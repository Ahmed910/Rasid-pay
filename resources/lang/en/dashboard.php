<?php
$permissions = [
    'index' => 'Record',
    'show' => 'Show',
    'store' => 'Save',
    'update' => 'Modify',
    'destroy' => 'Archive',
    'archive' => 'Show archive',
    'restore' => 'Restore',
    'force_delete' => 'Permanently delete',
];
return [
    'attributes' => [
        'name' => 'Name in Arabic',
        'description' => 'Description in Arabic',
    ],

    'datatable' => [
        'show' => 'Show :menu'
    ],
    'general' => [
        "success_add" => "Created Successfully",
        "success_delete" => "Deleted Successfully",
        "success_update" => "Updated Successfully",
        "success_archive" => "Archived Successfully",
        "success_restore" => "Restored Successfully",
        "has_relationship_cannot_delete" => "This item has relationships ,so you cannot delete it",
        'close'=>'Close',
        'yes'=>'Yes',
        'no' => 'No',
        'want_saving'=>'Do You Want To Save ?',
        'reason_required' => 'Reason Is Required',
        'want_back_without_saving' => 'Do You Want Back Without Saving ?',
        "save" => "Save",
        "back" => "Back",
        "edit" => "Edit",
        "show" => "Show",
        "archive" => "Archive",
        "restore" => "Restore",
        "force_delete" => "Permanent Delete",
        'sent_successfully' => 'Sent Successfully',
        'success_send_login_code' => 'The verification code has been sent to the mobile number',
        'fail_send' => 'Sending Failed',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'activited' => 'Activited',
        'unactivited' => 'Unactivited',
        'dashboard' => 'Rasid Jack Dashboard',
        "status" => "Status",
        "select_status" => "Select Status",
        "type" => "Type",
        "select_type" => "Select Type",
        "from_date" => "Creation Date (From)",
        "to_date" => "Creation Date (To)",
        "search" => "Search",
        "show_all" => "Show All",
        "created_at" => "Creation Date",
        'create' => 'Create',
        "actions" => "Actions",
        "active_cases" => [
            'Active',
            'Inactive',
        ],
        'job_type_cases' => [
            'Occupied',
            'Available',
        ],
        'all' => 'All',
        'description' => 'Description',
        'day_month_year' => 'day/month/year',
        'export' => 'Export',
        'details' => 'Details',
        'no_data' => 'No Data',
        'reason' =>'Reason',
        'done_by' => 'Done By',
        'there_is_no_data' => 'There is no data available',
        'showing' => 'Showing',
        'to' => 'To',
        'from' => 'From',
        'entries' => 'Entries',
        'delete' => 'Delete',
        'no_search_result' => 'No search results availables',
        'hold_upload' => 'Drag and drop or upload the image',
        'hold_change' => 'Drag and drop or tap to change the image',
        'upload_error' => 'Oh, something went wrong',
        'upload_file_max' => 'File size is large',
        'notAllowdedToUpload' => 'File type is not allowded to be uploaded',
        "active_cases" => [
            'Active',
            'Unactive',
        ],
        'the_archive' => 'The Archive',

    ],
    'error' => [
        'method_not_allow' => 'Http method (:method) not allowed',
        'not_found' => 'Model Not Found!',
        'page_not_found' => '404, Page not found!',
        'something_went_wrog' => 'The data entered is incorrect',
        'name_must_be_unique_on_department' => 'This job already exists for this department'
    ],
    'home' => [
        'home' => 'Home',
        'permissions' => [
            "show" => "show",
        ],
    ],
    'activity_log' => [
        "activity_log" => " Activity Log",
        "activity_logs" => "Activity Logs",
        "reason" => ":user did :action",
        "date" =>"Activity Date",
        "activity" => "Activity",
        'history' => 'History ',
        'actions' => [
            'created' => 'Create',
            'updated' => 'Update',
            'destroy' => 'Archieve',
            'restored' => 'Restore',
            'permanent_delete' => 'Delete',
            'searched' => 'Search',
            'deactivated' => 'Deactivate',
            'activated' => 'Activate',
            'permanent' => 'Permanent Ban',
            'temporary' => 'Temporary Ban ',

        ],
        'sub_progs' => [
            'index' => 'Activitylogs Record ',
            'show' => 'Show ActivityLog ',

        ],

    ],
    "country" => [
        "country" => "Country",
        "countries" => "Countries",
        "add_country" => "Add Country",
        "edit_country" => "Edit Country",
        "country_count" => "Countries Count",
        'permissions' => $permissions
    ],
    "group" => [
        "group" => "Admin group",
        "groups" => "Admin groups",
        "add_group" => "Add a group",
        "edit_group" => "",
        "group_count" => "",
        'sub_progs' => [
            'index' => ' Groups Record',
            'archive' => ' Groups Archive',
            'create' => 'Add Group ',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'Show side menu']
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
        "department_image" => "Department Image",
        "add_department" => "Add Department",
        "main_department" => "Main Department",
        "department_name" => "Department Name",
        'select_main_department' => 'Select Main Department',
        'name' => 'Department Name',
        "edit_department" => "",
        "department_count" => "",
        "department_has_relationship_cannot_delete" => "This department has sub department ,so you cannot delete it",
        'permissions' => $permissions + ['get_parents' => 'Show main departments'],
        'without_parent' => 'Without',
        'department_archive' => 'Department Archive',
        'sub_progs' => [
            'index' => 'Department Records',
            'archive' => 'Archieve Department',
            'create' => 'Add Department ',
            'show' => 'Show Department ',

        ],

    ],
    "rasid_job" => [
        "rasid_job" => "Job",
        "rasid_jobs" => "Jobs",
        "add_rasid_job" => "Add Job",
        "edit_rasid_job" => "Edit Job",
        "rasid_job_count" => "Job Count",
        "rasid_job_department" => "Department Name",
        "name" => "Job Name",
        "employee_name" => "Employee Name ",
        "rasid_job_description" => "Description",
        "validation" => [
            'name_must_be_unique_on_department' => 'The job title was previously selected for the same department'
        ],
        'sub_progs' => [
            'index' => 'Jobs Record',
            'archive' => 'Jobs Archive',
            'create' => 'Add Job',
            'show' => 'Show Job'
        ],
        'is_vacant' => [
            'true' => 'Busy',
            'false' => 'Vacant',
        ],

        "jobs_hired_deleted" => " can't delete this job ",
        "jobs_hired_archived" => " can't archive this job ",
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
        'sub_progs' => [
            'index' => 'Admins Rescord ',
            'archive' => 'Admins Archive',
            'create' => 'Add Admin ',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'Show Admins']
    ],
    "region" => [
        "region" => "Region",
        "regions" => "Regions",
        "add_region" => "",
        "edit_region" => "",
        "region_count" => "",
        'permissions' => $permissions
    ],
    "employee" => [
        "employee" => "Emplyee",
        "employees" => "Employees",
        "add_employee" => "Add Employee",
        "edit_employee" => "Edit Employee",
        "employee_count" => "Employees Count",
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'Show Employees'],
        'sub_progs' => [
            'index' => ' Employees Record',
            'archive' => 'Employess Archive ',
            'create' => 'Add Employee ',
        ],
    ],
    "bank" => [
        "bank" => "Bank",
        "banks" => "Banks",
        "add_bank" => "Add Bank",
        "edit_bank" => "Edit Bank",
        "bank_count" => "Banks Count",
        'permissions' => $permissions
    ],
    'job' => [
        "job" => "Job",
        "jobs" => "Jobs",
        "add_job" => "Add Job",
        "edit_job" => "Edit Job",
        "job_count" => "Job Count",
        "job_name" => "Job Name",
        "department" => "Department",
        "select_department" => "Select Department",
        "employee_name" => "Employee Name",
        "job_description" => "Job Description",
        'sub_progs' => [
            'index' => 'Jobs Record',
            'archive' => 'Jobs Archive',
            'create' => 'Add Job',
        ],
    ],
    "notification" => [
        "notification" => "Notification",
        "notifications" => "Notifications",
        "notification_count" => "Notifications Count",
        'permissions' => ['store' => 'Notification']
    ],
    'contact' => [
        'contact'        => 'Support',
        'contacts'       => 'Support',
        'index'          => 'Support Messages',
        'show'           => 'Show Support Message',
        'reply'          => 'Reply On Support Message',
        'delete_contact' => 'Delete Support Message',
        'delete_reply'   => 'Delete Support Reply',
    ],
    "client" => [
        "client" =>  "client",
        "clients" => "clients",
        "add_client" => "add_client",
        "edit_client" => "edit_client",
        "admin_client" => "admin_client",
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'Show Client']
    ],
    'user' => [
        'users' => 'Users'
    ],
    'chat' => [
        'chats' => 'Chats'
    ],
    'device' => [
        'devices' => 'Devices'
    ],
    'message' => [
        'messages' => 'Messages'
    ],
    'permission' => [
        'permissions' => 'Permissions'
    ]
];
