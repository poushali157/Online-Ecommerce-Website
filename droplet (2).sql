-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 08:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `droplet`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip` varchar(100) NOT NULL,
  `address_type` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user`, `address`, `country`, `state`, `city`, `zip`, `address_type`, `created_at`) VALUES
(10, 1, 'Sector V, DB Block', 'India', 'wb', 'Kolkata', '700008', 'Office', '2025-07-13'),
(14, 3, '4D, Tarini Charan Ghsoh Lane, Kolkata', 'India', 'WB', 'Kolkata', '700003', 'Home', '2025-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_title` varchar(250) NOT NULL,
  `category_description` text NOT NULL,
  `photo` varchar(300) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_title`, `category_description`, `photo`, `created_at`) VALUES
(16, 'Sparkling Adaptogen Drink', 'A fizzy burst of calm and clarity, made with real fruits, turmeric, and powerful adaptogens like ashwagandha and ginseng. Refresh your mind, support stress relief, and enjoy guilt-free bubbles—naturally delicious, zero crash.', '../category_image/category1.jpg', '2025-06-12'),
(17, 'Cold-Pressed Fruit Juices', 'Pure, vibrant, and full of life — our cold-pressed juices are made from fresh fruits like pomegranate, orange, and berries, with no added sugar or preservatives. Packed with vitamins, antioxidants, and natural flavor to energize your day, one refreshing sip at a time.', '../category_image/category2.jpg', '2025-06-12'),
(18, 'HydraVita Powder Mix', 'Stay fresh, focused, and fueled. Our HydraVita Mix blends essential vitamins, electrolytes, and plant extracts into a light, delicious drink—perfect for daily hydration and energy, anytime, anywhere.\r\nInfused with natural flavors and no added sugar, it supports immunity, boosts metabolism, and keeps you glowing from the inside out. Just mix, sip, and feel the difference.', '../category_image/category3.jpg', '2025-06-12'),
(19, 'PowerGlo Smoothies', 'Smooth energy meets radiant wellness. Our PowerGlow Smoothies are crafted with real fruits, nuts, seeds, and natural adaptogens like maca and matcha — giving you sustained energy, mental clarity, and that inner glow.\r\nNo added sugar, no crash—just clean, creamy power in every sip.', '../category_image/category4.jpg', '2025-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(150) NOT NULL,
  `percentage` varchar(150) NOT NULL,
  `exp_date` date NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `percentage`, `exp_date`, `created_on`) VALUES
(1, 'SUMMER20', '20', '2025-07-15', '2025-07-07'),
(2, 'dropletnewbie', '15', '2025-07-31', '2025-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(150) NOT NULL,
  `user` int(11) NOT NULL,
  `order_address` int(11) NOT NULL,
  `order_amount` decimal(10,0) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'order confirmed',
  `coupon` varchar(100) NOT NULL,
  `payment_type` enum('cod','razor') NOT NULL,
  `payment_id` varchar(200) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user`, `order_address`, `order_amount`, `order_status`, `coupon`, `payment_type`, `payment_id`, `payment_status`, `date`) VALUES
