<?php
/**
 * User: makalong
 * Date: 2018/2/3
 * Time: 18:35
 */

namespace app\api\controller\v1;


use app\api\validate\CategoryNew;
use app\api\validate\IDMustBePositiveInt;
use app\api\controller\BaseController;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;
use app\lib\exception\SuccessMessage;

class Category extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'UpdateCategory,createCategory,deleteCategory']
    ];
    public function getAllCategories()
    {
        $Categories = CategoryModel::all();
        if ($Categories->isEmpty()) {
            throw new CategoryException();
        }
        $res = array();
        foreach ($Categories as $k => $v) {
            if ($v['parent_id'] == 0) {
                $res[] = $Categories[$k];
                foreach ($Categories as $kk => $vv) {
                    if ($vv['parent_id'] == $v['id']) {
                        $res[] = $Categories[$kk];
                    }
                }
            }
        }
        $data['data'] = $res;
        return json($data);
    }

    public function getCategoryByID($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $Category = CategoryModel::get($id);
        return $Category;
    }

    /*
     * id不传参，默认查询顶级栏目；
     * id传参，查询对应id的子孙
    */
    public function getAllParentCategories($id)
    {
        $Categories = CategoryModel::getAllParentsCategories($id);
        if ($Categories->isEmpty()) {
            throw new CategoryException();
        }
        return new SuccessMessage([
            'data' => ['items' => $Categories]
        ]);
    }

    public function UpdateCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $validate = new CategoryNew();
        $validate->goCheck();

        $dataArray = $validate->getDataByRule(input('post.'));
        CategoryModel::where('id', $id)->update($dataArray);
        return new SuccessMessage();
    }

    public function createCategory()
    {
        $validate = new CategoryNew();
        $validate->goCheck();
        $dataArray = $validate->getDataByRule(input('post.'));
        $category = CategoryModel::create($dataArray);
        return new SuccessMessage([
            'data' => [
                'id' => $category->id
            ]
        ]);
    }

    public function deleteCategory($id = 0)
    {
        (new IDMustBePositiveInt())->goCheck();
        CategoryModel::deleteCategory($id);
        return new SuccessMessage();
    }

}
