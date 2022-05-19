<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppConfigHot;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Support\Helper;

class AppConfigHotController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppConfigHot(), function (Grid $grid) {
            // $grid->column('id')->sortable();
            // $grid->column('code');
            // $grid->column('enable');

            $grid->column('hot_address')->copyable();;
            // $grid->column('limit_amount');
            $grid->column('limit_amount')->display(function (){
                return sprintf("%.2f",$this->limit_amount);
            });
            $grid->column('enable')->display(function (){
                return $this->enable == "yes" ? 1 : 0;
            })->switch('', true);
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
        return Show::make($id, new AppConfigHot(), function (Show $show) {
            $show->field('id');
            $show->field('code');
            $show->field('enable');
            $show->field('hot_address');
            $show->field('hot_key');
            $show->field('limit_amount');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AppConfigHot(), function (Form $form) {
            // $form->display('id');
            // $form->text('code');
            // $form->text('enable');
            $form->switch("enable")->customFormat(function ($v) {
                return $v == 'yes' ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 'yes' : 'no';
            });
            $form->text('hot_address');
            
            $form->text('hot_key')->customFormat(function ($v) {
                return "";
            })
            ->saving(function ($v) {
                $v = Helper::array($v);
                $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap("MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCV29naWtQgs8F3XiQD9s94esKKFfMpvS8waKB9Vk9xvmwm7XArcNZPWLk2IXfD4T474xHHhHzY+9Hh+mwVJwEhvvoesB58uXJ0e9lJx6gbGjbAY34VfJJWTzytOVCK3hQjLaOhZJQnTOA62atFIbiEM5fvI5rCeODv1rgFewL0KwIDAQAB", 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
                
                openssl_public_encrypt($v[0], $encrypt, $res);
            
                $v =  base64_encode($encrypt);
                $v = strtr($v,'"','');
                return $v;
            })->help('不修改留空');
            $form->text('limit_amount');
        });
    }
    
   

}
