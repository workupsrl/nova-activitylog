<?php

namespace Workup\Nova\Activitylog;

use Bolechen\NovaActivitylog\Resources\Activitylog;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Tool;

class Activitylog extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot()
    {
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::resource(Activitylog::class)
            ->icon('document-duplicate');
    }
}
