-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2016 at 09:49 PM
-- Server version: 5.5.52-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `businessCMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE IF NOT EXISTS `aboutus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`id`, `heading`, `content`, `image`, `image_align`, `loc_id`) VALUES
(1, 'About Us', '<p>Lorem ipsum dolor sit amet, bonorum iracundia ex ius, sit modo quodsi cu, vitae omnesque no cum. In cotidieque adversarium vis, timeam sanctus alienum ad vim, nonumy vituperatoribus ei sea. No eam essent platonem, illud splendide an mel, ea mentitum officiis scripserit ius. Harum primis per in, duo cu ancillae disputationi, te pri causae tritani torquatos. Liber doming iracundia et his. An eros brute solet mei, abhorreant omittantur per te. Vim an labitur probatus, ea ius fugit omnesque aliquando.</p>\r\n<p>Inani singulis efficiantur ut mel, et regione repudiare ius. Et cibo commodo signiferumque cum. Tibique singulis nam id, aliquid mediocrem definitiones nam ne. Erant incorrupte eu nec, ex modus aperiri forensibus nam, eu ius bonorum adipisci theophrastus. Soleat animal liberavisse id eos, illum intellegam te est. Per velit ludus ne, diceret recusabo voluptaria usu et. Eu mea prodesset scriptorem.</p>', 'Ubuntu-Mate-Radioactive-no-logo.png', 'left', 1),
(2, 'test 2', '<p>test 2</p>', 'MapBackground2.png', 'right', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `nav_loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `nav_loc_id`) VALUES
(0, 'None', 1),
(45, 'test 2', 2),
(46, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` text NOT NULL,
  `introtext` text NOT NULL,
  `mapcode` text NOT NULL,
  `email` text NOT NULL,
  `sendtoemail` text NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zipcode` text NOT NULL,
  `phone` text NOT NULL,
  `hours` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `heading`, `introtext`, `mapcode`, `email`, `sendtoemail`, `address`, `city`, `state`, `zipcode`, `phone`, `hours`, `loc_id`) VALUES
(1, 'Contact Us', 'The White House', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.1503819264844!2d-77.03871848464966!3d38.897676279570575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7b7bcdecbb1df%3A0x715969d86d0b76bf!2sThe+White+House!5e0!3m2!1sen!2sus!4v1479220635842" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>', 'ryanjones153@gmail.com', 'ryanjones153@gmail.com', '1600 Pennsylvania Ave NW', 'Washington', 'DC', '20500', '555-5555', '9-5', 1),
(2, 'Contact 2', 'Contact Us', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.1503819264844!2d-77.03871848464966!3d38.897676279570575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7b7bcdecbb1df%3A0x715969d86d0b76bf!2sThe+White+House!5e0!3m2!1sen!2sus!4v1479220635842" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>', 'ryan@email.com', 'ryan@email.com', '1600 Pennsylvania Ave NW', 'Washington', 'DC', '20500', '555-5555', '9-5 M-F, 9-3 Sat', 2);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `image`, `name`, `link`, `active`, `datetime`, `loc_id`) VALUES
(4, 'webide.png', 'Darpa', 'http://www.darpa.gov', 'true', '2016-11-15 22:00:19', 1),
(5, 'webide.png', 'DISA', 'http://www.disa.gov', 'true', '2016-11-15 21:59:45', 1),
(6, 'webide.png', 'Bill and Melinda Gate Foundation', 'http://www.billgates.gov', 'true', '2016-11-15 21:59:57', 1),
(7, 'webide.png', 'CFPB', 'http://www.cfpb.gov', 'true', '2016-11-15 21:59:34', 1),
(8, 'webide.png', 'Cal OES', 'http://www.darpa.gov', 'true', '2016-11-29 14:49:45', 1),
(9, 'webide.png', 'Darpa', 'http://www.darpa.gov', 'true', '2016-11-15 22:00:19', 2),
(10, 'webide.png', 'DISA', 'http://www.disa.gov', 'true', '2016-11-15 21:59:45', 2),
(11, 'webide.png', 'Bill and Melinda Gate Foundation', 'http://www.billgates.gov', 'true', '2016-11-15 21:59:57', 2),
(12, 'webide.png', 'CFPB', 'http://www.cfpb.gov', 'true', '2016-11-15 21:59:34', 2),
(13, 'webide.png', 'Cal OES', 'http://www.darpa.gov', 'true', '2016-11-29 14:49:45', 2);

-- --------------------------------------------------------

--
-- Table structure for table `featured`
--

CREATE TABLE IF NOT EXISTS `featured` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` text NOT NULL,
  `introtext` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `featured`
--

INSERT INTO `featured` (`id`, `heading`, `introtext`, `content`, `image`, `image_align`, `loc_id`) VALUES
(1, 'Seeking Online Access to Resources', '', '<p>Welcome to the Chicago Public Schools Integrated Library System...Bringing together print and electronic materials for students and teachers who are Seeking Online Access to Resources.</p>', 'HSWorkingGroup.png', 'right', 1),
(2, 'featured two', '', '', 'HSWorkingGroup.png', 'right', 2);

-- --------------------------------------------------------

--
-- Table structure for table `generalinfo`
--

CREATE TABLE IF NOT EXISTS `generalinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `generalinfo`
--

INSERT INTO `generalinfo` (`id`, `heading`, `content`, `loc_id`) VALUES
(1, 'Resources', '<ul>\r\n<li><a href="#">Instructables.com</a></li>\r\n<li><a href="#">GitHub</a></li>\r\n<li><a href="#" target="_blank">Freelancer</a></li>\r\n</ul>', 1),
(2, 'General Info 2', '<p>test</p>', 2);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `active` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=468 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `active`) VALUES
(1, 'CPS', 'true'),
(2, 'Curie Metro High School', 'true'),
(3, 'Northside Prep High School', 'true'),
(4, 'Hyde Park High School', 'true'),
(5, 'Crane Tech Prep', 'true'),
(6, 'DuSable Campus', 'true'),
(7, 'Amundsen High School', 'true'),
(8, 'Professional Library', 'true'),
(9, 'Amundsen High School', 'true'),
(10, 'Barry Elementary School', 'true'),
(11, 'Belding Elementary School', 'true'),
(12, 'Budlong Elementary School', 'true'),
(13, 'Caldwell Academy', 'true'),
(14, 'Clissold Elementary School', 'true'),
(15, 'Franklin Fine Arts', 'true'),
(16, 'Fulton Elementary School', 'true'),
(17, 'Kohn Elementary School', 'true'),
(18, 'Locke Elementary School', 'true'),
(19, 'May Community', 'true'),
(20, 'Jackson Language', 'true'),
(21, 'Mt. Vernon Elementary School', 'true'),
(22, 'Mozart Elementary School', 'true'),
(23, 'The Nettelhorst School', 'true'),
(24, 'Sandoval Elementary School , Socorro', 'true'),
(25, 'Hurley Elementary School , Edward N', 'true'),
(26, 'Norwood Park Elementary School', 'true'),
(27, 'Onahan Elementary School', 'true'),
(28, 'Palmer Elementary School', 'true'),
(29, 'Pirie Elementary School', 'true'),
(30, 'Reilly Elementary School', 'true'),
(31, 'Frazier Int. Magnet', 'true'),
(32, 'Thorp Academy', 'true'),
(33, 'Twain Elementary School', 'true'),
(34, 'Whistler Elementary School, John', 'true'),
(35, 'Whitney Elementary School', 'true'),
(36, 'Douglass Academy', 'true'),
(37, 'Price Elementary School', 'true'),
(38, 'Johnson Elementary School', 'true'),
(39, 'Davis Academy', 'true'),
(40, 'Higgins Community', 'true'),
(41, 'Grant Campus', 'true'),
(42, 'Marshall Middle School', 'true'),
(43, 'LaSalle II Magnet', 'true'),
(44, 'DePriest Elementary School', 'true'),
(45, 'Harlan High School', 'true'),
(46, 'Tilden High School', 'true'),
(47, 'Vaughn Occ High School', 'true'),
(48, 'Uplift Community High School', 'true'),
(49, 'Haley Academy Elementary School', 'true'),
(50, 'Cameron Elementary School', 'true'),
(51, 'Copernicus Elementary School', 'true'),
(52, 'Gale Academy', 'true'),
(53, 'Greene Elementary School', 'true'),
(54, 'Gunsaulus Academy', 'true'),
(55, 'Kershaw Elementary School', 'true'),
(56, 'Lloyd Elementary School', 'true'),
(57, 'Mayer Magnet', 'true'),
(58, 'Keller Magnet Elementary School', 'true'),
(59, 'Owen Academy', 'true'),
(60, 'Pasteur Elementary School', 'true'),
(61, 'Prussing Elementary School', 'true'),
(62, 'Pulaski International School of Chicago', 'true'),
(63, 'Armstrong L Elementary School', 'true'),
(64, 'Spencer Academy', 'true'),
(65, 'Stockton Elementary School', 'true'),
(66, 'Trumbull Elementary School', 'true'),
(67, 'Banneker Elementary School', 'true'),
(68, 'Dumas Elementary School', 'true'),
(69, 'Woods Academy Elementary School', 'true'),
(70, 'Lenart Gifted', 'true'),
(71, 'Payton Coll Prep High School', 'true'),
(72, 'Little Village High School Campus', 'true'),
(73, 'Hancock Coll Prep', 'true'),
(74, 'Fenger High School', 'true'),
(75, 'Robeson High School', 'true'),
(76, 'Hirsch Metro High School', 'true'),
(77, 'Kennedy High School', 'true'),
(78, 'Lake View High School', 'true'),
(79, 'Manley High School', 'true'),
(80, 'Brooks Coll Prep High School', 'true'),
(81, 'Schurz High School', 'true'),
(82, 'Senn Campus', 'true'),
(83, 'Taft High School', 'true'),
(84, 'Lincoln Park High School', 'true'),
(85, 'Wells Academy High School', 'true'),
(86, 'Chicago Military High School', 'true'),
(87, 'Orr Academy High School', 'true'),
(88, 'Carver Military High School', 'true'),
(89, 'Corliss High School', 'true'),
(90, 'Armstrong G Elementary School', 'true'),
(91, 'Beaubien Elementary School', 'true'),
(92, 'Bradwell Elementary School', 'true'),
(93, 'Bridge Elementary School', 'true'),
(94, 'Cassell Elementary School', 'true'),
(95, 'Greeley Elementary School', 'true'),
(96, 'Clay Elementary School', 'true'),
(97, 'Clinton Elementary School', 'true'),
(98, 'Coles Academy', 'true'),
(99, 'Columbus Elementary School', 'true'),
(100, 'Jordan Community', 'true'),
(101, 'Eberhart Elementary School', 'true'),
(102, 'Edwards Elementary School', 'true'),
(103, 'Emmet Elementary School', 'true'),
(104, 'Ericson Academy Elementary School', 'true'),
(105, 'Kanoon Magnet Elementary School', 'true'),
(106, 'Gary Elementary School', 'true'),
(107, 'Ninos Heroes AC', 'true'),
(108, 'Hitch Elementary School', 'true'),
(109, 'Holmes Elementary School', 'true'),
(110, 'Lewis Elementary School', 'true'),
(111, 'Lowell Elementary School, James R', 'true'),
(112, 'Till Academy', 'true'),
(113, 'Moos Elementary School', 'true'),
(114, 'Morrill Elementary School', 'true'),
(115, 'Beard Elementary School', 'true'),
(116, 'Murray Lang Academy', 'true'),
(117, 'West Park Academy', 'true'),
(118, 'Parker Academy', 'true'),
(119, 'Peterson Elementary School', 'true'),
(120, 'Pickard Elementary School', 'true'),
(121, 'Reinberg Elementary School', 'true'),
(122, 'Sawyer Elementary School', 'true'),
(123, 'Scammon Elementary School', 'true'),
(124, 'Seward Academy', 'true'),
(125, 'Sexton Elementary School', 'true'),
(126, 'Mireles Academy Elementary School', 'true'),
(127, 'Shoop Academy', 'true'),
(128, 'Smyth Elementary School', 'true'),
(129, 'Swift Elementary School', 'true'),
(130, 'Talcott Elementary School', 'true'),
(131, 'Coleman Academy', 'true'),
(132, 'Tilton Elementary School', 'true'),
(133, 'Volta Elementary School', 'true'),
(134, 'Albany Park Campus', 'true'),
(135, 'Dvorak Academy', 'true'),
(136, 'Buckingham Center', 'true'),
(137, 'Ashburn Elementary School', 'true'),
(138, 'Westcott Elementary School', 'true'),
(139, 'Brighton Park Elementary School', 'true'),
(140, 'Roque de Duprey Elementary School', 'true'),
(141, 'Orozco Elementary School', 'true'),
(142, 'Ace Tech Campus', 'true'),
(143, 'Clemente Academy High School', 'true'),
(144, 'Skinner West ES', 'true'),
(145, 'Hernandez MS', 'true'),
(146, 'Dulles School of Excellence', 'true'),
(147, 'Hughes L ES', 'true'),
(148, 'Prieto ES', 'true'),
(149, 'South Shore Academy', 'true'),
(150, 'Westinghouse HS', 'true'),
(151, 'Cooper Elementary Dual Language Academy, Peter', 'true'),
(152, 'Clark Magnet High School', 'true'),
(153, 'Bethune Elementary School', 'true'),
(154, 'Blaine Elementary School', 'true'),
(155, 'Boone Elementary School', 'true'),
(156, 'Byrne Elementary School', 'true'),
(157, 'Carver Primary School', 'true'),
(158, 'Chappell Elementary School', 'true'),
(159, 'Chicago Academy High School', 'true'),
(160, 'Christopher Elementary School', 'true'),
(161, 'Daley Elementary Academy', 'true'),
(162, 'Dunbar Career Academy High School', 'true'),
(163, 'Dunne Elementary School', 'true'),
(164, 'Dvorak Elementary Specialty Academy', 'true'),
(165, 'Dyett High School', 'true'),
(166, 'Edward Coles Elementary Language Academy', 'true'),
(167, 'Farnsworth Elementary School', 'true'),
(168, 'Fort Dearborn Elementary School', 'true'),
(169, 'Garfield Park Preparatory Academy ES', 'true'),
(170, 'Garvy Elementary School, John W.', 'true'),
(171, 'Gregory Elementary School', 'true'),
(172, 'Hammond Elementary School', 'true'),
(173, 'Hancock College Preparatory High School', 'true'),
(174, 'Julian High School', 'true'),
(175, 'Kozminski Elementary Community Academy', 'true'),
(176, 'Lake View High School', 'true'),
(177, 'Marshall Metropolitan High School', 'true'),
(178, 'Nash Elementary School', 'true'),
(179, 'Ninos Heroes Elementary Academic Center', 'true'),
(180, 'Nixon Elementary School', 'true'),
(181, 'Ogden International High School', 'true'),
(182, 'Peirce International Studies ES', 'true'),
(183, 'Perez Elementary School', 'true'),
(184, 'Richards Career Academy High School', 'true'),
(185, 'Sabin Elementary Dual Language Magnet School', 'true'),
(186, 'Skinner North Classical Elementary', 'true'),
(187, 'Sullivan High School', 'true'),
(188, 'Talcott Elementary School', 'true'),
(189, 'Walsh Elementary School', 'true'),
(190, 'Ward Elementary School, James', 'true'),
(191, 'Beidler, Elementary School, Jacob', 'true'),
(192, 'Bennett Elementary School, Frank I', 'true'),
(193, 'Black Magnet Elementary School, Robert A ', 'true'),
(194, 'Black Magnet Elementary School, Robert A - Branch', 'true'),
(195, 'Brentano Math & Science Academy ES, Lorenz', 'true'),
(196, 'Burr Elementary School, Jonathan ', 'true'),
(197, 'Chase Elementary School, Salmon P', 'true'),
(198, 'Chavez Multicultural Academic Center ES, Cesar E - Lower Library', 'true'),
(199, 'Chavez Multicultural Academic Center ES, Cesar E', 'true'),
(200, 'Coonley Elementary School, John C.', 'true'),
(201, 'Disney Magnet Elementary School, Walt', 'true'),
(202, 'Durkin Park Elementary School', 'true'),
(203, 'Esmond Elementary School', 'true'),
(204, 'Falconer Elementary School, Laughlin', 'true'),
(205, 'Gage Park High School', 'true'),
(206, 'Gary Elementary School, Joseph E - New', 'true'),
(207, 'Gary Elementary School. Joseph E - Main', 'true'),
(208, 'Hale Elementary School, Nathan', 'true'),
(209, 'Hamilton Elementary School, Alexander', 'true'),
(210, 'Hanson Park Elementary School - Branch', 'true'),
(211, 'Hanson Park Elementary School - Main Library', 'true'),
(212, 'Harte Elementary School, Bret', 'true'),
(213, 'Hedges Elementary School, James ', 'true'),
(214, 'Inter-American Elementary Magnet School', 'true'),
(215, 'Juarez Community Academy High School, Benito', 'true'),
(216, 'Kenwood Academy High School', 'true'),
(217, 'LaSalle Elementary Language Academy', 'true'),
(218, 'Lindblom Math & Science Academy HS, Robert', 'true'),
(219, 'Logandale Middle School', 'true'),
(220, 'Lovett Elementary School, Joseph', 'true'),
(221, 'McAuliffe Elementary School, Sharon Christa', 'true'),
(222, 'McPherson ES', 'true'),
(223, 'Metcalfe Elementary Community Academy, Ralph H', 'true'),
(224, 'Morgan Park High School', 'true'),
(225, 'National Teachers Elementary Academy', 'true'),
(226, 'Newberry Math & Science Academy ES, Walter L.', 'true'),
(227, 'North Lawndale HS', 'true'),
(228, 'Ogden Elementary School, William B.', 'true'),
(229, 'Powell Academy Elementary School', 'true'),
(230, 'Powell Academy ES', 'true'),
(231, 'Pritzker School, A.N.', 'true'),
(232, 'Raby High School, Al', 'true'),
(233, 'Rudolph Elementary Learning Center, Wilma', 'true'),
(234, 'Ruiz Elementary School, Irma C', 'true'),
(235, 'Shoop Math-Science Technical Academy ES, John D ', 'true'),
(236, 'South Loop Elementary School', 'true'),
(237, 'Suder Montessori Magnet ES', 'true'),
(238, 'von Steuben Metropolitan Science HS, Friedrich W', 'true'),
(239, 'Washington High School, George', 'true'),
(240, 'Azuela Elementary School, Mariano', 'true'),
(241, 'Bradwell Communications Arts & Science ES, Myra', 'true'),
(242, 'Brennemann Elementary School, Joseph', 'true'),
(243, 'Calmeca Academy of Fine Arts and Dual Language', 'true'),
(244, 'Camras Elementary School, Marvin', 'true'),
(245, 'Clinton Elementary School, DeWitt', 'true'),
(246, 'Graham Training Center High School, Ray', 'true'),
(247, 'Lorca Elementary School, Federico Garcia', 'true'),
(248, 'Wadsworth Elementary School, James', 'true'),
(249, 'Zaragoza', 'true'),
(250, 'Parkman Elementary School, Francis', 'true'),
(251, 'Hammond Elementary School, Charles G', 'true'),
(252, 'Hale Elementary School, Nathan', 'true'),
(253, 'Washington Elementary School, George', 'true'),
(254, 'Solorio Academy High School, Eric', 'true'),
(255, 'Lorca Elementary School, Federico Garcia', 'true'),
(256, 'West Ridge Elementary School', 'true'),
(257, 'Fernwood Elementary School', 'true'),
(258, 'Woodson South Elementary School, Carter G', 'true'),
(259, 'Jefferson Alternative High School, Nancy B', 'true'),
(260, 'Galileo Math & Science Scholastic Academy', 'true'),
(261, 'Phillips Academy High School, Wendell', 'true'),
(262, 'Gillespie Elementary School, Frank L', 'true'),
(263, 'Lara Elementary Academy, Agustin', 'true'),
(264, 'Hibbard Elementary School, William G', 'true'),
(265, 'Funston Elementary School, Frederick', 'true'),
(266, 'Garvey Elementary School, Marcus Moziah', 'true'),
(267, 'Bowen High School', 'true'),
(268, 'Solomon Elementary School, Hannah G', 'true'),
(269, 'M. M. Garvey ES', 'true'),
(270, 'Sheridan (Mark) Math & Science Academy', 'true'),
(271, 'Kinzie Elementary School, John H', 'true'),
(272, 'Saucedo Elementary Scholastic Academy, Maria', 'true'),
(273, 'Belmont-Cragin', 'true'),
(274, 'Simeon Career Academy High School, Neal F', 'true'),
(275, 'Mather High School, Stephen T', 'true'),
(276, 'Roosevelt High School, Theodore', 'true'),
(277, 'Little Village Elementary School', 'true'),
(278, 'Lavizzo Elementary School, Mildred I', 'true'),
(279, 'Sandoval ES', 'true'),
(280, 'Chicago Academy Elementary School', 'true'),
(281, 'North River Elementary School', 'true'),
(282, 'Agassiz Elementary School, Louis A', 'true'),
(283, 'Carter Elementary School, William W', 'true'),
(284, 'Cook Elementary School, John W', 'true'),
(285, 'Dirksen Elementary School, Everett McKinley', 'true'),
(286, 'Everett Elementary School, Edward', 'true'),
(287, 'Goethe Elementary School, Johann W von', 'true'),
(288, 'Hawthorne Elementary Scholastic Academy', 'true'),
(289, 'Kelvyn Park High School', 'true'),
(290, 'Mount Greenwood Elementary School', 'true'),
(291, 'Wentworth Elementary School, Daniel S', 'true'),
(292, 'Dirksen Elementary School', 'true'),
(293, 'Chicago High School for Agricultural Sciences', 'true'),
(294, 'Ariel Elementary Community Academy', 'true'),
(295, 'Bogan High School, William J', 'true'),
(296, 'Brighton Park Elementary School', 'true'),
(297, 'Castellanos Elementary School, Rosario', 'true'),
(298, 'Claremont Academy Elementary School', 'true'),
(299, 'Cleveland Elementary School, Grover', 'true'),
(300, 'Corkery Elementary School, Daniel J', 'true'),
(301, 'Dever Elementary School', 'true'),
(302, 'Dodge Elementary Renaissance Academy, Mary Mapes', 'true'),
(303, 'Ebinger Elementary School, Christian', 'true'),
(304, 'Field Elementary School, Eugene', 'true'),
(305, 'Graham Elementary School, Alexander', 'true'),
(306, 'Hamline Elementary School, John H', 'true'),
(307, 'Henderson Elementary School, Charles R', 'true'),
(308, 'King Jr Academy of Social Justice, Dr. Martin L.', 'true'),
(309, 'Hope College Preparatory High School', 'true'),
(310, 'Jamieson Elementary School, Minnie Mars', 'true'),
(311, 'Lee Elementary School, Richard Henry', 'true'),
(312, 'Libby Elementary School, Arthur A ', 'true'),
(313, 'Linne Elementary School, Carl von', 'true'),
(314, 'Manierre Elementary School, George', 'true'),
(315, 'Marquette Elementary School', 'true'),
(316, 'Marsh Elementary School, John L', 'true'),
(317, 'McDade Elementary Classical School, James E', 'true'),
(318, 'Morton School of Excellence', 'true'),
(319, 'Namaste Charter Elementary School', 'true'),
(320, 'New Sullivan Elementary School, William K', 'true'),
(321, 'Nightingale Elementary School, Florence', 'true'),
(322, 'Pershing Elementary Humanities Magnet, John J', 'true'),
(323, 'Ray Elementary School ', 'true'),
(324, 'Sandoval Elementary School, Socorro', 'true'),
(325, 'Sayre Language Academy, Harriet', 'true'),
(326, 'Goudy Elementary School, William C', 'true'),
(327, 'Haugan Elementary School, Helge A', 'true'),
(328, 'Smyser Elementary School, Washington D', 'true'),
(329, 'South Shore International College Prep High School', 'true'),
(330, 'Spry & Community Links, John', 'true'),
(331, 'Stowe Elementary School, Harriet Beecher', 'true'),
(332, 'Tarkington School of Excellence ES', 'true'),
(333, 'Vanderpoel Elementary Magnet School, John H', 'true'),
(334, 'Von Humboldt Elementary School, Alexander', 'true'),
(335, 'Waters Elementary School, Thomas J', 'true'),
(336, 'White Elementary Career Academy, Edward', 'true'),
(337, 'Whittier Elementary School, John Greenleaf', 'true'),
(338, 'Woodlawn Community Elementary School', 'true'),
(339, 'Zapata Elementary Academy, Emiliano', 'true'),
(340, 'Fernwood Elementary School', 'true'),
(341, 'McKay Elementary School, Francis M', 'true'),
(342, 'Hayt Elementary School, Stephen K', 'true'),
(343, 'Alcott High School for the Humanities', 'true'),
(344, 'Agassiz Elementary School', 'true'),
(345, 'Canty Elementary School, Arthur E', 'true'),
(346, 'Cardenas Elementary School, Lazaro', 'true'),
(347, 'Chicago Vocational Career Academy High School', 'true'),
(348, 'Columbia Explorers Elementary Academy', 'true'),
(349, 'Edgebrook Elementary School', 'true'),
(350, 'Farragut Career Academy High School, David G', 'true'),
(351, 'Schubert Elementary School, Franz Peter ', 'true'),
(352, 'Schubert Elementary School, Franz Peter ', 'true'),
(353, 'Herzl Elementary School, Theodore', 'true'),
(354, 'Murphy Elementary School, John B', 'true'),
(355, 'Lafayette Elementary School, Jean D', 'true'),
(356, 'Melody Elementary School, Genevieve', 'true'),
(357, 'New Field Elementary School', 'true'),
(358, 'Cuffe Math-Science Technology Academy ES, Paul', 'true'),
(359, 'Portage Park Elementary School', 'true'),
(360, 'Prescott Elementary School, William H', 'true'),
(361, 'Ryerson Elementary School, Martin A', 'true'),
(362, 'Kelly High School, Thomas', 'true'),
(363, 'Young Magnet High School, Whitney M', 'true'),
(364, 'STEM Magnet Academy', 'true'),
(365, 'Stevenson Elementary School, Adlai E', 'true'),
(366, 'Talman Elementary School', 'true'),
(367, 'Drummond Elementary School, Thomas', 'true'),
(368, 'Brown Elementary Community Academy, Ronald', 'true'),
(369, 'Bright Elementary School, Orville T', 'true'),
(370, 'Ross Elementary School, Betsy', 'true'),
(371, 'White Elementary Career Academy, Edward', 'true'),
(372, 'Yates Elementary School, Richard', 'true'),
(373, 'Brunson Math & Science Specialty ES, Brunson', 'true'),
(374, 'Burley Elementary School, Augustus H', 'true'),
(375, 'Evergreen Academy Middle School', 'true'),
(376, 'Foreman High School , Edwin G', 'true'),
(377, 'Gray Elementary School, William P', 'true'),
(378, 'Neil Elementary School, Jane A', 'true'),
(379, 'Nobel Elementary School, Alfred', 'true'),
(380, 'Northwest Middle School', 'true'),
(381, 'Stone Elementary Scholastic Academy', 'true'),
(382, 'Tonti Elementary School, Enrico', 'true'),
(383, 'McCutcheon Elementary School, John T', 'true'),
(384, 'Instituto Health Sciences Career Academy HS', 'true'),
(385, 'Bateman Elementary School, Newton', 'true'),
(386, 'Beasley Elementary Magnet Academic Center, Edward', 'true'),
(387, 'Burroughs Elementary School, John C', 'true'),
(388, 'Esmond Elementary School', 'true'),
(389, 'Fermi Elementary School , Enrico', 'true'),
(390, 'Lincoln Elementary School, Abraham', 'true'),
(391, 'North-Grand High School', 'true'),
(392, 'Pilsen Elementary Community Academy', 'true'),
(393, 'Wildwood Elementary School', 'true'),
(394, 'Chicago Quest North', 'true'),
(395, 'Learn South', 'true'),
(396, 'King Jr College Prep HS, Dr Martin Luther', 'true'),
(397, 'Shields Middle School, James', 'true'),
(398, 'Bell Elementary School, Alexander Graham', 'true'),
(399, 'Falconer Elementary School, Laughlin', 'true'),
(400, 'Stewart Elementary School, Graeme', 'true'),
(401, 'Randolph Elementary School, Asa Philip', 'true'),
(402, 'Burbank Elementary School, Luther', 'true'),
(403, 'Holden Elementary School, Charles N', 'true'),
(404, 'Burley Elementary School, Augustus H', 'true'),
(405, 'Marine Leadership Academy', 'true'),
(406, 'Lyon Elementary School, Mary', 'true'),
(407, 'Carnegie Elementary School, Andrew', 'true'),
(408, 'Healy Elementary School, Robert', 'true'),
(409, 'Black Magnet Elementary School, Robert A', 'true'),
(410, 'Rogers Elementary School , Philip', 'true'),
(411, 'Montefiore Special Elementary School, Moses', 'true'),
(412, 'Haines Elementary School, John Charles', 'true'),
(413, 'Carson Elementary School, Rachel', 'true'),
(414, 'Finkl Elementary School, William F', 'true'),
(415, 'Henry Elementary School, Patrick', 'true'),
(416, 'McNair Elementary School, Ronald E', 'true'),
(417, 'Penn Elementary School, William', 'true'),
(418, 'Reavis Math & Science Specialty ES, William C', 'true'),
(419, 'Gallistel Elementary Language Academy, Mathew', 'true'),
(420, 'Ellington Elementary School, Edward K', 'true'),
(421, 'Burnside Elementary Scholastic Academy', 'true'),
(422, 'Brighton Park Elementary School', 'true'),
(423, 'Addams Elementary School, Jane', 'true'),
(424, 'Taylor Elementary School , Douglas', 'true'),
(425, 'Davis Elementary School, Nathan S', 'true'),
(426, 'Jones College Preparatory High School , William', 'true'),
(427, 'Monroe Elementary School, James', 'true'),
(428, 'Kellogg Elementary School , Kate S', 'true'),
(429, 'Sumner Math & Science Community Acad ES, Charles', 'true'),
(430, 'Mount Vernon Elementary School ', 'true'),
(431, 'Colemon Elementary Academy, Johnnie', 'true'),
(432, 'McCormick Elementary School, Cyrus H', 'true'),
(433, 'Hubbard High School, Gurdon S', 'true'),
(434, 'Jenner Elementary Academy of the Arts, Edward', 'true'),
(435, 'Leland Elementary School, George', 'true'),
(436, 'Faraday Elementary School, Michael', 'true'),
(437, 'Kellman Corporate Community ES, Joseph', 'true'),
(438, 'Wells Preparatory Elementary Academy, Ida B', 'true'),
(439, 'Ward Elementary School, Laura S', 'true'),
(440, 'Fiske Elementary School , John', 'true'),
(441, 'Harvard Elementary School of Excellence, John', 'true'),
(442, 'Air Force Academy High School', 'true'),
(443, 'ASPIRA Charter - Haugan Campus', 'true'),
(444, 'Intrinsic Schools', 'true'),
(445, 'Hearst Elementary School, Phobe Apperson', 'true'),
(446, 'Alcott Elementary School, Louisa May', 'true'),
(447, 'Dixon Elementary School, Arthur', 'true'),
(448, 'Lane Technical High School, Albert G', 'true'),
(449, 'North Lawndale College Prep Charter', 'true'),
(450, 'Steinmetz College Preparatory HS, Charles P', 'true'),
(451, 'Chicago Intl Charter - Northtown', 'true'),
(452, 'Mitchell Elementary School, Ellen', 'true'),
(453, 'Turner-Drew Elementary Language Academy', 'true'),
(454, 'Shields Elementary School, James', 'true'),
(455, 'Dubois Elementary School, William E B', 'true'),
(456, 'Marine Leadership Academy at Ames', 'true'),
(457, 'Gresham Elementary School, Walter Q', 'true'),
(458, 'Langford Community Academy, Anna R', 'true'),
(459, 'Earhart Options for Knowledge ES, Amelia', 'true'),
(460, 'Gage Park High School', 'true'),
(461, 'Chicago High School for the Arts', 'true'),
(462, 'Mireles Elementary Academy, Arnold', 'true'),
(463, 'Fulton Elementary School, Robert', 'true'),
(464, 'Goode STEM Academy, Sarah E.', 'true'),
(465, 'Back of the Yards High School', 'true'),
(466, 'Prosser Career Academy High School, Charles Allen', 'true'),
(467, 'Oglesby Elementary School, Richard J', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE IF NOT EXISTS `navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `url` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '29',
  `section` text NOT NULL,
  `win` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `sort`, `name`, `url`, `catid`, `section`, `win`, `loc_id`) VALUES
