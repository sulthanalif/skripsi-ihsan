<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {

        $documents = Document::query()
            ->with('documentType')
            ->latest()->get();

        $types = DocumentType::select('id', 'name')->get();

        return view('back-end.report.index', compact('documents', 'types'));
    }

    public function export(Request $request)
    {


        try {
            $year = $request->input('year') ?? null;
            $month = $request->input('month') ?? null;
            $type = $request->input('type');

            if($type == 'data') {
                $datas = Document::query()
                    ->with('documentType')
                    ->when($year, function ($query) use ($year) {
                        $query->whereYear('created_at', $year);
                    })
                    ->when($month, function ($query) use ($month) {
                        $query->whereMonth('created_at', $month);
                    })
                    ->get();

                $filename = 'Laporan-Dokumen';
                if ($month && $year) {
                    $filename .= '-' . $month . '-' . $year;
                } elseif ($year) {
                    $filename .= '-' . $year;
                }
                return Pdf::loadView('back-end.report.pdf-data', compact('datas'))->stream($filename . '.pdf');
            } else {
                if ($year && $month) {
                    $datas = Document::query()
                    ->select('document_type_id')
                    ->selectRaw('COUNT(*) as total')
                    ->when($year, function ($query) use ($year) {
                        $query->whereYear('created_at', $year);
                    })
                    ->whereHas('approval', function ($query) {
                        $query->where('status', 'approved');
                    })
                    ->when($month, function ($query) use ($month) {
                        $query->whereMonth('created_at', $month);
                    })
                    ->groupBy('document_type_id')
                    ->with('documentType')
                    ->get();

                    // Menyiapkan variabel tambahan untuk view
                    $monthName = Carbon::create()->month((int)$month)->locale('id')->monthName;

                    $pdfData = [
                        'datas' => $datas,
                        'monthName' => $monthName,
                        'year' => $year,
                    ];

                    // Ganti 'compact('datas')' menjadi 'compact('pdfData')' atau kirim array langsung
                    return Pdf::loadView('back-end.report.pdf-total-month', $pdfData)
                            ->download('Laporan Bulanan-' . $monthName . '-' . $year . '.pdf');
                } else {
                    // Query 1: Data untuk rekapitulasi bulanan
                    $monthlyData = Document::query()
                        ->select(
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('COUNT(*) as total')
                        )
                        ->whereYear('created_at', $year)
                        ->whereHas('approval', function ($query) {
                            $query->where('status', 'approved');
                        })
                        ->groupBy('month')
                        ->orderBy('month', 'asc')
                        ->get();

                    // Query 2: Data untuk rekapitulasi per jenis surat
                    $byTypeData = Document::query()
                        ->select('document_type_id', DB::raw('COUNT(*) as total'))
                        ->whereYear('created_at', $year)
                        ->whereHas('approval', function ($query) {
                            $query->where('status', 'approved');
                        })
                        ->groupBy('document_type_id')
                        ->with('documentType')
                        ->get();

                    // Data yang akan dikirim ke view
                    $pdfData = [
                        'year' => $year,
                        'monthlyData' => $monthlyData,
                        'byTypeData' => $byTypeData,
                    ];

                    return Pdf::loadView('back-end.report.pdf-total-year', $pdfData)
                            ->download('laporan-tahunan-' . $year . '.pdf');
                }
            }

        } catch (\Throwable $th) {
            // Catat error ke dalam file log Laravel
            \Log::error('Gagal export PDF: ' . $th->getMessage());
        }
    }
}
