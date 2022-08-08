<?php

return <<<'SQL'
INSERT INTO `countries` (`id`, `currency_id`, `phone_code`, `deleted_at`, `created_at`, `updated_at`, `added_by_id`) VALUES
('e3d4b36c-2001-49b0-bf62-82a649912067', NULL, '+253', NULL, '2022-03-31 12:24:58', '2022-03-31 12:24:58', NULL);
INSERT INTO `country_translations` (`id`, `country_id`, `name`, `nationality`, `locale`) VALUES
('a72c993a-2a81-418e-88f7-264c116fd5ee', 'e3d4b36c-2001-49b0-bf62-82a649912067', 'ايطالياs', 'الايطالية d', 'ar');
SQL;



