<div class="row row-sm">
    <div class="col-lg-12">
        <div class="table-responsive p-1">
            <table id="departmentTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">{{ trans('dashboard.department.department') }}</th>
                        <th class="border-bottom-0">{{ trans('dashboard.department.main_department') }}</th>
                        <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }}</th>
                        <th class="border-bottom-0">{{ trans('dashboard.general.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ @$department->parent->name ?? null }}</td>
                            <td>{{ $department->created_at }}</td>
                            <td>{{ trans('dashboard.general.active_cases.' . $department->is_active) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
