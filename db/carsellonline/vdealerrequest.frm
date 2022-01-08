TYPE=VIEW
query=select `c`.`Id` AS `ComisRequest`,`ad`.`Id` AS `Id`,`ad`.`userId` AS `userId`,`ad`.`company_name` AS `company_name`,`ad`.`nip` AS `nip`,`ad`.`regon` AS `regon`,`ad`.`postal` AS `postal`,`ad`.`street` AS `street`,`ad`.`city` AS `city`,`ad`.`phone` AS `phone`,`u`.`Email` AS `Email`,`u`.`Login` AS `Login` from ((`carsellonline`.`additional_dealer_data` `ad` join `carsellonline`.`comisrequest` `c` on(`ad`.`userId` = `c`.`UserId`)) join `carsellonline`.`user` `u` on(`u`.`Id` = `ad`.`userId`))
md5=174c219223a307bdf9ada70338fa91ed
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=2022-01-04 18:59:26
create-version=2
source=select `c`.`Id`            AS `ComisRequest`,\n       `ad`.`Id`           AS `Id`,\n       `ad`.`userId`       AS `userId`,\n       `ad`.`company_name` AS `company_name`,\n       `ad`.`nip`          AS `nip`,\n       `ad`.`regon`        AS `regon`,\n       `ad`.`postal`       AS `postal`,\n       `ad`.`street`       AS `street`,\n       `ad`.`city`         AS `city`,\n       ad.phone,\n       `u`.`Email`         AS `Email`,\n       `u`.`Login`         AS `Login`\nfrom ((`carsellonline`.`additional_dealer_data` `ad` join `carsellonline`.`comisrequest` `c` on (`ad`.`userId` = `c`.`UserId`))\n         join `carsellonline`.`user` `u` on (`u`.`Id` = `ad`.`userId`))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `c`.`Id` AS `ComisRequest`,`ad`.`Id` AS `Id`,`ad`.`userId` AS `userId`,`ad`.`company_name` AS `company_name`,`ad`.`nip` AS `nip`,`ad`.`regon` AS `regon`,`ad`.`postal` AS `postal`,`ad`.`street` AS `street`,`ad`.`city` AS `city`,`ad`.`phone` AS `phone`,`u`.`Email` AS `Email`,`u`.`Login` AS `Login` from ((`carsellonline`.`additional_dealer_data` `ad` join `carsellonline`.`comisrequest` `c` on(`ad`.`userId` = `c`.`UserId`)) join `carsellonline`.`user` `u` on(`u`.`Id` = `ad`.`userId`))
mariadb-version=100421
