<?php

namespace App\Http\Controllers;
use App\Exceptions\AuthException;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Session;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class FrontController extends Controller
{

    private $postService;
    private $userService;

    public function __construct(PostService $postService, UserService $userService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
    }

    public function home()
    {
        return view('pages.home');
    }

    public function login()
    {
        if(auth()->check())
            return redirect('/');

        return view('pages.auth');
    }

    public function blog(Request $request)
    {
        try {
            $content = $this->postService->paginate($request->get('page'));

           if(count($content) == 0)
           {
               abort(404);
           }
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            abort(500);
        }


        return view('pages.blog')->with(['items' => $content]);
    }

    public function verifyAccount()
    {
        if(auth()->check())
        {
            abort(404);
        }
        return view('pages.againverify');
    }

    public function result()
    {
        if(!(session('error') || session('result')))
        {
            abort(404);
        }

        return view('pages.result');
    }

    public function forbidden()
    {
        return view('pages.forbidden');
    }

    public function contact()
    {
        return view('pages.contact');
    }


    public function post(Request $request, $id)
    {
        $userId = null;
        if(auth()->check())
        {
            $userId = auth()->user()->id;
        }

        try {
            $data = $this->postService->find($id, $userId);
            $comments = $this->postService->comments($id,$userId,1);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            abort(404);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            abort(500);
        }

        return view('pages.post')
            ->with(['data' => $data,
                'comments' => $comments,
                'user_id' => $userId]);
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function dashboard()
    {

        return view('pages.dashboard');
    }

    public function insertPostDashboard()
    {
        if(!auth()->user()->can('add-post'))
        {
            throw new AuthException();
        }

        return view('pages.dashboard-insert-post');
    }

    public function notfound()
    {
        return view('pages.notfound');
    }

    public function topPost()
    {
        return view('pages.top5-posts')->with(['top5' => $this->postService->top5posts(),
            'top5in24' => $this->postService->top5postsNew()]);
    }

    public function topComment()
    {

        return view('pages.top10comments')->with(['comments' => $this->postService->top10comments()]);
    }

    public function dashboardUsers(Request $request)
    {
        activity()->log('user');
        return view('pages.dashboard-users')->with(['users' => $this->userService->dashboardUsers($request->get('page'))]);
    }

    public function userActivities()
    {

    }
}
