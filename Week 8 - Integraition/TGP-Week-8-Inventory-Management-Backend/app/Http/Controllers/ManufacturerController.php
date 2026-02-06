<?php

namespace App\Http\Controllers;
use App\Models\Manufacturer;

use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index() {
    // return the manufacturers.
    return response()->json(Manufacturer::select('id','name')->get());
}
}
