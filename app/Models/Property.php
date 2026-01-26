<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function units()
{
    return $this->hasMany(Unit::class);
}

}
