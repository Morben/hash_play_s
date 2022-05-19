<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function setLang(Request $request)
    {
        $lang = $request->get('lang');
        $request->session()->put('lang', $lang);
        
        return response()->json(['code' => 0], 200);
    }
}
