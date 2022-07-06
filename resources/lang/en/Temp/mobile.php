<?php

return [
    'transaction' =>  [
        'transaction_types' =>  [
            'promote_package' => 'Promote Package',
            'global_transfer' => 'Global Transfer',
            'payment' => 'Payment',
            'money_request' => 'Money Request',
            'charge' => 'Charge',
            'local_transfer' => 'Local Transfer',
        ],
        'status_cases' => [
            'received' => 'Received',
            'success' => 'Success',
            'cancel' => 'Cancel',
            'pending' => 'Pending',
            'fail' => 'Fail',
        ],
    ],
    'validation' => [
        'date_format' => 'Enter correct date',
        'after_today' => 'Should enter future date',
        'mobile' =>  [
            'otp_invaild' => 'otp is invalid',
            'otp_vaild' => 'otp is valid',
        ],
        'card_after_today' => 'Should enter future date',
        'card_date_format' => 'Enter correct date format',
        'card_name' => 'Card Name is required',
        'after' => 'Should enter future date',
    ],
    'local_transfers' =>  [
        'transfer_has_been_done_successfully' => 'Transfer Has Been Done Successfully',
        'local_transfers' => 'Local Transfers',
        'local_transfer' => 'Local Transfer',
        'current_balance_is_not_sufficiant_to_complete_transaction' => 'Current Balance Is Not Sufficiant To Complete Transaction',
    ],
    'messages' =>  [
        'firstly_add_wallet_bin' => 'Firstly Add Wallet Bin',
        'your_tries_have_been_expired' => 'Your Tries Have Been Expired For Complete This Transaction',
        'wallet_bin_has_been_updated' => 'Wallet Bin Has Been Updated',
        'you_can_complete_your_transaction' => 'You Can Complete Your Transaction',
    ],
    'mobile' => [
        'validation' => [
            'mobile' =>  [
                'otp_vaild' => 'otp is invalid',
            ],
        ],
    ],
    'promotion' => [
        'promo_code_is_not_found' => 'Promo Code Is Not Found',
        'promo_code_is_used' => 'Promo Code Is Used Before',
    ],
    'payments' => [
        'current_balance_is_not_sufficient_to_complete_payment' => 'Current Balance Is Not Sufficient To Complete Payment',
    ],
];
