TYPE=VIEW
query=select `o`.`dealerId` AS `dealerId`,`o`.`opinion` AS `opinion`,`o`.`feeling` AS `feeling`,`u`.`Login` AS `CreateBy` from (`carsellonline`.`opinion` `o` join `carsellonline`.`user` `u` on(`o`.`opinionAuthor` = `u`.`Id`))
md5=6d6babd79c13d8ec551dd1ef040a3c32
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=2022-01-03 17:14:16
create-version=2
source=SELECT o.dealerId, o.opinion, o.feeling, u.Login as \'CreateBy\' FROM opinion o\nJOIN user u on o.opinionAuthor = u.Id
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `o`.`dealerId` AS `dealerId`,`o`.`opinion` AS `opinion`,`o`.`feeling` AS `feeling`,`u`.`Login` AS `CreateBy` from (`carsellonline`.`opinion` `o` join `carsellonline`.`user` `u` on(`o`.`opinionAuthor` = `u`.`Id`))
mariadb-version=100421
