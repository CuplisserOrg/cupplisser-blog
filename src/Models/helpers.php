<?php

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