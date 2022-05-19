<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TgCrontab;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class TgCrontabController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TgCrontab(), function (Grid $grid) {
            $grid->column('id')->sortable();
            // $grid->column('group_id');
            $grid->column('group_id')->display(function (){
                $group = DB::table("tg_group")->where("id",$this->group_id)->first();
                return '<span class="label bg-primary">'.$group->title."[".$group->id."]".'</span>';
            });
            $grid->column('count_down');
            // $grid->column('key_id');
            $grid->column('key_id')->display(function (){
                $keyword = DB::table("tg_keyword")->where("id",$this->key_id)->first();
                return '<span class="label bg-primary">'.$keyword->keyword."[".$keyword->id."]".'</span>';
            });
            $grid->column('status')->switch();
            $grid->column('remark');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
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
        return Show::make($id, new TgCrontab(), function (Show $show) {
            $show->field('id');
            $show->field('group_id');
            $show->field('count_down');
            $show->field('key_id');
            $show->field('status');
            $show->field('remark');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TgCrontab(), function (Form $form) {
            $form->display('id');
            $bots = DB::table("tg_bot")->get()->pluck('username', 'id');
            $form->select('bot_id')->options($bots)->label("机器人");
            // $form->text('group_id');
            $group = DB::table("tg_group")->get()->pluck('title', 'id');
            $form->select('group_id')->options($group)->label("群组");
            
            $form->text('count_down');
            $keyword = DB::table("tg_keyword")->get()->pluck('keyword', 'id');
            $form->select('group_id')->options($keyword)->label("关键词");
            // $form->text('key_id');
            // $form->text('status');
            $form->text('remark');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
