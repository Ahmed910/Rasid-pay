<?php

return <<<'SQL'
INSERT INTO `clients` (`id`, `user_id`, `client_type`, `commercial_number`, `tax_number`, `activity_type`, `daily_expect_trans`, `nationality`, `address`, `marital_status`, `created_at`, `updated_at`, `register_type`, `transactions_done`) VALUES
('0cfcf15a-990a-4eae-9061-2059c0030027', 'afb22f32-21f3-4ad5-a86b-6e8d201caea8', 'institution', '85007404', '452470041494040', 'selling', 5, NULL, 'address', NULL, '2022-04-10 15:42:30', '2022-04-10 15:44:02', 'direct', '0'),
('121ea481-c3f6-4f29-b043-c8526f9b32b3', '128a309e-61f2-46db-832c-7a6ac772effe', 'company', '1264313214', '215464856465465', 'haha', 6, NULL, NULL, NULL, '2022-04-11 10:29:45', '2022-04-11 10:29:45', 'delegate', '0'),
('130e160b-ecf8-4e49-a937-27a309805bf3', 'b7aa3033-fa42-425d-a650-7d22d2ec794e', 'institution', '3213412313', '122698956523032', 'jjjjj', 9, NULL, NULL, NULL, '2022-04-19 14:41:10', '2022-04-19 14:41:10', 'direct', '0'),
('3176d80e-df79-4e0a-adf6-a04b1cf54435', 'df5d7e6c-78d1-44e1-a0a1-e7747b7e04e7', 'institution', '850034545', '123412344566', 'selling', 8, NULL, NULL, NULL, '2022-04-19 13:32:22', '2022-04-19 13:32:22', 'direct', '0'),
('4758c245-189d-471a-af67-72be856aec38', '933f6b2c-1bf0-43f9-b5fa-845796228bd9', 'famous', '850036693', '123470044567', 'selling', 8, NULL, NULL, NULL, '2022-04-11 10:15:43', '2022-04-11 10:15:43', NULL, '0'),
('5b20ad3d-7f13-427b-8d01-9ed62035ea48', '87457b22-6ed8-4b61-bdcf-51b1b577721f', 'company', '123123123', '123123123', 'asasd', 2, NULL, NULL, NULL, '2022-04-19 14:33:51', '2022-04-19 14:33:51', 'delegate', '0'),
('5fa6f323-369d-4349-b4a1-8e34d26bc203', 'f2d8718f-a4e8-485b-a5e5-25780f566030', 'institution', '850036666', '123470044566', 'selling', 8, NULL, NULL, NULL, '2022-04-11 10:32:45', '2022-04-11 10:32:45', 'direct', '0'),
('72ad6d05-08cf-4664-8fed-2c72f820cc92', 'c6c36801-c834-48c8-a244-4742ad830ad4', 'institution', '850074041', '452470011', 'selling', 5, NULL, 'address', NULL, '2022-04-10 15:48:02', '2022-04-10 15:49:13', 'direct', '0'),
('7a786d0b-20d5-42dc-a016-8afaedb37a06', '58f5e61d-a176-410a-b683-ead33c70a673', 'company', '1321321321', '1321321321', 'asdsd', 2, 'null', 'null', NULL, '2022-04-19 13:02:09', '2022-04-25 13:22:25', 'delegate', '0'),
('7ebbf509-980e-4085-97cf-ea14a8e2f0d2', '0ad579af-026c-4a4a-a66e-05fe1d41e5f3', 'member', '850074085', '452470041545', 'selling', 9, NULL, NULL, NULL, '2022-04-11 09:55:42', '2022-04-11 09:55:42', NULL, '0'),
('8438b95e-8ee9-4198-9df4-cbfeda44c482', 'a6614ac7-d4c3-4df4-a2f3-a537ca2ec032', 'company', '123123', '123123', '2', 2, 'null', 'null', NULL, '2022-04-20 10:30:30', '2022-04-24 10:43:52', 'delegate', '0'),
('9df44c30-2ff2-4968-9c48-0f4d4fd08b42', 'd7f0fac1-057f-47af-92ab-9b06eb11e2f5', 'institution', '850074458', '4524700415070', 'selling', 5, NULL, 'address', NULL, '2022-04-17 15:07:24', '2022-04-17 15:07:24', 'direct', '0'),
('a282fc1d-ecaa-49b2-8a31-5f2a1c02e09a', 'c5ac3887-fdc9-4011-a761-579ff0a9113f', 'institution', '5643131349', '465464317897', 'hjk', 9, NULL, NULL, NULL, '2022-04-11 10:36:53', '2022-04-11 10:36:53', 'delegate', '0'),
('b66c0766-72b3-47c1-8ec5-54fa9c2c84c5', 'fceabe05-af52-4c13-bb66-34b7b20f7c70', 'famous', '850036548', '123470044463', 'selling', 8, NULL, NULL, NULL, '2022-04-11 10:01:06', '2022-04-11 10:01:06', NULL, '0'),
('c67f46fb-ac99-41ca-b0e1-0879dde32d65', '069b5559-7091-4d54-b066-d1b92ee0ae69', 'company', '850071243', '123470041545', 'selling', 10, NULL, NULL, NULL, '2022-04-11 09:58:45', '2022-04-11 09:58:45', 'direct', '0'),
('d9c29a27-73be-48f7-b2b9-404cd4b9ef6e', '9a324630-ab97-48cf-b83a-2c8f5f7fb83a', 'company', '215432132', '121546465422', 'sasaa', 9, 'null', 'null', NULL, '2022-04-19 13:39:04', '2022-04-25 12:58:03', 'delegate', '0'),
('ecc0d8c1-9b0e-4269-8d6b-c1a77f855d64', 'aff11e24-ded9-4af7-a0cd-593bab5676be', 'company', '454444444', '54543543545', 'business', 5, NULL, NULL, NULL, '2022-04-17 11:15:39', '2022-04-17 11:15:39', 'delegate', '0');

