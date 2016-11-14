-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2016 at 09:32 PM
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
(1, 'test one 1', '<p>test 1</p>', 'Home-Page1.jpg', 'right', 1),
(2, 'test 2', '<p>test 2</p>', '176242-1.jpg', 'left', 2),
(3, 'test 3', '<p>test 3 test 3</p>', 'Professional-Services-Banner.jpg', 'right', 3),
(7, 'test 4', '<p>test 4</p>', 'bmgates-c.gif', 'right', 4);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `nav_loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `nav_loc_id`) VALUES
(0, 'None', 1),
(2, 'FAQ', 1);

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
(1, 'Contact Us 1', 'test', '', 'ryanjones153@gmail.com', 'ryanjones153@gmail.com', '', '', '', '', '', '9-5', 1),
(2, 'Contact 2', '', '', 'ryan@email.com', '', '', '', '', '', '', '', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `image`, `name`, `link`, `active`, `datetime`, `loc_id`) VALUES
(4, 'darpa-c-352x193.png', 'Darpa', 'http://www.darpa.gov', 'true', '2016-11-12 01:37:56', 1),
(5, 'disa-c.png', 'DISA', 'http://www.disa.gov', 'true', '2016-11-12 01:37:56', 1),
(6, 'bmgates-c.gif', 'Bill and Melinda Gate Foundation', 'http://www.billgates.gov', 'true', '2016-11-12 01:37:56', 1),
(7, 'cfpb-c.png', 'CFPB', 'http://www.cfpb.gov', 'true', '2016-11-12 01:37:56', 1),
(8, 'caloes-c.jpg', 'Cal OES', 'http://www.darpa.gov', 'true', '2016-11-12 01:37:56', 1);

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
(1, 'Featured', '', '<p>test 1</p>', 'cyber-security4.jpg', 'right', 1),
(2, 'featured two', '', '', '176242-1.jpg', 'left', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `sort`, `name`, `url`, `catid`, `section`, `win`, `loc_id`) VALUES
(37, 1, 'Contact Us', 'contact.php', 0, 'Footer', 'false', 1),
(42, 1, 'About Us', 'about.php?loc_id=1', 2, 'Top', 'false', 1),
(43, 2, 'Careers', 'page.php?page_id=28&loc_id=1', 2, 'Top', 'false', 1),
(44, 3, 'Meet The Team', 'team.php?loc_id=1', 0, 'Top', 'false', 1),
(45, 4, 'Services', 'services.php?loc_id=1', 0, 'Top', 'false', 1),
(48, 4, 'Positions', 'page.php?page_id=34', 0, 'Footer', 'false', 1),
(50, 2, 'Services', 'services.php', 0, 'Footer', 'false', 1),
(51, 3, 'About', 'about.php', 0, 'Footer', 'false', 1),
(52, 5, 'Instructables', '#', 0, 'Footer', 'true', 1),
(53, 5, 'Test', '#', 0, 'Top', 'false', 1),
(54, 6, 'About', 'about.php?loc_id=1', 0, 'Top', 'false', 1),
(55, 7, 'Test location 4', 'page.php?page_id=36&loc_id=1', 0, 'Top', 'false', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `image`, `content`, `active`, `disqus`, `datetime`, `image_align`, `loc_id`) VALUES
(28, 'Join Our Team', 'Intelligence-Fusion1.jpg', '<p>Our work is driven&nbsp;by challenges that impact communities across our country and around the world. That is a&nbsp;nice way of saying that we are solving some of the toughest issues facing the public sector.&nbsp;How are we doing it? Through&nbsp;<strong style="box-sizing: border-box;">building the best team in the&nbsp;industry</strong>.</p>\r\n<p>Our team consists of developers, architects, data analysts, requirements gatherers, project managers, support engineers and much more.</p>\r\n<p><a href="page.php?ref=34">View Open Positions</a></p>', 'true', 'false', '2016-08-15 21:16:49', 'right', 1),
(33, 'Trusted by 15 of the 20 Largest Urban Areas to Make Smarter Risk Informed Decisions', 'cyber-security4.jpg', '<p>From federal, state and local law enforcement agencies to school districts, our products create an informed network of security experts that help ensure the safety of our communities.</p>\r\n<p>The&nbsp;provides a robust suite of applications that connects the front-line elements of the public safety community through data collection, prioritization, presentation and analysis. It is currently one of the most widely deployed solution in the nation&nbsp;and trusted by first responders to provide the right information at the right time, to do the right thing to keep themselves and their citizens safe</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><img src="//localhost/businessCMS/uploads/1/blackwatch_holmes.jpg" alt="blackwatch_holmes.jpg" /></p>', 'true', 'true', '2016-11-09 04:48:29', 'right', 1),
(34, 'Positions', '', '<p>Job posting appear here if available.</p>', 'true', 'false', '2015-07-26 02:24:41', '', 1),
(35, 'Test location 2', '176242-1.jpg', '<p>test</p>', 'on', 'false', '2016-11-13 18:26:07', 'left', 2),
(36, 'Test location 4', 'school-safety1.jpg', '', 'true', 'true', '2016-11-11 03:27:49', 'right', 1),
(37, 'Test location 5', 'Professional-Services-Banner.jpg', '<p>test</p>', 'true', 'false', '2016-11-13 04:29:10', 'right', 1),
(38, 'Test location 6666', 'Intelligence-Fusion1.jpg', '<p>test test</p>', 'true', 'false', '2016-11-13 06:50:37', 'right', 1),
(39, 'test ', 'Professional-Services-Banner.jpg', '<p>test</p>', 'true', 'true', '2016-11-13 06:59:19', 'right', 1),
(40, 'adfasdfasdfasdf', 'cyber-security4.jpg', '<p>asdfasdf</p>', 'true', 'false', '2016-11-13 07:05:02', 'right', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `image`, `title`, `content`, `link`, `active`, `datetime`, `loc_id`) VALUES
(2, 'male', '', 'PUBLIC SAFETY APPLICATIONS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-11-14 02:03:18', 1),
(3, 'map-marker', '', 'SITUATIONAL AWARENESS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-14 02:03:17', 1),
(4, 'copyright', '', 'INNOVATION CONSULTING', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-11-14 02:09:41', 1),
(5, 'male', '', 'INSIDER THREAT DETECTION', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-12 01:39:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services_icons`
--

