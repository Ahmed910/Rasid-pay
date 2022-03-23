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
        'name' => 'الاسم باللغة العربية',
        'description' => 'الوصف باللغة العربية',
        'nationality' => 'الجنسية باللغة العربية',
    ],
    'datatable' => [
        'show :menu' => 'عرض :menu'
    ],
    'general' => [
        "success_add" => "تم الإضافة بنجاح",
        "success_delete" => "تم الحذف بنجاح",
        "success_update" => "تم التعديل بنجاح",
        "success_archive" => "تم الأرشفة بنجاح",
        "success_restore" => "تم الاستعادة بنجاح",
        "has_relationship_cannot_delete" => "لا يمكن حذف هذا العنصر ،بسبب احتواءه علي علاقات",
        "save" => "حفظ",
        "back" => "عودة",
        "edit" => "تعديل",
        'add' => 'إضافة',
        "show" => "عرض",
        "archive" => "أرشفة",
        "restore" => "استعادة",
        "force_delete" => "حذف نهائي",
        'sent_successfully' => 'تم الارسال بنجاح',
        'success_send_login_code' => 'تم ارسال كود التحقق الى رقم الهاتف',
        'fail_send' => 'فشل عملية الارسال',
        'active' => 'مفعل',
        'inactive' => 'معطل',
        'activited' => 'تفعيل',
        'unactivited' => 'تعطيل',
        'dashboard' => 'لوحة تحكم رصيد جاك',
        "status" => "الحالة",
        "select_status" => "اختر الحالة",
        "type" => "النوع",
        "select_type" => "اختر النوع",
        "from_date" => "تاريخ الإنشاء (من)",
        "to_date" => "تاريخ الإنشاء (إلى)",
        "search" => "بحث",
        "show_all" => "عرض الكل",
        "created_at" => "تاريخ الإنشاء",
        'create' => 'انشاء',
        "actions" => "العمليات",
        "active_cases" => [
            'معطل',
            'مفعل',
        ],
        'all' => 'الجميع',
        'description' => 'الوصف',
        'day_month_year' => 'يوم/شهر/سنة',
        'export' => 'تصدير',
        'details' => 'التفاصيل',
        'no_data' => 'لا يوجد بيانات',
        'there_is_no_data' => 'لا يوجد نتائج بحث متاحة',
        'showing' => 'عرض',
        'to' => 'الى',
        'from' => 'من',
        'entries' => 'مدخلات',
        'delete' => 'حذف',
        'hold_upload' => 'اسحب وأسقط او قم برفع الصورة',
        'hold_change' => 'اسحب وأسقط او إضغط لتغيير الصورة',
        'upload_error' => 'اووه ، حدث خطأ ما',
        'upload_file_max' => 'حجم الملف كبير',
        'notAllowdedToUpload' => 'نوع الملف غير مسموح بتحميله',
        'description'=>'الوصف',
        'reason' =>'السبب',
        'done_by' => 'تم بواسطة',
    ],
    'error' => [
        'method_not_allow' => 'طريقة الطلب (:method) غير صحيحة',
        'not_found' => 'لم يتم العثور على بيانات',
        'page_not_found' => '404, الصفحة غير موجودة',
        'something_went_wrog' => 'البيانات المدخلة غير صحيحة',
        'name_must_be_unique_on_department' =>  'هذه الوظيفة موجودة بالفعل لهذا القسم'
    ],
    'activity_log' => [
        "reason" => ":user قام :action",
        "date" => "تاريخ النشاط",
        "activity" => " النشاط",
        'history' => 'الحركة التاريخية',

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
        "group" => "المجموعة الادارية",
        "groups" => "المجموعات الادارية",
        "add_group" => "اضافة مجموعه",
        "edit_group" => "تعديل المجموعه",
        "group_count" => "عدد المجموعات",
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'اضافة مجموعة',
        ],
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
        "department" => "القسم",
        "main_department" => "القسم الرئيسي",
        "departments" => "الأقسام",
        "department_image" => "صورة القسم",
        "add_department" => "اضافة قسم",
        "edit_department" => "تعديل القسم",
        "department_count" => "عدد الأقسام",
        'select_main_department' => 'جميع الاقسام',
        "name" => "اسم القسم",
        "sub_progs" => [
            'index' => 'سجل الأقسام',
            'archive' => 'أرشيف الأقسام',
            'create' => 'اضافة قسم',
            'show' => 'عرض قسم',

        ],
        'permissions' => $permissions + ['get_parents' => 'عرض الأقسام الرئيسية'],
        "has_jobs_cannot_delete" => "لا يمكن أرشفة قسم مرتبط بوظائف",
        "department_has_relationship_cannot_delete" => "لا يمكن حذف هذا القسم لأنه يحتوي علي أقسام فرعية   ",
        'without_parent' => 'بدون'
    ],
    "rasid_job" => [
        "rasid_job" => "الوظيفة",
        "rasid_jobs" => "الوظائف",
        "add_rasid_job" => "اضافة وظيفة",
        "edit_rasid_job" => "تعديل الوظيفة",
        "rasid_job_count" => "عدد الوظائف",
        "employee_name" => "اسم الموظف",
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
        'is_vacant' => [
            'true' => 'مشغولة',
            'false' => 'شاغرة',
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
        "admin" => "مستخدم النظام",
        "admins" => "مستخدمى النظام",
        "add_admin" => "اضافة مستخدم",
        "edit_admin" => "تعديل المستخدم",
        "admin_count" => "عدد المستخدمين",
        'sub_progs' => [
            'index' => 'سجل مستخدمى النظام',
            'archive' => 'أرشيف مستخدمى النظام',
            'create' => 'اضافة مستخدم',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض المستخدمين']
    ],
    'contact' => [
        'contact'        => 'الدعم الفني',
        'contacts'       => 'الدعم الفني',
        'index'          => 'رسائل الدعم الفني',
        'show'           => 'عرض رسالة الدعم الفني',
        'reply'          => 'الرد علي رسالة دعم فني',
        'delete_contact' => 'حذف رسالة دعم فني',
        'delete_reply'   => 'حذف الرد علي رسالة دعم فني',
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
    'job' => [
        "job" => "الوظيفة",
        "jobs" => "الوظائف",
        "add_job" => "اضافة وظيفة",
        "edit_job" => "تعديل وظيفة",
        "job_count" => "عدد الوظائف",
        "job_name" => "اسم الوظيفة",
        "select_department" => "اختر القسم",
        "employee_name" => "اسم الموظف",
        "job_description" => "وصف الوظيفة",
        'is_vacant' => [
            'true' => 'مشغولة',
            'false' => 'شاغرة',
        ],
        'sub_progs' => [
            'index' => 'سجل الوظائف',
            'archive' => 'أرشيف الوظائف',
            'create' => 'اضافة وظيفة',
        ],
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
            'create' => 'اضافة عميل',
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
            'create' => 'اضافة رسالة',
        ],
    ],
    'permission' => [
        'permissions' => 'الصلاحيات',
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'اضافة صلاحية',
        ],
    ],
];