INSERT INTO `attachments` (`id`, `user_id`, `title`, `attachment_type`, `created_at`, `updated_at`) VALUES
('4057ceed-6674-4af0-b85d-d15dbf0aa9bc', '87457b22-6ed8-4b61-bdcf-51b1b577721f', 'asdasdasd', 'images', '2022-04-19 14:33:51', '2022-04-19 14:33:51'),
('491681e2-e6de-45f3-8fbb-7ccef6fcd273', '58f5e61d-a176-410a-b683-ead33c70a673', 'asd asd asd', 'images', '2022-04-19 13:02:09', '2022-04-19 13:02:09'),
('4f53c30b-e8d1-46b0-9e3c-842f19ee8c19', 'b7aa3033-fa42-425d-a650-7d22d2ec794e', 'otherss', 'other', '2022-04-19 14:41:10', '2022-04-19 14:41:10'),
('6fb03ca8-c8d0-48a9-96da-314ef302521c', '9a324630-ab97-48cf-b83a-2c8f5f7fb83a', 'imgg', 'images', '2022-04-19 13:39:04', '2022-04-19 13:39:04'),
('978b9c29-6095-4178-97f8-9bdab2761df6', 'df5d7e6c-78d1-44e1-a0a1-e7747b7e04e7', 'title', 'images', '2022-04-19 13:32:22', '2022-04-19 13:32:22'),
('bddbf284-bead-46c0-abc3-454d5a964f16', 'a6614ac7-d4c3-4df4-a2f3-a537ca2ec032', '222', 'images', '2022-04-20 10:30:30', '2022-04-20 10:30:30');

