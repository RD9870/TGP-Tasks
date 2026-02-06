<?php

namespace App\Http\Controllers;
use App\Models\ImportCompany;

use Illuminate\Http\Request;

class ImportCompanyController extends Controller
{
// show the import companies.
    public function index() {
    return response()->json(ImportCompany::select('id','name')->get());
}
}
