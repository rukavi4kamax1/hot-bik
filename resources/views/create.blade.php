@extends('main')

@section('content')
    <style>
            .hotbike_tabs .tab {
                width: 33.33333%;
                background: #85613d;
                color: whitesmoke;
                padding: 30px;
                font-size: 26px;
                text-align: center;
                cursor: pointer;
                border: 1px solid #453629;
                border-left: none;
                border-radius: 15px 15px 0 0;
            }
            .hotbike_tabs .tab:first-child {
                border-left: 1px solid #453629;
            }
            .hotbike_tabs .tab_active{
                border-bottom: none;
                background: #a67c52;
            }
            .tab_content {
                flex-grow: 1;
                background: #a67c52;
                border: 1px solid #453629;
                border-top: none;
                padding: 30px;
                color: whitesmoke;
            }
            .hidden {
                display: none;
            }
            .hotbike_form {
                display: flex;
                flex-direction: column;
            }
            .hotbike_form input {
                flex-grow: 1;
            }
            .field {
                text-align: center;
                padding: 5px;
                margin: 5px 0;
                font-size: 20px;
                display: flex;
                align-items: center;
            }
            .field label {
                margin-right: 15px;
                border-bottom: 3px solid transparent;
                padding: 5px;
            }
            .field input, .field select {
                flex-grow: 1;
                padding: 5px;
                background: transparent;
                border: none;
                border-bottom: 3px solid whitesmoke;
                outline: none;
                font-size: 18px;
                color: whitesmoke;
            }
            .field option {
                color: #453629;
                padding: 10px;
                margin: 10px;
            }
    </style>


<section class="admin_section container-fluid">
    <div class="row justify-content-center">
        <div class="admin col-9">
            <div class="hotbike_tabs d-flex">
                <div class="tab tab_active" refers="#directory">Директорія</div>
                <div class="tab" refers="#product">Товар</div>
                <div class="tab" refers="#alias">Аліас</div>
            </div>
            <div class="tab_content_wrapper">
                <div class="tab_content" id="directory">
                    <form class="hotbike_form" action="" method="post">
                        @csrf
                        <input type="text" name="pid" hidden value="{{ $pid }}">
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
                            <select name="sort_field" id="sort_order">
                                <option value="desc">За спаданням</option>
                                <option value="asc">За зростанням</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="tab_content hidden" id="product">
                    <form action="" method="post">
                        Form for product
                    </form>
                </div>
                <div class="tab_content hidden" id="alias">
                    <form action="" method="post">
                        Form for alias
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // ===========================================================================================================
        //  TAB CONTROL
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
@endsection
