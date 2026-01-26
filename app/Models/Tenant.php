<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    public function leases()
{
    return $this->hasMany(Lease::class);
}

}
