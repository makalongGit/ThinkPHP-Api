<?php
/**
 * User: makalong
 * Date: 2018/2/3
 * Time: 18:36
 */

namespace app\api\model;

use app\lib\exception\CategoryException;
use app\lib\exception\SuccessMessage;

class Category extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    
    public static function getAllParentsCategories($id = 0)
    {
        return self::all(['parent_id' => $id]);
    }

    public static function deleteCategory($id)
    {
        $ids = self::getAllParentsCategories($id)->visible(['id'])->toArray();
        $ids = array_column($ids, 'id');
        array_push($ids, $id);
        $ids = implode(',', $ids);
        $rs = self::destroy($ids);
        if (!$rs) {
            throw new CategoryException();
        }
        return new SuccessMessage();
    }
}