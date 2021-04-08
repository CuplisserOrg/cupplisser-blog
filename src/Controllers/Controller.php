<?php
namespace Cupplisser\Blog\Controllers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController{
    protected $viewPath;
    protected $routePrefix;
    public function __construct()
    {
        $this->viewPath = config("cblog.views_path");
        // if ($this->viewPath) {
        //     $this->viewPath .= ".";
        // }


        $this->routePrefix = config("cblog.route_prefix");
        if ($this->routePrefix && substr($this->routePrefix, -1) !== "/") {
            $this->routePrefix .= "/";
        }
    }
}
