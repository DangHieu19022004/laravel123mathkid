<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class UtilsServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Blade::directive('icon', static function ($arguments) {
            // Funky madness to accept multiple arguments into the directive
            [$path, $class] = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path  = str_replace('.', '/', trim($path, "' "));
            $class = trim($class, "' ");

            if (Str::startsWith($path, '$')) {
                return <<<EOT
                    {!! get_svg($path, '$class') !!}
                EOT;
            }

            return get_svg($path, $class);
        });
    }
}
