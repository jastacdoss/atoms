<?php

namespace App\Http\Controllers;

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


}
