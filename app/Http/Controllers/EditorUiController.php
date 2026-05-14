<?php

namespace App\Http\Controllers;

use App\Models\Receipt;

class EditorUiController extends Controller
{
    public function pos()
    {
        return view('editor.pos.index');
    }

    public function receipts()
    {
        $receipts = Receipt::with('order')->latest('date_created')->paginate(20);

        return view('editor.receipts.index', compact('receipts'));
    }

    public function reports()
    {
        return view('editor.reports.index');
    }

    public function settings()
    {
        return view('editor.settings.index');
    }
}
