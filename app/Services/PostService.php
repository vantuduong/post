<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2/25/2022
 * Time: 2:00 PM
 */

namespace App\Services;


use App\Models\Post;
use App\Services\Contracts\PostServiceInterface;

class PostService extends CRUDService implements PostServiceInterface
{
    /**
     * @return string
     */
    public function getModel()
    {
        return Post::class;
    }

    /**
     * @param Post $post
     * @param bool $status
     * @return Post
     */
    public function updateStatus(Post $post, bool $status)
    {
        $post->update([
            'status' => $status
        ]);

        return $post;
    }
}
