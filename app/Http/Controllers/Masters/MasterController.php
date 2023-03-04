<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class MasterController extends Controller
{
    /**
     * | Created On-04-03-2023 
     * | Created By-Anshu Kumar
     * | Get all master lists of Single Tables
     */

    public function levelLists()
    {
        try {
            $levels = Config::get('master-constants.LEVELS');
            return responseMsg(true, "Level Lists", remove_null($levels));
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }
}
