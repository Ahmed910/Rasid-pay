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
        "has_relationship_cannot_delete" => "لا يمكن حذف هذا العنصر ،بسبب احتواءه علي علاقات",
        "save" => "حفظ",
        "edit" => "تعديل",
        "show" => "عرض",
        "archive" => "",
        "restore" => "",
        "force_delete" => "",
        'not_found' => 'لم يتم العثور على بيانات',

    ],

    "country" => [
        "country" => "",
        "countries" => "",
        "add_country" => "",
        "edit_country" => "",
        "country_count" => "",
        'permissions' => $permissions
    ],
];
