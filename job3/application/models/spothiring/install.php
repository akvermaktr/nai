<?php
exit();

?>

CREATE TABLE `service_spot_users` 
( `ss_id` INT(11) NOT NULL AUTO_INCREMENT ,
`ss_name` VARCHAR(50) NULL ,
`ss_mobile_no` VARCHAR(12) NULL , 
`ss_department` INT(20) NULL ,
`ss_custom_fields` VARCHAR(50) NULL ,
PRIMARY KEY (`ss_id`)) ENGINE = InnoDB;


CREATE TABLE `ecommercedgsnd`.`service_spot_rides` ( `ssr_id` INT NOT NULL AUTO_INCREMENT , `ssr_pickup_location` INT NOT NULL , `ssr_drop_location` INT NOT NULL , `ssr_distance` INT NOT NULL , `ssr_pickup_time` INT NOT NULL , `ssr_droping_time` INT NOT NULL , PRIMARY KEY (`ssr_id`)) ENGINE = InnoDB;


CREATE TABLE `ecommercedgsnd`.`service_spot_user_api_status` ( `sua_id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT , `sua_u_id` INT(10) NOT NULL , `sua_api_id` INT(10) NOT NULL , `sua_status` int(2) NOT NULL DEFAULT 0) ENGINE = InnoDB 



ALTER TABLE `service_spot_users` ADD UNIQUE( `ss_mobile_no`, `ss_email`)

-- Users should not be authorized For spot hiring without existing ORDER ID. 
ALTER TABLE `service_spot_users` ADD `ss_order_id` INT(10) NOT NULL COMMENT 'Order ID from where user are authorized for Spot Hiring.' AFTER `ss_status`;
ALTER TABLE `service_spot_users` CHANGE `ss_order_id` `ss_order_id` VARCHAR(20) NOT NULL COMMENT 'Order ID from where user are authorized for Spot Hiring.';



-- 
CREATE TRIGGER AFTER INSERT INTO spot_spot_api insert into service_spot_user_api_status
-- to make sure if new services provider Add new api with name "add_emp" 
-- User will be available only if service provider's api has been approved by Admin. 

DELIMITER //

CREATE TRIGGER spot_api_after_update
AFTER UPDATE
   ON spot_spot_api FOR EACH ROW

BEGIN
    DECLARE API_ID INT;
    DECLARE PROVIDER_ID INT; 
   -- variable declarations
   SELECT * FROM SERVICE_SPOT_USERS;
   
    API_ID := NEW.api_id; 
   
   INSERT INTO service_spot_user_api_status ( sua_u_id , sua_api_id , sua_status ) ( select     1 , 2 , 3    ) ; 
   
   -- trigger code

END; //
DELIMITER ;



-----------------------
delimiter #


DROP TRIGGER IF EXISTS `spot_api_after_update`;CREATE DEFINER=`root`@`localhost` TRIGGER `spot_api_after_update` AFTER UPDATE ON `service_spot_api` FOR EACH ROW 
begin

SET @COUNT=( 
 SELECT count(*)   FROM service_spot_users ss WHERE ss.ss_id not in (select sua.sua_u_id from service_spot_user_api_status sua where sua.sua_api_id = New.api_id )

);

    IF @COUNT > 0 && New.api_name = "add_emp" THEN
    
insert into service_spot_user_api_status ( sua_u_id , sua_api_id , sua_status ) (SELECT ss.ss_id ,New.api_id , 0   FROM service_spot_users ss WHERE ss.ss_id not in (select sua.sua_u_id from service_spot_user_api_status sua INNER JOIN service_spot_api api on sua.sua_api_id = api.api_id where api.api_name = "add_emp" and api.api_sp_user_id =  New.api_sp_user_id)) ;
    END IF;
end #

DELIMITER ;



-- Add Foregin key 
alter table `service_spot_invoiced_rides` ADD FOREIGN KEY (sir_invoice_id) REFERENCES service_spot_invoice(ssi_id)


0=> draft,
1=> pending for approval, 
2=> Recommened for Payment, 
3=> Approved By DDO,
4=> Paid, 
5=> Returned by DDO, 
6=> paid offline, 
