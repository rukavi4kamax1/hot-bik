<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model {

    public static $priKey = "id";
    public static $root_id = "root";
    public static $tableName = "pages";
    public static $parentKey = "parent";

    public $id;
    public $title;
    public $description;
    public $created;
    public $updated;
    public $is_container;
    public $images;
    public $brand;
    public $price;
    public $stats;
    public $parent;
    public $is_alias = false;
    public $alias_id;

    public static function createObject($data) {
        $page = new Page();
        if ($data->alias_to) {
            $page = Page::createObject(DB::table(Page::$tableName)->where(Page::$priKey, $data->alias_to)->first());
            $page->title = $data->title ?? $page->title;
            $page->description = $data->description ?? $page->description;
            $page->is_alias = true;
            $page->alias_id = $data->id;
        } else {
            $page->id = $data->id;
            $page->parent = $data->parent;
            $page->title = $data->title;
            $page->description = $data->description;
            $page->created = $data->created;
            $page->updated = $data->updated;
            $page->is_container = $data->is_container;
            $page->brand = $data->brand;
            $page->price = $data->price;
            $page->stats = $data->stats;
            $page->images = explode(Image::$imageGlue, $data->images);
        }
        return $page;
    }

    public static function createCompact($data) {
        $page = new Page();
        $page->id = $data->id;
        $page->title = $data->title;
        return $page;
    }

    public static function getAllChildrenOf($parent_id, $include_containers = true) {
        $parent = DB::table(Page::$tableName)->where(Page::$priKey, $parent_id)->get();
        $pages_array = new ArrayObject();
        if (sizeof($parent) == 0 || !$parent[0]->is_container)
            return $pages_array;
        $raw_pages = DB::table(Page::$tableName)
            ->where(Page::$parentKey, $parent_id)
            ->where(Page::$priKey, "!=", Page::$root_id)
            ->orderBy("is_container", "desc")
            ->orderBy($parent[0]->sort_field, $parent[0]->sort_order);
        if (!$include_containers) {
            $raw_pages = $raw_pages->where("is_container", false);
        }
        $raw_pages = $raw_pages->get();
        foreach ($raw_pages as $page) {
            $pages_array->append(Page::createObject($page));
        }
        return $pages_array;
    }

    public static function getAllPages() {
        $raw_pages = DB::table(Page::$tableName)
            ->where("is_container", false)
            ->where("alias_to", null)
            ->get();
        $pages_array = new ArrayObject();
        foreach ($raw_pages as $page) {
            $pages_array->append(Page::createCompact($page));
        }
        return $pages_array;
    }

    public static function getParent($id) {
        $parent = DB::table(Page::$tableName)->where(Page::$priKey, $id)->get();
        if (sizeof($parent) == 0)
            return Page::$root_id;
        return $parent[0]->parent;
    }

    public static function getPageById($id) {
        return Page::createObject(DB::table(Page::$tableName)->where(Page::$priKey, $id)->first());
    }

    public static function regroupBy($arr, $count) {
        $res = new ArrayObject();
        for ($i = 0; $i < sizeof($arr); $i += $count) {
            $res->append(new ArrayObject());
            for($j = 0; $j < $count && $j + $i < sizeof($arr); $j++){
                $res[sizeof($res)-1]->append($arr[$i+$j]);
            }
        }
        return $res;
    }

    public static function getCategories($pid) {
        $parent = DB::table(Page::$tableName)->where(Page::$priKey, $pid)->get();
        $pages_array = new ArrayObject();
        if (sizeof($parent) == 0 || !$parent[0]->is_container)
            return $pages_array;
        $raw_pages = DB::table(Page::$tableName)
            ->where(Page::$parentKey, $pid)
            ->where(Page::$priKey, "!=", Page::$root_id)
            ->where("is_container", true)
            ->orderBy($parent[0]->sort_field, $parent[0]->sort_order)
            ->get();
        foreach ($raw_pages as $page) {
            $pages_array->append(Page::createObject($page));
        }
        return $pages_array;
    }

}
