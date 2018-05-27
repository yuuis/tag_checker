<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemcachedController extends Controller
{
    public function index(Request $request)
    {
    	\Log::info(__METHOD__);
    	
        $logic = new \App\Http\Logic\Test\MemcachedLogic;
        $logic->validate($request);
        $resultsDTO = $logic->execute($request);
        
        return view("test/memcached", $resultsDTO->getForView($request));
    }
   
}