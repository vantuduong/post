<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2/25/2022
 * Time: 1:54 PM
 */

namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Model;

interface CRUDInterface
{
    public function index(array $params = []);

    public function create(array $data);

    public function update(Model $model, array $data);

    public function delete(Model $model);

}
