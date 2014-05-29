CREATE 
VIEW `user_apikeys_retailers` AS
    select 
        `user`.`username` AS `username`,
        `user`.`apikey` AS `apikey`,
        `user`.`retailer_id` AS `retailer_id`,
        `retailer`.`title` AS `title`
    from
        (`user`
        join `retailer` ON ((`user`.`retailer_id` = `retailer`.`retailer_id`)))
    where
        (`user`.`retailer_id` is not null)