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
    'permissions' => [
        'index' => 'السجل',
        "create" => "انشاء",
        'show' => 'عرض',
        'store' => 'حفظ',
        'update' => 'تعديل',
        'destroy' => 'أرشفة',
        'archive' => 'عرض أرشيف',
        'restore' => 'استعادة',
        'force_delete' => 'حذف نهائي',
    ],
    'attributes' => [
        'name' => 'الاسم',
        'description' => 'الوصف',
        'nationality' => 'الجنسية',
    ],
    'datatable' => [
        'show :menu' => 'عرض :menu'
    ],
    'general' => [
        "delete" => "حذف",
        "no_reasons" => "لايوجد",
        "success_add" => "تمت الإضافة بنجاح",
        "success_delete" => "تم الحذف بنجاح",
        "success_update" => "تم التعديل بنجاح",
        "success_archive" => "تمت الأرشفة بنجاح",
        "success_restore" => "تم الاستعادة بنجاح",
        "Send VerificationCode" => "إرسال رمز التحقق",
        'change_password' => 'تغيير كلمة المرور',
        "has_relationship_cannot_delete" => "لا يمكن حذف هذا العنصر ،بسبب احتواءه علي علاقات",
        'yes' => 'موافق',
        'no' => 'غير موافق',
        'want_saving' => 'هل تريد اتمام عملية الحفظ ؟',
        'want_force_delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
        "want_restore" => "هل تريد إتمام عملية الاستعادة؟",
        'reason_required' => 'السبب مطلوب',
        'want_back_without_saving' => 'هل تريد العوده دون الحفظ ؟',
        'close' => 'اغلاق',
        "save" => "حفظ",
        "index" => "عرض",
        "back" => "عودة",
        "edit" => "تعديل",
        'add' => 'إضافة',
        'delete'=>'حذف',
        "show" => "عرض",
        "archive" => "أرشفة",
        "restore" => "استعادة",
        "force_delete" => "حذف نهائي",
        'sent_successfully' => 'تم الارسال بنجاح',
        'success_send_login_code' => 'تم ارسال كود التحقق الى رقم الجوال',
        'phone' => 'رقم الجوال',
        "enter_phone" => "أدخل رقم الجوال",
        'phone_code' => "حقل رقم الجوال مطلوب",
        'phoneCode_registeration' => "رقم الجوال غير مسجل بالنظام",
        'digits_between' => "يجب أن يحتوي حقل الجوال بين 5 و 20 رقمًا/أرقام .
        ",
        'fail_send' => 'فشل عملية الارسال',
        'invalid_code' => 'رمز التحقق غير صحيح',
        'active' => 'مفعل',
        'inactive' => 'معطل',
        'activited' => 'تفعيل',
        'un_active_account' => 'هذا المستخدم معطل',
        'unactivited' => 'تعطيل',
        'dashboard' => 'لوحة تحكم رصيد باي',
        "status" => "الحالة",
        "select_status" => "اختر الحالة",
        "select_user" => "اختر مستخدم",
        "select_employee" => "اختر موظف",
        'select_permissions' => 'اختر الصلاحيات',
        "type" => "النوع",
        "select_type" => "اختر النوع",
        "from_date" => "تاريخ الإنشاء (من)",
        "to_date" => "تاريخ الإنشاء (إلى)",
        "search" => "بحث",
        "show_all" => "عرض الكل",
        "created_at" => "تاريخ الإنشاء",
        'create' => 'إضافة',
        "actions" => "العمليات",
        'enter_name' => 'أدخل الاسم',
        'enter_description' => 'أدخل الوصف',
        "notifications" => "الاشعارات",
        "show_all notification" => "مشاهدة كل الإشعارات",
        "personalfile" => "الملف الشخص",
        "username" => "اسم المستخدم",
        "name" => "الاسم",
        "user_name" => "أدخل الاسم",
        "email" => "البريد الالكتروني",
        "enter_email" => "أدخل البريد الالكتروني",
        "phone" => "رقم الجوال",
        "enter_email" => "أدخل البريد الالكتروني",
        "enter_phone" => "أدخل رقم الجوال",
        "active_cases" => [
            'معطلة',
            'مفعلة',
        ],
        "department_active_cases" => [
            'معطل',
            'مفعل',
        ],
        'job_type_cases' => [
            'مشغولة',
            'شاغرة',
        ],
        'all_cases' => 'الجميع',
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
        'accept' => 'موافقة',
        'refuse' => 'رفض',
        'cancel' => 'الغاء',
        'created_by' => 'منشيء المجموعة',
        'u_can_use_this_name' => 'يمكنك استخدام الإسم',
        'confirm' => 'تأكيد',
        'send' => 'إرسال',
        'Total_departments' => 'الأقسام ',
        'Total_active_users' => 'المستخدمين المفعلين ',
        'Total_permenant_users' => 'المستخدمين المعطلين دائماً ',
        'Total_temporary_users' => 'المستخدمين المعطلين لفترة ',
        'Total_employees' => 'الموظفين',
        'Total_vacant_jobs' => 'الوظائف الشاغرة ',
        'Total_unvacant_jobs' => 'الوظائف المشغولة',
        'Permission_field_required' => 'حقل الصلاحيات مطلوب',

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
        'name_must_be_unique_on_department' => 'قيمة حقل الاسم موجودة من قبل لهذا القسم'
    ],
    'activity_log' => [
        "activity_log" => "المتابعة",
        "activity_logs" => "المتابعة",
        "activity_log_records" => "سجل النشاطات",
        "reason" => "قام :user بـ:action :model من البرنامج الرئيسى :main من البرنامج الفرعى :sub",
        "date" => "تاريخ النشاط",
        "main_program" => "البرنامج الرئيسي",
        "sub_program" => "البرنامج الفرعي",
        "activity" => " النشاط",
        "employees" => " الموظفين",
        "ip_address" => "رقم معرف الجهاز",
        "select_activity" => "اختر النشاط",
        "select_employee" => "اختر موظف",
        "select_mainprogram" => "اختر برنامج رئيسي",
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
            'permanent' => 'تعطيل دائم',
            'temporary' => 'تعطيل لفترة',

        ],
        'models' => [
            'department' => 'القسم',
            'group' => 'المجموعة',
            'rasidjob' => 'الوظيفة',
            'type_job_name' => 'أدخل اسم الوظيفة',
            'bank' => 'البنك',
            'admin' => 'المستخدم',
            'attachment' => 'المرفق',
            'bankaccount' => 'الحساب بنكى',
            'client' => 'العميل',
            'employee' => 'الموظف',
            'user' => 'اليوزر',
            'profile' => "البروفايل",
            "manager" => "المدير",
            "permission" => "الصلاحية",
            "attachments" => "المرفقات",
            "attachmentfile" => " ملف المرفقات",
            "cardpackage" => "باقة البطاقة",
            "citizen" => "المواطن"

        ],
        'permissions' => array_only($permissions, ['index', 'show']),
        'sub_progs' => [
            'index' => 'المتابعة',
            'show' => 'عرض المتابعة',
            'create' => 'اضافة',
            'ban_status' => 'حظر',
            'archive' => 'أرشفة'

        ],

    ],
    'home' => [
        'home' => 'الرئيسية',
        'permissions' => [
            "show" => "عرض",
        ],
    ],
    "citizen" => [
        "citizens" => "المواطنون",
        "same_citizen_transfer"=>"عفوا، لا يمكن التحويل لمحفظتك الشخصية",
         "wallet_in_black_list"=>"عفوا، رقم المحفظة خاص بهوية أوإقامة في القائمةالسوداءالسوداء",
        "identity_in_black_list"=>"عفوا، رقم الهوية محظورمحظور"
        ],
    "cardpackage" => [
        "cardpackages" => "باقات البطاقات",
        'basic' => 'اساسية',
        'golden' => 'ذهبية',
        'platinum' => 'بلاتينية',
    ],
    "manager" => [
        "managers" => "العملاء",],
    "bank_account" => [
        "bank_accounts" => "العملاء",
        "order_number" => "رقم الطلب",
        "permissions"=>[
            'index'=>'السجل',
            'destroy'=>'حذف',
        ],
    ],
    "attachment" => [
        "attachments" => "العملاء",],
    "attachment_file" => [
        "attachment_files" => "العملاء",],

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
        'groups' => 'المجموعات',
        'all_groups' => 'الصلاحيات',
        "group_name" => "اسم المجموعة",
        "main_program" => 'البرنامج الرئيسي',
        "sub_program" => 'البرنامج الفرعي',
        "group" => "المجموعة الادارية",
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
        'sorry_group_name_is_repeated' => 'عفواً اسم المجموعة متكرر',
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
        "department_main" => "القسم الرئيسي",
        "select_department" => "اختر القسم",
        "main_department" => "القسم الرئيسي",
        'select_main_department' => 'اختر القسم الرئيسي',
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
            1 => 'مفعل',
            0 => 'معطل',
        ],
        'permissions' => $permissions + [
                'get_parents' => 'عرض الأقسام الرئيسية',
                'export' => 'تصدير',
            ],
        "has_jobs_cannot_delete" => "لا يمكن أرشفة قسم مرتبط بوظائف",
        "department_has_relationship_cannot_delete" => "لا يمكن أرشفة هذا القسم لأنه يحتوي علي أقسام فرعية   ",
        'without_parent' => 'بدون قسم رئيسي ',
        'without' => 'بدون قسم',
        'department_archive' => 'أرشيف الأقسام',
    ],
    "rasid_job" => [
        "select_job" => "اختر الوظيفة",
        "rasid_jobs" => "الوظائف",
        "add_rasid_job" => "اضافة وظيفة",
        "edit_rasid_job" => "تعديل الوظيفة",
        "rasid_job_count" => "عدد الوظائف",
        "rasid_job_description" => "الوصف الوظيفي",
        "rasid_job_department" => "اسم القسم",
        "name" => "اسم الوظيفة",
        "enter_name" => "أدخل الاسم",
        "validation" => [
            'name_must_be_unique_on_department' => 'تم اختيار اسم الوظيفة من قبل لنفس القسم'
        ],
        "jobs_hired_deleted" => " لا يمكن حذف هذه الوظيفة لانها مشغولة ",
        "jobs_hired_is_active_changed" => " لا يمكن تعديل حالة هذه الوظيفة لانها مشغولة ",
        "jobs_hired_archived" => " لا يمكن أرشفة هذه الوظيفة لانها مشغولة ",
        'sub_progs' => [
            'index' => 'سجل الوظائف',
            'archive' => 'أرشيف الوظائف',
            'create' => 'اضافة وظيفة',
            'show' => 'عرض وظيفة',
        ],
        "rasid_job" => "الوظيفة",
        "choose_rasid_job" => "اختر الوظيفة",
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
            1 => 'مفعلة',
            0 => 'معطلة',
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
        "admin" => "اسم المستخدم",
        "admin_name" => "أدخل الاسم",
        "login_id" => "رقم المستخدم",
        "enter_login_id" => "أدخل رقم المستخدم",
        "admins" => "المستخدمين",
        "add_admin" => "اضافة مستخدم",
        "edit_admin" => "تعديل المستخدم",
        "admin_count" => "عدد المستخدمين",
        'name' => 'الموظف',
        'enter_number' => 'أدخل رقم المستخدم',
        "ban_from" => "معطل لفترة (من)",
        "ban_to" => "معطل لفترة (إلى)",
        'permission_system' => 'صلاحيات النظام',
        'password' => 'كلمة المرور ',
        'new_password' => 'كلمة المرور الجديدة',
        'confirmed_password' => 'تاكيد كلمة المرور',
        'enter_password' => 'أدخل كلمة المرور',
        'u_can_use_this_id' => 'يمكنك استخدام هذا الرقم',
        'sub_progs' => [
            'index' => 'سجل المستخدمين',
            'archive' => 'أرشيف المستخدمين',
            'create' => 'اضافة مستخدم',
            'show' => 'عرض مستخدم'
        ],

        'active_cases' => [
            'active' => 'مفعل',
            'temporary' => 'معطل لفترة',
            'permanent' => 'معطل دائم',
        ],
        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض المستخدمين']
    ],
    'contact' => [
        'contact' => 'الدعم الفني',
        'contacts' => 'الدعم الفني',
        'permissions' => [
            'index' => 'رسائل الدعم الفني',
            'show' => 'عرض رسالة الدعم الفني',
            'reply' => 'الرد علي رسالة دعم فني',
            'delete_contact' => 'حذف رسالة دعم فني',
            'delete_reply' => 'حذف الرد علي رسالة دعم فني',
        ]
    ],
    'bank_branch' => [
        'bank_branches' => 'فروع البنوك',
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
        "bank_name" => "اسم البنك",
        "Enter_Bank_name" => "أدخل اسم البنك",
        "add_bank" => "اضافة بنك",
        "edit_bank" => "تعديل بنك",
        "select_bank" => "اختر البنك",
        "bank_count" => "عدد البنوك",
        "BranchName" => "اسم الفرع",
        "Enter_Bank_branch_name" => "أدخل اسم الفرع",
        "Enter_bank_code" => "ادخل الكود ",
        "Enter_bank_location" => "ادخل الموقع",
        "transaction_Value_From" => "قيمة تكلفة التحويل",
        "Enter_transfer_amount" => "ادخل قيمة التحويل",
        "code" => "الكود",
        "type" => "نوع البنك",
        "type bank" => "النوع",
        "location" => "الموقع",
        "NumberTransactions" => "عدد المعاملات",
        "Enter_NumberTransactions" => "ادخل عدد المعاملات",
        "commercialRecord" => "السجل التجاري",
        "Enter_commercial_Record" => "ادخل السجل التجاري",
        "taxNumber" => "الرقم الضريبي",
        "Enter_tax_Number" => "ادخل الرقم الضريبي",
        "serviceNumber" => "رقم خدمة العملاء",
        "Enter_service_Number" => "ادخل رقم خدمة العملاء",
        "Add new Branch" => "إضافة فرع جديد",
        'types' => [
            'centeral' => 'بنك مركزي',
            'commercial' => 'بنك تجاري',
            'bank' => 'بنك',
            'investment' => 'استثماري',
            'industrial' => 'بنك صناعي',
            'real_estate' => 'بنك عقاري',
            'agricultural' => 'بنك زراعي',
            'islamic' => 'بنك إسلامي',
            'savings' => 'بنك إدخار',
        ],
        'sub_progs' => [
            'index' => 'سجل البنوك',
            'archive' => 'أرشيف البنوك',
            'create' => 'اضافة بنك',
            'show' => 'عرض البنك',
            'edit' => 'تعديل بنك',

        ],
        'permissions' => $permissions
    ],
    "notification" => [
        "notification" => "تنبيه",
        "notificationS" => "التنبيهات",
        "notification_count" => "عدد التنبيهات",
        'permissions' => ['store' => 'ارسال تنبيه']
    ],
    'transaction' => [
        'transactions' => 'سجل المعاملات',
        'transaction' => 'المعاملة',
        'transaction_number' => 'رقم المعاملة',
        'enter_transaction_number' => 'أدخل رقم المعاملة',
        'transaction_date' => 'تاريخ المعاملة',
        'enter_transaction_date' => 'أدخل تاريخ المعاملة',
        'from_user' => 'اسم المستخدم',
        'user_identity' => 'رقم الهوية',
        'to_user_client' => 'اسم العميل',
        'transaction_amount' => 'قيمة المعاملة',
        'total_amount' => 'قيمة الفاتورة',
        'enter_from_user' => 'أدخل الاسم',
        'enter_user_identity' => 'أدخل رقم الهوية',
        'enter_to_user_client' => 'أدخل اسم العميل',
        'enter_total_amount' => 'أدخل قيمة الفاتورة',
        'gift_balance' => 'المكافآت',
        'transaction_type' => 'نوع المعاملة',
        'transaction_status' => 'حالة المعاملة',
        'active_card' => 'البطاقة المفعلة',
        'choose_client_name' => 'اختر العميل',
        'choose_type' => 'اختر النوع',
        'choose_card' => 'اختر البطاقة',
        'choose_status' => 'اختر الحالة',
        'transaction_date_from' => ' تاريخ المعاملة (من)',
        'transaction_date_to' => ' تاريخ المعاملة (إلى)',
        'transaction_amount_from' => ' قيمة المعاملة (من)',
        'transaction_amount_to' => ' قيمة المعاملة (إلى)',
        'enter_transaction_amount' => 'أدخل قيمة المعاملة',
        'status_cases' => [
            'success' => 'ناجحة',
            'fail' => 'فاشلة',
            'pending' => 'بانتظار الاستلام',
            'received' => 'تم الاستلام',
            'cancel' => 'تم الالغاء',
        ],
        'card_cases' => [
            'basic' => 'البطاقة الاساسية',
            'golden' => 'البطاقة الذهبية',
            'platinum' => 'البطاقة البلاتينية',
        ],
        'type_cases' => [
            'pay' => 'دفع',
            'transfer' => 'تحويل',
            'charge' => 'شحن',
            'money_request' => 'طلب أموال',
        ],
    ],
    "client" => [
        "client" => "العميل",
        "clients" => "العملاء",
        "add_client" => "اضافة عميل",
        "select_client" => "اختر العميل",
        "edit_client" => "تعديل عميل",
        "admin_client" => "عدد العملاء",
        'sub_progs' => [
            'index' => 'سجل العملاء',
            'archive' => 'أرشيف العملاء',
            'create' => 'تسجيل عميل',
            "show" => " عرض عميل",
            'edit' => 'تعديل عميل',
            'account_order' => 'طلبات فتح حساب',
        ],
        "name" => "اسم العميل",
        "type" => "نوع العميل",
        "client_type" => [
            "company" => "شركات",
            "institution" => "مؤسسات",
            "member" => "عضو",
            "freelance_doc" => "مستقل",
            "famous" => "مشاهير",
            "other" => "أخري",

        ],
        "commercial_number" => "رقم السجل",
        "tax_number" => "الرقم الضريبي",
        "order_date" => "تاريخ الطلب",
        "order_number" => "رقم الطلب",
        "transactions_done" => "عدد المعاملات المنجزة",
        "transactions_done_from" => "عدد المعاملات المنجزة من",
        "transactions_done_to" => "عدد المعاملات المنجزة الى",
        "transactions_done_from_date" => "عدد المعاملات المنجزة فى الفترة من",
        "transactions_done_to_date" => "عدد المعاملات المنجزة فى الفترة الى",

        "bank_name" => "البنك التابع له",
        "account_status" => "حالة الحساب البنكي",
        "status" => "الحالة",
        "account_statuses" => [
            "pending" => "لم يتم تاكيد الحساب البنكى ",
            "before_review" => "قبل المراجعة",
            "reviewed" => "تمت المراجعة",
            "accepted" => "تمت الموافقة",
            "refused" => "تم الرفض",

        ],

        'permissions' => array_except($permissions, ['archive', 'restore', 'force_delete']) + ['create' => 'عرض العملاء']
    ],

    'client_package'=>[
        'client_packages'=>'باقات العميل',
        'permissions'=>[
            'index'=>'السجل',
            'store'=>'حفظ'
        ]
    ],

    "citizens" => [
        "citizens" => "المواطنين",
        "citizens_record" => "سجل المواطنين",
        "name" => "اسم المواطن",
        "identity_number" => "رقم الهوية",
        "enter_name" => "أدخل اسم المواطن",
        "enter_identity_number" => "أدخل رقم الهوية",
        "phone" => "رقم الجوال",
        "enter_phone" => "أدخل رقم الجوال",
        "enabled_package" => "البطاقة المفعلة",
        "choose_card" => "اختر البطاقة",
        'card_end_at_from' => "تاريخ انتهاء البطاقة (من)",
        'card_end_at_to' => "تاريخ انتهاء البطاقة (إلى)",
        'created_at_from' => "تاريخ التسجيل (من)",
        'created_at_to' => "تاريخ التسجيل (إلى)",

        'card_end_at' => "تاريخ انتهاء البطاقة",
        'created_at' => "تاريخ التسجيل",
        'actions' => "العمليات",
        'without' => "بدون",

        'edit_phone' => "تعديل رقم الجوال",
        'new_phone' => "رقم الجوال الجديد",
        "phone_required" =>"رقم الجوال مطلوب",
        "phone_unique" =>"رقم الجوال مكرر"
    ],
    'package' => [
        "package" => "نسب خصم البطاقات",
        "packages" => "نسب خصم البطاقات",
        "cards_discount" => "نسب خصم البطاقات",
        "basic_card_discount" => "نسبة خصم البطاقة الأساسية",
        "package_title" => "نسبة خصم :name",
        "enter_discount" => "أدخل نسبة الخصم",
        "golden_card_discount" => "نسبة خصم البطاقة الذهبية",
        "platinum_card_discount" => "نسبة خصم البطاقة البلاتينية",
        "cards_discount_records" => "سجل نسب خصم البطاقات",
        "add" => "إضافة نسب الخصم",
        "without" => "لا يوجد",
        "discount_success_add" => "تم إضافة نسب خصم البطاقات للعميل  :client",
        "discount_success_update" => "تم تعديل نسب خصم البطاقات للعميل  :client",
        'permissions' => array_except($permissions, ['show'])
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
            'show_all messages' => "مشاهدة
        كل
        الرسائل",
            'create' => 'اضافة رسالة',
        ],
    ],
    'permission' => [
        'name' => 'اسم الصلاحية',
        'permissions' => 'الصلاحيات',
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'اضافة صلاحية',
        ],
    ],
];
