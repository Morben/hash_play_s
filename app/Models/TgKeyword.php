<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class TgKeyword extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'tg_keyword';
    
}
