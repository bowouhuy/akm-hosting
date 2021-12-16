<?php

namespace App\Models;

use App\Models\Contracts\BaseModelContract;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel
    extends Model
    implements BaseModelContract
{
    /**
     * handle pre & post action
     */
    protected static function boot()
    {
        parent::boot();
    }
}
