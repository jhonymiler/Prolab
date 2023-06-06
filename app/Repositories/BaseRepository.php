<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function all()
    {
        return $this->model->all();
    }


    public function resolveModel()
    {
        return app($this->model);
    }
}
