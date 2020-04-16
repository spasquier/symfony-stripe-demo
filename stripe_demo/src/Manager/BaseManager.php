<?php

namespace App\Manager;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class BaseManager
{
    /**
     * @var ServiceEntityRepository
     */
    protected $repository;

    /**
     * @param $object
     */
    public function save($object)
    {
        $this->repository->save($object);
    }

    /**
     * @param $object
     */
    public function remove($object)
    {
        $this->repository->delete($object);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}
