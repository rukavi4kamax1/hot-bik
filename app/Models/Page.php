<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model {

    protected static $parentKey = "parent";

    public static $priKey = "id";
    public static $root_id = "root";
    public static $tableName = "pages";

    public $id;
    public $title;
    public $description;
    public $content;
    public $created;
    public $updated;
    public $is_container;

    public static function createObject($data) {
        $page = new Page();
        $page->id = $data->id;
        $page->title = $data->title;
        $page->description = $data->description;
        $page->content = $data->content;
        $page->created = $data->created;
        $page->updated = $data->updated;
        $page->is_container = $data->is_container;
        return $page;
    }

    public static function createCompact($data) {
        $page = new Page();
        $page->id = $data->id;
        $page->title = $data->title;
        return $page;
    }

    public static function getAllPages($parent_id) {
        $parent = DB::table(Page::$tableName)->where(Page::$priKey, $parent_id)->get();
        $pages_array = new ArrayObject();
        if (sizeof($parent) == 0 || !$parent[0]->is_container)
            return $pages_array;
        $raw_pages = DB::table(Page::$tableName)
            ->where(Page::$parentKey, $parent_id)
            ->where(Page::$priKey, "!=", Page::$root_id)
            ->orderBy("is_container")
            ->orderBy($parent[0]->sort_field, $parent[0]->sort_order)
            ->get();
        foreach ($raw_pages as $page) {
            $pages_array->append(Page::createObject($page));
        }
        return $pages_array;
    }

    public static function getParent($id) {
        $parent = DB::table(Page::$tableName)->where(Page::$priKey, $id)->get();
        if (sizeof($parent) == 0)
            return Page::$root_id;
        return $parent[0]->parent;
    }

}
