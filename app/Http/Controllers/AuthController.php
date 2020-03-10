<?php

namespace App\Http\Controllers;

use App\Dto\ContactDto;
use App\Dto\RegisterDto;
use App\Exceptions\NotVerifyException;
use App\Exceptions\PasswordNotException;
use App\Exceptions\VerifyException;
use App\Notifications\ContactNotify;
use App\Notifications\VerifyNofify;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{

    private  $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function verify(Request $request)
    {
        if(!$request->hasValidSignature())
            return redirect('/verify')->with(['error' => 'Verifikacioni link istekao, unesite ispod Vas email i pokusajte ponovo']);

        $email = $request->all()['data'];

        try {
            $this->userService->verify($email);
            return redirect('/verified')->with(['error' => 'Korisnik uspesno verifikovan','show_button'=> true]);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verified')->with(['error' => 'Korisnik ne postoji ili je vec verifikovan']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/verified')->with(['error' => 'Doslo je do greske']);
        }
    }

    public function registration(Request $request)
    {
        $request->validate([
            'username' => 'required|min:6|max:20',
            'password' => 'required|min:6|max:14',
            'email' => 'required|email'
        ]);

        try {

            $user = $this->userService->register(new RegisterDto([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]));

            $user->notify((new VerifyNofify($user->email))->delay(now()->addSeconds(4)));

            return redirect('/login')->with(['error' => 'Verifikujte Vas nalog']);

        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error' => 'Korisnik vec postoji']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error' => 'Doslo je do greske']);
        }
    }

    public function againVerify(Request $request)
    {
        $request->validate([
            'email' => 'email'
        ]);

        try {
            $user = $this->userService->checkEmail($request->input('email'));
            $user->notify((new VerifyNofify($user->email))->delay(now()->addSeconds(50)));

            return redirect('/verify')->with(['error' => 'Verifikujte Vas email']);
        }
        catch(ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Korisnik ne postoji']);
        }
        catch (VerifyException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Korisnik je vec verifikovan']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Doslo je do greske']);
        }

    }

    public function login(Request $request)
    {
        $request->validate([
           'login_email' => 'required|email',
           'login_password' => 'required'
        ]);

        try
        {
            $user = $this->userService->login($request->input('login_email'),$request->input('login_password'));

            $request->session()->put('user',$user);
            return redirect('/');
        }
        catch(ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Podaci nisu tacni']);
        }
        catch (PasswordNotException $er)
        {
            return redirect('/login')->with(['error-login' => 'Podaci nisu tacni']);

        }
        catch (NotVerifyException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Verifikujte Vas nalog']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Doslo je do greske']);
        }

    }

    public function logout(Request $request)
    {
        try {
            if($request->session()->has('user'))
            {
                $request->session()->forget('user');
                $request->session()->flush();
            }
            return redirect('/login');
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/');
        }

    }

    public function contact(Request $request)
    {
        $request->validate([
            'desc' => 'required|min:10',
            'title' => 'required|min:4',
            'email' => 'required|email'
        ]);

        try {
            Notification::route('mail', env('MAIL_USERNAME'))
                ->notify((new ContactNotify(new ContactDto([
                    'title' => $request->input('title'),
                    'desc' => $request->input('desc'),
                    'email' => $request->input('email')
                ]))));
            return redirect('/contact')->with(['error' => 'Uspesno poslato']);

        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/contact')->with(['error' => 'Doslo je do greske']);
        }
    }

}
