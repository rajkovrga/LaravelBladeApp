@extends('content.layout')

@section('content')
    <div class="col-12 text-center">
        <h3>Postavljena pitanja</h3>
    </div>

    <div class="d-flex flex-wrap items justify-content-center">


        @foreach($items as $item)
        <a href="/blog/{{$item->id}}"  class="item item-blog col-md-6 col-11 ">
            <span class="card bg-primary item-blog d-flex flex-column justify-content-between" >
                <div class="item-title text-white">
                    <h4>{{$item->title}}</h4></h5>
                </div>
                <div class="item-title text-white">
                    <p> {{$item->desc}} </p>
                </div>
                <div class="author text-white d-flex justify-content-between">
                    <h6>{{date('Y/m/d',strtotime($item->created_at))}}</h6>
                    <h6>{{$item->user->username}}</h6>
                </div>
            </span>
        </a>
        @endforeach

    </div>
    <div class="d-flex justify-content-center" id="pagination">
        {{ $items->links()  }}
    </div>

@endsection





