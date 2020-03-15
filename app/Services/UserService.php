<?php


namespace App\Services;

use App\Dto\RegisterDto;
use App\Exceptions\NotActiveException;
use App\Exceptions\NotVerifyException;
use App\Exceptions\PasswordNotException;
use App\Exceptions\VerifyException;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;

class UserService
{
    private $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function register(RegisterDto $registerDto)
    {
        $user = new User([
            'username' => $registerDto->username,
            'password' => bcrypt($registerDto->password),
            'email' => $registerDto->email
        ]);

        $user->saveOrFail();
        return $user;
    }

    public function checkEmail($email)
    {
        $user = User::query()->where('email','=',$email)->whereNull('email_verified_at')->firstOrFail();

        if($user->email_verified_at != null ){
            throw new VerifyException('Email verified');
        }

        return $user;
    }

    public function verify(string $email)
    {
        $user = User::query()->where('email','=',$email)->whereNull('email_verified_at')->firstOrFail();

        $user->email_verified_at = now();

        if(!$user->active)
        {
            $user->active = true;
        }

        $user->saveOrFail();

        return $user;
    }

    public function login(string $email, string $password)
    {
        $user = User::query()->where('email',$email)->firstOrFail();

        if($user->email_verified_at == null){
            throw new NotVerifyException("User not verified");
        }

        if(!$user->active)
        {
            throw new NotActiveException("User not active");
        }

        if(!$this->hasher->check($password,$user->password)){
            throw new PasswordNotException();
        }

        return $user;
    }

    public function changeUsername($id, $username)
    {
        $user = User::query()->findOrFail($id);

        $user->username = $username;

        $user->saveOrFail();
    }

    public function changeEmail($id, $email)
    {
        $user = User::query()->findOrFail($id);

        $user->email = $email;
        $user->email_verified_at = null;

        $user->saveOrFail();
    }

    public function deactiveUser($id)
    {
        $user = User::query()->findOrFail($id);

        $user->email_verified_at = null;
        $user->active = false;

        $user->saveOrFail();
    }

    public function changePassword($oldPassword, $newPassword, $id)
    {
        $user = User::query()->findOrFail($id);

        if(!$this->hasher->check($oldPassword, $user->password))
        {
            throw new PasswordNotException("Password is not good");
        }

        $user->password = bcrypt($newPassword);

        $user->saveOrFail();
    }

}
