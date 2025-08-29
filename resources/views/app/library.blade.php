@extends('app')

@section('name', 'library')

@section('content')
    <div class="pane-area">
        <div class="pane-stack">
            <div id="library-title">
                <h1 id="library-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="Media Library"
                    ></span><span class="blink">_</span>
                </h1>
            </div>
        </div>
        
        <div class="pane-stack">
            <a class="pane-button" href="{{ route('dashboard') }}">
                cd home
            </a>

            <button class="pane-button" id="media-upload-button">
                media upload
            </button>
        </div>

        <form
            id="media-upload"
            action="{{ route('media-upload') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <input
                type="file"
                id="media"
                name="media[]"
                accept="video/mp4, video/webm"
                multiple
                required
            >
        </form>

        <div class="pane-grid" id="media-grid">
            @foreach ($user_files as $file)
                <x-media-pane :file="$file" />
            @endforeach
        </div>
    </div>
@endsection