<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Traits\RestControllerTrait;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    use RestControllerTrait;
    const MODEL = 'App\Models\Facility';
    protected $friendlyName = 'facility';

    public function __construct()
    {
//        $this->middleware(['auth:sanctum']);
    }

    public function index()
    {
        $facilities = Facility::where('release', 1)->get();
        $facilities->each(fn ($f) =>
            $f->whos_travelling()
        );
        return $this->successResponse($facilities);
    }
}
