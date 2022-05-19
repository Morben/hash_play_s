<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppRomaddress extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_romaddress';
    public $timestamps = false;

}
