<?php

namespace App\Admin\Repositories;

use App\Models\AppOrder as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppOrder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
