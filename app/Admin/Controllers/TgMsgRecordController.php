<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TgMsgRecord;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class TgMsgRecordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TgMsgRecord(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('bot_id')->display(function (){
                $bot = DB::table("tg_bot")->where("id",$this->bot_id)->first();
                return '<span class="label bg-primary">'.$bot->username."[".$bot->id."]".'</span>';
            });
            $grid->column('chat_id');
            $grid->column('type');
            $grid->column('username');
            $grid->column('content');
            $grid->column('images')->image();
            $grid->column('remark');
            $grid->column('created_at');
            // $grid->column('updated_at')->sortable();
            
    
            $grid->disableEditButton();
            $grid->disableQuickEditButton();


            $grid->model()->orderBy('id', 'desc');
            $grid->withBorder();
            $grid->quickSearch();
            $grid->quickSearch('username', 'bot_id', 'content');
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $bots = DB::table("tg_bot")->get()->pluck('username', 'id');
                $filter->in('bot_id')->multipleSelect($bots);
                $filter->in('type')->multipleSelect(['private'=>'private','supergroup'=>'supergroup','channel'=>'channel']);
                $filter->like('content');
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
        return Show::make($id, new TgMsgRecord(), function (Show $show) {
            $show->field('id');
            $show->field('bot_id');
            $show->field('message_id');
            $show->field('type');
            $show->field('username');
            $show->field('content');
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
        return Form::make(new TgMsgRecord(), function (Form $form) {
            $form->display('id');
            $form->text('bot_id');
            $form->text('message_id');
            $form->text('type');
            $form->text('username');
            $form->text('content');
            $form->text('remark');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
