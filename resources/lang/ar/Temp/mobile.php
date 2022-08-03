<?php

return [
    'validation' => [
        "identity_number" => [
            "required" => "رقم الهوية / الإقامة  مطلوب",
            "min" => "اسم المستخدم يجب ان لا يقل عن 2 حروف",
            "digits" => "رقم الهوية يجب أن يكون :digits أرقام",
            "not_exists" => "هذا الرقم غير مسجل بالنظام",
            'is_not_found' => 'رقم الهوية غير صحيح',
        ],
        "fullname" => [
            "required" => "اسم المستخدم مطلوب",
            "min" => "اسم المستخدم يجب ان لا يقل عن 2 حروف",
        ],

        "phone" => [
            "required" => "رقم الجوال مطلوب",
            "invalid" => "صيغة رقم الجوال غير صحيحة",
            "is_not_found" => "رقم الهاتف غير صحيح",
            'unique' => 'رقم الجوال مسجل لدينا من قبل',
            'digits' => 'رقم الجوال يجب أن يكون :digits أرقام',
        ],

        "email" => [
            "required" => "البريد الإلكتروني مطلوب",
            "email" => "البريد الالكتروني غير صحيح رجاء التأكد من الكتابة بطريقة صحيحة",
            "regex" => "البريد الالكتروني غير صحيح رجاء التأكد من الكتابة بطريقة صحيحة",
        ],

        'password' => [
            'min' => 'كلمة المرور يجب ان لا تقل عن :min حروف',
            'max' => 'كلمة المرور يجب ان لا تزيد عن :max حرفا',
            'regex' => 'كلمة المرور يجب أن تحتوي علي حروف كبيرة و صغيرة و أرقام و علامات خاصة',
        ],
        'card_date_format' => 'أدخل التاريخ بصيغة صحيحة',
        'after' => 'يجب ادخال تاريخ مستقبلي',
        'date_format' => 'يجب ادخال تاريخ مستقبلي',
        'code' => [
            'exists' => 'رمز التحقق غير صحيح',
        ],
        'wallet_number_is_not_found' => 'رقم المحفظة غير صحيح',
        'not_same_wallet' => 'عفوا لا يمكن التحويل لمحفظتك الشخصية',
        'reset_code' => [
            'required' => 'رمز التحقق مطلوب',
            'exists' => 'رمز التحقق غير صحيح',
        ],
        'after_today' => 'يجب ادخال تاريخ مستقبلي',
        'card_after_today' => 'يجب ادخال تاريخ مستقبلي',
        'card_name' => 'اسم البطاقة مطلوب',
        'invalid_iban' => 'رقم الأيبان غير صحيح',
        'before' => 'لا يمكن ان يكون تاريخ الميلاد تاريخ مستقبلي',

        'otp' => [
            'required' => 'رمز OTP مطلوب',
            'exists' => 'رمز OTP غير صحيح',
            'invaild' => 'رمز التحقق غير صالح',
            'vaild' => 'رمز التحقق صالح'
        ],
        'card_name' => 'اسم البطاقة مطلوب',
        'owner_name' => 'الاسم مطلوب',
        'invalid_iban' => 'رقم الأيبان غير صحيح',
        'unique_phone' => 'رقم الجوال مسجل لدينا من قبل',
        'phone_digits' => 'رقم الجوال يجب أن يكون :digits أرقام',
        'identity_number_digits' => 'رقم الهوية يجب أن يكون :digits أرقام',
        'before' => 'لا يمكن ان يكون تاريخ الميلاد تاريخ مستقبلي',
        'card_number_digits' => 'الرقم علي البطاقة يجب ان يكون مكون من :card_digits رقم',
        'required_card_number' => 'رقم البطاقة مطلوب',
    ],
    'wallet_charge' => [
        'amount' => [
            'gte' => 'يجب ان لا يقل قيمة المبلغ عن :min_amount',
            'lte' => 'يجب ان لا يتعدي قيمة المبلغ عن :max_amount'
        ],
    ],


    'beneficiaries' => [
        "iban_number" => [
            "required" => "رقم الايبان مطلوب",
            "starts_with" => "رقم الايبان يجب ان يبدأ ب :starts_with",
            "size" => "رقم الايبان يجب ان يكون :size حرف ورقم",
            "unique" => "رقم الايبان موجود من قبل",
        ],
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
            'wallet_transfer_status' => 'تم تحويل مبلغ :amount ر.س من المحفظة الخاصة بك إلى محفظة المستخدم ب:transfer_type_trans :to_user_identity_or_mobile_or_wallet_number',
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
    'promotion' => [
        'package_is_required' => 'يجب إختيار باقة',
        'package_is_not_found' => 'الباقة غير موجودة',
        'promo_code_is_used' => 'كود التخفيض مستخدم من قبل',
        'promo_code_is_not_found' => 'كود التخفيض غير صالح',
        'promoted_successfully' => 'تم ترقية الباقة بنجاح',
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
        'cancel_transfer' => 'تم إلغاء التحويل',
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
        'transaction_name' => 'اسم العملية',
        'transaction_value' => 'قيمة العملية',
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
        'exchange_rate' => 'سعر الصرف',
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
            'title' => 'تم شحن رصيد بنجاح',

        ],
        'payment' => [
            'title' => 'تم الدفع بنجاح',

        ],
        'wallet_transfer' => [
            'title' => 'تم التحويل لمحفظة أخرى بنجاح',

        ],
        'wallet_transfer_to' => [
            'title' => 'تحويل برقم المحفظة',

        ],
        "global_transfer" => [
            "title" => "تم التحويل الدولي بنجاح",

        ],
        "local_transfer" => [
            "title" => "تم التحويل المحلي بنجاح",

        ],


        "money_request" => [
            "title" => "تمت عملية طلب الأموال بنجاح",

        ],
        "promote_package" => [
            "title" => "تم ترقية البطاقات بنجاح",

        ],
        ],



    "wallet_transfer" => [
        "transfer_purpose" => [
            "exists" => "غرض الحوالة غير موجود",
        ]
    ]

];
