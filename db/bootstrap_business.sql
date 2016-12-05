-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2016 at 09:53 AM
-- Server version: 5.5.52-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `businessCMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `nav_loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
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
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `featured` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `introtext` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `generalinfo` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `active` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `active`) VALUES
(1, 'Location Test One', 'true'),
(2, 'Location Test Two', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `url` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '29',
  `section` text NOT NULL,
  `win` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(59, 0, 'Contact', 'contact.php?loc_id=2', 0, 'Top', 'off', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `active` text NOT NULL,
  `disqus` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `icon` text NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `link` int(11) NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `services_icons` (
  `id` int(11) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `setup` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `headercode` text NOT NULL,
  `config` text NOT NULL,
  `logo` text NOT NULL,
  `ls2pac` text NOT NULL,
  `ls2kids` text NOT NULL,
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
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `headercode`, `config`, `logo`, `ls2pac`, `ls2kids`, `author`, `googleanalytics`, `tinymce`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `customersheading`, `databasesheading`, `servicescontent`, `customerscontent`, `databasescontent`, `teamcontent`, `disqus`, `loc_id`) VALUES
(1, 'My Site', '', '', '', '123', 'webide.png', 'true', 'true', 'John Doe', '', 1, 'Pages', 'Services', 'Image Slider', 'Meet the Team', 'Resources', 'Databases', 'Our areas of expertise.', 'Lorem ipsum dolor sit amet, bonorum iracundia ex ius, sit modo quodsi cu, vitae omnesque no cum', 'Lorem ipsum dolor sit amet, bonorum iracundia ex ius, sit modo quodsi cu, vitae omnesque no cum', 'Through its collective experience, the team drives innovation to deliver customers a significant return on investment paired with successful engagements.', '', 1),
(2, 'test two 2222', '', '', '', '555', '', 'true', 'true', '', '', 1, '', '', '', '', '', '', '', '', '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `content` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `socialmedia` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `facebook` text NOT NULL,
  `twitter` text NOT NULL,
  `pinterest` text NOT NULL,
  `google` text NOT NULL,
  `instagram` text NOT NULL,
  `youtube` text NOT NULL,
  `tumblr` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `name` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `level` int(11) NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `level`, `loc_id`) VALUES
(1, 'admin', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'rjones@tlcdelivers.com', 1, 1),
(2, 'rjones', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'rjones@tlcdelivers.com', 0, 2),
(3, 'kgray', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'kgray@tlcdelivers.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured`
--
ALTER TABLE `featured`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generalinfo`
--
ALTER TABLE `generalinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_icons`
--
ALTER TABLE `services_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socialmedia`
--
ALTER TABLE `socialmedia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `featured`
--
ALTER TABLE `featured`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `generalinfo`
--
ALTER TABLE `generalinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `services_icons`
--
ALTER TABLE `services_icons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `socialmedia`
--
ALTER TABLE `socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
