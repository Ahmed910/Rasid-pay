<?php

return <<<'SQL'

INSERT INTO `slides` (`id`, `is_active`, `ordering`, `deleted_at`, `created_at`, `updated_at`) VALUES
('320638a3-5d71-4f08-92d5-fc70f34c2453', 1, '1', NULL, '2022-04-26 15:33:58', '2022-04-26 15:33:58'),
('4be0c971-e43a-42a0-a96b-988052991e8e', 1, '3', NULL, '2022-04-26 15:35:36', '2022-04-26 15:35:36'),
('9e224a7c-b106-4a10-a814-34907dfe7f4f', 1, '2', NULL, '2022-04-26 15:34:51', '2022-04-26 15:34:51');

INSERT INTO `slide_translations` (`id`, `slide_id`, `locale`, `name`, `description`) VALUES
('49bef62b-069e-4b88-99d1-ab24dee8e5c0', '320638a3-5d71-4f08-92d5-fc70f34c2453', 'ar', 'شحن رصيد' , 'بامكانك شحن رصيد محفظتك الالكترونية الآن بأسهل الطرق لأي بطاقة من خلال خاصية الـ NFC'),
('682eec5c-4024-4585-a5b6-a11205258149', '4be0c971-e43a-42a0-a96b-988052991e8e', 'ar', 'الدفع الالكتروني' , 'عملية الدفع الالكتروني أصبحت سهلة مع رصيد باي باستخدام تقنية NFC انضم الينا الان لمعرفة التفاصيل'),
('8ed76cd7-a505-4c43-a173-123c200ee467', '9e224a7c-b106-4a10-a814-34907dfe7f4f', 'ar', 'التحويل' , 'إجراء جميع التحويلات بكل سهولة باستخدام رصيد باي انضم الينا الان لمعرفة التفاصيل');

INSERT INTO `app_media` (`id`, `media`, `mediable_type`, `mediable_id`, `option`, `deleted_at`, `created_at`, `updated_at`) VALUES
('3cfb9746-9779-4cda-8371-12545c9fca55', '/dashboardAssets/images/onBoard/onboard-1.png', 'App\\Models\\Slide', '320638a3-5d71-4f08-92d5-fc70f34c2453', NULL, NULL, '2022-06-20 16:27:46', '2022-06-20 16:27:46'),
('3cfb9746-9779-4cda-8371-12545c9fca56', '/dashboardAssets/images/onBoard/onboard-2.png', 'App\\Models\\Slide', '9e224a7c-b106-4a10-a814-34907dfe7f4f', NULL, NULL, '2022-06-20 16:27:46', '2022-06-20 16:27:46'),
('3cfb9746-9779-4cda-8371-12545c9fca57', '/dashboardAssets/images/onBoard/onboard-3.png', 'App\\Models\\Slide', '9e224a7c-b106-4a10-a814-34907dfe7f4f', NULL, NULL, '2022-06-20 16:27:46', '2022-06-20 16:27:46');
SQL;
