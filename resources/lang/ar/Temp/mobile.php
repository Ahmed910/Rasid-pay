<?php

return [
    'validation' => [
        'card_date_format' => 'أدخل التاريخ بصيغة صحيحة',
        'after' => 'يجب ادخال تاريخ مستقبلي',
        'date_format' => 'يجب ادخال تاريخ مستقبلي',
        'code' =>  [
            'exists' => 'رمز التحقق غير صحيح',
        ],
        'password' => [
            'min' => 'كلمة المرور يجب ان لا تقل عن 8 حروف',
            'max' => 'كلمة المرور يجب ان لا تزيد عن 20 حرفا',
            'regex' => 'كلمة المرور يجب أن تحتوي علي حروف كبيرة و صغيرة و أرقام و علامات خاصة',
        ],
        'after_today' => 'يجب ادخال تاريخ مستقبلي',
        'card_after_today' => 'يجب ادخال تاريخ مستقبلي',
        'invalid_phone' => 'صيغة رقم الجوال غير صحيحة',
        'mobile' =>  [
            'otp_invaild' => 'رمز التحقق غير صالح',
            'otp_vaild' => 'رمز التحقق صالح',
        ],
        'card_name' => 'اسم البطاقة مطلوب',
        'invalid_iban' => 'رقم الأيبان غير صحيح',
        'unique_phone' => 'رقم الجوال مسجل لدينا من قبل',
        'phone_digits' => 'رقم الجوال يجب أن يكون 9 أرقام',
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
        'transaction_types' => [
            'local_transfer' => 'تحويل محلي',
            'payment' => 'دفع فاتورة',
            'charge' => 'شحن',
            'promote_package' => 'ترقية بطاقة',
            'global_transfer' => 'تحويل دولي',
            'wallet_transfer' => 'تحويل محفظة',
            'money_request' => 'طلب أموال',
        ],
    ],
    'messages' => [
        'you_can_complete_your_transaction' => 'يمكنك إستكمال العملية',
        'your_tries_have_been_expired' => 'لقد تم إنتهاء محاولاتك لإتمام العميلة',
        'wallet_bin_has_been_updated' => 'تم تحديث الرقم الخاص بالمحفظة',
        'success_charge' => 'تم الشحن بنجاح',
        'firstly_add_wallet_bin' => 'يجب إضافة رقم المحفظة أولاً',
    ],
    'payments' => [
        'current_balance_is_not_sufficient_to_complete_payment' => 'الرصيد الحالي لا يكفي لإجراء عملية الدفع',
    ],
    'global_transfers' => [
        'current_balance_is_not_sufficiant_to_complete_transaction' => 'الرصيد الحالي لا يكفي لإجراء عملية التحويل',
        'transfer_has_been_done_successfully' => 'تمت عملية التحويل بنجاح',
    ],
    'min' =>  [
        'string' => 'كلمة المرور يجب ان لا تقل عن 8 حروف',
    ],
    'promotion' => [
        'promo_code_is_not_found' => 'كود التخفيض غير موجود',
        'promo_code_is_used' => 'كود التخفيض مستخدم من قبل',
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
    'local_transfers' =>  [
        'local_transfers' => 'التحويلات المحلية',
        'current_balance_is_not_sufficiant_to_complete_transaction' => 'الرصيد الحالي لا يكفي لإجراء عملية التحويل',
        'local_transfer' => 'التحويل المحلي',
        'transfer_has_been_done_successfully' => 'تمت عملية التحويل بنجاح',
    ],

    'transfers' => [
        'transfer_details' => 'تم تحويل مبلغ :amount ر.س  من المحفظة الخاصة بك إلى محفظة المستخدم :wallet_transfer_method',
        'by_phone' => 'برقم جوال ',
        'by_identity_number' => 'برقم هوية ',
        'by_wallet_number' => 'برقم ',

    ]
];