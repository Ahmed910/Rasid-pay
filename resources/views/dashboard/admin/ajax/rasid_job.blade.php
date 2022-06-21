{!! Form::select('rasid_job_id', ['' => ''] + $rasid_jobs, null, ['class' =>
'form-control select2-show-search', 'id' => 'rasid_job_id', 'data-placeholder' =>
trans('dashboard.rasid_job.select_job')]) !!}
<span class="text-danger" id="rasid_job_idError"></span>
<script>
    $("#rasid_job_id").select2();
</script>
