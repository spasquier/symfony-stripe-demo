<?php

namespace App\Manager;

class ProductManager extends BaseManager
{
    public function __construct($repository)
    {
        $this->repository = $repository;
    }
}