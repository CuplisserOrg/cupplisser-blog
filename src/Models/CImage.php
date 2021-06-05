<?php namespace Cupplisser\Blog\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CImage extends Model{

    protected $guard = [];
    public function imageable()
    {
        return $this->morphTo();
    }
}
