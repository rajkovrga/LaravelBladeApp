
    <nav class="col-12 navbar navbar-expand-lg main-navbar">
        <button class="navbar-toggler text-white" id="toggle" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <div class="mr-auto ">
                <a class="navbar-brand" href="#">Pitanja i odgovori</a>

            </div>
            <ul class="navbar-nav  my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/home">Pocetna <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/blog">Objave</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Kontakt</a>
                </li>
                @if(!auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Logovanje</a>
                    </li>
                @endif
                @if(auth()->check())
                    @if(auth()->user()->can('update-post'))
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Admin panel</a>
                        </li>
                        @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Odjavi se</a>
                    </li>
                @endif

            </ul>

        </div>
    </nav>
<div class="col-12 d-flex flex-column">
