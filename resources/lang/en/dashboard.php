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
        'sent_successfully' => 'Sent Successfully',

    ],
    'error' => [
        'method_not_allow' => 'Http method (:method) not allowed',
        'not_found' => 'Model Not Found!',
        'page_not_found' => '404, Page not found!',
    ],
    'activity_log' => [
        "reason" => ":user did :action",
    ],
    "country" => [
        "country" => "Country",
        "countries" => "Countries",
        "add_country" => "Add Country",
        "edit_country" => "Edit Country",
        "country_count" => "Countries Count",
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
    "job" => [
        "job" => "Job",
        "jobs" => "Jobs",
        "add_job" => "",
        "edit_job" => "",
        "job_count" => "",
        'permissions' => $permissions
    ],
    "setting" => [
        "setting" => "Setting",
        "settings" => "Settings",
        "add_setting" => "",
        "setting_count" => "",
        'permissions' => $permissions
    ],
    "profile" => [
        "profile" => "Profile",
        "profiles" => "Profiles",
        "show_profile" => "",
        "edit_profile" => "",
        "profile_count" => "",
    ],
    "admin" => [
        "admin" => "Admin",
        "admins" => "Admins",
        "add_admin" => "Add Admin",
        "edit_admin" => "Edit Admin",
        "admin_count" => "Admins Count",
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['hold' => 'Hold']
    ],
    "region" => [
        "region" => "Region",
        "regions" => "Regions",
        "add_region" => "",
        "edit_region" => "",
        "region_count" => "",
        'permissions' => $permissions
    ],
];
