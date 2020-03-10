

@extends('content.layout')

@section('content')


<div class="row auth-page d-flex flex-wrap justify-content-around">
    <div class="col-10 col-sm-5">
        <div class="text-center">
            <h3>Logovanje</h3>
        </div>
        <form method="POST" action="{{url('/login')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="exampleInputEmail1">Email adresa</label>

                <input id="login_email" name="login_email"  type="email" class="form-control" aria-describedby="emailHelp" placeholder="Email">
                @error('login_email')
                <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Lozinka</label>
                <input id="login_password" name="login_password" type="password" class="form-control" placeholder="Lozinka">
                @error('login_password')
                <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                @enderror

                <small id="emailHelp" class="form-text text-muted">
                    @if(session('error-login'))
                        {{ session('error-login') }}
                    @endif
                </small>
            </div>

            <button type="submit" class="btn btn-primary">Uloguj se</button>
        </form>
    </div>
    <div class="col-10 col-sm-5">
        <div class="text-center">
            <h3>Registracija</h3>
        </div>
        <form action="{{url("/register")}}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="exampleInputEmail1">Korisnicko ime</label>
                <input id="username" name="username" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Korisnicko ime">
                @error('username')
                <small id="emailHelp" class="form-text text-muted"> {{$message}} </small>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email adresa</label>
                <input id="email" type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Email adresa">
                @error('email')
                <small id="emailHelp" class="form-text text-muted">Email adresa nije odgovarajuca</small>
                @enderror                 </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Lozinka</label>
                <input id="password" type="password"  name="password" class="form-control" placeholder="Lozinka">
                @error('password')
                <small id="emailHelp" class="form-text text-muted">Lozinka nije odgovarajuca</small>
                @enderror

                <small id="emailHelp" class="form-text text-muted">
                    @if(session('error'))
                        {{ session('error') }}
                    @endif
                </small>

            </div>
            <button type="submit" name="registration" class="btn btn-primary">Registruj se</button>
        </form>
    </div>


</div>
@endsection
