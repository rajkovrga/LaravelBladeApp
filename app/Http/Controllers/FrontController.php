<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Session;

class FrontController extends Controller
{

    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function home()
    {
        return view('pages.home');
    }

    public function login()
    {
        if(session()->has('user'))
            return redirect('/');

        return view('pages.auth');
    }

    public function blog(Request $request)
    {
        return view('pages.blog')->with(['items' => $this->postService->paginate($request->get('page'))]);
    }

    public function verifyAccount()
    {
        return view('pages.againverify');
    }

    public function verified()
    {
        return view('pages.verificated');
    }

    public function contact()
    {
        return view('pages.contact');

    }

    public function post(Request $request, $id)
    {
        $userId = null;
        if($request->session()->has('user'))
        {
            $userId = $request->session()->get('user')->id;
        }

        return view('pages.post')
            ->with(['data' => $this->postService->find($id, $userId),
            'comments' => $this->postService->comments($id),
                'user_id' => $userId]);
    }

    public function profile()
    {

    }

    public function dashboard()
    {

    }
}
