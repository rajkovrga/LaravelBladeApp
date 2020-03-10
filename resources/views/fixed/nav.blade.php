
<div class="col-12 d-flex flex-column justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <div class="mr-auto ">
                <a class="navbar-brand" href="#">Pitanja i odgovori</a>

            </div>
            <ul class="navbar-nav   my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/home">Pocetna <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/blog">Objave</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Kontakt</a>
                </li>
                @if(!session('user'))
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Logovanje</a>
                    </li>
                @endif
                @if(session('user'))
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
