<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Path extends Model {
    public static function getPathTo($id) {
        $db_resp = DB::table(Page::$tableName)->where(Page::$priKey, $id)->first();
        $result = new ArrayObject();
        if (!$db_resp)
            return $result;
        while ($db_resp->id != $db_resp->parent) {
            $result->append(Page::createCompact($db_resp));
            $db_resp = DB::table(Page::$tableName)->where(Page::$priKey, $db_resp->parent)->first();
        }
        return array_reverse($result->getArrayCopy());
    }

    public static function recursive_delete($start) {
        $resp = DB::table(Page::$tableName)->where(Page::$priKey, $start)->first();
        if (!$resp)
            return;
        $pages = DB::table(Page::$tableName)->where(Page::$parentKey, $start)->get();
        foreach ($pages as $page) {
            self::recursive_delete($page->id);
        }
        $pages = DB::table(Page::$tableName)->where("alias_to", $start)->get();
        foreach ($pages as $page) {
            self::recursive_delete($page->id);
        }
        Image::deleteAll($resp->images);
        DB::table(Page::$tableName)->where(Page::$priKey, $start)->delete();
    }
}
