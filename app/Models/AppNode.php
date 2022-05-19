<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppNode extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_node';
    public $timestamps = false;

}
