<?php

use App\Models\Insertion;
use App\Models\InvoiceStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IssueNrsController;
use App\Http\Controllers\InsertionController;
use App\Http\Controllers\InvoiceStatusController;

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

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/my_insertions', [InsertionController::class, 'myInsertions'])->middleware('auth')->name('my_insertions');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('insertions', InsertionController::class);
    Route::resource('medias', MediaController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('invoice_status', InvoiceStatusController::class);
    Route::resource('issue_nr', IssueNrsController::class);
});

//ROUTE AJAX
Route::get('/ajax/companies/index', [AjaxController::class, 'indexCompany'])->name('ajax.companies.index');
Route::post('/ajax/companies/store', [AjaxController::class, 'storeCompany'])->name('ajax.companies.store');
Route::post('/ajax/issue/get', [AjaxController::class, 'getIssue'])->name('ajax.issue.get');
Route::post('/ajax/issue/getSearch', [AjaxController::class, 'getIssueSearch'])->name('ajax.issue.getSearch');
Route::get('ajax/brand/get', [AjaxController::class, 'liveSearch'])->name('ajax.live.search');
Route::get('ajax/issueExist/get', [AjaxController::class, 'issueExist'])->name('ajax.issueExist.get');