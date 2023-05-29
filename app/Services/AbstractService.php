<?php

namespace App\Services;

use App\Repositories\Repository;

abstract class AbstractService implements Service {

    private Repository $repository;

    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    public function paginate($page, $limit = 10) {
        return $this->repository->paginate($limit);
    }

    public function get($id) {
        return $this->repository->get($id);
    }

    public function findBy(array $fieldsValues, $limit, $operator = 'like', $orderBy = null, $direction = 'asc', $aggregate = false) {
        return $this->repository->findBy($fieldsValues, $limit, $operator ,$orderBy, $direction, $aggregate);
    }

    public function findByDateRange($field, $start, $end, $page, $limit) {
        return $this->repository->findByDateRange($field, $start, $end, $page, $limit);
    }

    public function create($data) {
        return $this->repository->create($data);
    }

    public function update($id, $data) {
        return $this->repository->update($id, $data);
    }

    public function delete($id) {
        return $this->get($id)->delete();
    }
}
