<?php

namespace Workup\Nova\ActivityLog\Resources;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Resource as NovaResource;
use Laravel\Nova\Http\Requests\NovaRequest;

class ActivityLog extends NovaResource
{
    public static $model;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'properties',
    ];

    public static $globallySearchable = false;

    /**
     * Hide resource from Nova's standard menu.
     *
     * @var bool
     */
    public static $displayInNavigation = true;

    public static function group()
    {
        return __('Activity Logs');
    }

    /**
     * Label for display.
     *
     * @return string
     */
    public static function label()
    {
        return __('Activity Logs');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Activity Log');
    }

    /**
     * Get a fresh instance of the model represented by the resource.
     *
     * @return mixed
     */
    public static function newModel()
    {
        self::$model = \Spatie\ActivityLog\ActivityLogServiceProvider::determineActivityModel();

        return new self::$model();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Description'), 'description'),
            Text::make(__('Subject Id'), 'subject_id'),
            Text::make(__('Subject Type'), 'subject_type'),
            MorphTo::make(__('Causer'), 'causer'),
            Text::make(__('Causer Ip'), 'properties->ip')->onlyOnIndex(),

            Code::make(__('Properties'), 'properties')->json(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            DateTime::make(__('Created At'), 'created_at'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
