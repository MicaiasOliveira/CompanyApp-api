<?php

namespace App\Services;

interface Service {
    public function getAll();
    public function paginate($page, $limit);
    public function get($id);
    public function findBy(array $fieldsValues, $limit, $operator, $orderBy, $direction, $aggregate);
    public function findByDateRange($field, $start, $end, $page, $limit);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}
