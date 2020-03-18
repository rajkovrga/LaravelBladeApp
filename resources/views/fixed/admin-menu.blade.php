@section('style')
    <link rel="stylesheet" href="{{url('css/dashboard-menu.css')}}">
@endsection


<div id="menu" class="page-wrapper chiller-theme position-fixed ">
    <a id="show-sidebar" class="btn btn-sm btn-dark w-auto align-items-center justify-content-between d-flex" href="#">
       <span id="title-menu">Admin meni</span> <i class="fa fa-bars" aria-hidden="true"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="/dashboard">ADMIN PANEL</a>
                <div id="close-sidebar">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-pic">
                    <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                         alt="User picture">
                </div>
                <div class="user-info">

          <span class="user-name"><b>{{auth()->user()->username}}</b>
          </span>
                    <span class="user-name">{{auth()->user()->email}}
          </span>
                    <span class="user-role">{{auth()->user()->roles()->pluck('name')[0]}}</span>

                </div>
            </div>
            <!-- sidebar-header  -->

            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Sadrzajni deo</span>
                    </li>
                    <li>
                        <a href="/dashboard/insert">
                            <i class="far fa-gem"></i>
                            <span>Dodaj post</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/top/posts">
                            <i class="far fa-gem"></i>
                            <span>Top 5 objava</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/top/comments">
                            <i class="far fa-gem"></i>
                            <span>Top 10 komentara</span>
                        </a>
                    </li>
                    <li class="header-menu">
                        <span>Korisnicki deo</span>
                    </li>
                    <li>
                        <a href="/dashboard/users">
                            <i class="far fa-gem"></i>
                            <span>Prikaz korisnika</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
        <!-- sidebar-content  -->
        <div class="sidebar-footer d-flex justify-content-center">
            <label>Dashboard 2020 &copy;</label>
        </div>
    </nav>

</div>
