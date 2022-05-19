<?php

use Dcat\Admin\Layout\Navbar;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

// *
//  * Dcat-admin - admin builder based on Laravel.
//  * @author jqh <https://github.com/jqhph>
//  *
//  * Bootstraper for Admin.
//  *
//  * Here you can remove builtin form field:
//  *
//  * extend custom field:
//  * Dcat\Admin\Form::extend('php', PHPEditor::class);
//  * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
//  * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
//  *
//  * Or require js and css assets:
//  * Admin::css('/packages/prettydocs/css/styles.css');
//  * Admin::js('/packages/prettydocs/js/main.js');
//  *
//语言切换 
Admin::navbar(function (Navbar $navbar) {
    $navbar->right(view('admin.nav'));
});

$lang = session('lang') ? session('lang') : 'zh-CN';
// $lang = "zh_CN";
// dd($lang);
// dd($lang);

config(['app.locale' =>$lang]);
// dd(config('app.fallback_locale'));