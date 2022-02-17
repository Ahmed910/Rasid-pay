<?php

$permissions = [
    'read' => 'قراءه',
    'save' => 'حفظ',
    'edit' => 'تعديل',
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
        'not_found' => 'لم يتم العثور على بيانات',
        'sent_successfully' => 'تم الارسال بنجاح',

    ],
    'activity_log' => [
        "reason" => ":user قام :action",
    ],
    'home' => [
        'home' => '',
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
    "role" => [
        "role" => "المستوى الاداري",
        "roles" => "المستويات الادارية",
        "add_role" => "",
        "edit_role" => "",
        "role_count" => "",
        'permissions' => $permissions
    ],
    "currency" => [
        "currency" => "العملة ",
        "currencies" => "العملات",
        "add_currency" => "",
        "edit_currency" => "",
        "currency_count" => "",
        'permissions' => $permissions
    ],
    "department" => [
        "department" => "القسم ",
        "departments" => "الاقسام",
        "add_department" => "",
        "edit_department" => "",
        "department_count" => "",
        'permissions' => $permissions
    ],
    "job" => [
        "job" => "الوظيفة ",
        "jobs" => "الوظائف",
        "add_job" => "",
        "edit_job" => "",
        "job_count" => "",
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
        "show_profile" => "",
        "edit_profile" => "",
        "profile_count" => "",
    ],
    "admin" => [
        "admin" => "مستخدم نظام",
        "admins" => "مستخدمى النظام",
        "add_admin" => "اضافة مستخدم",
        "edit_admin" => "تعديل مستخدم",
        "admin_count" => "عدد المستخدمين",
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['hold' => 'تعطيل']
    ],






];