INSERT INTO `attachment_files` (`id`, `attachment_id`, `type`, `path`, `created_at`, `updated_at`, `name`, `size`) VALUES
('151f2347-aa94-4d0a-a378-e5f597842a69', '978b9c29-6095-4178-97f8-9bdab2761df6', 'image/png', 'files/client/HAiIl1obcnXgCcwHha8istomeKR0RoCUQBk6E65z.png', '2022-04-19 13:32:22', '2022-04-19 13:32:22', 'icon3.png', '3519'),
('18365fc4-15be-418c-ba13-c095a118d0f3', 'bddbf284-bead-46c0-abc3-454d5a964f16', 'image/png', 'files/client/m8KNBqZLKfJM87WFXrYSlnmAhIZ2mY6D0udlOFwg.png', '2022-04-25 14:53:44', '2022-04-25 14:53:44', '7 - Departments Management – 1.png', '265399'),
('1f5cc663-f0d0-491d-bce4-545d0bcff7a1', '4f53c30b-e8d1-46b0-9e3c-842f19ee8c19', 'image/jpeg', 'files/client/0iUArCknIlgwEDlbsOKVcE87r0T5icrVzeAa8e3W.jpg', '2022-04-19 14:41:10', '2022-04-19 14:41:10', 'img.jpg', '72214'),
('21b57918-f62c-4bd2-80c7-649d3e1ef084', '491681e2-e6de-45f3-8fbb-7ccef6fcd273', 'image/png', 'files/client/9QcxzqahFJOORj0pHclUO9P5BLoi4LcCWPwJEOAE.png', '2022-04-25 13:30:54', '2022-04-25 13:30:54', '2 - Add Departments Management.png', '127350'),
('2967e3a0-ab57-432a-b90d-68c7dbc26b5c', '978b9c29-6095-4178-97f8-9bdab2761df6', 'image/png', 'files/client/2UphmYZgMBRFswyDqg8IPtGX0RtPHTyHwjIpSaZn.png', '2022-04-19 13:32:22', '2022-04-19 13:32:22', 'icon1.png', '4894'),
('47615116-f8f8-4615-937e-b16c7f72c85b', '978b9c29-6095-4178-97f8-9bdab2761df6', 'image/png', 'files/client/RzKqkwrzPIxFBZpyLticbI4Cf258Czgud4LGto5O.png', '2022-04-19 13:32:22', '2022-04-19 13:32:22', 'icon2.png', '4695'),
('704c1061-e6ac-42cd-a488-bfe797752774', '4057ceed-6674-4af0-b85d-d15dbf0aa9bc', 'image/jpeg', 'files/client/4e7KUqsEVecAmPnqz6hieYJ6JnkLgvvLu9nIdBj4.jpg', '2022-04-19 14:33:51', '2022-04-19 14:33:51', 'solo.jpg', '144699'),
('c1a66505-d91a-4cd1-b0bc-00aa4a01ae21', '4057ceed-6674-4af0-b85d-d15dbf0aa9bc', 'image/png', 'files/client/9Xu3rvHLvLcJSDfB3asjS5jRSKGqZl16yYSZgnTF.png', '2022-04-19 14:33:51', '2022-04-19 14:33:51', 'screencapture-localhost-8080-users-view-7cf03772-4107-41c7-95ea-3ab2e4665ffb-2022-03-07-10_08_47.png', '274180'),
('cdc5544e-6469-4068-90a3-e3f9138f235c', '4f53c30b-e8d1-46b0-9e3c-842f19ee8c19', 'image/png', 'files/client/VQwAsMMExUnzeFHaDJLsyKBKExqBT3NIwGQVdcEv.png', '2022-04-19 14:41:10', '2022-04-19 14:41:10', 'Mask Group 23.png', '1347'),
('d6dc95c6-065e-4d33-9bea-98e299adc65d', '4f53c30b-e8d1-46b0-9e3c-842f19ee8c19', 'image/png', 'files/client/MaJgPOAOHd2Yh09rQ0Ii3la9AXEF5fc5NN8WWBAF.png', '2022-04-19 14:41:10', '2022-04-19 14:41:10', 'Mask Group 24.png', '2185'),
('e2b9d5c9-d178-473a-868c-9622bb279ae4', 'bddbf284-bead-46c0-abc3-454d5a964f16', 'image/png', 'files/client/aifxdgraRN86kM6GXPHBXgLtWj1oWf9alaOOVqb0.png', '2022-04-25 14:53:44', '2022-04-25 14:53:44', '8 - Archive Alert – 2.png', '174434'),
('f1ca0237-2a2a-4e3b-a24e-0a47bf5beef6', '491681e2-e6de-45f3-8fbb-7ccef6fcd273', 'image/png', 'files/client/fnxxdBebTnAXFcUdOzDkSaUWaFLj9BtvnSUQstgA.png', '2022-04-25 13:30:54', '2022-04-25 13:30:54', '0 - Departments Management - Small Menu.png', '228694'),
('f7a8d1af-db3c-463d-a7b4-b2f20624828f', '491681e2-e6de-45f3-8fbb-7ccef6fcd273', 'image/png', 'files/client/R795k1KhiED5usL3S00NwYWjtF9GS2F1nXBczyRb.png', '2022-04-25 13:30:54', '2022-04-25 13:30:54', '1 - Departments Management.png', '253260'),
('f8673dab-f43a-4992-987a-c12ff2350edc', 'bddbf284-bead-46c0-abc3-454d5a964f16', 'image/png', 'files/client/MgnT5hpLXXiJTLnXzd6fTV4ahwyr6tzapVygFfNY.png', '2022-04-25 14:53:44', '2022-04-25 14:53:44', '4 - Edit Departments Management – 2.png', '126995');

SQL;
