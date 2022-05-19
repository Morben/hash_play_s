<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppRomaddress;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class AppRomaddressController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppRomaddress(), function (Grid $grid) {
            $grid->column('id')->sortable();
            // $grid->column('private_key');
            // $grid->column('public_key');
            $grid->column('address_hex');
            $grid->column('address_base58');
            $grid->column('createtime');
            $grid->column('remark');
            
            $grid->export();
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            // $grid->disableDeleteButton();
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
        return Show::make($id, new AppRomaddress(), function (Show $show) {
            $show->field('id');
            $show->field('id');
            $show->field('private_key');
            $show->field('public_key');
            $show->field('address_hex');
            $show->field('address_base58');
            $show->field('createtime');
            $show->field('remark');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppRomaddress(), function (Form $form) {
            $form->display('id');
            $form->text('private_key');
            $form->text('public_key');
            $form->text('address_hex');
            $form->text('address_base58');
            $form->text('createtime');
            $form->text('remark');
        });
    }
}
