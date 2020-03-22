
@extends('content.layout')

@section('content')
    @include('fixed.admin-menu')

    <div class="mb-5 col-12 text-center">
        <h3>Top 10 komentara</h3>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <div class="col-xl-9  col-md-12 d-flex flex-wrap justify-content-center">


                @foreach($comments as $item)
                    <span class="col-12 col-md-6 pl-1 pr-1">
                         <div class="position-relative  rounded comment-box d-flex border-primary border">
                        <div class="col-3 d-flex text-center justify-content-start align-items-center flex-column">
                            <img src="
                            @if(isset($item->image_url))
                            {{asset('/images/avatars/' . $item->image_url)}}
                            @else
                            {{asset('/images/avatar.jpg')}}
                            @endif" alt="avatar" class="image-avatar">
                            <span>{{$item->username}}  </span>
                            <span class="d-flex justify-content-center flex-column align-items-center">
                                    <i class="heart-item fa fa-heart heart-red"  data-id="a" aria-hidden="true"></i>
                                    <p class="count-comment-likes" id="count-comment-likes">{{$item->numberLikes}}</p>
                                </span>
                        </div>
                        <div class="col-9 ">
                            <p> {{$item->desc}} </p>
                        </div>
                             <div class="position-absolute post-btn">
                                 <a href="/blog/{{$item->id}}" class="btn btn-info ">
                                  <i class="fa fa-search" aria-hidden="true"></i>

                                </a>
                             </div>
                    </div>
                    </span>

                @endforeach

        </div>
    </div>

@endsection

@section('script')
    <script src="{{url('js/dashboard.js')}}"></script>
@endsection