CREATE TABLE IF NOT EXISTS `services_icons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

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
(81, 'picture-o');

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
  `servicescontent` text NOT NULL,
  `customerscontent` text NOT NULL,
  `teamcontent` text NOT NULL,
  `disqus` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `headercode`, `config`, `ls2pac`, `ls2kids`, `author`, `googleanalytics`, `tinymce`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `customersheading`, `servicescontent`, `customerscontent`, `teamcontent`, `disqus`, `loc_id`) VALUES
(1, 'My Site', '', '', '', '123', 'true', 'true', 'John Doe', '', 1, 'Pages', 'Services', 'Image Slider', 'Meet the Team', 'Customers', 'Our areas of expertise.', 'Decision makers rely on our solutions everyday to protect against threats to some of the most mission-critical and high-profile networks and institutions in the world. ', 'Through its collective experience, the team drives innovation to deliver customers a significant return on investment paired with successful engagements.', '', 1),
(2, 'test two 2222', '', '', '', '555', 'true', 'true', '', '', 1, '', '', '', '', '', '', '', '', '', 2),
(3, 'test 3', 'test, test3', '', '', '', '', '', '', '', 1, '', '', '', '', '', '', '', '', '', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image`, `title`, `link`, `content`, `active`, `datetime`, `loc_id`) VALUES
(3, 'Professional-Services-Banner.jpg', 'INTELLIGENCE, SECURITY, PERFORMANCE', '', 'Our expertise in large-scale networks and advanced threat analytics has led us to develop a full range of innovative products and industry leading services that help secure and maximize enterprise operations.', 'true', '2016-11-13 05:45:53', 1),
(4, 'Professional-Services-Banner.jpg', 'SECURE AND RELIABLE', '', 'Cyber Risk Analysis', 'true', '2016-11-13 07:05:20', 1),
(5, 'insider.jpg', 'Trusted by Mission-Critical Organizations', '', 'Our expertise in large-scale, enterprise networks and advanced threat analytics has led us to develop a full range of industry leading services and innovative products that help secure and maximize mission-critical operations.', 'true', '2016-11-11 03:51:57', 2),
(6, '176242-1.jpg', 'Know your schools, detect threats sooner and respond faster', '', ' Threat awareness and incident response by enabling school districts and states to catalog their facilities and school security plans, to create and manage safety assessments and to report incidents and monitor threats in and around their schools through an integrated online system. ', 'true', '2016-11-13 18:27:37', 2),
(7, 'Intelligence-Fusion1.jpg', 'asdfasdfasdfasdf', '', 'asdfasdfasdf', 'true', '2016-11-13 07:03:57', 1);

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
(1, 'Follow Us 1', 'http://www.facebook.com', 'http://www.twitter.com', '', 'http://www.google.com', '', '', '', 1),
(2, 'Follow Us 2', '', '', '', '', '', '', '', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `image`, `title`, `content`, `name`, `active`, `datetime`, `loc_id`) VALUES
(3, 'placeholder-personF.png', 'Chief Financial Officer', 'More than 30 years of experience in large and small aerospace and defense companies, most recently as the Chief Financial Officer of Applied Signal Technology.', 'Cindy Dole', 'true', '2016-11-12 01:40:31', 1),
(4, 'placeholder-personM.png', 'Chief Operations Officer', 'President and CEO since in 1995. Provides executive oversight and leadership of day-to-day company operations, integration of shared company resources.', 'John Doe', 'true', '2016-11-12 01:40:31', 1),
(5, 'placeholder-personM.png', 'CTO', 'Mr. Anderson has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Anderson', 'true', '2016-11-12 01:40:31', 1),
(7, 'placeholder-personM.png', 'President', 'Mr. Smith has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Smith', 'true', '2016-11-12 01:40:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` int(11) NOT NULL,
  `loc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `loc_id`) VALUES
(1, 'admin', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
