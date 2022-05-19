<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TgGroup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class TgGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TgGroup(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('bot_id')->display(function (){
                $bot = DB::table("tg_bot")->where("id",$this->bot_id)->first();
                return '<span class="label bg-primary">'.$bot->username."[".$bot->id."]".'</span>';
            });
            $grid->column('chat_id');
            $grid->column('title');
            $grid->column('remark')->editable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            
            $grid->disableEditButton();
            $grid->quickSearch();
            $grid->disableCreateButton();
            $grid->quickSearch('chat_id', 'title', 'remark');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $bots = DB::table("tg_bot")->get()->pluck('username', 'id');
                $filter->in('bot_id')->multipleSelect($bots);
                $filter->like('title');
                $filter->like('remark');
                $filter->between('created_at', "created_at")->datetime();
        
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
        return Show::make($id, new TgGroup(), function (Show $show) {
            $show->field('id');
            $show->field('bot_id');
            $show->field('chat_id');
            $show->field('title');
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
        return Form::make(new TgGroup(), function (Form $form) {
            $form->display('id');
            $form->text('bot_id');
            $form->text('chat_id');
            $form->text('title');
            $form->text('remark');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
