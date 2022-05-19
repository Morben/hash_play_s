<?php

namespace App\Admin\Repositories;

use App\Models\AppConfigHot as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppConfigHot extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
