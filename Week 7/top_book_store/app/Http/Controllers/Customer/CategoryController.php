<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    //return the categories in the database
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }
}
