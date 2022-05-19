<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppFenFlow extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_fen_flow';
    public $timestamps = false;

}
