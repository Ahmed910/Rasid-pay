<?php
$permissions = [
    'read' => 'Read',
    'store' => 'Save',
    'update' => 'Update',
    'archive' => 'Archive',
    'restore' => 'Restore',
    'force_delete' => 'Permanent Delete',
];
return [
    'general' => [
        "success_add" => "Created Successfully",
        "success_delete" => "Deleted Successfully",
        "success_update" => "Updated Successfully",
        "success_archive" => "Archived Successfully",
        "success_restore" => "Restored Successfully",
        "has_relationship_cannot_delete" => "This item has relationships ,so you cannot delete it",
        "save" => "Save",
        "edit" => "Edit",
        "show" => "Show",
        "archive" => "",
        "restore" => "",
        "force_delete" => "",
        'not_found' => 'Not Found',
        'sent_successfully' => 'Sent Successfully',
    ],
    'activity_log' => [
        "reason" => ":user did :action",
    ],
    "country" => [
        "country" => "Country",
        "countries" => "Countries",
        "add_country" => "",
        "edit_country" => "",
        "country_count" => "",
        'permissions' => $permissions
    ],
    "currency" => [
        "currency" => "Currency",
        "countries" => "Currencies",
        "add_currency" => "",
        "edit_currency" => "",
        "currency_count" => "",
        'permissions' => $permissions
    ],
    "department" => [
        "department" => "Department",
        "departments" => "Departments",
        "add_department" => "",
        "edit_department" => "",
        "department_count" => "",
        'permissions' => $permissions
    ],
    "job"=>[
        "job" => "Job",
        "jobs" => "Jobs",
        "add_job" => "",
        "edit_job" => "",
        "job_count" => "",
        'permissions' => $permissions
    ],
    "setting"=>[
        "setting" => "Setting",
        "settings" => "Settings",
        "add_setting" => "",
        "setting_count" => "",
        'permissions' => $permissions
    ],
];
