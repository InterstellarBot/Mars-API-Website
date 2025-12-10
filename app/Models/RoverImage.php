<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RoverImage extends Model {
    protected $table = 'rover_images';
    protected $primaryKey = 'nasa_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function camera(): HasOne {
        return $this->hasOne(RoverCameras::class, 'camera_id', 'camera_id');
    }
}
