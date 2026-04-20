<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\ChatThread;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatThreadController extends Controller
{
    public function index(): View
    {
        $threads = ChatThread::query()
            ->where('user_id', auth()->id())
            ->with(['material', 'user'])
            ->withCount('messages')
            ->latest()
            ->get();

        $materials = Material::query()->where('user_id', auth()->id())->latest()->get(['id', 'title']);

        return view('chat.index', compact('threads', 'materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'material_id' => ['nullable', 'exists:materials,id'],
            'opening_message' => ['nullable', 'string'],
        ]);

        $thread = ChatThread::create([
            'user_id' => $request->user()->id,
            'material_id' => $validated['material_id'] ?? null,
            'title' => $validated['title'],
        ]);

        if (! empty($validated['opening_message'])) {
            $thread->messages()->create([
                'role' => 'user',
                'content' => $validated['opening_message'],
            ]);

            $thread->messages()->create([
                'role' => 'assistant',
                'content' => 'Ini balasan dasar untuk fondasi awal. Nanti endpoint AI bisa menggantikan bagian ini.',
            ]);
        }

        return redirect()
            ->route('chat.show', $thread)
            ->with('status', 'Thread chat berhasil dibuat.');
    }

    public function show(ChatThread $chatThread): View
    {
        abort_unless($chatThread->user_id === auth()->id(), 403);
        $chatThread->load(['material', 'user', 'messages']);

        return view('chat.show', ['thread' => $chatThread]);
    }
}
