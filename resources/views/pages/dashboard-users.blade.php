@extends('content.layout')

@section('content')

    @include('fixed.admin-menu')

<div class="container bootstrap snippet">
    <div class="row">
        <h4>Izmena uloge</h4>
</div>

    <div class="row">
        <form action="/change/role" class="form-group" method="post">
            @csrf
            <label for="role">Korisnicko ime</label>
            <input type="text" name="username" class="form-control" id="username">
            @error('username')
            <p>{{$message}}</p>
            @enderror
            <label for="role">Uloga</label>
            <select class="form-control" name="role" id="role">
                <option value="0">Odaberite</option>
            @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
            @error('role')
            <p>{{$message}}</p>
            @enderror

            <input type="submit" class="form-control" value="Promeni">

            @if(session('error'))
                <p>{{session('error')}}</p>
            @endif

        </form>
    </div>
    <br>
    <div class="row">
        <h4>Korisnici</h4>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                            <tr>
                                <th ><span>Korisnik</span></th>
                                <th><span>Registrovan</span></th>
                                <th class="text-center"><span>Aktivan</span></th>
                                <th><span>Email</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <img src="https://bootdey.com/img/Content/user_1.jpg" alt="">
                                        <a href="#" class="user-link">{{$user->username}}</a>
                                        <span class="user-subhead">
                                            @if($user->roles->first()->name == 'user')
                                                Korisnik
                                                @elseif($user->roles->first()->name == 'admin')
                                                Administrator
                                            @endif
                                           </span>
                                    </td>
                                    <td>{{date('Y/m/d',strtotime($user->created_at))}}</td>
                                    <td class="text-center">
                                        <span class="label label-default">
                                            @if($user->active)
                                            Aktivan
                                                @else
                                                Neaktivan
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <a>{{$user->email}}</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                <span>
                    <label> {{$users->firstItem()}} - {{$users->lastItem()}} od {{$users->total()}}</label>
                </span>
                <span>

                   <a href="{{$users->previousPageUrl()}}"  class="@if($users->firstItem() == 1) d-none @endif btn border-dark"> < </a>
                    <a href="{{$users->nextPageUrl()}}" class="@if($users->lastItem() == $users->total()) d-none @endif btn border-dark"> > </a>
                    <a href="{{$users->url($users->lastPage())}}" class="btn border-dark"> Poslednja </a>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{url('js/dashboard.js')}}"></script>
@endsection


