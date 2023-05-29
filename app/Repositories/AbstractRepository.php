<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements Repository {

    private Model $model;
    protected int $limit = 10;

    public function __construct(Model $model) {
        $this->model = $model;
        $this->model->__set('perPage', $this->limit);
    }

    public function get($id) {
        return $this->model->find($id);
    }

    public function getAll(): Collection {
        return $this->model->all();
    }

    public function paginate($limit = 10) {
        return $this->model->paginate($limit);
    }

    public function findBy(array $fieldsValues, $limit, $operator = 'like', $orderBy = null, $direction = 'asc', $aggregate = false) {
        $query = $this->mountQueryByFields($fieldsValues, $operator, $aggregate);
        if ($orderBy) {
            $query->orderBy($orderBy, $direction);
        }

        return $limit == 'all' ? $query->get() : $query->paginate($limit);
    }

    public function findByDateRange($field, $start, $end, $page, $limit) {
        $query = $this->model->whereBetween($field, [$start, $end]);
        return $limit == 'all' ? $query->get() : $query->paginate($limit);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        return $this->get($id)->update($data);
    }

    public function delete($id) {
        return $this->get($id)->delete();
    }

    private function mountQueryByFields($fieldsValues, $operator ,$aggregate) {
        $query = null;
        foreach ($fieldsValues as $field => $value) {
            $operatorValue = $operator == 'like' ? "%$value%" : $value;
            if (empty($query)) {
                $query = $this->model->where($field, $operator, $operatorValue);
            } else {
                if ($aggregate) {
                    $query->where($field, $operator, $operatorValue);
                } else {
                    $query->orWhere($field, $operator, $operatorValue);
                }
            }
        }

        return $query;
    }
}
