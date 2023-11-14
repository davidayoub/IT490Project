CREATE TABLE `inventory` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `crypto_name` VARCHAR(50) NOT NULL,
    `quantity` DECIMAL(16,8) NOT NULL,
    `purchase_price` DECIMAL(16,8) NOT NULL,
    `purchase_date` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);
