<?php

namespace App\Http\Controllers;

use App\Models\AiSummary;
use App\Models\ChatMessage;
use App\Models\FlashcardDeck;
use App\Models\FeatureUsage;
use App\Models\Material;
use App\Models\QuizAttempt;
use App\Models\QuizSet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    public function index()
    {
        $featureUsages = FeatureUsage::orderBy('click_count', 'desc')->get();
        $totalUsers = User::count();
        $totalAiRequests = $this->getTotalAiRequestCount();

        $stats = [
            'total_users' => $totalUsers,
            'active_users' => User::where('is_active', true)->count(),
            'total_documents' => Material::count(),
            'total_ai_requests' => $totalAiRequests,
        ];

        return view('pages.admin.dashboard', compact('featureUsages', 'stats'));
    }

    public function monitoringAi()
    {
        $totalUsers = User::count();
        $trend = $this->buildAiRequestTrend();
        $totalAiRequests = $this->getTotalAiRequestCount();

        $aiStats = [
            'total_requests' => $totalAiRequests,
            'errors' => 0,
            'avg_response_time' => 'N/A',
            'usage_per_user' => $totalUsers > 0 ? round($totalAiRequests / $totalUsers, 1) : 0,
        ];

        return view('pages.admin.monitoring-ai', [
            'aiStats' => $aiStats,
            'aiTrend' => $trend,
        ]);
    }

    public function statistikPembelajaran()
    {
        $allAttempts = QuizAttempt::query()->get(['user_id', 'percentage', 'completed_at']);
        $latestScores = $allAttempts
            ->sortByDesc(fn (QuizAttempt $attempt) => $attempt->completed_at?->getTimestamp() ?? 0)
            ->unique('user_id')
            ->pluck('percentage')
            ->map(fn ($score) => (float) $score)
            ->values();

        $overallScore = (int) round($latestScores->avg() ?? 0);

        $learningStats = [
            'avg_quiz_score' => round((float) ($allAttempts->avg('percentage') ?? 0), 1),
            'most_used_feature' => FeatureUsage::orderBy('click_count', 'desc')->first()?->feature_name ?? 'N/A',
            'learning_activity' => $allAttempts->count(),
            'overall_score' => $overallScore,
            'overall_grade' => $this->formatGrade($overallScore),
        ];

        return view('pages.admin.statistik-pembelajaran', [
            'learningStats' => $learningStats,
            'scoreDistribution' => $this->buildScoreDistribution($latestScores),
        ]);
    }

    private function getTotalAiRequestCount(): int
    {
        return AiSummary::count()
            + QuizSet::count()
            + FlashcardDeck::count()
            + ChatMessage::where('role', 'assistant')->count();
    }

    private function buildAiRequestTrend(): array
    {
        $days = collect(range(6, 0))
            ->map(fn (int $offset) => Carbon::today()->subDays($offset));
        $labels = $days->map(fn (Carbon $day) => $day->translatedFormat('d M'))->all();
        $series = array_fill_keys($days->map(fn (Carbon $day) => $day->toDateString())->all(), 0);
        $startDate = Carbon::today()->subDays(6)->startOfDay();

        $sources = [
            AiSummary::query(),
            QuizSet::query(),
            FlashcardDeck::query(),
            ChatMessage::query()->where('role', 'assistant'),
        ];

        foreach ($sources as $source) {
            $source
                ->where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
                ->groupBy('day')
                ->pluck('total', 'day')
                ->each(function ($total, $day) use (&$series): void {
                    if (array_key_exists($day, $series)) {
                        $series[$day] += (int) $total;
                    }
                });
        }

        return [
            'labels' => $labels,
            'data' => array_values($series),
            'total_last_7_days' => array_sum($series),
        ];
    }

    private function buildScoreDistribution(Collection $scores): array
    {
        $bins = [
            '0-20' => 0,
            '21-40' => 0,
            '41-60' => 0,
            '61-80' => 0,
            '81-100' => 0,
        ];

        foreach ($scores as $score) {
            $value = max(0, min(100, (float) $score));

            if ($value <= 20) {
                $bins['0-20']++;
            } elseif ($value <= 40) {
                $bins['21-40']++;
            } elseif ($value <= 60) {
                $bins['41-60']++;
            } elseif ($value <= 80) {
                $bins['61-80']++;
            } else {
                $bins['81-100']++;
            }
        }

        return [
            'labels' => array_keys($bins),
            'data' => array_values($bins),
            'user_count' => $scores->count(),
        ];
    }

    private function formatGrade(int $score): string
    {
        return match (true) {
            $score >= 90 => 'A',
            $score >= 80 => 'A-',
            $score >= 70 => 'B',
            $score >= 60 => 'C',
            $score >= 50 => 'D',
            default => 'E',
        };
    }
}
