<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2/25/2022
 * Time: 1:57 PM
 */

namespace App\Services\Contracts;


use App\Models\Post;

interface PostServiceInterface extends CRUDInterface
{
    public function updateStatus(Post $post, bool $status);
}
