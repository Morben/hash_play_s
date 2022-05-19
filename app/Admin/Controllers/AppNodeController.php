<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppNode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class AppNodeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppNode(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('height');
            $grid->column('node');
        
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
        return Show::make($id, new AppNode(), function (Show $show) {
            $show->field('id');
            $show->field('height');
            $show->field('node');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppNode(), function (Form $form) {
            $form->display('id');
            $form->text('height');
            $form->text('node');
        });
    }
}
