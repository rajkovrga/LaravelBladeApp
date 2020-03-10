@extends('content.layout')

@section('content')

    <div class="row d-flex verify justify-content-center">

        <div class="col-12 col-sm-5 col-md-4 text-center">

            <h2 id="verify-title">Verifikacija naloga</h2>

            <p>
                @if(session('error'))
                    {{session('error')}}
                @endif
            </p>

            <form action="{{url('/verify/again')}}" class="col-12" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input id="email" name="email" type="text" class="form-control" placeholder="Email adresa">
                    @error('email')
                        <small id="emailHelp" class="form-text text-muted">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Verifikuj</button>

            </form>
        </div>

    </div>

    @endsection
