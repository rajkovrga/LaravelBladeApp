
@extends('content.layout')

@section('content')

    @include('fixed.admin-menu')

    <div class="col-12 dashboard-box d-flex text-center justify-content-center align-items-center flex-column">
        <h2>Kreiranje objave</h2>
        <br>


        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-12 col-12 ">
            <form method="POST" action="/post/update/">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Naslov</label>
                        <input id="email" type="text" value="" name="title" class="form-control" aria-describedby="titleHelp" placeholder="Naslov objave">
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
                        <textarea id="desc" rows="4"  name="desc" class="form-control" placeholder="Poruka"></textarea>
                        @error('desc')
                        <small id="emailHelp" class="form-text text-muted">{{$message}}</small>
                        @enderror

                        <small id="emailHelp" class="form-text text-muted">
                            @if(session('error'))
                                {{ session('error') }}
                            @endif
                        </small>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" name="insert" class="btn btn-primary">Dodaj objavu</button>
                    </div>
                </div>
            </form>
        </div>


                </div>




@endsection

@section('script')
    <script src="{{url('js/dashboard.js')}}"></script>
@endsection
