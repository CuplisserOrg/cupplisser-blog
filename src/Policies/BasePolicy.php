<?php namespace Cupplisser\Blog\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
class BasePolicy{

    use HandlesAuthorization;
    
    public function __construct(){}
}