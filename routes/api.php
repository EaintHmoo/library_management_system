<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::put('users/{user}/approve', [AuthController::class, 'approve']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['as' => 'api.', 'namespace' => 'App\Http\Controllers\Api', 'middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('password/update', [AuthController::class, 'changePassword']);
    Route::put('profile/update', [AuthController::class, 'updateProfile']);
    Route::delete('users/delete-account', [AuthController::class, 'deleteAccount']);

    //Author
    Route::apiResource('authors', 'AuthorController');

    //Book Category
    Route::apiResource('book-categories', 'BookCategoryController');

    //Publisher
    Route::apiResource('publishers', 'PublisherController');

    //Location
    Route::apiResource('locations', 'LocationController');

    //Book
    Route::apiResource('books', 'BookController');

    //Member
    Route::apiResource('members', 'MemberController');

    //Library Setting
    Route::apiResource('library-settings', 'LibrarySettingController');

    //Checkout
    Route::apiResource('checkouts', 'CheckoutController');

    //Fine
    Route::apiResource('fines', 'FineController');

    //User
    Route::apiResource('users', 'UserController');

    //Role
    Route::apiResource('roles', 'RoleController');

    //Permission
    Route::apiResource('permissions', 'PermissionController');
});
