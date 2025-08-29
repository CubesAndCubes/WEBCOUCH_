@if ($selectable)
    <button class="pane-button media-select-button" data-uuid="{{ $file->uuid }}">
        {{ $file->name }}
    </button>
@else
    <a class="pane" href="{{ route('media', ['file_uuid' => $file->uuid]) }}" target="_blank">
        {{ $file->name }}
    </a>
@endif