<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppConfigFenhong;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class AppConfigFenhongController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppConfigFenhong(), function (Grid $grid) {
            // $grid->column('id')->sortable();
            // $grid->column('code');
            // $grid->column('daili_num')->display(function (){
            //     return sprintf("%.2f",$this->daili_num);
            // });
            $grid->column('group_num')->display(function (){
                return sprintf("%.2f",$this->group_num);
            });
            $grid->column('one')->display(function (){
                return sprintf("%.2f",$this->one);
            });
            $grid->column('two')->display(function (){
                return sprintf("%.2f",$this->two);
            });
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableFilterButton();
            $grid->disableRowSelector();

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
        return Show::make($id, new AppConfigFenhong(), function (Show $show) {
            $show->field('id');
            $show->field('code');
            $show->field('daili_num');
            $show->field('group_num');
            $show->field('one');
            $show->field('two');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppConfigFenhong(), function (Form $form) {
            // $form->display('id');
            // $form->text('code');
            $form->text('daili_num')->type('number')->required();
            $form->text('group_num')->type('number')->required();
            $form->text('one')->type('number')->required();
            $form->text('two')->type('number')->required();
        });
    }
}
