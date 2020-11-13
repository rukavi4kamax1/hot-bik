@extends('main')

@section('content')
    <section id="catalog">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-12" style="margin: 50px 0">
                            <h1 style="margin: 0">{{ $page->title }}</h1>
                            <div class="subdirectories">
                                @foreach($subcategories as $item)
                                    <a href="{{ route("page", [ "id" => $item->id ]) }}">{{ $item->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @foreach($pages as $row)
                        <div class="row justify-content-between">
                            @foreach($row as $item)
                                <div class="col-lg-6 item">
                                    <div class="d-flex flex-column flex-lg-column-reverse">
                                        <h2>{{ $item->title }}</h2>
                                        <img src="{{ asset("storage/images/".$item->images[0]) }}">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p style="margin-bottom: 0px; text-overflow: ellipsis;">
                                            Бренд: {{ $item->brand }}<br/>
                                            Код товару: {{ $item->id }}<br/>
                                            Опис: {{ mb_strimwidth($item->description, 0, 200, "...") }}
                                        </p>
                                        <div class="row">
                                            <div class="col-xl-8 d-flex flex-row justify-content-lg-between justify-content-around align-items-baseline">
                                                <p class="price">Ціна: {{ $item->price }} грн</p>
                                                <a href="{{ route("page", [ "id" => $item->id ]) }}">Купити </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
            </div>
        </div>
    </section>
@endsection
