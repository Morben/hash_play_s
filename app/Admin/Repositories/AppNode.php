<?php

namespace App\Admin\Repositories;

use App\Models\AppNode as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppNode extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
