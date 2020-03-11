@extends('content.layout')

@section('content')

        <div class="col-12 d-flex justify-content-center flex-column align-items-center">
            <div class="bg-primary post-content col-11 col col-xl-5 col-md-5 ">
                <h4>{{$data->title}}</h4>
                <p>{{$data->desc}}</p>
                <div class="col-12 d-flex justify-content-between">
                    <h6>{{date('Y/m/d',strtotime($data->created_at))}}</h6>
                    <h6>{{$data->user->username}}</h6>

                </div>
            </div>
            <div   class="border-primary border  col-12 col col-xl-5 col-md-5 d-flex justify-content-center align-items-center">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h6>Komentari: {{$data->comments_count}}</h6>
                    <h6>
                            <i class="fa fa-thumbs-up
                             @if($data->liked)
                                liked-button
                             @else
                              like-button
                            @endif

                        " id="like-button" data-id="{{$data->id}}" aria-hidden="true"></i> <span id="count-likes">{{$data->likes_count}}</span>
                    </h6>
                </div>
            </div>
            <div class="border-primary border col-12 col col-xl-5 col-md-5 d-flex flex-column justify-content-center align-items-center">
                <span id="comments" class="col-12">
                <div class=" col-12 comments">
                    @if(session('user'))
                    <div class="col-12 form-group">
                        <form method="POST" action="/create/comment/{{$data->id}}" class="col-12  d-flex align-items-end flex-column">
                            @csrf
                            <div class="col-12 text-left">
                                <label>Ostavite komentar:</label>
                            </div>
                            <textarea  class="form-control col-12" name="comment-area" id="comment-area" rows="2"></textarea>
                            @error('comment-area')
                <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                @enderror

                <small id="emailHelp" class="form-text text-muted">
                    @if(session('error'))
                        {{ session('error') }}
                    @endif
                </small>
                            <button type="submit" class="form-control btn btn-primary">Objavi</button>
                        </form>
                    </div>
                    @endif
                        @if(!session('user'))
                            <div id="login-redirect" class="col-12 border-bottom border-primary text-center d-flex align-items-center flex-column">
                        <p>Ulogujte se i ostavite komentar</p>
                        <a href="{{url('/login')}}" class="btn btn-primary">Uloguj se</a>
                    </div>
                        @endif

                    <span id="comment-items">


                    @foreach($comments as $item)
                    <div class="row comment-box">
                        <div class="col-3 d-flex text-center justify-content-start align-items-center flex-column">
                            <img src="{{url('images/' .$item->image_url)}}" alt="avatar" class="image-avatar">
                            <span>{{$item->username}}   </span>
                            <span class="d-flex justify-content-center flex-column align-items-center">
                                <i class="heart-item fa fa-heart
                                 @if($item->user_liked == $user_id)
                                        heart-red
                                 @else
                                    heart-classic
                                  @endif

                                "  data-id="{{$item->id}}" aria-hidden="true"></i>
                                <p id="count-comment-likes">{{$item->numberLikes}}</p>
                            </span>
                        </div>
                        <div class="col-9 ">
                            <p> {{$item->desc}} </p>
                        </div>
                    </div>
                    @endforeach

                    </span>
                </div>

                @if($comments->currentPage() != $comments->lastPage())
                    <div id="more-comments" data-page="{{$comments->currentPage()}}" data-id="{{$data->id}}" class="col-12 text-center border border-primary">
                    <p>Jos komentara</p>
                </div>
                    @endif

</span>
            </div>
        </div>




@endsection
