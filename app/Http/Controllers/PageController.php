<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Path;

class PageController extends Controller {

    // ===============================================================================================================
    //  Оновлення сторінки
    // ===============================================================================================================
    public function update($id) {
        $page = Page::getPageById($id);
        return view('create',[
            "title" => "HotBike - Редагування ".$page->title,
            "categories" => Page::getAllChildrenOf(Page::$root_id),
            "page" => $page,
            "pid" => $page->parent,
            "is_update" => true,
            "pages" => Page::getAllPages()
        ]);
    }

    // ===============================================================================================================
    //  Створення нової сторінки
    // ===============================================================================================================
    public function create($pid) {
        return view('create',[
            "title" => "HotBike - Створення нової сторінки",
            "categories" => Page::getAllChildrenOf(Page::$root_id),
            "pid" => $pid,
            "is_update" => false,
            "pages" => Page::getAllPages()
        ]);
    }

    // ===============================================================================================================
    //  Адмін панель
    // ===============================================================================================================
    public function admin_root() {
        return $this->admin_page(Page::$root_id);
    }

    public function admin_page($id) {
        return view("admin", [
            "dir_id" => $id,
            "parent_id" => Page::getParent($id),
            "title" => "HotBike - Адміністративна панель",
            "categories" => Page::getAllChildrenOf(Page::$root_id),
            "pages" => Page::getAllChildrenOf($id),
            "path" => Path::getPathTo($id)
        ]);
    }

    // ===============================================================================================================
    //  Перегляд сторінок
    // ===============================================================================================================
    public function get_page($id) {
        $page = Page::getPageById($id);
        if ($page->is_container) {
            return view("container", [
                "title" => "HotBike - ".$page->title,
                "categories" => Page::getAllChildrenOf(Page::$root_id),
                "pages" => Page::regroupBy(Page::getAllChildrenOf($page->id, false), 2),
                "page" => $page,
                "subcategories" => Page::getCategories($id)
            ]);
        }
        return view("product", [
            "title" => "HotBike - ".$page->title,
            "categories" => Page::getAllChildrenOf(Page::$root_id),
            "page" => $page
        ]);
    }

}
