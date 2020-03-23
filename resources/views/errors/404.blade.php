@extends('content.layout')

@section('content')

    <div class="row d-flex verify justify-content-center">

        <div class="col-12 col-sm-5 col-md-4 d-flex justify-content-center flex-column align-items-center text-center">



            <img src="{{url('images/not-found.gif')}}" alt="not found" id="notfound-img"/>
            <h3>
                Stranica ne postoji
            </h3>
        </div>

    </div>

@endsection
