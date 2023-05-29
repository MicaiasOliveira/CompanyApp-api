<?php

namespace App\Repositories;

interface Repository {
    public function getAll();
    public function paginate($limit);
    public function get($id);
    public function findBy(array $fieldsValues, $limit, $operator, $orderBy, $direction, $aggregate);
    public function findByDateRange($field, $start, $end, $page, $limit);
    public function create($data);
    public function update($id, $data);
    public function delete($id);

}
