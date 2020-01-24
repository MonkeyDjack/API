-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 24 2020 г., 15:08
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `studentgrades`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_classes`
--

CREATE TABLE `tbl_classes` (
  `ClassID` int(11) NOT NULL,
  `ClassName` varchar(50) NOT NULL,
  `SemesterID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tbl_classes`
--

INSERT INTO `tbl_classes` (`ClassID`, `ClassName`, `SemesterID`) VALUES
(1, 'Information Management', 3),
(2, 'PHP 2', 2),
(3, 'Java 2', 1),
(4, 'FED', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_grades`
--

CREATE TABLE `tbl_grades` (
  `StudentID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `SemesterID` int(11) NOT NULL,
  `Grade` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tbl_grades`
--

INSERT INTO `tbl_grades` (`StudentID`, `ClassID`, `SemesterID`, `Grade`) VALUES
(1, 1, 1, 6),
(1, 4, 2, 7),
(4, 4, 2, 7),
(3, 1, 2, 8),
(2, 3, 3, 7),
(2, 4, 2, 10),
(3, 4, 3, 10),
(3, 4, 3, 9),
(4, 3, 3, 7),
(1, 2, 2, 4),
(2, 1, 2, 5),
(1, 3, 3, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_semesters`
--

CREATE TABLE `tbl_semesters` (
  `SemesterID` int(11) NOT NULL,
  `Semester` varchar(20) NOT NULL,
  `StartDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tbl_semesters`
--

INSERT INTO `tbl_semesters` (`SemesterID`, `Semester`, `StartDate`) VALUES
(1, 'period 1', '2019-09-01'),
(2, 'period 2', '2019-11-11'),
(3, 'period 3', '2020-02-03'),
(4, 'period 4', '2020-05-20');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_students`
--

CREATE TABLE `tbl_students` (
  `studentID` int(11) NOT NULL,
  `studentFirstName` varchar(50) NOT NULL,
  `studentLastName` varchar(50) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Zip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tbl_students`
--

INSERT INTO `tbl_students` (`studentID`, `studentFirstName`, `studentLastName`, `dateOfBirth`, `Age`, `Gender`, `Address`, `City`, `Zip`) VALUES
(1, 'Muhitdin', 'Yahya', '2001-01-08', 19, 'male', 'peyeserhof 57', 'Emmen', '7824CN'),
(2, 'Alex', 'Skorjak', '1998-10-31', 21, 'male', 'Peyserhof 57', 'Emmen', '2343'),
(3, 'Nastya', 'Sokolova', '2001-03-10', 19, 'female', 'hoitengeshlag 23', 'Emmen', '32432'),
(4, 'Octavian', 'Dragu', '1997-01-31', 24, 'male', 'weytacker 54', 'Emmen', '23432');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `SemesterID` (`SemesterID`);

--
-- Индексы таблицы `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD KEY `ClassID` (`ClassID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `tbl_grades_ibfk_2` (`SemesterID`);

--
-- Индексы таблицы `tbl_semesters`
--
ALTER TABLE `tbl_semesters`
  ADD PRIMARY KEY (`SemesterID`);

--
-- Индексы таблицы `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`studentID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tbl_classes`
--
ALTER TABLE `tbl_classes`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tbl_semesters`
--
ALTER TABLE `tbl_semesters`
  MODIFY `SemesterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD CONSTRAINT `tbl_classes_ibfk_1` FOREIGN KEY (`SemesterID`) REFERENCES `tbl_semesters` (`SemesterID`);

--
-- Ограничения внешнего ключа таблицы `tbl_grades`
--
ALTER TABLE `tbl_grades`
  ADD CONSTRAINT `tbl_grades_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `tbl_classes` (`ClassID`),
  ADD CONSTRAINT `tbl_grades_ibfk_2` FOREIGN KEY (`SemesterID`) REFERENCES `tbl_classes` (`SemesterID`),
  ADD CONSTRAINT `tbl_grades_ibfk_3` FOREIGN KEY (`StudentID`) REFERENCES `tbl_students` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
