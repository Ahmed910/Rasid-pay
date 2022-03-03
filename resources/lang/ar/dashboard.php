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
    'general' => [
        "success_add" => "تم الأنشاء بنجاح",
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
        'success_send_login_code' => 'تم ارسال كود التحقق الى رقم الجوال',
    ],
    'error' => [
        'method_not_allow' => 'طريقة الطلب (:method) غير صحيحة',
        'not_found' => 'لم يتم العثور على بيانات',
        'page_not_found' => '404, الصفحة غير موجودة',
        'something_went_wrog' => 'البيانات المدخلة غير صحيحة'
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
        'permissions' => $permissions
    ],
    "region" => [
        "region" => "المنطقة ",
        "regions" => "المناطق",
        "add_region" => "اضافة منطقة",
        "edit_region" => "تعديل المنطقه",
        "region_count" => "عدد المناطق",
        'permissions' => $permissions
    ],
    "city" => [
        "city" => "المدينة",
        "cities" => "المدن",
        "add_city" => "اضافة مدينة",
        "edit_city" => "تعديل المدينة",
        "city_count" => "عدد المدن",
        'permissions' => $permissions
    ],
    "group" => [
        "group" => "المجموعة الادارية",
        "groups" => "المجموعات الادارية",
        "add_group" => "اضافة مجموعه",
        "edit_group" => "تعديل المجموعه",
        "group_count" => "عدد المجموعات",
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض القائمة']
    ],
    "currency" => [
        "currency" => "العملة ",
        "currencies" => "العملات",
        "add_currency" => "اضافة عملة",
        "edit_currency" => "تعديل العملة",
        "currency_count" => "عدد العملات",
        'permissions' => $permissions
    ],
    "department" => [
        "department" => "القسم ",
        "departments" => "الاقسام",
        "add_department" => "اضافة قسم",
        "edit_department" => "تعديل القسم",
        "department_count" => "عدد الاقسام",
        'permissions' => $permissions + ['get_parents' => 'عرض الاقسام الرئيسية'],
        "has_jobs_cannot_delete" => "لا يمكن أرشفة قسم مرتبط بوظائف"
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
        'permissions' => $permissions
    ],
    "setting" => [
        "setting" => "الاعدادات",
        "settings" => "الاعدادات",
        "add_setting" => "",
        "setting_count" => "",
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
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['hold' => 'تعطيل', 'create' => 'عرض الموظفين']
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
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['hold' => 'تعطيل']
    ],
    "bank" => [
        "bank" => "البنك",
        "banks" => "البنوك",
        "add_bank" => "اضافة بنك",
        "edit_bank" => "تعديل بنك",
        "bank_count" => "عدد البنوك",
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
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + [ 'create' => 'عرض العملاء']
    ],

];
