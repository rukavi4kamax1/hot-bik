@extends('main')

@section('content')
    <style>
        .loaded-images {
            flex-direction: row-reverse;
        }
        .loaded-image {
            height: 100px;
            margin-left: 10px;
            cursor: pointer;
            flex-grow: 0 !important;
            padding: 0 !important;
            position: relative;
        }
        .loaded-image img {
            height: 100%;
        }
        .loaded-image .mask {
            position: absolute;
            display: none;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #1c1c1c;
            opacity: .5;
            border: 3px solid red;
        }
        .loaded-image.marked .mask {
            display: block;
        }
        .loaded-image .mask i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
    </style>

<section class="admin_section container-fluid">
    <div class="row justify-content-center">
        <div class="admin col-9">
            <div class="hotbike_tabs d-flex">
                <div class="tab " id="tab_button_directory" refers="#directory">Директорія</div>
                <div class="tab tab_active" id="tab_button_product" refers="#product">Товар</div>
                <div class="tab " id="tab_button_alias" refers="#alias">Аліас</div>
            </div>
            <div class="tab_content_wrapper">
                <div class="tab_content hidden" id="directory">
                    <form class="hotbike_form" id="directory_form" action="{{ route("create_dir") }}" method="post">
                        @csrf
                        <input type="text" name="pid" hidden value="{{ $pid }}">
                        <div class="field" id="id_field">
                            <label for="id">id</label>
                            <input required type="text" name="id" id="id">
                        </div>
                        <div class="field">
                            <label for="title">Назва</label>
                            <input type="text" name="title" id="title">
                        </div>
                        <div class="field">
                            <label for="sort_field">Сортувати за</label>
                            <select name="sort_field" id="sort_field">
                                <option value="title">Назвою</option>
                                <option value="created">Датою створення</option>
                                <option value="updated">Датою змінення</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="sort_order">Порядок сортування</label>
                            <select name="sort_order" id="sort_order">
                                <option value="desc">За спаданням</option>
                                <option value="asc">За зростанням</option>
                            </select>
                        </div>
                        <div class="field">
                            <button type="commit">Готово</button>
                        </div>
                    </form>
                </div>
                <div class="tab_content " id="product">
                    <form action="{{ route("create_prod") }}" method="post" class="product_form" id="product_form" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="pid" hidden value="{{ $pid }}">
                        <input type="text" hidden name="properties">
                        <div class="field" id="id_field">
                            <label for="id">Код товару</label>
                            <input type="text" required name="id" id="id">
                        </div>
                        <div class="field">
                            <label for="brand">Бренд</label>
                            <input type="text" name="brand" id="brand">
                        </div>
                        <div class="field">
                            <label for="title">Назва</label>
                            <input type="text" name="title" id="title">
                        </div>
                        <div class="field">
                            <label for="descr">Опис</label>
                            <textarea name="descr" id="descr" cols="30" rows="7"></textarea>
                        </div>
                        <div class="field">
                            <label for="price">Ціна</label>
                            <input type="text" name="price" id="price">
                        </div>
                        @if ($is_update)
                            <div class="field loaded-images">
                                @foreach($page->images as $image)
                                    <div class="loaded-image" image="{{ $image }}">
                                        <img src="{{ asset("storage/images/".$image) }}">
                                        <div class="mask"><i class="fas fa-trash-alt"></i></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-none images_to_delete_wrapper">
                            </div>
                            <script>
                                $(".loaded-image").click(function (){
                                    $(this).toggleClass("marked")
                                })
                                function countMarkedImages() {
                                    const images_to_delete_wrapper = $(".images_to_delete_wrapper")
                                    images_to_delete_wrapper.html('');
                                    $(".loaded-image.marked").each(function () {
                                        images_to_delete_wrapper.append($(`<input type="text" hidden value="${$(this).attr("image")}" name="images_to_delete[]">`))
                                    })
                                }
                            </script>
                        @endif
                        <div class="field">
                            <label for="">Зображення</label>
                            <input type="file" class="hotbike_image_select_field" multiple name="pictures[]" hidden="hidden" accept="image/*">
                            <button type="button" class="hotbike_image_select_button" default="Вибрати фото">Вибрати фото</button>
                            <script>
                                $(".hotbike_image_select_button").click(function (){
                                    $(".hotbike_image_select_field").click();
                                });
                                $(".hotbike_image_select_field").change(function() {
                                    button = $(this).parent().find("button")
                                    if ($(this).val() != '') {
                                        newname = "";
                                        for (i = 0; i < $(this)[0].files.length; i++) {
                                            newname = newname + " " + $(this)[0].files[i].name;
                                        }
                                        button.html(newname);
                                    }
                                    else button.html(button.attr('default'));
                                })
                            </script>
                        </div>
                        <div class="field">
                            <label for="">Характеристики</label>
                            <div class="table_creator">
                                <div class="head">Додати <input class="table_creator_add_fields_count" type="number" value="1"> поле(я)
                                    <button type="button" class="table_creator_add_fields">Вперед</button>
                                </div>
                                <table class="properties_table">
                                    <thead>
                                    <tr>
                                        <td class="properties_table_hrow">Характеристика</td>
                                        <td class="properties_table_hrow">Значення</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><input type="text" id="pname"></td>
                                        <td><input type="text" id="pval"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="pname"></td>
                                        <td><input type="text" id="pval"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="pname"></td>
                                        <td><input type="text" id="pval"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="pname"></td>
                                        <td><input type="text" id="pval"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <script>
                                    // ===============================================================================
                                    //  Додавання нових рядків в таблицю
                                    // ===============================================================================
                                    $(`.table_creator_add_fields`).click(function (){
                                        const count = $(".table_creator_add_fields_count").val();
                                        if (count != '') {
                                            const tbody = $(".properties_table").find("tbody");
                                            const maxi = parseInt(count, "10");
                                            for (let i = 0; i < maxi; i++) {
                                                tbody.append($(`<tr><td><input type="text" id="pname"></td><td><input type="text" id="pval"></td></tr>`));
                                            }
                                        }
                                    })
                                    // ===============================================================================
                                    //  Перетворення рядків в таблицю яка буде вставлення в сторінку з товаром
                                    // ===============================================================================
                                    function buildTable() {
                                        const tbody = $(".properties_table").find("tbody");
                                        var result = "";
                                        tbody.find("tr").each(function (){
                                            const pname = $(this).find("#pname").val();
                                            const pval = $(this).find("#pval").val();
                                            if (pname != "" && pval != "") result += `<div class="row">\n<div class="col-6">\n<b>${pname}</b>\n</div>\n<div class="col-6">\n<p>${pval}</p>\n</div>\n</div>\n<hr>\n\n`
                                        })
                                        return result;
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="field">
                            <button type="commit" class="product_commit">Готово</button>
                        </div>
                        <script>
                            // =======================================================================================
                            //  Формування списку характеристик перед відправкою форми
                            // =======================================================================================
                            $(".product_commit").click(function () {
                                $(".product_form").find("input[name='properties']").val(buildTable());
                                @if($is_update)countMarkedImages();@endif
                            })
                        </script>
                    </form>
                </div>
                <div class="tab_content hidden" id="alias">
                    <form action="{{ route("create_alias") }}" id="alias_form" method="post">
                        @csrf
                        <input type="text" name="pid" hidden value="{{ $pid }}">
                        @if($is_update)
                            <input type="text" name="id" hidden value="{{ $page->alias_id }}">
                        @endif
                        <div class="field" id="alias_to_field">
                            <label for="alias_to">Оригінальна сторінка</label>
                            <select name="alias_to" id="alias_to">
                                @foreach($pages as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label for="title">Назва</label>
                            <input type="text" name="title" id="title">
                        </div>
                        <div class="field">
                            <label for="descr">Опис</label>
                            <textarea name="descr" id="descr" cols="30" rows="7"></textarea>
                        </div>
                        <div class="field">
                            <button type="commit">Готово</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // ===========================================================================================================
        //  Функціонал вкладок
        // ===========================================================================================================
        const wrapper = $(".tab_content_wrapper");
        const tabs = $(".hotbike_tabs");
        $(".tab").click(function () {
            wrapper.find(".tab_content").addClass('hidden');
            wrapper.find($(this).attr('refers')).removeClass('hidden');
            tabs.find(".tab").removeClass('tab_active');
            $(this).addClass('tab_active');
        })
    </script>
</section>
    @if ($is_update)
        @if ($page->is_container)
            <script>
                // ===================================================================================================
                //  У випадку, якщо ми зібрались редагувати контейнер
                // ===================================================================================================
                $("#tab_button_directory").click();
                $("#tab_button_product").remove();
                $("#tab_button_alias").remove();
                const form = $("#directory_form");
                form.attr("action", '{{ route("upd_dir") }}');
                form.find("#id_field").addClass("d-none")
                form.find("input[name='id']").val( '{{ $page->id }}' )
                form.find("input[name='title']").val( '{{ $page->title }}' )
                form.find("input[name='sort_field']").val( '{{ $page->sort_field }}' )
                form.find("input[name='sort_order']").val( '{{ $page->sort_order }}' )
            </script>
        @elseif($page->is_alias)
            <script>
                // ===================================================================================================
                //  Те ж саме, тільки для аліасу
                // ===================================================================================================
                $("#tab_button_directory").remove();
                $("#tab_button_product").remove();
                $("#tab_button_alias").click();
                const form = $("#alias_form");
                form.attr("action", '{{ route("upd_alias") }}');
                form.find("#alias_to_field").addClass("d-none")
                form.find("input[name='title']").val( '{{ $page->title }}' )
                form.find("textarea[name='descr']").val( '{{ $page->description }}' )
            </script>
        @else
            <script>
                // ===================================================================================================
                //  Те ж саме, тільки для товару
                // ===================================================================================================
                $("#tab_button_directory").remove();
                $("#tab_button_product").click();
                $("#tab_button_alias").remove();
                const $productForm = $("#product_form");
                $productForm.attr("action", '{{ route("upd_product") }}');
                $productForm.find("#id_field").addClass("d-none")
                $productForm.find("input[name='id']").val( '{{ $page->id }}' )
                $productForm.find("input[name='title']").val( '{{ $page->title }}' )
                $productForm.find("input[name='brand']").val( '{{ $page->brand }}' )
                $productForm.find("textarea[name='descr']").val( '{{ $page->description }}' )
                $productForm.find("input[name='price']").val( '{{ $page->price }}' )
                const tbody = $productForm.find(".properties_table").find("tbody");
                tbody.html("")
                $('<div>{!! $page->stats !!}</div>').find(".row").each(function () {
                    const cols = $(this).find(".col-6").toArray()
                    tbody.append($(`<tr><td><input type="text" id="pname" value="${$(cols[0]).text()}"></td><td><input type="text" id="pval" value="${$(cols[1]).text()}"></td></tr>`));
                })
            </script>
        @endif
    @endif
@endsection
