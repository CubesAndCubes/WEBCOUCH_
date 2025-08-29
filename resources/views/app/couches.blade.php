@extends('app')

@section('name', 'couches')

@section('content')
    <div class="pane-area">
        <div class="pane-stack">
            <div id="couches-title">
                <h1 id="couches-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="My Couches"
                    ></span><span class="blink">_</span>
                </h1>
            </div>
        </div>

        <div class="pane-stack">
            <a class="pane-button" href="{{ route('dashboard') }}">
                cd home
            </a>

            <a class="pane-button" href="{{ route('couches.new') }}">
                couch new --dialog
            </a>
        </div>

        <div class="pane-grid" id="couch-grid">
            @foreach ($rooms as $room)
                <x-couch-pane :room="$room" />
            @endforeach
        </div>
    </div>
@endsection