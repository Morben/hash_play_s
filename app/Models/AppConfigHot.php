<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppConfigHot extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_config_hot';
    public $timestamps = false;

}
