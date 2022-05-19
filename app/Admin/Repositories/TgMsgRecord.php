<?php

namespace App\Admin\Repositories;

use App\Models\TgMsgRecord as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class TgMsgRecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
