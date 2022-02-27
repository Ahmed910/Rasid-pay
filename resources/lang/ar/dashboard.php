<?php

$permissions = [
    'index' => 'السجل',
    'show' => 'عرض',
    'store' => 'حفظ',
    'update' => 'تعديل',
    'archive' => 'أرشفة',
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
        'permissions' => array_except($permissions,['archive','restore','force_delete']) + ['hold' => 'تعطيل']
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
        'permissions' => $permissions
    ],
    "job" => [
        "job" => "الوظيفة",
        "jobs" => "الوظائف",
        "add_job" => "اضافة وظيفة",
        "edit_job" => "تعديل الوظيفة",
        "job_count" => "عدد الوظائف",
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
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['hold' => 'تعطيل']
    ],


];
