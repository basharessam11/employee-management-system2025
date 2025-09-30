<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Traits\HasCrudPermissions;
use App\Models\Country;
use App\Models\Location;
use App\Models\Position;
use App\Models\User;
use App\Models\Unit;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Jop;
use App\Models\Grade;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
   use HasCrudPermissions;


    public function __construct()
    {
         $this->applyCrudPermissions('users');
    }
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name_ar', 'LIKE', "%{$search}%")
                  ->orwhere('name_en', 'LIKE', "%{$search}%");
        }

        if ($request->filled('from_date') && $request->filled('to_date') && $request->from_date <= $request->to_date) {
            $query->whereBetween('join_date', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('join_date', '>=', Carbon::parse($request->from_date)->startOfDay());
        } elseif ($request->filled('to_date')) {
            $query->whereDate('join_date', '<=', Carbon::parse($request->to_date)->endOfDay());
        }

  $user = Auth::user();

if (!$user->hasRole('admin')) {

$query->where('id',  $user->id);


}
        $users = $query->with('country:id,name,code')->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        return view('admin.users.index', get_defined_vars());
    }
    public function show(string $id)
    {
        //
    }
    public function create()
    {
        $locations = Location::all();
        $countries = Country::all();
        $positions = Position::all();
        $roles = Role::get(['id','name']);

        return view('admin.users.create', get_defined_vars());
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->except('photo','role'));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        if ($request->hasFile('photo')) {
            $user->setImageAttribute([$request->file('photo')]);
            $user->save();
        }

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', __('admin.Created Successfully'));
    }

    public function edit(string $id)
    {

        $country = Country::all();
        $user = User::FindOrFail($id);
        $positions = Position::all();
        $locations = Location::all();
        $countries = Country::all();
        $Structurepermissions = Position::all();
        $roles = Role::get(['id','name']);

        return view('admin.users.edit', get_defined_vars());
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->except('photo', 'password','role'));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('setting')->delete($user->photo);
            }
            $user->setImageAttribute([$request->file('photo')]);
            $user->save();
        }


        $user->save();
$user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', __('admin.Updated Successfully'));
    }

    public function destroy(Request $request)
    {
        $ex = explode(',', $request->id);

        foreach ($ex as $key => $value) {
            $user = User::findOrFail($value);
            if ($user->photo) {
                Storage::disk('setting')->delete($user->photo);
            }
            $user->delete();
        }

        session()->flash('success', __('admin.Deleted Successfully'));

        return redirect()->back();
    }

    /**
     * ✅ استيراد موظفين من ملف Excel
     */


// لو هتقرأ Excel مباشرةً:
// composer require phpoffice/phpspreadsheet


