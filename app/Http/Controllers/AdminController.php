<?php

namespace App\Http\Controllers;

use App\Models\FeatureUsage;
use App\Models\StudyMatch;
use App\Models\StudyRoom;
use App\Models\User;
use App\Models\UserReport;

class AdminController extends Controller
{
    public function index()
    {
        $featureUsages = FeatureUsage::orderBy('click_count', 'desc')->get();
        $stats = [
            'userCount' => User::count(),
            'roomCount' => StudyRoom::count(),
            'matchCount' => StudyMatch::where('status', 'active')->count(),
            'reportCount' => UserReport::where('status', 'open')->count(),
        ];
        $recentRooms = StudyRoom::with('owner')->withCount('members')->latest()->take(5)->get();
        $recentReports = UserReport::with(['reporter', 'reportedUser'])->latest()->take(5)->get();

        return view('Admin.adminDashboard', compact('featureUsages', 'stats', 'recentRooms', 'recentReports'));
    }
}
