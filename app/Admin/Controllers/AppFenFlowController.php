<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppFenFlow;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;
use Dcat\Admin\Admin;

class AppFenFlowController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppFenFlow(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('from_address')->copyable();;
            $grid->column('to_address')->copyable();;
            $grid->column('fenhong_amonut')->display(function (){
                return sprintf("%.2f",$this->fenhong_amonut)." ".$this->coin_code;
            });
            $grid->column('create_time');
            $grid->column('update_time');
            $grid->column('remark');
            
            $grid->model()->orderBy('id', 'desc');
            $grid->quickSearch('to_address')->placeholder("请输入到账地址");
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->export();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->disableViewButton();
            
            if(Admin::user()->inRoles(['agent'])){
                $admin = DB::table("admin_users")->where("id",Admin::user()->id)->first();
                $userchekc = DB::table("app_user")->where("address",$admin->username)->first();
                $user = [$userchekc->id];
                //一级
                   $son = DB::table("app_user")->where("father_id",$userchekc->id)->pluck("id");
                   $son = json_decode($son);
                   //二级
                   $son_two = DB::table("app_user")->whereIn("father_id",$son)->pluck("id");
                   $son_two = json_decode($son_two);
                   //三级
                   $son_three = DB::table("app_user")->whereIn("father_id",$son_two)->pluck("id");
                   $son_three = json_decode($son_three);
                   $son = array_merge($son,$son_two);
                   $son = array_merge($son,$son_three);
                   $son = array_merge($son,$user);
                   $grid->model()->whereIn('user_id',$son);
                   $grid->disableQuickEditButton();
                   $grid->disableDeleteButton();
                
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
        return Show::make($id, new AppFenFlow(), function (Show $show) {
            $show->field('id');
            $show->field('coin_code');
            $show->field('create_time');
            $show->field('fenhong_amonut');
            $show->field('from_address');
            $show->field('to_address');
            $show->field('update_time');
            $show->field('user_id');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppFenFlow(), function (Form $form) {
            // $form->display('id');
            $form->textarea('remark');
            // $form->text('create_time');
            // $form->text('fenhong_amonut');
            // $form->text('from_address');
            // $form->text('to_address');
            // $form->text('update_time');
            // $form->text('user_id');
        });
    }
}
