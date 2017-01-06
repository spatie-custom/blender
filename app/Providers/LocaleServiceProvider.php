<?php

namespace App\Providers;

use Jenssegers\Date\Date;
use App\Services\Locale\CurrentLocale;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $locale = CurrentLocale::determine();

        $this->app->setLocale(CurrentLocale::determine());

        Date::setLocale($locale);
    }
}
