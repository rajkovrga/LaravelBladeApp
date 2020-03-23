@extends('content.layout')

@section('content')

    <div class="row d-flex verify justify-content-center">

        <div class="col-12 col-sm-5 col-md-4 text-center">

            <h2 id="verify-title">Resetovanje lozinke</h2>

            <form action="{{url('/reset/password')}}" class="col-12" method="POST">
                @csrf
                <div class="form-group">
                    <input id="email" name="email" type="text" class="form-control" placeholder="Email adresa">
                    @error('email')
                    <small id="emailHelp" class="form-text text-muted">{{ $message }}</small>
                    @enderror
                    @if(session('error'))
                        <small id="emailHelp" class="form-text text-muted">{{ session('error') }}</small>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Resetuj</button>
            </form>
        </div>

    </div>

@endsection
