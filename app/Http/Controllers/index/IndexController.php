<?php

namespace App\Http\Controllers\index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class IndexController extends Controller
{
    //
    public function index(){
        $niuniu_dating = DB::table("app_config")->where(['game_house'=>"dating","game_type"=>"niuniu"])->first();
        $shuangwei_dating = DB::table("app_config")->where(['game_house'=>"dating","game_type"=>"shuangwei"])->first();
        $danshuang_dating = DB::table("app_config")->where(['game_house'=>"dating","game_type"=>"danshuang"])->first();
        $baijiale_zhuang = DB::table("app_config")->where(['game_house'=>"庄","game_type"=>"baijiale"])->first();
        $baijiale_xian = DB::table("app_config")->where(['game_house'=>"闲","game_type"=>"baijiale"])->first();
        $baijiale_he = DB::table("app_config")->where(['game_house'=>"和","game_type"=>"baijiale"])->first();
        
        // var_dump($niuniu_dating);
         return view('index.index', [
            'niuniu_dating'=>$niuniu_dating,
            'shuangwei_dating'=>$shuangwei_dating,
            'danshuang_dating'=>$danshuang_dating,
            'baijiale_zhuang'=>$baijiale_zhuang,
            'baijiale_xian'=>$baijiale_xian,
            'baijiale_he'=>$baijiale_he,
        ]);
    }
    
    public function index_en(){
        $niuniu_dating = DB::table("app_config")->where(['game_house'=>"dating","game_type"=>"niuniu"])->first();
        $shuangwei_dating = DB::table("app_config")->where(['game_house'=>"dating","game_type"=>"shuangwei"])->first();
        $danshuang_dating = DB::table("app_config")->where(['game_house'=>"dating","game_type"=>"danshuang"])->first();
        $baijiale_zhuang = DB::table("app_config")->where(['game_house'=>"庄","game_type"=>"baijiale"])->first();
        $baijiale_xian = DB::table("app_config")->where(['game_house'=>"闲","game_type"=>"baijiale"])->first();
        $baijiale_he = DB::table("app_config")->where(['game_house'=>"和","game_type"=>"baijiale"])->first();
        
        // var_dump($niuniu_dating);
         return view('index.index_en', [
            'niuniu_dating'=>$niuniu_dating,
            'shuangwei_dating'=>$shuangwei_dating,
            'danshuang_dating'=>$danshuang_dating,
            'baijiale_zhuang'=>$baijiale_zhuang,
            'baijiale_xian'=>$baijiale_xian,
            'baijiale_he'=>$baijiale_he,
        ]);
    }
}
