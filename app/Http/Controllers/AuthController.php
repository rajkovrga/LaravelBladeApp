<?php

namespace App\Http\Controllers;

use App\Dto\ContactDto;
use App\Dto\RegisterDto;
use App\Exceptions\NotActiveException;
use App\Exceptions\NotVerifyException;
use App\Exceptions\PasswordNotException;
use App\Exceptions\VerifyException;
use App\Http\Requests\PasswordChangeRequest;
use App\Notifications\ContactNotify;
use App\Notifications\VerifyNofify;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Mockery\Exception;

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
            return redirect('/result')->with(['error' => 'Korisnik uspesno verifikovan','show_button'=> true]);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());

            return redirect('/result')->with(['error' => 'Korisnik ne postoji ili je vec verifikovan']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/result')->with(['error' => 'Doslo je do greske']);
        }
    }

    public function registration(Request $request)
    {
        $request->validate([
            'username' => 'required|min:6|max:20',
            'password' => 'required|min:6',
            'email' => 'required|email'
        ]);

        try {

            $user = $this->userService->register(new RegisterDto([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]));

            $user->notify((new VerifyNofify($user->email))->delay(now()->addSeconds(4)));
            $user->assignRole('user');
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

            auth()->login($user);
            return redirect('/');
        }
        catch(ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Podaci nisu tacni']);
        }
        catch (PasswordNotException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Podaci nisu tacni']);
        }
        catch (NotVerifyException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Verifikujte Vas nalog']);
        }
        catch (NotActiveException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Nalopg deaktiviran, ako zelite opet da ga aktivirate verifikujte vas nalog']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Doslo je do greske']);
        }

    }

    public function logout(Request $request)
    {

        if(!auth()->check()) {
            throw new AuthorizationException();
        }

        try {
            if(auth()->check())
            {
                auth()->logout();
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

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if(!auth()->check()) {
            throw new AuthorizationException();
        }

        try {
            $this->userService->changeEmail(auth()->user()->id, $request->input('email'));

            return redirect()->back()->with(['error-email' => 'Uspesno promenjeno, verifikujte nalog ponovo prilikom sledeceg logovanja']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-email' => 'Korisnik ne postoji']);
        }
        catch (\PDOException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-email' => 'Email je zauzet']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-email' => 'Doslo je do greske']);
        }
    }

    public function changeUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|min:6|max:20'
        ]);

        if(!auth()->check()) {
            throw new AuthorizationException();
        }

        try {
            $this->userService->changeUsername(auth()->user()->id, $request->input('username'));
            return redirect()->back()->with(['error-uname' => 'Uspesno promenjeno']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Korisnik ne postoji']);
        }
        catch (\PDOException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Korisnicko ime je zauzeto']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Doslo je do greske']);
        }
    }

    public function deactiveUser(Request $request)
    {

        if(!auth()->check()) {
            throw new AuthorizationException();
        }

        try {
            $this->userService->deactiveUser(auth()->user()->id);
            auth()->logout();
            return redirect('/login')->with(['error-login' => 'Nalog deaktiviran']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Korisnik ne postoji']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Doslo je do greske']);
        }
    }


    public function changePassword(PasswordChangeRequest $request)
    {
        $data = $request->validated();

        if(!auth()->check()) {
            throw new AuthorizationException();
        }

        try {
            $this->userService->changePassword($data['oldPass'], $data['newPass'], auth()->user()->id);
            return redirect()->back()->with(['password-error' => 'Lozinka promenjena']);
        }
        catch (PasswordNotException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['password-error' => 'Stara lozinka nije odgovarajuca']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['password-error' => 'Korisnik ne postoji']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['password-error' => 'Doslo je do greske']);
        }
    }

    public function changeImage(Request $request)
    {
        $request->validate([
            'file' => 'file|mimes:png,gif,jpg,jpeg|max:3000'
        ]);

        if(!auth()->check()) {
            throw new AuthorizationException();
        }
        $image = $request->file('file');

        try {
            $imageUrl = $this->userService->changeImage($image, auth()->user()->id);
            return response()->json(['url' => $imageUrl],200);
        }
        catch (FileNotFoundException $er)
        {
            Log::error($er->getMessage());
            return response()->json(['message' => 'File not saved'],400);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json(['message' => 'Error'],500);
        }
    }
}
