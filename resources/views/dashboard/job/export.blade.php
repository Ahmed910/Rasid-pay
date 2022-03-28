<div class="row row-sm">
    <div class="col-lg-12">
        <div class="table-responsive p-1">
            <table id="departmentTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                <thead>
                    <tr>
                      <th class="border-bottom-0">#</th>
                      <th class="border-bottom-0">{{ trans('dashboard.job.job_name') }}</th>
                      <th class="border-bottom-0">{{ trans('dashboard.department.department') }} </th>
                      <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }} </th>
                      <th class="border-bottom-0">{{ trans('dashboard.general.status') }}</th>
                      <th class="border-bottom-0">{{ trans('dashboard.general.type') }}</th>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $job->name }}</td>
                            <td>{{ $job->department->name }}</td>
                            <td>{{ $job->created_at }}</td>
                            <td>{{trans('dashboard.general.active_cases')[$job->is_active]}}</td>
                            <td>{{trans('dashboard.general.job_type_cases')[$job->is_vacant]}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
