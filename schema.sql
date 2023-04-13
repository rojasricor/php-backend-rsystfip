-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 09, 2023 at 12:14 PM
-- Server version: 10.5.18-MariaDB-0+deb11u1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `itfip`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de persona (autoincremental).',
  `person` varchar(15) NOT NULL COMMENT 'Campo que guarda el nombre del tipo de persona, clasificado por categoria.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los diferentes tipos de persona clasificada por categoria, usada para los agendamientos.';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `person`) VALUES
(1, 'Docente'),
(2, 'Estudiante'),
(3, 'Coordinador'),
(4, 'Decano'),
(5, 'Otro (externo)');

-- --------------------------------------------------------

--
-- Table structure for table `deans`
--

CREATE TABLE `deans` (
  `cc` varchar(12) NOT NULL COMMENT 'Campo que guarda el numero de cedula del de decano del ITFIP, (unique).',
  `name` varchar(50) NOT NULL COMMENT 'Campo que guarda el nombre de decano del ITFIP.',
  `facultie` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id de facultad a la que pertenece el decano del ITFIP.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los datos de decanos del ITFIP, que seran utilizados para el agendamiento de personas mas rapidamente, haciendo un autocompletado.';

--
-- Dumping data for table `deans`
--

INSERT INTO `deans` (`cc`, `name`, `facultie`) VALUES
('1111122448', 'Holman Reyes', 3);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de documento, (autoincremental).',
  `document` varchar(3) NOT NULL COMMENT 'Campo que guarda una abreviacion corta del tipo de documento.',
  `description` varchar(40) NOT NULL COMMENT 'Campo que guarda el nombre detallado del tipo de documento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los tipos de documentos, que seran utilizados para el agendamiento de personas.';

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `document`, `description`) VALUES
(1, 'CC', 'Cédula Ciudadanía CC'),
(2, 'TI', 'Tarjeta Identidad TI'),
(3, 'CE', 'Cédula Extranjería CE'),
(4, 'PA', 'Pasaporte PA'),
(5, 'NIT', 'Número de identificación tributaria NIT');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id de la facultad, (autoincremental).',
  `name` varchar(60) NOT NULL COMMENT 'Campo que guarda el nombre de la facultad.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena las facultades actuales de los programas academicos del ITFIP.';

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`) VALUES
(1, 'Facultad de Economía, Administración y Contaduría Pública'),
(2, 'Facultad de Ingeniería y Ciencias Agroindustriales'),
(3, 'Facultad de Ciencias Sociales, Salud y Educación'),
(4, 'No aplica');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL COMMENT 'Campo que guarda el id de las personas agendadas (autoincremental).',
  `name` varchar(50) NOT NULL COMMENT 'Campo que guarda el nombre completo de las personas agendadas.',
  `id_doc` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de documento referenciado de la tabla document.',
  `num_doc` char(11) NOT NULL COMMENT 'Campo que guarda el numero de documento de las personas agendadas.',
  `person_type` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id del tipo de persona referenciado de la tabla person_type.',
  `facultad` tinyint(1) NOT NULL DEFAULT 4 COMMENT 'Campo que guarda el id de la facultad a la que pertenece referenciado de la tabla faculties.',
  `text_asunt` varchar(150) NOT NULL COMMENT 'Campo que guarda el asunto, motivo o razon de la visita a la rectoria, para su posterior agendamiento.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena todos los datos personales de las personas que han sido agendadas.';

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `id_doc`, `num_doc`, `person_type`, `facultad`, `text_asunt`) VALUES
(1, 'Aadsadasada', 1, '4777777777', 1, 1, 'Id velit est magni et'),
(2, 'Abbot Holmes', 1, '9559595555', 2, 3, 'Reprehenderit except'),
(3, 'Abdul Vaughan', 5, '8888888888', 4, 1, 'Eu quas sit sunt in odio dolor repellendus a velit quae nemo vitae dolore aspernatur anim volupta'),
(4, 'Abra Randolph', 5, '3333333333', 5, 4, 'Doloremque illo magni excepteur sunt'),
(5, 'Adam Salas', 4, '4477777777', 4, 4, 'Expedita sint ut quisquam et nostrum dolores qui nihil alias ipsum deleniti sed error non cupidatat'),
(6, 'Adrian Cline', 2, '4444444444', 5, 2, 'Dignissimos quo elit ab dolore'),
(7, 'Adrian Walsh', 3, '2345678000', 5, 4, 'Magni do quibusdam a'),
(8, 'Aidan Valencia', 4, 'Culpa con', 5, 4, 'Autem excepteur nostrud in fugiat consequat do eum error explicabo atque quas'),
(9, 'Aiko Avila', 5, '123456789', 5, 2, 'Sit in alias irure '),
(10, 'Ainsley Vega', 2, '2345678908', 5, 4, 'Et eveniet excepteur eaque voluptatem est sunt enim sint sit'),
(11, 'Allen Roberts', 2, '9999999999', 5, 4, 'Alias quia aspernatur commodo aliqua mollit sint quos laboris facere cillum dolores aut qui in'),
(12, 'Andrew Valencia', 5, '9555555555', 2, 4, 'Et est reiciendis officia ipsam facere pariatur obcaecati nam pariatur qui vel eos'),
(13, 'Ann Stokes', 4, '1234567666', 5, 4, 'Illo labore ipsam veritatis esse id quod in consectetur quia'),
(14, 'Anthony Leach', 1, '6555555555', 4, 4, 'Quos excepturi sunt numquam iusto quae non maxime doloribus obcaecati veniam minus sit rem'),
(15, 'April Shelton', 4, '4444444444', 1, 1, 'Facere quidem anim sed hic blanditiis ipsum ex dolor et quis et quis dolore optio sit amet id'),
(16, 'Aristotle Miranda', 2, '1111111111', 2, 2, 'Repellendus aliquid nesciunt eum et dolores eligendi quis sit sequi aut'),
(17, 'Armand Pollard', 2, '5555555555', 2, 1, 'Debitis et dolores ut est distinctio nobis qui accusamus cumque ducimus dolorem illo veniam volu'),
(18, 'Arthur Fitzgerald', 4, '633334444', 5, 4, 'Consequatur anim voluptatem sit unde officiis qui'),
(19, 'Asadasad', 1, '333664748', 2, 1, 'Sssssssasaadsd'),
(20, 'Asadsadsa', 1, '6627627267', 1, 4, 'Dasdasaadsadad'),
(21, 'Asasasasasaaaasas', 1, '1234567890', 4, 2, 'Voluptatum tempor excepturi aspernatur obcaecati dolore eveniet rerum quo porro non laborum quis v'),
(22, 'Asdaasdsa', 2, '33333333', 3, 2, 'Asdadsadasad'),
(23, 'Asher Ellis', 4, '4888888888', 3, 1, 'Sint et quis et molestias eos praesentium deleniti commodo'),
(24, 'Assadasasda', 3, '123456789', 4, 1, 'Ipsum ipsa minima culpa est suscipit architecto quis minim consequat cum cillum omnis nulla neque'),
(25, 'Assdasada', 5, '4444444444', 4, 1, 'Autem ullam ratione aliqua velit duis velit officia veniam voluptate ipsa aliquam vero hic nihil '),
(26, 'Audra Hale', 4, '2222222222', 3, 1, 'Qui quo veritatis et sunt reiciendis possimus reprehenderit quia quia voluptas commodi'),
(27, 'Audrey Boone', 5, '7222222222', 4, 1, 'Corrupti modi voluptas natus sint quod quis esse itaque et consectetur distinctio veritatis eius '),
(28, 'Aurora Welch', 1, '5555555555', 2, 2, 'Perspiciatis elit '),
(29, 'Avram Berg', 5, '7777777777', 1, 3, 'Qui ad consequatur id quisquam atque ut nostrud sit sequi labore dolore nisi sunt et nesciunt mol'),
(30, 'Beatrice Holloway', 5, '4885555555', 2, 1, 'Aut pariatur perspi'),
(31, 'Bernard Dyer', 1, '4444444444', 3, 1, 'Hic molestiae dolores commodi obcaecati'),
(32, 'Beverly Hahn', 5, '7777444444', 3, 2, 'Consectetur amet error fugiat lorem inventore'),
(33, 'Blair Mcdonald', 4, '895556666', 5, 4, 'Ea omnis porro quia Nam a minim minima voluptatem temporibus minus commodo duis ex in do nihil'),
(34, 'Brady Payne', 1, '5555555555', 4, 4, 'Et ut dolore dolor ex pariatur ullam commodo nemo commodi nobis neque culpa vel eaque'),
(35, 'Brenda Daniels', 3, '4666666666', 4, 2, 'Tenetur sed ea dignissimos iure excepteur voluptates suscipit ut est consequuntur nam sequi deserunt'),
(36, 'Brenna Gonzalez', 4, '6444444444', 3, 3, 'Modi repellendus et numquam aut fuga amet cumque'),
(37, 'Brennan Mclean', 2, '1237888888', 5, 4, 'Veniam quidem vel e'),
(38, 'Brent Booker', 4, '6666666444', 1, 1, 'Numquam quidem moles'),
(39, 'Britanni Clements', 3, '6333333333', 4, 1, 'Incididunt quibusdam rem tenetur labore cillum'),
(40, 'Cailin Mercado', 4, '2396666666', 5, 4, 'Doloremque temporibus aut sunt tenetur ducimus sunt'),
(41, 'Cain Alexander Satanas', 5, '4888888888', 1, 4, 'Aperiam et sit illum mollit deserunt facilis et assumenda qui quis illo accusamus soluta commodi d'),
(42, 'Caldwell Knight', 3, '4444444444', 4, 3, 'Consequatur aut aut rerum corrupti expedita quia mollitia ut perferendis est'),
(43, 'Cameron Wyatt', 1, '2222222222', 1, 2, 'Repudiandae sunt sunt excepturi earum rerum corrupti harum reprehenderit sint id'),
(44, 'Candace Andrews', 1, '3663333333', 4, 3, 'Qui est quos adipisicing ut proident'),
(45, 'Carl Ruiz', 2, '5666666666', 5, 4, 'A deserunt molestiae autem ea omnis ab corporis nemo quos totam praesentium nostrud impedit qui'),
(46, 'carlo enrique lara meneces', 1, '100588732', 3, 2, 'aumento de saliario'),
(47, 'Carlos Enrique Lara Meneses', 1, '4890444994', 1, 2, 'Prestamo del auditorio del itfip'),
(48, 'Carlos Solomon', 2, '9976532222', 5, 4, 'Officia laborum ad saepe velit'),
(49, 'Carly Garrett', 2, '8555555555', 1, 2, 'Officiis nostrum qui est sit quidem nostrum dolorem ipsum cum est natus eu rerum quam quia velit '),
(50, 'Casey Norton', 1, '2222222222', 2, 1, 'Dolorem laborum eveniet inventore eiusmod natus ut modi in sit repellendus esse ducimus consectet'),
(51, 'Casey Serrano', 3, '2222222220', 5, 4, 'Ipsam odio provident'),
(52, 'Cassandra Stark', 1, '9444444444', 2, 2, 'Est cumque ab quia voluptatem qui perferendis qui'),
(53, 'Cedric Reilly', 5, '5333333333', 5, 4, 'Consequatur consequatur voluptas sit sed'),
(54, 'Ciara Gilmore', 2, '3333333333', 1, 2, 'Quia omnis iusto et '),
(55, 'Ciara Roy', 3, '4444444444', 4, 4, 'Consequuntur facilis laboris omnis pariatur perspiciatis voluptatem ad voluptatem earum numquam q'),
(56, 'Ciara Todd', 4, '44444444', 3, 1, 'Delectus non sed proident illum proident sint officiis quo rerum velit rem ipsam qui'),
(57, 'Clio Gallagher', 2, '8449595995', 3, 2, 'Qui sunt Nam omnis Nam laboris pariatur Natus sunt labore ratione vitae ea minima hic assumenda con'),
(58, 'Clio Valdez', 3, '4444444444', 3, 2, 'Nihil modi est duis veritatis deserunt cum est eaque velit ipsa quibusdam laudantium illo consequ'),
(59, 'Colby Haley', 5, '1111122222', 5, 4, 'Laboriosam odio eli'),
(60, 'Colette Charles', 1, '6666666666', 2, 1, 'Ea provident elit molestiae alias et et dolor quibusdam voluptatibus ut ipsum voluptatem quod'),
(61, 'Colton Wolfe', 3, '4444444444', 3, 4, 'Ea molestiae porro quis ducimus est'),
(62, 'Colleen Mcpherson', 1, '2222222222', 2, 4, 'Est accusamus volupt'),
(63, 'Connor Tucker', 2, '3333333333', 4, 3, 'Quo ipsum enim anim dolor repudiandae hic quibusdam eum quidem animi minim tempora et commodo est'),
(64, 'Cyrus Wilkinson', 5, '7777777777', 4, 3, 'Mollit consequatur in eum praesentium officia elit itaque'),
(65, 'Charissa Wright', 1, '4444444444', 3, 3, 'Aut sunt autem ad anim corporis pariatur in sint nulla sint ipsam enim sit omnis consectetur exc'),
(66, 'Charles Kline', 1, '4444444444', 5, 4, 'Rem dolor molestias quia maiores voluptas nobis ea voluptas laborum atque'),
(67, 'Cheyenne Berry', 3, '3444444444', 1, 4, 'Unde adipisci dolore'),
(68, 'Dale Baldwin', 5, '374955005', 3, 4, 'Non vero quis proide'),
(69, 'Dale Collier', 3, '3333337555', 1, 1, 'Eum unde ad non eveniet consectetur dolor sequi atque quisquam sit voluptas autem ea magnam earum'),
(70, 'Dalton Mejia', 2, '8888888888', 5, 4, 'Voluptas quos et nostrum nulla eos non ut cumque nemo aute temporibus'),
(71, 'Damian Bennett', 2, '1111111188', 5, 2, 'Qui est officiis et'),
(72, 'Damian Medina', 2, '949955555', 1, 4, 'Porro doloribus molestiae ea omnis eu vel sint vel fugiat at sed magnam ratione fuga'),
(73, 'Daria Love', 4, '6666666666', 5, 2, 'Dolorem illo numquam molestiae voluptatibus blanditiis explicabo et a nisi consequat nulla'),
(74, 'Darrel Garza', 1, '4444444444', 5, 3, 'Do sunt non id excepteur consectetur asperiores repudiandae et dolor enim ipsum maiores'),
(75, 'Darrel Yates', 1, '4445555555', 1, 3, 'Modi qui adipisicing alias earum eius incidunt minima id rerum ad illum pariatur'),
(76, 'David Larry', 3, '8444444444', 4, 2, 'In beatae repellendus nostrud recusandae qui voluptas nobis voluptas odio irure in quidem error mo'),
(77, 'Derek Hull', 3, '8888888888', 3, 1, 'Laborum dicta quis nostrud nulla consequatur praesentium accusantium earum sequi ut'),
(78, 'Derek Saunders', 4, '3333333333', 2, 3, 'Corrupti reiciendis consequatur doloremque autem ut dolore praesentium cillum adipisicing facilis q'),
(79, 'Diana Salinas', 4, '6333333333', 1, 3, 'Voluptas irure irure error et irure pariatur soluta culpa'),
(80, 'Dominic Vega', 5, '5888888888', 3, 2, 'Quia perferendis ipsam quia autem qui fugiat in sit deserunt fugit officia omnis sit quas volupt'),
(81, 'Dominique Miles', 1, '4444444444', 2, 4, 'Sit non sit aut inventore deserunt aut distinctio voluptas accusantium expedita'),
(82, 'Dora Perez', 5, '3844444455', 4, 3, 'Exercitationem assum'),
(83, 'Drew Mcfadden', 1, '5555555555', 1, 1, 'Est eaque ad ex maxime suscipit aliquip totam fugit voluptas autem culpa eos quod impedit quis'),
(84, 'Eaton Guerra', 5, '3334444444', 3, 3, 'Incididunt sit est '),
(85, 'Elizabeth Daniel', 3, '3333333333', 3, 4, 'Aut quidem exercitationem porro assumenda obcaecati optio enim ex fugit pariatur vel explicabo i'),
(86, 'Elton Wilkins', 2, '3777777777', 4, 4, 'Maiores et modi et perferendis unde quia velit aliquam quisquam'),
(87, 'Ella Francis', 3, '22333444', 3, 3, 'Irure ullamco ut dol'),
(88, 'Ella Porter', 5, '3333333332', 4, 3, 'Quis nisi voluptate eaque ex earum ipsum ducimus in veniam do nihil autem'),
(89, 'Emi Lewis', 2, '9999999999', 2, 1, 'Velit in ipsum accusamus est proident dolor autem mollit incidunt incidunt lorem quibusdam quia '),
(90, 'F', 1, '45555555', 2, 2, '4'),
(91, 'Felicia Flynn', 1, '999999995', 2, 1, 'Ut laboriosam architecto similique eligendi veniam aut dolor quidem officia soluta veniam elit h'),
(92, 'Ferdinand Simmons', 5, '4444444444', 1, 1, 'Ex quidem eius perferendis omnis autem enim magna do odio occaecat amet consectetur eius provident'),
(93, 'Fff', 1, '3399999999', 2, 4, 'Dddd'),
(94, 'Ffffffffffff', 2, '55555555', 2, 2, '55555555555'),
(95, 'Fiona Moon', 4, '4444444444', 2, 1, 'A ut veritatis laudantium nemo ut occaecat'),
(96, 'Flavia Mcmillan', 2, '4499999999', 3, 2, 'Necessitatibus ut eu ea magna voluptatem'),
(97, 'Fletcher Cotton', 1, '9999999999', 5, 4, 'Ipsa qui quibusdam in sint voluptatum necessitatibus laborum rerum dolore ullamco unde commodo nes'),
(98, 'Fletcher Hartman', 2, '3333333333', 5, 4, 'Culpa vitae nihil magni qui incididunt labore sed harum totam nam in culpa nihil'),
(99, 'Florence Graham', 3, '5555555555', 2, 1, 'Ducimus nemo alias '),
(100, 'Galena Brooks', 2, '3352222222', 1, 4, 'Repellendus at dese'),
(101, 'Gavin Foreman', 2, '4444444444', 2, 1, 'Ratione ut dolorem n'),
(102, 'Gay Stark', 1, '7777777777', 1, 2, 'Consequat incididunt fugiat facilis expedita eum soluta sed libero id ut fuga ut voluptate veniam'),
(103, 'Gillian Floyd', 3, '6666666666', 2, 4, 'Neque atque eius blanditiis nihil minim recusandae distinctio aut quidem dolor corporis ea nisi qu'),
(104, 'Glenna Bradford', 1, '7384884494', 4, 3, 'Et quia dolorem sapi'),
(105, 'Glenna Walton', 2, '339483944', 2, 3, 'Sint lorem quasi qu'),
(106, 'Gloria Gamble', 5, '5555555555', 1, 3, 'Quas voluptatem voluptatibus incididunt voluptas molestias velit molestiae adipisci aliquam delectu'),
(107, 'Griffin Pruitt', 3, '1111111119', 3, 3, 'Explicabo anim est ea eveniet esse ducimus veniam nobis hic vel dolor consequatur reprehenderi'),
(108, 'Harper Langley', 2, '88484949', 2, 3, 'Eiusmod illo esse quia nisi officia lorem animi in omnis sint et id libero quae'),
(109, 'Harriet Hunter', 1, '6333333333', 4, 3, 'Quibusdam in saepe distinctio eiusmod voluptate aut mollitia ea qui qui nostrum quos provident ut '),
(110, 'Hashim Savage', 4, '5555555555', 2, 2, 'Qui qui dolore fugit'),
(111, 'Hayden William', 4, '4444444444', 5, 4, 'Alias anim cillum ab sint nobis quia repudiandae dolorem veniam aliquam animi quod id'),
(112, 'Hayes Guzman', 4, '5554444444', 3, 4, 'Ea aut ut quis qui commodi consectetur sint rerum aperiam et blanditiis dolorum nemo est qui do vel'),
(113, 'Hedley Adkins', 3, '2222222222', 4, 4, 'Magni rerum aut impe'),
(114, 'Hermione Holloway', 3, '4444444444', 1, 3, 'Laboriosam magna quia enim cupidatat pariatur officia rerum quos nihil quidem est corporis aute du'),
(115, 'Hilary Shepherd', 3, '88895995', 2, 1, 'Dicta dolore neque voluptate qui ut esse minim ut incidunt corrupti quibusdam esse veniam omnis '),
(116, 'Hiroko Downs', 1, '5555555555', 2, 3, 'Mollitia dolorem dolorem voluptatem quam quis dolore rerum'),
(117, 'Holman reyes', 1, '658557677', 4, 2, 'Nombramiento  docent'),
(118, 'Idona Grimes', 3, '7555555555', 4, 2, 'Ipsum sit praesentiu'),
(119, 'Ignacia Higgins', 5, '3333333344', 2, 2, 'Id porro facere cill'),
(120, 'Illiana Sharpe', 5, '555555544', 4, 3, 'Ipsum rem eveniet '),
(121, 'Imani Leonard', 1, '7333333333', 2, 4, 'Odio odit voluptas sed eum expedita assumenda fugiat repellendus ratione aut quod officiis cupidat'),
(122, 'Inez Mills', 3, '4444444444', 5, 2, 'Nisi adipisci lorem '),
(123, 'Irma Frederick', 3, '2345678900', 5, 4, 'Ipsum dolore sed odit ad explicabo blanditiis consequat corporis ut quas quaerat sit in fuga ape'),
(124, 'Isabella Duffy', 5, '4888888888', 1, 3, 'Maiores omnis cillum quia cillum omnis autem non fugiat'),
(125, 'Isabella Mcfarland', 3, '4444444444', 5, 4, 'Dolores voluptas beatae aut exercitation laboris nemo sapiente quae'),
(126, 'Isadora Romero', 2, '2222222222', 2, 4, 'Fugit autem eligendi fugit voluptas at reprehenderit rerum'),
(127, 'Jackson Weaver', 5, '8888888888', 3, 3, 'Porro veritatis aliquip quia sunt tenetur doloribus voluptatem quis'),
(128, 'Jade Ratliff', 2, '3333333333', 3, 4, 'Modi totam commodi t'),
(129, 'Jamal Foley', 3, '6666444555', 5, 4, 'Quisquam nisi quis pariatur Ipsa tenetur dolores eius repudiandae velit perferendis'),
(130, 'Jamal Yates Creampie', 2, '5555555555', 5, 3, 'Ea est itaque duis id voluptas duis cumque ut suscipit corrupti deserunt alias earum quis'),
(131, 'Jameson Sanchez', 1, '8888888888', 5, 4, 'Quia qui quo sunt rerum sit nisi labore nostrum aperiam ut nostrum explicabo pariatur'),
(132, 'Jermaine Barnes', 4, '5555555555', 5, 3, 'In ducimus elit perspiciatis exercitation laborum'),
(133, 'Jesse Walker', 5, '5444444434', 4, 4, 'Enim cupidatat porro'),
(134, 'Jessica Buchanan', 3, '4444444444', 4, 4, 'Magni reprehenderit ab sint id earum iste'),
(135, 'Jocelyn Phelps', 1, '4444444444', 1, 3, 'Aliquid asperiores qui consectetur officiis aliqua voluptatem eaque natus ut hic'),
(136, 'Jonas Mcneil', 5, '7333333333', 1, 2, 'Voluptatem voluptatem sequi magna hic quis in minima dolor et eum laboriosam'),
(137, 'jorge leonardo castro arana', 1, '1105679460', 1, 2, 'revision de notas de primero B'),
(138, 'Jose Carlos Figeroa', 4, '4444444444', 2, 4, 'Quia magni id voluptas accusantium nihil maiores'),
(139, 'Jose Julio', 4, '5555555555', 2, 2, 'Culpa eum iste aut maxime et labore rem numquam suscipit'),
(140, 'Jose Lucas', 4, '6444444444', 5, 4, 'Reprehenderit laborum atque fugit nulla aut impedit'),
(141, 'jose manuel', 2, '172167312', 4, 3, 'persmisos de citas'),
(142, 'Juan Jose', 4, '6666666666', 3, 2, 'Enim inventore est dolor quasi sint voluptatibus'),
(143, 'Juanka', 4, '5555555555', 1, 1, 'Laudantium magni voluptatem iusto consectetur perferendis neque perspiciatis dolores voluptas ex '),
(144, 'Kaitlin Floyd', 3, '7445555555', 2, 2, 'Aspernatur aperiam c'),
(145, 'Kamal Byers', 4, '5555555555', 1, 2, 'Proident aliquid explicabo ullamco et mollitia nihil tenetur'),
(146, 'Karina Rosales', 5, '4444444444', 5, 4, 'Ut qui natus labore eiusmod saepe incidunt a'),
(147, 'Karleigh Blackwell', 2, '8444444444', 1, 3, 'Delectus quos dignissimos voluptas est dolores ut error molestiae'),
(148, 'Karly Noel', 5, '9999999999', 3, 1, 'Eum culpa et at et eligendi deserunt eiusmod quaerat eum'),
(149, 'Kaseem Bernard', 1, '5555555555', 5, 4, 'Animi corrupti rerum nemo minus quis sit numquam nostrum est proident voluptatum voluptates ipsu'),
(150, 'Kasper Spencer', 1, '8444444455', 1, 2, 'Accusantium eos bea'),
(151, 'Kelly Atkinson', 5, '9949959555', 5, 4, 'Et ut anim consequun'),
(152, 'Kelly Owen', 4, 'Neque repr', 5, 4, 'Quo sit et laborum ex quia dolor rerum consequuntur molestiae'),
(153, 'Kennedy Crosby', 1, '6666666666', 3, 4, 'Ut consectetur aut officiis sapiente consequatur omnis sunt consequatur voluptatum lorem et omnis'),
(154, 'Kenneth Day', 5, '3445556666', 1, 2, 'Nulla culpa qui a odit repudiandae cumque consequat in alias magni'),
(155, 'Kerry Sloan', 5, '633333333', 5, 4, 'Temporibus ut sunt incidunt ex provident sunt tenetur aut aliquip rerum aut minima vel voluptatem '),
(156, 'Kiara Duke', 3, '4444444444', 1, 4, 'Nihil aliquam qui ipsa est duis amet iusto nemo ex tempora architecto veniam earum'),
(157, 'Kirk Yates', 3, '8888888888', 5, 4, 'Asperiores sint et et voluptatem quaerat dolores nam et cillum alias'),
(158, 'Kuame Hanson', 3, '1111111111', 4, 3, 'Sint eius in blandi'),
(159, 'Kyla Fleming', 3, '4789333333', 2, 3, 'Aut qui ea voluptas est aut velit esse quia sunt repudiandae numquam consequatur ad eum'),
(160, 'Kyla Rosales', 1, '66666666', 2, 1, 'Eum qui voluptatum t'),
(161, 'Kylee Mason', 4, '5555555555', 5, 3, 'Tempore explicabo ullamco quaerat aliquam rem nulla magni sed exercitation veniam reprehenderit '),
(162, 'Lani Blanchard', 3, '3333333333', 4, 1, 'Duis in rerum nisi fugiat sed in ducimus pariatur necessitatibus beatae aspernatur hic totam earum'),
(163, 'Latifah Richmond', 2, '2333333333', 1, 4, 'Amet magni incidunt'),
(164, 'Laurel Alvarado', 4, '8444444444', 3, 4, 'Assumenda odio recusandae tenetur voluptatem cum animi est nulla ullamco'),
(165, 'Lavinia Castro', 5, '6111111111', 2, 2, 'Adipisci tempora dignissimos soluta accusantium'),
(166, 'Lester Weewks', 5, '4444444444', 2, 2, 'Nobis vel dolore aut minim ut molestias ex maxime qui hic minus sit atque incididunt qui velit adipi'),
(167, 'Louis Willis', 1, '9999999999', 4, 1, 'Mollit amet enim pe'),
(168, 'Lucas Moy', 3, '448958533', 5, 4, 'Programmer'),
(169, 'Lucius Knowles', 3, '8884444455', 3, 4, 'Id ut aut dolore quae corrupti vitae commodi reiciendis incidunt dolores asperiores consequat con'),
(170, 'Lunea Morris', 5, '1222223444', 1, 1, 'Est ad minima eos e'),
(171, 'Madeline Randall', 3, '5555555555', 1, 4, 'Repudiandae inventore alias ipsum elit quos libero ea'),
(172, 'Madison Mccoy', 2, '2222222222', 5, 4, 'Fugiat dolores qui vitae qui ut do rerum dignissimos assumenda sit quam nam'),
(173, 'Maggie Mack', 2, '9999999999', 2, 4, 'Possimus rerum exercitation eaque nam minima animi voluptatem laboriosam aut ipsa veniam eiusm'),
(174, 'Maia Cherry', 2, '3333333333', 1, 4, 'Facere id rerum asperiores eiusmod iusto deserunt veniam quia'),
(175, 'Malcolm Hopkins', 2, '6666666666', 2, 4, 'Sunt tempore doloremque aliquip expedita cupiditate dolore et'),
(176, 'Maryam Francis', 3, '5555555555', 2, 2, 'Sed qui exercitation at earum qui aute nesciunt alias architecto'),
(177, 'Maya Price', 1, '1111111111', 1, 4, 'Ab ab duis eos labore sit vitae odit qui quia molestias reprehenderit atque suscipit magna hic est'),
(178, 'Meghan Fleming', 1, '6766666666', 5, 4, 'Tempora vel porro non cum eum reiciendis odit ad sapiente eos voluptate culpa'),
(179, 'Melodie Ware', 4, '9559893955', 4, 4, 'Officia optio doloribus vitae et autem ipsa nisi'),
(180, 'Merrill Cardenas', 5, '6666666666', 3, 1, 'Hic quaerat sunt et nam amet ad dolorem sed itaque modi'),
(181, 'Nichole Sanford', 3, '3333333333', 1, 4, 'Corrupti dolore nem'),
(182, 'Odysseus Kemp', 3, '2222222222', 4, 4, 'Autem fugiat consequatur eligendi commodo exercitationem vero non accusantium rerum molestiae id qu'),
(183, 'Oleg Blackwell', 4, '9555555555', 2, 2, 'Optio quisquam dolorem molestias facere quis inventore'),
(184, 'Patricia Long', 1, '6666666664', 5, 4, 'Dolorem voluptatem q'),
(185, 'Penelope Taylor', 1, '5555555555', 3, 1, 'Nostrud qui ipsum qu'),
(186, 'Peter Mckinney', 2, '6789000000', 5, 4, 'A voluptatem rerum laborum magni quis recusandae sit ut necessitatibus minus'),
(187, 'Piper Atkins', 2, '4444444444', 5, 3, 'Eos aliquid qui aut'),
(188, 'Piper Patterson', 4, '4666644444', 1, 1, 'Commodo qui sit consequat eu eaque omnis proident dolore'),
(189, 'Prescott Rush', 3, '55555555', 3, 4, 'Est accusamus tenetur pariatur ullam nesciunt corporis'),
(190, 'Quintessa Rogers', 3, '3333333333', 4, 4, 'Laborum voluptas vero omnis ea'),
(191, 'Raphael Mcconnell', 5, '9777777775', 5, 4, 'Odit quia nostrud facilis ut duis et qui tempor et provident ea veniam aut ipsa ipsa adipisci'),
(192, 'Raven Shaffer', 4, '6444444444', 4, 1, 'Eaque voluptatem explicabo vel quis odio provident consequatur quo nisi'),
(193, 'Raya Gomez', 1, '2555555555', 3, 2, 'Non corporis molestiae et magnam sit nihil itaque nobis nam vero dolore iure'),
(194, 'Rebekah Hernandez', 5, '3400000000', 5, 4, 'Esse vero adipisci consequatur nostrud quos ratione quod ut'),
(195, 'Rebekah Valdez', 3, '33333334', 2, 1, 'Sed porro aut labore consequuntur non quasi aliquid qui aut anim sunt iusto consequat nostrud et q'),
(196, 'Regan Holmes', 4, '3333333338', 2, 2, 'Velit voluptas molestias deserunt officia dolorem ut omnis deleniti quisquam sed'),
(197, 'Ricardo Andres Rojas Rico', 1, '1111122448', 2, 2, 'Crear software para ustedes.'),
(198, 'Ricardo Rojas', 1, '1111122448', 2, 2, 'Hola'),
(199, 'Ricardo Rojas Rico', 1, '7333333333', 4, 2, 'Sasaasadasas'),
(200, 'Richard', 1, '1111122448', 4, 2, 'Ut dolorem consequuntur eaque omnis non modi repellendus minima'),
(201, 'Richard Beasley', 4, '7777777777', 3, 3, 'Laborum ut placeat omnis sunt voluptas et provident error officia illo aliquid'),
(202, 'Riley Little', 3, '5555555555', 1, 1, 'Sit sit nisi corporis harum qui doloribus dolore culpa est aliquam occaecat blanditiis sed qui dol'),
(203, 'Rinah Cooper', 5, '4444225555', 4, 2, 'Quo vitae sint provident excepturi reiciendis natus eos voluptatem enim aut aut voluptatem porro '),
(204, 'Rowan Salinas', 5, '3333333333', 5, 4, 'Exercitationem cupiditate consequat labore autem qui'),
(205, 'Savannah Spence', 1, '2222222222', 5, 3, 'Aut autem omnis dignissimos temporibus lorem qui et enim placeat odio ea'),
(206, 'Scott Blair', 1, '6444444444', 3, 4, 'Sed in dolores eum aut incididunt in aut fugit ex totam iusto alias dolore'),
(207, 'Selma White', 2, '3333333333', 3, 1, 'Aut numquam voluptas tempore eaque'),
(208, 'Setmaick', 5, '7494995995', 5, 4, 'Odit repudiandae quis quia eveniet laboriosam non et id mollit qui eum et incididunt'),
(209, 'Sharon Rice', 4, '3333333333', 1, 4, 'Consectetur ipsum minim obcaecati sint ex dignissimos molestias quia ut deleniti eaque odit corrupt'),
(210, 'Shea Vaughan', 2, '2666666666', 3, 4, 'Ea quo dicta aut consequuntur quibusdam doloremque occaecat anim'),
(211, 'Sheila Wise', 3, '5222222222', 5, 3, 'Architecto repellendus perspiciatis mollit repellendus in rerum qui vel omnis fuga ipsam archite'),
(212, 'Silas Coffey', 3, '222222222', 1, 1, 'Maiores repellendus voluptates voluptatem similique'),
(213, 'Slade Sutton', 2, '4444444444', 2, 1, 'Vitae cupiditate alias aliquid exercitationem ut deserunt et accusamus laudantium consequatur dolo'),
(214, 'Sss', 1, '33353355', 2, 1, 'Rr'),
(215, 'Ssssssss', 3, '3333333', 2, 4, '3333333333'),
(216, 'Ssssssssssssssssssss', 1, '3333333333', 2, 1, 'Eeee'),
(217, 'Stone Griffin', 1, '4444444453', 1, 4, 'Occaecat obcaecati r'),
(218, 'Susan Bray', 2, '7333333333', 5, 3, 'Deserunt odio nisi facilis est soluta reprehenderit voluptatem provident'),
(219, 'Sydney Rutledge', 3, '4444444444', 2, 3, 'Quos corporis assumenda dolor molestiae'),
(220, 'Tamekah Cooper', 3, '7333333333', 4, 4, 'Voluptate amet rem delectus aspernatur pariatur qui omnis maiores quasi elit explicabo sed sit '),
(221, 'Tashya Fisher', 4, '9999999999', 2, 1, 'Totam beatae expedita velit eum rerum culpa dolorum non ea consequuntur nemo'),
(222, 'Thomas Herring', 3, '4444444444', 4, 3, 'Et asperiores ut repellendus et nemo ad'),
(223, 'Trevor Bender', 5, '3333333333', 1, 1, 'Minus pariatur nihil et illo ut velit enim laborum reprehenderit'),
(224, 'Trevor Frazier', 1, '8888888888', 4, 1, 'Qui voluptatum in aute corporis autem commodi dolore quia a eum est irure iusto aliquam nesciunt il'),
(225, 'Ursa Herrera', 3, '4444444444', 1, 2, 'Voluptas sunt distinctio quia harum repellendus commodo in irure rerum duis dolores aut vero ut i'),
(226, 'Ursula Solis', 2, '4444444444', 5, 2, 'Pariatur in eius quo quia dignissimos'),
(227, 'Vance Spencer', 4, '5555555555', 2, 4, 'Lorem totam ullamco delectus deleniti officiis ut enim voluptates qui impedit'),
(228, 'Vanna Mccall', 5, '5888888888', 1, 2, 'Voluptatem neque et molestiae cum ullam commodo vel in expedita velit laboriosam tenetur'),
(229, 'Walter Osborne', 1, '7775555555', 2, 4, 'Iure quia iusto impedit ut laborum dolore corporis quas sit sed adipisicing architecto ut qui'),
(230, 'Wylie Pope', 4, '3333333333', 1, 4, 'Consequatur veritatis in est voluptatum officia reiciendis rem dolorem aut ex maxime in mollit obc'),
(231, 'Xander Scott', 1, '4458888888', 2, 4, 'Quae qui doloremque hic enim similique enim modi quis perferendis animi consequat similique animi'),
(232, 'Xantha Bass', 4, '5555555555', 4, 3, 'Et maxime dolore qui'),
(233, 'Xena Bass', 1, '2222222222', 3, 4, 'Atque ullamco earum qui vel ex dolor'),
(234, 'Xerxes Becker', 4, '2222222222', 4, 2, 'Sunt et dolores possimus ut omnis obcaecati quo sed sint suscipit in'),
(235, 'Yael Knight', 4, '4444444444', 4, 3, 'Deserunt et illum incididunt et esse beatae voluptates quis qui ut ipsum dolore similique consequa'),
(236, 'Ynn Ellis', 3, '3333333333', 3, 3, 'Pariatur nihil sed illum perspiciatis nesciunt dolorem perferendis'),
(237, 'Yolanda Moss', 5, '4444444444', 1, 1, 'Consequatur aut esse explicabo veniam totam ex qui saepe deserunt aut quo cumque'),
(238, 'Yuli Armstrong', 2, '5585866666', 4, 1, 'Nihil ex itaque nisi in doloremque ex et suscipit velit esse illo ea est eu incididunt ipsum dolor'),
(256, 'Hugo', 1, '3985596889', 5, 4, 'Go language static site generator');

-- --------------------------------------------------------

--
-- Table structure for table `scheduling`
--

CREATE TABLE `scheduling` (
  `person_id` int(11) UNSIGNED NOT NULL COMMENT 'Campo que almacena el id de la persona agendada, llave foranea del campo id de la tabla registered people.',
  `date_filter` char(10) NOT NULL COMMENT 'Campo que guarda la fecha del agendamiento, utilizada para hacer busquedas en rango en  la base de datos.',
  `start_date` datetime NOT NULL COMMENT 'Campo que guarda la fecha y hora (datetime), de inicio de la visita a la rectoria, de la persona agendada.',
  `end_date` datetime NOT NULL COMMENT 'Campo que guarda la fecha y hora (datetime), de finalizacion de la visita a la rectoria, de la persona agendada.',
  `modification` char(8) NOT NULL COMMENT 'Campo que guarda la ultima hora de modificacion (time), del registro en la base de datos.',
  `status` enum('presence','absence') NOT NULL COMMENT 'Campo que guarda el tipo de agendamiento realizado, puede ser de dos tipos,agendamiento programado o agendamiento al dia.',
  `color` char(7) NOT NULL DEFAULT '#388cdc' COMMENT 'Campo que guarda un valor de texto correspondiente al color que tendra el registro al ser agendado.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena todos los agendamientos en fecha del aplicativo.';

--
-- Dumping data for table `scheduling`
--

INSERT INTO `scheduling` (`person_id`, `date_filter`, `start_date`, `end_date`, `modification`, `status`, `color`) VALUES
(1, '2022-12-05', '2022-12-05 06:00:00', '2022-12-05 07:30:00', '08:08:25', 'absence', '#5ec4fc'),
(2, '2022-12-05', '2022-12-05 10:00:00', '2022-12-05 13:00:00', '08:09:25', 'absence', '#75b6df'),
(3, '2022-12-09', '2022-12-09 20:10:05', '2022-12-09 20:10:05', '08:10:05', 'absence', '#388cdc'),
(4, '2022-12-01', '2022-12-01 06:30:00', '2022-12-01 08:30:00', '08:17:39', 'absence', '#4ddf48'),
(5, '2022-12-02', '2022-12-02 08:00:00', '2022-12-02 08:30:00', '08:17:50', 'absence', '#b701c5'),
(6, '2022-12-07', '2022-12-07 07:30:00', '2022-12-07 08:00:00', '09:32:08', 'absence', '#c6b703'),
(7, '2022-12-10', '2022-12-10 03:00:00', '2022-12-10 05:00:00', '02:14:44', 'absence', '#66ff00'),
(8, '2022-12-08', '2022-12-08 06:00:00', '2022-12-08 06:30:00', '02:24:16', 'absence', '#388cdc'),
(9, '2022-12-12', '2022-12-12 10:03:09', '2022-12-12 10:03:09', '03:03:09', 'absence', '#388cdc'),
(10, '2022-12-12', '2022-12-12 10:04:50', '2022-12-12 10:04:50', '03:04:43', 'absence', '#388cdc'),
(11, '2022-12-12', '2022-12-12 10:04:50', '2022-12-12 10:04:50', '03:04:43', 'absence', '#388cdc'),
(12, '2022-12-12', '2022-12-12 15:00:00', '2022-12-12 15:30:00', '03:04:57', 'presence', '#dc3838'),
(13, '2022-12-12', '2022-12-12 10:05:53', '2022-12-12 10:05:53', '03:05:46', 'absence', '#388cdc'),
(14, '2022-12-13', '2022-12-13 09:00:00', '2022-12-13 12:30:00', '03:09:05', 'absence', '#388cdc'),
(15, '2022-12-12', '2022-12-12 10:22:41', '2022-12-12 10:22:41', '03:22:42', 'absence', '#388cdc'),
(16, '2022-12-13', '2022-12-13 07:30:00', '2022-12-13 10:00:00', '06:29:19', 'presence', '#26e600'),
(17, '2022-12-17', '2022-12-17 22:33:32', '2022-12-17 22:33:32', '10:33:32', 'absence', '#388cdc'),
(18, '2022-12-17', '2022-12-17 22:33:50', '2022-12-17 22:33:50', '10:33:50', 'absence', '#388cdc'),
(19, '2022-12-17', '2022-12-17 22:34:51', '2022-12-17 22:34:51', '10:34:51', 'absence', '#388cdc'),
(20, '2022-12-17', '2022-12-17 22:35:59', '2022-12-17 22:35:59', '10:35:59', 'absence', '#388cdc'),
(21, '2022-12-20', '2022-12-20 07:00:00', '2022-12-20 08:30:00', '11:41:36', 'presence', '#f97d68'),
(22, '2022-12-20', '2022-12-20 09:31:17', '2022-12-20 09:31:17', '09:31:17', 'absence', '#388cdc'),
(23, '2022-12-21', '2022-12-21 07:00:00', '2022-12-21 08:00:00', '09:31:37', 'presence', '#19689f'),
(24, '2022-12-22', '2022-12-22 06:30:00', '2022-12-22 08:30:00', '09:32:28', 'presence', '#1ec831'),
(25, '2022-12-20', '2022-12-20 10:05:11', '2022-12-20 10:05:11', '10:05:10', 'absence', '#388cdc'),
(26, '2022-12-20', '2022-12-20 10:22:20', '2022-12-20 10:22:20', '10:22:20', 'absence', '#388cdc'),
(27, '2022-12-20', '2022-12-20 10:31:30', '2022-12-20 10:31:30', '10:31:29', 'absence', '#388cdc'),
(28, '2022-12-29', '2022-12-29 07:30:00', '2022-12-29 10:00:00', '06:15:57', 'absence', '#388cdc'),
(29, '2022-12-28', '2022-12-28 08:00:00', '2022-12-28 11:30:00', '06:31:18', 'absence', '#388cdc'),
(30, '2023-01-03', '2023-01-03 19:07:22', '2023-01-03 19:07:22', '07:07:23', 'absence', '#388cdc'),
(31, '2023-01-10', '2023-01-10 02:30:00', '2023-01-10 03:00:00', '07:08:00', 'absence', '#32b6c0'),
(32, '2023-01-03', '2023-01-03 19:18:13', '2023-01-03 19:18:13', '07:18:13', 'absence', '#388cdc'),
(33, '2023-01-03', '2023-01-03 19:19:18', '2023-01-03 19:19:18', '07:19:18', 'absence', '#388cdc'),
(34, '2023-01-04', '2023-01-04 13:37:13', '2023-01-04 13:37:13', '01:37:14', 'absence', '#388cdc'),
(35, '2023-01-04', '2023-01-04 21:56:29', '2023-01-04 21:56:29', '09:56:30', 'absence', '#388cdc'),
(36, '2023-01-05', '2023-01-05 08:00:00', '2023-01-05 08:30:00', '10:21:58', 'absence', '#21b81e'),
(37, '2023-01-06', '2023-01-06 08:00:00', '2023-01-06 08:30:00', '10:23:39', 'absence', '#91e4f7'),
(38, '2023-01-06', '2023-01-06 19:33:13', '2023-01-06 19:33:13', '07:33:13', 'absence', '#388cdc'),
(39, '2023-01-06', '2023-01-06 19:33:33', '2023-01-06 19:33:33', '07:33:33', 'absence', '#388cdc'),
(40, '2023-01-08', '2023-01-08 13:12:38', '2023-01-08 13:12:38', '01:12:38', 'absence', '#388cdc'),
(50, '2023-01-11', '2023-01-11 08:30:00', '2023-01-11 09:00:00', '05:31:16', 'absence', '#93d484'),
(51, '2023-01-11', '2023-01-11 06:30:00', '2023-01-11 07:00:00', '05:39:41', 'absence', '#f56434'),
(52, '2023-01-10', '2023-01-10 06:30:00', '2023-01-10 07:00:00', '05:40:49', 'absence', '#b31b09'),
(53, '2023-01-10', '2023-01-10 08:00:00', '2023-01-10 08:30:00', '05:42:02', 'absence', '#044f00'),
(57, '2023-01-11', '2023-01-11 09:30:00', '2023-01-11 10:00:00', '09:18:46', 'absence', '#1a52a6'),
(58, '2023-01-12', '2023-01-12 22:53:00', '2023-01-12 22:53:00', '10:53:00', 'absence', '#388cdc'),
(59, '2023-01-11', '2023-01-11 10:30:00', '2023-01-11 11:00:00', '10:54:10', 'absence', '#ec225f'),
(60, '2023-01-12', '2023-01-12 23:54:06', '2023-01-12 23:54:06', '11:54:06', 'absence', '#388cdc'),
(61, '2023-01-13', '2023-01-13 11:57:58', '2023-01-13 11:57:58', '11:57:58', 'absence', '#388cdc'),
(62, '2023-01-10', '2023-01-10 08:30:00', '2023-01-10 09:00:00', '11:59:36', 'absence', '#3d96cd'),
(63, '2023-01-14', '2023-01-14 11:22:25', '2023-01-14 11:22:25', '11:22:25', 'absence', '#388cdc'),
(64, '2023-01-14', '2023-01-14 11:22:45', '2023-01-14 11:22:45', '11:22:45', 'absence', '#388cdc'),
(66, '2023-01-12', '2023-01-12 07:30:00', '2023-01-12 08:00:00', '11:26:50', 'absence', '#7e0e94'),
(66, '2023-01-12', '2023-01-12 07:30:00', '2023-01-12 08:00:00', '11:26:50', 'absence', '#7e0e94'),
(68, '2023-01-12', '2023-01-12 08:30:00', '2023-01-12 09:00:00', '11:27:49', 'absence', '#3b4229'),
(68, '2023-01-12', '2023-01-12 08:30:00', '2023-01-12 09:00:00', '11:27:49', 'absence', '#3b4229'),
(70, '2023-01-12', '2023-01-12 10:30:00', '2023-01-12 11:00:00', '11:28:22', 'absence', '#085c15'),
(70, '2023-01-12', '2023-01-12 10:30:00', '2023-01-12 11:00:00', '11:28:22', 'absence', '#085c15'),
(71, '2023-01-12', '2023-01-12 09:30:00', '2023-01-12 10:00:00', '11:29:41', 'absence', '#2c7d18'),
(73, '2023-01-12', '2023-01-12 10:30:00', '2023-01-12 11:00:00', '11:29:48', 'absence', '#d921fa'),
(73, '2023-01-12', '2023-01-12 10:30:00', '2023-01-12 11:00:00', '11:29:48', 'absence', '#d921fa'),
(76, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:29:57', 'absence', '#e6c01b'),
(76, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:29:57', 'absence', '#e6c01b'),
(76, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:29:57', 'absence', '#e6c01b'),
(78, '2023-01-12', '2023-01-12 13:00:00', '2023-01-12 13:30:00', '11:30:08', 'absence', '#74f94c'),
(78, '2023-01-12', '2023-01-12 13:00:00', '2023-01-12 13:30:00', '11:30:08', 'absence', '#74f94c'),
(80, '2023-01-12', '2023-01-12 13:00:00', '2023-01-12 13:30:00', '11:30:08', 'absence', '#74f94c'),
(80, '2023-01-12', '2023-01-12 13:00:00', '2023-01-12 13:30:00', '11:30:08', 'absence', '#74f94c'),
(81, '2023-01-12', '2023-01-12 07:30:00', '2023-01-12 08:00:00', '11:36:07', 'presence', '#39745a'),
(82, '2023-01-12', '2023-01-12 09:00:00', '2023-01-12 09:30:00', '11:36:30', 'presence', '#602f07'),
(83, '2023-01-12', '2023-01-12 09:30:00', '2023-01-12 10:00:00', '11:36:56', 'presence', '#f64062'),
(84, '2023-01-12', '2023-01-12 10:00:00', '2023-01-12 10:30:00', '11:37:12', 'presence', '#0c9580'),
(87, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:38:47', 'absence', '#2291dc'),
(87, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:38:47', 'absence', '#2291dc'),
(87, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:38:47', 'absence', '#2291dc'),
(88, '2023-01-12', '2023-01-12 11:30:00', '2023-01-12 12:00:00', '11:38:47', 'absence', '#2291dc'),
(89, '2023-01-14', '2023-01-14 11:39:31', '2023-01-14 11:39:31', '11:39:31', 'absence', '#388cdc'),
(90, '2023-01-14', '2023-01-14 11:40:10', '2023-01-14 11:40:10', '11:40:10', 'absence', '#388cdc'),
(91, '2023-01-14', '2023-01-14 11:40:24', '2023-01-14 11:40:24', '11:40:24', 'absence', '#388cdc'),
(92, '2023-01-14', '2023-01-14 11:40:33', '2023-01-14 11:40:33', '11:40:32', 'absence', '#388cdc'),
(93, '2023-01-14', '2023-01-14 11:40:54', '2023-01-14 11:40:54', '11:40:54', 'absence', '#388cdc'),
(94, '2023-01-14', '2023-01-14 11:41:18', '2023-01-14 11:41:18', '11:41:18', 'absence', '#388cdc'),
(95, '2023-01-14', '2023-01-14 12:01:00', '2023-01-14 12:01:00', '12:01:00', 'absence', '#388cdc'),
(96, '2023-01-14', '2023-01-14 12:03:15', '2023-01-14 12:03:15', '12:03:15', 'absence', '#388cdc'),
(99, '2023-01-12', '2023-01-12 15:00:00', '2023-01-12 15:30:00', '12:25:11', 'presence', '#eca964'),
(100, '2023-01-12', '2023-01-12 15:00:00', '2023-01-12 15:30:00', '12:25:11', 'absence', '#eca964'),
(100, '2023-01-12', '2023-01-12 15:00:00', '2023-01-12 15:30:00', '12:25:11', 'absence', '#eca964'),
(101, '2023-01-12', '2023-01-12 15:00:00', '2023-01-12 15:30:00', '12:25:12', 'absence', '#eca964'),
(101, '2023-01-12', '2023-01-12 15:00:00', '2023-01-12 15:30:00', '12:25:12', 'absence', '#eca964'),
(102, '2023-01-14', '2023-01-14 12:55:16', '2023-01-14 12:55:16', '12:55:16', 'absence', '#388cdc'),
(103, '2023-01-14', '2023-01-14 13:17:01', '2023-01-14 13:17:01', '01:17:01', 'absence', '#388cdc'),
(105, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(106, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(111, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(110, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(111, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(111, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(111, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(111, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(112, '2023-01-13', '2023-01-13 08:00:00', '2023-01-13 08:30:00', '01:17:54', 'presence', '#2e022a'),
(113, '2023-01-13', '2023-01-13 09:00:00', '2023-01-13 09:30:00', '01:19:43', 'presence', '#db1489'),
(114, '2023-01-13', '2023-01-13 11:30:00', '2023-01-13 12:00:00', '01:20:13', 'presence', '#f64e94'),
(115, '2023-01-13', '2023-01-13 12:30:00', '2023-01-13 13:00:00', '01:39:51', 'presence', '#94a1ae'),
(116, '2023-01-14', '2023-01-14 13:58:22', '2023-01-14 13:58:22', '01:58:22', 'absence', '#388cdc'),
(117, '2023-01-14', '2023-01-14 13:58:57', '2023-01-14 13:58:57', '01:58:57', 'absence', '#388cdc'),
(118, '2023-01-13', '2023-01-13 06:30:00', '2023-01-13 07:00:00', '04:26:34', 'absence', '#e57b5b'),
(119, '2023-01-15', '2023-01-15 12:44:36', '2023-01-15 12:44:36', '12:44:36', 'absence', '#388cdc'),
(120, '2023-01-15', '2023-01-15 12:47:20', '2023-01-15 12:47:20', '12:47:20', 'absence', '#388cdc'),
(121, '2023-01-15', '2023-01-15 12:48:32', '2023-01-15 12:48:32', '12:48:32', 'absence', '#388cdc'),
(122, '2023-01-15', '2023-01-15 12:51:02', '2023-01-15 12:51:02', '12:51:02', 'absence', '#388cdc'),
(123, '2023-01-12', '2023-01-12 04:30:00', '2023-01-12 05:00:00', '06:13:04', 'absence', '#9cc6b5'),
(124, '2023-01-18', '2023-01-18 14:09:47', '2023-01-18 14:09:47', '02:09:47', 'absence', '#388cdc'),
(125, '2023-01-18', '2023-01-18 14:10:08', '2023-01-18 14:10:08', '02:10:08', 'absence', '#388cdc'),
(126, '2023-01-18', '2023-01-18 14:12:10', '2023-01-18 14:12:10', '02:12:10', 'absence', '#388cdc'),
(127, '2023-01-18', '2023-01-18 14:12:29', '2023-01-18 14:12:29', '02:12:29', 'absence', '#388cdc'),
(128, '2023-01-18', '2023-01-18 14:13:29', '2023-01-18 14:13:29', '02:13:29', 'absence', '#388cdc'),
(130, '2023-01-18', '2023-01-18 05:00:00', '2023-01-18 05:30:00', '02:16:08', 'presence', '#8f8ec7'),
(131, '2023-01-18', '2023-01-18 14:17:34', '2023-01-18 14:17:34', '02:17:34', 'absence', '#388cdc'),
(132, '2023-01-17', '2023-01-17 06:30:00', '2023-01-17 07:00:00', '02:31:32', 'presence', '#2eaa17'),
(133, '2023-01-16', '2023-01-16 04:00:00', '2023-01-16 04:30:00', '04:08:47', 'presence', '#e0e473'),
(134, '2023-01-21', '2023-01-21 15:14:34', '2023-01-21 15:14:34', '03:14:34', 'absence', '#388cdc'),
(135, '2023-01-21', '2023-01-21 15:18:27', '2023-01-21 15:18:27', '03:18:26', 'absence', '#388cdc'),
(136, '2023-01-21', '2023-01-21 15:19:16', '2023-01-21 15:19:16', '03:19:16', 'absence', '#388cdc'),
(137, '2023-01-21', '2023-01-21 15:19:26', '2023-01-21 15:19:26', '03:19:25', 'absence', '#388cdc'),
(138, '2023-01-21', '2023-01-21 15:31:37', '2023-01-21 15:31:37', '03:31:36', 'absence', '#388cdc'),
(139, '2023-01-21', '2023-01-21 15:32:15', '2023-01-21 15:32:15', '03:32:14', 'absence', '#388cdc'),
(140, '2023-01-21', '2023-01-21 15:34:42', '2023-01-21 15:34:42', '03:34:41', 'absence', '#388cdc'),
(141, '2023-01-21', '2023-01-21 16:18:12', '2023-01-21 16:18:12', '04:18:12', 'absence', '#388cdc'),
(142, '2023-01-20', '2023-01-20 05:00:00', '2023-01-20 05:30:00', '05:30:21', 'presence', '#388cdc'),
(143, '2023-01-21', '2023-01-21 17:31:24', '2023-01-21 17:31:24', '05:31:24', 'absence', '#388cdc'),
(144, '2023-01-19', '2023-01-19 03:30:00', '2023-01-19 04:00:00', '05:33:26', 'presence', '#01740f'),
(145, '2023-01-19', '2023-01-19 05:30:00', '2023-01-19 06:00:00', '05:34:10', 'presence', '#4094a5'),
(146, '2023-01-19', '2023-01-19 06:30:00', '2023-01-19 07:00:00', '05:34:50', 'presence', '#867af2'),
(147, '2023-01-21', '2023-01-21 22:37:07', '2023-01-21 22:37:07', '10:37:07', 'absence', '#388cdc'),
(148, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:30', 'presence', '#5d0055'),
(149, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:36', 'presence', '#d23202'),
(150, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:41', 'presence', '#41daa6'),
(151, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:45', 'presence', '#005810'),
(152, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:49', 'presence', '#31bb8d'),
(153, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:54', 'presence', '#8c845e'),
(154, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:37:58', 'presence', '#308835'),
(155, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:06', 'presence', '#0aedb0'),
(156, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:11', 'presence', '#933055'),
(157, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:16', 'presence', '#d2b7db'),
(158, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:20', 'presence', '#808cd0'),
(159, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:27', 'presence', '#621f9f'),
(160, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:33', 'presence', '#c2f2db'),
(161, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:37', 'presence', '#161a6a'),
(162, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:49', 'presence', '#e5f3d4'),
(163, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:53', 'presence', '#fa8054'),
(164, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:38:57', 'presence', '#5a5da9'),
(165, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:02', 'presence', '#ce3c1b'),
(166, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:08', 'presence', '#a404d9'),
(167, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:13', 'presence', '#c72a7d'),
(168, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:17', 'presence', '#37ae4f'),
(169, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:21', 'presence', '#b48e44'),
(170, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:25', 'presence', '#ef8078'),
(171, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:30', 'presence', '#0ffc5b'),
(172, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:34', 'presence', '#e395bd'),
(173, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:37', 'presence', '#ff8a7c'),
(174, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:41', 'presence', '#7910c5'),
(175, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:44', 'presence', '#f5c0a8'),
(176, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:54', 'presence', '#5c85e1'),
(177, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:39:59', 'presence', '#445db3'),
(178, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:40:08', 'presence', '#ef2b48'),
(179, '2023-01-18', '2023-01-18 04:00:00', '2023-01-18 04:30:00', '10:40:14', 'presence', '#8d10a7'),
(180, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:40:43', 'presence', '#15f915'),
(181, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:40:50', 'presence', '#38de31'),
(182, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:40:56', 'presence', '#9ce1bc'),
(183, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:00', 'presence', '#37a86c'),
(184, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:04', 'presence', '#0d46d3'),
(185, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:08', 'presence', '#6ed234'),
(186, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:11', 'presence', '#7688c8'),
(187, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:15', 'presence', '#6c8118'),
(188, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:21', 'presence', '#87f7f5'),
(189, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:24', 'presence', '#3a5f21'),
(190, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:30', 'presence', '#361ebf'),
(191, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:34', 'presence', '#f3b136'),
(192, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:38', 'presence', '#544854'),
(193, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:43', 'presence', '#359db6'),
(194, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:47', 'presence', '#83c9b9'),
(195, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:53', 'presence', '#b6510d'),
(196, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:41:58', 'presence', '#ee9197'),
(197, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:04', 'presence', '#b7995c'),
(198, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:09', 'presence', '#bb9ceb'),
(199, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:12', 'presence', '#822669'),
(200, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:20', 'presence', '#56ea49'),
(201, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:26', 'presence', '#9f490c'),
(202, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:31', 'presence', '#0b320d'),
(203, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:35', 'presence', '#b3f552'),
(204, '2023-01-17', '2023-01-17 04:00:00', '2023-01-17 04:30:00', '10:42:40', 'presence', '#5c674b'),
(205, '2023-01-22', '2023-01-22 22:03:41', '2023-01-22 22:03:41', '10:03:41', 'absence', '#388cdc'),
(206, '2023-01-18', '2023-01-18 06:30:00', '2023-01-18 07:00:00', '10:32:35', 'presence', '#482976'),
(207, '2023-01-19', '2023-01-19 04:30:00', '2023-01-19 05:00:00', '10:34:58', 'presence', '#1cd347'),
(208, '2023-01-19', '2023-01-19 04:30:00', '2023-01-19 05:00:00', '10:35:11', 'presence', '#01805b'),
(209, '2023-01-20', '2023-01-20 03:00:00', '2023-01-20 03:30:00', '10:36:12', 'presence', '#7470cc'),
(210, '2023-01-22', '2023-01-22 22:40:01', '2023-01-22 22:40:01', '10:40:00', 'absence', '#388cdc'),
(211, '2023-01-18', '2023-01-18 07:00:00', '2023-01-18 07:30:00', '10:40:36', 'presence', '#f1b6b3'),
(212, '2023-01-28', '2023-01-28 22:07:50', '2023-01-28 22:07:50', '10:07:50', 'absence', '#388cdc'),
(213, '2023-01-28', '2023-01-28 22:23:47', '2023-01-28 22:23:47', '10:23:47', 'absence', '#388cdc'),
(214, '2023-01-28', '2023-01-28 22:24:07', '2023-01-28 22:24:07', '10:24:07', 'absence', '#388cdc'),
(215, '2023-01-28', '2023-01-28 22:24:33', '2023-01-28 22:24:33', '10:24:33', 'absence', '#388cdc'),
(216, '2023-01-28', '2023-01-28 22:24:52', '2023-01-28 22:24:52', '10:24:52', 'absence', '#388cdc'),
(217, '2023-01-28', '2023-01-28 22:25:08', '2023-01-28 22:25:08', '10:25:08', 'absence', '#388cdc'),
(218, '2023-01-28', '2023-01-28 22:25:24', '2023-01-28 22:25:24', '10:25:23', 'absence', '#388cdc'),
(219, '2023-01-28', '2023-01-28 22:26:04', '2023-01-28 22:26:04', '10:26:04', 'absence', '#388cdc'),
(220, '2023-01-28', '2023-01-28 23:22:31', '2023-01-28 23:22:31', '11:22:31', 'absence', '#388cdc'),
(221, '2023-01-28', '2023-01-28 23:23:58', '2023-01-28 23:23:58', '11:23:58', 'absence', '#388cdc'),
(222, '2023-01-28', '2023-01-28 23:24:28', '2023-01-28 23:24:28', '11:24:28', 'absence', '#388cdc'),
(223, '2023-01-27', '2023-01-27 07:00:00', '2023-01-27 07:30:00', '03:48:01', 'presence', '#f015c0'),
(224, '2023-01-30', '2023-01-30 20:34:49', '2023-01-30 20:34:49', '08:34:49', 'absence', '#388cdc'),
(225, '2023-01-30', '2023-01-30 22:40:10', '2023-01-30 22:40:10', '10:40:10', 'absence', '#388cdc'),
(226, '2023-01-31', '2023-01-31 09:52:21', '2023-01-31 09:52:21', '09:52:21', 'absence', '#388cdc'),
(227, '2023-01-31', '2023-01-31 13:21:00', '2023-01-31 13:21:00', '01:20:59', 'absence', '#388cdc'),
(228, '2023-02-03', '2023-02-03 08:00:00', '2023-02-03 09:00:00', '01:21:29', 'absence', '#c01acc'),
(229, '2023-02-03', '2023-02-03 04:00:00', '2023-02-03 04:30:00', '01:21:56', 'absence', '#1f2196'),
(230, '2023-02-03', '2023-02-03 05:00:00', '2023-02-03 05:30:00', '01:22:24', 'absence', '#02c0ae'),
(231, '2023-02-02', '2023-02-02 21:00:00', '2023-02-02 21:30:00', '01:39:41', 'absence', '#3434bc'),
(232, '2023-01-31', '2023-01-31 13:40:19', '2023-01-31 13:40:19', '01:40:18', 'absence', '#388cdc'),
(233, '2023-02-03', '2023-02-03 20:00:00', '2023-02-03 20:30:00', '01:51:21', 'absence', '#66796b'),
(234, '2023-02-03', '2023-02-03 19:30:00', '2023-02-03 20:00:00', '01:54:36', 'absence', '#a8f328'),
(235, '2023-02-03', '2023-02-03 20:00:00', '2023-02-03 20:30:00', '01:55:54', 'absence', '#7c1ea8'),
(236, '2023-02-03', '2023-02-03 21:00:00', '2023-02-03 21:30:00', '01:57:03', 'absence', '#740d2a'),
(237, '2023-01-31', '2023-01-31 19:23:55', '2023-01-31 19:23:55', '07:23:55', 'absence', '#388cdc'),
(238, '2023-02-04', '2023-02-04 12:10:30', '2023-02-04 12:10:30', '12:10:30', 'absence', '#388cdc'),
(239, '2023-02-04', '2023-02-04 12:25:12', '2023-02-04 12:25:12', '12:25:11', 'absence', '#388cdc'),
(240, '2023-02-04', '2023-02-04 12:59:39', '2023-02-04 12:59:39', '12:59:39', 'absence', '#388cdc'),
(241, '2023-02-04', '2023-02-04 14:58:19', '2023-02-04 14:58:19', '02:58:19', 'absence', '#388cdc'),
(242, '2023-02-07', '2023-02-07 12:17:33', '2023-02-07 12:17:33', '12:17:33', 'absence', '#388cdc'),
(243, '2023-02-07', '2023-02-07 12:58:44', '2023-02-07 12:58:44', '12:58:43', 'absence', '#388cdc'),
(244, '2023-02-07', '2023-02-07 13:38:34', '2023-02-07 13:38:34', '01:38:33', 'absence', '#388cdc'),
(245, '2023-02-09', '2023-02-09 19:00:00', '2023-02-09 19:30:00', '02:22:49', 'presence', '#c9e46c'),
(246, '2023-02-10', '2023-02-10 20:30:00', '2023-02-10 21:00:00', '02:24:57', 'presence', '#e93cae'),
(247, '2023-02-08', '2023-02-08 19:30:00', '2023-02-08 20:00:00', '04:56:16', 'absence', '#751c03'),
(248, '2023-02-10', '2023-02-10 19:00:00', '2023-02-10 19:30:00', '05:00:33', 'presence', '#5d590e'),
(249, '2023-02-10', '2023-02-10 20:00:00', '2023-02-10 20:30:00', '05:03:36', 'presence', '#6cafab'),
(250, '2023-02-09', '2023-02-09 19:00:00', '2023-02-09 21:00:00', '05:06:19', 'presence', '#47813a'),
(251, '2023-02-09', '2023-02-09 19:30:00', '2023-02-09 20:00:00', '05:07:54', 'presence', '#f7f74a'),
(252, '2023-02-08', '2023-02-08 19:00:00', '2023-02-08 19:30:00', '05:08:44', 'absence', '#df17da'),
(253, '2023-02-10', '2023-02-10 18:34:43', '2023-02-10 18:34:43', '06:34:43', 'absence', '#388cdc'),
(254, '2023-02-10', '2023-02-10 19:19:48', '2023-02-10 19:19:48', '07:19:48', 'absence', '#388cdc'),
(255, '2023-02-10', '2023-02-10 19:19:50', '2023-02-10 19:19:50', '07:19:50', 'absence', '#388cdc'),
(256, '2023-02-10', '2023-02-10 19:19:50', '2023-02-10 19:19:50', '07:19:50', 'absence', '#388cdc'),
(257, '2023-02-10', '2023-02-10 19:19:50', '2023-02-10 19:19:50', '07:19:50', 'absence', '#388cdc'),
(258, '2023-02-10', '2023-02-10 19:19:51', '2023-02-10 19:19:51', '07:19:51', 'absence', '#388cdc'),
(259, '2023-02-10', '2023-02-10 19:20:29', '2023-02-10 19:20:29', '07:20:29', 'absence', '#388cdc'),
(260, '2023-02-10', '2023-02-10 19:20:41', '2023-02-10 19:20:41', '07:20:41', 'absence', '#388cdc'),
(261, '2023-02-10', '2023-02-10 19:21:18', '2023-02-10 19:21:18', '07:21:18', 'absence', '#388cdc'),
(262, '2023-02-10', '2023-02-10 19:23:05', '2023-02-10 19:23:05', '07:23:05', 'absence', '#388cdc'),
(263, '2023-02-10', '2023-02-10 19:23:07', '2023-02-10 19:23:07', '07:23:07', 'absence', '#388cdc'),
(264, '2023-02-10', '2023-02-10 19:23:07', '2023-02-10 19:23:07', '07:23:07', 'absence', '#388cdc'),
(265, '2023-02-10', '2023-02-10 19:23:07', '2023-02-10 19:23:07', '07:23:07', 'absence', '#388cdc'),
(266, '2023-02-10', '2023-02-10 19:23:09', '2023-02-10 19:23:09', '07:23:09', 'absence', '#388cdc'),
(267, '2023-02-10', '2023-02-10 19:23:09', '2023-02-10 19:23:09', '07:23:09', 'absence', '#388cdc'),
(268, '2023-02-10', '2023-02-10 19:23:09', '2023-02-10 19:23:09', '07:23:09', 'absence', '#388cdc'),
(269, '2023-02-10', '2023-02-10 19:23:09', '2023-02-10 19:23:09', '07:23:09', 'absence', '#388cdc'),
(270, '2023-02-10', '2023-02-10 19:23:10', '2023-02-10 19:23:10', '07:23:10', 'absence', '#388cdc'),
(271, '2023-02-10', '2023-02-10 19:23:10', '2023-02-10 19:23:10', '07:23:10', 'absence', '#388cdc'),
(272, '2023-02-10', '2023-02-10 19:23:10', '2023-02-10 19:23:10', '07:23:10', 'absence', '#388cdc'),
(273, '2023-02-10', '2023-02-10 19:23:10', '2023-02-10 19:23:10', '07:23:10', 'absence', '#388cdc'),
(274, '2023-02-10', '2023-02-10 19:23:10', '2023-02-10 19:23:10', '07:23:10', 'absence', '#388cdc'),
(275, '2023-02-10', '2023-02-10 19:23:11', '2023-02-10 19:23:11', '07:23:11', 'absence', '#388cdc'),
(276, '2023-02-10', '2023-02-10 19:23:11', '2023-02-10 19:23:11', '07:23:11', 'absence', '#388cdc'),
(277, '2023-02-10', '2023-02-10 19:23:11', '2023-02-10 19:23:11', '07:23:11', 'absence', '#388cdc'),
(278, '2023-02-10', '2023-02-10 19:23:12', '2023-02-10 19:23:12', '07:23:12', 'absence', '#388cdc'),
(279, '2023-02-10', '2023-02-10 19:24:12', '2023-02-10 19:24:12', '07:24:12', 'absence', '#388cdc'),
(280, '2023-02-10', '2023-02-10 19:24:12', '2023-02-10 19:24:12', '07:24:12', 'absence', '#388cdc'),
(281, '2023-02-10', '2023-02-10 19:24:48', '2023-02-10 19:24:48', '07:24:48', 'absence', '#388cdc'),
(282, '2023-02-10', '2023-02-10 19:25:55', '2023-02-10 19:25:55', '07:25:55', 'absence', '#388cdc'),
(283, '2023-02-09', '2023-02-09 00:00:00', '2023-02-10 00:00:00', '07:30:10', 'presence', '#9aa874'),
(284, '2023-02-11', '2023-02-11 20:20:30', '2023-02-11 20:20:30', '08:20:30', 'absence', '#388cdc'),
(285, '2023-02-10', '2023-02-10 01:00:00', '2023-02-10 01:30:00', '08:21:07', 'presence', '#664cfe'),
(286, '2023-02-11', '2023-02-11 21:53:36', '2023-02-11 21:53:36', '09:53:36', 'absence', '#388cdc'),
(287, '2023-02-11', '2023-02-11 21:57:07', '2023-02-11 21:57:07', '09:57:07', 'absence', '#388cdc'),
(288, '2023-02-10', '2023-02-10 00:00:00', '2023-02-10 00:30:00', '11:04:26', 'presence', '#291743'),
(289, '2023-02-11', '2023-02-11 00:30:00', '2023-02-11 02:30:00', '11:07:00', 'presence', '#61235c'),
(290, '2023-02-10', '2023-02-10 01:30:00', '2023-02-10 02:00:00', '11:10:45', 'presence', '#cecf77'),
(291, '2023-02-08', '2023-02-08 01:30:00', '2023-02-08 02:00:00', '11:11:29', 'presence', '#1d5202'),
(292, '2023-02-12', '2023-02-12 11:51:12', '2023-02-12 11:51:12', '11:51:12', 'absence', '#388cdc'),
(256, '2023-04-03', '2023-04-03 16:05:05', '2023-04-03 16:05:05', '04:05:39', 'absence', '#388cdc');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(1) NOT NULL COMMENT 'Campo que guarda el id de los usuarios del aplicativo, con acceso permitido (unique).',
  `name` varchar(25) NOT NULL COMMENT 'Campo que guarda el nombre de los usuarios del aplicativo, con acceso permitido.',
  `lastname` varchar(25) NOT NULL COMMENT 'Campo que guarda el apellido de los usuarios del aplicativo, con acceso permitido.',
  `id_doc` tinyint(1) NOT NULL COMMENT 'Campo que almacena el id del tipo de documento, de la tabla document.',
  `num_doc` char(11) NOT NULL COMMENT 'Campo que guarda el numero de documento.',
  `tel` char(10) NOT NULL COMMENT 'Campo que guarda el numero de telefono de contacto.',
  `email` varchar(30) NOT NULL COMMENT 'Campo que guarda el correo electronico institucional o usuario de acceso al aplicativo.',
  `password` varchar(80) NOT NULL COMMENT 'Campo que guarda el password de acceso al aplicativo (encriptado).',
  `role` enum('admin','rector','secretaria') NOT NULL COMMENT 'Campo que guarda el rol que tiene el usaurio, existen 3: admin, rector, secretaria.',
  `permissions` set('admin','add','schedule','reports','statistics') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='Tabla que almacena los usuarios del aplicativo, y sus respectivos usuarios y password de acceso al aplicativo.';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `id_doc`, `num_doc`, `tel`, `email`, `password`, `role`, `permissions`) VALUES
(1, 'Mario Fernando', 'Díaz Pava', 0, '7223309043', '3100000000', 'rectoria@itfip.edu.co', '$2y$10$ulcGJ5S/NodjeQmPo1wTL.rISkGNJ5th9ejXf6kJqdwlm/8yAZxYm', 'rector', 'schedule'),
(2, 'Luz Elena', 'Avila', 1, '11111111111', '3100000000', 'secretaria@itfip.edu.co', '$2y$10$ISfxYUjrGFnjZAup3yeNY./5Vyj3X88LmxudLTN.lKKlMSuApH45W', 'secretaria', 'add,schedule,reports,statistics'),
(3, 'admin', 'admin', 1, '1111122448', '3173926578', 'admin@itfip.edu.co', '$2y$10$DQArhuEW5Z4GmY9QwmZJzuc4VAnTYPIygOP5MmQburwfqtMSfEk.S', 'admin', 'admin,add,schedule,reports,statistics');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deans`
--
ALTER TABLE `deans`
  ADD PRIMARY KEY (`cc`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document` (`id_doc`),
  ADD KEY `id_facultied` (`facultad`) USING BTREE,
  ADD KEY `person_type` (`person_type`) USING BTREE;

--
-- Indexes for table `scheduling`
--
ALTER TABLE `scheduling`
  ADD KEY `people_id` (`person_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_doc` (`id_doc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id del tipo de persona (autoincremental).', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id del tipo de documento, (autoincremental).', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id de la facultad, (autoincremental).', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo que guarda el id de las personas agendadas (autoincremental).', AUTO_INCREMENT=257;
COMMIT;