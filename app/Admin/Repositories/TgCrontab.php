<?php

namespace App\Admin\Repositories;

use App\Models\TgCrontab as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class TgCrontab extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
