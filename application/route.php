<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/category', 'api/:version.Category/getAllCategories');
Route::get('api/:version/category/:id', 'api/:version.Category/getCategoryByID', [], ['id' => '\d+']);
Route::get('api/:version/category/parent/:id', 'api/:version.Category/getAllParentCategories');
Route::delete('api/:version/category/:id', 'api/:version.Category/deleteCategory');
Route::post('api/:version/category', 'api/:version.Category/createCategory');
Route::post('api/:version/category/:id', 'api/:version.Category/updateCategory');

Route::post('api/:version/account/login', 'api/:version.Account/getAppToken');
Route::post('api/:version/account/changePw', 'api/:version.Account/changePassWord');
Route::get('api/:version/account', 'api/:version.Account/getInfo');
Route::post('api/:version/account/logout','api/:version.Account/logout');
Route::get('api/:version/account/student','api/:version.Account/getAllStudentInfo');
Route::post('api/:version/account/:id','api/:version.Account/updateAccount');

Route::get('api/:version/laboratory', 'api/:version.Laboratory/getAllLabs');
Route::post('api/:version/laboratory', 'api/:version.Laboratory/createLaboratory');
Route::post('api/:version/laboratory/:id', 'api/:version.Laboratory/updateLaboratory');
Route::post('api/:version/laboratory/status/:id', 'api/:version.Laboratory/changeStatus');
Route::delete('api/:version/laboratory', 'api/:version.Laboratory/deleteLaboratory');

Route::get('api/:version/device', 'api/:version.Device/getAllDevices');
Route::delete('api/:version/device', 'api/:version.Device/deleteDevice');
Route::post('api/:version/device', 'api/:version.Device/createDevice');
Route::post('api/:version/device/:id', 'api/:version.Device/updateDevice');
Route::post('api/:version/device/status/:id','api/:version.Device/changeStatus');

Route::post('api/:version/repair','api/:version.Repair/createRepair');
Route::get('api/:version/repair','api/:version.Repair/getAllRepair');
Route::post('api/:version/repair/status/:id','api/:version.Repair/changeStatus');

Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order','api/:version.Order/getAllOrder');
Route::get('api/:version/myOrder','api/:version.Order/getOrderByAccount');
Route::post('api/:version/order/audit/:id','api/:version.Order/auditing');
Route::delete('api/:version/order/:id','api/:version.Order/deleteOrder');

Route::post('api/:version/loan', 'api/:version.Circulate/placeOrder');
Route::get('api/:version/loan','api/:version.Circulate/getAllOuiOrder');
Route::get('api/:version/myLoan','api/:version.Circulate/getOuiOrderByAccount');
Route::post('api/:version/loan/audit/:id', 'api/:version.Circulate/auditing');
