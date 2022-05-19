<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any('pushmsg/{bot_token}', 'api\ApiController@pushmsg'); //接收消息推送 
Route::any('test', 'api\ApiController@test'); //接收消息推送 
Route::any('get/config', 'api\ApiController@get_config'); //接收消息推送  1分钟一次

Route::any('get/romaddress', 'api\ApiController@get_romaddress'); //生成靓号 开启后服务器会满负载 或者降低效率去掉do while结构

Route::get('Synchronous/transfer/data', 'api\CrontabController@Synchronous_transfer_data'); //同步区块转账数据 12秒一次 根据情况酌情使用

Route::get('Draw_prize', 'api\CrontabController@Draw_prize'); //订单开奖  10秒一次 必须5秒以上

Route::get('transfer/accounts', 'api\CrontabController@transfer_accounts'); //订单返奖 10秒一次

Route::get('Winning/notice', 'api\ApiController@Winning_notice'); //中奖通知 1秒一次





