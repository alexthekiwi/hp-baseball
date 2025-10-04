<?php

namespace App\Widgets;

use Statamic\Widgets\Widget;

class OrderExportWidget extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        return view('widgets.order_export_widget');
    }
}
