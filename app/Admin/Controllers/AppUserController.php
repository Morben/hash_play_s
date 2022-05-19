<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Admin;
use DB;

class AppUserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppUser(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('address')->copyable();
            
            $grid->column('father_id');
            $grid->column('fenhong_balance');
            
           
            // $grid->column('level');
            $grid->quickSearch('address')->placeholder("trc20地址");
            
            $grid->column('my_code')->copyable();
             $grid->column('tg_name')->copyable();
            $grid->column('create_time');
            $grid->column('update_time');
            $grid->model()->orderBy('id', 'desc');
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            // $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->export();
            
            if(Admin::user()->inRoles(['administrator'])){
                 $grid->column('fenyong_enable')->display(function (){
                    return $this->fenyong_enable == "yes" ? 1 : 0;
                })->switch('', true);
                 $grid->column('jiesuan_enable')->display(function (){
                    return $this->jiesuan_enable == "yes" ? 1 : 0;
                })->switch('', true);
                
            }    
            
            
            
            
            if(Admin::user()->inRoles(['agent'])){
                $grid->column('fenyong_enable')->display(function (){
                    return $this->fenyong_enable == "yes" ? "代理" : "用户";
                });
                $grid->disableDeleteButton();
                $grid->disableQuickEditButton();
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
                   $grid->model()->whereIn('address',$son);
                   $grid->disableQuickEditButton();
                
            }


            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('father_id');
                $filter->equal('address');
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
        return Show::make($id, new AppUser(), function (Show $show) {
            $show->field('id');
            $show->field('address');
            $show->field('create_time');
            $show->field('father_id');
            $show->field('fenhong_balance');
            $show->field('fenyong_enable');
            $show->field('jiesuan_enable');
            $show->field('level');
            $show->field('my_code');
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
        return Form::make(new AppUser(), function (Form $form) {
            $form->display('id');
            $form->text('address');
            $form->text('create_time');
            $form->text('father_id');
            $form->text('fenhong_balance');
            $form->switch("fenyong_enable")->customFormat(function ($v) {
                return $v == 'yes' ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 'yes' : 'no';
            });
            $form->switch("jiesuan_enable")->customFormat(function ($v) {
                return $v == 'yes' ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 'yes' : 'no';
            });
            $form->text('level');
            $form->text('my_code');
            $form->text('update_time');
        });
    }
}
