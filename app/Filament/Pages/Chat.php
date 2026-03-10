<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use App\Models\User;
use App\Models\Message;

class Chat extends Page
{
    protected string $view = 'filament.pages.chat';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $slug = 'chat';

    protected static ?int $navigationSort = 5;


    public $chats = [];
    public $messages = [];
    public $partner = null;

    public $messageText = '';

    public function mount()
    {
        $this->chats = User::where('role','customer')->get();
    }

    public function loadChat($userId)
    {
        $this->partner = User::findOrFail($userId);

        $this->refreshMessages();
    }

    public function refreshMessages()
    {
        if (!$this->partner) return;

        $user = auth()->user();

        $this->messages = Message::where(function ($q) use ($user) {

            $q->where('sender_id',$user->id)
              ->where('receiver_id',$this->partner->id);

        })
        ->orWhere(function ($q) use ($user) {

            $q->where('sender_id',$this->partner->id)
              ->where('receiver_id',$user->id);

        })
        ->orderBy('created_at')
        ->get();
    }

    public function sendMessage()
    {
        if (!$this->partner || !$this->messageText) return;

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->partner->id,
            'message' => $this->messageText
        ]);

        $this->messageText = '';

        $this->refreshMessages();
    }
}