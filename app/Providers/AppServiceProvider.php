<?php

namespace App\Providers;

use App\Rules\JwtRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('jwt',function ($attribute, $value, $parameters, $validator) {
            return $this->validateToken($value);
        });
    }

    function validateToken($myToken) {
        try {
            $token = (new Parser())->parse($myToken);
        } catch (\Exception $exception) {
            return false;
        }

        $validationData = new ValidationData();
        $validationData->setIssuer('JWT Token');
        $validationData->setAudience('JWT Token');

        return $token->validate($validationData);
    }


}
