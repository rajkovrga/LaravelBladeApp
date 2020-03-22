@extends('content.layout')

@section('content')

    <div class="col-12 text-center flex-column d-flex align-items-center">

        <h3>Profil korisnika</h3>
        <form enctype="multipart/form-data" class="position-relative d-flex flex-column" id="avatar">
            <img src="
                    @if(isset(auth()->user()->image_url))
                    {{asset('/images/avatars/' . auth()->user()->image_url)}}
                    @else
                    {{asset('/images/avatar.jpg')}}
                    @endif
                "
                 id="image-avatar" class="rounded-circle w-100 h-100" alt="avatar user">
            <label for="image-input" id="edit-image" class="position-absolute rounded-circle btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></label>
            <input accept="image/*" class="d-none" type="file" name="image" id="image-input">
        </form>

      <b> <p id="error-image"></p> </b>

        <p>Korisnicko ime:</p>

        <form class="d-flex flex-column align-items-center" method="post" action="/change/username">
            @csrf
            <div class="d-flex h-auto justify-content-start align-items-center">
            <span>
                <h5 id="uname-content">{{auth()->user()->username}}</h5>
                <div id="form-uname">
                     <div id="form" class="d-flex ">
                     <input value="{{auth()->user()->username}}"  class="form-control" type="text" name="username" id="username">
                            <br>
                         <button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                     </div>
                </div>
            </span>
                <button id="edit-uname" type="button" class="edit btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            </div>
            @if(session('error-uname'))
                <label>{{session('error-uname')}}</label>
            @endif
            @error('username')
            <label>{{$message}}</label>
            @enderror
        </form>
        <br>

        <p>Email:</p>
        <form class="d-flex flex-column align-items-center" method="post" action="/change/email">
            @csrf
        <div class="d-flex h-auto justify-content-start align-items-center">
            <span>
                <h5 id="email-content">{{auth()->user()->email}}</h5>
                <div id="form-email">
                     <div id="form" class="d-flex ">
                            <input value="{{auth()->user()->email}}" class="form-control" type="text" name="email" id="email">
                            <br>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                     </div>
                </div>
            </span>
            <button id="edit-email" type="button" class="edit btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
        </div>
            @error('email')
            <label>{{$message}}</label>
            @enderror
            @if(session('error-email'))
                <label>{{session('error-email')}}</label>
            @endif
        </form>
        <br>



        <br>
        <p>Kreiran:</p>
        <h5>20.06.1998</h5>
        <br>


        <form action="/user/deactive" method="post">
            @csrf
            <button class="btn btn-primary">Deaktiviraj nalog</button>
        </form>
        <br>

        <p>Promena lozinke:</p>
        <div  id="form-password">
            <form method="post" action="/change/password" class="collapse d-flex flex-column align-items-center">
                @csrf
                <label for="oldPass">Stara lozinka</label>
                <input type="password" name="oldPass" id="oldPass" class="form-control">
                @if(session('oldPass-error'))
                    <small id="emailHelp" class="form-text text-muted">{{session('password-error')}}</small>
                    @enderror
                @error('oldPass')
                <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                @enderror
                <label for="newPass">Nova lozinka</label>
                <input type="password" name="newPass" id="newPass" class="form-control">
                @error('newPass')
                <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                @enderror
                <label for="newPassAgain">Ponovite lozinku</label>
                <input type="password" name="newPassAgain" id="newPassAgain" class="form-control">
                @error('newPassAgain')
                <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                @enderror
                <button type="submit" class="btn btn-primary">Promeniti</button>
                @if(session('password-error'))
                <small id="emailHelp" class="form-text text-muted">{{session('password-error')}}</small>
                @enderror
            </form>
        </div>
    </div>


@endsection

@section('script')

    <script src="{{url('js/profile.js')}}"></script>

    @endsection
