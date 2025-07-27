<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApprovalController extends Controller
{
    // ... (method index, approve, reject tidak perlu diubah) ...
    public function index(Document $document)
    {
        return view('back-end.document.approval.index', compact('document'));
    }

    public function approve(Document $document, Request $request)
    {
        $document->approval()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'approved', 'note' => $request->input('note')]
        );
        return redirect()->back()->with('success', 'Document has been approved.');
    }

    public function reject(Document $document, Request $request)
    {
        $document->approval()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'rejected', 'note' => $request->input('note')]
        );
        return redirect()->back()->with('error', 'Document has been rejected.');
    }

    public function generate(Document $document)
    {
        $document->approval()->update(
            ['generated_at' => now()],
        );

        return redirect()->back()->with('success', 'Document has been generated.');
    }

    public function sign(Document $document, Request $request)
    {
        $approval = $document->approval()->first();

        if (!$approval) {
            return redirect()->back()->with('error', 'You have not approved this document yet.');
        }

        // ... (logika pembuatan $sign, $sign_at, dll. tetap sama) ...
        $date = now()->format('dmyHis');
        $random = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
        $sign = "SIGN{$date}{$random}";
        $sign_at = now();
        $sign_by = Auth::user();

        $array_in_qr_code = "Code: " . $sign . "\n" .
            "Document Type: " . $document->documentType->name . "\n" .
            "Document User Name: " . $document->user->name . "\n" .
            "Document Number: " . $document->number . "\n" .
            "Signed At: " . $sign_at->toDateTimeString() . "\n" .
            "Signed By: " . $sign_by->name;

        $approval->update([
            'sign' => $sign,
            'sign_at' => $sign_at,
            'sign_by' => $sign_by->id,
        ]);

        // PERUBAHAN V3: Cara membuat gambar
        // 1. Buat instance ImageManager dengan driver yang dipilih (misal: GD)
        $manager = new ImageManager(new Driver());

        // 2. Buat gambar QR Code
        $qrCodeData = (new DNS2D())->getBarcodePNG($array_in_qr_code, 'QRCODE,H', 3, 3);
        $img = $manager->read($qrCodeData);

        // 3. Baca logo dan sisipkan
        $logo = $manager->read(public_path('assets/img/logo.png'))->resize(50, 60);
        $img->place($logo, 'center');

        // 4. Simpan gambar ke storage
        $directory = 'sign';
        $path = $directory . '/' . $sign . '.png';
        Storage::disk('public')->put($path, $img->toPng()); // Gunakan method encoding dari Intervention

        return redirect()->back()->with('success', 'Document has been signed.');
    }
}
