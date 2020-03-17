
@extends('content.layout')

@section('content')

    @include('fixed.admin-menu')


    <div class="col-12 dashboard-box d-flex text-center justify-content-center align-items-center flex-column">
        <h2>Admin panel</h2>
        <br>
        <div class="welcome-dsb col-xl-7 col-lg-6 col-md-8 col-sm-11 col-12">
            <img src="{{url('images/dashboard-home.png')}}" class="w-100" alt="dashboard main" >
        </div>
        <div class="col-xl-5 col-lg-7 col-md-6 col-sm-11 col-12">
            <h5>Postovani clanovi uredjivackog tima sajta pitanja i odgovori, ovo je deo sajta gde cete vi imati uvid na sva vazna desavanja na sajtu i gde cete moci da dodate nov i aktuelan sadrzaj</h5>

        </div>
    </div>


@endsection

@section('script')
    <script src="{{url('js/dashboard.js')}}"></script>
@endsection
