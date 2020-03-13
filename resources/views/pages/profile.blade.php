@extends('content.layout')

@section('content')

    <div class="col-12 text-center flex-column d-flex align-items-center">

        <h3>Profil korisnika</h3>

        <img src="{{url('images/avatar.jpg')}}" alt="avatar user" id="avatar">
        <p>Korisnicko ime:</p>

        <div class="d-flex h-auto justify-content-start align-items-center">
            <span>
                <h5 id="uname-content">korisnicko.ime</h5>
                <div id="form-uname">
                    @csrf
                     <form id="form" class="d-flex ">
                     <input value="korisnicko.ime"  class="form-control" type="text" name="uname" id="uname">
                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </form>

                </div>

            </span>

            <button id="edit-uname" class="edit btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
        </div>
        @if(session('uname'))
           <label>{{session('uname')}}</label>
        @endif
        @error('uname-error')
          <label>{{$message}}</label>
        @enderror
        <br>

        <p>Email:</p>
        <div class="d-flex h-auto justify-content-start align-items-center">
            <span>
                <h5 id="email-content">enauk@email.com</h5>
                <div id="form-email">
                    @csrf
                     <form id="form" class="d-flex ">
                     <input value="enauk@email.com" class="form-control" type="text" name="email" id="email">
                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </form>

                </div>
            </span>
            <button id="edit-email" class="edit btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
        </div>
        @if(session('email'))
            <label>{{session('email')}}</label>
        @endif
        @error('email-error')
        <label>{{$message}}</label>
        @enderror
        <br>

        <p>Kreiran:</p>
        <h5>20.06.1998</h5>
        <br>

        <button class="btn btn-primary">Promeni lozinku</button>

        <br>

        <button class="btn btn-primary">Obrisi nalog</button>
    </div>


@endsection

@section('script')

    <script src="{{url('js/profile.js')}}"></script>

    @endsection
