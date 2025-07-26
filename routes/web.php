<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SwitchUserController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\Document\DocumentTypeController;
use App\Http\Controllers\Document\DocumentFieldController;
use App\Http\Controllers\Document\GeneratedDocumentController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/coba-template', function () {
//     return view('template-doc.surat_keterangan_usaha');
// });
// Route::resource('dynamic-form', App\Http\Controllers\DynamicFormController::class);

if (config('switchuser.enabled')) {
    Route::get('/users/get', [SwitchUserController::class, 'getUsers'])->middleware('auth')->name('users.get');
    Route::post('/users/switch', [SwitchUserController::class, 'switch'])->middleware('auth')->name('users.switch');
}


Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->middleware('can:manage-users')->name('users');
        Route::get('/user/{user}/show', [UserController::class, 'show'])->middleware('can:manage-users')->name('user.show');
        Route::post('/users', [UserController::class, 'store'])->middleware('can:user-create')->name('user.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('can:user-update')->name('user.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('can:user-delete')->name('user.destroy');

        Route::resource('role-permission', RolePermissionController::class)
            ->middleware('can:manage-roles')
            ->except(['create', 'edit', 'destroy']); // Jika Anda tidak menggunakan method ini secara langsung
        Route::get('role-permission/{role}', [RolePermissionController::class, 'show'])
            ->middleware('can:manage-roles')
            ->name('role-permission.show');
        Route::put('role-permission/{role}', [RolePermissionController::class, 'update'])
            ->middleware('can:role-update')
            ->name('role-permission.update');
        Route::post('role-permission', [RolePermissionController::class, 'store'])
            ->middleware('can:role-create')
            ->name('role-permission.store');
        Route::post('role-permission/{role}', [RolePermissionController::class, 'destroy'])
            ->middleware('can:role-delete')
            ->name('role.destroy');
        Route::post('role-permission/permission/store', [RolePermissionController::class, 'permissionStore'])
            ->middleware('can:permission-create')
            ->name('permission.store');
        Route::post('role-permission/{id}', [RolePermissionController::class, 'permissionDestroy'])
            ->middleware('can:permission-delete')
            ->name('permission.destroy');



        Route::get('/resident', [ResidentController::class, 'index'])->middleware('can:manage-residents')->name('residents');
        Route::get('/resident/{user}/show', [ResidentController::class, 'show'])->middleware('can:manage-residents')->name('resident.show');
        Route::post('/resident', [ResidentController::class, 'store'])->middleware('can:resident-create')->name('resident.store');
        Route::put('/resident/{user}', [ResidentController::class, 'update'])->middleware('can:resident-update')->name('resident.update');

        Route::prefix('document')->group(function () {
            Route::get('/document-type', [DocumentTypeController::class, 'index'])->middleware('can:document-type')->name('document.type.index');
            Route::get('/document-type/show/{document_type}', [DocumentTypeController::class, 'show'])->middleware('can:document-type')->name('document.type.show');
            Route::post('/document-type', [DocumentTypeController::class, 'store'])->middleware('can:document-type')->name('document.type.store');
            Route::put('/document-type/{id}', [DocumentTypeController::class, 'update'])->middleware('can:document-type')->name('document.type.update');
            Route::post('/document-type/{id}', [DocumentTypeController::class, 'destroy'])->middleware('can:document-type')->name('document.type.destroy');

            Route::get('/document-field/{document_type}', [DocumentTypeController::class, 'indexFields'])->middleware('can:document-field')->name('document.field.index');
            Route::get('/document-field/show/{form_field}', [DocumentFieldController::class, 'show'])->middleware('can:document-field')->name('document.field.show');
            Route::post('/document-field/{document_type}', [DocumentFieldController::class, 'store'])->middleware('can:document-field')->name('document.field.store');
            Route::put('/document-field/{document_type}/{form_field}', [DocumentFieldController::class, 'update'])->middleware('can:document-field')->name('document.field.update');
            Route::post('/document-field/{document_type}/{form_field}', [DocumentFieldController::class, 'destroy'])->middleware('can:document-field')->name('document.field.destroy');
        });
    });

    Route::get('/documents', [DocumentController::class, 'index'])->middleware('can:document-list')->name('document.index');

    Route::get('/document/generate', [GeneratedDocumentController::class, 'index'])->middleware('can:document-create')->name('document.generated.index');
    Route::get('/document/generate/{document_type}', [GeneratedDocumentController::class, 'create'])->middleware('can:document-create')->name('document.generated.create');
    Route::get('/document/generate/getUserApprovals/{user}', [GeneratedDocumentController::class, 'userApprovals'])->middleware('can:document-create')->name('document.generated.getUserApprovals');
    Route::post('/document/generate/{document_type}', [GeneratedDocumentController::class, 'store'])->middleware('can:document-create')->name('document.generated.store');
    Route::get('/document/generate/edit/{document_type}/{document}', [GeneratedDocumentController::class, 'edit'])->middleware('can:document-create')->name('document.generated.edit');
    Route::put('/document/generate/{document_type}/{document}', [GeneratedDocumentController::class, 'update'])->middleware('can:document-create')->name('document.generated.update');

    Route::get('/document/generate/download/{document}', [GeneratedDocumentController::class, 'generate'])->middleware('can:document-create')->name('document.generated.download');

    Route::get('/document/approval/{document}', [ApprovalController::class, 'index'])->middleware('can:document-approval')->name('document.approval.index');
    Route::get('/document/approval/{document}/generate', [ApprovalController::class, 'generate'])->middleware('can:action-approve')->name('document.approval.generate');
    Route::post('document/approval/{document}/approve', [ApprovalController::class, 'approve'])->middleware('can:action-approve')->name('document.approval.approve');
    Route::post('document/approval/{document}/reject', [ApprovalController::class, 'reject'])->middleware('can:action-approve')->name('document.approval.reject');
    Route::post('document/approval/{document}/sign', [ApprovalController::class, 'sign'])->middleware('can:action-sign')->name('document.approval.sign');

    Route::get('/report', [ReportController::class, 'index'])->middleware('can:report')->name('report');
});

