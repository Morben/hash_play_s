<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppOrderWaitSend;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;
use Dcat\Admin\Admin;

class AppOrderWaitSendController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppOrderWaitSend(), function (Grid $grid) {
            $grid->column('id')->sortable();
            // $grid->column('amount');
            $grid->column('tx_id')->display(function (){
                return '<a href="https://tronscan.io/#/transaction/'.$this->tx_id.'" target="_black" style="color:#4397fd" title="'.$this->tx_id.'" >...'.substr($this->tx_id,-10).'<a>';
            });
            $grid->column('amount')->display(function (){
                return sprintf("%.2f",$this->amount)." ".$this->coin_code;
            });
            // $grid->column('coin_code');
            $grid->combine("转账", ['receive_address', 'amount']);
            // $grid->column('from_address')->copyable();
            $grid->column('receive_address');
            // $grid->column('from_address');
            $grid->combine("订单信息", ['order_id', 'otxid']);
            $grid->column('order_id')->display(function (){
                return $this->order_id;
            });
            $grid->column('otxid')->display(function (){
                $user = DB::table("app_order")->where("id",$this->order_id)->first();
                return '<a href="https://tronscan.io/#/transaction/'.$user->hash.'" target="_black" style="color:#4397fd" title="'.$user->hash.'" >...'.substr($user->hash,-10).'<a>';
            });
            
            $grid->column('remark');
            // $grid->column('send_status');
            $grid->column('status');
            // $grid->column('tx_id');
            // $grid->column('type');
            $grid->column('create_time');
            $grid->column('update_time');
            
            $grid->selector(function (Grid\Tools\Selector $selector) {
                
                $selector->select('coin_code', '币种', [
                    'TRX' => 'TRX',
                    'USDT' => 'USDT',
                   
                ]);
               
                $selector->select('status', '转账状态', [
                    'success' => 'success',
                    
                   
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
                   $grid->model()->whereIn('receive_address',$son);
                   $grid->disableQuickEditButton();
                
            }
            
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('order_id');
                $filter->equal('tx_id');
                $filter->equal('from_address');
                $filter->equal('receive_address');
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
        return Show::make($id, new AppOrderWaitSend(), function (Show $show) {
            $show->field('id');
            $show->field('amount');
            $show->field('coin_code');
            $show->field('create_time');
            $show->field('from_address');
            $show->field('order_id');
            $show->field('receive_address');
            $show->field('remark');
            $show->field('send_status');
            $show->field('status');
            $show->field('tx_id');
            $show->field('type');
            $show->field('update_time');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppOrderWaitSend(), function (Form $form) {
            $form->display('id')->disable();
            // $form->text('amount');
            // $form->text('coin_code');
            // $form->text('create_time');
            $form->text('from_address')->disable();;
            // $form->text('order_id');
            $form->text('receive_address')->disable();;
            $form->text('remark');
            // $form->text('send_status');
            // $form->text('status');
            // $form->text('tx_id');
            // $form->text('type');
            // $form->text('update_time');
        });
    }
}
