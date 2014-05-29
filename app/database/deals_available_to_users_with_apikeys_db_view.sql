CREATE 
VIEW `deals_available_to_users_with_apikeys` AS
    select distinct
        `product_deals_retailers`.`id` AS `id`,
        `product_deals_retailers`.`product_id` AS `product_id`,
        `product_deals_retailers`.`price_discount` AS `price_discount`,
        `product_deals_retailers`.`terms` AS `terms`,
        `product_deals_retailers`.`expires_time` AS `expires_time`,
        `product_deals_retailers`.`begins_time` AS `begins_time`,
        `product_deals_retailers`.`category` AS `category`,
        `product_deals_retailers`.`created_at` AS `created_at`,
        `product_deals_retailers`.`updated_at` AS `updated_at`,
        `product_deals_retailers`.`product_title` AS `product_title`,
        `product_deals_retailers`.`product_description` AS `product_description`,
        `product_deals_retailers`.`original_price` AS `original_price`,
        `product_deals_retailers`.`image_url` AS `image_url`,
        `product_deals_retailers`.`retailer_id` AS `retailer_id`,
        `product_deals_retailers`.`retailer` AS `retailer`,
        `user_apikeys_retailers`.`retailer_id` AS `retailer_apikey`
    from
        (`product_deals_retailers`
        join `user_apikeys_retailers`)
    where
        (`product_deals_retailers`.`retailer_id` = `user_apikeys_retailers`.`retailer_id`)