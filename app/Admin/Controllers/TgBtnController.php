<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TgBtn;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use DB;

class TgBtnController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TgBtn(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('bot_id')->display(function (){
                $bot = DB::table("tg_bot")->where("id",$this->bot_id)->first();
                return '<span class="label bg-primary">'.$bot->username."[".$bot->id."]".'</span>';
            });
            // $grid->column('chat_id');
            // $grid->column('chat_id')->display(function (){
            //     $group = DB::table("tg_group")->where("id",$this->chat_id)->first();
            //     // return '<span class="label bg-primary">'.$group->title ?? ""."[".$group->id ?? ""."]".'</span>';
            // });
            // $grid->column('type');
            $grid->column('type')->display(function (){
                if($this->type == 1){
                    return "内联";
                }else {
                    return "外联";
                }
            });
            $grid->column('btntext');
            // $grid->column('keywordid');
             $grid->column('keywordid')->display(function (){
                $keyword = DB::table("tg_keyword")->where("id",$this->keywordid)->first();
                return '<span class="label bg-primary">'.$keyword->keyword."[".$keyword->id."]".'</span>';
            });
            
            
            $grid->column('remark');
            $grid->column('status')->switch();
            $grid->column("groyp")->display(function (){
                if($this->groyp == 1){
                    return "普通用户";
                }else{
                    return "代理";
                }
            });
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
        return Show::make($id, new TgBtn(), function (Show $show) {
            $show->field('id');
            $show->field('bot_id');
            $show->field('chat_id');
            $show->field('type');
            $show->field('btntext');
            $show->field('keywordid');
            $show->field('remark');
            $show->field('status');
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
        return Form::make(new TgBtn(), function (Form $form) {
            $form->display('id');
            $bots = DB::table("tg_bot")->get()->pluck('username', 'id');
            $form->select('bot_id')->options($bots)->label("机器人");
            // $group = DB::table("tg_group")->get()->pluck('title', 'id');
            // $form->select('chat_id')->options($group)->label("群组");
            $form->select('type')->options([1 => '内联', 0 => '外联']);
            $form->text('btntext');
            $keyword = DB::table("tg_keyword")->get()->pluck('keyword', 'id');
            $form->select('keywordid')->options($keyword);
            $form->switch("status")->customFormat(function ($v) {
                return $v == 1 ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 1 : 0;
            });
            
            $form->text('remark');
            $form->select('groyp')->options([1 => '普通用户', 0 => '代理']);
            // $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
