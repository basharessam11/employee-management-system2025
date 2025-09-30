<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect user after login based on permissions.
     */
    protected function authenticated($request, $user)
    {
        // جلب كل الصلاحيات للمستخدم
        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

if (in_array('view department_user', $permissions)) {
    // اليوزر عنده الصلاحية
    foreach ($user->department_user as $du) {
        $department_id = $du->department->id;


    }
}

         // خريطة الصفحات حسب الصلاحية
        $redirectMap = [
            'view hr'          => route('hr.index'),
            'view users'       => route('users.index'),
            'view roles'       => route('roles.index'),
            'view units'       => route('units.index'),
            'view departments' => route('departments.index'),
            'view location'    => route('location.index'),
            'view grades'      => route('grades.index'),
            'view jobs'        => route('jobs.index'),
            'view position'    => route('position.index'),
            'view settings'    => route('settings.index'),
            // مثال: لو الصفحات محتاجة ID
              'view answer'      => route('answer.index', ['id' => Auth::user()->id]),
              'view result'      => route('result.index', ['id' => Auth::user()->id]),
              'view department_user'      => route('department_user.show',  $department_id ?? 0),
        ];


        // البحث عن أول صلاحية موجودة في الماب
        foreach ($permissions as $permission) {
            if (isset($redirectMap[$permission])) {
                return redirect($redirectMap[$permission]);
            }
        }

        // لو مفيش صلاحية مناسبة، روح للـ Dashboard أو الصفحة الرئيسية
        return redirect()->route('home');
    }
}
