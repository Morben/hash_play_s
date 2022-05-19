<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class TgCrontab extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'tg_crontab';
    
}
