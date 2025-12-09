<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoverCameras extends Model {
    protected $table = 'rover_cameras';
    protected $primaryKey = 'camera_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
