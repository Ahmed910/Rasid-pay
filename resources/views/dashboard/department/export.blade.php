<div class="row row-sm">
    <div class="col-lg-12">
        <div class="table-responsive p-1">
            <table id="departmentTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">
                            @lang('dashboard.department.department')</th>
                        <th class="border-bottom-0">
                            @lang('dashboard.department.main_department')</th>
                        <th class="border-bottom-0">
                            @lang('dashboard.general.created_at')</th>
                        <th class="border-bottom-0">
                            @lang('dashboard.general.status')</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $index }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->parent->name ?? null }}</td>
                            <td>{{ $department->created_at }}</td>
                            <td>{{ $department->is_active == 1 ? trans('dashboard.general.active') : trans('dashboard.general.inactive') }}
                            </td>
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
