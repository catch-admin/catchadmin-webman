<?php

use app\admin\controller\permissions\Permissions;
use app\admin\controller\permissions\Departments;
use app\admin\controller\permissions\Roles;
use app\admin\controller\permissions\Jobs;
use Webman\Route;
use app\admin\controller\permissions\Admin;
use app\admin\controller\common\Options;
use app\admin\controller\common\Upload;

Route::resource('users', Admin::class);
Route::put('/users/enable/{id}', [Admin::class , 'enable']);
Route::get('/user/login/log', [Admin::class , 'loginLog']);
Route::get('/user/operate/log', [Admin::class , 'operateLog']);

Route::get('/user/online', [Admin::class, 'online']);
Route::post('/user/online', [Admin::class, 'online']);

Route::resource('permissions/jobs', Jobs::Class);
Route::resource('permissions/roles', Roles::Class);
Route::resource('permissions/departments', Departments::Class);
Route::put('/permissions/departments/enable/{id}', [Departments::class, 'enable']);

Route::resource('permissions/permissions', Permissions::Class);
Route::put('/permissions/permissions/enable/{id}', [Permissions::Class, 'enable']);

Route::get('/options/{option}', [Options::class , 'get']);
Route::post('/upload/image', [Upload::class , 'image']);
Route::post('/upload/file', [Upload::class , 'file']);
