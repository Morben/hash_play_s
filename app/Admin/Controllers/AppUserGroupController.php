<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppUserGroup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class AppUserGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppUserGroup(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->combine("用户信息", ['user_id', 'user_address']);
            $grid->column('user_id');
            $grid->column('user_address')->display(function (){
                $user = DB::table("app_user")->where("id",$this->user_id)->first();
                return $user->address;
            });
            // $grid->column('group_chain');
            $grid->column('group_total');
            $grid->column('create_time');
            $grid->column('update_time');

            $grid->quickSearch('user_id')->placeholder("用户id");
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableFilterButton();
            $grid->export();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
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
        return Show::make($id, new AppUserGroup(), function (Show $show) {
            $show->field('id');
            $show->field('create_time');
            $show->field('group_chain');
            $show->field('group_total');
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
        return Form::make(new AppUserGroup(), function (Form $form) {
            $form->display('id');
            $form->text('create_time');
            $form->text('group_chain');
            $form->text('group_total');
            $form->text('update_time');
            $form->text('user_id');
        });
    }
}
