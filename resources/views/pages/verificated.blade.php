@extends('content.layout')

@section('content')

    <div class="row d-flex verify justify-content-center">

        <div class="col-12 col-sm-5 col-md-4 d-flex justify-content-center flex-column align-items-center text-center">


            <p>
                @if(session('error'))
                    {{session('error')}}

                @else

                    <script> window.location = "/"; </script>

                @endif
            </p>
            @if(session('show_button'))
                <a class="btn btn-primary" href="{{url('/login')}}">Uloguj se</a>
            @endif




        </div>

    </div>

@endsection
