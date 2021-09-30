-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 9 月 30 日 20:09
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gsacs_d03_05`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `product_todo_table`
--

CREATE TABLE `product_todo_table` (
  `id` int(12) NOT NULL,
  `todo` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `product_todo_table`
--

INSERT INTO `product_todo_table` (`id`, `todo`, `reason`, `deadline`, `created_at`, `updated_at`) VALUES
(34, 'GGAに出場する', '目に見える成果を残すため', '2022-01-20', '2021-09-29 07:01:25', '2021-09-29 07:01:25'),
(36, '見た目わからん', '動く', '2021-10-08', '2021-10-01 02:58:48', '2021-10-01 02:58:48');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `product_todo_table`
--
ALTER TABLE `product_todo_table`
  ADD UNIQUE KEY `id` (`id`,`todo`,`reason`,`deadline`,`created_at`,`updated_at`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `product_todo_table`
--
ALTER TABLE `product_todo_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
