CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `product_deals` AS
    select 
        `deal`.`deal_id` AS `id`,
        `deal`.`product_id` AS `product_id`,
        `deal`.`price_discount` AS `price_discount`,
        `deal`.`terms` AS `terms`,
        `deal`.`expires_time` AS `expires_time`,
        `deal`.`begins_time` AS `begins_time`,
        `deal`.`category` AS `category`,
        `deal`.`created_at` AS `created_at`,
        `deal`.`updated_at` AS `updated_at`,
        `product`.`title` AS `product_title`,
        `product`.`description` AS `product_description`,
        `product`.`retail_price` AS `original_price`,
        `product`.`image_url` AS `image_url`
    from
        (`deal`
        join `product` ON ((`product`.`product_id` = `deal`.`product_id`)))