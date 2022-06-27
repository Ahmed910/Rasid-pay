<?php

use Illuminate\Support\Arr;

$dashboardAr = Arr::dot(include resource_path('lang/ar/dashboard.php'));
$dashboardEn = Arr::dot(include resource_path('lang/en/dashboard.php'));

$mobileAr = Arr::dot(include resource_path('lang/ar/mobile.php'));
$mobileEn = Arr::dot(include resource_path('lang/en/mobile.php'));

$validationAr = Arr::dot(include resource_path('lang/ar/validation.php'));
$validationEn = Arr::dot(include resource_path('lang/en/validation.php'));

$vueAr = Arr::dot(include resource_path('lang/ar/vue_static.php'));
$vueEn = Arr::dot(include resource_path('lang/en/vue_static.php'));

foreach ($dashboardAr as $key => $value) {
    $allTrans[] = ['locale' => 'ar', 'file' => 'dashboard', 'key' => $key, 'value' => $value];
}

foreach ($dashboardEn as $key => $value) {
    $allTrans[] = ['locale' => 'en', 'file' => 'dashboard', 'key' => $key, 'value' => $value];
}

foreach ($mobileAr as $key => $value) {
    $allTrans[] = ['locale' => 'ar', 'file' => 'mobile', 'key' => $key, 'value' => $value];
}

foreach ($mobileEn as $key => $value) {
    $allTrans[] = ['locale' => 'en', 'file' => 'mobile', 'key' => $key, 'value' => $value];
}

foreach ($validationAr as $key => $value) {
    $allTrans[] = ['locale' => 'ar', 'file' => 'validation', 'key' => $key, 'value' => $value];
}

foreach ($validationEn as $key => $value) {
    $allTrans[] = ['locale' => 'en', 'file' => 'validation', 'key' => $key, 'value' => $value];
}

foreach ($vueAr as $key => $value) {
    $allTrans[] = ['locale' => 'ar', 'file' => 'vue_static', 'key' => $key, 'value' => $value];
}

foreach ($vueEn as $key => $value) {
    $allTrans[] = ['locale' => 'en', 'file' => 'vue_static', 'key' => $key, 'value' => $value];
}

return [
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'failed', 'value' => 'محاولة غير صالحة لتسجيل الدخول'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'password', 'value' => 'كلمة المرور  غير صحيحة'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'throttle', 'value' => 'تخطي عدد مرات الارسال رجاء الانتظار :seconds ثواني.'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_login', 'value' => 'تسجيل الدخول الى النظام برقم مستخدم :user'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'unauth', 'value' => 'قم بتسجيل الدخول أولا'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'logout_waiting_u_another_time', 'value' => 'تم تسجيل الخروج بنجاح], في انتظارك مرة أخرى'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'ban_permanent', 'value' => 'تم تعطيل الحساب'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'ban_temporary', 'value' => 'تم تعطيل الحساب لفترة من :ban_from  إلي :ban_to'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_send_login_code', 'value' => 'تم ارسال كود التحقق الى رقم الجوال'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'account_not_exists', 'value' => 'الحساب غير موجود'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_change_password', 'value' => 'تم تغيير كلمة المرور بنجاح'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'account_is_true', 'value' => 'البيانات المدخلة صحيحة'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_code_plz_add_new_password', 'value' => 'تم التحقق من كود الاسترجاع برجاء اضافة كلمة مرور جديدة'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'code_not_true', 'value' => 'الكود غير صحيح'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'login_title', 'value' => 'تسجيل الدخول'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'login_subtitle', 'value' => 'من فضلك أدخل رقم المستخدم وكلمة المرور'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'reset_password', 'value' => 'إعادة تعيين كلمة المرور'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'userID', 'value' => 'رقم المستخدم'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'your_userID', 'value' => 'أدخل الرقم'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'password', 'value' => 'أدخل كلمة المرور'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'remember', 'value' => 'تذكرني'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'reset_subtitle', 'value' => 'من فضلك أدخل بريدك الإلكتروني أو رقم جوالك لإرسال رمز التحقق'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'user_banned', 'value' => 'هذا الحساب معطل'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_activate_notifcation', 'value' => 'تم تعديل الاشعارات بنجاح'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_signup', 'value' => 'تم إنشاء الحساب بنجاح يرجي التحقق من رقم الجوال'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'verify_phone', 'value' => 'برجاء تأكيد رقم الجوال'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_verify_phone', 'value' => 'تم تأكيد رقم الجوال بنجاح'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'fail_send', 'value' => 'فشل عملية الارسال'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_update_password', 'value' => 'تم تعديل كلمة المرور بنجاح'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'wrong_old_password', 'value' => 'كلمة المرور الحالية غير متطابقة'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'verify_phone_first', 'value' => 'يجب تأكيد رقم الهاتف أولا'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_verify_phone_make_login', 'value' => 'تم إنشاء الحساب بنجاح'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_login_mobile', 'value' => 'تسجيل دخول إلى التطبيق برقم هوية :user'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'success_update_verify_phone', 'value' => 'تم تحديث بياناتك بنجاح رجاء تأكيد رقم الجوال الجديد'],
    ['locale' => 'ar', 'file' => 'auth', 'key' => 'password_used_before', 'value' => 'كلمة المرور مستخدمة من قبل'],
    //en
    ['locale' => 'en', 'file' => 'auth', 'key' => 'failed', 'value' => 'These credentials do not match our records.'],
    ['locale' => 'en', 'file' => 'auth', 'key' => 'password', 'value' => 'The provided password is incorrect.'],
    ['locale' => 'en', 'file' => 'auth', 'key' => 'throttle', 'value' => 'Too many login attempts. Please try again in :seconds seconds.'],
    ['locale' => 'en', 'file' => 'auth', 'key' => 'success_login', 'value' => 'تم تسجيل الدخول بنجاح'],
    ['locale' => 'en', 'file' => 'auth', 'key' => 'unauth', 'value' => 'قم بتسجيل الدخول أولا'],
    ['locale' => 'en', 'file' => 'auth', 'key' => 'login_title', 'value' => 'login'],
    ['locale' => 'en', 'file' => 'auth', 'key' => 'user_banned', 'value' => 'User Banned']

] + $allTrans;
