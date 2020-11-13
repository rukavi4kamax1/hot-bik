@extends('main')

@section('content')
    <section class="admin_section container-fluid">
        <div class="row justify-content-center">
            <div class="admin col-10">
                <div class="admin_content">
                    <div class="crumbs d-flex flex-row">
                        <div class="path_add crumbs_button"><a href="{{ route("create", ["pid" => $dir_id]) }}"><i class="fas fa-plus"></i></a></div>
                        <div class="path_up crumbs_button"><a href="{{ route("admin_page", ["id" => $parent_id]) }}"><i class="fas fa-arrow-up"></i></a></div>
                        <div class="path">
                            <a href="{{ route("admin_page", ["id" => "root"]) }}" class="path_element">root</a>
                            @foreach($path as $page)
                                > <a href="{{ route("admin_page", ["id" => $page->id]) }}" class="path_element">{{ $page->title }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex">
                        <table class="admin_table">
                            <thead>
                                <tr>
                                    <td style="width: 1%;">Id</td>
                                    <td>Назва</td>
                                    <td>Опис</td>
                                    <td>Створено</td>
                                    <td>Змінено</td>
                                    <td style="width: 1%;"></td>
                                    <td style="width: 1%;"></td>
                                    <td style="width: 1%;"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pages as $page)
                                    <tr>
                                        <td>
                                            @if($page->is_alias)
                                                <span style="font-style: italic;">*{{$page->id}}</span>
                                            @else
                                                {{$page->id}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($page->is_container)
                                                <a class="admin_table_directory" href="{{ route("admin_page", ["id" => $page->id]) }}">{{$page->title}}</a>
                                            @else
                                                {{$page->title}}
                                            @endif
                                        </td>
                                        <td width="50%">
                                            @if(!$page->is_container)
                                                {{$page->description}}
                                            @endif
                                        </td>
                                        <td>{{$page->created}}</td>
                                        <td>{{$page->updated}}</td>
                                        <td><a href="{{ route("page", [ "id" => $page->id ]) }}"><i class="fas fa-eye"></i></a></td>
                                        @if($page->is_alias)
                                            <td><a href="{{ route("update", [ "id" => $page->alias_id ]) }}"><i class="fas fa-pencil-alt"></i></a></td>
                                            <td><a href="{{ route("rm_content", ["id" => $page->alias_id, "pid" => $dir_id]) }}"><i class="fas fa-trash-alt"></i></a></td>
                                        @else
                                            <td><a href="{{ route("update", [ "id" => $page->id ]) }}"><i class="fas fa-pencil-alt"></i></a></td>
                                            <td><a href="{{ route("rm_content", ["id" => $page->id, "pid" => $dir_id]) }}"><i class="fas fa-trash-alt"></i></a></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
