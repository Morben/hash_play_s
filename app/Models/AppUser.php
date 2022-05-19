<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'app_user';
    public $timestamps = false;

}
