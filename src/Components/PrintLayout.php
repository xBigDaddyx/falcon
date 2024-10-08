<?php

namespace Xbigdaddyx\Falcon\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PrintLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('falcon::layouts.print');
    }
}
