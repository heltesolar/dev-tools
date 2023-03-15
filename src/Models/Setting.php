<?php

namespace Helte\DevTools\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'val'];
}
