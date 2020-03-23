<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use App\Services\PostService;
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

    public function moreComments(Request $request,$id, $page)
    {

        $userId = null;
        if(auth()->check())
        {
            $userId = auth()->user()->id;
        }

        try {
            $comments = $this->postService->comments($id,$userId,$page);
            return $comments;
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
        }

    }

    public function createComment(CreateCommentRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $this->postService->createComment($data['comment-area'],auth()->user()->id,$id);
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
        try {
            $numberLikes = $this->postService->like($request->input('id'),auth()->user()->id);
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
        try {
            $numberLikes = $this->postService->unlike($request->input('id'),auth()->user()->id);
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

    public function likeComment(Request $request)
    {

        try {
            $numberLikes = $this->postService->likeComment($request->input('id'),auth()->user()->id, $request->input('postId'));
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
            return response()->json(['message' => 'Error' . $er->getMessage()],500);
        }
    }

    public function unlikeComment(Request $request)
    {
        try {
            $numberLikes = $this->postService->unlikeComment($request->input('id'),auth()->user()->id, $request->input('postId'));
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

    public function edit(EditPostRequest $request, $id)
    {
        $data = $request->validated();
        try {

            $this->postService->edit($id,$data['title'],$data['desc']);
            return redirect()->back();
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with([
                'error' => 'Ne postoji ovaj post'
            ]);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with([
                'error' => 'Došlo je do greške, izmena nije uspela'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $this->postService->delete($id);
            return redirect('/result')->with([
                'result' => 'Uspešno obrisano'
            ]);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/result')->with([
                'error' => 'Ne postoji ovaj post'
            ]);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/result')->with([
                'error' => 'Došlo je do greške, brisanje nije uspelo'
            ]);
        }
    }

    public function create(CreatePostRequest $request)
        {
            $data = $request->validated();

            try {
                $post = $this->postService->create($data['title'], $data['desc'],auth()->user()->id);

                return redirect('/blog/' . $post->id);
            }
            catch (\PDOException $er)
            {
                Log::error($er->getMessage());
                return redirect()->back()->with([
                    'error' => 'Upis nije uspeo'
                ]);
            }
            catch (\Exception $er)
            {
                Log::error($er->getMessage());
                return redirect()->back()->with([
                    'error' => 'Došlo je do greške, kreiranje nije uspelo'
                ]);
            }
        }

}
