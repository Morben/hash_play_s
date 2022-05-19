<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    
    $router->post('setLang', 'NavController@setLang');
    
    $router->resource('tgBot', 'TgBotController'); // 机器人列表
    $router->resource('tgBot_msg_record', 'TgMsgRecordController'); //消息记录
    $router->resource('tg_keyword', 'TgKeywordController'); //回复设置
    $router->resource('tg_group', 'TgGroupController'); //群列表
    $router->resource('tg_btn', 'TgBtnController'); //按钮列表
    $router->resource('tg_crontab', 'TgCrontabController'); //定时任务
    
    $router->resource('app_config', 'AppConfigController'); //游戏配置
    
    $router->resource('app_fenhon', 'AppConfigFenhongController'); //分红配置
    
    $router->resource('app_fenflow', 'AppFenFlowController'); //分红记录
    
    $router->resource('app_node', 'AppNodeController'); //
    
    $router->resource('app_order', 'AppOrderController'); //订单记录
    
    $router->resource('app_order_send', 'AppOrderWaitSendController'); //转账记录
    
    $router->resource('app_user', 'AppUserController'); //用户列表
    
    $router->resource('app_user_group', 'AppUserGroupController'); //用户组
    
    $router->resource('app_config_hot', 'AppConfigHotController'); //热钱包配置
    
    $router->resource('app_romaddress', 'AppRomaddressController'); //生成靓号
    

});
