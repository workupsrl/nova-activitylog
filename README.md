# Nova tool for activity log

[![StyleCI](https://github.styleci.io/repos/174304298/shield?branch=master)](https://github.styleci.io/repos/174304298)
[![Packagist Downloads](https://img.shields.io/packagist/dt/bolechen/nova-activitylog)](https://packagist.org/packages/bolechen/nova-activitylog)
[![Packagist Version](https://img.shields.io/packagist/v/bolechen/nova-activitylog)](https://packagist.org/packages/bolechen/nova-activitylog)
![GitHub](https://img.shields.io/github/license/bolechen/nova-activitylog)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fbolechen%2Fnova-activitylog.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Fbolechen%2Fnova-activitylog?ref=badge_shield)

A tool to activity logger to monitor the users of your Laravel Nova.

- Behind the scenes [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog) is used.

![screenshot](https://raw.githubusercontent.com/bolechen/nova-activitylog/master/docs/screenshot.png?20190308)


## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require workup/nova-activitylog
```

You can publish the migration with:

```bash
php artisan vendor:publish --provider="Spatie\ActivityLog\ActivityLogServiceProvider" --tag="activitylog-migrations"
```

*Note*: The default migration assumes you are using integers for your model IDs. If you are using UUIDs, or some other format, adjust the format of the subject_id and causer_id fields in the published migration before continuing.


After publishing the migration you can create the `activity_log` table by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Spatie\ActivityLog\ActivityLogServiceProvider" --tag="config"
```

You may only want to log actions from nova, put this line to your `.env` files let default logger off.

```env
ACTIVITY_LOGGER_ENABLED=false
```

## How to use

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvder.php

// ...

public function tools()
{
    return [
        // ...
        new \Workup\Nova\ActivityLog\ActivityLog(),
    ];
}
```

Because the backend uses the `spatie/laravel-activitylog` package, you need to let your model use the `Spatie\ActivityLog\Traits\LogsActivity` trait.

Here's an example:

```php
use Illuminate\Database\Eloquent\Model;
use Spatie\ActivityLog\Traits\LogsActivity;

class NewsItem extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'text'];
    
    protected static $logAttributes = ['name', 'text'];
}
```

For more advanced usage can look at the doc: https://docs.spatie.be/laravel-activitylog/v3/advanced-usage/logging-model-events

## Authorizing

Typical usage of tool authorizing using `->canSee()` or `->canSeeWhen()` when registering the tool will NOT work. To authorize the tool, simply [make and register a Laravel policy](https://laravel.com/docs/10.x/authorization#creating-policies) for the `ActivityLog` model. If a user is not able to view them according to the policy, the tool will not show.


## Customize

If you want to customize the tools. Eg: add filters or cards, you can create your owner resource file extends the original like this:

```php
use Workup\Nova\ActivityLog\Resources\ActivityLog;

class Activity extends ActivityLog
{
    public function filters(Request $request)
    {
        return [
            // Your customize filters, etc...
            new Filters\LogsType(),
        ];
    }
}
```

Next up, publish the config file with:

```bash
php artisan vendor:publish --provider="Workup\\Nova\\ActivityLog\\ToolServiceProvider" --tag="config"
```

And change the `resource` in `config/nova-activitylog.php` to your custom nova resource.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.


[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fbolechen%2Fnova-activitylog.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fbolechen%2Fnova-activitylog?ref=badge_large)
