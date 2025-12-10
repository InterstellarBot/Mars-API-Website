<?php

use App\Http\Requests\GetRoverImagesRequest;
use App\Models\Rover;
use App\Models\RoverCameras;
use App\Models\RoverImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(function () {
    Route::get('/rovers', function (Request $request) {
        return Rover::with('cameras')->get();
    });
    Route::get('/rovers/{roverID}', function (Request $request, string $roverID) {
        return Rover::with('cameras')->find($roverID);
    });

    Route::get('/cameras', function (Request $request) {
        return RoverCameras::all();
    });
    Route::get('/cameras/{cameraID}', function (Request $request, string $cameraID) {
        return RoverCameras::find($cameraID);
    });

    Route::get('/images/{roverID}', function (GetRoverImagesRequest $request, string $roverID) {
        $validated = collect($request->validated());

        $data = RoverImage::with('camera')->where('rover_id', $roverID);
        if($validated->has('sol'))
            $data = $data->where('sol', $validated->get('sol'));
        if($validated->has('camera')) {
            $cameraID = $roverID . '-' . $validated->get('camera');
            $data = $data->where('camera_id', $cameraID);
        }

        // https://stackoverflow.com/a/51131009
        $result = $data->paginate($validated->get('per_page', 15));
        $data = $result;
        $result = $result->makeHidden('camera_id');
        $result = $result->makeHidden('camera_instrument_name');
        $data->data = $result;

        return $data;
    });
});
