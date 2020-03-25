<?php

namespace App\Http\Controllers;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Builder;
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
            abort(403);
        }

        return view('pages.dashboard-insert-post');
    }

    public function topPost()
    {
        try {
            $top5 = $this->postService->top5posts();
            $top5in24 = $this->postService->top5postsNew();
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

        return view('pages.top5-posts')->with(['top5' => $top5,
            'top5in24' => $top5in24]);
    }

    public function topComment()
    {
        try {
            $comments = $this->postService->top10comments();
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

        return view('pages.top10comments')->with(['comments' => $comments]);
    }

    public function dashboardUsers(Request $request)
    {
        try {
            $users = $this->userService->dashboardUsers($request->get('page'));
            $roles = $this->userService->getRoles();
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
        return view('pages.dashboard-users')->with(['users' => $users, 'roles' => $roles]);
    }

    public function userActivities()
    {


        try {
            $activities = $this->userService->getActivities();
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
        return view('pages.activities')->with(['activities' => $activities]);
    }

    public function forgetPassword()
    {
        return view('pages.forget-password');
    }

    public function resetPassword(Request $request)
    {
        $token = (new Builder())->setIssuer('JWT Token')
                    ->setAudience('JWT Token')
                    ->setIssuedAt(time())
                    ->setExpiration(time() + 3600)
                    ->withClaim('email',$request->all()['email'])
                        ->getToken();


        return view('pages.reset-password', ['token' => $token]);
    }
}
