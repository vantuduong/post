<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\Contracts\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Post::class);

        $params = $request->all();

        if (!Auth::user()->is_admin) {
            $params['user_id'] = Auth::id();
        }

        return view('posts.index', [
            'posts' => $this->postService->index($params)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        return view('posts.create', [
            'post' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);

        $this->postService->create(array_merge($request->only([
            'title',
            'content',
            'schedule_publish'
        ]), [
            'user_id' => Auth::id()
        ]));

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.create', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $this->postService->update($post, $request->only([
            'title',
            'content',
            'schedule_publish'
        ]));

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        return redirect()->route('posts.index');
    }

    public function newFeed(Request $request)
    {
        return view('new-feed', [
            'posts' => $this->postService->index(array_merge($request->all(), [
                'status' => true
            ]))
        ]);
    }

    /**
     * @param Post $post
     * @return JsonResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateStatus(Post $post)
    {
        $this->authorize('update-status', $post);

        $post->update([
            'status' => !$post->status
        ]);

        return new JsonResource($post);
    }
}
