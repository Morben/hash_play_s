<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TgBot;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TgBotController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TgBot(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('bot_id');
            $grid->column('username');
            $grid->column('can_join_groups')->bool();
            $grid->column('can_read_all_group_messages')->bool();
            $grid->column('supports_inline_queries')->bool();
            $grid->column('status')->switch();
            $grid->column('remark');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('username');
                $filter->between('created_at', "created_at")->datetime();
            });
            
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->toolsWithOutline(false);
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->export();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                
                // prepend一个操作
                $botToken = $actions->row->bot_token;
                $apiUrl = "https://".$_SERVER["HTTP_HOST"]."/api/pushmsg/".$botToken;
                $actions->prepend('<a href="https://api.telegram.org/bot'.$botToken.'/deleteWebhook" target="_blank" title="删除webhook"><i class="fa fa-minus-circle"></i> 删除webhook</a>');
                $actions->prepend('<a href="https://api.telegram.org/bot'.$botToken.'/getUpdates" target="_blank" title="测试消息"><i class="fa fa-telegram"></i> 测试消息</a>');
                $actions->prepend('<a href="https://api.telegram.org/bot'.$botToken.'/setWebhook?url='.$apiUrl.'" target="_blank" title="注册webhook"><i class="fa fa-chevron-circle-right"></i> 注册webhook</a>');
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
        return Show::make($id, new TgBot(), function (Show $show) {
            $show->field('id');
            $show->field('bot_id');
            $show->field('username');
            $show->field('can_join_groups')->using(['0' => '否', '1' => '是']);
            $show->field('can_read_all_group_messages')->using(['0' => '否', '1' => '是']);
            $show->field('supports_inline_queries')->using(['0' => '否', '1' => '是']);
            $show->textarea('remark');
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
        return Form::make(new TgBot(), function (Form $form) {
            $form->display('username');
            // $form->text('bot_id');
            $form->text('bot_token');
            $form->switch("status")->customFormat(function ($v) {
                return $v == 1 ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 1 : 0;
            });
            // $form->text('username');
            // $form->text('can_join_groups');
            // $form->text('can_read_all_group_messages');
            // $form->text('supports_inline_queries');
            $form->textarea('remark');
        
            // $form->display('created_at');
            // $form->display('updated_at');
        });
    }
}
