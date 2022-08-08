
<?php

return [
    'permissions' =>  [
        'index' => 'السجل',
        'show' => 'عرض',
        'store' => 'حفظ',
        'restore' => 'استعادة',
        'update' => 'تعديل',
        'create' => 'انشاء',
        'destroy' => 'أرشفة',
        'force_delete' => 'حذف نهائي',
        'archive' => 'عرض أرشيف',
    ],
    'follow_up'=>[
        "chips" => [
            "active" => "مفعل",
            "permanent" => "معطل دائم",
            "temporary" => "معطل لفترة",
            "deactivated" => "تعطيل",
            "activated" => "تفعيل",
            "archive" => "أرشيف",
            "edit" => "تعديل",
            "add" => "إضافة",
            "inActive" => "معطل",
            "actived" => "تفعيل",
            "deactive" => "تعطيل",
            "restored" => "استعادة",
        ],
    ],
    'currency' =>  [
        'permissions' =>  [
            'index' => 'السجل',
            'show' => 'عرض',
            'store' => 'حفظ',
            'restore' => 'استعادة',
            'update' => 'تعديل',
            'create' => 'انشاء',
            'destroy' => 'أرشفة',
            'force_delete' => 'حذف نهائي',
            'archive' => 'عرض أرشيف',
        ],
        'sub_progs' =>  [
            'index' => 'سجل العملات',
            'archive' => 'أرشيف العملات',
            'create' => 'إضافة عملة',
        ],
        'currencies' => 'العملات',
        'currency' => 'العملة ',
        'currency_count' => 'عدد العملات',
        'edit_currency' => 'تعديل العملة',
        'add_currency' => 'إضافة عملة',
    ],
    'vendor_package' => [
        'vendor_package' => 'نسب الخصم',
        'vendor_packages' => 'نسب الخصم',
        'permissions' => [
            'update' => 'تعديل',
            'store' => 'حفظ',
            'index' => 'السجل',
            'destroy' => 'حذف',
            'show' => 'عرض'
        ],
    ],
    'general' => [
            'validation' => [
                'reason' => [
                    "max"   => "يجب أن لا يزيد السبب عن :max حرف ",
                    "min"   => "يجب أن لا يقل السبب عن :min حروف",
                ],
            ],
        'email' => 'البريد الإلكتروني',
        'page_number' => 'ص ',
        'description' => 'الوصف',
        'select_user' => 'اختر مستخدم',
        'username' => 'اسم المستخدم',
        'hold_upload' => 'اسحب وأسقط او قم برفع الصورة',
        'report' => 'طباعة تقرير',
        'Total_employees' => 'الموظفين',
        'from_date' => 'تاريخ الإنشاء (من]',
        'actions' => 'العمليات',
        'fail_send' => 'فشل عملية الارسال',
        'want_force_delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
        'details' => 'التفاصيل',
        'login_code' => 'رمز التحقق',
        'show_all' => 'عرض الكل',
        'success_add' => 'تمت الإضافة بنجاح',
        'un_active_account' => 'هذا المستخدم معطل . برجاء التواصل مع الدعم الفني',
        'delete' => 'حذف',
        'created_at' => 'تاريخ الإنشاء',
        'done_by' => 'تم بواسطة',
        'all_cases' => 'الجميع',
        'confirm' => 'تأكيد',
        'user_name' => 'أدخل الاسم',
        'reset_code' => 'رمز التحقق',
        'close' => 'اغلاق',
        'reason' => 'السبب',
        'settings' => 'الإعدادات',
        'no_reasons' => 'لايوجد',
        'no' => 'غير موافق',
        'Total_unvacant_jobs' => 'الوظائف المشغولة',
        'restore' => 'تمت الاستعادة بنجاح',
        'unactivited' => 'تعطيل',
        'phoneCode_registeration' => 'رقم الجوال غير مسجل بالنظام',
        'create' => 'إضافة',
        'want_saving' => 'هل تريد اتمام عملية الحفظ ؟',
        'black_menu' => 'القائمة السوداء',
        'want_back_without_saving' => 'هل تريد العوده دون الحفظ ؟',
        'active_cases' =>  [
            0 => 'معطلة',
            1 => 'مفعلة',
        ],
        'Total_temporary_users' => 'المستخدمين المعطلين لفترة ',
        'digits_between' => 'يجب أن يحتوي حقل الجوال بين 5 و 20 رقمًا/أرقام .',
        'u_can_use_this_name' => 'يمكنك استخدام الإسم',
        'yes' => 'موافق',
        'name' => 'الاسم',
        'add' => 'إضافة',
        'dashboard' => 'لوحة تحكم رصيد باي',
        'department_active_cases' =>  [
            1 => 'مفعل',
            0 => 'معطل',
        ],
        'success_restore' => 'تم الاستعادة بنجاح',
        'change_password' => 'تغيير كلمة المرور',
        'show_all notification' => 'مشاهدة كل الإشعارات',
        'phone' => 'رقم الجوال',
        'save' => 'حفظ',
        'Total_permenant_users' => 'المستخدمين المعطلين دائماً ',
        'force_delete' => 'حذف نهائي',
        'success_send_login_code' => 'تم ارسال كود التحقق الى رقم الجوال',
        'active' => 'مفعل',
        'refuse' => 'رفض',
        'Permission_field_required' => 'صلاحيات النظام مطلوبة',
        'send' => 'إرسال',
        'Send VerificationCode' => 'إرسال رمز التحقق',
        'select_permissions' => 'اختر الصلاحيات',
        'day_month_year' => 'يوم/شهر/سنة',
        'enter_description' => 'أدخل الوصف',
        'has_relationship_cannot_delete' => 'لا يمكن حذف هذا العنصر ،بسبب احتواءه علي علاقات',
        'status' => 'الحالة',
        'notAllowdedToUpload' => 'نوع الملف غير مسموح بتحميله',
        'invalid_code' => 'رمز التحقق غير صحيح',
        'index' => 'عرض',
        'hold_change' => 'اسحب وأسقط او إضغط لتغيير الصورة',
        'upload_file_max' => 'حجم الملف كبير',
        'the_archive' => 'الأرشيف',
        'select_type' => 'اختر النوع',
        'job_type_cases' =>   [
            1 => 'شاغرة',
            0 => 'مشغولة',
        ],
        'select_employee' => 'اختر موظف',
        'reason_needed' => 'الرجاء ذكر السبب*',
        'notifications' => 'الاشعارات',
        'select_status' => 'اختر الحالة',
        'created_by' => 'منشيء المجموعة',
        'success_delete' => 'تم الحذف بنجاح',
        'search' => 'بحث',
        'edit' => 'تعديل',
        'logout' => 'تسجيل خروج',
        'accept' => 'موافقة',
        'inactive' => 'معطل',
        'want_to_archive' => 'هل تريد إتمام عملية الأرشفة؟',
        'phone_code' => 'حقل رقم الجوال مطلوب',
        'all' => 'الكل',
        'show' => 'عرض',
        'back' => 'عودة',
        'activited' => 'تفعيل',
        'to_date' => 'تاريخ الإنشاء (إلى]',
        'type' => 'النوع',
        'cancel' => 'الغاء',
        'success_update' => 'تم التعديل بنجاح',
        'success_message_forwareded' => 'تم احالة الرسالة الى الموظف',
        'personalfile' => 'الملف الشخص',
        'reason_required' => 'السبب مطلوب',
        'Total_vacant_jobs' => 'الوظائف الشاغرة ',
        'archive' => 'أرشفة',
        'Total_departments' => 'الأقسام ',
        'Total_active_users' => 'المستخدمين المفعلين ',
        'upload_error' => 'اوبس ، حدث خطأ ما',
        'success_archive' => 'تمت الأرشفة بنجاح',
        'sent_successfully' => 'تم الارسال بنجاح',
        'enter_email' => 'أدخل البريد الالكتروني',
        'success_send' => 'تم الإرسال بنجاح',
        'enter_name' => 'أدخل الاسم',
        'want_restore' => 'هل تريد إتمام عملية الاستعادة؟',
        'enter_phone' => 'أدخل الرقم',
        'export' => 'تصدير',
        'cant_update_phone_related_with_hold_transactions' => 'عفوا، لا يمكن تعديل رقم الجوال نظرا لوجود عمليات تحويل جارية',
        'cannot_update' => 'لا يمكن التعديل',
    ],
    'setting' => [
        'sub_progs' =>  [
            'create' => 'إضافة إعداد',
            'index' => 'سجل الاعدادات',
            'archive' => 'أرشيف الاعدادات',
        ],
        'permissions' =>  [
            'update' => 'تعديل',
            'archive' => 'عرض أرشيف',
            'destroy' => 'أرشفة',
            'index' => 'السجل',
            'create' => 'انشاء',
            'force_delete' => 'حذف نهائي',
            'show' => 'عرض',
            'restore' => 'استعادة',
            'store' => 'حفظ',
        ],
        'add_setting' => '',
        'setting' => 'الاعدادات',
        'settings' => 'الاعدادات',
        'setting_count' => '',
    ],
    'transaction' =>  [
        'status_cases' => [
            'pending' => 'بانتظار الاستلام',
            'fail' => 'فاشلة',
            'cancel' => 'تم الالغاء',
            'success' => 'ناجحة',
            'received' => 'تم الاستلام',
        ],
        'type_cases' =>   [
            'payment' => 'دفع فاتورة',
            'local_transfer' => 'تحويل محلي',
            'charge' => 'شحن',
            'promote_package' => 'ترقية بطاقة',
            'global_transfer' => 'تحويل دولي',
            'money_request' => 'طلب أموال',
            'wallet_transfer' => 'تحويل لمحفظة',
        ],
        'permissions' =>   [
            'restore' => 'استعادة',
            'create' => 'انشاء',
            'index' => 'السجل',
            'transactions_statues' => 'حالات التحويلات',
            'store' => 'حفظ',
            'show' => 'عرض',
            'archive' => 'عرض أرشيف',
            'force_delete' => 'حذف نهائي',
            'destroy' => 'أرشفة',
            'update' => 'تعديل',
        ],
        'card_cases' =>   [
            'platinum' => 'البطاقة البلاتينية',
            'golden' => 'البطاقة الذهبية',
            'basic' => 'البطاقة الاساسية',
        ],
        'enter_transaction_date' => 'أدخل تاريخ المعاملة',
        'transaction_amount' => 'قيمة المعاملة',
        'enter_user_identity' => 'أدخل الرقم',
        'choose_card' => 'اختر البطاقة',
        'transaction_date_from' => ' تاريخ المعاملة (من]',
        'enter_transaction_number' => 'أدخل الرقم',
        'choose_client_name' => 'اختر العميل',
        'to_user_client' => 'اسم العميل',
        'choose_status' => 'اختر الحالة',
        'enter_from_user' => 'أدخل الاسم',
        'sub_progs' =>   [
            'archive' => 'أرشيف المعاملات',
            'show' => 'عرض المعاملة',
            'index' => 'سجل المعاملات',
        ],
        'transactions' => 'سجل المعاملات',
        'transaction_amount_from' => ' قيمة المعاملة (من]',
        'transaction_number' => 'رقم المعاملة',
        'total_amount' => 'قيمة الفاتورة',
        'enter_to_user_client' => 'أدخل الاسم',
        'transaction_amount_to' => ' قيمة المعاملة (إلى]',
        'transaction' => 'المعاملة',
        'active_card' => 'البطاقة المفعلة',
        'enter_total_amount' => 'أدخل قيمة الفاتورة',
        'transaction_date' => 'تاريخ المعاملة',
        'gift_balance' => 'المكافآت',
        'enter_transaction_amount' => 'أدخل قيمة المعاملة',
        'transaction_status' => 'حالة المعاملة',
        'from_user' => 'اسم المستخدم',
        'user_identity' => 'رقم الهوية',
        'transaction_date_to' => ' تاريخ المعاملة (إلى]',
        'choose_type' => 'اختر النوع',
        'transaction_type' => 'نوع المعاملة',
    ],
    'manager' => [
        'managers' => 'العملاء',
    ],
    'group' =>  [
        'all_groups' => 'الصلاحيات',
        'permissions' =>  [
            'index' => 'السجل',
            'destroy' => 'أرشفة',
            'create' => 'انشاء',
            'store' => 'حفظ',
            'update' => 'تعديل',
            'show' => 'عرض',
        ],
        'active_cases' =>
            [
                0 => 'معطل',
                1 => 'مفعل',
            ],
        'sub_program' => 'البرنامج الفرعي',
        'add_group' => 'إضافة مجموعة',
        'group_name' => 'اسم المجموعة',
        'show_group' => 'عرض مجموعة',
        'group_count' => 'عدد المجموعات',
        'sub_progs' => [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'إضافة مجموعة',
        ],
        'groups' => 'المجموعات',
        'group' => 'المجموعة الادارية',
        'chosen_groups' => 'الصلاحيات المختارة',
        'sorry_group_name_is_repeated' => 'الاسم موجود من قبل',
        'edit_group' => 'تعديل مجموعة',
        'group_name_required' => 'اسم المجموعة مطلوب',
        'admins_count' => 'عدد المستخدمين',
        'admins_to' => 'عدد المستخدمين إلى',
        'group_data' => 'بيانات المجموعة',
        'main_program' => 'البرنامج الرئيسي',
        'admins_from' => 'عدد المستخدمين من',
    ],
    'transfer' => [
        'transfers' => 'التحويلات',

    ],
    'card' => [
        'cards' => 'البطاقات',
        'sub_progs' => 'البرنامج'
    ],
    'bank_transfer' => [
        'bank_transfers' => 'التحويلات البنكية',

    ],
    'activity_log' =>  [
        'models' =>  [
            'admin' => 'المستخدم',
            'department' => 'القسم',
            'attachment' => 'المرفق',
            'profile' => 'البروفايل',
            'permission' => 'الصلاحية',
            'vendor' => 'العميل',
            'rasidjob' => 'الوظيفة',
            'manager' => 'المدير',
            'bankaccount' => 'الحساب بنكى',
            'group' => 'المجموعة',
            'citizen' => 'المستخدم',
            'cardpackage' => 'باقة البطاقة',
            'bank' => 'البنك',
            'user' => 'اليوزر',
            'employee' => 'الموظف',
            'attachments' => 'المرفقات',
            'attachmentfile' => ' ملف المرفقات',
            'type_job_name' => 'أدخل الاسم',
            'contact' => 'صندوق الرسائل',
            'transferpurpose' => 'أغراض التحويل',
            'staticpage' => 'الصفحات الثابتة',
            'ourapp' => 'تطبيقاتنا',
            'faq' => 'الأسئلة الشائعة',
            'messagetype' => 'نوع الرسالة',
            'vendorbranch' => 'أفرع العميل',
            'transaction' => 'المعاملات',
            'transfer' => 'التحويلات',
            'setting' => 'الإعدادات',
            'currency' => 'العملات',
            'banktransfer' => 'تحويل بنكي'

        ],
        'transfer' => [
            'transfers' => 'التحويلات',

        ],
        'card' => [
            'cards' => 'البطاقات',
            'sub_progs' => 'البرنامج'
        ],
        'bank_transfer' => [
            'bank_transfers' => 'التحويلات البنكية',

        ],
        'activity_log' => 'المتابعة',
        'actions' =>  [
            'searched' => 'بحث',
            'created' => 'إضافة',
            'temporary' => 'تعطيل لفترة',
            'updated' => 'تعديل',
            'activated' => 'تفعيل',
            'restored' => 'استعادة',
            'destroy' => 'أرشفة',
            'permanent_delete' => 'حذف',
            'deactivated' => 'تعطيل',
            'permanent' => 'تعطيل دائم',
            'shown'     => 'الإطلاع',
            'assigned' => 'الإحالة',
            'replied' => 'الرد'
        ],
        'select_activity' => 'اختر النشاط',
        'select_subprogram' => 'اختر برنامج فرعي',
        'activity_log_records' => 'سجل النشاطات',
        'sub_programs' =>  [
            'index' => 'المتابعة',
            'create' => 'إضافة',
            'show' => 'عرض المتابعة',
            'ban_status' => 'حظر',
            'archive' => 'أرشفة',
        ],
        'permissions' =>  [
            'show' => 'عرض',
            'index' => 'السجل',
        ],
        'sub_progs' =>  [
            'show' => 'عرض المتابعة',
            'ban_status' => 'حظر',
            'create' => 'إضافة',
            'archive' => 'أرشفة',
            'index' => 'المتابعة',
        ],
        'select_employee' => 'اختر موظف',
        'reason' => 'تم :action :model (:name)',
        'sub_program' => 'البرنامج الفرعي',
        'main_program' => 'البرنامج الرئيسي',
        'ip_address' => 'رقم معرف الجهاز',
        'date' => 'تاريخ النشاط',
        'history' => 'الحركة التاريخية',
        'activity_logs' => 'المتابعة',
        'employees' => ' الموظفين',
        'activity' => ' النشاط',
        'select_mainprogram' => 'اختر برنامج رئيسي',
    ],
    'package' =>  [
        'discount_success_add' => 'تم إضافة نسب خصم البطاقات للعميل ',
        'basic_card_discount' => 'نسبة خصم البطاقة الأساسية',
        'permissions' =>  [
            'restore' => 'استعادة',
            'store' => 'حفظ',
            'archive' => 'عرض أرشيف',
            'update' => 'تعديل',
            'index' => 'السجل',
            'force_delete' => 'حذف نهائي',
            'destroy' => 'أرشفة',
            'create' => 'انشاء',
        ],
        'cards_discount_records' => 'سجل نسب خصم البطاقات',
        'platinum_card_discount' => 'نسبة خصم البطاقة البلاتينية',
        'add' => 'إضافة نسب الخصم',
        'package_title' => 'نسبة خصم :name',
        'without' => 'لا يوجد',
        'client_name' => 'اسم العميل',
        'select_client_name' => 'اختر العميل',
        'golden_card_discount' => 'نسبة خصم البطاقة الذهبية',
        'cards_discount' => 'نسب خصم البطاقات',
        'basic_card' => 'البطاقة الأساسية',
        'choose_client' => 'اختار العميل',
        'discount_success_update' => 'تم تعديل نسب خصم البطاقات للعميل ',
        'golden_card' => 'البطاقة الذهبية',
        'package' => 'نسب خصم البطاقات',
        'platinum_card' => 'البطاقة البلاتينية',
        'packages' => 'نسب خصم البطاقات',
        'enter_discount' => 'أدخل نسبة الخصم',
    ],
    'client_package' =>  [
        'permissions' =>   [
            'getMainPackages' => 'عرض الباقات الاساسية',
            'archive' => 'عرض أرشيف',
            'update' => 'تعديل',
            'show' => 'عرض',
            'index' => 'السجل',
            'get_clients' => 'عرض العملاء',
            'store' => 'حفظ',
            'restore' => 'استعادة',
            'destroy' => 'أرشفة',
            'force_delete' => 'حذف نهائي',
            'create' => 'انشاء',
        ],
        'client_packages' => 'باقات العميل',
        'client_package' => 'باقات العميل',
    ],
    'slide' => [
        'permissions' => [
            'index' => 'السجل',
            'create' => 'انشاء',
            'archive' => 'عرض أرشيف',
            'show' => 'عرض',
            'destroy' => 'أرشفة',
            'force_delete' => 'حذف نهائي',
            'update' => 'تعديل',
            'restore' => 'استعادة',
            'store' => 'حفظ',
        ],
        'sub_progs' =>  [
            'index' => 'سجل الاسلايدز',
            'archive' => 'أرشيف الاسلايدز',
            'edit' => 'تعديل اسلايد',
            'create' => 'تسجيل اسلايد',
            'show' => ' عرض اسلايد',
        ],
        'slides' => 'الاسلايدز',
        'add_slide' => 'إضافة اسلايد',
        'admin_slide' => 'عدد الاسلايدز',
        'select_slide' => 'اختر اسلايد',
        'slide' => 'الاسلايد',
        'edit_slide' => 'تعديل اسلايد',
    ],
    'datatable' => [
        'entries' => 'الاجمالي',
        'from' => 'من',
        'there_is_no_data' => 'لا يوجد نتائج بحث متاحة',
        'to' => 'إلى',
        'no_data' => 'لا توجد نتائج متاحة',
        'showing' => 'عرض',
        'no_search_result' => 'لا يوجد نتائج بحث متاحة',
    ],
    'region' => [
        'sub_progs' => [
            'create' => 'إضافة منطقة',
            'archive' => 'أرشيف المناطق',
            'index' => 'سجل المناطق',
        ],
        'add_region' => 'إضافة منطقة',
        'permissions' =>  [
            'update' => 'تعديل',
            'force_delete' => 'حذف نهائي',
            'store' => 'حفظ',
            'create' => 'انشاء',
            'restore' => 'استعادة',
            'destroy' => 'أرشفة',
            'show' => 'عرض',
            'index' => 'السجل',
            'archive' => 'عرض أرشيف',
        ],
        'regions' => 'المناطق',
        'edit_region' => 'تعديل المنطقه',
        'region_count' => 'عدد المناطق',
        'region' => 'المنطقة ',
    ],

    'bank' =>  [
        'Enter_service_Number' => 'ادخل رقم خدمة العملاء',
        'sub_progs' =>  [
            'edit' => 'تعديل بنك',
            'create' => 'إضافة بنك',
            'index' => 'سجل البنوك',
            'archive' => 'أرشيف البنوك',
            'show' => 'عرض البنك',
            'active_cases' =>
            [
                0 => 'معطل',
                1 => 'مفعل',
            ],
        ],
        'permissions' =>  [
            'archive' => 'عرض أرشيف',
            'banks_types' => 'انواع البنوك',
            'store' => 'حفظ',
            'update' => 'تعديل',
            'force_delete' => 'حذف نهائي',
            'show' => 'عرض',
            'index' => 'السجل',
            'restore' => 'استعادة',
            'create' => 'انشاء',
            'destroy' => 'أرشفة',
        ],
        'types' =>  [
            'savings' => 'بنك إدخار',
            'islamic' => 'بنك إسلامي',
            'agricultural' => 'بنك زراعي',
            'investment' => 'استثماري',
            'centeral' => 'بنك مركزي',
            'industrial' => 'بنك صناعي',
            'commercial' => 'بنك تجاري',
            'real_estate' => 'بنك عقاري',
            'bank' => 'بنك',
        ],
        'add_bank' => 'إضافة بنك',
        'bank_name' => 'اسم البنك',
        'Enter_Bank_branch_name' => 'أدخل الاسم',
        'taxNumber' => 'الرقم الضريبي',
        'Enter_bank_code' => 'ادخل الكود ',
        'serviceNumber' => 'رقم خدمة العملاء',
        'code' => 'الكود',
        'type' => 'نوع البنك',
        'Enter_tax_Number' => 'ادخل الرقم الضريبي',
        'Enter_commercial_Record' => 'ادخل السجل التجاري',
        'Enter_bank_location' => 'ادخل الموقع',
        'edit_bank' => 'تعديل بنك',
        'Add new Branch' => 'إضافة فرع جديد',
        'banks' => 'البنوك',
        'bank_count' => 'عدد البنوك',
        'bank' => 'البنك',
        'select_bank' => 'اختر البنك',
        'transaction_Value_From' => 'قيمة تكلفة التحويل',
        'NumberTransactions' => 'عدد المعاملات',
        'Enter_Bank_name' => 'أدخل الاسم',
        'BranchName' => 'اسم الفرع',
        'type bank' => 'النوع',
        'Enter_NumberTransactions' => 'ادخل عدد المعاملات',
        'commercialRecord' => 'السجل التجاري',
        'location' => 'الموقع',
        'Enter_transfer_amount' => 'ادخل قيمة التحويل',
    ],
    'error' =>  [
        'something_went_wrong' => 'البيانات المدخلة غير صحيحة',
        'method_not_allow' => 'طريقة الطلب (:method] غير صحيحة',
        'not_found' => 'لم يتم العثور على بيانات',
        'page_not_found' => '404, الصفحة غير موجودة',
        'name_must_be_unique_on_department' => 'الاسم موجود من قبل لهذا القسم',
    ],
    'citizens' => [
        'without' => 'بدون',
        'name' => 'اسم المستخدم',
        'card_end_at_to' => 'تاريخ انتهاء البطاقة (إلى]',
        'choose_card' => 'اختر البطاقة',
        'created_at_from' => 'تاريخ التسجيل (من]',
        'actions' => 'العمليات',
        'enabled_package' => 'البطاقة المفعلة',
        'edit_phone' => 'تعديل رقم الجوال',
        'citizens_record' => 'سجل المستخدمين',
        'phone_unique' => 'رقم الجوال مكرر',
        'new_phone' => 'رقم الجوال الجديد',
        'created_at' => 'تاريخ التسجيل',
        'identity_number' => 'رقم الهوية',
        'phone' => 'رقم الجوال',
        'enter_name' => 'أدخل الاسم',
        'created_at_to' => 'تاريخ التسجيل (إلى]',
        'enter_identity_number' => 'أدخل الرقم',
        'phone_required' => 'رقم الجوال مطلوب',
        'card_end_at' => 'تاريخ انتهاء البطاقة',
        'enter_phone' => 'أدخل الرقم',
        'card_end_at_from' => 'تاريخ انتهاء البطاقة (من]',
        'citizens' => 'المستخدمين',
    ],
    'country' => [
        'countries' => 'الدول',
        'permissions' =>   [
            'index' => 'السجل',
            'create' => 'انشاء',
            'show' => 'عرض',
            'update' => 'تعديل',
            'restore' => 'استعادة',
            'force_delete' => 'حذف نهائي',
            'store' => 'حفظ',
            'archive' => 'عرض أرشيف',
            'destroy' => 'أرشفة',
        ],
        'sub_progs' =>   [
            'create' => 'إضافة دولة',
            'archive' => 'أرشيف الدول',
            'index' => 'سجل الدول',
        ],
        'edit_country' => 'تعديل دولة',
        'add_country' => 'إضافة دولة',
        'country' => 'الدولة',
        'country_count' => 'عدد الدول',
    ],
    'employee' =>  [
        'employee_count' => 'عدد الموظفين',
        'permissions' =>   [
            'store' => 'حفظ',
            'show' => 'عرض',
            'create' => 'انشاء',
            'update' => 'تعديل',
            'destroy' => 'أرشفة',
            'index' => 'السجل',
        ],
        'sub_progs' =>  [
            'archive' => 'أرشيف الموظفين',
            'index' => 'سجل الموظفين',
            'create' => 'إضافة موظف',
        ],
        'add_employee' => 'إضافة موظف',
        'edit_employee' => 'تعديل موظف',
        'employees' => 'الموظفين',
        'employee' => 'الموظف',
    ],
    'client' => [
        'sub_progs' =>  [
            'show' => ' عرض عميل',
            'edit' => 'تعديل عميل',
            'account_order' => 'طلبات فتح حساب',
            'index' => 'سجل العملاء',
            'archive' => 'أرشيف العملاء',
            'create' => 'تسجيل عميل',
        ],
        'permissions' =>  [
            'destroy' => 'أرشفة',
            'force_delete' => 'حذف نهائي',
            'archive' => 'عرض أرشيف',
            'store' => 'حفظ',
            'restore' => 'استعادة',
            'create' => 'انشاء',
            'index' => 'السجل',
            'update' => 'تعديل',
            'show' => 'عرض',
        ],
        'account_statuses' =>  [
            'reviewed' => 'تمت المراجعة',
            'pending' => 'لم يتم تاكيد الحساب البنكى ',
            'accepted' => 'تمت الموافقة',
            'before_review' => 'قبل المراجعة',
            'refused' => 'تم الرفض',
        ],
        'client' => 'العميل',
        'status' => 'الحالة',
        'name' => 'اسم العميل',
        'clients' => 'العملاء',
        'client_type' =>   [
            'institution' => 'مؤسسات',
            'other' => 'أخري',
            'company' => 'شركات',
            'famous' => 'مشاهير',
            'freelance_doc' => 'مستقل',
            'member' => 'عضو',
        ],
        'order_date' => 'تاريخ الطلب',
        'select_client' => 'اختر العميل',
        'add_client' => 'إضافة عميل',
        'tax_number' => 'الرقم الضريبي',
        'bank_name' => 'البنك التابع له',
        'transactions_done_from' => 'عدد المعاملات المنجزة من',
        'transactions_done_to' => 'عدد المعاملات المنجزة الى',
        'account_status' => 'حالة الحساب البنكي',
        'edit_client' => 'تعديل عميل',
        'transactions_done_to_date' => 'عدد المعاملات المنجزة فى الفترة الى',
        'order_number' => 'رقم الطلب',
        'admin_client' => 'عدد العملاء',
        'transactions_done_from_date' => 'عدد المعاملات المنجزة فى الفترة من',
        'commercial_number' => 'رقم السجل',
        'transactions_done' => 'عدد المعاملات المنجزة',
        'type' => 'نوع العميل',
    ],
    'admin' =>  [
        'new_password' => 'كلمة المرور الجديدة',
        'u_can_use_this_id' => 'يمكنك استخدام هذا الرقم',
        'u_can_not_use_this_email' => 'لا يمكنك إدخال بريد الكتروني مستخدم',
        'confirmed_password' => 'تاكيد كلمة المرور',
        'admin_name' => 'أدخل الاسم',
        'name' => 'الموظف',
        'permissions' =>   [
            'show' => 'عرض',
            'store' => 'حفظ',
            'create' => 'انشاء',
            'destroy' => 'أرشفة',
            'index' => 'السجل',
            'update' => 'تعديل',
        ],
        'sub_progs' =>
        [
            'create' => 'إضافة مستخدم',
            'archive' => 'أرشيف المستخدمين',
            'show' => 'عرض مستخدم',
            'index' => 'سجل المستخدمين',
        ],
        'edit_admin' => 'تعديل المستخدم',
        'enter_password' => 'أدخل كلمة المرور',
        'admin_count' => 'عدد المستخدمين',
        'enter_number' => 'أدخل الرقم',
        'active_cases' =>
        [
            'permanent' => 'معطل دائم',
            'active' => 'مفعل',
            'temporary' => 'معطل لفترة',
            'exceeded_attempts' => 'تعدي محاولات الدخول الخاطئة'
        ],
        'admin' => 'اسم المستخدم',
        'login_id' => 'رقم المستخدم',
        'admins' => 'المستخدمين',
        'permission_system' => 'صلاحيات النظام',
        'ban_from' => 'معطل لفترة (من]',
        'ban_to' => 'معطل لفترة (إلى]',
        'add_admin' => 'إضافة مستخدم',
        'password' => 'كلمة المرور ',
        'enter_login_id' => 'أدخل الرقم',
    ],
    'department' =>  [
            'validation' => [
                'name'  => [
                    'required' => 'اسم القسم مطلوب',
                    'unique' => 'الاسم موجود من قبل',
                    'min' => 'لاسم يجب ان لا يقل عن :min حروف',
                    'max' => 'لاسم يجب ان لا يزيد عن :max حرف',
                ],
                'description' => [
                    'max'   => 'الوصف يجب أن لا يزيد عن :max حرف'
                ],
                'image' => [
                    'max' => 'لا يجب أن يزيد الحجم عن 1 ميجا بايت',
                    'mimes' => '(:values) يقبل فقط صيغة الملفات',
                ],
            ],
        'is_active' => 'الحالة',
        'permissions' => [
            'index' => 'السجل',
            'create' => 'انشاء',
            'archive' => 'عرض أرشيف',
            'show' => 'عرض',
            'destroy' => 'أرشفة',
            'force_delete' => 'حذف نهائي',
            'update' => 'تعديل',
            'restore' => 'استعادة',
            'store' => 'حفظ',
        ],
        'sub_progs' =>
        [
            'show' => 'عرض قسم',
            'archive' => 'أرشيف الأقسام',
            'create' => ' إضافة قسم ',
            'index' => 'سجل الأقسام',
        ],
        'without' => 'بدون قسم',
        'department_name' => 'اسم القسم',
        'permissions' =>
        [
            'index' => 'السجل',
            'archive' => 'عرض أرشيف',
            'export' => 'تصدير',
            'force_delete' => 'حذف نهائي',
            'show' => 'عرض',
            'store' => 'حفظ',
            'update' => 'تعديل',
            'restore' => 'استعادة',
            'destroy' => 'أرشفة',
            'create' => 'انشاء',
            'get_parents' => 'عرض الأقسام الرئيسية',
        ],
        'active_cases' =>
        [
            0 => 'معطل',
            1 => 'مفعل',
        ],
        'add_department' => 'إضافة قسم',
        'has_jobs_cannot_delete' => 'لا يمكن أرشفة قسم مرتبط بوظائف',
        'archive_to_date' => 'تاريخ الأرشفة  (إلى]',
        'departments' => 'الاقسام',
        'without_parent' => 'بدون قسم رئيسي ',
        'department_archive' => 'أرشيف الأقسام',
        'search' => 'بحث',
        'department_count' => 'عدد الاقسام',
        'select_department' => 'اختر القسم',
        'department_image' => 'صورة القسم',
        'show_all' => 'عرض الكل',
        'department_has_relationship_cannot_delete' => 'لا يمكن أرشفة هذا القسم لأنه يحتوي علي أقسام فرعية   ',
        'main_department' => 'القسم الرئيسي',
        'edit_department' => 'تعديل قسم',
        'select_main_department' => 'اختر القسم الرئيسي',
        'department' => 'القسم ',
        'archive_from_date' => 'تاريخ الأرشفة  (من]',
        'archived_at' => ' تاريخ الأرشفة',
        'department_main' => 'القسم الرئيسي',
    ],
    'our_app' => [
        'our_apps' => 'تطبيقاتنا',
        'permissions' => [
            'store' => 'حفظ',
            'show' => 'عرض',
            'destroy' => 'حذف'
        ],
        'active_cases' =>
            [
                0 => 'معطل',
                1 => 'مفعل',
            ],
    ],

    'faq' => [
        'faqs' => 'الاسئلة الشائعة',
        'permissions' => [
            'index' => 'السجل',
            'store' => 'حفظ',
            'destroy' => 'حذف',
            'update' => 'تعديل',
            'show' => 'عرض'
        ],
        'active_cases' =>
        [
            0 => 'معطل',
            1 => 'مفعل',
        ],
    ],


    'vendor' => [
        'vendors' => 'العملاء',
        'permissions' => [
            'index' => 'السجل',
            'update' => 'تعديل',
            'destroy' => 'حذف',
            'show' => 'عرض',
            'store' => 'حفظ',
        ],
        'active_cases' =>
        [
            0 => 'معطل',
            1 => 'مفعل',
        ],
    ],

    'vendor_branch' => [
        'vendor_branches' => 'أفرع العميل',
        'permissions' => [
            'index' => 'السجل',
            'store' => 'حفظ',
            'destroy' => 'حذف',
            'show' => 'عرض',
            'update' => 'تعديل'

        ],
        'active_cases' =>
        [
            0 => 'معطل',
            1 => 'مفعل',
        ],

        'validation' => [
            'vendor_id' => [
                'required' => 'حقل اسم العميل مطلوب',
                'exists' => 'حقل اسم العميل غير موجود'
            ],
            'location' => [
                'required' => 'حقل الموقع مطلوب',
                'string' => 'حقل الموقع يجب أن يكون قيمة نصية',
                'between' => 'حقل الموقع يجب ان يكون بين :min و :max حرف'
            ],
            'address_details' => [
                'required' => 'حقل العنوان بالتفصيل مطلوب',
                'string' => 'حقل العنوان بالتفصيل يجب أن يكون قيمة نصية',
                'between' => 'حقل العنوان بالتفصيل يجب ان يكون بين :min و :max حرف'
            ],
            'lat' => [
                'required' => 'حقل خط الطول مطلوب',
                'numeric' => 'حقل خط الطول يجب أن يكون قيمة رقمية',
            ],
            'lng' => [
                'required' => 'حقل خط الطول مطلوب',
                'numeric' => 'حقل خط العرض يجب أن يكون قيمة رقمية',
            ],
            'email' => [
                'required' => 'حقل البريد الالكتروني مطلوب',
                'email' => 'حقل البريد الالكتروني يجب أن يكون بصيغة صحيحة',
                'unique' => 'حقل البريد الالكتروني يجب أن لا يتكرر',
            ],
            'is_active' => [
                'required' => 'حقل الحالة مطلوب',
                'in' => 'حقل الحالة يجب أن يكون بين هذه القيم :values',
                'unique' => 'حقل البريد الالكتروني يجب أن لا يتكرر',
            ],
            'phone' => [
                'required' => 'حقل رقم الهاتف مطلوب',
                'numeric' => 'حقل رقم الهاتف ينبغي أن يكون رقماً',
                'digits_between' => 'حقل رقم الهاتف ينبغي أن يكون أرقاماً بين :min و :max',
                'starts_with' => 'حقل رقم الهاتف ينبغي أن يبدأ بأرقام :values ',
                'unique' => 'حقل رقم الهاتف يجب أن لا يتكرر',
            ],
            'logo' => [
                'required' => 'حقل صورة الفرع مطلوب',
                'image' => 'حقل صورة الفرع يجب أن يكون صورة',
                'mimes' => 'حقل صورة الفرع يجب أن يكون من نوع  :values',
                'max' => 'يجب أن يكون حقل صورة الفرع على الأكثر :max ميجا',
                'numeric' => 'حقل خط الطول يجب أن يكون قيمة رقمية',
            ],
            'ar' => [
                'name'=> [
                    'required' => 'حقل اسم الفرع مطلوب',
                    'string' => 'حقل اسم الفرع يجب أن يكون قيمة نصية',
                    'between' => 'حقل اسم الفرع يجب ان يكون بين :min و :max حرف'
                ]
            ],
        ]
    ],

    'transfer_purposes' => [
        'validation' => [
            'ar' => [
                'name'=> [
                    'unique' => 'حقل الغرض من التحويل لا يجب أن يتكرر',
                ]
            ],
        ],
        'active_cases' =>
        [
            0 => 'معطل',
            1 => 'مفعل',
        ],
    ],
    'city' =>
    [
        'edit_city' => 'تعديل المدينة',
        'permissions' =>
        [
            'create' => 'انشاء',
            'force_delete' => 'حذف نهائي',
            'restore' => 'استعادة',
            'destroy' => 'أرشفة',
            'archive' => 'عرض أرشيف',
            'update' => 'تعديل',
            'show' => 'عرض',
            'store' => 'حفظ',
            'index' => 'السجل',
        ],
        'add_city' => 'إضافة مدينة',
        'city_count' => 'عدد المدن',
        'sub_progs' =>
        [
            'create' => 'إضافة مدينة',
            'index' => 'سجل المدن',
            'archive' => 'أرشيف المدن',
        ],
        'cities' => 'المدن',
        'city' => 'المدينة',
    ],
    'rasid_job' =>  [
        'choose_rasid_job' => 'اختر الوظيفة',
        'from_date' => 'تاريخ الإنشاء (من]',
        'permissions' =>
        [
            'update' => 'تعديل',
            'store' => 'حفظ',
            'destroy' => 'أرشفة',
            'restore' => 'استعادة',
            'index' => 'السجل',
            'show' => 'عرض',
            'create' => 'انشاء',
            'force_delete' => 'حذف نهائي',
            'archive' => 'عرض أرشيف',
        ],
        'show' => 'عرض',
        'sub_progs' =>
        [
            'archive' => 'أرشيف الوظائف',
            'index' => 'سجل الوظائف',
            'create' => 'إضافة وظيفة',
            'show' => 'عرض وظيفة',
        ],
        'rasid_job' => 'الوظيفة',
        'rasid_job_count' => 'عدد الوظائف',
        'rasid_jobs' => 'الوظائف',
        'actions' => 'العمليات',
        'select_department' => 'اختر القسم',
        'is_vacant' =>
        [
            'false' => 'مشغولة',
            'true' => 'شاغرة',
        ],
        'job_count' => 'عدد الوظائف',
        'edit_job' => 'تعديل وظيفة',
        'add_job' => 'إضافة وظيفة',
        'enter_name' => 'أدخل الاسم',
        'edit_rasid_job' => 'تعديل الوظيفة',
        'archived_at' => ' تاريخ الأرشفة',
        'created_at' => 'تاريخ الإنشاء',
        'archive_from_date' => 'تاريخ الأرشفة  (من]',
        'name' => 'اسم الوظيفة',
        'employee_name' => 'اسم الموظف',
        'jobs_hired_is_active_changed' => ' لا يمكن تعطيل  هذه الوظيفة لانها مشغولة ',
        'is_active' => 'الحالة',
        'select_job' => 'اختر الوظيفة',
        'add_rasid_job' => 'إضافة وظيفة',
        'archive_to_date' => 'تاريخ الأرشفة  (إلى]',
        'jobs' => 'الوظائف',
        'job_name' => 'اسم الوظيفة',
        'active_cases' =>
        [
            0 => 'معطلة',
            1 => 'مفعلة',
        ],
        'rasid_job_department' => 'اسم القسم',
        'department' => 'القسم',
        'to_date' => 'تاريخ الإنشاء (إلى]',
        'search' => 'بحث',
        'show_all' => 'عرض الكل',
        'jobs_hired_deleted' => ' لا يمكن حذف هذه الوظيفة لانها مشغولة ',
        'rasid_job_description' => 'الوصف الوظيفي',
        'jobs_hired_archived' => ' لا يمكن أرشفة هذه الوظيفة لانها مشغولة ',
        'validation' =>
        [
            'name_must_be_unique_on_department' => 'الاسم موجود من قبل لهذا القسم',
        ],
        'job_description' => 'وصف الوظيفة',
    ],
    'permissions' =>   [
        'show' => 'عرض',
        'index' => 'السجل',
        'restore' => 'استعادة',
        'archive' => 'عرض أرشيف',
        'store' => 'حفظ',
        'update' => 'تعديل',
        'force_delete' => 'حذف نهائي',
        'destroy' => 'أرشفة',
        'create' => 'انشاء',
    ],
    'user' => [
        'sub_progs' =>
        [
            'archive' => 'أرشيف المستخدمين',
            'create' => 'إضافة مستخدم',
            'index' => 'سجل المستخدمين',
        ],
        'users' => 'المستخدمين',
    ],
    'bank_account' => [
        'permissions' =>
        [
            'show' => 'عرض',
            'restore' => 'استعادة',
            'store' => 'حفظ',
            'create' => 'انشاء',
            'index' => 'السجل',
            'archive' => 'عرض أرشيف',
            'update' => 'تعديل',
            'destroy' => 'أرشفة',
            'force_delete' => 'حذف نهائي',
        ],
        'order_number' => 'رقم الطلب',
        'bank_accounts' => 'العملاء',
    ],
    'device' => [
        'devices' => 'الأجهزة',
        'sub_progs' =>
        [
            'archive' => 'أرشيف الأجهزة',
            'index' => 'سجل الأجهزة',
        ],
    ],
    'localization' => [
        'localizations' => 'الترجمات',
        'permissions' =>
        [
            'update' => 'تعديل الترجمات',
            'index' => 'سجل الترجمات',
            'store' => 'إنشاء الترجمات',
        ],
    ],
    'link' => [
        'links' => 'الروابط',
        'permissions' =>
        [
           'index' => 'السجل',
           'update' => 'تعديل',
           'destroy' => 'حذف',
           'show' => 'عرض',
        ],
    ],
    'transfer_purpose' => [
        'transfer_purposes' => 'أغراض التحويل',
        'permissions' =>
        [
           'destroy' => 'حذف',
           'index' => 'السجل',
           'update' => 'تعديل',
           'show' => 'عرض',
           'store' => 'حفظ'

        ],
    ],
    'cardpackage' =>  [
        'golden' => 'ذهبية',
        'cardpackages' => 'باقات البطاقات',
        'basic' => 'اساسية',
        'platinum' => 'بلاتينية',
    ],
    'package_types' => [
        "basic" => "أساسية",
        "golden" => "ذهبية",
        "platinum" => "بلاتينية"
    ],
    'message' =>  [
        'sub_progs' =>  [
            'index' => 'سجل الرسائل',
            'show_all messages' => 'مشاهدة كل الرسائل',
            'archive' => 'أرشيف الرسائل',
            'create' => 'إضافة رسالة',
        ],
        'messages' => 'الرسائل',
    ],
    'messages'=>[
        'login_firstly' => 'يجب تسجيل الدخول اولا'
    ],
    'message_type' =>  [
        'message_types' => 'أنواع الرسائل',
        'name' => 'الاسم',
        'employee_count'=> 'عدد الموظفين',
        'permissions' => [
            'store' => 'حفظ',
            'index' => 'السجل',
            'update' => 'تعديل',
            'show' => 'عرض',
            'destroy' => 'حذف',
        ],
        'active_cases' =>
        [
            0 => 'معطل',
            1 => 'مفعل',
        ],

    ],

    'citizen' =>  [
        'add_citizen' => 'إضافة مستخدم',
        'permissions' => [
            'show' => 'عرض',
            'index' => 'السجل',
            'update' => 'تعديل'
        ],
        'sub_progs' =>  [
            'index' => 'سجل مستخدمي التطبيق',
            'create' => 'إضافة مستخدم',
        ],
        'citizen_count' => 'عدد مستخدمي التطبيق',
        'citizens' => 'مستخدمي التطبيق',
        'citizen' => 'المستخدم ',
        'edit_citizen' => 'تعديل مستخدم',
    ],
    'attachment' => [
        'attachments' => 'العملاء',
    ],
    'profile' =>  [
        'profiles' => 'الملفات الشخصية',
        'edit_profile' => 'تعديل الملف الشخصي',
        'show_profile' => 'عرض الملف الشخصي',
        'profile' => 'الملف الشخصي',
    ],
    'contact' =>  [
        'contacts' => 'الدعم الفني',
        'contact' => 'الدعم الفني',
        'name' =>'رسالة',
        'can_not_delete_contact' => 'لا يمكن حذف نوع رسالة مرتبط برسائل',
        'replied' =>'تم الرد',
        'validation' => [
            'contact_id' => [
                'required' => 'مطلوب حقل رقم الرسالة',
                'unique' => 'حقل   رقم الرسالة يجب أن لا يتكرر'
            ],
            'reply' => [
                'required' => 'حقل الرد مطلوب',
                'string' => 'حقل الرد  يجب أن يكون قيمة نصية',
            ],
        ],
        'message_sources'=>[
            'app' => 'التطبيق',
            'website' => 'الموقع',
        ],
        'message_status'=>[
            'replied' =>'تم الرد',
            "pending" => "بانتظار الرد ",
            "shown" => "تم الإطلاع",
            "assigned" => "تم الإحالة",
        ],

        'permissions' =>
        [
            'delete_reply' => 'حذف الرد علي رسالة دعم فني',
            'reply' => 'الرد علي رسالة دعم فني',
            'delete_contact' => 'حذف رسالة دعم فني',
            'index' => 'رسائل الدعم الفني',
            'show' => 'عرض رسالة الدعم الفني',
            'assign_contact' => 'تحويل رسالة',
            'destroy' => 'حذف',
            'store' => 'حفظ',
            'update' => 'تعديل'
        ],
        'types' =>
        [
            'complain' => 'شكوى',
            'suggestions' => 'اقتراحات',
            'inquiries' => 'استعلامات',
        ],

    ],
    'attributes' =>   [
        'description' => 'الوصف',
        'name' => 'الاسم',
        'nationality' => 'الجنسية',
    ],
    'notification' =>   [
        'notification_count' => 'عدد التنبيهات',
        'notification' => 'تنبيه',
        'notifications' => 'التنبيهات',
        'permissions' =>
        [
            'store' => 'ارسال تنبيه',
        ],
    ],
    'chat' =>  [
        'sub_progs' =>
        [
            'index' => 'سجل الدردشات',
            'archive' => 'أرشيف الدردشات',
        ],
        'chats' => 'الدردشات',
    ],
    'static_page' => [

        'validation' => [

            'can_not_be_deleted_has_link' => 'لا يمكن حذف صفحة مرتبطة برابط',
            'can_not_be_deactivated_has_link' => 'لا يمكن تعطيل صفحة مرتبطة برابط',

            'is_active' => [
                'in' => 'حقل الحالة يجب أن يكون بين هذه القيم :values',

            ],
            'show_in_website' => [
                'in' => 'حقل عرض في الموقع يجب أن يكون بين هذه القيم :values',

            ],

            'show_in_app' => [
                'in' => 'حقل عرض في التطبيق يجب أن يكون بين هذه القيم :values',

            ],

            'image' => [
                'mimes' => 'لا يسمح برفع الصورة غير من النوع :values',
                'max' => 'حجم الصورة يجب ألا يزيد عن 1 ميجابايت',

            ],
            'ar' => [
                'name'=> [
                    'required' => 'حقل الاسم  مطلوب',
                    'max' => 'يجب أن يكون حقل الاسم  على الأكثر :max '

                ],
                'description'=> [
                    'required' => 'حقل الوصف  مطلوب',
                    'string' => 'حقل  الوصف يجب أن يكون قيمة نصية'
                ]
            ],
        ],
        'permissions' =>
        [
            'store' => 'حفظ الصفحات الثابتة',
            'index' => 'سجل الصفحات الثابتة',
            'destroy' => 'حذف الصفحات الثابتة',
            'update' => 'تعديل الصفحات الثابتة',
            'show'   => 'عرض الصفحات الثابتة'
        ],
        'static_pages' => 'الصفحات الثابتة',
    ],
    'permission' =>  [
        'sub_progs' =>
        [
            'index' => 'سجل الصلاحيات',
            'archive' => 'أرشيف الصلاحيات',
            'create' => 'إضافة صلاحية',
        ],
        'name' => 'اسم الصلاحية',
        'permissions' => 'الصلاحيات',
    ],
    'active_cases' =>
    [
        0 => 'معطل',
        1 => 'مفعل',
    ],
    'home' =>  [
        'permissions' =>
        [
            'show' => 'عرض',
            'index' => 'الرئيسية',
        ],
        'home' => 'الرئيسية',
    ],
    'bank_branch' =>  [
        'bank_branches' => 'فروع البنوك',
    ],
    'attachment_file' => [
        'attachment_files' => 'العملاء',
    ],

    'vendors' => [
        "iban_number" => [
            "required" => "رقم الايبان مطلوب",
            "starts_with" => "رقم الايبان يجب ان يبدأ ب :starts_with",
            "size" => "رقم الايبان يجب ان يكون :size حرف ورقم",
            "unique" => "رقم الايبان موجود من قبل",
        ],
    ],

    'links' => [
        'mobile' => [
            'register_policy' => 'الشروط والأحكام (تسجيل جديد)',
            'charge_policy' => 'الشروط والأحكام (شحن)',
            'local_transfer_policy' => 'الشروط والأحكام (التحويل المحلي)',
            'global_transfer_policy' => 'الشروط والأحكام (التحويل الدولي)',
            'page1' => 'الصفحة الأولى',
            'page2' => 'الصفحة الثانية',
            'page3' => 'الصفحة الثالثة',
            'page4' => 'الصفحة الرابعة',
            'page5' => 'الصفحة الخامسة',
            'page6' => 'الصفحة السادسة',




        ],

        ],
        'our_app' => [
            'our_apps' => 'تطبيقاتنا',
            'permissions' =>
            [
                'index' => 'السجل',
                'store' => 'حفظ',
                'update' => 'تعديل',
                'destroy' => 'حذف',
                'show' => 'عرض',
            ],
            'show' => 'عرض',
            'sub_progs' =>
            [
                'index' => 'سجل تطبيقاتنا',
                'create' => 'إضافة تطبيق',
                'show' => 'عرض تطبيق',
            ],
            'rasid_job' => 'التطبيق',
            'rasid_job_count' => 'عدد تطبيقاتنا',
            'rasid_jobs' => 'تطبيقاتنا',
            'validation' => [

                'order' => [

                    'numeric' => 'حقل الترتيب  يجب أن يكون قيمة رقمية',
                ],
                'android_link' => [
                    'required' => 'حقل رابط التحميل Android   مطلوب',

                ],
                'ios_link' => [
                    'required' => 'حقل رابط التحميل Ios  مطلوب',

                ],

                'is_active' => [
                    'required' => 'حقل الحالة مطلوب',
                    'in' => 'حقل الحالة يجب أن يكون بين هذه القيم :values',

                ],

                'image' => [
                    'required' => 'حقل صورة التطبيق مطلوب',
                    'image' => 'حقل صورة التطبيق يجب أن يكون صورة',
                    'mimes' => 'حقل صورة التطبيق يجب أن يكون من نوع  :values',
                    'max' => 'يجب أن يكون حقل صورة التطبيق على الأكثر :max ميجا',

                ],
                'ar' => [
                    'name'=> [
                        'required' => 'حقل اسم التطبيق مطلوب',
                        'unique' => 'حقل  اسم التطبيق يجب أن لا يتكرر',
                        'string' => 'حقل اسم التطبيق يجب أن يكون قيمة نصية',
                        'between' => 'حقل اسم التطبيق يجب ان يكون بين :min و :max حرف'
                    ],
                    'description'=> [
                        'string' => 'حقل وصف التطبيق يجب أن يكون قيمة نصية',
                        'max' => 'يجب أن يكون حقل وصف التطبيق على الأكثر :max '
                    ]
                ],
            ]
        ],
];
