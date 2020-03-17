
@extends('content.layout')


@section('content')



    <div class="row " id="home-page">

        <span>
<div class="row title-carousel">
    <div class="text-center">
        <h3>Sajt pitanja i odgovora</h3>
        <h4>Dobrodosli</h4>
    </div>
</div>

        <!--Carousel Wrapper-->
<div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">
    <!--Indicators-->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-1z" data-slide-to="0"  class="active"></li>
      <li data-target="#carousel-example-1z" data-slide-to="1"></li>
    </ol>
    <!--/.Indicators-->
    <!--Slides-->
    <div class="carousel-inner " role="listbox">

      <!--Second slide-->
      <div class="carousel-item active">
        <img class=" w-100" src="images/slide1.jpg"
          alt="Second slide">
      </div>
      <!--/Second slide-->
      <!--Third slide-->
      <div class="carousel-item">
        <img class=" w-100"  src="images/slide2.jpg"
          alt="Third slide">
      </div>
      <!--/Third slide-->
    </div>
    <!--/.Slides-->
    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <!--/.Controls-->
  </div>
  <!--/.Carousel Wrapper-->
    </div>

</span>

<div class="row">
    <div class="col-12 desc-home text-center">
        <h2>Zelite da naucite nove stvari?</h2>
        <p>Na pravom ste mestu</p>
        <p>Procitajte najnovije odgovore na najpoznatija pitanja koja su oduvek mnogima bila nedoumica</p>
        <div class="col-12 d-flex justify-content-center">
            <a href="/blog" class="btn btn-primary btn-md" role="button" aria-disabled="true">Pogledati</a>
        </div>
    </div>
</div>
<blockquote class="wp-block-quote"><p>
    Everybody wants to be famous, but nobody wants to do the work. I live by that. You grind hard so you can play hard. At the end of the day, you put all the work in, and eventually it’ll pay off. It could be in a year, it could be in 30 years. Eventually, your hard work will pay off. </p><cite> Kevin Hart</cite></blockquote>

@endsection
