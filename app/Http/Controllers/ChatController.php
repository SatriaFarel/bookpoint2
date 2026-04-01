<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected function currentUser(): ?User
    {
        return Auth::guard('customer')->user() ?? Auth::user();
    }

    /*
    | Halaman utama chat
    */
    public function index()
    {
        $auth = $this->currentUser();

        abort_unless($auth, 401);

        $chats = User::where('id', '!=', $auth->id)->get();

        return view('admin.chat', [
            'chats' => $chats,
            'messages' => [],
            'partner' => null,
            'authId' => $auth->id,
        ]);
    }

    /* ===== HALAMAN CHAT ===== */
    public function show(User $user)
    {
        $auth = $this->currentUser();

        abort_unless($auth, 401);

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

        if (! $chats->contains('id', $user->id)) {
            $chats->prepend($user);
        }

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
            'chats' => $chats,
            'authId' => $auth->id,
        ]);
    }


    /* ===== KIRIM PESAN ===== */
    public function send(Request $request)
    {
        $auth = $this->currentUser();

        abort_unless($auth, 401);

        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required'
        ]);

        Message::create([
            'sender_id' => $auth->id,
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
        $auth = $this->currentUser();

        abort_unless($auth, 401);

        $partner = User::findOrFail($user);

        $messages = Message::where(function ($q) use ($user, $auth) {

            $q->where('sender_id', $auth->id)
                ->where('receiver_id', $user);
        })->orWhere(function ($q) use ($user, $auth) {

            $q->where('sender_id', $user)
                ->where('receiver_id', $auth->id);
        })
            ->orderBy('created_at')
            ->get();

        return view('partials.messages', [
            'messages' => $messages,
            'partner' => $partner,
            'authId' => $auth->id,
        ]);
    }
}
