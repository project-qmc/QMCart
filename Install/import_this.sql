CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` tinytext NOT NULL,
  `product_img_name` varchar(60) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `hidden` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `orders` (
  `name`varchar(255) DEFAULT 'None',
  `formatted_address`varchar(255)DEFAULT 'None',
  `postal_code`varchar(255)DEFAULT 'None',
  `sublocality`varchar(255)DEFAULT 'None',
  `country_short`varchar(255)DEFAULT 'None',
  `street_number` int(11) DEFAULT '123',
  `locality`varchar(255)DEFAULT 'None',
  `country`varchar(255)DEFAULT 'None',
  `state`varchar(255)DEFAULT 'None',
  `coin_address`varchar(255)NOT NULL,
  `email`varchar(255)NOT NULL,
  `order_number` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `product_img_name`, `price`) VALUES (1, "PD1001", "Some Product", "Great stuff" ,"scratchcard.jpg", 200.50);

INSERT INTO `orders` (`name`, `email`, `coin_address`) VALUES ("test", "test@test.com", "Qfxu6TjMXJsfSyce1ufWj2uVcoAALrRhmS");

