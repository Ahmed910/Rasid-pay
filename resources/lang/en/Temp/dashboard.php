<?php
return [
    'department' => [
        'main_department' => 'Main Department',
        'department_count' => '',
        'permissions' =>  [
            'restore' => 'Restore',
            'update' => 'Modify',
            'archive' => 'Show archive',
            'show' => 'Show',
            'get_parents' => 'Show main departments',
            'force_delete' => 'Permanently delete',
            'store' => 'Save',
            'index' => 'Record',
            'destroy' => 'Archive',
        ],
        'sub_progs' => [
            'archive' => 'Archieve Department',
            'create' => 'Add Department ',
            'show' => 'Show Department ',
            'index' => 'Department Records',
        ],
        'department_has_relationship_cannot_delete' => 'This department has sub department ,so you cannot delete it',
        'department_archive' => 'Department Archive',
        'without_parent' => 'Without Main Department',
        'without' => 'Without Department',
        'edit_department' => '',
        'department_image' => 'Department Image',
        'department_name' => 'Department Name',
        'select_main_department' => 'Select Main Department',
        'add_department' => 'Add Department',
        'name' => 'Department Name',
        'departments' => 'Departments',
        'department' => 'Department',
    ],
    'rasid_job' => [
        'edit_rasid_job' => 'Edit Job',
        'job_count' => 'Job Count',
        'jobs_hired_archived' => ' can\'t archive this rasid_job ',
        'permissions' =>  [
            'restore' => 'Restore',
            'index' => 'Record',
            'force_delete' => 'Permanently delete',
            'show' => 'Show',
            'destroy' => 'Archive',
            'archive' => 'Show archive',
            'update' => 'Modify',
            'store' => 'Save',
        ],
        'sub_progs' => [
            'show' => 'Show Job',
            'index' => 'Jobs Record',
            'create' => 'Add Job',
            'archive' => 'Jobs Archive',
        ],
        'is_vacant' => [
            'false' => 'Vacant',
            'true' => 'Busy',
        ],
        'name' => 'Job Name',
        'add_rasid_job' => 'Add Job',
        'jobs' => 'Jobs',
        'select_department' => 'Select Department',
        'validation' =>  [
            'name_must_be_unique_on_department' => 'The rasid_job title was previously selected for the same department',
        ],
        'department' => 'Department',
        'job_description' => 'Job Description',
        'rasid_job' => 'Job',
        'rasid_job_count' => 'Job Count',
        'rasid_job_description' => 'Description',
        'rasid_job_department' => 'Department Name',
        'jobs_hired_deleted' => ' can\'t delete this rasid_job ',
        'add_job' => 'Add Job',
        'rasid_jobs' => 'Jobs',
        'edit_job' => 'Edit Job',
        'job_name' => 'Job Name',
        'employee_name' => 'Employee Name',
    ],
    'transaction' => [
        'enter_to_user_client' => 'Enter Client Name',
        'user_identity' => 'User Identity',
        'type_cases' => [
            'charge' => 'Charge',
            'wallet_transfer' => 'wallet transfer',
            'transfer' => 'Transfer',
            'pay' => 'Pay',
            'money_request' => 'Money Request',
        ],
        'choose_card' => 'Choose Card',
        'transaction_number' => 'Transaction Number',
        'enter_user_identity' => 'Enter User Identity',
        'total_amount' => 'Total Amount',
        'status_cases' => [
            'pending' => 'Pending',
            'cancel' => 'Cancel',
            'received' => 'Received',
            'success' => 'Success',
            'fail' => 'Fail',
        ],
        'active_card' => 'Active Card',
        'enter_transaction_amount' => 'Enter Transaction Amount',
        'transaction_amount_from' => 'Transaction Amount From',
        'transactions' => 'Transactions',
        'enter_from_user' => 'Enter User Name',
        'sub_progs' => [
            'index' => 'Transaction Records',
            'archive' => 'Archive Transaction',
            'show' => 'Show Transaction ',
        ],
        'enter_transaction_date' => 'Enter Transaction Date',
        'choose_client_name' => 'Choose Client Name',
        'transaction_type' => 'Transaction Type',
        'transaction' => 'Transaction',
        'to_user_client' => 'Client To',
        'card_cases' =>  [
            'golden' => 'Golden',
            'basic' => 'Basic',
            'platinum' => 'Platinum',
        ],
        'choose_status' => 'Choose Status',
        'gift_balance' => 'Gift Balance',
        'transaction_date' => 'Transaction Date',
        'enter_transaction_number' => 'Enter Transaction Number',
        'transaction_amount' => 'Transaction Amount',
        'from_user' => 'User From',
        'transaction_date_to' => 'Transaction Date To',
        'enter_total_amount' => 'Enter Total Amount',
        'choose_type' => 'Choose Type',
        'transaction_date_from' => 'Transaction Date From',
        'transaction_status' => 'Transaction Status',
        'transaction_amount_to' => 'Transaction Amount To',
    ],
    'general' =>  [
        'description' => 'Description',
        'force_delete' => 'Permanent Delete',
        'no_search_result' => 'No search results availables',
        'notifications' => 'Notifications',
        'job_type_cases' => [
            1 => 'Available',
            0 => 'Occupied',
        ],
        'there_is_no_data' => 'There is no data available',
        'delete' => 'Delete',
        'success_update' => 'Updated Successfully',
        'Total_temporary_users' => 'Temporary Users',
        'logout' => 'Logout',
        'all_cases' => 'All',
        'Total_unvacant_jobs' => 'Unvacant Jobs',
        'upload_error' => 'Oh, something went wrong',
        'actions' => 'Actions',
        'email' => 'Email',
        'show' => 'Show',
        'create' => 'Create',
        'confirm' => 'Confirm',
        'change_password' => 'Change _password',
        'status' => 'Status',
        'personalfile' => 'Personal Account',
        'success_delete' => 'Deleted Successfully',
        'want_saving' => 'Do You Want To Save ?',
        'success_restore' => 'Restored Successfully',
        'activited' => 'Activited',
        'cancel' => 'Cancel',
        'hold_change' => 'Drag and drop or tap to change the image',
        'active' => 'Active',
        'show_all' => 'Show All',
        'send' => 'Send',
        'no_reasons' => 'No reasons',
        'report' => 'Print Report',
        'sent_successfully' => 'Sent Successfully',
        'Total_departments' => 'Departments',
        'close' => 'Close',
        'hold_upload' => 'Drag and drop or upload the image',
        'archive' => 'Archive',
        'from_date' => 'Creation Date (From]',
        'type' => 'Type',
        'to_date' => 'Creation Date (To]',
        'enter_description' => 'Enter Description',
        'restore' => 'Restore',
        'yes' => 'Yes',
        'upload_file_max' => 'File size is large',
        'created_at' => 'Creation Date',
        'want_back_without_saving' => 'Do You Want Back Without Saving ?',
        'Permission_field_required' => 'Permission Field Required',
        'fail_send' => 'Sending Failed',
        'search' => 'Search',
        'Send VerificationCode' => 'Send VerificationCode ',
        'back' => 'Back',
        'index' => 'Index',
        'all' => 'All',
        'Total_employees' => 'Employees',
        'the_archive' => 'The Archive',
        'invalid_code' => 'code is wrong ',
        'accept' => 'Accept',
        'to' => 'To',
        'select_status' => 'Select Status',
        'enter_name' => 'Enter Name',
        'active_cases' => [
            1 => 'Inactive',
            0 => 'Active',
        ],
        'success_send_login_code' => 'The verification code has been sent to the mobile number',
        'dashboard' => 'Rasid Jack Dashboard',
        'unactivited' => 'Unactivited',
        'show_all notification' => 'Show All Notifications',
        'reason_required' => 'Reason Is Required',
        'from' => 'From',
        'select_permissions' => 'Select Permissions',
        'Total_permenant_users' => 'Permenant Users',
        'day_month_year' => 'day/month/year',
        'inactive' => 'Inactive',
        'settings' => 'Settings',
        'no' => 'No',
        'success_archive' => 'Archived Successfully',
        'select_user' => 'Select User',
        'success_add' => 'Created Successfully',
        'showing' => 'Showing',
        'export' => 'Export',
        'save' => 'Save',
        'un_active_account' => 'Account is unactive',
        'Total_vacant_jobs' => 'Vacant Jobs',
        'reason' => 'Reason',
        'no_data' => 'No Data',
        'done_by' => 'Done By',
        'has_relationship_cannot_delete' => 'This item has relationships ,so you cannot delete it',
        'Total_active_users' => 'Active Users  ',
        'black_menu' => 'Black Menu',
        'edit' => 'Edit',
        'details' => 'Details',
        'select_type' => 'Select Type',
        'notAllowdedToUpload' => 'File type is not allowded to be uploaded',
        'entries' => 'Entries',
    ],
    'datatable' => [
        'from' => 'from',
        'no_data' => 'No D ata ',
        'there_is_no_data' => 'There is No Data    ',
        'no_search_result' => 'No Search Result    ',
        'to' => 'to',
        'showing' => 'showing',
        'entries' => 'entries',
    ],
    'activity_log' => [
        'actions' => [
            'created' => 'Create',
            'activated' => 'Activate',
            'temporary' => 'Temporary Ban ',
            'permanent_delete' => 'Delete',
            'deactivated' => 'Deactivate',
            'restored' => 'Restore',
            'permanent' => 'Permanent Ban',
            'destroy' => 'Archieve',
            'updated' => 'Update',
            'searched' => 'Search',
        ],
        'sub_progs' =>  [
            'create' => 'Create',
            'show' => 'Show ActivityLog ',
            'ban_status' => 'Ban Status',
            'index' => 'Activitylogs Record ',
            'archive' => 'Archive',
        ],
        'select_mainprogram' => ' Select MainProgram',
        'reason' => ':user did :action',
        'history' => 'History ',
        'sub_program' => ' Sub Program',
        'select_employee' => 'Select Employee',
        'activity' => 'Activity',
        'main_program' => 'Main Program',
        'activity_logs' => 'Activity Logs',
        'select_subprogram' => ' Select SubProgram',
        'ip_address' => 'ip_address',
        'select_activity' => 'Select Activity ',
        'activity_log' => ' Activity Log',
        'date' => 'Activity Date',
    ],
    'admin' =>  [
        'permission_system' => 'Permission System',
        'edit_admin' => 'Edit Admin',
        'ban_from' => 'Ban Date (From]',
        'admin_name' => 'Admin_Name',
        'admins' => 'Admins',
        'permissions' =>  [
            'index' => 'Record',
            'create' => 'Show Admins',
            'update' => 'Modify',
            'destroy' => 'Archive',
            'show' => 'Show',
            'store' => 'Save',
        ],
        'sub_progs' => [
            'index' => 'Follow Up',
            'archive' => 'Admins Archive',
            'show' => 'Show Admin',
            'create' => 'Add Admin ',
        ],
        'admin_count' => 'Admins Count',
        'name' => 'Admin Name ',
        'active_cases' =>  [
            'temporary' => 'Ban Temporary',
            'active' => 'Active',
            'permanent' => 'Ban Permnent',
        ],
        'email' => 'Email',
        'login_id' => 'Login_id ',
        'admin' => 'Admin',
        'job' => 'Job',
        'number' => 'Admin Number',
        'phone' => 'Phone',
        'confirmed_password' => 'Confirmed Password',
        'add_admin' => 'Add Admin',
        'ban_to' => ' Ban Date (To]',
        'new_password' => 'New Password',
    ],
    'static_page' =>   [
        'permissions' =>  [
            'update' => 'Update Static Pages',
            'store' => 'Store Static Pages',
            'index' => 'Static Page Index',
            'destroy' => 'Delete Static Pages',
        ],
        'static_pages' => 'Static Pages',
    ],
    'profile' =>  [
        'edit_profile' => '',
        'profile' => 'Profile',
        'profile_count' => '',
        'profiles' => 'Profiles',
        'show_profile' => '',
    ],
    'package' =>   [
        'cards_discount_records' => 'Cards Discount Records',
        'platinum_card_discount' => 'Platinum Card Discount',
        'discount_success_add' => 'Card discounts have been added to client ',
        'enter_discount' => 'Enter discount',
        'basic_card_discount' => 'Basic Card Discount',
        'choose_client' => 'Choose Client',
        'discount_success_update' => 'Card discounts have been updated to client ',
        'cards_discount' => 'Cards discount',
        'golden_card_discount' => 'Golden Card Discount',
    ],
    'cardpackage' =>   [
        'golden' => 'Golden',
        'cardpackages' => 'Card Packages',
        'platinum' => 'Platinum',
        'basic' => 'Basic',
    ],
    'client' =>  [
        'permissions' =>   [
            'show' => 'Show',
            'create' => 'Show Client',
            'update' => 'Modify',
            'store' => 'Save',
            'destroy' => 'Archive',
            'index' => 'Record',
        ],
        'client_type' =>   [
            'member' => 'Member',
            'other' => 'Other',
            'freelance_doc' => 'Freelance_doc',
            'company' => 'Company',
            'famous' => 'Famous',
            'institution' => 'Institution',
        ],
        'account_status' => 'Account Status',
        'admin_client' => 'admin_client',
        'account_statuses' =>  [
            'pending' => 'Pending',
            'refused' => 'Refused',
            'reviewed' => 'Reviewed',
            'accepted' => 'Accepted',
            'before_review' => 'Before_review',
        ],
        'type' => 'Client Type',
        'client' => 'client',
        'edit_client' => 'edit_client',
        'tax_number' => 'Tax Number ',
        'commercial_number' => 'Commercial Number',
        'add_client' => 'add_client',
        'transactions_done' => 'Transactions Done',
        'clients' => 'clients',
        'bank_name' => 'Related Bank',
        'name' => 'Client Name',
    ],
    'contact' => [
        'permissions' =>    [
            'delete_contact' => 'delete contact message',
            'index' => 'contact messages',
            'reply' => 'reply on contact message',
            'delete_reply' => 'delete reply on contact message',
            'show' => 'show contact message',
        ],
        'contacts' => 'Support',
        'types' => [
            'suggestions' => 'Suggestions',
            'inquiries' => 'Inquiries',
            'complain' => 'Complain',
        ],
        'contact' => 'Support',
    ],
    'bank' =>  [
        'permissions' => [
            'show' => 'Show',
            'force_delete' => 'Permanently delete',
            'destroy' => 'Archive',
            'store' => 'Save',
            'index' => 'Record',
            'restore' => 'Restore',
            'archive' => 'Show archive',
            'update' => 'Modify',
        ],
        'bank_count' => 'Banks Count',
        'Enter_service_Number' => 'Enter_service_Number',
        'edit_bank' => 'Edit Bank',
        'sub_progs' =>  [
            'index' => 'سجل البنوك',
            'show' => 'عرض البنك',
            'archive' => 'أرشيف البنوك',
            'create' => 'اضافة بنك',
        ],
        'type' => ' type',
        'add_bank' => 'Add Bank',
        'Enter_Bank_name' => 'Enter Bank Name ',
        'Enter_transfer_amount' => 'Enter_transfer_amount',
        'serviceNumber' => 'serviceNumber ',
        'commercialRecord' => 'commercialRecord ',
        'code' => 'code',
        'Enter_bank_code' => 'Enter_bank_code',
        'card_cases' =>  [
            'basic' => 'Basic',
            'platinum' => 'Platinum',
            'golden' => 'Golden',
        ],
        'Enter_bank_location' => 'Enter_bank_location ',
        'BranchName' => 'BranchName ',
        'bank' => 'Bank',
        'taxNumber' => 'taxNumber ',
        'Enter_commercial_Record' => ' Enter_commercial_Record ',
        'Enter_Bank_branch_name' => 'Enter_Bank_branch_name',
        'types' =>  [
            'islamic' => 'Islamic',
            'centeral' => 'Central',
            'investment' => 'Investment ',
        ],
        'bank_name' => 'Bank Name',
        'location' => 'location',
        'transaction_Value_From' => 'transaction_Value_From',
        'Enter_tax_Number' => 'Enter_tax_Number',
        'banks' => 'Banks',
        'Add new Branch' => ' Add new Branch ',
    ],
    'country' => [
        'permissions' => [
            'store' => 'Save',
            'archive' => 'Show archive',
            'update' => 'Modify',
            'show' => 'Show',
            'index' => 'Record',
            'force_delete' => 'Permanently delete',
            'restore' => 'Restore',
            'destroy' => 'Archive',
        ],
        'countries' => 'Countries',
        'add_country' => 'Add Country',
        'country' => 'Country',
        'edit_country' => 'Edit Country',
        'country_count' => 'Countries Count',
    ],
    'citizens' => [
        'edit_phone' => 'Edit Phone Number',
        'card_end_at_to' => 'Card Expiry Date (to]',
        'name' => 'Name',
        'card_end_at_from' => 'Card Expiry Date (from]',
        'identity_number' => 'Identity Number',
        'enabled_package' => 'Activated Card',
        'created_at_from' => 'Registration Date (from]',
        'citizens' => 'Users',
        'card_end_at' => 'Card Expiry Date',
        'phone' => 'Phone Number',
        'choose_card' => 'Choose Card',
        'enter_phone' => 'Enter Phone Number',
        'new_phone' => 'New Phone Number',
        'created_at_to' => 'Registration Date (to]',
        'created_at' => 'Registration Date',
    ],
    'currency' => [
        'permissions' =>  [
            'store' => 'Save',
            'show' => 'Show',
            'destroy' => 'Archive',
            'archive' => 'Show archive',
            'force_delete' => 'Permanently delete',
            'restore' => 'Restore',
            'index' => 'Record',
            'update' => 'Modify',
        ],
        'currency_count' => '',
        'currency' => 'Currency',
        'countries' => 'Currencies',
        'edit_currency' => '',
        'add_currency' => '',
    ],
    'notification' =>  [
        'permissions' =>   [
            'store' => 'Notification',
        ],
        'notification' => 'Notification',
        'notifications' => 'Notifications',
        'notification_count' => 'Notifications Count',
    ],
    'group' =>   [
        'chosen_groups' => 'Chosen_Groups ',
        'permissions' =>  [
            'store' => 'Save',
            'destroy' => 'Archive',
            'create' => 'Show side menu',
            'index' => 'Record',
            'show' => 'Show',
            'update' => 'Modify',
        ],
        'add_group' => 'Add a group',
        'sub_progs' =>  [
            'index' => ' Groups Record',
            'archive' => ' Groups Archive',
            'create' => 'Add Group ',
        ],
        'edit_group' => '',
        'group_count' => '',
        'sorry_group_name_is_repeated' => 'Sorry Group Name Is Repeated',
        'groups' => 'Admin groups',
        'group' => 'Admin group',
    ],
    'permission' => [
        'permissions' => 'Permissions',
    ],
    'localization' =>  [
        'permissions' =>  [
            'update' => 'Localizations Store',
            'index' => 'Localizations Index',
        ],
        'localizations' => 'Localizations',
    ],
    'region' =>  [
        'region' => 'Region',
        'permissions' =>  [
            'index' => 'Record',
            'show' => 'Show',
            'store' => 'Save',
            'archive' => 'Show archive',
            'restore' => 'Restore',
            'destroy' => 'Archive',
            'update' => 'Modify',
            'force_delete' => 'Permanently delete',
        ],
        'add_region' => '',
        'edit_region' => '',
        'regions' => 'Regions',
        'region_count' => '',
    ],
    'setting' => [
        'permissions' => [
            'store' => 'Save',
            'restore' => 'Restore',
            'update' => 'Modify',
            'archive' => 'Show archive',
            'force_delete' => 'Permanently delete',
            'destroy' => 'Archive',
            'show' => 'Show',
            'index' => 'Record',
        ],
        'setting' => 'Setting',
        'settings' => 'Settings',
        'setting_count' => '',
        'add_setting' => '',
    ],
    'error' =>  [
        'method_not_allow' => 'Http method (:method] not allowed',
        'name_must_be_unique_on_department' => 'This job already exists for this department',
        'something_went_wrog' => 'The data entered is incorrect',
        'page_not_found' => '404, Page not found!',
        'not_found' => 'Model Not Found!',
    ],
    'home' =>  [
        'permissions' => [
            'show' => 'show',
        ],
        'home' => 'Home',
    ],
    'employee' => [
        'permissions' => [
            'destroy' => 'Archive',
            'update' => 'Modify',
            'store' => 'Save',
            'index' => 'Record',
            'create' => 'Show Employees',
            'show' => 'Show',
        ],
        'sub_progs' =>  [
            'index' => ' Employees Record',
            'create' => 'Add Employee ',
            'archive' => 'Employess Archive ',
        ],
        'employee_count' => 'Employees Count',
        'employee' => 'Emplyee',
        'employees' => 'Employees',
        'edit_employee' => 'Edit Employee',
        'add_employee' => 'Add Employee',
    ],
    'message' =>  [
        'sub_progs' => [
            'show_all messages' => 'Show All Messages',
        ],
        'messages' => 'Messages',
    ],
    'attributes' => [
        'name' => 'Name in Arabic',
        'description' => 'Description in Arabic',
    ],
    'user' => [
        'users' => 'Users',
    ],
    'chat' => [
        'chats' => 'Chats',
    ],
    'localizations_update' => [
        'localizations_update' => 'Localizations Update',
    ],
    'device' =>   [
        'devices' => 'Devices',
    ],
];