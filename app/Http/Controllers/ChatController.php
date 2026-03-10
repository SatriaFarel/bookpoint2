<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    /*
    | Halaman utama chat
    */
    public function index()
    {
        $chats = User::where('id', '!=', auth()->id())->get();

        return view('admin.chat', [
            'chats' => $chats,
            'messages' => [],
            'partner' => null
        ]);
    }

    /* ===== HALAMAN CHAT ===== */
    public function show(User $user)
    {
        $auth = auth()->user();

        /* daftar chat partner */
        $chats = Message::where('sender_id', $auth->id)
            ->orWhere('receiver_id', $auth->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->map(function ($msg) use ($auth) {

                return $msg->sender_id == $auth->id
                    ? $msg->receiver
                    : $msg->sender;
            })
            ->unique('id')
            ->values();

        /* ambil percakapan */
        $messages = Message::where(function ($q) use ($auth, $user) {

            $q->where('sender_id', $auth->id)
                ->where('receiver_id', $user->id);
        })
            ->orWhere(function ($q) use ($auth, $user) {

                $q->where('sender_id', $user->id)
                    ->where('receiver_id', $auth->id);
            })
            ->orderBy('created_at')
            ->get();

        return view('chat.index', [
            'partner' => $user,
            'messages' => $messages,
            'chats' => $chats
        ]);
    }


    /* ===== KIRIM PESAN ===== */
    public function send(Request $request)
    {

        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return back();
    }

    /*
    | Ambil messages tanpa reload
    */
    public function messages($user)
    {

        $partner = User::findOrFail($user);

        $messages = Message::where(function ($q) use ($user) {

            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $user);
        })->orWhere(function ($q) use ($user) {

            $q->where('sender_id', $user)
                ->where('receiver_id', auth()->id());
        })
            ->orderBy('created_at')
            ->get();

        return view('partials.messages', compact('messages', 'partner'));
    }
}
