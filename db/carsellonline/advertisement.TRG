TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `AdvertisementAutoCreateDate`\n    BEFORE INSERT ON `advertisement` FOR EACH ROW\nBEGIN\n    SET NEW.CreateDate = NOW();\nEND'
sql_modes=1101004800
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8_polish_ci'
created=163932592416
