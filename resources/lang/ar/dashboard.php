<?php

$permissions = [
    'index' => 'السجل',
    'show' => 'عرض',
    'store' => 'حفظ',
    'update' => 'تعديل',
    'destroy' => 'أرشفة',
    'archive' => 'عرض الارشيف',
    'restore' => 'استعادة',
    'force_delete' => 'حذف نهائي',
];

return [
    'attributes' => [
        'name' => 'الاسم باللغة العربية',
        'description' => 'الوصف باللغة العربية',
        'nationality' => 'الجنسية باللغة العربية',
    ],
    'general' => [
        "success_add" => "تم الإضافة بنجاح",
        "success_delete" => "تم الحذف بنجاح",
        "success_update" => "تم التعديل بنجاح",
        "success_archive" => "تم الأرشفة بنجاح",
        "success_restore" => "تم الاستعادة بنجاح",
        "has_relationship_cannot_delete" => "لا يمكن حذف هذا العنصر ،بسبب احتواءه علي علاقات",
        "save" => "حفظ",
        "edit" => "تعديل",
        "show" => "عرض",
        "archive" => "أرشفة",
        "restore" => "استعادة",
        "force_delete" => "حذف نهائي",
        'sent_successfully' => 'تم الارسال بنجاح',
        'fail_send' => 'فشل عملية الارسال',
        'active' => 'مفعل',
        'inactive' => 'معطل'
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
            'archive' => 'ارشيف الدول',
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
            'archive' => 'ارشيف المناطق',
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
            'archive' => 'ارشيف المدن',
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
            'archive' => 'ارشيف الصلاحيات',
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
            'archive' => 'ارشيف العملات',
            'create' => 'اضافة عملة',
        ],
        'permissions' => $permissions
    ],
    "department" => [
        "department" => "القسم ",
        "departments" => "الاقسام",
        "add_department" => "اضافة قسم",
        "edit_department" => "تعديل القسم",
        "department_count" => "عدد الاقسام",
        'sub_progs' => [
            'index' => 'سجل الأقسام',
            'archive' => 'ارشيف الأقسام',
            'create' => 'اضافة قسم',
        ],
        'permissions' => $permissions + ['get_parents' => 'عرض الاقسام الرئيسية'],
        "has_jobs_cannot_delete" => "لا يمكن أرشفة قسم مرتبط بوظائف",
        "department_has_relationship_cannot_delete" => "لا يمكن حذف هذا القسم لأنه يحتوي علي أقسام فرعية   ",

    ],
    "rasid_job" => [
        "rasid_job" => "الوظيفة",
        "rasid_jobs" => "الوظائف",
        "add_rasid_job" => "اضافة وظيفة",
        "edit_rasid_job" => "تعديل الوظيفة",
        "rasid_job_count" => "عدد الوظائف",
        "validation" => [
            'name_must_be_unique_on_department' => 'تم اختيار اسم الوظيفة من قبل لنفس القسم'
        ],
        "jobs_hired_deleted" => " لا يمكن حذف هذه الوظيفة لانها مشغولة ",
        "jobs_hired_archived" => " لا يمكن أرشفة هذه الوظيفة لانها مشغولة ",
        'sub_progs' => [
            'index' => 'سجل الوظائف',
            'archive' => 'ارشيف الوظائف',
            'create' => 'اضافة وظيفة',
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
            'archive' => 'ارشيف الاعدادات',
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
            'archive' => 'ارشيف مستخدمى النظام',
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
            'archive' => 'ارشيف الموظفين',
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
            'archive' => 'ارشيف البنوك',
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
            'archive' => 'ارشيف العملاء',
            'create' => 'اضافة عميل',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض العملاء']
    ],
    'user' => [
        'users' => 'المستخدمين',
        'sub_progs' => [
            'index' => 'سجل المستخدمين',
            'archive' => 'ارشيف المستخدمين',
            'create' => 'اضافة مستخدم',
        ],
    ],
    'chat' => [
        'chats' => 'الدردشات',
        'sub_progs' => [
            'index' => 'سجل الدردشات',
            'archive' => 'ارشيف الدردشات',
        ],
    ],
    'device' => [
        'devices' => 'الأجهزة',
        'sub_progs' => [
            'index' => 'سجل الأجهزة',
            'archive' => 'ارشيف الأجهزة',
        ],
    ],
    'message' => [
        'messages' => 'الرسائل',
        'sub_progs' => [
            'index' => 'سجل الرسائل',
            'archive' => 'ارشيف الرسائل',
            'create' => 'اضافة رسالة',
        ],
    ],
    'permission' => [
        'permissions' => 'الصلاحيات',
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'ارشيف الصلاحيات',
            'create' => 'اضافة صلاحية',
        ],
    ]
];
