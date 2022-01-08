TYPE=VIEW
query=select `a`.`Id` AS `Id`,`ad`.`advertisementId` AS `advertisementId`,`a`.`Title` AS `Title`,`a`.`Description` AS `Description`,`a`.`Price` AS `Price`,`c`.`Name` AS `brand`,`ad`.`model` AS `model`,`ad`.`engine_size` AS `engine_size`,`ad`.`engine_power` AS `engine_power`,`ad`.`distance` AS `distance`,`a`.`CreateBy` AS `CreateBy`,`a`.`CreateDate` AS `CreateDate` from ((`carsellonline`.`advertisement` `a` join `carsellonline`.`advertisement_detail` `ad` on(`a`.`Id` = `ad`.`advertisementId`)) join `carsellonline`.`carbrand` `c` on(`ad`.`carBrandId` = `c`.`Id`))
md5=a5ef1ef79353d73877e83e44e4d53d30
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=2021-12-29 20:39:31
create-version=2
source=SELECT a.Id, advertisementId, a.Title, a.Description, a.Price,  c.Name as \'brand\', model, engine_size, engine_power, distance,  a.CreateBy, a.CreateDate\n    FROM advertisement a\n    JOIN advertisement_detail ad on a.Id = ad.advertisementId\n    JOIN carbrand c on ad.carBrandId = c.Id
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `a`.`Id` AS `Id`,`ad`.`advertisementId` AS `advertisementId`,`a`.`Title` AS `Title`,`a`.`Description` AS `Description`,`a`.`Price` AS `Price`,`c`.`Name` AS `brand`,`ad`.`model` AS `model`,`ad`.`engine_size` AS `engine_size`,`ad`.`engine_power` AS `engine_power`,`ad`.`distance` AS `distance`,`a`.`CreateBy` AS `CreateBy`,`a`.`CreateDate` AS `CreateDate` from ((`carsellonline`.`advertisement` `a` join `carsellonline`.`advertisement_detail` `ad` on(`a`.`Id` = `ad`.`advertisementId`)) join `carsellonline`.`carbrand` `c` on(`ad`.`carBrandId` = `c`.`Id`))
mariadb-version=100421
