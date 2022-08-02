<?php

return [
    'validation' => [
        "fullname" => [
            "required" => "اسم المستخدم مطلوب",
            "min" => "اسم المستخدم يجب ان لا يقل عن 2 حروف",
        ],

        "phone" => [
            "required" => "رقم الجوال مطلوب",
            "invalid" => "صيغة رقم الجوال غير صحيحة",
        ],

        "email" => [
            "required" => "البريد الإلكتروني مطلوب",
            "email" => "البريد الالكتروني غير صحيح رجاء التأكد من الكتابة بطريقة صحيحة",
            "regex" => "البريد الالكتروني غير صحيح رجاء التأكد من الكتابة بطريقة صحيحة",
        ],

        'card_date_format' => 'أدخل التاريخ بصيغة صحيحة',
        'after' => 'يجب ادخال تاريخ مستقبلي',
        'date_format' => 'يجب ادخال تاريخ مستقبلي',
        'code' => [
            'exists' => 'رمز التحقق غير صحيح',
        ],
        'identity_number_is_not_found' => 'رقم الهوية غير صحيح',
        'phone_number_is_not_found' => 'رقم الهاتف غير صحيح',
        'wallet_number_is_not_found' => 'رقم المحفظة غير صحيح',
        'not_same_wallet' => 'عفوا لا يمكن التحويل لمحفظتك الشخصية',
        'password' => [
            'min' => 'كلمة المرور يجب ان لا تقل عن :min حروف',
            'max' => 'كلمة المرور يجب ان لا تزيد عن :max حرفا',
            'regex' => 'كلمة المرور يجب أن تحتوي علي حروف كبيرة و صغيرة و أرقام و علامات خاصة',
        ],
        'after_today' => 'يجب ادخال تاريخ مستقبلي',
        'card_after_today' => 'يجب ادخال تاريخ مستقبلي',
        'invalid_phone' => 'صيغة رقم الجوال غير صحيحة',
        'mobile' => [
            'otp_invaild' => 'رمز التحقق غير صالح',
            'otp_vaild' => 'رمز التحقق صالح',
        ],
        'card_name' => 'اسم البطاقة مطلوب',
        'invalid_iban' => 'رقم الأيبان غير صحيح',
        'unique_phone' => 'رقم الجوال مسجل لدينا من قبل',
        'phone_digits' => 'رقم الجوال يجب أن يكون :digits أرقام',
        'identity_number_digits' => 'رقم الهوية يجب أن يكون :digits أرقام',
        'before' => 'لا يمكن ان يكون تاريخ الميلاد تاريخ مستقبلي',
    ],
    'transaction' => [
        'status_cases' => [
            'fail' => 'فاشلة',
            'pending' => 'بانتظار الاستلام',
            'cancel' => 'تم الالغاء',
            'success' => 'ناجحة',
            'received' => 'تم الاستلام',
        ],
        'charge_types' => [
            'nfc' => 'NFC',
            'manual' => 'البطاقة البنكية المنتهية بـ(:card_number)',
            'scan' => 'مسح بيانات البطاقة',
            'sadad' => 'سداد',
            'exists' => 'شحن باستخدام البطاقات المحفوظة'
        ],
        'transaction_types' => [
            'local_transfer' => 'تحويل محلي',
            'payment' => 'دفع فاتورة',
            'charge' => 'شحن',
            'promote_package' => 'ترقية بطاقة',
            'global_transfer' => 'تحويل دولي',
            'wallet_transfer' => 'تحويل لمحفظة',
            'money_request' => 'طلب أموال',
            'transfer' => 'تحويل',
        ],
        'transaction_details' => [
            'payment_status' => 'تمت عملية الشراء من العميل  بقيمة فاتورة :amount وتم استرداد مبلغ :refund_amount',
            'wallet_transfer_status' => 'تم تحويل مبلغ :amount ر.س من المحفظة الخاصة بك إلى محفظة المستخدم ب:transfer_type_trans :to_user_identity_or_mobile_or_wallet_number ',
            'local_transfer_status' => 'تم تحويل مبلغ :amount ر.س من المحفظة الخاصة بك إلى المستفيد :beneficiary برقم IBAN :iban',
            'global_transfer_status' => 'تم تحويل مبلغ :amount بعملة :currency من المحفظة الخاصة بك إلى المستفيد :beneficiary بدولة :country باستخدام :recieve_option وبرقم :mtcn',
            'charge_status' => 'تم شحن رصيد المحفظة الخاصة بك بالقيمة :amount عن طريق :method',
            'money_request_status' => 'تم استلام مبلغ :amount بالمحفظة الخاصة بك من قبل المستخدم برقم :to_user_identity_or_mobile_or_wallet_number',
            'promote_package_status' => 'تم ترقية البطاقة الخاصة بك إلي :package_name وتم خصم قيمة :amount ر.س  من المحفظة الخاصة بك مع العلم أن تاريخ انتهاء صلاحية البطاقة :expired_date',
            'reach_max_transaction_day' => 'عفواً إجمالي المعاملات اليومية المسموح بها لليوم الواحد يجب ألا تتجاوز :max_day_amount ',
            'reach_max_transaction_month' => 'عفواً إجمالي المعاملات الشهرية المسموح بها للشهر الواحد يجب ألا تتجاوز :max_month_amount',
        ],
    ],

    'messages' => [
        'you_can_complete_your_transaction' => 'يمكنك إستكمال العملية',
        'your_tries_have_been_expired' => 'لقد تم إنتهاء محاولاتك لإتمام العميلة',
        'wallet_bin_has_been_updated' => 'تم تحديث الرقم الخاص بالمحفظة',
        'success_charge' => 'تم الشحن بنجاح',
        'firstly_add_wallet_bin' => 'يجب إضافة رقم المحفظة أولاً',
        'success_payment' => 'تم الدفع بنجاح',

    ],
    'payments' => [
        'current_balance_is_not_sufficient_to_complete_payment' => 'لا يوجد رصيد كافي',
        'is_paid_before' => 'تم دفع هذه الفاتورة من قبل.',
        'invoice_number_required' => 'رقم الفاتورة مطلوب',
        'amount_required' => 'قيمة الفاتورة مطلوبة',
    ],
    'global_transfers' => [
        'current_balance_is_not_sufficient_to_complete_transaction' => 'لا يوجد رصيد كافى',
        'transfer_has_been_done_successfully' => 'تم التحويل بنجاح',
    ],
    'min' => [
        'string' => 'كلمة المرور يجب ان لا تقل عن 8 حروف',
    ],
    'promotion' => [
        'package_is_required' => 'يجب إختيار باقة',
        'package_is_not_found' => 'الباقة غير موجودة',
        'promo_code_is_used' => 'كود التخفيض مستخدم من قبل',
        'promo_code_is_not_found' => 'كود التخفيض غير صالح',
        'promoted_successfully' => 'تم ترقية الباقة بنجاح',
    ],
    'mobile' =>
    [
        'validation' =>
        [
            'mobile' =>
            [
                'otp_vaild' => 'رمز التحقق صالح',
            ],
        ],
    ],
    'local_transfers' => [
        'local_transfers' => 'التحويلات المحلية',
        'current_balance_is_not_sufficient_to_complete_transaction' => 'لا يوجد رصيد كافي',
        'local_transfer' => 'التحويل المحلي',
        'transfer_has_been_done_successfully' => 'تم التحويل بنجاح',
        'transfer_fees_is_not_enough' => 'رصيدك الحالي لا يكفي لسداد رسوم التحويل'
    ],

    'transfers' => [
        'transfer_details' => 'تم تحويل مبلغ :amount ر.س  من المحفظة الخاصة بك إلى محفظة المستخدم :wallet_transfer_method',
        'by_phone' => 'برقم جوال ',
        'by_identity_number' => 'برقم هوية ',
        'by_wallet_number' => 'برقم ',
        'cancel_transfer' => 'تم الالغاء واسترجاع الاموال بنجاح',
        'wallet_transfer_method' => 'تحويل لمحفظة',
        'exceed_max_transfer_day' => 'عفوا، لا يمكن تحويل مبلغ أكبر من :max_amount_per_reciever',
        'exceed_max_transfer_month' => 'لقد وصلت للحد الأقصى للتحويل الشهري',
        'wallet_transfer_methods' => [
            'phone' => 'رقم جوال',
            'wallet_number' => 'رقم محفظة',
            'identity_number' => 'رقم هوية',
        ],
    ],
    'package_types' => [
        'basic' => 'أساسية',
        'golden' => 'ذهبية',
        'platinum' => 'بلاتينية',
    ],
    'invoice' => [
        'invoice' => 'فاتورة',
        'invoice_number' => 'رقم الفاتورة',
        'successfully_Transfered' => 'تم التحويل بنجاح',
        'successfully_payment' => 'تم الدفع بنجاح',
        'successfully_charged' => 'تم الشحن بنجاح',
        'charge_amount' => 'مبلغ الشحن',
        'phone' => 'رقم الجوال',
        'transaction_type' => 'نوع العملية',
        'transaction_date' => 'تاريخ العملية',
        'mtcn_number' => 'رقم MTCN',
        'reference_number' => 'الرقم المرجعي',
        'transfer_amount' => 'مبلغ التحويل',
        'fee_amount' => 'رسوم التحويل',
        'from_account' => 'من المستخدم',
        'total' => 'إجمالي المبلغ',
        'beneficiary_name' => 'اسم المستفيد',
        'benefeciary_address' => 'عنوان المستفيد',
        'transfer_purpose' => 'الغرض من الحوالة',
    ],
    'otp' => [
        'required' => 'رمز OTP مطلوب',
        'exists' => 'رمز OTP غير صحيح'
    ],

    'currencies' => [
        'currency' => 'العملة',
        'currency_name' => 'اسم العملة',
        'valid_amount' => 'برجاء إدخال مبلغ صحيح',
        'base' => 'العملة الأساسية',
        'to' => 'إلى',
        'amount' => 'المبلغ',
        'error_parsing_json' => 'حدث خطأ ما',
        'validation' => [
            'base_required' => 'العملة الاساسية مطلوبة',
            'to_required' => 'العملة المحول اليها مطلوبة',
            'exists' => 'العملة غير موجودة',
            'gt' => 'ادخل مبلغ صحيح',
        ]
    ],
    'profile' => [
        'validation' => [
            'max_image_size' => 'عفوا، أقصى حجم للصورة 1MB',
            'image_mimes' => 'يرجى اختيار امتدادات الصور png, jpg, jpeg',
            'phone_required' => 'رقم الجوال مطلوب',
            'phone_unique' => 'رقم الجوال مسجل من قبل',
        ]
    ],

    "contacts" => [
        "validation" => [

            "message_type" => [
                "required" => "نوع الرسالة مطلوب",
                "exists" => "نوع الرسالة غير موجود",
            ],

            "content" => [
                "required" => "نص الرسالة مطلوب",
                "min" => "نص الرسالة يجب ان لا يقل عن :min حروف",
            ],
        ]
    ],
    "vendors" => [
        'vendor_type' => [
            'institution' => 'مؤسسات',
            'other' => 'أخري',
            'company' => 'شركات',
            'famous' => 'مشاهير',
            'freelance_doc' => 'مستقل',
            'member' => 'عضو',
        ]
    ],
    'notifications' => [
        'charge' => [
            'title' => 'شحن المحفظة',

        ],
        'payment' => [
            'title' => 'دفع فاتورة',

        ],
        'wallet_transfer' => [
            'title' => 'تحويل برقم المحفظة',

        ],
        'wallet_transfer_to' => [
            'title' => 'تحويل برقم المحفظة',

        ],
        "global_transfer" => [
            "title" => "تحويل دولي",

        ],
        "promote_package" => [
            "title" => "ترقية بطاقة",

        ],
        "local_transfer" => [
            "title" => "تحويل محلي",

        ]
    ],

    "wallet_transfer" => [
        "transfer_purpose" => [
            "exists" => "غرض الحوالة غير موجود",
        ]
    ]


];
