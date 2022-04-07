<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\{ActivityLog, User};
use App\Models\{Employee};
use App\Models\Department\Department;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Http\Resources\Dashboard\SimpleEmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Providers\AppServiceProvider;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
        $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
    }
        if ($request->ajax()) {
            $activatyLogsQuery = ActivityLog::search($request)
            ->CustomDateFromTo($request)
            ->sortBy($request);

            $activitylogCount = $activatyLogsQuery->count();
            $activitylogs = $activatyLogsQuery->skip($request->start)
                ->take(($request->length == -1) ? $activitylogCount : $request->length)
                ->get();

            return ActivityLogCollection::make($activitylogs)
                ->additional(['total_count' => $activitylogCount]);
        }

        $departments = Department::without("images", 'addedBy')
        ->select("id")
        ->ListsTranslations("name")
        ->pluck('name', 'id');

        $employees = User::whereIn('user_type', ['admin', 'superadmin'])
        ->when(request('department_id'), function ($employees) {
            $employees->whereHas('employee', function ($employees) {
                $employees->where('department_id', request('department_id'));
            });
        })
        ->pluck('fullname', 'id');

        $mainPrograms = collect(AppServiceProvider::MORPH_MAP)->transform(function ($class, $model) {
            $data['name'] = $model;

            $data['trans'] = trans("dashboard." . Str::snake($model) . "." . str_plural(Str::snake($model)));

            return $data;
        })->pluck('trans','name');

        //sub program
        return view('dashboard.activity_log.index',compact('departments','employees','mainPrograms'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        return view('dashboard.activity_log.show');
    }

 // get_Employees by ajax

    public function getEmployees()
    {
        $employees = User::whereIn('user_type', ['admin', 'superadmin'])
            ->when(request('department'), function ($employees) {
                $employees->whereHas('employee', function ($employees) {
                    $employees->where('department_id', request('department'));
                });
            })->get();


            return response()->json([
                'data' => $employees,
                'status' => true,
                'message' => ''
            ]);

    }
// sub program _ ajax
public function getSubPrograms($main_progs = null)
    {
        $subPrograms = collect([]);

        if ($main_progs) {
            $subPrograms = collect(trans('dashboard.' . mb_strtolower($main_progs) . '.sub_progs'))->transform(function ($trans, $key) {

                $data['name'] = trans("dashboard.general." . $key);
                // $data['name'] = $key;
                $data['trans'] = $trans;

                return $data;
            })->values();


        } else {
            $mainPrograms = array_keys(AppServiceProvider::MORPH_MAP);

            foreach ($mainPrograms as $main_progs) {
                $subPrograms[] =  collect(trans('dashboard.' . mb_strtolower(Str::snake($main_progs)) . '.sub_progs'))->transform(function ($trans, $key) {
                    $data['name'] = $key;
                    $data['trans'] = $trans;

                    return $data;
                })->values();
            }

            $subPrograms = $subPrograms->flatten(1);
        }

        return response()->json([
            'data' => $subPrograms,
            'status' => true,
            'message' => ''
        ]);
    }








}
