<?php

$permissions = [
    'read' => 'قراءه',
    'save' => 'حفظ',
    'edit' => 'تعديل',
    'archive' => 'أرشفة',
    'restore' => 'استعادة',
    'force_delete' => 'مسح نهائي',
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
        "archive" => "",
        "restore" => "",
        "force_delete" => "",
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
        "add_country" => "",
        "edit_country" => "",
        "country_count" => "",
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
     "currency"=>[
        "currency" => "العملة ",
        "currencies" => "العملات",
        "add_currency" => "",
        "edit_currency" => "",
        "currency_count" => "",
        'permissions' => $permissions
    ],
    




];
