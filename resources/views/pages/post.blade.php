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

            <div class=" col-12 col col-xl-5 col-md-5 d-flex justify-content-end ">
                @if(auth()->check())
                @if(auth()->user()->can('update-post'))
                    <form action="/delete/{{$data->id}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger text-white">Obrisi</button>
                    </form>
                 @endif

                @if(auth()->user()->can('delete-post'))
                    <a  class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModalCenter">Izmeni</a>
                @endif
                    @endif
            </div>

            @if(session('error'))
            <p class="text-center">{{session('error')}}</p>
            @endif
            @if(auth()->check())
            @if(auth()->user()->can('update-post'))
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Izmena objave</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="/post/update/{{$data->id}}">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Naslov</label>
                                        <input id="email" type="text" value="{{$data->title}}" name="title" class="form-control" aria-describedby="titleHelp" placeholder="Naslov objave">
                                        @error('desc')
                                        <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                                        @enderror

                                        <small id="emailHelp" class="form-text text-muted">
                                            @if(session('error'))
                                                {{ session('error') }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Opis objave</label>
                                        <textarea id="desc" rows="4"  name="desc" class="form-control" placeholder="Poruka">{{$data->desc}}</textarea>
                                        @error('desc')
                                        <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                                        @enderror

                                        <small id="emailHelp" class="form-text text-muted">
                                            @if(session('error'))
                                                {{ session('error') }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" name="edit" class="btn btn-secondary" data-dismiss="modal">Izadji</button>
                                        <button type="submit" class="btn btn-primary">Izmeni</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endif
            @endif
            <br>
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
                    @if(auth()->check())
                    <div class="col-12 form-group">
                        <form method="POST" action="/create/comment/{{$data->id}}" class="col-12  d-flex align-items-end flex-column">
                            @csrf
                            <div class="col-12 text-left">
                                <label>Ostavite komentar:</label>
                            </div>
                            <textarea  class="form-control form-comment" name="comment-area" id="comment-area" rows="2"></textarea>
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
                        @if(!auth()->check())
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
                                 @if($item->user_liked != 0)
                                        heart-red
                                 @else
                                    heart-classic
                                  @endif

                                "  data-id="{{$item->id}}" aria-hidden="true"></i>
                                <p class="count-comment-likes" id="count-comment-likes">{{$item->numberLikes}}</p>
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
@section('script')
    <script src="{{url('js/script.js')}}"></script>
@endsection
