<?php


namespace App\Services;

use App\Dto\RegisterDto;
use App\Exceptions\NotActiveException;
use App\Exceptions\NotVerifyException;
use App\Exceptions\PasswordNotException;
use App\Exceptions\VerifyException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class UserService
{
    private $hasher;
    private $imageManager;

    public function __construct(Hasher $hasher, ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
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

    public function changeImage($imageForUpload, $id)
    {
        $ext = $imageForUpload->extension();
        $user = User::query()->findOrFail($id);
        $old_image = $user->image_url;
        $path = $this->createName($ext, 'USER');
        $img = $this->imageManager->make($imageForUpload)->resize(250, 250);
        $img->stream();
        Storage::disk('local')->put($path, $img);
        if (! Storage::disk('local')->exists($path)) {
            throw new FileNotFoundException('File not saved', 400);
        }
        $user->image_url = $path;
        $user->saveOrFail();
        if ($old_image != null) {
            Storage::disk('local')->delete($old_image);
        }

        return $path;
    }

    public function createName(string $ext, string $type = 'HERBS')
    {
        return 'IMG'. $type . hash('sha384', Carbon::now()->toDateTimeString()) . '.' . $ext;
    }

    public function dashboardUsers($page = 1, $perPage = 10)
    {
        $users = User::query()->with('roles')->orderBy('created_at','desc')->paginate($perPage, ['*'], 'page',$page);
        return $users;
    }
}
