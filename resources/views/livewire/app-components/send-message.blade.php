<div class="sendMessage">
    {{-- Be like water. --}}
    <input type="text" wire:model="message" wire:keydown.enter="sendMessage">
    {{-- This is really slooooow, optimizing later, by swapping this to api based --}}
    <button  wire:click="sendMessage"><span class="material-symbols-outlined">send</span></button>
</div>
