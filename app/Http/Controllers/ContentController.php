<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Page;
use App\Models\Path;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller {

    // ===============================================================================================================
    //  Робота з директоріями
    // ===============================================================================================================

    public function create_directory(Request $req) {
        $pid = $req->input("pid");
        $resp = DB::table(Page::$tableName)->where(Page::$priKey, $pid)->first();
        if (!$resp)
            return "403";
        DB::table(Page::$tableName)->insert([
            "id" => $req->input("id"),
            "title" => $req->input("title"),
            "parent" => $req->input("pid"),
            "is_container" => true,
            "sort_field" => $req->input("sort_field"),
            "sort_order" => $req->input("sort_order")
        ]);
        return redirect()->route("admin_page", [ "id" => $pid ]);
    }

    public function update_directory(Request $req) {
        DB::table(Page::$tableName)->where(Page::$priKey, $req->input("id"))->update([
            "title" => $req->input("title"),
            "updated" => now(),
            "sort_field" => $req->input("sort_field"),
            "sort_order" => $req->input("sort_order")
        ]);
        return redirect()->route("admin_page", [ "id" => $req->input("pid") ]);
    }

    // ===============================================================================================================
    //  Робота з продуктами
    // ===============================================================================================================

    public function create_product(Request $req) {
        DB::table(Page::$tableName)->insert([
            "id" => $req->input("id"),
            "parent" => $req->input("pid"),
            "title" => $req->input("title"),
            "images" => Image::saveAll($req->file("pictures")),
            "brand" => $req->input("brand"),
            "description" => $req->input("descr"),
            "price" => $req->input("price"),
            "stats" => $req->input("properties"),
            ]);
        return redirect()->route("admin_page", [ "id" => $req->input("pid") ]);
    }

    public function update_product(Request $req) {
        $page = DB::table(Page::$tableName)->where(Page::$priKey, $req->input("id"))->first();
        $img_to_delete = $req->input("images_to_delete");
        $existing_images = explode(Image::$imageGlue, $page->images);
        if ($img_to_delete) {
            foreach ($img_to_delete as $image) {
                Image::deleteImage($image);
                if (($key = array_search($image, $existing_images)) !== false) {
                    unset($existing_images[$key]);
                }
            }
        }
        $existing_images = new ArrayObject($existing_images);
        if ($req->hasFile("pictures")) {
            foreach ($req->file("pictures") as $image) {
                $existing_images->append(Image::saveImage($image));
            }
        }
        DB::table(Page::$tableName)->where(Page::$priKey, $req->input("id"))->update([
            "title" => $req->input("title"),
            "updated" => now(),
            "images" => implode(Image::$imageGlue, $existing_images->getArrayCopy()),
            "brand" => $req->input("brand"),
            "description" => $req->input("descr"),
            "price" => $req->input("price"),
            "stats" => $req->input("properties"),
        ]);
        return redirect()->route("admin_page", [ "id" => $req->input("pid") ]);
    }

    // ===============================================================================================================
    //  Робота з аліасами
    // ===============================================================================================================

    public function create_alias(Request $req) {
        DB::table(Page::$tableName)->insert([
            "id" => uniqid(),
            "parent" => $req->input("pid"),
            "title" => $req->input("title"),
            "description" => $req->input("descr"),
            "alias_to" => $req->input("alias_to")
        ]);
        return redirect()->route("admin_page", [ "id" => $req->input("pid") ]);
    }

    public function update_alias(Request $req) {
        DB::table(Page::$tableName)->where(Page::$priKey, $req->input("id"))->update([
            "title" => $req->input("title"),
            "description" => $req->input("descr"),
        ]);
        return redirect()->route("admin_page", [ "id" => $req->input("pid") ]);
    }

    // ===============================================================================================================
    //  Видалення сторінок
    // ===============================================================================================================
    public function rm_content($id, $pid) {
        Path::recursive_delete($id);
        return redirect()->route("admin_page", [ "id" => $pid ]);
    }

}
