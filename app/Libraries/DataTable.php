<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseBuilder;

class DataTable
{
    protected $builder;
    protected $request;
    protected $columns;

    public function __construct(BaseBuilder $builder, array $columns = [])
    {
        $this->builder = $builder;
        $this->request = service('request');
        $this->columns = $columns;
    }

    public function generate()
    {
        $draw = intval($this->request->getPost('draw'));
    $start = intval($this->request->getPost('start'));
    $length = intval($this->request->getPost('length'));
    $searchValue = $this->request->getPost('search')['value'] ?? '';

    // Clone builder for counting
    $countBuilder = clone $this->builder;

    // Filter
    if (!empty($searchValue) && !empty($this->columns)) {
        $this->builder->groupStart();
        foreach ($this->columns as $col) {
            $this->builder->orLike($col, $searchValue);
        }
        $this->builder->groupEnd();
    }

    // Total filtered
    $filteredBuilder = clone $this->builder;
    $recordsFiltered = $filteredBuilder->countAllResults(false);

    // Ordering
    $order = $this->request->getPost('order');
    if (!empty($order) && isset($this->columns[$order[0]['column']])) {
        $orderColumn = $this->columns[$order[0]['column']];
        $orderDir = $order[0]['dir'] === 'desc' ? 'desc' : 'asc';
        $this->builder->orderBy($orderColumn, $orderDir);
    }

    // Limit and get data
    $this->builder->limit($length, $start);
    $query = $this->builder->get();
    $data = $query->getResultArray();

    return [
        'draw' => $draw,
        'recordsTotal' => $countBuilder->countAllResults(),
        'recordsFiltered' => $recordsFiltered,
        'data' => $data
    ];
    }
}
