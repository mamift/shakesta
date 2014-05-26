CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `retail_users` AS
    select distinct
        `user`.`user_id` AS `user_id`,
        `user`.`username` AS `username`,
        `user`.`email` AS `email`,
        `user`.`retailer_id` AS `retailer_id`,
		COUNT(*) AS `isAdmin`,
        `retailer`.`title` AS `retailer`,
        `retailer`.`description` AS `retailer_description`,
        `user`.`created_at` AS `created_at`,
        `user`.`updated_at` AS `updated_at`
    from
        (`user` `users_table`
        join (`retailer`
        join `user` ON ((`user`.`retailer_id` = `retailer`.`retailer_id`))))