(26, '3431454842', 1, 10, 4619, 'order confirmed', 'dropletnewbie', 'cod', 'Cash On Delivery', 'Pending', '2025-07-17'),
(29, '6580500919', 1, 10, 3731, 'Cancelled', 'dropletnewbie', 'razor', 'pay_Qu4NTfJkQUlg7d', 'Cancelled', '2025-07-17'),
(31, '2402876951', 1, 10, 2713, 'order confirmed', 'dropletnewbie', 'razor', 'pay_Qu4YBqAYh84Qr5', 'Paid', '2025-07-17'),
(33, '8778930168', 1, 10, 1696, 'order confirmed', 'dropletnewbie', 'razor', 'pay_QuPDF1ILlJZUV3', 'Paid', '2025-07-18'),
(35, '8588558018', 1, 10, 5216, 'Cancelled', 'dropletnewbie', 'cod', 'Cash On Delivery', 'Cancelled', '2025-07-19'),
(38, '5292975635', 3, 14, 254, 'order confirmed', 'dropletnewbie', 'cod', 'Cash On Delivery', 'Pending', '2025-07-21'),
(39, '8302128104', 3, 14, 3560, 'order confirmed', 'dropletnewbie', 'razor', 'pay_Qvo5kwYrqekiDX', 'Paid', '2025-07-21'),
(41, '8534870268', 3, 14, 5043, 'order confirmed', 'dropletnewbie', 'razor', 'pay_QvoHRCAkxbpIze', 'Paid', '2025-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product`, `quantity`, `date`) VALUES
(35, '3431454842', 13, 4, '2025-07-17'),
(36, '3431454842', 12, 5, '2025-07-17'),
(37, '3431454842', 11, 7, '2025-07-17'),
(41, '6580500919', 14, 5, '2025-07-17'),
(42, '6580500919', 16, 6, '2025-07-17'),
(44, '2402876951', 14, 8, '2025-07-17'),
(47, '8778930168', 14, 4, '2025-07-18'),
(48, '8778930168', 8, 1, '2025-07-18'),
(50, '8588558018', 7, 5, '2025-07-19'),
(51, '8588558018', 12, 9, '2025-07-19'),
(54, '5292975635', 11, 1, '2025-07-21'),
(55, '8302128104', 12, 12, '2025-07-21'),
(57, '8534870268', 15, 4, '2025-07-21'),
(58, '8534870268', 13, 3, '2025-07-21'),
(59, '8534870268', 8, 5, '2025-07-21'),
(60, '8534870268', 10, 5, '2025-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `p_title` varchar(300) NOT NULL,
  `p_description` text NOT NULL,
  `p_price` float NOT NULL DEFAULT 0,
  `company` varchar(300) NOT NULL,
  `m_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `p_img` varchar(300) NOT NULL,
  `about` varchar(1000) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category`, `p_title`, `p_description`, `p_price`, `company`, `m_date`, `exp_date`, `p_img`, `about`, `created_at`) VALUES
(5, 16, 'Droplet Adaptogen Drink - Pretty Happy', 'Infused with Lemon Balm, Passionflower, and Vitamin C, helps with stress relief, mood enhancement, and immune support', 399, 'Droplet', '2025-06-01', '2025-06-28', '../product_image/1749747027droplet-pretty happy.jpg', 'Pretty Happy by Droplet Adaptogen Drink isn’t just about quenching your thirst — it’s about elevating your mood and supporting your mental well-being. Infused with Lemon Balm, renowned for its calming and stress-reducing properties, and Passionflower, a natural herb that helps alleviate anxiety, Pretty Happy helps you feel centered and relaxed. With a burst of Vitamin C, it also supports your immune system, so you can stay healthy, happy, and balanced throughout your day. Enjoy the refreshing flavors while nourishing your body and mind.', '2025-06-12'),
(6, 18, 'Cure Berry Bundle – Plant-Based Electrolyte Drink', 'Packed with organic coconut water, superfruits, and electrolytes, Cure Berry Bundle hydrates, boosts energy, and supports muscle recovery naturally', 349, 'Cure', '2025-06-02', '2025-08-19', '../user_image/1749747693cure-berry bundle.jpg', 'The Cure Berry Bundle is a plant-based electrolyte drink designed to hydrate, replenish, and energize naturally. Infused with organic coconut water, a rich source of electrolytes, and a mix of superfruits like blueberries and strawberries, it helps restore essential nutrients and fluids lost during physical activity or throughout the day. Unlike traditional sports drinks, Cure uses only natural ingredients, free from artificial additives, to ensure you get the cleanest and most effective hydration. Perfect for workouts, post-recovery, or even a refreshing midday boost.', '2025-06-12'),
(7, 18, 'HydraVita Boba Tea Protein - Matcha Latte', 'Combines 20g plant protein, matcha energy, and boba pearls for a delicious, post-workout boost', 599, 'HydraVita', '2025-05-01', '2026-02-09', '../product_image/1749748864hydravita-boba tea.jpg', 'Indulge in the unique fusion of protein, matcha, and boba with HydraVitas Boba Tea Protein - Matcha Latte. This creamy, plant-based protein drink blends the natural energy of matcha green tea, the satisfying chew of boba pearls, and a high-quality protein boost. Not only does it fuel your muscles with 20 g of plant protein, but it also provides a natural caffeine boost to keep you energized without the jitters. Perfect for post-workout recovery, as a snack, or a refreshing mid-day treat, this protein-packed drink helps you stay fueled and focused all day long. Enjoy the benefits of antioxidant-rich matcha and the fun texture of boba, all in one tasty beverage.', '2025-06-12'),
(8, 16, 'Moment Adaptogen Drink - Blueberry Ginger', 'Packed with blueberries, ginger, and adaptogens, Moment Blueberry Ginger boosts immunity and promotes digestive health', 399, 'Moment ', '2025-02-03', '2026-01-08', '../product_image/1749749208moment -blueberry ginger.jpg', 'Experience the perfect blend of blueberry and ginger with Moment Adaptogen Drink – Blueberry Ginger. This refreshing beverage combines the natural antioxidants of blueberries with the anti-inflammatory properties of ginger, offering a powerful boost to your immunity and digestive system. Infused with adaptogens like Ashwagandha and Rhodiola, it helps reduce stress, enhance mental clarity, and support your body in adapting to daily challenges. Whether you are seeking a calming break in your day or an energizing pick-me-up, this drink provides the perfect balance of taste and wellness in every sip.', '2025-06-12'),
(9, 17, 'Suja Organic Beet Blend Juice', 'Combines organic beets, carrots, and ginger to boost energy, support detox, and improve circulation', 349, 'Suja Organic', '2025-03-11', '2026-01-12', '../product_image/1749749877suja organic-beet blend juice.jpg', 'Elevate your health with Suja Organic Beet Blend Juice, a nutrient-packed beverage that supports detoxification, boosts energy, and enhances endurance. Crafted with organic beets, carrots, and a touch of ginger, this juice is rich in antioxidants and essential vitamins, making it the perfect drink for a natural energy boost. Beets are well-known for their ability to improve blood circulation and enhance stamina, while ginger aids digestion and reduces inflammation. Whether you are looking to detox or just enjoy a refreshing, naturally sweet drink, this beet blend will nourish your body and rejuvenate your spirit.\r\n\r\n', '2025-06-12'),
(10, 19, 'Revive Superfoods Raspberry & Mango Smoothie', 'Packed with raspberries, mangoes, and antioxidants, Revive Superfoods Raspberry & Mango Smoothie', 349, 'Revive Superfoods', '2025-04-15', '2025-11-22', '../product_image/1749750435smoothie - raspberry and mango drink.jpg', 'Indulge in the natural goodness of Revive Superfoods Raspberry & Mango Smoothie — a tropical blend packed with vitamins, minerals, and antioxidants. This smoothie combines the tangy goodness of raspberries with the sweet, juicy flavor of mangoes, creating a delicious drink that supports immune health, promotes digestive wellness, and boosts your energy. Rich in fiber, vitamin C, and anti-inflammatory compounds, this smoothie helps you stay nourished and revitalized. It’s the perfect grab-and-go drink for a quick breakfast, post-workout recovery, or anytime you need a refreshing, nutrient-packed boost.', '2025-06-12'),
(11, 17, 'MamaBear Orange Juice', 'packed with organic vitamin C, supporting immunity and providing a natural, refreshing boost of energy', 299, 'MamaBear', '2025-04-10', '2026-03-23', '../product_image/1749754522cold pressed- orange juice.jpg', 'Start your day with a refreshing glass of MamaBear Orange Juice, made from 100% organic, hand-picked oranges. Rich in vitamin C, this juice is not only delicious but also helps support your immune system, promoting healthy skin and fighting off free radicals. Free from added sugars, preservatives, or artificial flavoring, MamaBear ensures you get all the natural goodness and freshness in every sip. Perfect for breakfast, a mid-day energy boost, or an immune-supporting refreshment, this pure orange juice is a wholesome way to hydrate and energize your body.', '2025-06-13'),
(12, 19, 'Revive Superfoods Apple & Black Tea Smoothie', 'Packed with apple, black tea, and antioxidants, boosts energy, supports digestion, and enhances focus', 349, ' Revive Superfoods', '2025-06-02', '2026-01-28', '../product_image/1749755732revive superfood-apple & tea smoothie.jpg', 'Revitalize your body with the refreshing and invigorating blend of apple and black tea in Revive Superfoods Apple & Black Tea Smoothie. This smoothie is packed with natural antioxidants from black tea and fiber from apples, helping to boost your energy, improve metabolism, and support digestion. Rich in polyphenols and vitamin C, it’s a great option for enhancing your immune system, increasing focus, and fueling your day with sustainable energy. The combination of caffeine from black tea and the natural sweetness of apples gives you a smooth, revitalizing drink to power through your busy routine, whether you need a morning kick-start or an afternoon pick-me-up.', '2025-06-13'),
(13, 17, 'NutriSeed Apple Kale Fusion', 'Packed with apple, kale, and cucumber, that hydrates, detoxifies, and energizes your body naturally', 399, 'NutriSeed', '2025-06-11', '2026-03-27', '../product_image/1749756212juice -nutriseed.jpg', 'Start your day the clean way with NutriSeed Apple Kale Fusion, a revitalizing juice made from apple, kale, and cucumber. This nutrient-rich blend is designed to hydrate, detoxify, and refresh your body with its natural goodness. Kale offers a dose of antioxidants and vitamin K, while cucumber helps to naturally flush out toxins and keep you hydrated. Apple adds a touch of natural sweetness and enhances the immune system with its vitamin C content. Whether you’re looking to cleanse your system, boost your energy, or maintain healthy digestion, this green detox juice offers the perfect balance of taste and wellness to nourish your body from the inside out.', '2025-06-13'),
(14, 16, 'Moment Strawberry Chamomile Adaptogen Drink', 'Combines adaptogens, chamomile, and strawberry to reduce stress, enhance mood, and support relaxation', 399, 'Moment', '2025-02-22', '2026-03-25', '../product_image/1749756932moment- strawberry.jpg', 'Unwind and recharge with Moment Strawberry Chamomile Adaptogen Drink, a unique blend of adaptogenic herbs and stress-relieving ingredients designed to bring balance to your body and mind. Infused with the calming properties of chamomile and enhanced by the antioxidant-rich sweetness of strawberry, this drink works to reduce stress, improve mood, and support overall relaxation. The adaptogens in this formula help your body manage stress and restore equilibrium, making it the perfect drink to enjoy after a hectic day or whenever you need a moment of peace. Packed with natural ingredients, this drink is your go-to for relaxation, rejuvenation, and stress relief, promoting better sleep and overall well-being.', '2025-06-13'),
(15, 18, 'Cure Kiwi Splash - Plant-Based Electrolyte Drink', 'Plant-based electrolyte boost with kiwi to hydrate, replenish, and energize naturally', 249, 'Cure', '2025-04-19', '2026-02-18', '../product_image/1749760073cure - kwiwi.jpg', 'Quench your thirst and revitalize your body with Kiwi Splash by Cure, a delicious plant-based electrolyte drink packed with the tangy goodness of kiwi. This refreshing beverage is designed to replenish your body with essential electrolytes, keeping you hydrated, energized, and ready to take on the day. With natural ingredients, Kiwi Splash offers a perfect balance of hydration and flavor, giving you a crisp, fruity taste while supporting your wellness journey. Ideal for post-workout recovery, long days in the sun, or whenever you need to stay hydrated, this drink delivers the benefits of potassium, magnesium, and calcium, helping you maintain healthy hydration levels and balance. Clean, refreshing, and energizing — Kiwi Splash is your go-to hydration companion!', '2025-06-13'),
(16, 19, 'Daily Harvest Mint Cocoa Bliss Smoothie', 'Blends mint and cocoa for a refreshing, antioxidant-rich, and energizing treat', 399, 'Daily Harvest', '2025-06-05', '2026-02-18', '../product_image/1749761326smoothie - daily harvest.jpg', 'Indulge in the perfect balance of mint and rich cocoa with the Mint Cocoa Bliss Smoothie from Daily Harvest. This smoothie combines the cooling freshness of mint with the deep, comforting taste of cocoa, creating a refreshing yet indulgent treat. Packed with plant-based nutrients, this smoothie is loaded with fiber, antioxidants, and natural sweetness, making it the ideal option for a post-workout refreshment or a nutritious snack. Simply blend with water or your favorite milk, and enjoy the nourishing goodness of mint, cocoa, and other wholesome ingredients in every sip. Feel the burst of energy and calm all in one.', '2025-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `user_type` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'EuphoriaGenx', 'euphoriagenx@gmail.com', '$2y$10$bmbDHhmHLkidvN2NEJUUQOmEMDzlNDYChiaeOOZBeR4pOAEfZaddu', 'customer', '2025-05-14 23:56:21'),
(2, 'Admin', 'admin@gmail.com', '$2y$10$FyDTUMsmVRMRiaWQhUvZaOfF9mZtvgof1p3oPtDR2h4j8kUo8D6Gu', 'admin', '2025-05-16 00:11:53'),
(3, 'Poushali Ghata', 'poushalighata@gmail.com', '$2y$10$c8Q5Kg.VcGlAMLSRNY2CFulRBlr31xIDYwi770sg5jTPjBDVW1Rrq', 'customer', '2025-07-11 10:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ph_no` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(100) NOT NULL,
  `img` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `ph_no`, `dob`, `gender`, `img`, `date`) VALUES
(5, 1, '2147483647', '2025-07-02', 'female', '../user_image/euphoria.jpg', '2025-07-13'),
(8, 3, '8583894995', '2003-10-19', 'female', '../user_image/IMG-20241011-WA0142.jpg', '2025-07-18'),
(9, 2, '9432668595', '2025-07-04', 'female', '../user_image/WhatsApp Image 2025-02-06 at 00.58.31_fcc47bc8.jpg', '2025-07-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK4` (`user`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK1` (`user`),
  ADD KEY `FK2` (`product`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `FK5` (`user`),
  ADD KEY `FK6` (`order_address`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK7` (`order_id`),
  ADD KEY `FK8` (`product`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign Key` (`category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK9` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK4` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK2` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK5` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK6` FOREIGN KEY (`order_address`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `FK7` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK8` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `FK9` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
