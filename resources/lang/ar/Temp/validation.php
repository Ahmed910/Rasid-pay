<?php

return [
    'attributes' => [
        'banks' =>  [
            '*' =>   [
                'id' => 'حقل ID للبنك',
                'type' => 'حقل نوع البنك',
                'transfer_amount' => 'حقل قيمة تكلفة التحويل',
                'commercial_record' => 'حقل السجل التجاري',
                'is_active' => 'حقل is_active',
                'tax_number' => 'حقل الرقم الضريبي',
                'name' => 'حقل اسم البنك',
                'site' => 'حقل موقع البنك',
                'service_customer' => 'حقل خدمة العملاء',
                'code' => 'حقل كود البنك',
                'ar' =>
                [
                    'name' => 'حقل اسم الفرع',
                ],
            ],
        ],
        'discounts' => [
            2 =>  [
                'package_discount' => 'حقل نسبة خصم البطاقة البلاتينية',
            ],
            0 =>  [
                'package_discount' => 'حقل نسبة خصم البطاقة الأساسية ',
            ],
            1 => [
                'package_discount' => 'حقل نسبة خصم البطاقة الذهبية',
            ],
        ],
        'rasid_job_id' => ' اسم الوظيفة',
        'expire_at' => 'تاريخ إنتهاء البطاقة',
        'excerpt' => 'حقل المُلخص',
        'sex' => 'حقل الجنس',
        'age' => 'حقل العمر',
        'size' => 'حقل الحجم',
        'contact_type' => 'حقل نوع الرسالة',
        'transfer_method_value' => 'حقل قيمة طريقة التحويل',
        'country_id' => 'حقل الدولة',
        'login_id' => ' رقم المستخدم',
        'today' => 'تاريخ غير صالح',
        'date_of_birth' => 'حقل تاريخ الميلاد',
        'first_name' => 'حقل الاسم الأول',
        'branches' =>  [
            '*' => [
                'tax_number' => 'حقل الرقم الضريبي ',
                'type' => 'حقل نوع البنك ',
                'transfer_amount' => 'حقل القيمة المحولة  ',
                'ar' =>  [
                    'name' => 'حقل الاسم',
                ],
                'site' => 'حقل موقع البنك ',
                'code' => 'حقل كود البنك ',
                'service_customer' => 'حقل خدمة العملاء  ',
                'commercial_record' => 'حقل السجل التجاري ',
            ],
        ],
        'hour' => 'حقل ساعة',
        'group_list' => 'حقل المجموعات',
        'password_confirmation' => 'حقل تأكيد كلمة المرور',
        'identity_number' => 'حقل رقم الهوية / الإقامة',
        'card_id' => 'حقل البطاقة',
        'permission_list' => [
            '*' => 'حقل الصلاحيات الفردية',
        ],
        'relation' => 'حقل علاقة القرابة',
        'wallet_bin' => 'حقل رقم المحفظة',
        'is_ban' => 'حقل الحالة من الحظر',
        'transfer_purpose_id ' => 'حقل غرض التحويل',
        'content' => 'حقل المُحتوى',
        'golden_discount' => 'نسبة خصم البطاقة الذهبية',
        'month' => 'حقل الشهر',
        'ban_from' => 'حقل تاريخ من',
        'ar' => [
            'name' => 'حقل الاسم',
            'nationality' => 'حقل الجنسية',
            'title' => 'حقل dashboard.attributes.title',
            'description' => 'حقل dashboard.attributes.desc',
        ],
        'mobile' => 'حقل الجوال',
        'ban_to' => 'حقل تاريخ إلى',
        'description' => 'حقل الوصف',
        'card_type' => 'حقل نوع البطاقة',
        'available' => 'حقل مُتاح',
        'card_number' => 'الرقم على البطاقة',
        'city_id' => 'حقل المدينة',
        'email' => ' البريد الالكتروني',
        'name' => 'حقل الاسم',
        'fullname' => 'حقل الاسم',
        'reasonAction' => ' السبب',
        'minute' => 'حقل دقيقة',
        'last_name' => 'حقل اسم العائلة',
        'title' => 'حقل العنوان',
        'code' => 'رمز التحقق',
        'year' => 'حقل السنة',
        'password' => 'حقل كلمة المرور',
        'reset_code' => 'رمز التحقق',
        'platinum_discount' => 'نسبة خصم البطاقة البلاتينية',
        'basic_discount' => 'نسبة خصم البطاقة الأساسية',
        'current_password' => 'حقل كلمة المرور الحالية',
        'date' => 'حقل التاريخ',
        'beneficiary_id ' => 'حقل المستفيد',
        'amount' => 'المبلغ',
        'second' => 'حقل ثانية',
        'charge_type' => 'حقل طريقة الشحن',
        'ban_reason' => 'حقل سبب الحظر',
        'owner_name' => 'الاسم على البطاقة',
        'full_phone' => 'حقل الهاتف',
        'is_active' => ' الحالة مطلوبة ',
        'is_card_saved' => 'الاحتفاظ ببيانات البطاقة',
        'employee_id' => 'حقل اسم الموظف',
        'department_id' => 'القسم ',
        'new_password' => 'حقل كلمة المرور الجديدة',
        'client_id' => 'اسم العميل',
        'time' => 'حقل الوقت',
        'recieve_option_id' => 'حقل  خيارات الاستلام',
        'phone' => 'حقل الهاتف',
        'wallet_transfer_method' => 'حقل طريقة التحويل',
        'card_name' => 'اسم البطاقة',
        'desc' => 'حقل الوصف',
        'username' => ' رقم المستخدم',
        'iban_number' => 'رقم الايبان',
        'day' => 'حقل اليوم',
        'parent_id' => 'حقل القسم الرئيسي',
        'gender' => 'حقل النوع',
        'nationality' => 'حقل الجنسية',
        'address' => 'حقل العنوان',
    ],
    'min' =>  [
        'numeric' => 'يجب أن تكون قيمة  :attribute مساوية أو أكبر من :min.',
        'string' => 'يجب أن يكون طول نص  :attribute على الأقل :min حروفٍ/حرفًا.',
        'file' => 'يجب أن يكون حجم ملف  :attribute على الأقل :min كيلوبايت.',
        'array' => 'يجب أن يحتوي  :attribute على الأقل على :min عُنصرًا/عناصر.',
    ],
    'different' => 'يجب أن يكون :attribute و :other مُختلفين.',
    'ipv4' => 'يجب أن يكون  :attribute عنوان IPv4 صحيحًا.',
    'values' =>  [
        'card_type' => [
            'mastercard' => 'ماستر كارد',
            'american_express' => 'امريكان اكسبريس',
            'visa' => 'فيزا',
        ],
        'code_type' => [
            'reset_code' => 'كود استعادة',
            'login_code' => 'كود الدخول',
            'verified_code' => 'كود تفعيل',
        ],
    ],
    'gt' =>  [
        'string' => 'يجب أن يكون طول نّص  :attribute أكثر من :value حروفٍ/حرفًا.',
        'numeric' => 'يجب أن تكون قيمة  :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم ملف  :attribute أكبر من :value كيلوبايت.',
        'array' => 'يجب أن يحتوي  :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'validation' => [
        'date_format' => 'يجب ادخال تاريخ مستقبلي',
    ],
    'admin' => [
        'unique_login_id' => 'رقم المستخدم موجود من قبل',
        'required_job' => 'الوظيفة مطلوبة',
        'unique_email' => 'البريد الإلكتروني موجود من قبل',
        'confirmed_password' => 'كلمة المرور غير متطابقة',
        'unique_phone' => 'رقم الجوال موجود من قبل',
        'required_name' => 'اسم المستخدم مطلوب',
        'required_password' => 'كلمة المرور مطلوبة',
    ],
    'password' => 'كلمة المرور غير صحيحة.',
    'gte' => [
        'string' => 'يجب أن يكون طول نص  :attribute على الأقل :value حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي  :attribute على الأقل على :value عُنصرًا/عناصر.',
        'file' => 'يجب أن يكون حجم ملف  :attribute على الأقل :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة  :attribute مساوية أو أكبر من :value.',
    ],
    'lte' =>   [
        'string' => 'يجب أن لا يتجاوز طول نّص  :attribute :value حروفٍ/حرفًا.',
        'numeric' => 'يجب أن تكون قيمة  :attribute مساوية أو أصغر من :value.',
        'file' => 'يجب أن لا يتجاوز حجم ملف  :attribute :value كيلوبايت.',
        'array' => 'يجب أن لا يحتوي  :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'before_or_equal' => ' :attribute يجب أن يكون تاريخا سابقا أو مطابقا لتاريخ :date.',
    'digits' => 'يجب أن يحتوي  :attribute على :digits رقمًا.',
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'declined' => 'يجب رفض :attribute.',
    'job' =>  [
        'required' => 'اسم الوظيفة مطلوب',
    ],
    'distinct' => 'لل :attribute قيمة مُكرّرة.',
    'max' =>  [
        'array' => 'يجب أن لا يحتوي  :attribute على أكثر من :max عناصر/عنصر.',
        'string' => 'يجب أن لا يتجاوز طول نّص  :attribute :max حروفٍ/حرفًا.',
        'file' => 'يجب أن لا يتجاوز حجم ملف  :attribute :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة  :attribute مساوية أو أصغر من :max.',
    ],
    'accepted_if' => 'يجب قبول :attribute في حالة :other يساوي :value.',
    'dimensions' => 'ال:attribute يحتوي على أبعاد صورة غير صالحة.',
    'uuid' => ' :attribute يجب أن يكون بصيغة UUID سليمة.',
    'between' =>  [
        'array' => 'يجب أن يحتوي  :attribute على عدد من العناصر بين :min و :max.',
        'string' => 'يجب أن يكون عدد حروف نّص  :attribute بين :min و :max.',
        'numeric' => 'يجب أن تكون قيمة  :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم ملف  :attribute بين :min و :max كيلوبايت.',
    ],
    'lt' => [
        'string' => 'يجب أن يكون طول نّص  :attribute أقل من :value حروفٍ/حرفًا.',
        'numeric' => 'يجب أن تكون قيمة  :attribute أصغر من :value.',
        'file' => 'يجب أن يكون حجم ملف  :attribute أصغر من :value كيلوبايت.',
        'array' => 'يجب أن يحتوي  :attribute على أقل من :value عناصر/عنصر.',
    ],
    'integer' => 'يجب أن يكون  :attribute عددًا صحيحًا.',
    'after_or_equal' => ' :attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'required_without_all' => ' :attribute مطلوب إذا لم يتوفّر :values.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة  :attribute مساوية لـ :size.',
        'array' => 'يجب أن يحتوي  :attribute على :size عنصرٍ/عناصر بالضبط.',
        'file' => 'يجب أن يكون حجم ملف  :attribute :size كيلوبايت.',
        'string' => 'يجب أن يحتوي نص  :attribute على :size حروفٍ/حرفًا بالضبط.',
    ],
    'ipv6' => 'يجب أن يكون  :attribute عنوان IPv6 صحيحًا.',
    'timezone' => 'يجب أن يكون  :attribute نطاقًا زمنيًا صحيحًا.',
    'custom' => [
        'email' => [
            'exists' => 'هذا البريد غير مسجل بالنظام',
            'correct_email' => 'يرجى إدخال بريد إلكتروني بصيغة صحيحة',
        ],
        'phone' =>  [
            'exists' => ' رقم الجوال غير مسجل بالنظام',
        ],
        'identity_number' =>  [
            'regex' => 'رقم الهوية/ الاقامة  يجب ان لا يبدا بصفر',
        ],
        'unique' => 'الاسم موجود من قبل',
    ],
    'prohibits' => 'ال :attribute يحظر تواجد ال :other.',
    'exists' => 'القيمة المحددة ل:attribute غير موجودة.',
    'string' => 'يجب أن يكون  :attribute نصًا.',
    'regex' => 'صيغة :attribute غير صحيحة',
    'boolean' => 'يجب أن تكون قيمة  :attribute إما true أو false .',
    'required_with' => ' :attribute مطلوب إذا توفّر :values.',
    'required_array_keys' => 'ال :attribute يجب أن يحتوي على مدخلات لـ: :values.',
    'present' => 'يجب تقديم  :attribute.',
    'in_array' => ' :attribute غير موجود في :other.',
    'url' => 'صيغة رابط  :attribute غير صحيحة.',
    'filled' => ' :attribute إجباري.',
    'alpha_num' => 'يجب أن يحتوي  :attribute على حروفٍ وأرقامٍ فقط.',
    'ip' => 'يجب أن يكون  :attribute عنوان IP صحيحًا.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'numeric' => 'يجب على  :attribute أن يكون رقمًا.',
    'required_unless' => ' :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'ends_with' => 'يجب أن ينتهي  :attribute بأحد القيم التالية: :values',
    'department' =>  [
        'required' => 'اسم القسم مطلوب',
    ],
    'alpha_dash' => 'يجب أن لا يحتوي  :attribute سوى على حروف، أرقام ومطّات.',
    'multiple_of' => ' :attribute يجب أن يكون من مضاعفات :value',
    'digits_between' => 'يجب أن يحتوي  :attribute بين :min و :max رقمًا.',
    'accepted' => 'يجب قبول :attribute.',
    'date_equals' => 'يجب أن يكون  :attribute مطابقاً للتاريخ :date.',
    'required' => ' :attribute مطلوب.',
    'json' => 'يجب أن يكون  :attribute نصًا من نوع JSON.',
    'client_package' =>
    [
        'platinum_gt_golden' => 'يرجى ادخال نسبة اكبر من نسبة البطاقة الذهبية',
        'gold_gt_basic' => 'يرجى ادخال نسبة اكبر من نسبة البطاقة الاساسية',
    ],
    'prohibited_if' => ' :attribute محظور إذا كان :other هو :value.',
    'active_url' => ' :attribute لا يُمثّل رابطًا صحيحًا.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'alpha' => 'يجب أن لا يحتوي  :attribute سوى على حروف.',
    'prohibited' => ' :attribute محظور.',
    'declined_if' => 'يجب رفض :attribute عندما يكون :other بقيمة :value.',
    'date' => ' :attribute ليس تاريخًا صحيحًا.',
    'required_without' => ' :attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق  :attribute مع :other.',
    'in' => ' :attribute يجب ان يكون ضمن القيم الآتية: :values.',
    'starts_with' => 'يجب أن يبدأ  :attribute بأحد القيم التالية: :values',
    'array' => 'يجب أن يكون  :attribute ًمصفوفة.',
    'enum' => ' :attribute المختار غير صالح.',
    'confirmed' => ' التأكيد غير مُطابق لل :attribute.',
    'before' => 'يجب على  :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'date_format' => 'لا يتوافق  :attribute مع الشكل :format.',
    'unique' => 'قيمة  :attribute موجودة من قبل.',
    'uploaded' => 'فشل في تحميل الـ :attribute.',
    'required_if' => ' :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'image' => 'يجب أن يكون  :attribute صورةً.',
    'not_regex' => 'صيغة  :attribute غير صحيحة.',
    'not_in' => 'عنصر ال :attribute غير صحيح.',
    'prohibited_unless' => ' :attribute محظور ما لم يكن :other ضمن :values.',
    'file' => 'ال :attribute يجب أن يكون ملفا.',
    'email' => 'صيغة  :attribute غير صحيحة',
    'after' => ':attribute غير صالح',
    'mac_address' => 'ال :attribute يجب أن يكون عنوان MAC صالحاً.',
    'required_with_all' => ' :attribute مطلوب إذا توفّر :values.',

    'beneficiaries' => [
        "name" =>   [
            "required" => "الاسم مطلوب"
        ],
        "transfer_relation" => [
            "required_if" => "العلاقة مع المستفيد مطلوبة"
        ],
          "country" => [
            "required_if" => "الدولة مطلوبة"
        ],
    ],
    'wallet_transfer' =>[
        'amount'=>[
            'gte'=>'مبلغ التحويل يجب أن لا يقل عن :min_amount',
            'lte'=>'مبلغ التحويل يجب أن لا يتجاوز عن :max_amount'
        ],

    ],

    'wallet_charge' =>[
        'amount'=>[
            'gte'=>'مبلغ الشحن يجب أن لا يقل عن :min_amount',
            'lte'=>'مبلغ الشحن يجب أن لا يتجاوز عن :max_amount'
        ],

    ],

    'local_transfers' =>[
        'amount'=>[
            'gte'=>'مبلغ التحويل يجب أن لا يقل عن :min_amount',
            'lte'=>'مبلغ التحويل يجب أن لا يتجاوز عن :max_amount',
            "required" => "مبلغ التحويل مطلوب",

        ],
        'transfer_purpose_id'=>[
            "required" =>  "الغرض من التحويل  مطلوب ",

        ],
        "notes" =>   [
            "required" => "الغرض من التحويل مطلوب"
        ],

    ],

    'global_transfers' => [
        "otp_code" =>   [
            "required" => "مطلوب otp رمز",
            "exists" => "غير صحيح otp رمز"
        ],

       "amount" =>   [
            "required" => "مبلغ التحويل مطلوب",
            'gte'=>'مبلغ التحويل يجب أن لا يقل عن :min_amount',
            'lte'=>'مبلغ التحويل يجب أن لا يتجاوز عن :max_amount',
       ],

        "notes" =>   [
            "required" => "الغرض من التحويل مطلوب"
        ],

       "beneficiary" =>   [
            "exists" => "هذا المستفيد غير موجود"
        ],

    ],
];
