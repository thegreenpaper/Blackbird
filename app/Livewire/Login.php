<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function save() {
        $this->form->login();
    }

    public function switchForm()
    {
        dispatch('switchForm');
    }

    public function render()
    {
        return <<<'HTML'
        <form wire:submit="save">
        @csrf
            {{-- If your happiness depends on money, you will never be happy with yourself. --}}
            <input wire:model.live="form.email" type="email" name="email">
            @error('form.email') {{ $message }}@enderror
            <input wire:model.live="form.password" type="password" name="password"
            @error('form.password') {{ $message }}@enderror
            <p wire:click="switchForm">Alredy have an acoount? click here</p>
            <button type="submit">Login</button>
        </form>
        HTML;
    }
}