@extends('main')

@section('content')
    <section id="info">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-12">
                            <h1>{{ $page->title }}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <img src="{{ asset("storage/images/".$page->images[0]) }}">
                            <div class="d-flex flex-row flex-wrap justify-content-center justify-content-lg-start sm-images">
                                @foreach($page->images as $image)
                                    <img src="{{ asset("storage/images/".$image) }}">
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-5 d-flex flex-column">
                            <div class="d-flex flex-row justify-content-center justify-content-lg-start">
                                <p class="mr-3">Бренд: {{ $page->brand }}</p>
                                <p>  Код товару: {{ $page->id }}</p>
                            </div>
                            <div class="row">
                                <div class="col-xl-11 pr-lg-0 d-flex flex-row justify-content-between align-items-baseline">
                                    <p class="price">Ціна: {{ $page->price }} грн</p>
                                    <a href="#">Купити </a>
                                </div>
                            </div>
                            <p>Гарантія: 2 роки</p>
                            <div class="d-flex flex-row flex-wrap justify-content-between align-items-center mt-3">
                                <div class="d-flex flex-row payment">
                                    <img src="{{ asset("public/assets/images/payment1.png") }}">
                                    <div class="d-flex flex-column">
                                        <p>Оплата частинами</p>
                                        <p class="grey">до 7 платежів - {{ (int)(intval($page->price) / 7) }} грн/міс</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-ro payment">
                                    <img src="{{ asset("public/assets/images/payment2.png") }}">
                                    <div class="d-flex flex-column">
                                        <p>Оплата частинами</p>
                                        <p class="grey">до 10 платежів - {{ (int)(intval($page->price) / 10) }} грн/міс</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="description">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2>Опис товару</h2>
                    <p class="mb-3">{{ $page->description }}</h2>
                    <h2>Характеристики</h2>
                    <div class="details">
                        {!! $page->stats !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
