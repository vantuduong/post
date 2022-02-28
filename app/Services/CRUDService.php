<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2/25/2022
 * Time: 2:01 PM
 */

namespace App\Services;


use App\Services\Contracts\CRUDInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class CRUDService implements CRUDInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    public function index(array $params = [])
    {
        return $this->model::filter($params)->sort(Arr::get($params, 'sort'))
            ->paginate(config('project.per_page'));
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update(Model $model, array $data)
    {
        $model->update($data);

        return $model;
    }

    public function delete(Model $model)
    {
        $model->delete();

        return $model;
    }

    abstract public function getModel();
}
