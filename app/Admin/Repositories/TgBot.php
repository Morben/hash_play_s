<?php

namespace App\Admin\Repositories;

use App\Models\TgBot as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class TgBot extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
