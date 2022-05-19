<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppOrder;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Admin;
use DB;

class AppOrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppOrder(), function (Grid $grid) {
            $grid->column('id')->sortable();
            
            $grid->column('hash')->display(function (){
                return '<a href="https://tronscan.io/#/transaction/'.$this->hash.'" target="_black" style="color:#4397fd" title="'.$this->hash.'" >...'.substr($this->hash,-10).'<a>';
            });
            $grid->column('hash_last');
            $grid->combine("转账地址", ['from_address', 'put_amount']);
            $grid->column('from_address')->copyable();
           
            $grid->column('put_amount')->display(function (){
                return sprintf("%.2f",$this->put_amount)." ".$this->coin_code;
            });
            $grid->column('game_house')->display(function (){
                if($this->game_house == "dating"){
                    $text = '<span class="label" style="background:#21b978">大厅场</span>';
                }else if($this->game_house == "vip"){
                    $text =  '<span class="label" style="background:#FF4500">VIP场</span>';
                }else{
                    $text =  '<span class="label" style="background:#FF7F50">'.$this->game_house.'</span>';
                }
                switch($this->game_type){
                   case "niuniu";
                   return "牛牛游戏 ".$text;
                   break;
                   case "shuangwei";
                   return  "双尾游戏 ".$text;
                   case "danshuang";
                   return "单双游戏 ".$text;
                   case "baijiale";
                   return  "百家乐 ".$text;
                   break;
                   default;
               } 
              
            });
            if(Admin::user()->inRoles(['administrator'])){
                
                $grid->column('auto_open')->display(function (){
                    return $this->auto_open == "yes" ? 1 : 0;
                })->switch('', true);
                    
            }   
            
            $grid->column('shuying_amount')->display(function (){
                return sprintf("%.2f",$this->shuying_amount)." ".$this->coin_code;
            });
           
            $grid->column('win_status')->display(function (){
                if($this->win_status == "ying"){
                    return '<span class="label" style="background:#009688">中奖</span>';
                }else{
                    return '<span class="label" style="background:#FF4500">未中奖</span>';;
                }
            });
            $grid->column('open_status')->display(function (){
                if($this->open_status == "over"){
                    return '<span class="label" style="background:#009688">发放完成</span>';;
                }else if($this->open_status == "open"){
                    return '<span class="label" style="background:#FFA500">已开奖</span>';;
                }
            });
            $grid->column('update_time');
            $grid->column('remark');
            
            $grid->selector(function (Grid\Tools\Selector $selector) {
                
                $selector->select('game_type', '游戏', [
                    'niuniu' => '牛牛游戏',
                    'shuangwei' => '双尾游戏',
                    'danshuang'=>"单双游戏",
                    'baijiale'=>"百家乐"
                   
                ]);
                
                $selector->select('game_house', '房间', [
                    'dating' => '大厅场',
                    'vip' => 'VIP场',
                   
                ]);
                
                $selector->select('coin_code', '币种', [
                    'TRX' => 'TRX',
                    'USDT' => 'USDT',
                   
                ]);
                $selector->select('win_status', '中奖状态', [
                    'ying' => '中奖',
                    'shu' => '未中奖',
                   
                ]);
            });
            

            $grid->model()->orderBy('id', 'desc');
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->export();
            
            if(Admin::user()->inRoles(['agent'])){
                $admin = DB::table("admin_users")->where("id",Admin::user()->id)->first();
                $userchekc = DB::table("app_user")->where("address",$admin->username)->first();
                $user = [$userchekc->address];
                //一级
                   $son = DB::table("app_user")->where("father_id",$userchekc->id)->pluck("address");
                   $son = json_decode($son);
                   //二级
                   $son_two = DB::table("app_user")->whereIn("father_id",$son)->pluck("address");
                   $son_two = json_decode($son_two);
                   //三级
                   $son_three = DB::table("app_user")->whereIn("father_id",$son_two)->pluck("address");
                   $son_three = json_decode($son_three);
                   $son = array_merge($son,$son_two);
                   $son = array_merge($son,$son_three);
                   $son = array_merge($son,$user);
                   $grid->model()->whereIn('from_address',$son);
                   $grid->disableQuickEditButton();
                
            }
            
             
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('from_address');
                $filter->equal('to_address');
                $filter->between('create_time', "创建时间")->datetime();
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new AppOrder(), function (Show $show) {
            $show->field('id');
            $show->field('auto_open');
            $show->field('coin_code');
            $show->field('create_time');
            $show->field('from_address');
            $show->field('game_house');
            $show->field('game_type');
            $show->field('hash');
            $show->field('hash_last');
            $show->field('huikuan_amount');
            $show->field('open_status');
            $show->field('open_time');
            $show->field('put_amount');
            $show->field('shuying_amount');
            $show->field('to_address');
            $show->field('update_time');
            $show->field('wanjia_open_str');
            $show->field('win_status');
            $show->field('zhuang_open_str');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppOrder(), function (Form $form) {
            // $form->display('id');
            $form->switch("auto_open")->customFormat(function ($v) {
                return $v == 'yes' ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 'yes' : 'no';
            });
            // $form->text('coin_code');
            // $form->text('create_time');
            $form->text('from_address');
            $form->text('to_address');
            // $form->text('game_house');
            // $form->text('game_type');
            $form->text('hash');
            $form->text('hash_last');
            // $form->text('huikuan_amount');
            // $form->text('open_status');
            // $form->text('open_time');
            // $form->text('put_amount');
            // $form->text('shuying_amount');
            
            // $form->text('update_time');
            $form->text('wanjia_open_str');
            // $form->text('win_status');
            // $form->text('zhuang_open_str');
        });
    }
}
