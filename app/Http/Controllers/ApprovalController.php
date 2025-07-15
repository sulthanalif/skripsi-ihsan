<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApprovalController extends Controller
{
    public function index(Document $document)
    {
        return view('back-end.document.approval.index', compact('document'));
    }

    public function approve(Document $document, Request $request)
    {
        $document->approval()->create([
            'user_id' => Auth::id(),
            'status' => 'approved',
            'note' => $request->input('note'),
        ]);

        return redirect()->back()->with('success', 'Document has been approved.');
    }

    public function reject(Document $document, Request $request)
    {
        $document->approval()->updateOrCreate([
            'user_id' => Auth::id(),
            'status' => 'rejected',
            'note' => $request->input('note'),
        ]);

        return redirect()->back()->with('error', 'Document has been rejected.');
    }

    public function sign(Document $document, Request $request)
    {
            // Generate random qr_code
            $date = now()->format('dmyHis');
            $random = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
            $sign = "SIGN{$date}{$random}";
            $sign_at = now();
            $sign_by = Auth::user();
            $array_in_qr_code = "Code: " . $sign . "\n" .
                "Document Type: " . $document->documentType->name . "\n" .
                "Document User Name: " . $document->user->name . "\n" .
                "Document Number: " . $document->number . "\n" .
                "Signed At: " . $sign_at . "\n" .
                "Signed By: " . $sign_by->name;
            $document->approval->sign = $sign;
            $document->approval->sign_at = $sign_at;
            $document->approval->sign_by = $sign_by->id;
            $document->approval->save();

            // Generate QR code image
            $qrCode = (new DNS2D())->getBarcodePNG($array_in_qr_code, 'QRCODE', 5, 5);

            // Ensure directory exists
            $directory = 'sign';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Save QR code image
            $path = $directory . '/' . $sign . '.png';
            Storage::disk('public')->put($path, base64_decode($qrCode));

            return redirect()->back()->with('success', 'Document has been signed.');
    }
}