public function import(Request $request)
{




    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ], [
        'file.required' => 'ارفع ملف Excel يا اسطا',
        'file.mimes'    => 'الملف لازم يكون xlsx/xls/csv',
    ]);

    $path = $request->file('file')->getRealPath();
    $sheet = IOFactory::load($path)->getActiveSheet();
    $rows  = $sheet->toArray(null, true, true, true);

    // تحويل عناوين الأعمدة لـ snake_case علشان تبقى سهلة
    $headerRow = array_shift($rows);
    $headers = [];
    foreach ($headerRow as $k => $title) {


        $title = Str::snake(trim(mb_strtolower((string)$title)));
        $headers[$k] = $title;
    }

    // الأعمدة المتوقعة في الشيت (أسماء مرنة طالما اتعملت snake_case):
    // name_ar, name_en, email, phone, married, iqama, ex_date_iqama, paymant_method,
    // birthday, join_date, qualification, status,
    // country_name (أو country_code),
    // location_name, location_address,
    // grade_name, grade_code,
    // jop_name, position_name,
    // unit_name, department_name

    $report = ['inserted' => 0, 'skipped' => 0, 'linked' => 0, 'errors' => 0];
    $line   = 1 + 1; // بعد الهيدر


    // return$rows;
    foreach ($rows as $row) {
        try {
            $data = [];
            foreach ($row as $colKey => $value) {
                $key = $headers[$colKey] ?? null;
                if ($key) $data[$key] = is_string($value) ? trim($value) : $value;
            }

            // فحوصات أساسية
            if (empty($data['email']) || empty($data['position_name']) || empty($data['location_name'])) {
                $report['skipped']++;
                $line++;
                continue;
            }

            DB::transaction(function () use (&$report, $data) {

                // 1) Country
                $country = null;
                if (!empty($data['country_code'])) {
                    $country = Country::firstOrCreate(
                        ['code' => mb_strtolower($data['country_code'])],
                        ['name' => $data['country_name'] ?? mb_strtoupper($data['country_code'])]
                    );
                } elseif (!empty($data['country_name'])) {
                    $country = Country::firstOrCreate(
                        ['name' => $data['country_name']],
                        ['code' => substr(Str::slug($data['country_name']), 0, 3)]
                    );
                } else {
                    // لو مش متحدد، خلّيها 1 لو عندك Egypt already
                    $country = Country::find(1) ?: Country::firstOrCreate(['code' => 'xx'], ['name' => 'Unknown']);
                }

                // 2) Location (خلي بالك: العمود اسمه location)
                $location = Location::firstOrCreate(
                    ['location' => $data['location_name']],
                    ['address' => $data['location_address'] ?? '']
                );

                // 3) Grade + Jop + Position (positions requires grade_id & jop_id)
                // grade إلزامي لو فيه jop/position
                $grade = null;
                if (!empty($data['grade_name']) || !empty($data['grade_code'])) {
                    $grade = Grade::firstOrCreate(
                        ['name' => $data['grade_name'] ?? ($data['grade_code'] ?? 'Unnamed Grade')],
                        ['code' => $data['grade_code'] ?? ($data['grade_name'] ?? '000')]
                    );
                } else {
                    // لو مفيش أي تعريف لجراد، هنثبت جراد افتراضي
                    $grade = Grade::firstOrCreate(['name' => 'Default'], ['code' => '000']);
                }

                $jop = null;
                if (!empty($data['jop_name'])) {
                    $jop = Jop::firstOrCreate(
                        ['name' => $data['jop_name'], 'grade_id' => $grade->id]
                    );
                } else {
                    // لو مفيش jop في الشيت: اعمل واحد افتراضي مربوط بالجراد
                    $jop = Jop::firstOrCreate(['name' => 'General', 'grade_id' => $grade->id]);
                }

                $position = Position::firstOrCreate(
                    ['name' => $data['position_name'], 'jop_id' => $jop->id, 'grade_id' => $grade->id]
                );

                // 4) تأكد أن المستخدم مش موجود (بالبريد أو بالإقامة)
                $existingUser = User::where('email', $data['email'])
                    ->when(!empty($data['iqama']), fn($q) => $q->orWhere('iqama', $data['iqama']))
                    ->first();

                if ($existingUser) {
                    // لو موجود: مانكررش إنشاء. لكن نكمّل ربطه بالوحدة/القسم لو اتبعتوا
                    $user = $existingUser;
                    $report['skipped']++;
                } else {
                    // Parse dates safely
                    $parseDate = function ($v) {
                        if (empty($v)) return null;
                        try { return Carbon::parse($v)->toDateString(); } catch (\Throwable $e) { return null; }
                    };

                    $user = new User();
                    $user->name_ar       = $data['name_ar'] ?? ($data['name_en'] ?? 'بدون اسم');
                    $user->name_en       = $data['name_en'] ?? ($data['name_ar'] ?? 'No Name');
                    $user->email         = $data['email'];
                    $user->phone         = $data['phone'] ?? null;
                    $user->married       = isset($data['married']) ? (int)!!$data['married'] : 0;
                    $user->country_id    = $country->id;
                    $user->location_id   = $location->id;
                    $user->iqama         = $data['iqama'] ?? null;
                    $user->ex_date_iqama = $parseDate($data['ex_date_iqama']);
                    $user->paymant_method= isset($data['paymant_method']) ? (int)$data['paymant_method'] : 0;
                    $user->position_id   = $position->id;
                    $user->birthday      = $parseDate($data['birthday']);
                    $user->join_date     = $parseDate($data['join_date']);
                    $user->status        = isset($data['status']) ? (int)$data['status'] : 1;
                    $user->qualification = $data['qualification'] ?? null;
                    $user->password      = Hash::make(12345678);
                    $user->save();

                    $report['inserted']++;
                }

                // 5) Unit / Department وربط الـ pivot (department_users)
                if (!empty($data['unit_name'])) {
                    // لو الوحدة مش موجودة هننشئها ومديرها يبقى المستخدم الحالي كخيار افتراضي صالح FK
                    $unit = Unit::firstOrCreate(['name' => $data['unit_name']], ['manager_id' => $user->id]);



                    if (!empty($data['department_name'])) {
                        $department = Department::firstOrCreate(
                            ['name' => $data['department_name'], 'unit_id' => $unit->id],
                            ['manager_id' => $user->id]
                        );

                        // اربط لو مش مربوط
                        DepartmentUser::firstOrCreate([
                            'user_id'       => $user->id,
                            'unit_id'       => $unit->id,
                            'department_id' => $department->id,
                        ]);
                        $report['linked']++;
                    }
                }
            });

        } catch (\Throwable $e) {
            // ممكن تطبع اللوج لو محتاج
            // logger()->error("Import error at line {$line}: ".$e->getMessage());
            $report['errors']++;

        }

        $line++;
    }

    return back()->with('success', "تم: {$report['inserted']} إضافة | {$report['skipped']} مكررين | {$report['linked']} ربط | {$report['errors']} أخطاء");
}

}
