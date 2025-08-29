@extends('app')

@section('name', 'view-couch')

@section('content')
    <meta
        id="room-meta"
        data-uuid="{{ $room->uuid }}"
        data-username="{{ $user->name }}"

        @if (!empty($seek))
            data-seek="{{ $seek }}"
        @endif
    >

    <div class="pane-area">
        <div class="pane-stack">
            <div id="new-couch-title">
                <h1 id="new-couch-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="{{ $room->name }}"
                    ></span><span class="blink">_</span>
                </h1>
            </div>
        </div>

        <div class="pane-stack">
            @if ($room->user_id == $user->id)
                <a class="pane-button" href="{{ route('couches') }}">
                    cd my_couches
                </a>

                <a class="pane-button" href="{{ route('couch.select', ['room_uuid' => $room->uuid]) }}">
                    couch select_media
                </a>

                <button class="pane-button" type="submit" form="couch-regenerate">
                    couch regenerate_url
                </button>

                <form
                    id="couch-regenerate"
                    method="POST"
                    action="{{ route('couch.regenerate', ['room_uuid' => $room->uuid]) }}"
                >
                    @csrf
                </form>
            @else
                <a class="pane-button" href="{{ route('dashboard') }}">
                    cd home
                </a>
            @endif
        </div>

        <div id="couch-container">
            <video
                id="couch-media"
                controls
                muted
                
                @if (!empty($room->play_timestamp))
                    autoplay
                @endif

                @if ($user_file)
                    src="{{ route('media', ['file_uuid' => $user_file->uuid]) }}"
                @endif
            ></video>

            <div id="couch-chat" class="pane">
                <div id="couch-chat-log">

                </div>

                <div id="couch-chat-bar">
                    <input
                        id="couch-chat-input"
                        class="data-input"
                        type="text"
                    >

                    <button id="couch-chat-submit" class="data-button">
                        submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    
@endsection