<?php

namespace App\Admin\Repositories;

use App\Models\AppConfig as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppConfig extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
