<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends ApiController
{
    //
    public function index()
    {
        $posts = Post::get();
        // return response()->json([
        //     'message' => 'List of posts',
        //     'posts' => $posts
        // ], 200);

        return $this->successResponse($posts);
    }

    public function store(StorePostRequest $request){
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return response()->json([
            'message' => "Post Created Successfully",
            'posts' => $post
        ]);
    }

    public function show($id)
    {
       $post = Post::find($id);
       //$post = Post::whereId($id)->first()
        //    return response()->json([
        //     'message' => "Single Post",
        //     'post' => $post
        //    ], 200);

        if(!$post){
            return response()->json([
                'message' => "Post Not Found"
            ],404);
        }
        return $this->successResponse($post);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        //print_r($request->all());
        $data = $request->validated();

       $post = Post::findOrFail($id);
       if(!$post) {
              return response()->json([
                'message' => "Post Not Found"
            ], 404);
       }
        $post->update($data);
        //die;
        // $post = Post::find($id);
        // $post->title = $request->title ;
        // $post->content = $request->content;
        // $post->save();

        // $post->update($request->validated());
        return $this->successResponse($post);

    }

    public function destroy($id)
    {
        $post = Post::whereId($id)->first();
        if(!$post) {
              return response()->json([
                'message' => "Post Not Found"
            ], 404);
        }
        $post->delete();

        return $this->successResponse($post);

    }
}