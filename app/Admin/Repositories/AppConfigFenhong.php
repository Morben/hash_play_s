<?php

namespace App\Admin\Repositories;

use App\Models\AppConfigFenhong as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppConfigFenhong extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
