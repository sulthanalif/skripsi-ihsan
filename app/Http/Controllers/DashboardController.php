<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $loggedInUserId = Auth::id();

        $approvalDocuments = Document::whereHas('approval', function ($query) use ($loggedInUserId) {
            $query->where('user_id', $loggedInUserId)
                  ->where('status', 'pending');
        })
        ->whereDoesntHave('approval', function($query) {
            $query->where('status', 'rejected');
        })
        ->with(['documentType', 'user', 'approval' => function ($query) {
            $query->orderBy('order');
        }])
        ->orderBy('created_at', 'desc');


        $userDocuments = Document::with('approval', 'documentType', 'user', 'creator')->where('user_id', Auth::user()->id)->limit(5)->get();


        $stats = [
            ['title' => 'Menunggu Approval', 'value' => $approvalDocuments->get()->count(), 'icon' => 'fa-clock text-white', 'color' => 'bg-warning'],
            ['title' => 'Semua Dokumen', 'value' => Document::count(), 'icon' => 'fa-file', 'color' => 'bg-primary'],
            ['title' => 'Dokumen Saya', 'value' => Document::where('user_id', Auth::user()->id)->count(), 'icon' => 'fa-user', 'color' => 'bg-info'],
            ['title' => 'Type Dokumen', 'value' => DocumentType::count(), 'icon' => 'fa-folder', 'color' => 'bg-success'],
        ];

        if (auth()->user()->roles?->first()->name == 'warga') {
            $stats[0]['hidden'] = 'hidden';
            $stats[1]['hidden'] = 'hidden';
        }


        $approvalDocuments = $approvalDocuments->limit(5)->get();
        // return response()->json($stats);

        return view('back-end.dashboard', compact('approvalDocuments', 'stats', 'userDocuments'));

    }
}
