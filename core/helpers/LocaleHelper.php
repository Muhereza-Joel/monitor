<?php

namespace core\helpers;

use core\Registry;

class LocaleHelper
{
    
    public static function cleanLocaleFromRoute($route)
    {
         $locales = Registry::get('locales');
         set_locale('en');
        // Match any segment that contains a locale between slashes or at the end
        $localePattern = '#/(?:' . implode('|', $locales) . ')(/|$)#';

        // Replace the locale segment and return the cleaned route
        return preg_replace($localePattern, '/', $route);
    }
}
