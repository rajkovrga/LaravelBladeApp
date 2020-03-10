@extends('content.layout')

@section('content')


    <div class="row auth-page d-flex flex-wrap justify-content-center">

        <div class="col-10 col-sm-5">
            <div class="text-center">
                <h3>Kontakt</h3>
            </div>
            <form action="{{url("/contact")}}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="exampleInputEmail1">Naslov</label>
                    <input id="title" name="title" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Korisnicko ime">
                    @error('title')
                    <small id="emailHelp" class="form-text text-muted"> {{$message}} </small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email adresa</label>
                    <input id="email" type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Email adresa">
                    @error('email')
                    <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                    @enderror                 </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Poruka</label>
                    <textarea id="desc" rows="4"  type="password"  name="desc" class="form-control" placeholder="Poruka"></textarea>
                    @error('desc')
                    <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                    @enderror

                    <small id="emailHelp" class="form-text text-muted">
                        @if(session('error'))
                            {{ session('error') }}
                        @endif
                    </small>

                </div>
                <div class="d-flex justify-content-center w-100">
                <button type="submit" name="contact" class="btn btn-primary"> Posalji </button>
                </div>
            </form>
        </div>


    </div>

@endsection
