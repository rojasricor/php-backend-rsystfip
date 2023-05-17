SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `cancelled` (
  `person_id` int(11) NOT NULL COMMENT 'Campo que guarda el id de la persona que se va a cancelar la cita.',
  `date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Campo que guarda la fecha y hora en la que se cancela la cita.',
  `cancelled_asunt` varchar(150) NOT NULL COMMENT 'Campo que guarda el asunto por el cual se cancela la cita.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla que almacena las citas canceladas.';

INSERT INTO `cancelled` (`person_id`, `date`, `cancelled_asunt`) VALUES
(4, '2023-04-12 21:57:15', 'sssssssssss'),
(5, '2023-04-12 22:08:55', '\n\n'),
(6, '2023-04-12 22:22:34', 'No asiste'),
(6, '2023-04-12 22:22:36', 'No asiste'),
(7, '2023-04-12 22:25:09', 'sssssssss');

CREATE TABLE `categories` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de persona (autoincremental).',
  `category` varchar(15) NOT NULL COMMENT 'Campo que guarda el nombre del tipo de persona, clasificado por categoria.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los diferentes tipos de persona clasificada por categoria, usada para los agendamientos.';

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Docente'),
(2, 'Estudiante'),
(3, 'Coordinador'),
(4, 'Decano'),
(5, 'Otro (externo)');

CREATE TABLE `deans` (
  `_id` varchar(12) NOT NULL COMMENT 'Campo que guarda el numero de cedula del de decano del ITFIP, (unique).',
  `dean` varchar(50) NOT NULL COMMENT 'Campo que guarda el nombre de decano del ITFIP.',
  `facultie_id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id de facultad a la que pertenece el decano del ITFIP.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los datos de decanos del ITFIP, que seran utilizados para el agendamiento de personas mas rapidamente, haciendo un autocompletado.';

INSERT INTO `deans` (`_id`, `dean`, `facultie_id`) VALUES
('1111122448', 'Holman Reyes Puentes', 2),
('1111122449', 'Cesar Julio Bravo Saavedra', 1),
('1111122450', 'Luz Mery Vega Bustamante', 3);

CREATE TABLE `documents` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de documento, (autoincremental).',
  `document` varchar(3) NOT NULL COMMENT 'Campo que guarda una abreviacion corta del tipo de documento.',
  `description` varchar(40) NOT NULL COMMENT 'Campo que guarda el nombre detallado del tipo de documento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los tipos de documentos, que seran utilizados para el agendamiento de personas.';

INSERT INTO `documents` (`id`, `document`, `description`) VALUES
(1, 'CC', 'Cédula Ciudadanía CC'),
(2, 'TI', 'Tarjeta Identidad TI'),
(3, 'CE', 'Cédula Extranjería CE'),
(4, 'PA', 'Pasaporte PA'),
(5, 'NIT', 'Número de identificación tributaria NIT');

CREATE TABLE `faculties` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id de la facultad, (autoincremental).',
  `facultie` varchar(60) NOT NULL COMMENT 'Campo que guarda el nombre de la facultad.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena las facultades actuales de los programas academicos del ITFIP.';

INSERT INTO `faculties` (`id`, `facultie`) VALUES
(1, 'Facultad de Economía, Administración y Contaduría Pública'),
(2, 'Facultad de Ingeniería y Ciencias Agroindustriales'),
(3, 'Facultad de Ciencias Sociales, Salud y Educación'),
(4, 'No aplica');

CREATE TABLE `people` (
  `id` int(11) NOT NULL COMMENT 'Campo que guarda el id de las personas agendadas (autoincremental).',
  `name` varchar(50) NOT NULL COMMENT 'Campo que guarda el nombre completo de las personas agendadas.',
  `document_id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de documento referenciado de la tabla document.',
  `document_number` char(11) NOT NULL COMMENT 'Campo que guarda el numero de documento de las personas agendadas.',
  `telephone` char(10) NOT NULL COMMENT 'Campo que guarda el numero de telefono de contacto.',
  `email` varchar(30) NOT NULL COMMENT 'Campo que guarda el correo electronico de contacto.',
  `category_id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de persona referenciado de la tabla person_type.',
  `facultie_id` tinyint(1) NOT NULL DEFAULT 4 COMMENT 'Campo que guarda el id de la facultad a la que pertenece referenciado de la tabla faculties.',
  `come_asunt` varchar(150) NOT NULL COMMENT 'Campo que guarda el asunto, motivo o razon de la visita a la rectoria, para su posterior agendamiento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena todos los datos personales de las personas que han sido agendadas.';

INSERT INTO `people` (`id`, `name`, `document_id`, `document_number`, `telephone`, `email`, `category_id`, `facultie_id`, `come_asunt`) VALUES
(1, 'Et Libero Cumque Error Et Deleniti ', 1, '98838844', '', '', 2, 1, 'Numquam eiusmod et sint aliquid minus quis sint est omnis sunt quas et accusamus error sunt'),
(2, 'Corporis Sit Vel Explicabo Culpa ', 5, '2127849455', '', '', 1, 3, 'Molestiae aut dolor ab provident'),
(3, 'Et Possimus Incidunt Soluta Ut Qu', 1, '5033333333', '', '', 1, 1, 'Ex dolorum ut totam et qui enim eaque dicta est assumenda rerum atque sunt quia est quos'),
(4, 'Et Rerum Distinctio Sit Corporis E', 2, '373737434', '', '', 5, 3, 'Voluptas sunt placeat vitae et quo sint quia reprehenderit corporis officiis eiusmod modi eveniet'),
(5, 'Sapiente Magnam Libero Earum Cupida', 4, '4833333333', '', '', 3, 2, 'Aut et in laborum amet quas nihil pariatur consequuntur cupidatat aliqua qui culpa et expedita'),
(6, 'Dolore Voluptatem Rerum Laboris Qu', 2, '473333333', '', '', 4, 2, 'Eos dolore deserunt ut cupiditate sit occaecat'),
(7, 'Odit Ducimus Iure Rem Perspiciatis', 5, '3333333326', '', '', 2, 3, 'Distinctio distinctio aliquid voluptatum dolor in sit optio dolores error id voluptatem invento'),
(8, 'Sed Sunt Nobis Esse Maiores Ut', 1, '9333333333', '', '', 1, 3, 'Aut molestiae aut quis sed fugiat iste quia consequatur harum eos inventore optio velit id nostr'),
(9, 'Officiis Dolorem Ut Dolore Deleniti', 3, '55774774', '', '', 3, 2, 'Dolorem qui aperiam aut et');

CREATE TABLE `scheduling` (
  `person_id` int(11) UNSIGNED NOT NULL COMMENT 'Campo que almacena el id de la persona agendada, llave foranea del campo id de la tabla registered people.',
  `date_filter` char(10) NOT NULL COMMENT 'Campo que guarda la fecha del agendamiento, utilizada para hacer busquedas en rango en  la base de datos.',
  `start_date` datetime NOT NULL COMMENT 'Campo que guarda la fecha y hora (datetime), de inicio de la visita a la rectoria, de la persona agendada.',
  `end_date` datetime NOT NULL COMMENT 'Campo que guarda la fecha y hora (datetime), de finalizacion de la visita a la rectoria, de la persona agendada.',
  `modification` char(8) NOT NULL COMMENT 'Campo que guarda la ultima hora de modificacion (time), del registro en la base de datos.',
  `status` enum('scheduled','daily','cancelled') NOT NULL COMMENT 'Campo que guarda el tipo de agendamiento realizado, puede ser de dos tipos,agendamiento programado o agendamiento al dia.',
  `color` char(7) NOT NULL DEFAULT '#388cdc' COMMENT 'Campo que guarda un valor de texto correspondiente al color que tendra el registro al ser agendado.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena todos los agendamientos en fecha del aplicativo.';

INSERT INTO `scheduling` (`person_id`, `date_filter`, `start_date`, `end_date`, `modification`, `status`, `color`) VALUES
(1, '2023-04-12', '2023-04-12 21:36:58', '2023-04-12 21:36:58', '09:37:04', 'daily', '#388cdc'),
(2, '2023-04-12', '2023-04-12 21:36:58', '2023-04-12 21:36:58', '09:37:11', 'daily', '#388cdc'),
(3, '2023-04-12', '2023-04-12 21:36:58', '2023-04-12 21:36:58', '09:37:17', 'daily', '#388cdc'),
(4, '2023-04-13', '2023-04-13 07:00:00', '2023-04-13 11:00:00', '09:37:36', 'cancelled', '#280da1'),
(5, '2023-04-13', '2023-04-13 08:00:00', '2023-04-13 13:30:00', '10:08:14', 'cancelled', '#de866e'),
(6, '2023-04-13', '2023-04-13 06:30:00', '2023-04-13 07:00:00', '10:10:09', 'cancelled', '#720048'),
(7, '2023-04-13', '2023-04-13 07:30:00', '2023-04-13 10:30:00', '10:24:59', 'cancelled', '#7ddc4b'),
(8, '2023-04-21', '2023-04-21 10:48:14', '2023-04-21 10:48:14', '11:48:24', 'daily', '#388cdc'),
(9, '2023-04-21', '2023-04-21 17:00:00', '2023-04-21 19:00:00', '11:48:42', 'scheduled', '#08fea5');

CREATE TABLE `users` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id de los usuarios del aplicativo, con acceso permitido (unique).',
  `name` varchar(25) NOT NULL COMMENT 'Campo que guarda el nombre de los usuarios del aplicativo, con acceso permitido.',
  `lastname` varchar(25) NOT NULL COMMENT 'Campo que guarda el apellido de los usuarios del aplicativo, con acceso permitido.',
  `document_id` tinyint(1) NOT NULL COMMENT 'Campo que almacena el id del tipo de documento, de la tabla document.',
  `document_number` char(11) NOT NULL COMMENT 'Campo que guarda el numero de documento.',
  `tel` char(10) NOT NULL COMMENT 'Campo que guarda el numero de telefono de contacto.',
  `email` varchar(30) NOT NULL COMMENT 'Campo que guarda el correo electronico institucional o usuario de acceso al aplicativo.',
  `password` varchar(80) NOT NULL COMMENT 'Campo que guarda el password de acceso al aplicativo (encriptado).',
  `role` enum('admin','rector','secretaria') NOT NULL COMMENT 'Campo que guarda el rol que tiene el usaurio, existen 3: admin, rector, secretaria.',
  `permissions` set('admin','add','schedule','reports','statistics') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los usuarios del aplicativo, y sus respectivos usuarios y password de acceso al aplicativo.';

INSERT INTO `users` (`id`, `name`, `lastname`, `document_id`, `document_number`, `tel`, `email`, `password`, `role`, `permissions`) VALUES
(1, 'Mario Fernando', 'Díaz Pava', 0, '7223309043', '3100000000', 'mdiaz@itfip.edu.co', '$2y$10$ulcGJ5S/NodjeQmPo1wTL.rISkGNJ5th9ejXf6kJqdwlm/8yAZxYm', 'rector', 'schedule'),
(2, 'Luz Elena', 'Avila', 1, '11111111111', '3100000000', 'lavila@itfip.edu.co', '$2y$10$ISfxYUjrGFnjZAup3yeNY./5Vyj3X88LmxudLTN.lKKlMSuApH45W', 'secretaria', 'add,schedule,reports,statistics'),
(3, 'Ricardo Andrés', 'Rojas Rico', 1, '1111122448', '3173926578', 'rrojas48@itfip.edu.co', '$2y$10$LLOliaD5SOpQYv/ovweIQOrpoKxbO6ocSH./vXIXHatN/6nRws1pC', 'admin', 'admin,add,schedule,reports,statistics');


ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deans`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `ID CARD` (`_id`) USING BTREE;

ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document` (`document_id`),
  ADD KEY `id_facultied` (`facultie_id`) USING BTREE,
  ADD KEY `person_type` (`category_id`) USING BTREE;

ALTER TABLE `scheduling`
  ADD KEY `people_id` (`person_id`) USING BTREE;

ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_doc` (`document_id`);


ALTER TABLE `categories`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id del tipo de persona (autoincremental).', AUTO_INCREMENT=6;

ALTER TABLE `documents`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id del tipo de documento, (autoincremental).', AUTO_INCREMENT=6;

ALTER TABLE `faculties`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id de la facultad, (autoincremental).', AUTO_INCREMENT=5;

ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id de las personas agendadas (autoincremental).', AUTO_INCREMENT=10;
COMMIT;
