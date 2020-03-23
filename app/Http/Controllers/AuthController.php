<?php

namespace App\Http\Controllers;

use App\Dto\ContactDto;
use App\Dto\RegisterDto;
use App\Exceptions\NotActiveException;
use App\Exceptions\NotVerifyException;
use App\Exceptions\PasswordNotException;
use App\Exceptions\VerifyException;
use App\Http\Requests\ChangeRoleRequest;
use App\Http\Requests\ChangeUsernameRequest;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\DownloadActivitiesRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\FileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\RegistartionRequest;
use App\Notifications\ContactNotify;
use App\Notifications\ResetPassword;
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
            return redirect('/verify')->with(['error' => 'Verifikacioni link istekao, unesite ispod Vaš email i pokušajte ponovo']);

        $email = $request->all()['data'];

        try {
            $this->userService->verify($email);
            return redirect('/result')->with(['error' => 'Korisnik uspešno verifikovan','show_button'=> true]);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());

            return redirect('/result')->with(['error' => 'Korisnik ne postoji ili je vec verifikovan']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/result')->with(['error' => 'Došlo je do greške']);
        }
    }

    public function registration(RegistartionRequest $request)
    {
        $data = $request->validated();
        try {

            $user = $this->userService->register(new RegisterDto([
                'username' => $data['username'],
                'email' =>  $data['email'],
                'password' => $data['password']
            ]));

            $user->notify((new VerifyNofify($user->email))->delay(now()->addSeconds(4)));
            $user->assignRole('user');
            return redirect('/login')->with(['error' => 'Verifikujte Vaš nalog']);

        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error' => 'Korisnik već postoji']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error' => 'Došlo je do greške']);
        }
    }

    public function againVerify(EmailRequest $request)
    {
        $data = $request->validated();
        try {
            $user = $this->userService->checkEmail($data['email']);
            $user->notify((new VerifyNofify($user->email))->delay(now()->addSeconds(50)));

            return redirect('/verify')->with(['error' => 'Verifikujte Vaš email']);
        }
        catch(ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Korisnik ne postoji']);
        }
        catch (VerifyException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Korisnik je već verifikovan']);
        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Došlo je do greške']);
        }

    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        try
        {
            $user = $this->userService->login($data['login_email'],$data['login_password']);

            auth()->login($user);
            return redirect('/');
        }
        catch(ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Podaci nisu tačni']);
        }
        catch (PasswordNotException $er)
        {
            Log::error($er->getMessage());
            return redirect('/login')->with(['error-login' => 'Podaci nisu tačni']);
        }
        catch (NotVerifyException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Verifikujte Vaš nalog']);
        }
        catch (NotActiveException $er)
        {
            Log::error($er->getMessage());
            return redirect('/verify')->with(['error' => 'Nalopg deaktiviran, ako želite opet da ga aktivirate verifikujte vaš nalog']);
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

    public function contact(ContactRequest $request)
    {
        $data = $request->validated();

        try {
            Notification::route('mail', env('MAIL_USERNAME'))
                ->notify((new ContactNotify(new ContactDto([
                    'title' => $data['title'],
                    'desc' => $data['desc'],
                    'email' => $data['email']
                ]))));
            return redirect('/contact')->with(['error' => 'Uspešno poslato']);

        }
        catch(Exception $er)
        {
            Log::error($er->getMessage());
            return redirect('/contact')->with(['error' => 'Došlo je do greške']);
        }
    }

    public function changeEmail(EmailRequest $request)
    {
        $data = $request->validated();

        try {
            $this->userService->changeEmail(auth()->user()->id, $data['email']);

            return redirect()->back()->with(['error-email' => 'Uspešno promenjeno, verifikujte nalog ponovo prilikom sledećeg logovanja']);
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
            return redirect()->back()->with(['error-email' => 'Došlo je do greške']);
        }
    }

    public function changeUsername(ChangeUsernameRequest $request)
    {
        $data = $request->validated();

        try {
            $this->userService->changeUsername(auth()->user()->id, $data['username']);
            return redirect()->back()->with(['error-uname' => 'Uspešno promenjeno']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Korisnik ne postoji']);
        }
        catch (\PDOException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Korisničko ime je zauzeto']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error-uname' => 'Došlo je do greške']);
        }
    }

    public function deactiveUser(Request $request)
    {

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
            return redirect()->back()->with(['error-uname' => 'Došlo je do greške']);
        }
    }


    public function changePassword(PasswordChangeRequest $request)
    {
        $data = $request->validated();

        try {
            $this->userService->changePassword($data['oldPass'], $data['newPass'], auth()->user()->id);
            return redirect()->back()->with(['password-error' => 'Lozinka promenjena']);
        }
        catch (PasswordNotException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['password-error' => 'Stara lozinka nije odgovarajuća']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['password-error' => 'Korisnik ne postoji']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['password-error' => 'Došlo je do greške']);
        }
    }

    public function changeImage(FileRequest $request)
    {
        $request->validated();

        $image = $request->file('file');

        try {
            $imageUrl = $this->userService->changeImage($image, auth()->user()->id);
            return response()->json(['url' => asset('/images/avatars/' . $imageUrl)],200);
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

    public function downloadActivities(DownloadActivitiesRequest $request)
    {
        $data = $request->validated();

        try {

            $activities = $this->userService->getActivitiesForDay($data['date']);

            return response()->streamDownload(function () use ($activities)
            {
                    echo $activities;
            },'activities.txt', [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=activities.txt',
            ]);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Greška sa pronalaženjem aktivnosti']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Došlo je do greške']);
        }
    }
    public function changeRole(ChangeRoleRequest $request)
    {
        $date = $request->validated();

        try {

            if($request->username == auth()->user()->username)
            {
                throw new Exception();
            }

            $this->userService->changeRole($date['username'],$date['role']);
            return redirect()->back()->with(['error' => 'Uspešno promenjeno']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Ne postoji korisnik']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Došlo je do greške']);
        }
    }

    public function sendResetPasswordLink(EmailRequest $request)
    {
        $data = $request->validated();

        try {
            $user = $this->userService->checkUser($data['email']);
            $user->notify((new ResetPassword($user->email))->delay(now()->addSeconds(4)));

            return redirect()->back()->with(['error' => 'Resetujte Vašu lozniku, posetite email']);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Ne postoji korisnik']);
        }
        catch (Exception $er)
        {
            Log::error($er->getMessage());
            return redirect()->back()->with(['error' => 'Došlo je do greške']);
        }
    }


}
