<?php

namespace App\Admin\Repositories;

use App\Models\AppFenFlow as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppFenFlow extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
