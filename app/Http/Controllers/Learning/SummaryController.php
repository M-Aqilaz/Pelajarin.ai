<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\AiSummary;
use Illuminate\View\View;

class SummaryController extends Controller
{
    public function index(): View
    {
        $summaries = AiSummary::query()
            ->with(['material', 'user'])
            ->latest()
            ->get();

        return view('summaries.index', compact('summaries'));
    }

    public function show(AiSummary $summary): View
    {
        $summary->load(['material', 'user']);

        return view('summaries.show', compact('summary'));
    }
}
