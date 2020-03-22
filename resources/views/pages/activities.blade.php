
@extends('content.layout')

@section('content')

    @include('fixed.admin-menu')

    <div class="container bootstrap snippet">
        <div class="row">
                <h4>Uzimanje aktivnosti</h4>
        </div>

        <div class="row">
            <form action="/download/activities" method="post">
                @csrf
                <input class="form-control" type="date" name="date" id="date">
                <input type="submit" class="form-control" value="Preuzmi">
                @error('date')
                <p>{{$message}}</p>
                @enderror

                @if(session('error'))
                    <p>{{session('error')}}</p>
                    @endif

            </form>
        </div>
        <br>

        <div class="row text-center">
            <h4>Poslednjih 50 aktivnosti</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box no-header clearfix">
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table user-list">
                                <thead>
                                <tr >
                                    <th ><span>Ruta</span></th>
                                    <th><span>IP adresa</span></th>
                                    <th class="text-center"><span>Korisnik</span></th>
                                    <th class="text-center"><span>Datum</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activities as $item)
                                   <tr>
                                        <td class="activity-cell">
                                            <span class="user-subhead">
                                           {{$item->properties['method']}} :: {{$item->properties['path']}}
                                           </span>
                                        </td>
                                        <td>{{$item->properties['address']}}</td>
                                        <td class="text-center activity-cell">
                                        <span class="label label-default">
                                            @if(isset($item->properties['username']))
                                                {{$item->properties['username']}}
                                                @else
                                                Neautentifikovan
                                                @endif
                                        </span>
                                        </td>
                                        <td class="activity-cell text-center ">
                                            <span> {{$item->created_at}}</span>
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection


@section('script')
    <script src="{{url('js/dashboard.js')}}"></script>
@endsection
