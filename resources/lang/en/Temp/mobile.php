<?php

return [
    'transaction' => [
        'transaction_types' => [
            'promote_package' => 'Promote Package',
            'global_transfer' => 'Global Transfer',
            'payment' => 'Payment',
            'money_request' => 'Money Request',
            'charge' => 'Charge',
            'local_transfer' => 'Local Transfer',
            'transfer' => 'Transfer',
        ],
        'status_cases' => [
            'received' => 'Received',
            'success' => 'Success',
            'cancel' => 'Cancel',
            'pending' => 'Pending',
            'fail' => 'Fail',
        ],
        'transaction_details' => [
            'reach_max_transaction_day' => 'You have reached the maximum transaction limit per day.',
            'reach_max_transaction_month' => 'You have reached the maximum transaction limit per month.',
        ],
    ],
    'validation' => [
        'date_format' => 'Enter correct date',
        'after_today' => 'Should enter future date',
        'mobile' => [
            'otp_invaild' => 'otp is invalid',
            'otp_vaild' => 'otp is valid',
        ],
        'card_after_today' => 'Should enter future date',
        'card_date_format' => 'Enter correct date format',
        'card_name' => 'Card Name is required',
        'after' => 'Should enter future date',
    ],
    'local_transfers' => [
        'transfer_has_been_done_successfully' => 'Transfer Has Been Done Successfully',
        'local_transfers' => 'Local Transfers',
        'local_transfer' => 'Local Transfer',
        'current_balance_is_not_sufficient_to_complete_transaction' => 'Current Balance Is Not Sufficient To Complete Transaction',
    ],
    'messages' => [
        'firstly_add_wallet_bin' => 'Firstly Add Wallet Bin',
        'your_tries_have_been_expired' => 'Your Tries Have Been Expired For Complete This Transaction',
        'wallet_bin_has_been_updated' => 'Wallet Bin Has Been Updated',
        'you_can_complete_your_transaction' => 'You Can Complete Your Transaction',
        'success_payment' => 'Payment completed successfully ',

    ],
    'mobile' => [
        'validation' => [
            'mobile' => [
                'otp_vaild' => 'otp is invalid',
            ],
        ],
    ],
    'promotion' => [
        'package_is_required' => 'Package is required',
        'package_is_not_found' => 'Package Is Not Found',
        'promo_code_is_used' => 'Promo Code Is Used',
        'promo_code_is_not_found' => 'Promo Code Is Not Found',
        'promoted_successfully' => 'Promoted Successfully',
    ],
    'payments' => [
        'current_balance_is_not_sufficient_to_complete_payment' => 'Current Balance Is Not Sufficient To Complete Payment',
        'is_paid_before' => 'This invoice has been paid before.'
    ],
    'transfers' => [
        'transfer_details' => '???? ?????????? ???????? :amount ??.??  ???? ?????????????? ???????????? ???? ?????? ?????????? ???????????????? :wallet_transfer_method',
        'by_phone' => 'By Phone',
        'by_identity_number' => 'By Identity Number',
        'by_wallet_number' => 'By Wallet Number',
        'cancel_transfer' => 'Transfer has been canceled successfully and money is back to your wallet',
        'wallet_transfer_method' => 'Wallet Transfer Method',
        'exceed_max_transfer_day' => 'You have exceeded the maximum transfer value per day.',
        'exceed_max_transfer_month' => 'You have exceeded the maximum transfer value per month.'
    ],
    'package_types' => [
        'basic' => 'Basic',
        'golden' => 'Golden',
        'platinum' => 'Platinum',
    ]
];
