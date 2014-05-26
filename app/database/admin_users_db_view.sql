CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `admin_users` AS
    (select 
        `user`.`user_id` AS `user_id`,
        `user`.`username` AS `username`,
        `user`.`password` AS `password`,
        `user`.`email` AS `email`,
        `user`.`retailer_id` AS `retailer_id`,
        `user`.`remember_token` AS `remember_token`,
        `user`.`created_at` AS `created_at`,
        `user`.`updated_at` AS `updated_at`
    from
        `user`
    where
        isnull(`user`.`retailer_id`))