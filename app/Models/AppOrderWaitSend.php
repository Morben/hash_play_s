<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppOrderWaitSend extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_order_wait_send';
    public $timestamps = false;

}
