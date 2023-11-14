CREATE TABLE `crypto_info` (
    `crypto_id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `symbol` VARCHAR(10) NOT NULL,
    `current_price` DECIMAL(20,8) NOT NULL,
    `market_cap` BIGINT NOT NULL,
    `circulating_supply` BIGINT NOT NULL,
    `total_supply` BIGINT NULL,
    `max_supply` BIGINT NULL,
    `percent_change_24h` DECIMAL(5,2) NULL,
    `last_updated` DATETIME NOT NULL,
    PRIMARY KEY (`crypto_id`)
);
