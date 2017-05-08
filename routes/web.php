<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/sign-out', 'Auth\LoginController@logout');
Route::get('/', 'HomeController@index');

// Files routes
Route::group(['prefix' => 'files', 'namespace' => 'File'], function() {

    Route::post('/{type}/upload/{disk?}', 'UploadController@upload')
        ->where([
            'type' => 'image|video|audio|others',
        ])
        ->name('files.upload_default')
    ;

    Route::post('/{type}/upload/{disk?}/w/{width?}/h/{height?}', 'UploadController@upload')
        ->where([
            'type' => 'image|video|audio|others',
            'width' => '\d+',
            'height' => '\d+'
        ])
        ->name('files.upload')
    ;

    Route::get('/{type}/{file}', 'ShowFileController@getFile')
        ->where([
            'type' => 'image|video|audio|others',
            'file' => '([\w]+)\.([a-zA-Z]{1,5})|\d+'
        ])
        ->name('files.get_file')
    ;
});

// Product routes
Route::group(['prefix' => 'product', 'namespace' => 'Product'], function() {
    Route::get('/types/{level?}_{parent?}', 'ProductTypeController@getByLevelAndParent')
        ->where([
            'level' => '\d+',
            'parent' => '\d+',
        ])
        ->name('product.get_types_by_level_parent');

    Route::get('/types/{id}', 'ProductTypeController@getById')
        ->where([
            'id' => '\d+'
        ])
        ->name('product.get_types_by_id')
    ;

    Route::post('/create', 'CreateProductController@create')
        ->name('product.create')
    ;

    Route::get('/list', 'ProductController@getList')
        ->name('product.list')
    ;

    Route::get('/delete/{id}', 'ProductController@delete')
        ->where([
            'id' => '\d+',
        ])
        ->name('product.delete')
    ;

    Route::get('/info/{id}', 'ProductController@getOne')
        ->where([
            'id' => '\d+'
        ])
        ->name('product.info')
    ;

    Route::post("/update/{id}", 'ProductController@update')
        ->where([
            'id' => '\d+',
        ])
        ->name('product.update')
    ;

});

// Order routes
Route::group(['prefix' => 'order', 'namespace' =>'Order'], function () {
    Route::post('/change_status/order_{orderID}/{orderStatus}', 'UpdateController@setStatus')
        ->where('orderID', '\d+')
        ->where('orderStatus', 'STATUS_NOT_PAID|STATUS_PAID|STATUS_DELIVER|STATUS_DID_DELIVER|STATUS_TRADE_FINISH')
        ->name('order.update_status');

    Route::post('/simple-create', 'CreateController@simpleCreate')
        ->name('order.create');

    Route::get('/table-data/{status}', 'ShowController@showTableData')
        ->where('status', 'not_paid|paid|deliver|did_deliver|trade_finish')
        ->name('order.tableData');

    Route::post('/update_deliver/order_{orderID}/{userID}', 'UpdateController@setDeliver')
        ->where('orderID', '\d+')
        ->where('userID', '\d+')
        ->name('order.update_deliver');
});

// User routes
Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {

    Route::get('/delivers', 'ShowController@getAllDeliver')
        ->name('users.getDelivers');

    Route::get('/list', 'ShowController@getList')
        ->name('users.get_list');

    Route::post('/create', 'CreateController@simpleCreate')
        ->name('users.create');

    Route::post('/update', 'UpdateController@simpleUpdate')
        ->name('users.update');

    Route::get('/get-one/{id}', 'ShowController@getOne')
        ->where('id', '\d+')
        ->name('user.getOne');

    Route::get('/get-roles', 'RoleController@showAll')
        ->name('users.roles');

    Route::post('/create-user-address/{userId}', 'CreateController@createAddress')
        ->where('userId', '\d+')
        ->name('users.createAddress');

    Route::get('/all', 'ShowController@getAll')
        ->name('users.getAll');

    Route::get('/get-address/{id}', 'ShowController@getUserAddress')
        ->where('id', '\d+')
        ->name('users.getAddress');

    Route::get('/lock/{userID}/{locked?}', 'UpdateController@lockedUser')
        ->where('locked', '\d+')
        ->where('userID', '\d+')
        ->name('users.lock');

    Route::get('/roles-with-permission', 'RoleController@getRolesWithPermission')
        ->name('user.rolesWithPerm');

    Route::get('/all-perms', 'PermissionController@getPerms')
        ->name('user.allPerms');

    Route::post('/sync-perms/{id}', 'RoleController@syncRolePerms')
        ->where('id', '\d+')
        ->name('user.syncPerms');

    Route::post('/create-role', 'RoleController@createRole')
        ->name('user.createRole');
});


