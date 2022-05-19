<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppOrder extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_order';
    public $timestamps = false;

}
