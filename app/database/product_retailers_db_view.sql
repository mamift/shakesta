CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `product_retailers` AS
    select 
        `product`.`product_id` AS `product_id`,
        `product`.`title` AS `title`,
        `product`.`description` AS `description`,
        `product`.`retailer_id` AS `retailer_id`,
        `product`.`retail_price` AS `retail_price`,
        `product`.`image` AS `image`,
        `product`.`image_url` AS `image_url`,
        `product`.`created_at` AS `created_at`,
        `product`.`updated_at` AS `updated_at`,
        `retailer`.`title` AS `retailer`
    from
        (`product`
        join `retailer` ON ((`product`.`retailer_id` = `retailer`.`retailer_id`)))