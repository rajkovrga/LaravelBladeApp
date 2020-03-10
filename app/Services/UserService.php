<?php


namespace App\Services;

use App\Dto\RegisterDto;
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
        $user = User::query()->where('email','=',$email)->firstOrFail();

        if($user->email_verified_at != null){
            throw new VerifyException('Email verified');
        }

        return $user;
    }

    public function verify(string $email)
    {
        $user = User::query()->where('email',$email)->where('email_verified_at','==',null)->firstOrFail();

        $user->email_verified_at = now();

        $user->saveOrFail();
    }

    public function login(string $email, string $password)
    {
        $user = User::query()->where('email',$email)->firstOrFail();

        if($user->email_verified_at == null){
            throw new NotVerifyException("User not verified");
        }

        if(!$this->hasher->check($password,$user->password)){
            throw new PasswordNotException();
        }

        return $user;
    }
}
