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
        "success_add" => "Created Successfully",
        "success_delete" => "Deleted Successfully",
        "success_update" => "Updated Successfully",
        "success_archive" => "Archived Successfully",
        "has_relationship_cannot_delete" => "This item has relationships ,so you cannot delete it",
        "save" => "Save",
        "edit" => "Edit",
        "show" => "Show",
        "archive" => "",
        "restore" => "",
        "force_delete" => "",
    ],
    "country" => [
        "country" => "Country",
        "countries" => "Countries",
        "add_country" => "",
        "edit_country" => "",
        "country_count" => "",
        'permissions' => $permissions
    ],
];