(37, 1, 'Contact Us', 'contact.php?loc_id=1', 0, 'Footer', 'false', 1),
(43, 3, 'Careers', 'page.php?page_id=28&loc_id=1', 0, 'Top', 'false', 1),
(44, 10, 'Meet The Team', 'team.php?loc_id=1', 0, 'Top', 'false', 1),
(45, 5, 'Services', 'services.php?loc_id=1', 0, 'Top', 'false', 1),
(48, 4, 'Positions', 'page.php?page_id=34&loc_id=1', 0, 'Footer', 'false', 1),
(50, 2, 'Services', 'services.php?loc_id=1', 0, 'Footer', 'false', 1),
(51, 3, 'About', 'about.php?loc_id=1', 0, 'Footer', 'false', 1),
(52, 5, 'Instructables', '#', 0, 'Footer', 'true', 1),
(54, 7, 'About', 'about.php?loc_id=1', 0, 'Top', 'false', 1),
(56, 9, 'Contact', 'contact.php?loc_id=1', 0, 'Top', 'true', 1),
(57, 1, 'Test Link', '#', 0, 'Top', 'true', 2),
(58, 2, 'Test location 2', 'page.php?page_id=35&loc_id=2', 0, 'Top', 'true', 2),
(59, 3, 'Contact', 'contact.php?loc_id=2', 0, 'Top', 'off', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `active` text NOT NULL,
  `disqus` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `image`, `content`, `active`, `disqus`, `datetime`, `image_align`, `loc_id`) VALUES
