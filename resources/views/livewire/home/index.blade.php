<div>
    @php
    $user = Auth::user();
    var_dump($user->session_id);
    var_dump(session()->getId());
    @endphp
    <p>Ini adalah halaman home</p>
    <button class="btn btn-primary btn-page-block waves-effect waves-light">
        Default
    </button>
    <button wire:click="testEvent" class="btn btn-primary btn-page-block-spinner waves-effect waves-light">
        Test Event
    </button>
    <input type="text" wire:model="todo" placeholder="Todo...">

    <button wire:click="add">Add Todo</button>

    <ul>
        @foreach ($todos as $todo)
        <li>{{ $todo }}</li>
        @endforeach
    </ul>
</div>