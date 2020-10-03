<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    //
    public function index()
    {
        $posts = Post::latest()->get();

        return response(
            [
                'success'=>true,
                'message'=> 'List of All Posts',
                'data'=>$posts
            ],200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(),
            [
            'title'=> 'required',
            'content'=>'required'
        ],[
            'title.required'=>'Enter Title Post!',
            'content.required'=> 'Enter Content Post !'
        ]);

        if($validator->fails())
        {
            return response(
                [
                    'success'=>false,
                    'message'=>'Please fill in the blank fields ',
                    'data'=>$validator->errors()
                ],
                400
            );
        }else{
            $post = Post::create([
                'title'=>$request->input('title'),
                'content'=>$request->input('content')
            ]);
            if($post)
            {
                return response(
                    [
                        'success'=>true,
                        'message'=> 'Post Saved !'
                    ],200);
            }else
            {
                return response(
                    [
                        'success'=>false,
                        'message'=> 'Post failed to save'
                    ],400
                );
            }
        }
    }

    public function show($id)
    {
        $post = Post::whereId($id)->first();
        if($post)
        {
            return response(
                [
                    'success'=>true,
                    'message'=>'Detail post',
                    'data'=>$post
                ]
            );
        }else
        {
            return response(
              [
                  'success'=>true,
                  'message'=>'Post not found!',
                  'data'=> ''
              ]
            );
        }
    }

}
