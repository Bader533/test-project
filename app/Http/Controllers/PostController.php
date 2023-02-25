<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::user()->id)->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'title' => 'required|string|min:3|max:200',
            'description' => 'required|string|min:3|max:500',
        ]);
        if (!$validator->fails()) {
            $post = new Post();
            $post->title = $request->get('title');
            $post->description = $request->get('description');
            $post->user_id = Auth::user()->id;
            $isSaved = $post->save();
            return response()->json(
                [
                    'message' => $isSaved ? 'Saved successfully' : 'Failed to save'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'status' => true,
            'data' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator($request->all(), [
            'title' => 'required|string|min:3|max:200',
            'description' => 'required|string|min:3|max:500',
        ]);
        if (!$validator->fails()) {
            $post->title = $request->get('title');
            $post->description = $request->get('description');
            $post->user_id = Auth::user()->id;
            $isSaved = $post->save();
            return response()->json(
                [
                    'message' => $isSaved ? 'Saved successfully' : 'Failed to save'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $isDeleted = $post->delete();
        return response()->json(
            [
                'message' => $isDeleted ? 'Deleted successfully' : 'Failed to delete'
            ],
            $isDeleted ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
        );
    }
}
