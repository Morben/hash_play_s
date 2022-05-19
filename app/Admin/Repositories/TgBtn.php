<?php

namespace App\Admin\Repositories;

use App\Models\TgBtn as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class TgBtn extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
