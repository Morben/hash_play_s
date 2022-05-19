<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_config';
    public $timestamps = false;

}
