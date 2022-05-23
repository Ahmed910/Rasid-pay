if (data.type == "{{App\Models\ActivityLog::CREATE}}") {
    return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.created')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::UPDATE}}") {
  return `<span class="badge bg-warning-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.updated')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::DESTROY}}") {
  return `<span class="badge bg-primary-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.destroy')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::RESTORE}}") {
  return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.restored')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::PERMANENT}}") {
  return `<span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.permanent')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::SEARCH}}") {
  return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.searched')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::DEACTIVE}}") {
  return `<span class="badge bg-default-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.deactivated')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::ACTIVE}}") {
  return `<span class="badge bg-success-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.activated')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::TEMPORARY}}") {
  return `<span class="badge bg-warning-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.temporary')"}</span>`;
}
if (data.type == "{{App\Models\ActivityLog::PERMANENT_DELETE}}") {
  return `<span class="badge bg-danger-opacity py-2 px-4">${"@lang('dashboard.activity_log.actions.permanent_delete')"}</span>`;
}
