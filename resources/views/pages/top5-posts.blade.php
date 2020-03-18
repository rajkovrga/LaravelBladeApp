
@extends('content.layout')

@section('content')
    @include('fixed.admin-menu')

<div class="row d-flex justify-content-center">
    <div class="col-12 col-xl-8 d-flex justify-content-center flex-wrap">
        <div class="text-center col-md-6  col-11 col-sm-9 d-flex flex-column ">
            <h3>Top 5 objava</h3>
            <br>
            @foreach($top5 as $item)
            <a href="/blog/{{$item->id}}"  class="item item-blog d-flex justify-content-center m-1 mt-3">
            <span class="card bg-primary col-11 item-blog d-flex flex-column justify-content-between" >
                <div class="item-title text-left text-white">
                    <h4>{{$item->title}}</h4></h5>
                </div>
                <div class="item-title text-white text-left">
                    <p>{{$item->desc}}</p>
                </div>
                <div class="author text-white d-flex justify-content-between">
                    <h6>{{date('Y/m/d',strtotime($item->created_at))}}</h6>
                    <h6>{{$item->user->username}}</h6>
                </div>
            </span>

            </a>
            <span class="text-left ml-4">
                <h6>Broj lajkova: {{$item->likes_count}}</h6>
                <h6>Broj komentara: {{$item->comments_count}}</h6>
            </span>

            @endforeach
        </div>
        <div class="text-center  col-md-6  col-11 col-sm-9 d-flex flex-column">
            <h3>Najnovijih 5 objava</h3>
            <br>
            @foreach($top5in24 as $item)
                <a href="/blog/{{$item->id}}"  class="item item-blog d-flex justify-content-center m-1 mt-3">
            <span class="card bg-primary col-11 item-blog d-flex flex-column justify-content-between" >
                <div class="item-title text-left text-white">
                    <h4>{{$item->title}}</h4></h5>
                </div>
                <div class="item-title text-white text-left">
                    <p>{{$item->desc}}</p>
                </div>
                <div class="author text-white d-flex justify-content-between">
                    <h6>{{date('Y/m/d',strtotime($item->created_at))}}</h6>
                    <h6>{{$item->user->username}}</h6>
                </div>
            </span>

                </a>
                <span class="text-left ml-4">
                <h6>Broj lajkova: {{$item->likes_count}}</h6>
                <h6>Broj komentara: {{$item->comments_count}}</h6>
            </span>

            @endforeach
        </div>
    </div>

</div>

@endsection

@section('script')
    <script src="{{url('js/dashboard.js')}}"></script>
@endsection
