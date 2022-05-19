<?php

namespace App\Admin\Repositories;

use App\Models\AppOrderWaitSend as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppOrderWaitSend extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
