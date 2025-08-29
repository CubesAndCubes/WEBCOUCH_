@extends('app')

@section('name', 'couch-select')

@section('content')
    <div class="pane-area">
        <div class="pane-stack">
            <div id="select-couch-title">
                <h1 id="select-couch-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="Select Couch Media"
                    ></span><span class="blink">_</span>
                </h1>
            </div>
        </div>
        
        <div class="pane-stack">
            <a class="pane-button" href="{{ route('couch', ['room_uuid' => $room->uuid]) }}">
                abort
            </a>
        </div>

        <form
            id="media-select"
            action="{{ route('couch.select', ['room_uuid' => $room->uuid]) }}"
            method="POST"
        >
            @csrf

            <input
                type="hidden"
                id="media"
                name="media_uuid"
                required
            >
        </form>

        <div class="pane-grid" id="media-grid">
            @foreach ($user_files as $file)
                <x-media-pane :file="$file" selectable />
            @endforeach
        </div>
    </div>
@endsection