<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Services\PostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function moreComments($id, $page)
    {
        try {
            $comments = $this->postService->comments($id,$page);
            return $comments;
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
        }

    }

    public function createComment(Request $request, $id)
    {
        $request->validate([
           'comment-area' => 'required|min:5'
        ]);

        if(!$request->session()->has('user'))
        {
            return redirect('/');
        }
        try {
            $this->postService->createComment($request->input('comment-area'),$request->session()->get('user')->id,$id);
            return redirect()->back();
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Korisnik ne postoji']);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
        }

    }

    public function like(Request $request)
    {
        if(!$request->session()->has('user'))
        {
            throw new AuthException('User not logged',403);
        }

        try {
            $numberLikes = $this->postService->like($request->input('id'),$request->session()->get('user')->id);
            return response()->json(['number' => $numberLikes],200);
        }
        catch (AuthException $er)
        {
            Log::error($er->getMessage());
            return response()->json(['message' => 'User not logged'],403);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json(['message' => $er->getMessage()],500);
        }



    }

    public function unlike(Request $request)
    {
        if(!$request->session()->has('user'))
        {
            throw new AuthException('User not logged',403);
        }

        try {
            $numberLikes = $this->postService->unlike($request->input('id'),$request->session()->get('user')->id);
            return response()->json(['number' => $numberLikes],200);
        }
        catch (AuthException $er)
        {
            Log::error($er->getMessage());
            return response()->json(['message' => 'User not logged'],403);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json(['message' => 'Error'],500);

        }
    }
}
