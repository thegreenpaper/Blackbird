<?php

namespace App\Livewire\AppComponents;

use App\Events\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class SendMessage extends Component
{
    public string $message;

    public string $channel;

    public function mount()
    {
        $this->channel = 'placeholder';
    }

    #[On('swap')]
    public function swapChannel($channel)
    {
        $this->channel = $channel;
    }

    public function sendMessage()
    {
        if($this->channel == 'global')
        {
            $from = Auth::get()->username;

            app('App\Http\Controllers\ChatController')->globalChat($this->message, $from);
        }
    }

    public function render()
    {
        return view('livewire.app-components.send-message');
    }
}
