<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link rel = "stylesheet" href = "{{ asset("public/assets/styles.css") }}">
    <link rel = "stylesheet" href = "{{ asset("public/assets/additional.css") }}">
    <link rel = "stylesheet" href = "{{ asset("public/assets/bootstrap-grid.css") }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row">
                    <div class="col-12 logo_menu_block">
                        <img class="logo" src="{{ asset("public/assets/images/logo.png") }}">
                        <div class="navigation">
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="#">{{ $category->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 search_row">
                        <div class="search_button">
                            <a href="#">Пошук велосипедів, аксесуарів...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-5">
                        <div class="map">
                            <iframe width="100%" height="450" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;coord=50.345507, 30.277370&amp;q=HotBike%2C%20%D0%B2%D1%83%D0%BB%D0%B8%D1%86%D1%8F%20%D0%91%D1%96%D0%BB%D0%BE%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D1%81%D1%8C%D0%BA%D0%B0%2C%2051%2C%20%D0%91%D0%BE%D1%8F%D1%80%D0%BA%D0%B0%2C%20%D0%9A%D0%B8%D0%B5%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%2C%20%D0%A3%D0%BA%D1%80%D0%B0%D0%B8%D0%BD%D0%B0+(HotBike)&amp;ie=UTF8&amp;t=&amp;z=17&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row contacts">
                            <div class="col-lg-6">
                                <h3>Контакти</h3>
                                <div class="contact">+38‎(099) 361-95-33<br>+38(‎067) 701-00-99</div>
                            </div>
                            <div class="col-lg-6">
                                <h3>Пошта</h3>
                                <div class="contact">explorer0155@gmail.com</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p>Ми знаходимось за адресою: місто Боярка, вул. Білогородська 51</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 soc_icons">
                                <a href="#"> <img src="{{ asset("public/assets/images/google.svg") }}"></a>
                                <a href="#"> <img src="{{ asset("public/assets/images/insta.svg") }}"></a>
                                <a href="#"> <img src="{{ asset("public/assets/images/facebook.svg") }}"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 copyright">
                        <p>2017 - 2020   HotBike <br> Всі права захищені</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
