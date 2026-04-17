<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\AiSummary;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::query()
            ->withCount(['summaries', 'chatThreads'])
            ->latest()
            ->get();

        return view('materials.index', compact('materials'));
    }

    public function create(): View
    {
        return view('materials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'material_file' => ['nullable', 'file', 'max:51200'],
            'raw_text' => ['nullable', 'string'],
        ]);

        $user = $this->resolveUser();
        $file = $request->file('material_file');
        $storedPath = $file?->store('materials');
        $rawText = trim((string) ($validated['raw_text'] ?? ''));

        $material = Material::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'original_filename' => $file?->getClientOriginalName(),
            'file_path' => $storedPath,
            'mime_type' => $file?->getMimeType(),
            'file_size' => $file?->getSize(),
            'raw_text' => $rawText !== '' ? $rawText : null,
            'status' => ($storedPath || $rawText !== '') ? 'processed' : 'uploaded',
        ]);

        if ($rawText !== '') {
            AiSummary::create([
                'material_id' => $material->id,
                'user_id' => $user->id,
                'title' => 'Ringkasan ' . $material->title,
                'summary_text' => $this->buildSummary($rawText),
                'model' => 'local-placeholder',
            ]);
        }

        return redirect()
            ->route('materials.show', $material)
            ->with('status', 'Materi berhasil dibuat.');
    }

    public function show(Material $material): View
    {
        $material->load(['user', 'summaries', 'chatThreads.messages']);

        return view('materials.show', compact('material'));
    }

    private function resolveUser(): User
    {
        return auth()->user()
            ?? User::query()->firstOrCreate(
                ['email' => 'test@example.com'],
                ['name' => 'Test User', 'password' => 'password', 'role' => 'user']
            );
    }

    private function buildSummary(string $text): string
    {
        $normalized = preg_replace('/\s+/', ' ', trim($text)) ?? $text;
        $excerpt = Str::limit($normalized, 500, '...');

        return "Ringkasan awal dari materi ini:\n\n" . $excerpt;
    }
}
