<?php

namespace App\View\Components;

use Closure;
use App\Models\Room;
use App\Models\UserFile;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MediaPane extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public UserFile $file,
        public bool $selectable = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media-pane');
    }
}
