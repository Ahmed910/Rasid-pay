<?php

$permissions = [
    'index' => 'السجل',
    'show' => 'عرض',
    'store' => 'حفظ',
    'update' => 'تعديل',
    'destroy' => 'أرشفة',
    'archive' => 'عرض أرشيف',
    'restore' => 'استعادة',
    'force_delete' => 'حذف نهائي',
];

return [
    'attributes' => [
        'name' => 'الاسم',
        'description' => 'الوصف',
        'nationality' => 'الجنسية',
    ],
    'datatable' => [
        'show :menu' => 'عرض :menu'
    ],
    'general' => [
        "delete"=>"حذف",
        "no_reasons" => "لايوجد",
        "success_add" => "تمت الإضافة بنجاح",
        "success_delete" => "تم الحذف بنجاح",
        "success_update" => "تم التعديل بنجاح",
        "success_archive" => "تمت الأرشفة بنجاح",
        "success_restore" => "تم الاستعادة بنجاح",
        "Send VerificationCode" => "إرسال رمز التحقق",
        'change_password'=>'تغيير كلمة المرور',
        "has_relationship_cannot_delete" => "لا يمكن حذف هذا العنصر ،بسبب احتواءه علي علاقات",
        'yes' => 'موافق',
        'no' => 'غير موافق',
        'want_saving' => 'هل تريد اتمام عملية الحفظ ؟',
        'want_force_delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
        "want_restore"=>"هل تريد إتمام عملية الاستعادة؟",
        'reason_required' => 'السبب مطلوب',
        'want_back_without_saving' => 'هل تريد العوده دون الحفظ ؟',
        'close' => 'اغلاق',
        "save" => "حفظ",
        "index" => "عرض",
        "back" => "عودة",
        "edit" => "تعديل",
        'add' => 'إضافة',
        "show" => "عرض",
        "archive" => "أرشفة",
        "restore" => "استعادة",
        "force_delete" => "حذف نهائي",
        'sent_successfully' => 'تم الارسال بنجاح',
        'success_send_login_code' => 'تم ارسال كود التحقق الى رقم الجوال',
        'phone'=> 'رقم الجوال',
        'phone_code' =>"حقل رقم الجوال مطلوب",
        'phoneCode_registeration'=>"رقم الجوال غير مسجل بالنظام",
        'digits_between' =>"يجب أن يحتوي حقل الجوال بين 5 و 20 رقمًا/أرقام .
        ",
        'fail_send' => 'فشل عملية الارسال',
        'invalid_code'=>'رمز التحقق غير صحيح',
        'active' => 'مفعل',
        'inactive' => 'معطل',
        'activited' => 'تفعيل',
        'un_active_account'=>'هذا المستخدم معطل',
        'unactivited' => 'تعطيل',
        'dashboard' => 'لوحة تحكم رصيد جاك',
        "status" => "الحالة",
        "select_status" => "اختر الحالة",
        "select_user" => "اختر مستخدم",
        'select_permissions'=>'اختر الصلاحيات',
        "type" => "النوع",
        "select_type" => "اختر النوع",
        "from_date" => "تاريخ الإنشاء (من)",
        "to_date" => "تاريخ الإنشاء (إلى)",
        "search" => "بحث",
        "show_all" => "عرض الكل",
        "created_at" => "تاريخ الإنشاء",
        'create' => 'إضافة',
        "actions" => "العمليات",
        'enter_name'=>'أدخل الاسم',
        'enter_description'=>'أدخل الوصف',
        "notifications"=>"الاشعارات",
        "show_all notification"=>"مشاهدة كل الإشعارات",
        "personalfile" =>"الملف الشخص",
        "active_cases" => [
            'معطلة',
            'مفعلة',
        ],
        'job_type_cases' => [
            'مشغولة',
            'شاغرة',
        ],
        'all_cases' =>'الجميع',
        'all' => 'الكل',
        'description' => 'الوصف',
        'day_month_year' => 'يوم/شهر/سنة',
        'export' => 'تصدير',
        'report' => 'طباعة تقرير',
        'details' => 'التفاصيل',
        'email' => 'البريد الإلكتروني',
        'hold_upload' => 'اسحب وأسقط او قم برفع الصورة',
        'hold_change' => 'اسحب وأسقط او إضغط لتغيير الصورة',
        'upload_error' => 'اوبس ، حدث خطأ ما',
        'upload_file_max' => 'حجم الملف كبير',
        'notAllowdedToUpload' => 'نوع الملف غير مسموح بتحميله',
        'description' => 'الوصف',
        'reason' => 'السبب',
        'done_by' => 'تم بواسطة',
        'the_archive' => 'الأرشيف',
        "want_to_archive" => "هل تريد إتمام عملية الأرشفة؟",
        "reason_needed" => "الرجاء ذكر السبب*",
        'black_menu' => 'القائمة السوداء',
        'settings' => 'الإعدادات',
        'logout' => 'تسجيل خروج',
        'accept'=>'موافقة',
        'cancel'=>'الغاء',
        'created_by' => 'منشيء المجموعة',
        'u_can_use_this_name' => 'يمكنك استخدام الإسم',
        'confirm' => 'تأكيد',
        'send' => 'إرسال',
        'Total_departments'=>'الأقسام ',
        'Total_active_users'=>'المستخدمين المفعلة ',
        'Total_permenant_users'=>'المستخدمين المعطلين لفترة دائمة ',
        'Total_temporary_users'=>'المستخدمين المعطلين لفترة ',
        'Total_employees'=>'الموظفين',
        'Total_vacant_jobs'=>'الوظائف الشاغرة ',
        'Total_unvacant_jobs'=>'الوظائف المشغولة',

    ],
    'datatable' => [
        'no_data' => 'لا توجد نتائج متاحة',
        'there_is_no_data' => 'لا يوجد نتائج بحث متاحة',
        'showing' => 'عرض',
        'to' => 'الى',
        'from' => 'من',
        'entries' => 'الاجمالي',
        'no_search_result' => 'لا يوجد نتائج بحث متاحة',
    ],
    'error' => [
        'method_not_allow' => 'طريقة الطلب (:method) غير صحيحة',
        'not_found' => 'لم يتم العثور على بيانات',
        'page_not_found' => '404, الصفحة غير موجودة',
        'something_went_wrong' => 'البيانات المدخلة غير صحيحة',
        'name_must_be_unique_on_department' =>  'قيمة حقل الاسم موجودة من قبل لهذا القسم'
    ],
    'activity_log' => [
        "activity_log" => "سجل النشاط",
        "activity_logs" => "سجل النشاطات",
        "reason" => "قام :user بـ:action :model",
        "date" => "تاريخ النشاط",
        "main_program" =>"البرنامج الرئيسي",
        "sub_program" => "البرنامج الفرعي",
        "activity" => " النشاط",
        "employees"=>" الموظفين",
        "ip_address" => "رقم معرف الجهاز",
        "select_activity"=>"اختر النشاط",
        "select_employee" =>"اختر موظف",
        "select_mainprogram"=>"اختر برنامج رئيسي",
        "select_subprogram" => "اختر برنامج فرعي",
        'history' => 'الحركة التاريخية',
        'actions' => [
            'created' => 'إضافة',
            'updated' => 'تعديل',
            'destroy' => 'أرشفة',
            'restored' => 'استعادة',
            'permanent_delete' => 'حذف',
            'searched' => 'بحث',
            'deactivated' => 'تعطيل',
            'activated' => 'تفعيل',
            'permanent' => 'حظر دائم',
            'temporary' => 'حظر لفترة',

        ],
        'permissions' => array_only($permissions, ['index', 'show']),
        'sub_progs' => [
            'index' => 'سجل النشاطات',
            'show' => 'عرض النشاط',
            'create' =>'اضافة',
            'ban_status' =>'حظر',
            'archive'=>'أرشفة'

        ],

    ],
    'home' => [
        'home' => 'الرئيسية',
        'permissions' => [
            "show" => "عرض",
        ],
    ],

    "country" => [
        "country" => "الدولة",
        "countries" => "الدول",
        "add_country" => "اضافة دولة",
        "edit_country" => "تعديل دولة",
        "country_count" => "عدد الدول",
        'permissions' => $permissions,
        'sub_progs' => [
            'index' => 'سجل الدول',
            'archive' => 'أرشيف الدول',
            'create' => 'اضافة دولة',
        ],
    ],
    "region" => [
        "region" => "المنطقة ",
        "regions" => "المناطق",
        "add_region" => "اضافة منطقة",
        "edit_region" => "تعديل المنطقه",
        "region_count" => "عدد المناطق",
        'permissions' => $permissions,
        'sub_progs' => [
            'index' => 'سجل المناطق',
            'archive' => 'أرشيف المناطق',
            'create' => 'اضافة منطقة',
        ],
    ],
    "city" => [
        "city" => "المدينة",
        "cities" => "المدن",
        "add_city" => "اضافة مدينة",
        "edit_city" => "تعديل المدينة",
        "city_count" => "عدد المدن",
        'sub_progs' => [
            'index' => 'سجل المدن',
            'archive' => 'أرشيف المدن',
            'create' => 'اضافة مدينة',
        ],
        'permissions' => $permissions
    ],
    "group" => [
        "group_name" => "اسم المجموعة",
        "main_program" => 'البرنامج الرئيسي',
        "sub_program" => 'البرنامج الفرعي',
        "group" => "المجموعة الادارية",
        "groups" => "سجل الصلاحيات",
        "chosen_groups" => "الصلاحيات المختارة",
        "add_group" => "اضافة مجموعة",
        "edit_group" => "تعديل المجموعة",
        'show_group' => 'عرض مجموعة',
        "admins_from" => "عدد المستخدمين من",
        "admins_to" => "عدد المستخدمين إلى",
        "group_count" => "عدد المجموعات",
        'group_data' => 'بيانات المجموعة',
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'اضافة مجموعة',
        ],
        'admins_count' => 'عدد المستخدمين',
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض القائمة']
    ],
    "currency" => [
        "currency" => "العملة ",
        "currencies" => "العملات",
        "add_currency" => "اضافة عملة",
        "edit_currency" => "تعديل العملة",
        "currency_count" => "عدد العملات",
        'sub_progs' => [
            'index' => 'سجل العملات',
            'archive' => 'أرشيف العملات',
            'create' => 'اضافة عملة',
        ],
        'permissions' => $permissions
    ],
    "department" => [
        "department" => "القسم ",
        "departments" => "الاقسام",
        "department_image" => "صورة القسم",
        "department_name" => "اسم القسم",
        "department_main" => "القسم الر ئيسي",
        "select_department" => "اختر القسم",
        "main_department" => "القسم الر ئيسي",
        'select_main_department' => 'اختر القسم الر ئيسي',
        "add_department" => "إضافة قسم",
        "edit_department" => "تعديل قسم",
        "department_count" => "عدد الاقسام",
        "archive_from_date" => "تاريخ الأرشفة  (من)",
        "archive_to_date" => "تاريخ الأرشفة  (إلى)",
        "search" => "بحث",
        "show_all" => "عرض الكل",
        "archived_at" => " تاريخ الأرشفة",
        "is_active" => "الحالة",
        'sub_progs' => [
            'index' => 'سجل الأقسام',
            'archive' => 'أرشيف الأقسام',
            'create' => ' إضافة قسم ',
            'show' => 'عرض قسم',

        ],
        'active_cases' => [
           1=> 'مفعل',
            0=>'معطل',
        ],
        'permissions' => $permissions + [
            'get_parents' => 'عرض الأقسام الرئيسية',
            'export' => 'تصدير',
    ],
        "has_jobs_cannot_delete" => "لا يمكن أرشفة قسم مرتبط بوظائف",
        "department_has_relationship_cannot_delete" => "لا يمكن أرشفة هذا القسم لأنه يحتوي علي أقسام فرعية   ",
        'without_parent' => 'بدون قسم رئيسي ',
        'without'=> 'بدون قسم',
        'department_archive' => 'أرشيف الأقسام',
    ],
    "rasid_job" => [
        "rasid_jobs" => "الوظائف",
        "add_rasid_job" => "اضافة وظيفة",
        "edit_rasid_job" => "تعديل الوظيفة",
        "rasid_job_count" => "عدد الوظائف",
        "rasid_job_description" => "الوصف الوظيفي",
        "rasid_job_department" => "اسم القسم",
        "name" => "اسم الوظيفة",
        "validation" => [
            'name_must_be_unique_on_department' => 'تم اختيار اسم الوظيفة من قبل لنفس القسم'
        ],
        "jobs_hired_deleted" => " لا يمكن حذف هذه الوظيفة لانها مشغولة ",
        "jobs_hired_archived" => " لا يمكن أرشفة هذه الوظيفة لانها مشغولة ",
        'sub_progs' => [
            'index' => 'سجل الوظائف',
            'archive' => 'أرشيف الوظائف',
            'create' => 'اضافة وظيفة',
            'show' => 'عرض وظيفة',
        ],
        "rasid_job" => "الوظيفة",
        "jobs" => "الوظائف",
        "add_job" => "اضافة وظيفة",
        "edit_job" => "تعديل وظيفة",
        "job_count" => "عدد الوظائف",
        "department" => "القسم",
        "job_name" => "اسم الوظيفة",
        "select_department" => "اختر القسم",
        "employee_name" => "اسم الموظف",
        "from_date" => "تاريخ الإنشاء (من)",
        "to_date" => "تاريخ الإنشاء (إلى)",
        "archive_from_date" => "تاريخ الأرشفة  (من)",
        "archive_to_date" => "تاريخ الأرشفة  (إلى)",
        "search" => "بحث",
        "show_all" => "عرض الكل",
        "show" => "عرض",
        "created_at" => "تاريخ الإنشاء",
        "archived_at" => " تاريخ الأرشفة",
        "actions" => "العمليات",
        "job_description" => "وصف الوظيفة",
        "is_active" => "الحالة",
        'is_vacant' => [
    'true' => 'شاغرة',
    'false' => 'مشغولة',
],


        'active_cases' => [
    1=> 'مفعلة',
    0=>'معطلة',
],

     'permissions' => $permissions
    ],
    "setting" => [
        "setting" => "الاعدادات",
        "settings" => "الاعدادات",
        "add_setting" => "",
        "setting_count" => "",
        'sub_progs' => [
            'index' => 'سجل الاعدادات',
            'archive' => 'أرشيف الاعدادات',
            'create' => 'اضافة إعداد',
        ],
        'permissions' => $permissions
    ],
    "profile" => [
        "profile" => "الملف الشخصي",
        "profiles" => "الملفات الشخصية",
        "show_profile" => "عرض الملف الشخصي",
        "edit_profile" => "تعديل الملف الشخصي",
    ],
    "admin" => [
        "admin" => "المستخدم",
        "admin_name" => "اسم المستخدم",
        "login_id" => "رقم المستخدم",
        "admins" => "المستخدمين",
        "add_admin" => "اضافة مستخدم",
        "edit_admin" => "تعديل المستخدم",
        "admin_count" => "عدد المستخدمين",
        'name' => 'اسم المستخدم',
        'number' => 'رقم المستخدم',
        "ban_from" => "معطل لفترة (من)",
        "ban_to" => "معطل لفترة (إلى)",
        'permission_system'=>'صلاحيات النظام',
        'new_password'=>'كلمة المرور الجديدة',
        'confirmed_password'=>'تاكيد كلمة المرور',
        'u_can_use_this_id'=>'يمكنك استخدام هذا الرقم',
        'sub_progs' => [
            'index' => 'سجل المستخدمين',
            'archive' => 'أرشيف المستخدمين',
            'create' => 'اضافة مستخدم',
            'show' => 'عرض مستخدم'
        ],

        'active_cases' => [
            'active' => 'مفعلة',
            'temporary' => 'معطلة لفترة',
            'permanent' => 'معطلة دائم',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض المستخدمين']
    ],
    'contact' => [
        'contact'        => 'الدعم الفني',
        'contacts'       => 'الدعم الفني',
        'permissions' => [
            'index'          => 'رسائل الدعم الفني',
            'show'           => 'عرض رسالة الدعم الفني',
            'reply'          => 'الرد علي رسالة دعم فني',
            'delete_contact' => 'حذف رسالة دعم فني',
            'delete_reply'   => 'حذف الرد علي رسالة دعم فني',
        ]
    ],
    "employee" => [
        "employee" => "الموظف",
        "employees" => "الموظفين",
        "add_employee" => "اضافة موظف",
        "edit_employee" => "تعديل موظف",
        "employee_count" => "عدد الموظفين",
        'sub_progs' => [
            'index' => 'سجل الموظفين',
            'archive' => 'أرشيف الموظفين',
            'create' => 'اضافة موظف',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض الموظفين']

    ],
    "bank" => [
        "bank" => "البنك",
        "banks" => "البنوك",
        "add_bank" => "اضافة بنك",
        "edit_bank" => "تعديل بنك",
        "bank_count" => "عدد البنوك",
        'sub_progs' => [
            'index' => 'سجل البنوك',
            'archive' => 'أرشيف البنوك',
            'create' => 'اضافة بنك',
        ],
        'permissions' => $permissions
    ],
    "notification" => [
        "notification" => "تنبيه",
        "notificationS" => "التنبيهات",
        "notification_count" => "عدد التنبيهات",
        'permissions' => ['store' => 'ارسال تنبيه']
    ],
    "client" => [
        "client" =>  "العميل",
        "clients" => "العملاء",
        "add_client" => "اضافة عميل",
        "edit_client" => "تعديل عميل",
        "admin_client" => "عدد العملاء",
        'sub_progs' => [
            'index' => 'سجل العملاء',
            'archive' => 'أرشيف العملاء',
            'create' => 'تسجيل عميل',
            'account_order' => 'طلبات فتح حساب',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض العملاء']
    ],
    'user' => [
        'users' => 'المستخدمين',
        'sub_progs' => [
            'index' => 'سجل المستخدمين',
            'archive' => 'أرشيف المستخدمين',
            'create' => 'اضافة مستخدم',
        ],
    ],
    'chat' => [
        'chats' => 'الدردشات',
        'sub_progs' => [
            'index' => 'سجل الدردشات',
            'archive' => 'أرشيف الدردشات',
        ],
    ],
    'device' => [
        'devices' => 'الأجهزة',
        'sub_progs' => [
            'index' => 'سجل الأجهزة',
            'archive' => 'أرشيف الأجهزة',
        ],
    ],
    'message' => [
        'messages' => 'الرسائل',
        'sub_progs' => [
            'index' => 'سجل الرسائل',
            'archive' => 'أرشيف الرسائل',
            'show_all messages'=>"مشاهدة
        كل
        الرسائل",
            'create' => 'اضافة رسالة',
        ],
    ],
    'permission' => [
        'name'  => 'اسم الصلاحية',
        'permissions' => 'الصلاحيات',
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'اضافة صلاحية',
        ],
    ],
];
