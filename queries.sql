USE `schema`;

INSERT INTO `users` (`name`, `email`, `passwordhash`, `contacts`) VALUES
  ('Игнат', 'ignat.v@gmail.com', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', NULL),
  ('Леночка', 'kitty_93@li.ru', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', NULL),
  ('Руслан', 'warrior07@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', NULL);

INSERT INTO `categories` (`name`, `user_id`) VALUES
  ('Входящие', '1'),
  ('Учеба', '2'),
  ('Работа', '3'),
  ('Домашние дела', '2'),
  ('Авто', '3');


INSERT INTO `tasks` (`name`, `user_id`, `project_id`, `deadline`) VALUES
  ('Встреча с другом', '1', '1', '2017-09-22'),
  ('Сделать задание первого раздела', '2', '2', '2017-09-21'),
  ('Собеседование в IT компании', '3', '3', '2017-11-01'),
  ('Выполнить тестовое задание', '3', '3', '2017-10-25'),
  ('Купить корм для кота', '2', '4', NULL),
  ('Заказать пиццу', '2', '4', NULL);

SELECT * FROM `tasks` WHERE `user_id` = '2';

SELECT * FROM `tasks` WHERE `project_id` = '2';

UPDATE `tasks` SET `done` = NOW()
WHERE `id` = '19';

SELECT * FROM `tasks` WHERE `deadline` = NOW() + INTERVAL 1 DAY;

UPDATE `tasks` SET `name` = 'Выспаться'
WHERE `id` = '19';
