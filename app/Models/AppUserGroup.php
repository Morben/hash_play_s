<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppUserGroup extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_user_group';
    public $timestamps = false;

}
