<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Path;

class PageController extends Controller {

    public function create($pid) {
        return view('create',[
            "title" => "HotBike - Створення нової сторінки",
            "categories" => Page::getAllPages(Page::$root_id),
            "pid" => $pid,
        ]);
    }

    public function admin_root() {
        return $this->admin_page(Page::$root_id);
    }

    public function admin_page($id) {
        return view("admin", [
            "dir_id" => $id,
            "parent_id" => Page::getParent($id),
            "title" => "HotBike - Адміністративна панель",
            "categories" => Page::getAllPages(Page::$root_id),
            "pages" => Page::getAllPages($id),
            "path" => Path::getPathTo($id)
        ]);
    }

}
