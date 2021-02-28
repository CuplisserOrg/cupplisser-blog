<?php
use Illuminate\Support\Carbon;

function carbon(string $parseString = '', string $tz = null): Carbon
{
    return new Carbon($parseString, $tz);
}

function humanize_date(Carbon $date, string $format = 'd F Y, H:i'): string
{
    return $date->format($format);
}

function getBlogSiteID()
{
    $siteClass = config("cupplisser-blog.site_model");
    $siteClassInstance = $siteClass
        ? new $siteClass()
        : null;

    return $siteClassInstance ? $siteClassInstance::getSiteId() : null;
}

function blogUrl($url, $frontend = false)
{
    if ($frontend === true)
    {
        $routePrefix = config("blog.frontend_route_prefix", "");
    }
    else
    {
        $routePrefix = config("blog.route_prefix", "");
    }

    if ($routePrefix && substr($routePrefix, -1) !== "/") {
        $routePrefix .= "/";
    }

    return url($routePrefix.$url);
}
