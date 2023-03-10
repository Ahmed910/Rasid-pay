<?php
return [
    'dashboard' => [
        'login' => [
            'button' => [
                'login' => 'تسجيل دخول'
            ],
            'fields' => [
                'userID' => 'رقم المستخدم',
                'password' => 'كلمة المرور'
            ],
            'labels' => [
                'userID' => 'رقم المستخدم',
                'password' => 'كلمة المرور',
                'remember' => 'تذكرني',
                'reset_password' => 'إعادة تعيين كلمة المرور'
            ],
            'heading' => [
                'title' => 'تسجيل الدخول',
                'sub_title' => 'من فضلك أدخل رقم المستخدم وكلمة المرور'
            ],
            'placeholder' => [
                'title' => 'تسجيل الدخول',
                'sub_title' => 'من فضلك أدخل رقم المستخدم وكلمة المرور ',
                'enter_userID' => 'أدخل رقم المستخدم الخاص بك',
                'enter_password' => 'أدخل كلمة المرور'
            ],
            'validation' => [
                'validPhoneNumber' => 'يرجى ادخال رقم جوال بصيغة صحيحة ',
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'minLength_number' => '%{attribute} يجب ان لا يقل عن  %{min} ارقام',
                'email' => '%{attribute} غير صحيح رجاء التأكد من الكتابة بطريقة صحيحة',
                'maxValue' => '%{attribute} يجب ان لا تتجاوز %{max}',
                'minValue' => '%{attribute} يجب ان تكون  علي الاقل %{min}',
                'url' => 'هذا الرابط غير صحيح',
                'biggerThan' => '%{attribute} يجب ان تكون  اكبر من  %{biggerThan}',
                'smallerThan' => '%{attribute} يجب ان اقل من %{smallerThan}',
                'startWithSA' => '%{attribute} يجب ان يبدأ ب SA ',
                'validLength' => '%{attribute} يجب ان يكون  %{length} حرف ورقم ',
                'sameAsPassword' => 'كلمة المرور غير متطابقة',
                'hasNumbers' => 'يجب ان تحتوي علي أرقام',
                'hasCapitalLetters' => 'يجب ان تحتوي علي حروف كبيرة',
                'hasLowerLetters' => 'يجب ان تحتوي علي حروف صغيرة',
                'hasSpecialCharacters' => 'يجب ان تحتوي علي علامات خاصة',
                'validLocationInSaudia' => 'يجب ان يكون الموقع بداخل السعودية'
            ]
        ],
        'verification' => [
            'heading' => [
                'title' => 'إعادة تعيين كلمة المرور',
                'sub_title' => 'من فضلك أدخل رقم جوالك أو بريدك الإلكتروني لإرسال رمز التحقق '
            ],
            'labels' => [
                'mobile' => 'رقم الجوال',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال'
            ],
            'placeholder' => [
                'enter_mobile' => 'أدخل رقم  الجوال',
                'enter_email' => 'أدخل البرد الإلكتروني',
                'phone_x' => 'xxxxxxxx',
                'enter_phone' => 'أدخل رقم الجوال'
            ],
            'button' => [
                'send' => 'إرسال',
                'back' => 'عودة '
            ],
            'fields' => [
                'email' => 'البريد الإلكتروني',
                'mobile' => 'رقم الجوال'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف'
            ]
        ],
        'verify_code' => [
            'heading' => [
                'title' => 'رمز التحقق ',
                'sub_title' => 'تم إرسال تحقق برمز تحقق للتو إلى'
            ],
            'labels' => [
                'mobile' => 'رقم الجوال',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال'
            ],
            'placeholder' => [
                'enter_mobile' => 'أدخل رقم  الجوال',
                'enter_email' => 'أدخل البرد الإلكتروني'
            ],
            'button' => [
                'resendCode' => 'إعادة إرسال الرمز مرة أخرى',
                'send' => 'إرسال',
                'back' => 'عودة '
            ],
            'fields' => [
                'email' => 'البريد الإلكتروني',
                'mobile' => 'رقم الجوال'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب'
            ]
        ],
        'reset_password' => [
            'heading' => [
                'title' => 'إعادة تعيين كلمة المرور؟',
                'sub_title' => 'تم إرسال تحقق برمز تحقق للتو إلى'
            ],
            'labels' => [
                'new_password' => 'كلمة المرور الجديدة',
                'password_confirmation' => 'تأكيد كلمة المرور'
            ],
            'placeholder' => [
                'enter_new_password' => 'أدخل كلمة المرور الجديدة',
                'enter_email' => 'أدخل البرد الإلكتروني',
                'enter_password_confirmation' => 'أدخل تأكيد كلمة المرور'
            ],
            'button' => [
                'save' => 'حفظ',
                'back' => 'عودة'
            ],
            'fields' => [
                'new_password' => 'كلمة المرور الجديدة',
                'password_confirmation' => 'تأكيد كلمة المرور',
                'sameAsPassword' => 'كلمة المرور غير متطابقة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'sameAsPassword' => 'كلمة المرور غير متطابقة',
                'hasNumbers' => 'يجب ان تحتوي علي أرقام',
                'hasCapitalLetters' => 'يجب ان تحتوي علي حروف كبيرة',
                'hasLowerLetters' => 'يجب ان تحتوي علي حروف صغيرة',
                'hasSpecialCharacters' => 'يجب ان تحتوي علي علامات خاصة'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟'
                ]
            ]
        ],
        'sidebar' => [
            'home' => 'الرئيسية',
            'departments_management' => 'إدارة الأقسام',
            'control_panel' => 'لوحة التحكم',
            'department_list' => 'قائمة الأقسام',
            'record' => 'السجل',
            'department_record' => 'سجل الأقسام',
            'job_record' => 'سجل الوظائف',
            'departments' => 'الأقسام',
            'add' => 'إضافة',
            'archives' => 'الأرشيف',
            'department_archive' => 'أرشيف الأقسام',
            'jobs' => 'الوظائف',
            'users' => 'المستخدمين',
            'permissions' => 'الصلاحيات',
            'department_record_details' => 'عرض قسم',
            'job_record_details' => 'تفاصيل سجل الوظائف',
            'user_history' => 'سجل المستخدمين',
            'permissionsRecord' => 'سجل الصلاحيات',
            'users_history' => 'سجل المستخدمين',
            'user_view' => 'عرض مستخدم',
            'edit_user' => 'تعديل مستخدم',
            'edit' => 'تعديل',
            'editGroup' => 'تعديل مجموعة',
            'addGroup' => 'إضافة مجموعة',
            'job_view' => 'عرض وظيفة',
            'job_edit' => 'تعديل وظيفة',
            'users_record' => 'سجل المستخدمين',
            'jobs_record' => 'سجل الوظائف',
            'departments_record' => 'سجل الأقسام',
            'permissions_record' => 'سجل الصلاحيات',
            'viewGroup' => 'عرض مجموعة',
            'permission_record' => 'سجل الصلاحيات',
            'vendors' => 'العملاء',
            'vendors_record' => 'سجل العملاء',
            'vendors_record_details' => 'عرض العميل',
            'register_vendor' => 'تسجيل عميل',
            'bank_account' => 'طلبات فتح حساب',
            'add_group' => 'إضافة مجموعة',
            'add_user' => 'إضافة مستخدم',
            'add_department' => 'إضافة قسم',
            'edit_department' => 'تعديل قسم',
            'add_job' => 'إضافة وظيفة',
            'follow_up' => 'المتابعة',
            'activity_log' => 'سجل النشاطات',
            'departments_archive' => 'ارشيف الاقسام',
            'jobs_archives' => 'ارشيف الوظائف',
            'citizens' => 'مستخدمين التطبيق',
            'view_citizen' => 'عرض مستخدم',
            'edit_citizen' => 'تعديل مستخدم',
            'transactions' => 'المعاملات',
            'transaction-list' => 'سجل المعاملات',
            'transactions_record' => 'سجل المعاملات',
            'bank_record' => 'سجل البنوك',
            'banks' => 'البنوك',
            'add_bank' => 'اضافة بنك',
            'edit_bank' => 'تعديل بنك',
            'view_bank' => 'عرض بنك',
            'discount_rates' => 'نسب خصم البطاقات',
            'card_packages_record' => 'سجل نسب خصم البطاقات',
            'add_card_packages' => 'اضافة نسب خصم البطاقات',
            'edit_card_packages' => 'تعديل نسب خصم البطاقات',
            'rasid' => 'رصيد',
            'rasid_pay' => 'رصيد باي',
            'transaction_view' => 'عرض معاملة',
            'login' => 'تسجيل دخول',
            'reset' => 'كلمة المرور',
            'verification-method' => 'إعادة تعيين كلمة المرور',
            'verify-code' => 'كود التفعيل',
            'Page401' => 'خطأ 401',
            'Page404' => 'خطأ 404',
            'view' => 'عرض',
            'job_archive' => 'ارشيف الوظائف',
            'settings' => 'الإعدادات',
            'translations' => 'الترجمات',
            'staticPages' => 'الصفحات الثابتة',
            'links' => 'الروابط',
            'static_page_add' => 'إضافة صفحة',
            'static_page_edit' => 'تعديل صفحة',
            'static_page_record' => 'الصفحات الثابتة',
            'static_page_view' => 'عرض صفحة',
            'appSettings' => 'اعدادات التطبيق',
            'support' => ' الدعم والمساعدة',
            'faq' => 'الأسئلة الشائعة ',
            'faq_add' => 'إضافة سؤال ',
            'faq_edit' => 'إضافة سؤال ',
            'faq_view' => 'عرض سؤال',
            'messages' => 'صندوق الرسائل ',
            'messages_edit' => 'الرد علي الرسالة ',
            'messages_add' => 'إضافة رسالة',
            'messages_view' => 'عرض رسالة',
            'transferPurpose' => 'الغرض من الحوالة ',
            'transferPurpose_add' => 'إضافة الغرض من الحوالة ',
            'transferPurpose_edit' => 'تعديل الغرض من الحوالة ',
            'transferPurpose_view' => 'عرض الغرض من الحوالة ',
            'messageTypes' => 'نوع الرسائل',
            'logout' => 'تسجيل خروج',
            'messageTypes_edit' => 'تعديل نوع الرسالة',
            'messageTypes_record' => 'سجل نوع الرسائل',
            'messageTypes_add' => 'اضافة نوع الرسالة',
            'messageTypes_view' => 'عرض نوع الرسالة',
            'edit_vendor' => 'تعديل عميل',
            'add_vendor' => 'إضافة عميل',
            'view_vendor' => 'عرض عميل',
            'branches' => 'سجل الفروع',
            'branches_record' => 'سجل الفروع',
            'edit_branch' => 'تعديل فرع',
            'add_branch' => 'إضافة فرع',
            'view_branch' => 'عرض فرع',
            'ourApps' => 'تطبيقاتنا',
            'ourApps_add' => 'إضافة تطبيق',
            'ourApps_edit' => 'تعديل تطبيق',
            'ourApps_view' => 'عرض تطبيق',
            'staticPages_edit' => 'تعديل الصفحة الثابتة',
            'staticPages_view' => 'عرض الصفحة الثابتة',
            'staticPages_add' => 'إضافة الصفحة الثابتة',
            'profile' => 'الملف الشخصي'
        ],
        'home' => [
            'statistics' => 'الإحصائيات',
            'cards' => [
                'archived_departments' => 'الأقسام المؤرشفة ',
                'departments' => 'الأقسام',
                'active_jobs' => 'الوظائف المفعلة',
                'unactive_jobs' => 'الوظائف المعطلة',
                'vacant_jobs' => 'الوظائف الشاغرة',
                'unvacant_jobs' => 'الوظائف المشغولة',
                'active_users' => 'المستخدمين المفعلين',
                'temporary_banned_users' => 'المتسخدمين المعطلين لفترة',
                'permanent_banned_users' => 'المستخدمين المعطلين دائما',
                'employees' => 'العملاء',
                'active_citizens' => 'مستخدمين التطبيق المفعلين'
            ]
        ],
        'footer' => [
            'all_rights' => 'جميع الحقوق محفوظة الفنتك للتكنولوجيا والمعلومات'
        ],
        'users' => [
            'table' => [
                '#' => '#',
                'user_number' => 'رقم المستخدم',
                'user_name' => 'اسم المستخدم',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال',
                'department' => 'القسم',
                'create_date' => 'تاريخ الإنشاء',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'by_employee' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity' => 'النشاط',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'مستخدم'
                ]
            ],
            'buttons' => [
                'add' => 'إضافة مستخدم',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'edit' => 'تعديل',
                'back' => 'عودة',
                'save' => 'حفظ'
            ],
            'fields' => [
                'name' => 'الاسم',
                'department_name' => 'اسم القسم',
                'job_name' => 'اسم الوظيفة',
                'user_number' => 'رقم المستخدم',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال',
                'permission_list' => 'صلاحيات النظام',
                'status' => 'الحالة',
                'password' => 'كلمة المرور',
                'confirm_password' => 'تأكيد كلمة المرور',
                'ban_from' => 'تاريخ من',
                'ban_to' => 'تاريخ إلي'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'email' => '%{attribute} غير صحيح رجاء التأكد من الكتابة بطريقة صحيحة',
                'minLength_number' => '%{attribute} يجب ان لا يقل عن  %{min} ارقام',
                'noJobDepartment' => 'لا يوجد وظائف لهذا القسم'
            ],
            'placeholder' => [
                'enter_name' => 'أدخل اسم المستخدم',
                'enter_number' => 'أدخل الرقم',
                'enter_email' => 'أدخل البريد الإلكتروني',
                'choose_department' => 'أختر القسم',
                'select_date' => 'يوم/شهر/سنة',
                'select_status' => 'أختر الحالة',
                'select_job_name' => 'أختر الوظيفة',
                'enter_phone' => 'أدخل رقم الجوال',
                'select_permissions' => 'اختر الصلاحيات',
                'enter_password' => 'أدخل كلمة المرور',
                'enter_confirmation_password' => 'أدخل تأكيد كلمة المرور',
                'phone_x' => 'xxxxxxxx'
            ],
            'labels' => [
                'user_name' => 'اسم المستخدم',
                'user_number' => 'رقم المستخدم',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال',
                'department' => 'القسم',
                'creating_date' => 'تاريخ الإنشاء (من)',
                'end_date' => 'تاريخ الإنشاء (إلى)',
                'status' => 'الحالة',
                'period_from' => 'فترة (من)',
                'period_to' => 'فترة (إلى)',
                'from' => 'من',
                'to' => 'إلى',
                'job' => 'الوظيفة',
                'job_name' => 'اسم الوظيفة',
                'system_permissions' => 'صلاحيات النظام',
                'password' => 'كلمة المرور',
                'confirm_password' => 'تأكيد كلمة المرور',
                'check_password' => 'كلمة المرور',
                'send_activity_code' => 'إرسال رمز التحقق'
            ],
            'tooltip' => [
                'edit' => 'تعديل',
                'view_details' => 'عرض',
                'Groups' => 'مجموعة صلاحيات'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'selected_permissions' => 'الصلاحيات المختارة',
                'historical_movment' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'permanent' => 'معطل دائم',
                'temporary' => 'معطل لفترة',
                'deactivated' => 'تعطيل',
                'activated' => 'تفعيل',
                'archive' => 'أرشيف',
                'edit' => 'تعديل',
                'add' => 'إضافة',
                'inActive' => 'معطل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'restored' => 'استعادة'
            ],
            'breadcrumb' => [
                'users' => 'المستخدمين',
                'user_history' => 'سجل المستخدمين',
                'add_user' => 'إضافة مستخدم',
                'edit_user' => 'تعديل مستخدم',
                'user_view' => 'عرض مستخدم'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'permanent disable' => 'معطل دائم',
                'Temporary Disable' => 'معطل لفترة',
                'without_department' => 'بدون قسم',
                'no_data' => 'لا توجد نتائج متاحة'
            ]
        ],
        'archives' => [
            'breadcrumb' => [
                'archive' => 'الأرشيف'
            ],
            'departments' => [
                'table' => [
                    '#' => '#',
                    'department_name' => 'اسم القسم',
                    'main_department' => 'القسم الرئيسي',
                    'archive_date' => 'تاريخ الأرشفة',
                    'status' => 'الحالة',
                    'actions' => 'العمليات',
                    'no_data' => ' لا توجد نتائج متاحة',
                    'activity_details' => 'تفاصيل النشاط',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'قسم'
                    ]
                ],
                'buttons' => [
                    'export' => 'تصدير',
                    'reset' => 'عرض الكل',
                    'search' => 'بحث'
                ],
                'placeholder' => [
                    'enter_name' => 'أدخل الاسم',
                    'select_main_department' => 'اختر القسم الرئيسي',
                    'select_date' => 'يوم/شهر/سنة',
                    'select_status' => 'أختر الحالة'
                ],
                'labels' => [
                    'department_name' => 'اسم القسم',
                    'main_department' => 'القسم الرئيسي',
                    'archive_date_from' => 'تاريخ الأرشفة (من)',
                    'archive_date_to' => 'تاريخ الأرشفة (إلي)',
                    'status' => 'الحالة'
                ],
                'tooltip' => [
                    'view_details' => 'عرض',
                    'restore' => 'استعادة',
                    'force_delete' => 'حذف'
                ],
                'popup' => [
                    'buttons' => [
                        'accept' => 'موافق',
                        'refuse' => 'غير موافق'
                    ],
                    'body' => [
                        'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                        'restore' => 'هل تريد اتمام عملية الأستعادة؟'
                    ],
                    'reasonLabel' => 'الرجاء ذكر السبب',
                    'reasonValidation' => 'السبب'
                ],
                'chips' => [
                    'active' => 'مفعل',
                    'inactive' => 'معطل',
                    'inActive' => 'معطل',
                    'edit' => 'تعديل',
                    'actived' => 'تفعيل',
                    'deactive' => 'تعطيل',
                    'add' => 'إضافة',
                    'archive' => 'أرشفة',
                    'restored' => 'استعادة'
                ],
                'breadcrumb' => [
                    'department_archive' => 'أرشيف الأقسام'
                ],
                'statusOptions' => [
                    'all' => 'الجميع',
                    'active' => 'مفعل',
                    'inactive' => 'معطل',
                    'without_main_department' => 'بدون قسم رئيسي'
                ]
            ],
            'jobs' => [
                'table' => [
                    '#' => '#',
                    'job_name' => 'اسم الوظيفة',
                    'department' => 'القسم',
                    'archive_date' => 'تاريخ الأرشفة',
                    'status' => 'الحالة',
                    'actions' => 'العمليات',
                    'no_data' => ' لا توجد نتائج متاحة',
                    'activity_details' => 'تفاصيل النشاط',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'وظيفة'
                    ]
                ],
                'buttons' => [
                    'export' => 'تصدير',
                    'reset' => 'عرض الكل',
                    'search' => 'بحث'
                ],
                'placeholder' => [
                    'enter_name' => 'أدخل الاسم',
                    'choose_department' => 'اختر القسم',
                    'select_date' => 'يوم/شهر/سنة',
                    'select_status' => 'أختر الحالة'
                ],
                'labels' => [
                    'job_name' => 'اسم الوظيفة',
                    'department' => 'القسم',
                    'archive_date_from' => 'تاريخ الأرشفة (من)',
                    'archive_date_to' => 'تاريخ الأرشفة (إلي)',
                    'status' => 'الحالة'
                ],
                'tooltip' => [
                    'view_details' => 'عرض',
                    'restore' => 'استعادة',
                    'force_delete' => 'حذف'
                ],
                'popup' => [
                    'buttons' => [
                        'accept' => 'موافق',
                        'refuse' => 'غير موافق'
                    ],
                    'body' => [
                        'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                        'restore' => 'هل تريد اتمام عملية الأستعادة؟'
                    ],
                    'reasonLabel' => 'الرجاء ذكر السبب',
                    'reasonValidation' => 'السبب'
                ],
                'chips' => [
                    'active_f' => 'مفعلة',
                    'in_active_f' => 'معطلة',
                    'active' => 'مفعل',
                    'inActive' => 'معطل',
                    'edit' => 'تعديل',
                    'actived' => 'تفعيل',
                    'deactive' => 'تعطيل',
                    'add' => 'إضافة',
                    'archive' => 'أرشفة',
                    'restored' => 'استعادة'
                ],
                'breadcrumb' => [
                    'jobs_archives' => 'أرشيف الوظائف'
                ],
                'statusOptions' => [
                    'all' => 'الجميع',
                    'active_f' => 'مفعلة',
                    'in_active_f' => 'معطلة'
                ]
            ]
        ],
        'follow_up' => [
            'table' => [
                '#' => '#',
                'employee' => 'الموظف',
                'department' => 'القسم',
                'main_program' => 'البرنامج الرئيسي',
                'sub_program' => 'البرنامج الفرعي',
                'date_time' => 'تاريخ/وقت',
                'ip' => 'رقم معرف الجهاز',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'متابعة'
                ]
            ],
            'buttons' => [
                'print_report' => 'طباعة تقرير',
                'reset' => 'عرض الكل',
                'search' => 'بحث'
            ],
            'placeholder' => [
                'select_activity_name' => 'أدخل الاسم',
                'choose_department' => 'اختر القسم',
                'choose_employee_name' => 'اختر اسم الموظف',
                'choose_main_program' => 'اختر البرنامج الرئيسي',
                'choose_sub_program' => 'اختر البرنامج الفرعي',
                'select_date' => 'يوم/شهر/سنة',
                'select_status' => 'أختر الحالة'
            ],
            'labels' => [
                'activity_name' => 'اسم النشاط',
                'department' => 'القسم',
                'employee' => 'الموظف',
                'main_program' => 'البرنامج الرئيسي',
                'sub_program' => 'البرنامج الفرعي',
                'creating_date' => 'تاريخ الإنشاء (من)',
                'end_date' => 'تاريخ الإنشاء (إلى)',
                'status' => 'الحالة',
                'activity_details' => 'سجل النشاطات'
            ],
            'tooltip' => [
                'view_details' => 'عرض'
            ],
            'chips' => [
                'created' => 'إضافة',
                'updated' => 'تعديل',
                'destroy' => 'أرشفة',
                'permanent_delete' => 'حذف نهائي',
                'restored' => 'استعادة',
                'searched' => 'مبحوث',
                'deactivated' => 'تعطيل',
                'activated' => 'تفعيل',
                'permanent' => 'تعطيل دائم',
                'temporary' => 'تعطيل مؤقت',
                'assigned' => 'تم الإحالة',
                'replied' => 'تم الرد ',
                'delete' => 'حذف',
                'shown' => 'تم الإطلاع'
            ],
            'breadcrumb' => [
                'follow_up' => 'المتابعة',
                'activity_log' => 'سجل النشاطات'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'inactive' => 'معطل',
                'without_main_department' => 'بدون قسم رئيسي'
            ],
            'events' => [
                'created' => 'إضافة',
                'updated' => 'تعديل',
                'destroy' => 'أرشفة',
                'permanent_delete' => 'حذف نهائي',
                'restored' => 'استعادة',
                'searched' => 'مبحوث',
                'deactivated' => 'تعطيل',
                'activated' => 'تفعيل',
                'permanent' => 'تعطيل دائم',
                'temporary' => 'تعطيل مؤقت',
                'all' => 'الجميع',
                'assigned' => 'تم الإحالة',
                'replied' => 'تم الرد ',
                'delete' => 'حذف'
            ]
        ],
        'settings' => [
            'translations' => [
                'table' => [
                    '#' => '#',
                    'keyword' => 'المفتاح',
                    'arabic_lang' => 'اللغة العربية',
                    'no_data' => ' لا توجد نتائج متاحة',
                    'activity_details' => 'تفاصيل النشاط',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'الإجمالي'
                    ]
                ],
                'buttons' => [
                    'export' => 'تصدير',
                    'reset' => 'عرض الكل',
                    'search' => 'بحث'
                ],
                'placeholder' => [
                    'enter_keyword' => 'أدخل المفتاح',
                    'enter_arabic_lang' => 'أدخل اللغة العربية'
                ],
                'labels' => [
                    'keyword' => 'المفتاح',
                    'arabic_lang' => 'اللغة العربية'
                ],
                'breadcrumb' => [
                    'settings' => 'الإعدادات',
                    'translations' => 'الترجمات'
                ]
            ]
        ],
        'faq' => [
            'table' => [
                '#' => '#',
                'question' => 'السؤال',
                'order' => 'الترتيب',
                'page_status' => 'الحالة',
                'actions' => 'العمليات',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'without_department' => 'بدون قسم',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'أسئلة'
                ]
            ],
            'buttons' => [
                'add_faq' => 'أضف سؤال',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'edit' => 'تعديل',
                'back' => 'عودة',
                'save' => 'حفظ'
            ],
            'fields' => [
                'question' => 'السؤال',
                'order' => 'الترتيب',
                'status' => 'الحالة',
                'answer' => 'الإجابة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'minLength_number' => '%{attribute} يجب ان لا يقل عن  %{min} ارقام'
            ],
            'placeholder' => [
                'enter_question' => 'أدخل السؤال',
                'select_status' => 'اختر الحالة',
                'enter_question_number' => 'أدخل ترتيب الظهور',
                'enter_answer' => 'أدخل الإجابة'
            ],
            'labels' => [
                'question' => 'السؤال',
                'status' => 'الحالة',
                'question_number' => 'ترتيب الظهور',
                'answer' => 'الإجابة',
                'chooseStatus' => 'اختر الحالة'
            ],
            'tooltip' => [
                'edit' => 'تعديل',
                'view_details' => 'عرض',
                'force_delete' => 'حذف'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'historical_movment' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'permanent' => 'معطل دائم',
                'temporary' => 'معطل لفترة',
                'deactivated' => 'تعطيل',
                'inactive' => 'معطل',
                'activated' => 'تفعيل',
                'archive' => 'أرشيف',
                'edit' => 'تعديل',
                'add' => 'إضافة',
                'inActive' => 'معطل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'restored' => 'استعادة'
            ],
            'breadcrumb' => [
                'support' => 'الدعم والمساعدة',
                'faq' => 'الأسئلة الشائعة',
                'faqs_view' => 'عرض السؤال',
                'editQuestion' => 'تعديل السؤال',
                'createQuestion' => 'اضافة سؤال'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'inactive' => 'معطل'
            ],
            'historical_movment' => [
                'table' => [
                    '#' => '#',
                    'addedBy' => 'تم بواسطة',
                    'department_name' => 'اسم القسم',
                    'activity_date' => 'تاريخ النشاط',
                    'activity_name' => 'النشاط',
                    'activity_reason' => 'السبب',
                    'no_data' => ' لا توجد نتائج متاحة',
                    'activity_details' => 'تفاصيل النشاط',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'الإجمالي'
                    ]
                ]
            ]
        ],
        'transferPurpose' => [
            'table' => [
                '#' => '#',
                'purpose' => 'الغرض من الحوالة',
                'order' => 'الترتيب',
                'page_status' => 'الحالة',
                'actions' => 'العمليات',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'غرض'
                ]
            ],
            'buttons' => [
                'add_transferPurpose' => 'أضف غرض حوالة',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'edit' => 'تعديل',
                'back' => 'عودة',
                'save' => 'حفظ'
            ],
            'fields' => [
                'name' => 'الغرض من الحوالة',
                'status' => 'الحالة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'minLength_number' => '%{attribute} يجب ان لا يقل عن  %{min} ارقام'
            ],
            'placeholder' => [
                'enter_purpose' => 'أدخل الغرض من الحوالة',
                'select_status' => 'أختر الحالة',
                'enter_purpose_number' => 'أدخل ترتيب الظهور',
                'enter_answer' => 'أدخل الإجابة'
            ],
            'labels' => [
                'purpose' => 'الغرض من الحوالة',
                'status' => 'الحالة',
                'defaultValue' => 'القيمة الإفتراضية',
                'chooseStatus' => 'اختر الحالة'
            ],
            'tooltip' => [
                'edit' => 'تعديل',
                'view_details' => 'عرض',
                'force_delete' => 'حذف'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'historical_movment' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'inactive' => 'معطل',
                'inActive' => 'معطلة',
                'vacant' => 'شاغرة',
                'occupied' => 'مشغولة',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ],
            'breadcrumb' => [
                'record' => 'إعدادات التطبيق',
                'transferPurpose' => 'الغرض من الحوالة',
                'transferPurpose_view' => 'عرض الغرض من الحوالة',
                'editpurpose' => 'تعديل الغرض من الحوالة',
                'createpurpose' => 'اضافة الغرض من الحوالة'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'inactive' => 'معطل',
                'without_department' => 'بدون قسم'
            ],
            'historical_movment' => [
                'table' => [
                    '#' => '#',
                    'addedBy' => 'تم بواسطة',
                    'department_name' => 'اسم القسم',
                    'activity_date' => 'تاريخ النشاط',
                    'activity_name' => 'النشاط',
                    'activity_reason' => 'السبب',
                    'no_data' => 'لا يوجد بيانات',
                    'activity_details' => 'تفاصيل النشاط',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'الإجمالي'
                    ]
                ]
            ]
        ],
        'ourApps' => [
            'breadcrumb' => [
                'record' => 'اعدادات التطبيق',
                'ourApps' => 'تطبيقاتنا',
                'ourApps_record' => 'سجل تطبيقاتنا',
                'ourApps_edit' => 'تعديل تطبيق',
                'ourApps_add' => 'إضافة تطبيق',
                'ourApps_view' => 'عرض التطبيق'
            ],
            'table' => [
                '#' => '#',
                'app_name' => 'اسم التطبيق',
                'create_date' => 'تاريخ الإنشاء',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'activity_reason' => 'السبب',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'قسم'
                ]
            ],
            'buttons' => [
                'add_ourApps' => 'إضافة تطبيق',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'status' => 'الحالة',
                'name' => 'الاسم',
                'description' => 'الوصف',
                'order' => 'الترتيب',
                'android_link' => 'رابط تحميل الاندرويد',
                'ios_link' => 'رابط تحميل أبل'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف',
                'url' => 'هذا الرابط غير صحيح'
            ],
            'placeholder' => [
                'enter_app_name' => 'أدخل الاسم',
                'select_date' => 'يوم/شهر/سنة',
                'select_status' => 'اختر الحالة',
                'add_description' => 'أدخل الوصف',
                'chooseStatus' => 'اختر الحالة',
                'enter_order' => 'ادخل الترتيب',
                'enter_android_link' => 'ادخل رابط الأندرويد',
                'enter_ios_link' => 'ادخل رابط آبل'
            ],
            'labels' => [
                'app_name' => 'اسم التطبيق',
                'creating_date' => 'تاريخ الإنشاء (من)',
                'end_date' => 'تاريخ الإنشاء (إلى)',
                'status' => 'الحالة',
                'app_image' => 'صورة التطبيق',
                'description' => 'الوصف',
                'drag_image' => 'اسحب  واسقط أو قم برفع الصورة',
                'chooseStatus' => 'اختر الحالة',
                'all' => 'الجميع',
                'active' => 'مفعل',
                'inactive' => 'معطل',
                'order' => 'الترتيب',
                'android_link' => 'رابط تحميل الأندرويد',
                'ios_link' => 'رابط تحميل آبل'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                    'cant_archive_ourApps_has_job' => 'لا يمكن أرشفة قسم مرتبط بوظائف'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'historical_movment' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'inactive' => 'معطل',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'inactive' => 'معطل'
            ],
            'historical_movment' => [
                'table' => [
                    '#' => '#',
                    'addedBy' => 'تم بواسطة',
                    'department_name' => 'اسم القسم',
                    'activity_date' => 'تاريخ النشاط',
                    'activity_name' => 'النشاط',
                    'activity_reason' => 'السبب',
                    'no_data' => ' لا توجد نتائج متاحة',
                    'activity_details' => 'تفاصيل النشاط',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'الإجمالي'
                    ]
                ]
            ]
        ],
        'departments' => [
            'breadcrumb' => [
                'departments' => 'الأقسام',
                'department_record' => 'سجل الأقسام',
                'editDepartment' => 'تعديل قسم',
                'createDepartment' => 'إضافة قسم',
                'department_record_details' => 'عرض قسم'
            ],
            'table' => [
                '#' => '#',
                'department_name' => 'اسم القسم',
                'main_department' => 'القسم الرئيسي',
                'create_date' => 'تاريخ الإنشاء',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'activity_reason' => 'السبب',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'قسم'
                ]
            ],
            'buttons' => [
                'add' => 'إضافة قسم',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'status' => 'الحالة',
                'name' => 'الاسم',
                'description' => 'الوصف'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف'
            ],
            'placeholder' => [
                'enter_name' => 'أدخل الاسم',
                'select_main_department' => 'اختر القسم الرئيسي',
                'select_date' => 'يوم/شهر/سنة',
                'select_status' => 'اختر الحالة',
                'add_description' => 'أدخل الوصف',
                'chooseStatus' => 'اختر الحالة'
            ],
            'labels' => [
                'department_name' => 'اسم القسم',
                'main_department' => 'القسم الرئيسي',
                'creating_date' => 'تاريخ الإنشاء (من)',
                'end_date' => 'تاريخ الإنشاء (إلى)',
                'status' => 'الحالة',
                'depatmentimage' => 'صورة القسم',
                'description' => 'الوصف',
                'drag_image' => 'اسحب  واسقط أو قم برفع الصورة',
                'chooseStatus' => 'اختر الحالة'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'is_active' => 'مفعل',
                'un_active' => 'معطل',
                'without_main_department' => 'بدون قسم رئيسي',
                'without_department' => 'بدون قسم',
                'without_description' => 'بدون وصف'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                    'cant_archive_department_has_job' => 'لا يمكن أرشفة قسم مرتبط بوظائف'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'inActive' => 'معطل',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ]
        ],
        'permissions' => [
            'breadcrumb' => [
                'permissions' => 'الصلاحيات',
                'permissions_record' => 'سجل الصلاحيات',
                'editGroup' => 'تعديل مجموعة',
                'addGroup' => 'إضافة مجموعة',
                'viewGroup' => 'عرض مجموعة'
            ],
            'table' => [
                '#' => '#',
                'group_name' => 'اسم المجموعة',
                'users_number' => 'عدد المستخدمين',
                'created_at' => 'تاريخ الإنشاء',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'main_prog' => 'البرنامج الرئيسي',
                'sub_prog' => 'البرنامج الفرعي',
                'permission_name' => 'اسم الصلاحية',
                'addedBy' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'مجموعة'
                ]
            ],
            'buttons' => [
                'add' => 'إضافة مجموعة',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'group_name' => 'اسم المجموعة',
                'status' => 'الحالة',
                'permissions_list' => 'صلاحيات النظام'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن x %{min} حرف'
            ],
            'placeholder' => [
                'enter_name' => 'أدخل الاسم',
                'from' => 'من',
                'to' => 'إلى',
                'chooseStatus' => 'اختر الحالة',
                'select_permissions' => 'اختر الصلاحيات'
            ],
            'labels' => [
                'group_name' => 'اسم المجموعة',
                'permission_user_from' => 'عدد المستخدمين (من)',
                'permission_user_to' => 'عدد المستخدمين (إلى)',
                'status' => 'الحالة',
                'system_permissions' => 'صلاحيات النظام',
                'user_status' => 'الحالة',
                'groupManger' => 'منشئ المجموعة'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'selectAll' => ' اختر الكل',
                'is_active' => 'مفعلة',
                'un_active' => 'معطلة',
                'without_department' => 'بدون قسم'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                    'cant_archive_department_has_job' => 'لا يمكن أرشفة قسم مرتبط بوظائف'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية',
                'groupData' => 'بيانات المجموعة'
            ],
            'chips' => [
                'active' => 'مفعلة',
                'inActive' => 'معطلة',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ],
            'groupDataTablePagination' => [
                'show' => 'عرض',
                'to' => 'إلى',
                'of' => 'من',
                'result' => 'الإجمالي'
            ],
            'historyTablePagination' => [
                'show' => 'عرض',
                'to' => 'إلى',
                'of' => 'من',
                'result' => 'الإجمالي'
            ]
        ],
        'jobs' => [
            'breadcrumb' => [
                'jobs' => 'الوظائف',
                'job_record' => 'سجل الوظائف',
                'editJob' => 'تعديل وظيفة',
                'createJob' => 'إضافة وظيفة',
                'job_view' => 'عرض وظيفة'
            ],
            'table' => [
                '#' => '#',
                'job_name' => 'اسم الوظيفة',
                'department' => 'القسم',
                'create_date' => 'تاريخ الإنشاء',
                'status' => 'الحالة',
                'type' => 'النوع',
                'actions' => 'العمليات',
                'by_employee' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity' => 'النشاط',
                'reason' => 'السبب',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'وظيفة'
                ]
            ],
            'buttons' => [
                'add' => 'إضافة وظيفة',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'name' => 'الاسم',
                'job_description' => 'الوصف الوظيفي',
                'department' => 'القسم',
                'status' => 'الحالة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف'
            ],
            'placeholder' => [
                'enter_name' => 'أدخل الاسم',
                'choose_department' => 'اختر القسم',
                'select_date' => 'يوم/شهر/سنة',
                'choose_status' => 'اختر الحالة',
                'choose_type' => 'اختر النوع',
                'enter_description' => 'أدخل الوصف'
            ],
            'labels' => [
                'job_name' => 'اسم الوظيفة',
                'department' => 'القسم',
                'creating_date' => 'تاريخ الإنشاء (من)',
                'end_date' => 'تاريخ الإنشاء (إلى)',
                'status' => 'الحالة',
                'type' => 'النوع',
                'job_description' => 'الوصف الوظيفي',
                'employee_name' => 'الموظف المسئول',
                'employee' => 'الموظف'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'is_active' => 'مفعلة',
                'un_active' => 'معطلة',
                'vacant' => 'شاغرة',
                'occupied' => 'مشغولة',
                'without_main_department' => 'بدون قسم رئيسي',
                'without_department' => 'بدون قسم'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                    'unarchive_job' => 'لا يمكن ارشفة وظيفة مشغولة'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعلة',
                'inActive' => 'معطلة',
                'vacant' => 'شاغرة',
                'occupied' => 'مشغولة',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ]
        ],
        'banks' => [
            'breadcrumb' => [
                'banks' => 'البنوك',
                'bank_record' => 'سجل البنوك',
                'edit_bank' => 'تعديل بنك',
                'add_bank' => 'إضافة بنك',
                'bank_view' => 'عرض بنك'
            ],
            'table' => [
                '#' => '#',
                'name_of_bank' => 'اسم البنك',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'activity_details' => 'تفاصيل النشاط',
                'no_data' => ' لا توجد نتائج متاحة',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'بنك'
                ]
            ],
            'buttons' => [
                'add' => 'إضافة بنك',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'bank_name' => 'اسم البنك',
                'status' => 'الحالة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف'
            ],
            'placeholder' => [
                'enter_bank_name' => 'أدخل اسم البنك',
                'choose_status' => 'اختر الحالة'
            ],
            'labels' => [
                'bank_name' => 'اسم البنك',
                'status' => 'الحالة',
                'chooseStatus' => 'اختر الحالة',
                'image' => 'صورة',
                'drag_image' => 'اسحب  واسقط أو قم برفع الصورة'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'is_active' => 'مفعل',
                'un_active' => 'معطل',
                'without' => 'بدون'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'inActive' => 'معطل',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ]
        ],
        'appStaticPages' => [
            'breadcrumb' => [
                'settings' => 'إعدادات التطبيق',
                'staticPages' => 'الصفحات الثابتة',
                'static_page_edit' => 'تعديل صفحة',
                'static_page_add' => 'إضافة صفحة',
                'static_page_view' => 'عرض صفحة'
            ],
            'table' => [
                '#' => '#',
                'page_name' => 'اسم الصفحة',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'activity_reason' => 'السبب',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'صفحة'
                ]
            ],
            'buttons' => [
                'add' => 'إضافة صفحة',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'page_name' => 'اسم الصفحة',
                'status' => 'الحالة',
                'description' => 'محتوي الصفحة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف'
            ],
            'placeholder' => [
                'enter_page_name' => 'أدخل اسم صفحة',
                'choose_status' => 'اختر الحالة'
            ],
            'labels' => [
                'page_name' => 'اسم الصفحة',
                'page_status' => 'الحالة',
                'page_description' => 'محتوي الصفحة',
                'chooseStatus' => 'اختر الحالة',
                'image' => 'صورة',
                'drag_image' => 'اسحب  واسقط أو قم برفع الصورة',
                'status' => 'الحالة',
                'show_options' => 'اختيارات الظهور',
                'show_in_app' => 'يعرض في التطبيق',
                'show_in_website' => 'يعرض في الموقع'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'is_active' => 'مفعلة',
                'un_active' => 'معطلة',
                'without' => 'بدون',
                'without_department' => 'بدون قسم'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                    'force_delete' => 'هل تريد اتمام عملية الحذف النهائي؟',
                    'page_has_link' => 'لا يمكن حذف صفحة مرتبطة برابط'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعلة',
                'inActive' => 'معطلة',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ]
        ],
        'vendors' => [
            'breadcrumb' => [
                'vendors' => 'العملاء',
                'vendors_record' => 'سجل العملاء',
                'edit_vendor' => 'تعديل عميل',
                'add_vendor' => 'إضافة عميل',
                'view_vendor' => 'عرض عميل'
            ],
            'table' => [
                '#' => '#',
                'vendor_name' => 'اسم العميل',
                'vendor_type' => 'نوع العميل',
                'commercial_register' => 'السجل التجاري',
                'tax_record' => 'الرقم الضريبي',
                'branches_record' => 'سجل الفروع',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'activity_details' => 'تفاصيل النشاط',
                'no_data' => ' لا توجد نتائج متاحة',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'الإجمالي'
                ]
            ],
            'cards' => [
                'map' => 'إحداثيات الموقع'
            ],
            'buttons' => [
                'add' => 'إضافة عميل',
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'close' => 'إغلاق',
                'back' => 'عودة',
                'save' => 'حفظ',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'vendor_type' => 'نوع العميل',
                'vendor_name' => 'اسم العميل',
                'commercial_register' => 'السجل التجاري',
                'tax_record' => 'الرقم الضريبي',
                'account_number' => 'رقم الحساب',
                'logo_image' => 'الشعار',
                'commercial_register_image' => 'إثبات السجل التجاري',
                'country_code' => 'كود الدولة',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال',
                'status' => 'الحالة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف',
                'startWithSA' => '%{attribute} يجب ان يبدأ ب SA ',
                'validLength' => '%{attribute} يجب ان يكون  %{length} حرف ورقم '
            ],
            'placeholder' => [
                'choosevendor' => 'إختر العميل',
                'enter_name' => 'أدخل الاسم',
                'chooseStatus' => 'اختر الحالة',
                'commercial_register' => 'أدخل السجل التجاري',
                'tax_record' => 'أدخل الرقم الضريبي',
                'email' => 'أدخل البريد الإلكتروني',
                'phone_x' => 'xxxxxxxx',
                'enter_phone' => 'أدخل رقم الجوال'
            ],
            'labels' => [
                'vendor_type' => 'نوع العميل',
                'vendor_name' => 'اسم العميل',
                'status' => 'الحالة',
                'commercial_register' => 'السجل التجاري',
                'tax_record' => 'الرقم الضريبي',
                'account_number' => 'رقم الحساب',
                'logo_image' => 'الشعار',
                'commercial_register_image' => 'إثبات السجل التجاري',
                'tax_record_image' => 'إثبات الرقم الضريبي',
                'image' => 'صورة',
                'drag_image' => 'اسحب  واسقط أو قم برفع الصورة',
                'support_checkbox' => 'يدعم رصيد معاك',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال',
                'logoImage' => 'الشعار مطلوب',
                'commercialImage' => 'إثبات السجل التجاري مطلوب',
                'taxImage' => 'إثبات الرقم الضريبي مطلوب',
                'lat' => 'خط طول',
                'lng' => 'خط عرض',
                'fullAddress' => 'العنوان بالتفصيل',
                'location' => 'الموقع'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'is_active' => 'مفعل',
                'un_active' => 'معطل',
                'without' => 'بدون',
                'without_department' => 'بدون قسم'
            ],
            'vendorTypes' => [
                'company' => 'شركات',
                'institution' => 'مؤسسة',
                'member' => 'عضو',
                'freelance_doc' => 'مستقل',
                'famous' => 'مشهور',
                'other' => 'أخري'
            ],
            'tooltip' => [
                'archive' => 'أرشفة',
                'edit' => 'تعديل',
                'view_details' => 'عرض ',
                'messages' => 'الرسائل',
                'Settings' => 'الإعدادات',
                'logout' => 'تسجيل خروج',
                'confirm_account' => 'تأكيد الحساب',
                'confirmed_account' => 'الحساب مؤكد',
                'hang_account' => 'تعليق الحساب',
                'restore' => 'استعادة',
                'force_delete' => 'حذف '
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'chips' => [
                'active' => 'مفعل',
                'inActive' => 'معطل',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة'
            ],
            'branches' => [
                'breadcrumb' => [
                    'branches' => 'العملاء',
                    'branches_record' => 'سجل الفروع',
                    'edit_branch' => 'تعديل فرع',
                    'add_branch' => 'إضافة فرع',
                    'view_branch' => 'عرض فرع'
                ],
                'table' => [
                    '#' => '#',
                    'vendor_name' => 'اسم العميل',
                    'branch_name' => 'اسم الفرع',
                    'status' => 'الحالة',
                    'phone' => 'رقم الجوال',
                    'actions' => 'العمليات',
                    'addedBy' => 'تم بواسطة',
                    'department_name' => 'اسم القسم',
                    'activity_date' => 'تاريخ النشاط',
                    'activity_name' => 'النشاط',
                    'activity_details' => 'تفاصيل النشاط',
                    'no_data' => ' لا توجد نتائج متاحة',
                    'pagination' => [
                        'show' => 'عرض',
                        'to' => 'إلى',
                        'of' => 'من',
                        'result' => 'الإجمالي'
                    ]
                ],
                'buttons' => [
                    'add' => 'إضافة فرع',
                    'export' => 'تصدير',
                    'reset' => 'عرض الكل',
                    'search' => 'بحث',
                    'close' => 'إغلاق',
                    'back' => 'عودة',
                    'save' => 'حفظ',
                    'edit' => 'تعديل'
                ],
                'fields' => [
                    'vendor_name' => 'اسم العميل',
                    'branch_name' => 'اسم الفرع',
                    'country_code' => 'كود الدولة',
                    'email' => 'البريد الإلكتروني',
                    'phone' => 'رقم الجوال',
                    'address' => 'العنوان',
                    'status' => 'الحالة',
                    'fullAddress' => 'العنوان بالتفصيل',
                    'location' => 'الموقع',
                    'branchImage' => 'صورة الفرع',
                    'lat' => 'خط طول',
                    'lng' => 'خط عرض'
                ],
                'validation' => [
                    'required' => '%{attribute} مطلوب',
                    'required_f' => '%{attribute} مطلوبة',
                    'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حرف ',
                    'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حرف'
                ],
                'placeholder' => [
                    'choosevendor' => 'إختر العميل',
                    'chooseBranch' => 'أدخل اسم الفرع',
                    'enter_name' => 'أدخل الاسم',
                    'chooseStatus' => 'اختر الحالة',
                    'address' => 'أدخل العنوان',
                    'email' => 'أدخل البريد الإلكتروني',
                    'phone_x' => 'xxxxxxxx',
                    'enter_phone' => 'أدخل رقم الجوال'
                ],
                'labels' => [
                    'vendor_name' => 'اسم العميل',
                    'branch_name' => 'اسم الفرع',
                    'address' => 'العنوان',
                    'status' => 'الحالة',
                    'phone' => 'رقم الجوال',
                    'email' => 'البريد الإلكتروني',
                    'fullAddress' => 'العنوان بالتفصيل',
                    'location' => 'الموقع',
                    'branchImage' => 'صورة الفرع',
                    'drag_image' => 'اسحب  واسقط أو قم برفع صورة التطبيق',
                    'lat' => 'خط طول',
                    'lng' => 'خط عرض'
                ],
                'statusOptions' => [
                    'all' => 'الجميع',
                    'is_active' => 'مفعل',
                    'un_active' => 'معطل',
                    'without' => 'بدون',
                    'without_department' => 'بدون قسم'
                ],
                'cards' => [
                    'branch_data' => 'بيانات الفرع',
                    'map' => 'إحداثيات الموقع'
                ],
                'map' => [
                    'location' => 'الموقع',
                    'lat' => 'خط طول',
                    'lng' => 'خط عرض'
                ],
                'tooltip' => [
                    'archive' => 'أرشفة',
                    'edit' => 'تعديل',
                    'view_details' => 'عرض ',
                    'messages' => 'الرسائل',
                    'Settings' => 'الإعدادات',
                    'logout' => 'تسجيل خروج',
                    'confirm_account' => 'تأكيد الحساب',
                    'confirmed_account' => 'الحساب مؤكد',
                    'hang_account' => 'تعليق الحساب',
                    'restore' => 'استعادة',
                    'force_delete' => 'حذف '
                ],
                'popup' => [
                    'buttons' => [
                        'accept' => 'موافق',
                        'refuse' => 'غير موافق',
                        'close' => 'إغلاق'
                    ],
                    'body' => [
                        'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                        'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                        'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                        'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                        'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                        'back' => 'هل تريد العودة دون الحفظ ؟',
                        'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                    ],
                    'reasonLabel' => 'الرجاء ذكر السبب',
                    'reasonValidation' => 'السبب'
                ],
                'heading' => [
                    'history' => 'الحركة التاريخية'
                ],
                'chips' => [
                    'active' => 'مفعل',
                    'inActive' => 'معطل',
                    'edit' => 'تعديل',
                    'actived' => 'تفعيل',
                    'deactive' => 'تعطيل',
                    'add' => 'إضافة',
                    'archive' => 'أرشفة',
                    'restored' => 'استعادة'
                ]
            ]
        ],
        'citizens' => [
            'breadcrumb' => [
                'record' => 'سجل المستخدمين',
                'edit' => 'تعديل مستخدم',
                'view' => 'عرض مستخدم'
            ],
            'table' => [
                '#' => '#',
                'user_name' => 'اسم المستخدم',
                'identity_number' => 'رقم الهوية',
                'mobile' => 'رقم الجوال',
                'activated_card' => 'البطاقة المفعلة',
                'card_end_at' => 'تاريخ إنتهاء البطاقة',
                'register_date' => 'تاريخ التسجيل',
                'status' => 'الحالة',
                'actions' => 'العمليات',
                'by_employee' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity' => 'النشاط',
                'activity_details' => 'تفاصيل النشاط',
                'no_data' => ' لا توجد نتائج متاحة',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'مستخدم'
                ]
            ],
            'buttons' => [
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'save' => 'حفظ',
                'back' => 'عودة',
                'edit' => 'تعديل'
            ],
            'fields' => [
                'phone' => 'رقم الجوال'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'validPhoneNumber' => 'يرجى ادخال رقم جوال بصيغة صحيحة'
            ],
            'placeholder' => [
                'enter_name' => 'أدخل الاسم',
                'add_number' => 'أدخل الرقم',
                'select_date' => 'يوم/شهر/سنة',
                'all' => 'الجميع',
                'user_name' => 'اسم المستخدم',
                'identity_number' => 'رقم الهوية',
                'mobile' => 'رقم الجوال',
                'activated_card' => 'البطاقة المفعلة',
                'card_end_at' => 'تاريخ إنتهاء البطاقة',
                'register_date' => 'تاريخ التسجيل',
                'phone_x' => 'xxxxxxxx',
                'enter_phone' => 'أدخل رقم الجوال'
            ],
            'labels' => [
                'user_name' => 'اسم المستخدم',
                'identity_number' => 'رقم الهوية',
                'phone' => 'رقم الجوال',
                'active_card' => 'البطاقة المفعلة',
                'card_end_date_from' => 'تاريخ إنتهاء البطاقة (من)',
                'card_end_date_to' => 'تاريخ إنتهاء البطاقة (إلى)',
                'register_date_from' => 'تاريخ التسجيل (من)',
                'register_date_to' => 'تاريخ التسجيل (إلى)',
                'activated_card' => 'البطاقة المفعلة',
                'card_end_at' => 'تاريخ إنتهاء البطاقة',
                'register_date' => 'تاريخ التسجيل',
                'all' => 'الجميع',
                'from' => 'من',
                'to' => 'إلى',
                'status' => 'الحالة'
            ],
            'heading' => [
                'historical_movment' => 'الحركة التاريخية'
            ],
            'tooltip' => [
                'edit' => 'تعديل',
                'view_details' => 'عرض',
                'exceeded_attempts' => 'معطل لتخطي عدد مرات الدخول الخاطئ',
                'temporary' => 'معطل مؤقت'
            ],
            'chips' => [
                'active' => 'مفعل',
                'permanent' => 'معطل',
                'temporary' => 'معطل مؤقت',
                'inActive' => 'معطل'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'permanent disable' => 'معطل',
                'Temporary Disable' => 'معطل مؤقت',
                'exceeded_attempts' => 'معطل لتخطي عدد مرات الدخول الخاطئ',
                'no_data' => 'لا توجد نتائج متاحة'
            ]
        ],
        'transactions' => [
            'breadcrumb' => [
                'record' => 'سجل المعاملات',
                'view' => 'عرض معاملة'
            ],
            'table' => [
                '#' => '#',
                'transaction_number' => 'رقم المعاملة',
                'client_name' => 'اسم المستخدم',
                'transaction_date' => 'تاريخ المعاملة',
                'transaction_type' => 'نوع المعاملة',
                'transaction_status' => 'حالة المعاملة',
                'active_identity_card' => 'البطاقة المفعلة',
                'actions' => 'العمليات',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'معاملة'
                ]
            ],
            'buttons' => [
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'save' => 'حفظ',
                'back' => 'عودة'
            ],
            'fields' => [
                'phone' => 'رقم الجوال'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف'
            ],
            'placeholder' => [
                'enter_transaction' => 'أدخل رقم المعاملة',
                'choose_client' => 'اختر المستخدم',
                'select_date' => 'يوم/شهر/سنة',
                'choose_transaction_type' => 'اختر نوع المعاملة',
                'choose_transaction_status' => 'اختر حالة المعاملة',
                'choose_identity_type' => 'اختر نوع البطاقة',
                'enter_client_name' => 'أدخل اسم المستخدم'
            ],
            'labels' => [
                'transaction_number' => 'رقم المعاملة',
                'client_name' => 'اسم المستخدم',
                'user_name' => 'اسم المستخدم',
                'phone' => 'رقم الجوال',
                'active_card' => 'البطاقة المفعلة',
                'transaction_date_from' => 'تاريخ المعاملة (من)',
                'transaction_date_to' => 'تاريخ المعاملة (إلى)',
                'activated_card' => 'البطاقة المفعلة',
                'transaction_type' => 'نوع المعاملة',
                'transaction_status' => 'حالة المعاملة',
                'transaction_date' => 'تاريخ المعاملة',
                'invoice_amount' => 'قيمة الفاتورة',
                'enabled_package_discount' => 'نسبة خصم البطاقة',
                'amount' => 'قيمة المعاملة',
                'cash_back' => 'المكافئات المكتسبة',
                'all' => 'الجميع',
                'success' => 'ناجحة',
                'fail' => 'فاشلة',
                'pending' => 'بانتظار الاستلام',
                'delivared' => 'تم الاستلام',
                'cancel' => 'تم الإلغاء',
                'vendor_name' => ' اسم العميل',
                'citizen_name' => 'اسم المستخدم'
            ],
            'tooltip' => [
                'view_details' => 'عرض'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ],
            'types' => [
                'payment' => 'دفع',
                'wallet_transfer' => 'تحويل لمحفظة',
                'locale_transfer' => 'تحويل محلى',
                'global_transfer' => 'تحويل دولى',
                'recharge_credit' => 'شحن',
                'upgrade_card' => 'ترقية البطاقات'
            ]
        ],
        'card_packages' => [
            'breadcrumb' => [
                'card_packages' => 'نسب خصم البطاقات',
                'record' => 'سجل نسب خصم البطاقات',
                'add' => 'إضافة نسبة خصم البطاقة',
                'edit' => 'تعديل نسبة خصم البطاقة'
            ],
            'table' => [
                '#' => '#',
                'client_name' => 'اسم العميل',
                'basic_discount' => 'البطاقة الأساسية',
                'golden_discount' => 'البطاقة الذهبية',
                'platinum_discount' => 'البطاقة البلاتينية',
                'actions' => 'العمليات',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'نسبة خصم'
                ]
            ],
            'buttons' => [
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'save' => 'حفظ',
                'back' => 'عودة',
                'add_discount_rates' => 'إضافة نسب خصم البطاقات'
            ],
            'fields' => [
                'phone' => 'رقم الجوال',
                'client_name' => 'اسم العميل',
                'discounts' => 'نسبة الخصم'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'maxValue' => '%{attribute} يجب ان لا تتجاوز %{max}',
                'minValue' => '%{attribute} يجب ان تكون علي الاقل %{min}'
            ],
            'placeholder' => [
                'choose_client' => 'اختر العميل',
                'enter_discount' => 'أدخل نسبة الخصم'
            ],
            'labels' => [
                'client_name' => 'اسم العميل',
                'basic_card' => 'نسبة خصم البطاقة الأساسية',
                'gold_card' => 'نسبة خصم البطاقة الذهبية',
                'platinum_card' => 'نسبة خصم البطاقة البلاتينية'
            ],
            'tooltip' => [
                'edit' => 'تعديل'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ]
        ],
        'messages' => [
            'breadcrumb' => [
                'record' => 'الدعم والمساعدة',
                'messages' => 'صندوق الرسائل',
                'reply' => 'الرد على الرسالة',
                'view' => 'عرض الرسالة'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'table' => [
                '#' => '#',
                'sender_name' => 'اسم المرسل',
                'mobile' => 'رقم الجوال',
                'message_type' => 'نوع الرسالة',
                'message_status' => 'حالة الرسالة',
                'email' => 'البريد الإلكتروني',
                'employee' => ' الموظف المسئول',
                'message_from' => 'مصدر الرسالة',
                'message_date' => 'تاريخ الرسالة',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'department_name' => 'اسم القسم',
                'activity_date' => 'تاريخ النشاط',
                'activity_name' => 'النشاط',
                'activity_reason' => 'السبب',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'without_department' => 'بدون قسم',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'رسالة'
                ]
            ],
            'buttons' => [
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'save' => 'حفظ',
                'edit' => 'حفظ',
                'send' => 'إرسال',
                'back' => 'عودة'
            ],
            'fields' => [
                'employee_name' => 'الموظف المسئول',
                'reply' => 'الرد',
                'admin' => 'اسم الموظف',
                'notes' => 'الملحوظة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'validPhoneNumber' => 'يرجى ادخال رقم جوال بصيغة صحيحة    '
            ],
            'placeholder' => [
                'enter_name' => 'أدخل الاسم',
                'add_number' => 'أدخل الرقم',
                'select_date' => 'يوم/شهر/سنة',
                'all' => 'الجميع',
                'select_type' => 'اختر النوع',
                'select_status' => 'اختر الحالة',
                'enter_email' => 'أدخل البريد الإلكتروني',
                'select_message_from' => 'اختر المصدر',
                'employee' => 'اسم الموظف المسئول',
                'enter_reply' => 'أدخل الرد',
                'enter_note' => 'أدخل ملوحظة',
                'phone_x' => 'xxxxxxxx',
                'enter_phone' => 'أدخل رقم الجوال'
            ],
            'labels' => [
                'sender_name' => 'اسم المرسل',
                'phone' => 'رقم الجوال',
                'message_type' => 'نوع الرسالة',
                'message_status' => 'حالة الرسالة',
                'message_date_from' => 'تاريخ الرسالة (من)',
                'message_date_to' => 'تاريخ الرسالة (إلى)',
                'message_details' => 'نص الرسالة',
                'reply' => 'الرد',
                'message_date' => 'تاريخ الرسالة',
                'email' => 'البريد الإلكتروني',
                'employee' => 'اسم الموظف المسئول',
                'message_from' => 'مصدر الرسالة',
                'all' => 'الجميع',
                'problem' => 'شكوى',
                'suggestion' => 'إقتراح',
                'active' => 'مفعل',
                'deactive' => 'معطل',
                'application' => 'التطبيق',
                'website' => 'الموقع الإلكتروني',
                'no_data' => 'لا توجد بيانات',
                'complain' => 'شكوي',
                'noData' => 'لا يوجد رد',
                'noAdmin' => 'لا يوجد ',
                'new' => 'جديد',
                'pending' => 'بانتظار الرد ',
                'replied' => 'تم الرد ',
                'without_emplyees' => 'لا يوجد موظفين',
                'note' => 'ملحوظة',
                'assigned' => 'تم الإحالة'
            ],
            'tooltip' => [
                'reply' => 'رد',
                'view_details' => 'عرض',
                'force_delete' => 'حذف'
            ],
            'chips' => [
                'pending' => 'بإنتظار الرد',
                'new' => 'جديد',
                'replied' => 'تم الرد',
                'active' => 'مفعل',
                'inActive' => 'معطل',
                'edit' => 'تعديل',
                'actived' => 'تفعيل',
                'deactive' => 'تعطيل',
                'add' => 'إضافة',
                'archive' => 'أرشفة',
                'restored' => 'استعادة',
                'shown' => 'تم الإطلاع',
                'assigned' => 'تم الإحالة',
                'created' => 'تم الاستقبال'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الإرسال ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ]
        ],
        'messageTypes' => [
            'statusOptions' => [
                'all' => 'الجميع',
                'active' => 'مفعل',
                'inactive' => 'معطل',
                'no_data' => 'لا توجد نتائج متاحة'
            ],
            'breadcrumb' => [
                'record' => 'الدعم والمساعدة',
                'edit_message_type' => 'تعديل نوع الرسالة',
                'create_message_type' => 'اضاقة نوع رسالة',
                'view' => 'عرض نوع الرسالة',
                'message_type' => 'نوع  الرسالة'
            ],
            'heading' => [
                'history' => 'الحركة التاريخية'
            ],
            'table' => [
                '#' => '#',
                'message_type' => 'نوع الرسالة',
                'employees_count' => ' عدد الموظفين',
                'actions' => 'العمليات',
                'addedBy' => 'تم بواسطة',
                'created_at' => 'تاريخ الأنشاء ',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'status' => 'الحالة',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'نوع رسالة'
                ]
            ],
            'buttons' => [
                'export' => 'تصدير',
                'reset' => 'عرض الكل',
                'search' => 'بحث',
                'save' => 'حفظ',
                'edit' => 'حفظ',
                'back' => 'عودة',
                'add_message_type' => 'اضافة نوع رسالة',
                'edit_button' => 'تعديل'
            ],
            'fields' => [
                'employee_name' => 'الموظف المسئول',
                'employee' => 'الموظف المسئول',
                'name' => 'نوع الرسالة',
                'reply' => 'الرد',
                'status' => 'الحالة'
            ],
            'validation' => [
                'required' => '%{attribute} مطلوب',
                'required_f' => '%{attribute} مطلوبة',
                'maxLength' => '%{attribute} يجب ان لا يتجاوز %{max} حروف ',
                'minLength' => '%{attribute} يجب ان لا يقل عن  %{min} حروف',
                'validPhoneNumber' => 'يرجى ادخال رقم جوال بصيغة صحيحة    '
            ],
            'placeholder' => [
                'enter_message_type' => 'أدخل  نوع الرسالة',
                'enter_employee_in_charge' => 'اختر الموظف المسئول',
                'select_date' => 'يوم/شهر/سنة',
                'all' => 'الجميع',
                'select_type' => 'اختر النوع',
                'select_status' => 'اختر الحالة',
                'enter_email' => 'أدخل البريد الإلكتروني',
                'select_message_from' => 'اختر المصدر',
                'employee' => 'اسم الموظف المسئول',
                'enter_reply' => 'أدخل الرد'
            ],
            'labels' => [
                'message_type' => 'نوع الرسالة',
                'employee_in_charge' => 'الموظف المسئول',
                'created_date_from' => 'تاريخ  الإنشاء من',
                'created_date_to' => 'تاريخ الإنشاء إلى',
                'message_details' => 'نص الرسالة',
                'reply' => 'الرد',
                'message_date' => 'تاريخ الرسالة',
                'email' => 'البريد الإلكتروني',
                'employee' => ' الموظف المسئول',
                'message_from' => 'مصدر الرسالة',
                'all' => 'الجميع',
                'problem' => 'شكاوي',
                'suggestion' => 'إقتراح',
                'active' => 'مفعل',
                'deactive' => 'معطل',
                'application' => 'التطبيق',
                'website' => 'الموقع الإلكتروني',
                'no_data' => 'لا توجد بيانات',
                'complain' => 'شكوي',
                'without_emplyees' => 'لا يوجد موظفين',
                'status' => 'الحالة'
            ],
            'tooltip' => [
                'reply' => 'رد',
                'view_details' => 'عرض',
                'force_delete' => 'حذف'
            ],
            'chips' => [
                'active' => 'مفعل',
                'permanent' => 'معطل دائم',
                'temporary' => 'معطل لفترة',
                'deactivated' => 'تعطيل',
                'inactive' => 'معطل',
                'activated' => 'تفعيل',
                'archive' => 'أرشيف',
                'edit' => 'تعديل',
                'add' => 'إضافة',
                'inActive' => 'معطل'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق',
                    'close' => 'إغلاق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟',
                    'un_archive_has_message' => 'لا يمكن حذف رسالة مرتبطة برسالة'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ]
        ],
        'public' => [
            'loading' => 'جاري التحميل',
            'without' => 'بدون',
            'no_data' => ' لا توجد نتائج متاحة',
            'close' => 'إغلاق',
            'not_found' => 'الصفحة غير موجودة',
            'go_home' => 'اذهب للرئيسية',
            'pdf' => 'pdf',
            'xlsx' => 'xlsx',
            'map' => [
                'location' => 'الموقع',
                'lat' => 'خط طول',
                'lng' => 'خط عرض',
                'addLocation' => 'أدخل الموقع',
                'location_detect' => 'الموقع',
                'fields' => [
                    'lat' => 'خط طول',
                    'lng' => 'خط عرض'
                ]
            ],
            'validation' => [
                'imageType' => 'يجب أن يكون نوع الصورة jpg , png , jpeg',
                'imageSize' => 'يجب أن يكون حجم الصورة أقل من %{count} kb',
                'imageDimensions' => 'أبعاد الصورة غير صالحة',
                'image_ratio' => 'نسبة الصورة غير صالحة',
                'isPngType' => 'فقط  png'
            ]
        ],
        'appLinks' => [
            'table' => [
                '#' => '#',
                'links' => 'الروابط',
                'staticPages' => 'الصفحة الثابتة',
                'actions' => 'العمليات',
                'no_data' => ' لا توجد نتائج متاحة',
                'activity_details' => 'تفاصيل النشاط',
                'pagination' => [
                    'show' => 'عرض',
                    'to' => 'إلى',
                    'of' => 'من',
                    'result' => 'روابط'
                ]
            ],
            'breadcrumb' => [
                'settings' => 'إعدادات التطبيق',
                'links' => 'الروابط'
            ],
            'buttons' => [
                'save' => 'حفظ'
            ],
            'placeholder' => [
                'enter_static_page' => 'اختر الصفحة الثابتة'
            ]
        ],
        'appBar' => [
            'labels' => [
                'profile' => 'الملف الشخصي',
                'logout' => 'تسجيل خروج'
            ]
        ],
        'profile' => [
            'labels' => [
                'user_name' => 'اسم المستخدم',
                'department' => 'القسم',
                'job_name' => 'اسم الوظيفة',
                'user_number' => 'رقم المستخدم',
                'email' => 'البريد الإلكتروني',
                'phone' => 'رقم الجوال',
                'check_password' => 'تغيير كلمة المرور',
                'image' => 'صورة المستخدم',
                'drag_image' => 'اسحب  واسقط أو قم برفع الصورة',
                'current_password' => 'كلمة المرور الحالية',
                'new_password' => 'كلمة المرور الجديدة',
                'confirm_password' => 'تأكيد كلمة المرور الجديدة'
            ],
            'placeholder' => [
                'enter_current_password' => 'أدخل كلمة المرور الحالية',
                'enter_confirmation_password' => 'أدخل تأكيد كلمة المرور الجديدة',
                'enter_new_password' => 'أدخل كلمة المرور الجديدة'
            ],
            'breadcrumb' => [
                'profile' => 'الملف الشخصي'
            ],
            'buttons' => [
                'save' => 'حفظ',
                'back' => 'عودة'
            ],
            'fields' => [
                'current_password' => 'كلمة المرور الحالية',
                'new_password' => 'كلمة المرور الجديدة',
                'confirm_password' => 'تأكيد كلمة المرور'
            ],
            'popup' => [
                'buttons' => [
                    'accept' => 'موافق',
                    'refuse' => 'غير موافق'
                ],
                'body' => [
                    'archive' => 'هل تريد إتمام عملية الأرشفة؟',
                    'confirmAccount' => 'هل تريد إتمام عملية تأكيد الحساب؟',
                    'hangAccount' => 'هل تريد إتمام عملية التعليق؟',
                    'confirm' => 'هل تريد إتمام عملية الحفظ ؟',
                    'confirmSubmit' => 'هل تريد إتمام عملية الحفظ ؟',
                    'back' => 'هل تريد العودة دون الحفظ ؟',
                    'delete' => 'هل تريد إتمام عملية الحذف النهائي؟'
                ],
                'reasonLabel' => 'الرجاء ذكر السبب',
                'reasonValidation' => 'السبب'
            ]
        ]
    ],
    'appName' => 'الفنتك'
];
