TYPE=VIEW
query=select `a2`.`Id` AS `Id`,`a`.`company_name` AS `company_name`,`u`.`Email` AS `email`,`a`.`phone` AS `phone` from ((`carsellonline`.`user` `u` join `carsellonline`.`additional_dealer_data` `a` on(`u`.`Id` = `a`.`userId`)) join `carsellonline`.`advertisement` `a2` on(`u`.`Id` = `a2`.`CreateBy`)) where `u`.`Type` = \'C\'
md5=b735c3f97c61366b0adb152f887fbabb
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=2022-01-01 18:34:22
create-version=2
source=SELECT a2.Id, a.company_name, u.Email as \'email\', a.phone  FROM user u\njoin additional_dealer_data a on u.Id = a.userId\njoin advertisement a2 on u.Id = a2.CreateBy\nwhere Type=\'C\'
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `a2`.`Id` AS `Id`,`a`.`company_name` AS `company_name`,`u`.`Email` AS `email`,`a`.`phone` AS `phone` from ((`carsellonline`.`user` `u` join `carsellonline`.`additional_dealer_data` `a` on(`u`.`Id` = `a`.`userId`)) join `carsellonline`.`advertisement` `a2` on(`u`.`Id` = `a2`.`CreateBy`)) where `u`.`Type` = \'C\'
mariadb-version=100421
