<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * | Created On-04-03-2023 
     * | Created By-Anshu Kumar
     * | Created for Category Crud Operations
     */

    public function __construct()
    {
    }

    /**
     * | Post New Category
     */
    public function postCategory(Request $req)
    {
        return dd($req->all());
    }
}
