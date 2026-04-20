<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\ChatThread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function store(Request $request, ChatThread $chatThread): RedirectResponse
    {
        abort_unless($chatThread->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:4000'],
        ]);

        $chatThread->messages()->create([
            'role' => 'user',
            'content' => $validated['content'],
        ]);

        $chatThread->messages()->create([
            'role' => 'assistant',
            'content' => 'Balasan placeholder: integrasi AI belum dipanggil di thread ini, tetapi struktur database dan alurnya sudah siap.',
        ]);

        return redirect()
            ->route('chat.show', $chatThread)
            ->with('status', 'Pesan ditambahkan ke thread.');
    }
}
