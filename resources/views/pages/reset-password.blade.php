@extends('content.layout')

@section('content')

    <div class="row d-flex verify justify-content-center">

        <div class="col-12 col-sm-4 col-md-3 text-center">

            <h2 id="verify-title">Promena lozinke</h2>


                <form method="post" action="{{url('/reset/password/form')}}" class="collapse d-flex flex-column align-items-center">
                    @csrf
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
                    <br>
                        <button type="submit" class="btn btn-primary">Promeniti</button>
                        @if(session('password-error'))
                            <small id="emailHelp" class="form-text text-muted">{{session('password-error')}}</small>
                            @enderror
                </form>
        </div>

    </div>

@endsection
