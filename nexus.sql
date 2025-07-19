-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 19, 2025 at 08:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `KnowledgeForum`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bookmark`
--

CREATE TABLE `Bookmark` (
  `bookmark_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Bookmark`
--

INSERT INTO `Bookmark` (`bookmark_id`, `user_id`, `post_id`) VALUES
(12, 14, 47),
(13, 12, 52),
(14, 14, 57),
(15, 12, 58),
(16, 14, 60);

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`comment_id`, `comment_text`, `likes`, `dislikes`, `user_id`, `post_id`) VALUES
(9, 'comment', 0, 0, 12, 47),
(11, 'comment', 0, 0, 14, 47),
(12, 'question', 0, 0, 12, 57);

-- --------------------------------------------------------

--
-- Table structure for table `Group_Message`
--

CREATE TABLE `Group_Message` (
  `grp_id` int(11) NOT NULL,
  `grp_name` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  `sender_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE `Message` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(1, 12, 14, 'hi ', '2025-06-28 11:02:59'),
(2, 12, 14, 'read that file i sent ?', '2025-06-28 11:03:26'),
(3, 14, 12, 'yeah i did ', '2025-06-28 11:04:07'),
(4, 14, 12, 'great article ', '2025-06-28 11:04:38'),
(5, 14, 12, 'https://www.youtube.com/shorts/kg_8F8ep86Y', '2025-06-28 11:04:49'),
(6, 13, 12, 'that dev team of assassins creed is so great. i cant wait to play that game', '2025-06-28 11:11:52'),
(7, 13, 12, 'hey', '2025-06-28 11:19:54'),
(8, 13, 12, 'https://www.youtube.com/shorts/kg_8F8ep86Y', '2025-06-28 11:40:23'),
(9, 13, 12, 'DSA (Data Structures and Algorithms) is the study of organizing data efficiently using data structures like arrays, stacks, and trees, paired with step-by-step procedures (or algorithms) to solve problems effectively. Data structures manage how data is stored and accessed, while algorithms focus on processing this data.  Why to Learn DSA? Learning DSA boosts your problem-solving abilities and make you a stronger programmer. DSA is foundation for almost every software like GPS, Search Engines, AI ChatBots, Gaming Apps, Databases, Web Applications, etc Top Companies like Google, Microsoft, Amazon, Apple, Meta and many other heavily focus on DSA in interviews. Do you know the basics already and looking to prepare in limited time?    Try our free course GfG 160 where we have 160 most asked problems along with well written editorials and video explanations. The course also has 90 bonus problems.  How to learn DSA? Learn at-least one programming language (C++, Java, Python or JavaScript) and build your basic logic. Learn about Time and Space complexities Learn Data Structures (Arrays, Linked List, etc) and Algorithms (Searching, Sorting, etc). Once you learn main topics, it is important to solve coding problems against some predefined test cases, Solve problems daily using GfG Problem of the Day 5-Steps-to-learn-DSA-from-scratch Hoping you have learned a programming language of your choice, here comes the next stage of the roadmap - Learn about Time and Space Complexities.  1. Logic Building Once you have learned basics of a programming language, it is recommended that you learn basic logic building  Logic Building Guide Quiz on Logic Building 2. Learn about Complexities To analyze algorithms, we mainly measure order of growth of time or space taken in terms of input size. We do this in the worst case scenario in most of the cases. Please refer the below links for a clear understanding of these concepts.  Complexity Analysis Guide Quiz on Complexity Analysis 3. Array Array is a linear data structure where elements are allocated contiguous memory, allowing for constant-time access.  Array Data Structure Guide Quiz on Arrays 4. Searching Algorithms Searching algorithms are used to locate specific data within a large set of data. It helps find a target value within the data. There are various types of searching algorithms, each with its own approach and efficiency.  Searching Algorithms Guide Quiz on Searching 5. Sorting Algorithm Sorting algorithms are used to arrange the elements of a list in a specific order, such as numerical or alphabetical. It organizes the items in a systematic way, making it easier to search for and access specific elements.  Sorting Algorithms Guide Quiz on Sorting 6. Hashing Hashing is a technique that generates a fixed-size output (hash value) from an input of variable size using mathematical formulas called hash functions. Hashing is commonly used in data structures for efficient searching, insertion and deletion.  Hashing Guide Quiz on Hashing 7. Two Pointer Technique In Two Pointer Technique, we typically use two index variables from two corners of an array. We use the two pointer technique for searching a required point or value in an array.  Two Pointer Technique Quiz on Two Pointer Technique 8. Window Sliding Technique In Window Sliding Technique, we use the result of previous subarray to quickly compute the result of current.  Window Sliding Technique Quiz on Sliding Window', '2025-06-28 11:40:54'),
(10, 12, 14, 'hi', '2025-06-29 10:45:41'),
(13, 12, 13, 'this is gonna be a normal year', '2025-07-19 12:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `Personal_Message`
--

CREATE TABLE `Personal_Message` (
  `message_id` int(11) NOT NULL,
  `sent_time` datetime DEFAULT current_timestamp(),
  `message` text DEFAULT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `receiver_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

CREATE TABLE `Post` (
  `post_id` int(11) NOT NULL,
  `post_text` text DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Post`
--

INSERT INTO `Post` (`post_id`, `post_text`, `likes`, `dislikes`, `title`, `state`, `user_id`) VALUES
(47, 'big text big text big text ', 1, 1, 'title', NULL, 12),
(52, '1', 3, 0, '1', NULL, 14),
(55, 'n', 0, 0, 'b', NULL, 14),
(57, 'The knapsack problem is a classic optimization problem where you need to select items with associated weights and values to maximize the total value within a given weight capacity (the \"knapsack\"). It\'s a common problem in computer science, logistics, and resource allocation. \r\nHere\'s a breakdown of the core concepts:\r\nProblem Definition:\r\nItems: A set of items, each with a weight and a value. \r\nKnapsack Capacity: A maximum weight limit for the knapsack. \r\nGoal: Select a subset of items that maximizes the total value without exceeding the knapsack\'s weight capacity. \r\nTypes of Knapsack Problems:\r\n0/1 Knapsack:\r\nEach item can be either fully included or excluded (no fractions allowed). This is the most common version. \r\nFractional Knapsack:\r\nYou can take fractions of items. This allows for greater flexibility in filling the knapsack, and can be solved using a greedy approach. \r\nBounded/Unbounded Knapsack:\r\nIn the bounded knapsack, there is a limit to the number of instances of each item. In the unbounded knapsack, there is no limit. \r\nAlgorithms for Solving:\r\nDynamic Programming:\r\nThis is a common approach for solving the 0/1 knapsack problem. It builds a table to store the maximum value achievable for different knapsack capacities and subsets of items. \r\nGreedy Algorithm:\r\nFor the fractional knapsack problem, the greedy approach (sorting items by value-to-weight ratio and picking the most profitable ones first) provides an optimal solution. \r\nBranch and Bound:\r\nThis method explores possible solutions by dividing the problem into subproblems, and it can be more efficient than brute force for larger datasets. \r\nExample:\r\nImagine you have a knapsack with a capacity of 50kg and the following items: \r\nItem\r\nWeight (kg)\r\nValue ($)\r\nA\r\n10\r\n60\r\nB\r\n20\r\n100\r\nC\r\n30\r\n120\r\nIf it\'s a 0/1 knapsack, the dynamic programming approach might be used to determine that including items A and B (total weight 30kg, total value $160) is the optimal solution. Taking items A and C would exceed the capacity, and taking just item C would yield a lower total value. \r\n', 1, 0, 'knapsack problem', NULL, 12),
(58, 'project show', 0, 1, 'SAD', NULL, 14),
(60, 'kdbakbad', 1, 0, 'hdoadha', NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `Post_to_Tag`
--

CREATE TABLE `Post_to_Tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Post_to_Tag`
--

INSERT INTO `Post_to_Tag` (`post_id`, `tag_id`) VALUES
(55, 40),
(57, 42),
(58, 36);

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--

CREATE TABLE `Reports` (
  `report_id` int(11) NOT NULL,
  `report_text` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Reputation`
--

CREATE TABLE `Reputation` (
  `user_id` int(11) NOT NULL,
  `points` int(11) DEFAULT 0,
  `rank` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

CREATE TABLE `Tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Tag`
--

INSERT INTO `Tag` (`tag_id`, `tag_name`) VALUES
(36, 'sad course'),
(38, 'Human-Computer Interaction'),
(39, 'chemistry'),
(40, 'AI'),
(41, 'statistics'),
(42, 'data structure and algorithm'),
(43, 'DSA'),
(44, 'Machine Learning'),
(45, 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_on_site` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `name`, `email`, `role_on_site`, `password`) VALUES
(12, 'manzil mahim', 'manzilahsan8105@gmail.com', 'regular', '1234'),
(13, 'manzil', 'm@gmail.com', 'regular', '1234'),
(14, 'ashik', 'ashi@gmail.com', 'regular', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `User_Likes_Dislikes`
--

CREATE TABLE `User_Likes_Dislikes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `action` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Likes_Dislikes`
--

INSERT INTO `User_Likes_Dislikes` (`id`, `user_id`, `post_id`, `action`, `created_at`) VALUES
(21, 14, 47, 'dislike', '2025-06-22 06:02:28'),
(22, 14, 52, 'like', '2025-06-28 05:03:55'),
(23, 13, 52, 'like', '2025-06-28 05:11:24'),
(24, 12, 52, 'like', '2025-06-28 06:44:57'),
(25, 12, 57, 'like', '2025-06-29 06:03:13'),
(26, 12, 58, 'dislike', '2025-06-29 06:05:38'),
(27, 14, 60, 'like', '2025-07-19 06:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `User_Reactions`
--

CREATE TABLE `User_Reactions` (
  `reaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `reaction` enum('like','dislike') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bookmark`
--
ALTER TABLE `Bookmark`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `Group_Message`
--
ALTER TABLE `Group_Message`
  ADD PRIMARY KEY (`grp_id`),
  ADD KEY `sender_user_id` (`sender_user_id`);

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `Personal_Message`
--
ALTER TABLE `Personal_Message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_user_id` (`sender_user_id`),
  ADD KEY `receiver_user_id` (`receiver_user_id`);

--
-- Indexes for table `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Post_to_Tag`
--
ALTER TABLE `Post_to_Tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `Reports`
--
ALTER TABLE `Reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `Reputation`
--
ALTER TABLE `Reputation`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `Tag`
--
ALTER TABLE `Tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `User_Likes_Dislikes`
--
ALTER TABLE `User_Likes_Dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `User_Reactions`
--
ALTER TABLE `User_Reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bookmark`
--
ALTER TABLE `Bookmark`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Group_Message`
--
ALTER TABLE `Group_Message`
  MODIFY `grp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Message`
--
ALTER TABLE `Message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Personal_Message`
--
ALTER TABLE `Personal_Message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Post`
--
ALTER TABLE `Post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `Reports`
--
ALTER TABLE `Reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tag`
--
ALTER TABLE `Tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `User_Likes_Dislikes`
--
ALTER TABLE `User_Likes_Dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `User_Reactions`
--
ALTER TABLE `User_Reactions`
  MODIFY `reaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Bookmark`
--
ALTER TABLE `Bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Post` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Post` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `Group_Message`
--
ALTER TABLE `Group_Message`
  ADD CONSTRAINT `group_message_ibfk_1` FOREIGN KEY (`sender_user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Personal_Message`
--
ALTER TABLE `Personal_Message`
  ADD CONSTRAINT `personal_message_ibfk_1` FOREIGN KEY (`sender_user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `personal_message_ibfk_2` FOREIGN KEY (`receiver_user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `Post_to_Tag`
--
ALTER TABLE `Post_to_Tag`
  ADD CONSTRAINT `post_to_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Post` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_to_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `Tag` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `Reports`
--
ALTER TABLE `Reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Post` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `Reputation`
--
ALTER TABLE `Reputation`
  ADD CONSTRAINT `reputation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `User_Likes_Dislikes`
--
ALTER TABLE `User_Likes_Dislikes`
  ADD CONSTRAINT `user_likes_dislikes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`),
  ADD CONSTRAINT `user_likes_dislikes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Post` (`post_id`);

--
-- Constraints for table `User_Reactions`
--
ALTER TABLE `User_Reactions`
  ADD CONSTRAINT `user_reactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_reactions_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Post` (`post_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
