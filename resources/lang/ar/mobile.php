<?php

return [
    'local_transfers' => [
        'local_transfers' => 'التحويلات المحلية',
        'local_transfer' => 'التحويل المحلي',
        'current_balance_is_not_sufficiant_to_complete_transaction' => 'الرصيد الحالي لا يكفي لإجراء عملية التحويل',
        'transfer_has_been_done_successfully' => 'تمت عملية التحويل بنجاح'
    ],
    'messages' => [
        'wallet_bin_has_been_updated' => 'تم تحديث الرقم الخاص بالمحفظة',
        'firstly_add_wallet_bin' => 'يجب إضافة رقم المحفظة أولاً',
        'you_can_complete_your_transaction'=>'يمكنك إستكمال العملية',
        'your_tries_have_been_expired'=>'لقد تم إنتهاء محاولاتك لإتمام العميلة'
    ],
    'validation' => [
        'invalid_phone' => 'صيغة رقم الجوال غير صحيحة',
        'invalid_iban' => 'رقم الأيبان غير صحيح',
    ],

    'global_transfers'=>[
        'current_balance_is_not_sufficiant_to_complete_transaction'=>'الرصيد الحالي لا يكفي لإجراء عملية التحويل',
        'transfer_has_been_done_successfully'=>'تمت عملية التحويل بنجاح'
    ],
    'payments' => [
        'current_balance_is_not_sufficient_to_complete_payment'=>'الرصيد الحالي لا يكفي لإجراء عملية الدفع',
    ],
    'promotion'=>[
        'promo_code_is_used'=>'كود التخفيض مستخدم من قبل',
        'promo_code_is_not_found'=>'كود التخفيض غير موجود',
    ],
    'transaction' => [
        'transaction_types' => [
            'local_transfer' => 'تحويل محلي',
            'global_transfer' => 'تحويل دولي',
            'charge' => 'شحن',
            'money_request' => 'طلب أموال',
            'payment' => 'دفع فاتورة',
            'promote_package' => 'ترقية بطاقة',
        ],
        'status_cases' => [
            'success' => 'ناجحة',
            'fail' => 'فاشلة',
            'pending' => 'بانتظار الاستلام',
            'received' => 'تم الاستلام',
            'cancel' => 'تم الالغاء',
        ],
    ],
];
