<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoverImage extends Model {
    protected $table = 'rover_images';
    protected $primaryKey = 'nasa_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
