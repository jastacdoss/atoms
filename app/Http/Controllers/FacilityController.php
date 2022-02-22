<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Traits\RestControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FacilityController extends Controller
{
    use RestControllerTrait;
    const MODEL = 'App\Models\Facility';
    protected $friendlyName = 'facility';

    public function __construct()
    {
//        $this->middleware(['auth:sanctum']);
    }

    /**
     * Retrieve all facilities
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /** Must run artisan atoms:calc to get values */
        return $this->successResponse(Cache::get('facilities'));
    }

    /**
     * Update the facility
     *
     * @param Request $request
     * @param Facility $facility
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Facility $facility)
    {
        try {
            // Update the model
            $facility->fill($request->all());
            $facility->save();

            // Locate the facility
            $facilities = Cache::pull('facilities');
            $idx = $facilities->search(fn ($f) => $f->id == $facility->id);

            // Save the facility into the cache
            $facility->whos_travelling();
            $facilities[$idx] = $facility;
            Cache::put('facilities', $facilities);

            return $this->successResponse($facility);
        } catch(\Exception $exception) {
            // Log the exception
            Log::debug('Error updating facility', [
                'model' => $facility,
                'exception' => $exception->getMessage(),
                'user_id' => auth()->user()->id,
                'request' => $request->all()
            ]);

            // Handle errors
            return $this->errorResponse( 'Unable to update the facility.\n\r');
        }
    }

    /**
     * Get all siblings for a facility
     *
     * @param Facility $facility
     * @return \Illuminate\Http\JsonResponse
     */
    public function siblings(Facility $facility)
    {
        return $this->successResponse($facility->load('siblings.sibling', 'pairs_fly_from'));
    }
}
