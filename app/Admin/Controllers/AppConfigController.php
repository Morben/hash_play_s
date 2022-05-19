<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppConfig;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class AppConfigController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppConfig(), function (Grid $grid) {
            // $grid->column('id')->sortable();
            
            $grid->column('game_house')->display(function (){
                if($this->game_house == "dating"){
                    return '<span class="label" style="background:#21b978">大厅场</span>';
                }else if($this->game_house == "vip"){
                    return '<span class="label" style="background:#FF4500">VIP场</span>';
                }else{
                    return '<span class="label" style="background:#FF7F50">'.$this->game_house.'</span>';
                }
            });
            $grid->column('game_type')->display(function (){
               switch($this->game_type){
                   case "niuniu";
                   return "牛牛游戏";
                   break;
                   case "shuangwei";
                   return "双尾游戏";
                   case "danshuang";
                   return "单双游戏";
                   case "baijiale";
                   return "百家乐";
                   break;
                   default;
               } 
            });
            $grid->combine("TRX限额", ['min_trx', 'max_trx']);
            $grid->combine("USDT限额", ['min_usd', 'max_usd']);
            $grid->column('max_trx')->display(function (){
                return sprintf("%.2f",$this->max_trx);
            });
            $grid->column('max_usd')->display(function (){
                return sprintf("%.2f",$this->max_usd);
            });
            $grid->column('min_trx')->display(function (){
                return sprintf("%.2f",$this->min_trx);
            });
            $grid->column('min_usd')->display(function (){
                return sprintf("%.2f",$this->min_usd);
            });
            $grid->column('odds')->display(function (){
                return sprintf("%.2f",$this->odds);
            });
            $grid->column('auto_open')->display(function (){
                return $this->auto_open == "yes" ? 1 : 0;
            })->switch('', true);
            $grid->column('to_address')->copyable();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
            // append一个操作
                $actions->append('<a href="https://tronscan.io/#/address/'.$this->to_address.'" target="_black" ><i class="fa fa-eye"></i>波场浏览器</a>');
            });


            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableFilterButton();
            $grid->disableRowSelector();

            $grid->quickSearch('tp_address')->placeholder("Enter wallet address");
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('to_address');
        
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
        return Show::make($id, new AppConfig(), function (Show $show) {
            $show->field('id');
            $show->field('auto_open');
            $show->field('game_house');
            $show->field('game_type');
            $show->field('max_trx');
            $show->field('max_usd');
            $show->field('min_trx');
            $show->field('min_usd');
            $show->field('odds');
            $show->field('to_address');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppConfig(), function (Form $form) {
            // $form->display('id');
            $form->text('game_house')->disable()->customFormat(function ($v) {
                return $v == 'dating' ? "大厅场" : "VIP场";
            })
            ->saving(function ($v) {
                return $v ? 'dating' : 'vip';
            });
            $form->text('game_type')->disable()->customFormat(function ($v) {
                 switch($v){
                   case "niuniu";
                   return "牛牛游戏";
                   break;
                   case "shuangwei";
                   return "双尾游戏";
                   case "danshuang";
                   return "单双游戏";
                   case "baijiale";
                   return "百家乐";
                   break;
                   default;
               } 
            });
            $form->switch("auto_open")->customFormat(function ($v) {
                return $v == 'yes' ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 'yes' : 'no';
            });
            $form->text('max_trx')->type('number')->required();
            $form->text('max_usd')->type('number')->required();
            $form->text('min_trx')->type('number')->required();
            $form->text('min_usd')->type('number')->required();
            $form->text('odds')->type('number')->required();
            $form->text('to_address')->required();
            $form->submitted(function (Form $form) {
                // 接收表单参数
                $to_address = $form->to_address;
                $id = $form->getKey();
                $res = DB::table("app_config")->where("to_address",$to_address)->where('id','<>',$id)->count();
                if($res>0){
                    $form->responseValidationMessages('to_address', '该游戏地址已经绑定过了');    
                }
                
            });


        });
    }
}
