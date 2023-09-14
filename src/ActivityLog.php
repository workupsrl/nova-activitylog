<?php

namespace Workup\Nova\ActivityLog;

use Laravel\Nova\Tool;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;

class ActivityLog extends Tool
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::resource(\Workup\Nova\ActivityLog\Resources\ActivityLog::class)
            ->icon('document-duplicate');
    }
}
