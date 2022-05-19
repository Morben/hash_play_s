<?php

namespace App\Admin\Repositories;

use App\Models\AppUserGroup as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppUserGroup extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
