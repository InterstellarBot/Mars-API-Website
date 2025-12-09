<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rover extends Model {
    protected $table = 'rovers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function cameras(): HasMany {
        return $this->hasMany(RoverCameras::class);
    }
}
