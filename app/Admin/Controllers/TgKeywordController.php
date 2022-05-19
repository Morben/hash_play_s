<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TgKeyword;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class TgKeywordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TgKeyword(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('bot_id')->display(function (){
                $bot = DB::table("tg_bot")->where("id",$this->bot_id)->first();
                return '<span class="label bg-primary">'.$bot->username."[".$bot->id."]".'</span>';
            });
            $grid->column('keyword');
            // $grid->column('type');
            $grid->column('content')->width('270px');
            $grid->column('status')->switch();
            $grid->type('显示按钮')->switch();
            $grid->column('method')->display(function (){
                if($this->method == 'sendphoto'){
                    return '发送图文';
                }else {
                    return '发送文字';
                }
            });
            $grid->column('remark');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
       
            $grid->disableQuickEditButton();
            $grid->quickSearch();
            $grid->quickSearch('keyword', 'content','id');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $bots = DB::table("tg_bot")->get()->pluck('username', 'id');
                $filter->in('bot_id')->multipleSelect($bots);
                $filter->like('keyword');
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
        return Show::make($id, new TgKeyword(), function (Show $show) {
            $show->field('id');
            $show->field('bot_id');
            $show->field('keyword');
            // $show->field('type');
            $show->field('content');
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
        return Form::make(new TgKeyword(), function (Form $form) {
            $form->display('id');
            // $form->text('bot_id');
            $bots = DB::table("tg_bot")->get()->pluck('username', 'id');
            $form->select('bot_id')->options($bots)->label("机器人");
            $form->text('keyword');
            $form->image('file_id')->label("图片");
            $form->markdown('content');
            $form->switch("status")->customFormat(function ($v) {
                return $v == 1 ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 1 : 0;
            });
            $form->select('type')->options([1 => '显示按钮', 0 => '不显示按钮']);
            $form->select('method')->options(['sendMessage' => '发送文字', 'sendphoto' => '发送图文']);
            $form->text('remark');
            
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