(28, 'Join Our Team', '', '<p>Our work is driven&nbsp;by challenges that impact communities across our country and around the world. That is a&nbsp;nice way of saying that we are solving some of the toughest issues facing the public sector.&nbsp;How are we doing it? Through&nbsp;<strong style="box-sizing: border-box;">building the best team in the&nbsp;industry</strong>.</p>\r\n<p>Our team consists of developers, architects, data analysts, requirements gatherers, project managers, support engineers and much more.</p>\r\n<p><a href="page.php?ref=34">View Open Positions</a></p>', 'true', 'false', '2016-11-15 21:00:35', 'right', 1),
(33, 'Trusted by 15 of the 20 Largest Urban Areas to Make Smarter Risk Informed Decisions', 'Ubuntu-Mate-Radioactive-no-logo.png', '<p>From federal, state and local law enforcement agencies to school districts, our products create an informed network of security experts that help ensure the safety of our communities.</p>\r\n<p>The&nbsp;provides a robust suite of applications that connects the front-line elements of the public safety community through data collection, prioritization, presentation and analysis. It is currently one of the most widely deployed solution in the nation&nbsp;and trusted by first responders to provide the right information at the right time, to do the right thing to keep themselves and their citizens safe</p>', 'true', 'false', '2016-11-16 21:08:52', 'right', 1),
(34, 'Positions', 'Ubuntu-Mate-Radioactive-no-logo.png', '<p>Job posting appear here if available.</p>', 'true', 'false', '2016-11-15 20:21:02', 'right', 1),
(35, 'Test location 2', '176242-1.jpg', '<p>test</p>', 'true', 'false', '2016-11-13 18:26:07', 'left', 2),
(36, 'Test location 4', '', '', 'true', 'false', '2016-11-15 21:00:22', 'right', 1),
(37, 'Test location 5', '', '<p>test</p>', 'true', 'false', '2016-11-15 21:00:10', 'right', 1),
(38, 'Test location 6666', '', '<p>test test</p>', 'true', 'false', '2016-11-15 20:59:25', 'right', 1),
(39, 'test ', 'Ubuntu-Mate-Radioactive-no-logo.png', '<p>test</p>', 'true', 'false', '2016-11-15 14:05:23', 'right', 1),
(40, 'adfasdfasdfasdf', 'Ubuntu-Mate-Radioactive-no-logo.png', '<p>asdfasdf</p>', 'true', 'false', '2016-11-15 14:02:49', 'right', 1),
(41, 'hjkgjkghjkgjkghjk', 'Ubuntu-Mate-Radioactive-no-logo.png', '<p>hjkghjkgjhkgjkghkjasdfasdfasf</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>asdfasdf</p>\r\n<p>&nbsp;</p>\r\n<p>asdfasdf</p>\r\n<p>adsfadsf</p>', 'true', 'false', '2016-11-15 20:20:33', 'right', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` text NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `link` int(11) NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `image`, `title`, `content`, `link`, `active`, `datetime`, `loc_id`) VALUES
(2, 'address-card', '', 'PUBLIC SAFETY APPLICATIONS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-11-14 22:04:13', 1),
(3, 'id-badge', '', 'SITUATIONAL AWARENESS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 20:32:50', 1),
(4, 'bicycle', '', 'INNOVATION CONSULTING', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 21:43:58', 1),
(5, '', 'webide.png', 'INSIDER THREAT DETECTION', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 36, 'true', '2016-11-29 14:49:35', 1),
(6, 'address-card', '', 'PUBLIC SAFETY APPLICATIONS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-11-14 22:04:13', 2),
(7, 'id-badge', '', 'SITUATIONAL AWARENESS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 20:32:50', 2),
(8, 'bicycle', '', 'INNOVATION CONSULTING', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 21:43:58', 2),
(9, '', 'webide.png', 'INSIDER THREAT DETECTION', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 36, 'true', '2016-11-29 14:49:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `services_icons`
--

CREATE TABLE IF NOT EXISTS `services_icons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `services_icons`
--

INSERT INTO `services_icons` (`id`, `icon`) VALUES
(1, 'diamond'),
(2, 'paper-plane'),
(3, 'motorcycle'),
(4, 'ship'),
(7, 'birthday-cake'),
(8, 'paint-brush'),
(9, 'eyedropper'),
(10, 'area-chart'),
(11, 'pie-chart'),
(12, 'line-chart'),
(13, 'bus'),
(14, 'bicycle'),
(15, 'buysellads'),
(16, 'connectdevelop'),
(17, 'shirtsinbulk'),
(18, 'simplybuilt'),
(19, 'skyatlas'),
(20, 'cart-plus'),
(21, 'server'),
(22, 'user-plus'),
(23, 'hotel'),
(24, 'bed'),
(25, 'train'),
(26, 'subway'),
(27, 'car'),
(28, 'cab'),
(29, 'taxi'),
(30, 'truck'),
(31, 'wrench'),
(32, 'compass'),
(33, 'bullseye'),
(34, 'check-square'),
(35, 'pencil-square'),
(36, 'dollar'),
(37, 'recycle'),
(38, 'tree'),
(39, 'bomb'),
(40, 'heartbeat'),
(41, 'child'),
(42, 'space-shuttle'),
(43, 'male'),
(44, 'map-marker'),
(45, 'copyright'),
(46, 'building'),
(47, 'female'),
(49, 'cogs'),
(50, 'clipboard'),
(51, 'database'),
(52, 'money'),
(55, 'print'),
(56, 'cc-visa'),
(57, 'cc-mastercard'),
(58, 'laptop'),
(60, 'book'),
(61, 'bookmark'),
(63, 'calendar'),
(64, 'drivers-license'),
(65, 'support'),
(66, 'address-card'),
(67, 'address-book'),
(68, 'braille'),
(69, 'cloud'),
(70, 'credit-card'),
(72, 'television'),
(73, 'magic'),
(76, 'lightbulb-o'),
(77, 'question'),
(78, 'wifi'),
(79, 'music'),
(80, 'video-camera'),
(81, 'picture-o'),
(82, 'podcast'),
(83, 'wpexplorer'),
(84, 'telegram'),
(85, 'grav'),
(86, 'snowflake-o'),
(87, 'id-badge');

-- --------------------------------------------------------

--
-- Table structure for table `setup`
--

CREATE TABLE IF NOT EXISTS `setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `headercode` text NOT NULL,
  `config` text NOT NULL,
  `logo` text NOT NULL,
  `ls2pac` text NOT NULL,
  `ls2kids` text NOT NULL,
  `searchdefault` int(11) NOT NULL DEFAULT '1',
  `author` text NOT NULL,
  `googleanalytics` text NOT NULL,
  `tinymce` int(11) NOT NULL DEFAULT '1',
  `pageheading` text NOT NULL,
  `servicesheading` text NOT NULL,
  `sliderheading` text NOT NULL,
  `teamheading` text NOT NULL,
  `customersheading` text NOT NULL,
  `databasesheading` text NOT NULL,
  `servicescontent` text NOT NULL,
  `customerscontent` text NOT NULL,
  `databasescontent` text NOT NULL,
  `teamcontent` text NOT NULL,
  `disqus` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=468 ;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `headercode`, `config`, `logo`, `ls2pac`, `ls2kids`, `searchdefault`, `author`, `googleanalytics`, `tinymce`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `customersheading`, `databasesheading`, `servicescontent`, `customerscontent`, `databasescontent`, `teamcontent`, `disqus`, `loc_id`) VALUES
(1, 'CPS', '', '', '', '1', '', 'true', 'true', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 1),
(2, 'Curie Metro High School', '', '', '', '1820', '', 'true', 'true', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 2),
(3, 'Northside Prep High School', '', '', '', '1740', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 3),
(4, 'Hyde Park High School', '', '', '', '1390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 4),
(5, 'Crane Tech Prep', '', '', '', '1270', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 5),
(6, 'DuSable Campus', '', '', '', '1280', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 6),
(7, 'Amundsen High School', '', '', '', '1210', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 7),
(8, 'Professional Library', '', '', '', '390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 8),
(9, 'Amundsen High School', '', '', '', '1210', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 7),
(10, 'Barry Elementary School', '', '', '', '2160', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 10),
(11, 'Belding Elementary School', '', '', '', '2260', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 11),
(12, 'Budlong Elementary School', '', '', '', '2440', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 12),
(13, 'Caldwell Academy', '', '', '', '2580', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 13),
(14, 'Clissold Elementary School', '', '', '', '2820', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 14),
(15, 'Franklin Fine Arts', '', '', '', '3420', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 15),
(16, 'Fulton Elementary School', '', '', '', '3450', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 16),
(17, 'Kohn Elementary School', '', '', '', '4360', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 17),
(18, 'Locke Elementary School', '', '', '', '4510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 18),
(19, 'May Community', '', '', '', '4670', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 19),
(20, 'Jackson Language', '', '', '', '4690', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 20),
(21, 'Mt. Vernon Elementary School', '', '', '', '4980', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 21),
(22, 'Mozart Elementary School', '', '', '', '5000', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 22),
(23, 'The Nettelhorst School', '', '', '', '5070', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 23),
(24, 'Sandoval Elementary School , Socorro', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 24),
(25, 'Hurley Elementary School , Edward N', '', '', '', '4120', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 25),
(26, 'Norwood Park Elementary School', '', '', '', '5120', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 26),
(27, 'Onahan Elementary School', '', '', '', '5190', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 27),
(28, 'Palmer Elementary School', '', '', '', '5260', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 28),
(29, 'Pirie Elementary School', '', '', '', '5440', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 29),
(30, 'Reilly Elementary School', '', '', '', '5590ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 30),
(31, 'Frazier Int. Magnet', '', '', '', '5850', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 31),
(32, 'Thorp Academy', '', '', '', '6190', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 32),
(33, 'Twain Elementary School', '', '', '', '6240', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 33),
(34, 'Whistler Elementary School, John', '', '', '', '6420', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 34),
(35, 'Whitney Elementary School', '', '', '', '6440ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 35),
(36, 'Douglass Academy', '', '', '', '6630', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 36),
(37, 'Price Elementary School', '', '', '', '6810', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 37),
(38, 'Johnson Elementary School', '', '', '', '6940', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 38),
(39, 'Davis Academy', '', '', '', '7180', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 39),
(40, 'Higgins Community', '', '', '', '7210', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 40),
(41, 'Grant Campus', '', '', '', '7310', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 41),
(42, 'Marshall Middle School', '', '', '', '7520', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 42),
(43, 'LaSalle II Magnet', '', '', '', '8040', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 43),
(44, 'DePriest Elementary School', '', '', '', '8050', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 44),
(45, 'Harlan High School', '', '', '', '1350', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 45),
(46, 'Tilden High School', '', '', '', '1590', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 46),
(47, 'Vaughn Occ High School', '', '', '', '1920', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 47),
(48, 'Uplift Community High School', '', '', '', '2210', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 48),
(49, 'Haley Academy Elementary School', '', '', '', '2360', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 49),
(50, 'Cameron Elementary School', '', '', '', '2610', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 50),
(51, 'Copernicus Elementary School', '', '', '', '2900', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 51),
(52, 'Gale Academy', '', '', '', '3480', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 52),
(53, 'Greene Elementary School', '', '', '', '3650', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 53),
(54, 'Gunsaulus Academy', '', '', '', '3690', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 54),
(55, 'Kershaw Elementary School', '', '', '', '4270', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 55),
(56, 'Lloyd Elementary School', '', '', '', '4500', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 56),
(57, 'Mayer Magnet', '', '', '', '4680', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 57),
(58, 'Keller Magnet Elementary School', '', '', '', '4960', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 58),
(59, 'Owen Academy', '', '', '', '5240', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 59),
(60, 'Pasteur Elementary School', '', '', '', '5310', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 60),
(61, 'Prussing Elementary School', '', '', '', '5510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 61),
(62, 'Pulaski International School of Chicago', '', '', '', '5520', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 62),
(63, 'Armstrong L Elementary School', '', '', '', '5700', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 63),
(64, 'Spencer Academy', '', '', '', '6000', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 64),
(65, 'Stockton Elementary School', '', '', '', '6060', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 65),
(66, 'Trumbull Elementary School', '', '', '', '6230', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 66),
(67, 'Banneker Elementary School', '', '', '', '6880', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 67),
(68, 'Dumas Elementary School', '', '', '', '6890', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 68),
(69, 'Woods Academy Elementary School', '', '', '', '7080', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 69),
(70, 'Lenart Gifted', '', '', '', '7240', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 70),
(71, 'Payton Coll Prep High School', '', '', '', '1090', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 71),
(72, 'Little Village High School Campus', '', '', '', '1130', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 72),
(73, 'Hancock Coll Prep', '', '', '', '1200', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 73),
(74, 'Fenger High School', '', '', '', '1310', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 74),
(75, 'Robeson High School', '', '', '', '1320', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 75),
(76, 'Hirsch Metro High School', '', '', '', '1380', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 76),
(77, 'Kennedy High School', '', '', '', '1420', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 77),
(78, 'Lake View High School', '', '', '', '1430', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 78),
(79, 'Manley High School', '', '', '', '1460', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 79),
(80, 'Brooks Coll Prep High School', '', '', '', '1500', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 80),
(81, 'Schurz High School', '', '', '', '1530', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 81),
(82, 'Senn Campus', '', '', '', '1540', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 82),
(83, 'Taft High School', '', '', '', '1580', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 83),
(84, 'Lincoln Park High School', '', '', '', '1620', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 84),
(85, 'Wells Academy High School', '', '', '', '1640', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 85),
(86, 'Chicago Military High School', '', '', '', '1800', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 86),
(87, 'Orr Academy High School', '', '', '', '1830', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 87),
(88, 'Carver Military High School', '', '', '', '1850', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 88),
(89, 'Corliss High School', '', '', '', '1860', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 89),
(90, 'Armstrong G Elementary School', '', '', '', '2080', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 90),
(91, 'Beaubien Elementary School', '', '', '', '2240', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 91),
(92, 'Bradwell Elementary School', '', '', '', '2340', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 92),
(93, 'Bridge Elementary School', '', '', '', '2380', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 93),
(94, 'Cassell Elementary School', '', '', '', '2720', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 94),
(95, 'Greeley Elementary School', '', '', '', '2730', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 95),
(96, 'Clay Elementary School', '', '', '', '2790', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 96),
(97, 'Clinton Elementary School', '', '', '', '2810', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 97),
(98, 'Coles Academy', '', '', '', '2830', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 98),
(99, 'Columbus Elementary School', '', '', '', '2850', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 99),
(100, 'Jordan Community', '', '', '', '2870', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 100),
(101, 'Eberhart Elementary School', '', '', '', '3140', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 101),
(102, 'Edwards Elementary School', '', '', '', '3200', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 102),
(103, 'Emmet Elementary School', '', '', '', '3230', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 103),
(104, 'Ericson Academy Elementary School', '', '', '', '3240', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 104),
(105, 'Kanoon Magnet Elementary School', '', '', '', '3370', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 105),
(106, 'Gary Elementary School', '', '', '', '3520', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 106),
(107, 'Ninos Heroes AC', '', '', '', '3720', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 107),
(108, 'Hitch Elementary School', '', '', '', '4010', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 108),
(109, 'Holmes Elementary School', '', '', '', '4030', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 109),
(110, 'Lewis Elementary School', '', '', '', '4450', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 110),
(111, 'Lowell Elementary School, James R', '', '', '', '4540', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 111),
(112, 'Till Academy', '', '', '', '4740', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 112),
(113, 'Moos Elementary School', '', '', '', '4870', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 113),
(114, 'Morrill Elementary School', '', '', '', '4880', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 114),
(115, 'Beard Elementary School', '', '', '', '4950', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 115),
(116, 'Murray Lang Academy', '', '', '', '5030', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 116),
(117, 'West Park Academy', '', '', '', '5140', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 117),
(118, 'Parker Academy', '', '', '', '5270', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 118),
(119, 'Peterson Elementary School', '', '', '', '5410', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 119),
(120, 'Pickard Elementary School', '', '', '', '5430', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 120),
(121, 'Reinberg Elementary School', '', '', '', '5600', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 121),
(122, 'Sawyer Elementary School', '', '', '', '5710', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 122),
(123, 'Scammon Elementary School', '', '', '', '5730', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 123),
(124, 'Seward Academy', '', '', '', '5820', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 124),
(125, 'Sexton Elementary School', '', '', '', '5830', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 125),
(126, 'Mireles Academy Elementary School', '', '', '', '5880', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 126),
(127, 'Shoop Academy', '', '', '', '5930', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 127),
(128, 'Smyth Elementary School', '', '', '', '5970ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 128),
(129, 'Swift Elementary School', '', '', '', '6130', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 129),
(130, 'Talcott Elementary School', '', '', '', '6140', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 130),
(131, 'Coleman Academy', '', '', '', '6170', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 131),
(132, 'Tilton Elementary School', '', '', '', '6210', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 132),
(133, 'Volta Elementary School', '', '', '', '6270', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 133),
(134, 'Albany Park Campus', '', '', '', '6290', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 134),
(135, 'Dvorak Academy', '', '', '', '6760', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 135),
(136, 'Buckingham Center', '', '', '', '6980', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 136),
(137, 'Ashburn Elementary School', '', '', '', '7100', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 137),
(138, 'Westcott Elementary School', '', '', '', '7260', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 138),
(139, 'Brighton Park Elementary School', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 139),
(140, 'Roque de Duprey Elementary School', '', '', '', '7510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 140),
(141, 'Orozco Elementary School', '', '', '', '7610', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 141),
(142, 'Ace Tech Campus', '', '', '', '7950', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 142),
(143, 'Clemente Academy High School', '', '', '', '1840', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 143),
(144, 'Skinner West ES', '', '', '', '5940', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 144),
(145, 'Hernandez MS', '', '', '', '8021', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 145),
(146, 'Dulles School of Excellence', '', '', '', '6860', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 146),
(147, 'Hughes L ES', '', '', '', '8060', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 147),
(148, 'Prieto ES', '', '', '', '8023', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 148),
(149, 'South Shore Academy', '', '', '', '2015', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 149),
(150, 'Westinghouse HS', '', '', '', '1160', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 150),
(151, 'Cooper Elementary Dual Language Academy, Peter', '', '', '', '2890', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 151),
(152, 'Clark Magnet High School', '', '', '', '6620', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 152),
(153, 'Bethune Elementary School', '', '', '', '8020', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 153),
(154, 'Blaine Elementary School', '', '', '', '2300', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 154),
(155, 'Boone Elementary School', '', '', '', '2320', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 155),
(156, 'Byrne Elementary School', '', '', '', '2570', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 156),
(157, 'Carver Primary School', '', '', '', '2690', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 157),
(158, 'Chappell Elementary School', '', '', '', '2750', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 158),
(159, 'Chicago Academy High School', '', '', '', '7770', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 159),
(160, 'Christopher Elementary School', '', '', '', '2780', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 160),
(161, 'Daley Elementary Academy', '', '', '', '6560', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 161),
(162, 'Dunbar Career Academy High School', '', '', '', '1030', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 162),
(163, 'Dunne Elementary School', '', '', '', '6050ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 163),
(164, 'Dvorak Elementary Specialty Academy', '', '', '', '6760', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 164),
(165, 'Dyett High School', '', '', '', '1600', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 165),
(166, 'Edward Coles Elementary Language Academy', '', '', '', '2830', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 166),
(167, 'Farnsworth Elementary School', '', '', '', '3280', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 167),
(168, 'Fort Dearborn Elementary School', '', '', '', '3400', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 168),
(169, 'Garfield Park Preparatory Academy ES', '', '', '', '8064', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 169),
(170, 'Garvy Elementary School, John W.', '', '', '', '3510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 170),
(171, 'Gregory Elementary School', '', '', '', '3660', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 171),
(172, 'Hammond Elementary School', '', '', '', '3750', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 172),
(173, 'Hancock College Preparatory High School', '', '', '', '1200', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 173),
(174, 'Julian High School', '', '', '', '1870', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 174),
(175, 'Kozminski Elementary Community Academy', '', '', '', '4390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 175),
(176, 'Lake View High School', '', '', '', '1430', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 78),
(177, 'Marshall Metropolitan High School', '', '', '', '1470', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 177),
(178, 'Nash Elementary School', '', '', '', '5050', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 178),
(179, 'Ninos Heroes Elementary Academic Center', '', '', '', '3720', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 179),
(180, 'Nixon Elementary School', '', '', '', '5100ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 180),
(181, 'Ogden International High School', '', '', '', '8083', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 181),
(182, 'Peirce International Studies ES', '', '', '', '5360', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 182),
(183, 'Perez Elementary School', '', '', '', '2930', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 183),
(184, 'Richards Career Academy High School', '', '', '', '1110', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 184),
(185, 'Sabin Elementary Dual Language Magnet School', '', '', '', '7790', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 185),
(186, 'Skinner North Classical Elementary', '', '', '', '8024', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 186),
(187, 'Sullivan High School', '', '', '', '1570', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 187),
(188, 'Talcott Elementary School', '', '', '', '6140', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 130),
(189, 'Walsh Elementary School', '', '', '', '6320', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 189),
(190, 'Ward Elementary School, James', '', '', '', '6330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 190),
(191, 'Beidler, Elementary School, Jacob', '', '', '', '2250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 191),
(192, 'Bennett Elementary School, Frank I', '', '', '', '2280', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 192),
(193, 'Black Magnet Elementary School, Robert A ', '', '', '', '7860ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 193),
(194, 'Black Magnet Elementary School, Robert A - Branch', '', '', '', '7861', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 194),
(195, 'Brentano Math & Science Academy ES, Lorenz', '', '', '', '2370', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 195),
(196, 'Burr Elementary School, Jonathan ', '', '', '', '2530', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 196),
(197, 'Chase Elementary School, Salmon P', '', '', '', '2760', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 197),
(198, 'Chavez Multicultural Academic Center ES, Cesar E - Lower Library', '', '', '', '5641', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 198),
(199, 'Chavez Multicultural Academic Center ES, Cesar E', '', '', '', '5640', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 199),
(200, 'Coonley Elementary School, John C.', '', '', '', '2880', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 200),
(201, 'Disney Magnet Elementary School, Walt', '', '', '', '8000', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 201),
(202, 'Durkin Park Elementary School', '', '', '', '7870', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 202),
(203, 'Esmond Elementary School', '', '', '', '3250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 203),
(204, 'Falconer Elementary School, Laughlin', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 204),
(205, 'Gage Park High School', '', '', '', '1340', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 205),
(206, 'Gary Elementary School, Joseph E - New', '', '', '', '3520ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 206),
(207, 'Gary Elementary School. Joseph E - Main', '', '', '', '3520ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 207),
(208, 'Hale Elementary School, Nathan', '', '', '', '3710', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 208),
(209, 'Hamilton Elementary School, Alexander', '', '', '', '3730', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 209),
(210, 'Hanson Park Elementary School - Branch', '', '', '', '4770ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 210),
(211, 'Hanson Park Elementary School - Main Library', '', '', '', '4770ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 211),
(212, 'Harte Elementary School, Bret', '', '', '', '3780', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 212),
(213, 'Hedges Elementary School, James ', '', '', '', '3900', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 213),
(214, 'Inter-American Elementary Magnet School', '', '', '', '4890', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 214),
(215, 'Juarez Community Academy High School, Benito', '', '', '', '1890', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 215),
(216, 'Kenwood Academy High School', '', '', '', '1710', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 216),
(217, 'LaSalle Elementary Language Academy', '', '', '', '4420', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 217),
(218, 'Lindblom Math & Science Academy HS, Robert', '', '', '', '7110', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 218),
(219, 'Logandale Middle School', '', '', '', '7560', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 219),
(220, 'Lovett Elementary School, Joseph', '', '', '', '4530', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 220),
(221, 'McAuliffe Elementary School, Sharon Christa', '', '', '', '3770', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 221),
(222, 'McPherson ES', '', '', '', '4800', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 222),
(223, 'Metcalfe Elementary Community Academy, Ralph H', '', '', '', '3190', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 223),
(224, 'Morgan Park High School', '', '', '', '1490', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 224),
(225, 'National Teachers Elementary Academy', '', '', '', '6480', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 225),
(226, 'Newberry Math & Science Academy ES, Walter L.', '', '', '', '5080', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 226),
(227, 'North Lawndale HS', '', '', '', '1106', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 227),
(228, 'Ogden Elementary School, William B.', '', '', '', '5150', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 228),
(229, 'Powell Academy Elementary School', '', '', '', '7010', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 229),
(230, 'Powell Academy ES', '', '', '', '7010', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 230),
(231, 'Pritzker School, A.N.', '', '', '', '6460', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 231),
(232, 'Raby High School, Al', '', '', '', '7690', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 232),
(233, 'Rudolph Elementary Learning Center, Wilma', '', '', '', '7350', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 233),
(234, 'Ruiz Elementary School, Irma C', '', '', '', '5390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 234),
(235, 'Shoop Math-Science Technical Academy ES, John D ', '', '', '', '5930', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 235),
(236, 'South Loop Elementary School', '', '', '', '3960', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 236),
(237, 'Suder Montessori Magnet ES', '', '', '', '6340', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 237),
(238, 'von Steuben Metropolitan Science HS, Friedrich W', '', '', '', '1610', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 238),
(239, 'Washington High School, George', '', '', '', '1630', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 239),
(240, 'Azuela Elementary School, Mariano', '', '', '', '8660', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 240),
(241, 'Bradwell Communications Arts & Science ES, Myra', '', '', '', '2340', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 241),
(242, 'Brennemann Elementary School, Joseph', '', '', '', '6600', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 242),
(243, 'Calmeca Academy of Fine Arts and Dual Language', '', '', '', '7880', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 243),
(244, 'Camras Elementary School, Marvin', '', '', '', '8600', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 244),
(245, 'Clinton Elementary School, DeWitt', '', '', '', '2810', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 245),
(246, 'Graham Training Center High School, Ray', '', '', '', '1950', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 246),
(247, 'Lorca Elementary School, Federico Garcia', '', '', '', '8330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 247),
(248, 'Wadsworth Elementary School, James', '', '', '', '6300', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 248),
(249, 'Zaragoza', '', '', '', '8550', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 249),
(250, 'Parkman Elementary School, Francis', '', '', '', '5280', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 250),
(251, 'Hammond Elementary School, Charles G', '', '', '', '3750', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 251),
(252, 'Hale Elementary School, Nathan', '', '', '', '3710', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 208),
(253, 'Washington Elementary School, George', '', '', '', '6360', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 253),
(254, 'Solorio Academy High School, Eric', '', '', '', '8550', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 254),
(255, 'Lorca Elementary School, Federico Garcia', '', '', '', '8330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 247),
(256, 'West Ridge Elementary School', '', '', '', '8440', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 256),
(257, 'Fernwood Elementary School', '', '', '', '3330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 257),
(258, 'Woodson South Elementary School, Carter G', '', '', '', '7820', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 258),
(259, 'Jefferson Alternative High School, Nancy B', '', '', '', '2120', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 259),
(260, 'Galileo Math & Science Scholastic Academy', '', '', '', '4160', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 260),
(261, 'Phillips Academy High School, Wendell', '', '', '', '1510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 261),
(262, 'Gillespie Elementary School, Frank L', '', '', '', '3530', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 262),
(263, 'Lara Elementary Academy, Agustin', '', '', '', '3980', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 263),
(264, 'Hibbard Elementary School, William G', '', '', '', '4000', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 264),
(265, 'Funston Elementary School, Frederick', '', '', '', '3460', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 265),
(266, 'Garvey Elementary School, Marcus Moziah', '', '', '', '5420', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 266),
(267, 'Bowen High School', '', '', '', '7550', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 267),
(268, 'Solomon Elementary School, Hannah G', '', '', '', '5980', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 268),
(269, 'M. M. Garvey ES', '', '', '', '5420', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 269),
(270, 'Sheridan (Mark) Math & Science Academy', '', '', '', '4920', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 270),
(271, 'Kinzie Elementary School, John H', '', '', '', '4330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 271),
(272, 'Saucedo Elementary Scholastic Academy, Maria', '', '', '', '4250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 272),
(273, 'Belmont-Cragin', '', '', '', '3390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 273),
(274, 'Simeon Career Academy High School, Neal F', '', '', '', '1150', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 274),
(275, 'Mather High School, Stephen T', '', '', '', '1480', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 275),
(276, 'Roosevelt High School, Theodore', '', '', '', '1520', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 276),
(277, 'Little Village Elementary School', '', '', '', '2590', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 277),
(278, 'Lavizzo Elementary School, Mildred I', '', '', '', '6260', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 278),
(279, 'Sandoval ES', '', '', '', '6430', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 279),
(280, 'Chicago Academy Elementary School', '', '', '', '6670', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 280),
(281, 'North River Elementary School', '', '', '', '7890', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 281),
(282, 'Agassiz Elementary School, Louis A', '', '', '', '2030', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 282),
(283, 'Carter Elementary School, William W', '', '', '', '2670', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 283),
(284, 'Cook Elementary School, John W', '', '', '', '2860', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 284),
(285, 'Dirksen Elementary School, Everett McKinley', '', '', '', '2950', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 285),
(286, 'Everett Elementary School, Edward', '', '', '', '3260', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 286),
(287, 'Goethe Elementary School, Johann W von', '', '', '', '3560', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 287),
(288, 'Hawthorne Elementary Scholastic Academy', '', '', '', '3830', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 288),
(289, 'Kelvyn Park High School', '', '', '', '1410', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 289),
(290, 'Mount Greenwood Elementary School', '', '', '', '4940', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 290),
(291, 'Wentworth Elementary School, Daniel S', '', '', '', '6390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 291),
(292, 'Dirksen Elementary School', '', '', '', '2950', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 292),
(293, 'Chicago High School for Agricultural Sciences', '', '', '', '1790', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 293),
(294, 'Ariel Elementary Community Academy', '', '', '', '3640', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 294),
(295, 'Bogan High School, William J', '', '', '', '1230', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 295),
(296, 'Brighton Park Elementary School', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 139),
(297, 'Castellanos Elementary School, Rosario', '', '', '', '2510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 297),
(298, 'Claremont Academy Elementary School', '', '', '', '7830', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 298),
(299, 'Cleveland Elementary School, Grover', '', '', '', '2800', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 299),
(300, 'Corkery Elementary School, Daniel J', '', '', '', '2910', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 300),
(301, 'Dever Elementary School', '', '', '', '3020', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 301),
(302, 'Dodge Elementary Renaissance Academy, Mary Mapes', '', '', '', '3050', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 302),
(303, 'Ebinger Elementary School, Christian', '', '', '', '3150', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 303),
(304, 'Field Elementary School, Eugene', '', '', '', '3350', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 304),
(305, 'Graham Elementary School, Alexander', '', '', '', '3600ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 305),
(306, 'Hamline Elementary School, John H', '', '', '', '3740ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 306),
(307, 'Henderson Elementary School, Charles R', '', '', '', '3920', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 307),
(308, 'King Jr Academy of Social Justice, Dr. Martin L.', '', '', '', '7250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 308),
(309, 'Hope College Preparatory High School', '', '', '', '1940', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 309),
(310, 'Jamieson Elementary School, Minnie Mars', '', '', '', '4180', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 310),
(311, 'Lee Elementary School, Richard Henry', '', '', '', '7170', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 311),
(312, 'Libby Elementary School, Arthur A ', '', '', '', '4470', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 312),
(313, 'Linne Elementary School, Carl von', '', '', '', '4490', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 313),
(314, 'Manierre Elementary School, George', '', '', '', '4580', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 314),
(315, 'Marquette Elementary School', '', '', '', '4620', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 315),
(316, 'Marsh Elementary School, John L', '', '', '', '4630', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 316),
(317, 'McDade Elementary Classical School, James E', '', '', '', '4750', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 317),
(318, 'Morton School of Excellence', '', '', '', '6800', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 318),
(319, 'Namaste Charter Elementary School', '', '', '', '7920', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 319),
(320, 'New Sullivan Elementary School, William K', '', '', '', '6100', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 320),
(321, 'Nightingale Elementary School, Florence', '', '', '', '5090', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 321),
(322, 'Pershing Elementary Humanities Magnet, John J', '', '', '', '5400', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 322),
(323, 'Ray Elementary School ', '', '', '', '5560', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 323),
(324, 'Sandoval Elementary School, Socorro', '', '', '', '6430', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 324),
(325, 'Sayre Language Academy, Harriet', '', '', '', '5720', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 325),
(326, 'Goudy Elementary School, William C', '', '', '', '3590', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 326),
(327, 'Haugan Elementary School, Helge A', '', '', '', '3810', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 327),
(328, 'Smyser Elementary School, Washington D', '', '', '', '5960', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 328),
(329, 'South Shore International College Prep High School', '', '', '', '8676', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 329),
(330, 'Spry & Community Links, John', '', '', '', '6010', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 330),
(331, 'Stowe Elementary School, Harriet Beecher', '', '', '', '6080ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 331),
(332, 'Tarkington School of Excellence ES', '', '', '', '7160', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 332),
(333, 'Vanderpoel Elementary Magnet School, John H', '', '', '', '6250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 333),
(334, 'Von Humboldt Elementary School, Alexander', '', '', '', '6280', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 334),
(335, 'Waters Elementary School, Thomas J', '', '', '', '6370', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 335),
(336, 'White Elementary Career Academy, Edward', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 336),
(337, 'Whittier Elementary School, John Greenleaf', '', '', '', '6450', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 337),
(338, 'Woodlawn Community Elementary School', '', '', '', '3860', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 338),
(339, 'Zapata Elementary Academy, Emiliano', '', '', '', '3820', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 339),
(340, 'Fernwood Elementary School', '', '', '', '3330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 257),
(341, 'McKay Elementary School, Francis M', '', '', '', '4760', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 341),
(342, 'Hayt Elementary School, Stephen K', '', '', '', '3850', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 342),
(343, 'Alcott High School for the Humanities', '', '', '', '8035', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 343),
(344, 'Agassiz Elementary School', '', '', '', '2030', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 344),
(345, 'Canty Elementary School, Arthur E', '', '', '', '2620', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 345),
(346, 'Cardenas Elementary School, Lazaro', '', '', '', '4320', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 346),
(347, 'Chicago Vocational Career Academy High School', '', '', '', '1010', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 347),
(348, 'Columbia Explorers Elementary Academy', '', '', '', '5860', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 348),
(349, 'Edgebrook Elementary School', '', '', '', '3170', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 349),
(350, 'Farragut Career Academy High School, David G', '', '', '', '1300', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 350),
(351, 'Schubert Elementary School, Franz Peter ', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 351),
(352, 'Schubert Elementary School, Franz Peter ', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 351),
(353, 'Herzl Elementary School, Theodore', '', '', '', '3970', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 353),
(354, 'Murphy Elementary School, John B', '', '', '', '5020', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 354),
(355, 'Lafayette Elementary School, Jean D', '', '', '', '4400', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 355),
(356, 'Melody Elementary School, Genevieve', '', '', '', '7190', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 356),
(357, 'New Field Elementary School', '', '', '', '7060', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 357),
(358, 'Cuffe Math-Science Technology Academy ES, Paul', '', '', '', '4090', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 358),
(359, 'Portage Park Elementary School', '', '', '', '5490', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 359),
(360, 'Prescott Elementary School, William H', '', '', '', '5500', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 360),
(361, 'Ryerson Elementary School, Martin A', '', '', '', '5680', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 361),
(362, 'Kelly High School, Thomas', '', '', '', '1400', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 362),
(363, 'Young Magnet High School, Whitney M', '', '', '', '1810', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 363),
(364, 'STEM Magnet Academy', '', '', '', '8678', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 364),
(365, 'Stevenson Elementary School, Adlai E', '', '', '', '6030', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 365),
(366, 'Talman Elementary School', '', '', '', '6680', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 366),
(367, 'Drummond Elementary School, Thomas', '', '', '', '3120', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 367),
(368, 'Brown Elementary Community Academy, Ronald', '', '', '', '5040', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 368),
(369, 'Bright Elementary School, Orville T', '', '', '', '2390', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 369),
(370, 'Ross Elementary School, Betsy', '', '', '', '5650', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 370),
(371, 'White Elementary Career Academy, Edward', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 336),
(372, 'Yates Elementary School, Richard', '', '', '', '6510', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 372),
(373, 'Brunson Math & Science Specialty ES, Brunson', '', '', '', '2550', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 373),
(374, 'Burley Elementary School, Augustus H', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 374);
INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `headercode`, `config`, `logo`, `ls2pac`, `ls2kids`, `searchdefault`, `author`, `googleanalytics`, `tinymce`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `customersheading`, `databasesheading`, `servicescontent`, `customerscontent`, `databasescontent`, `teamcontent`, `disqus`, `loc_id`) VALUES
(375, 'Evergreen Academy Middle School', '', '', '', '7490', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 375),
(376, 'Foreman High School , Edwin G', '', '', '', '1330', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 376),
(377, 'Gray Elementary School, William P', '', '', '', '3620', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 377),
(378, 'Neil Elementary School, Jane A', '', '', '', '5060', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 378),
(379, 'Nobel Elementary School, Alfred', '', '', '', '5110', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 379),
(380, 'Northwest Middle School', '', '', '', '4600', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 380),
(381, 'Stone Elementary Scholastic Academy', '', '', '', '6070', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 381),
(382, 'Tonti Elementary School, Enrico', '', '', '', '6220', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 382),
(383, 'McCutcheon Elementary School, John T', '', '', '', '6910', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 383),
(384, 'Instituto Health Sciences Career Academy HS', '', '', '', '8026', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 384),
(385, 'Bateman Elementary School, Newton', '', '', '', '2190', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 385),
(386, 'Beasley Elementary Magnet Academic Center, Edward', '', '', '', '6660', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 386),
(387, 'Burroughs Elementary School, John C', '', '', '', '2540', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 387),
(388, 'Esmond Elementary School', '', '', '', '3250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 203),
(389, 'Fermi Elementary School , Enrico', '', '', '', '3320', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 389),
(390, 'Lincoln Elementary School, Abraham', '', '', '', '4480', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 390),
(391, 'North-Grand High School', '', '', '', '1140', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 391),
(392, 'Pilsen Elementary Community Academy', '', '', '', '4210', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 392),
(393, 'Wildwood Elementary School', '', '', '', '6470', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 393),
(394, 'Chicago Quest North', '', '', '', '8672', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 394),
(395, 'Learn South', '', '', '', '8029', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 395),
(396, 'King Jr College Prep HS, Dr Martin Luther', '', '', '', '1760', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 396),
(397, 'Shields Middle School, James', '', '', '', '9597', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 397),
(398, 'Bell Elementary School, Alexander Graham', '', '', '', '2270', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 398),
(399, 'Falconer Elementary School, Laughlin', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 204),
(400, 'Stewart Elementary School, Graeme', '', '', '', '6040', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 400),
(401, 'Randolph Elementary School, Asa Philip', '', '', '', '3550', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 401),
(402, 'Burbank Elementary School, Luther', '', '', '', '2450', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 402),
(403, 'Holden Elementary School, Charles N', '', '', '', '4020', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 403),
(404, 'Burley Elementary School, Augustus H', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 374),
(405, 'Marine Leadership Academy', '', '', '', '2090', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 405),
(406, 'Lyon Elementary School, Mary', '', '', '', '4560', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 406),
(407, 'Carnegie Elementary School, Andrew', '', '', '', '2630', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 407),
(408, 'Healy Elementary School, Robert', '', '', '', '3880ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 408),
(409, 'Black Magnet Elementary School, Robert A', '', '', '', '7860ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 193),
(410, 'Rogers Elementary School , Philip', '', '', '', '5630', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 410),
(411, 'Montefiore Special Elementary School, Moses', '', '', '', '4860', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 411),
(412, 'Haines Elementary School, John Charles', '', '', '', '3700', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 412),
(413, 'Carson Elementary School, Rachel', '', '', '', '2660', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 413),
(414, 'Finkl Elementary School, William F', '', '', '', '3760', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 414),
(415, 'Henry Elementary School, Patrick', '', '', '', '3940', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 415),
(416, 'McNair Elementary School, Ronald E', '', '', '', '7040', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 416),
(417, 'Penn Elementary School, William', '', '', '', '5370', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 417),
(418, 'Reavis Math & Science Specialty ES, William C', '', '', '', '5580', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 418),
(419, 'Gallistel Elementary Language Academy, Mathew', '', '', '', '3490', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 419),
(420, 'Ellington Elementary School, Edward K', '', '', '', '3220', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 420),
(421, 'Burnside Elementary Scholastic Academy', '', '', '', '2520', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 421),
(422, 'Brighton Park Elementary School', '', '', '', '0', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 139),
(423, 'Addams Elementary School, Jane', '', '', '', '2020', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 423),
(424, 'Taylor Elementary School , Douglas', '', '', '', '6150', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 424),
(425, 'Davis Elementary School, Nathan S', '', '', '', '2970', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 425),
(426, 'Jones College Preparatory High School , William', '', '', '', '1060', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 426),
(427, 'Monroe Elementary School, James', '', '', '', '4850', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 427),
(428, 'Kellogg Elementary School , Kate S', '', '', '', '4240', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 428),
(429, 'Sumner Math & Science Community Acad ES, Charles', '', '', '', '6110', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 429),
(430, 'Mount Vernon Elementary School ', '', '', '', '4980', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 430),
(431, 'Colemon Elementary Academy, Johnnie', '', '', '', '6170', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 431),
(432, 'McCormick Elementary School, Cyrus H', '', '', '', '4720', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 432),
(433, 'Hubbard High School, Gurdon S', '', '', '', '1670', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 433),
(434, 'Jenner Elementary Academy of the Arts, Edward', '', '', '', '4200', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 434),
(435, 'Leland Elementary School, George', '', '', '', '7320', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 435),
(436, 'Faraday Elementary School, Michael', '', '', '', '4640', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 436),
(437, 'Kellman Corporate Community ES, Joseph', '', '', '', '3410', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 437),
(438, 'Wells Preparatory Elementary Academy, Ida B', '', '', '', '5250', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 438),
(439, 'Ward Elementary School, Laura S', '', '', '', '5470', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 439),
(440, 'Fiske Elementary School , John', '', '', '', '3360', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 440),
(441, 'Harvard Elementary School of Excellence, John', '', '', '', '3800', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 441),
(442, 'Air Force Academy High School', '', '', '', '1055', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 442),
(443, 'ASPIRA Charter - Haugan Campus', '', '', '', '3500', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 443),
(444, 'Intrinsic Schools', '', '', '', '9619', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 444),
(445, 'Hearst Elementary School, Phobe Apperson', '', '', '', '3890', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 445),
(446, 'Alcott Elementary School, Louisa May', '', '', '', '2040', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 446),
(447, 'Dixon Elementary School, Arthur', '', '', '', '3040', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 447),
(448, 'Lane Technical High School, Albert G', '', '', '', '1440', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 448),
(449, 'North Lawndale College Prep Charter', '', '', '', '1105ALL', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 449),
(450, 'Steinmetz College Preparatory HS, Charles P', '', '', '', '1560', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 450),
(451, 'Chicago Intl Charter - Northtown', '', '', '', '7740', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 451),
(452, 'Mitchell Elementary School, Ellen', '', '', '', '4840', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 452),
(453, 'Turner-Drew Elementary Language Academy', '', '', '', '3110', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 453),
(454, 'Shields Elementary School, James', '', '', '', '5910', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 454),
(455, 'Dubois Elementary School, William E B', '', '', '', '8010', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 455),
(456, 'Marine Leadership Academy at Ames', '', '', '', '2090', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 456),
(457, 'Gresham Elementary School, Walter Q', '', '', '', '3670', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 457),
(458, 'Langford Community Academy, Anna R', '', '', '', '2900', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 458),
(459, 'Earhart Options for Knowledge ES, Amelia', '', '', '', '7450', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 459),
(460, 'Gage Park High School', '', '', '', '1340', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 205),
(461, 'Chicago High School for the Arts', '', '', '', '8047', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 461),
(462, 'Mireles Elementary Academy, Arnold', '', '', '', '5880', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 462),
(463, 'Fulton Elementary School, Robert', '', '', '', '3450', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 463),
(464, 'Goode STEM Academy, Sarah E.', '', '', '', '9598', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 464),
(465, 'Back of the Yards High School', '', '', '', '9623', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 465),
(466, 'Prosser Career Academy High School, Charles Allen', '', '', '', '1070', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 466),
(467, 'Oglesby Elementary School, Richard J', '', '', '', '5170', '', '', '', 1, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 467);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `content` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image`, `title`, `link`, `content`, `active`, `datetime`, `loc_id`) VALUES
(3, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Tibique singulis nam id, aliquid mediocrem definitiones nam ne', '28', 'Tibique singulis nam id, aliquid mediocrem definitiones nam ne.', 'true', '2016-11-15 21:54:19', 1),
(4, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Inani singulis efficiantur ut mel, et regione repudiare ius', '28', 'dgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg\r\ndgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdf\r\ndgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdf\r\ndgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdf\r\ndgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdf\r\ndgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdf\r\ndgadfgsdfgsdfgsdfgsdfgsdfgsdfgsdf\r\ndgadfgsdf', 'true', '2016-11-28 22:10:42', 1),
(5, 'parallax_6-8_med.jpg', 'Trusted by Mission-Critical Organizations', '', 'Our expertise in large-scale, enterprise networks and advanced threat analytics has led us to develop a full range of industry leading services and innovative products that help secure and maximize mission-critical operations.', 'true', '2016-12-05 14:38:21', 2),
(6, 'budget2015.jpg', 'Know your schools, detect threats sooner and respond faster', '', ' Threat awareness and incident response by enabling school districts and states to catalog their facilities and school security plans, to create and manage safety assessments and to report incidents and monitor threats in and around their schools through an integrated online system. ', 'true', '2016-12-05 14:38:50', 2),
(7, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Vim ea omnes discere molestie.', '34', 'Vim ea omnes discere molestie. Cu vix facilisis efficiendi, vix ne ipsum inermis. Te cum possit voluptua expetendis. Cibo integre virtute ius ut.', 'true', '2016-11-18 14:57:21', 1),
(8, 'space-desktop-backgrounds.jpg', 'New Slide', '35', 'test slide #1', 'true', '2016-11-22 19:19:48', 2);

-- --------------------------------------------------------

--
-- Table structure for table `socialmedia`
--

CREATE TABLE IF NOT EXISTS `socialmedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` text NOT NULL,
  `facebook` text NOT NULL,
  `twitter` text NOT NULL,
  `pinterest` text NOT NULL,
  `google` text NOT NULL,
  `instagram` text NOT NULL,
  `youtube` text NOT NULL,
  `tumblr` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `socialmedia`
--

INSERT INTO `socialmedia` (`id`, `heading`, `facebook`, `twitter`, `pinterest`, `google`, `instagram`, `youtube`, `tumblr`, `loc_id`) VALUES
(1, 'Follow Us', 'http://www.facebook.com', 'http://www.twitter.com', '', 'http://www.google.com', 'http://instagram.com', '', '', 1),
(2, 'Follow Us 2', 'http://facebook.com', '', '', '', '', 'http://www.youtube.com', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `name` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `image`, `title`, `content`, `name`, `active`, `datetime`, `loc_id`) VALUES
(3, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Chief Financial Officer', 'More than 30 years of experience in large and small aerospace and defense companies, most recently as the Chief Financial Officer of Applied Signal Technology.', 'Cindy Dole', 'true', '2016-11-29 14:50:11', 1),
(4, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Chief Operations Officer', 'President and CEO since in 1995. Provides executive oversight and leadership of day-to-day company operations, integration of shared company resources.', 'John Doe', 'true', '2016-11-14 21:59:52', 1),
(5, 'Ubuntu-Mate-Radioactive-no-logo.png', 'CTO', 'Mr. Anderson has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Anderson', 'true', '2016-11-14 21:59:55', 1),
(7, 'Ubuntu-Mate-Radioactive-no-logo.png', 'President', 'Mr. Smith has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Smith', 'true', '2016-11-14 21:59:54', 1),
(8, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Chief Financial Officer', 'More than 30 years of experience in large and small aerospace and defense companies, most recently as the Chief Financial Officer of Applied Signal Technology.', 'Cindy Dole', 'true', '2016-11-29 14:50:11', 2),
(9, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Chief Operations Officer', 'President and CEO since in 1995. Provides executive oversight and leadership of day-to-day company operations, integration of shared company resources.', 'John Doe', 'true', '2016-11-14 21:59:52', 2),
(10, 'Ubuntu-Mate-Radioactive-no-logo.png', 'CTO', 'Mr. Anderson has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Anderson', 'true', '2016-11-14 21:59:55', 2),
(11, 'Ubuntu-Mate-Radioactive-no-logo.png', 'President', 'Mr. Smith has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Smith', 'true', '2016-11-14 21:59:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `level` int(11) NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `level`, `loc_id`) VALUES
(1, 'admin', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'rjones@tlcdelivers.com', 1, 1),
(2, 'rjones', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'rjones@tlcdelivers.com', 0, 2),
(3, 'kgray', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'kgray@tlcdelivers.com', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
