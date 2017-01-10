-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2017 at 02:10 PM
-- Server version: 5.5.50-MariaDB
-- PHP Version: 5.4.16

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

CREATE TABLE IF NOT EXISTS `aboutus` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `image_align` text NOT NULL,
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`id`, `heading`, `content`, `image`, `image_align`, `use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(1, 'About Us', '<p>Lorem ipsum dolor sit amet, bonorum iracundia ex ius, sit modo quodsi cu, vitae omnesque no cum. In cotidieque adversarium vis, timeam sanctus alienum ad vim, nonumy vituperatoribus ei sea. No eam essent platonem, illud splendide an mel, ea mentitum officiis scripserit ius. Harum primis per in, duo cu ancillae disputationi, te pri causae tritani torquatos. Liber doming iracundia et his. An eros brute solet mei, abhorreant omittantur per te. Vim an labitur probatus, ea ius fugit omnesque aliquando.</p>\r\n<p>Inani singulis efficiantur ut mel, et regione repudiare ius. Et cibo commodo signiferumque cum. Tibique singulis nam id, aliquid mediocrem definitiones nam ne. Erant incorrupte eu nec, ex modus aperiri forensibus nam, eu ius bonorum adipisci theophrastus. Soleat animal liberavisse id eos, illum intellegam te est. Per velit ludus ne, diceret recusabo voluptaria usu et. Eu mea prodesset scriptorem.</p>', 'HSWorkingGroup.png', 'left', 'false', '2017-01-05 16:18:28', 'admin', 1),
(2, 'Mission', '<p>It is the mission of Curie Metropolitan High School to offer a rigorous academic curriculum with an emphasis on technology and the arts. Curie High School promotes future success by establishing a culture of college and career readiness and by encouraging students to enroll in post-secondary institutions. Curie High School is committed to providing authentic learning experiences that will provide a foundation for life-long learning. Students will be prepared to become leaders and engaged citizens in a global society, enabling them to contribute positively and responsibly to their community.</p>', '', 'right', 'false', '2017-01-06 03:36:27', 'admin', 2),
(3, 'Who We Are', '<p>At Barry, we believe that every child, in every classroom, deserves a first-class education and should be provided with quality resources that can support their cognitive and social emotional development. In order to succeed in our commitment to a first-class education for all children, we must develop teacher capacity and capability. We have partnered with Chicago Literacy Group to support our instruction in moving forward to becoming a Balanced Literacy School. Barry utilizes a Responsive Classroom Approach and Positive Discipline to built school community and increase positive conflict resolution skills.</p>', '', 'right', 'false', '2017-01-06 01:37:46', 'admin', 10),
(4, '', '', '', '', 'true', '2017-01-05 17:02:50', 'admin', 5),
(6, '', '', '', '', 'false', '2017-01-05 21:33:49', 'admin', 100);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `nav_loc_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `nav_loc_id`, `datetime`, `author_name`) VALUES
(0, 'None', 1, '0000-00-00 00:00:00', ''),
(45, 'test 2', 2, '0000-00-00 00:00:00', ''),
(46, 'test', 1, '0000-00-00 00:00:00', ''),
(47, 'Services', 1, '0000-00-00 00:00:00', ''),
(48, 'test 2', 1, '2016-12-12 20:16:13', ''),
(49, 'test 3', 1, '2016-12-12 20:22:38', ''),
(50, 'Information', 1, '2016-12-28 18:35:05', '');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
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
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `heading`, `introtext`, `mapcode`, `email`, `sendtoemail`, `address`, `city`, `state`, `zipcode`, `phone`, `hours`, `use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(1, 'Contact Us', 'Chicago Public Schools', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2970.491674759722!2d-87.63084358455876!3d41.882281979221865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e2cbb3bf3aac1%3A0xf3321c9d81c08854!2s42+W+Madison+St%2C+Chicago%2C+IL+60602!5e0!3m2!1sen!2sus!4v1483022894306" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>', '', '', '42 W. Madison St.', 'Chicago', 'IL', '60602', '773-553-1000', '', '', '2016-12-29 16:44:04', '', 1),
(2, 'Contact the Librarian', '', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2974.209822288167!2d-87.72389568456126!3d41.802240179228214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e31969597f317%3A0xac2c7141e727810e!2s4959+S+Archer+Ave%2C+Chicago%2C+IL+60632!5e0!3m2!1sen!2sus!4v1483025122998" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>', '', '', '4959 S Archer Ave.', 'Chicago', 'IL', '60632', '773- 535-2134', '7:30 a.m. - 4:30 p.m. Monday thru Friday', '', '2016-12-29 16:44:21', '', 2),
(3, 'Contact Us', '', '<iframe allowtransparency="true" frameborder="0" scrolling="no" style="width: 100%; height: 250px; margin-top: 10px; margin-bottom: 10px;" src="//www.weebly.com/weebly/apps/generateMap.php?map=google&amp;elementid=724245238896205531&amp;ineditor=0&amp;control=2&amp;width=auto&amp;height=250px&amp;overviewmap=1&amp;scalecontrol=0&amp;typecontrol=0&amp;zoom=17&amp;long=-87.739867&amp;lat=41.93273809999999&amp;domain=www&amp;point=1&amp;align=2&amp;reseller=false"></iframe>', '', '', '2828 N Kilbourn Ave.', 'Chicago', 'IL', '60641', '773-534-3455', '', 'false', '2017-01-06 01:36:07', 'admin', 10),
(4, '', '', '', '', '', '', '', '', '', '', '', 'false', '2017-01-05 18:49:02', 'admin', 100);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `icon` text NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `content` text NOT NULL,
  `featured` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `image`, `icon`, `name`, `link`, `content`, `featured`, `active`, `datetime`, `author_name`, `loc_id`) VALUES
(4, '', 'child', 'Kids InfoBits', 'http://infotrac.galegroup.com/itweb/cps?db=ITKE', 'For K-5 students. Features a visually graphic interface, a topic tree search and age-appropriate, curriculum-related magazine, newspaper and reference content.', 'false', 'true', '2016-12-28 17:27:56', '', 1),
(5, '', 'book', 'Encyclopedia Universal en Espanol', 'http://www.spanish.eb.com/', 'Our subscription includes Britannica&#039;s Spanish language version.', 'false', 'true', '2016-12-28 16:51:05', '', 1),
(6, '', 'book', 'Britannica', 'http://school.eb.com/', 'In addition to millions of articles on as many topics, this online encyclopedia includes Internet links, journal and magazine articles, teacher resources, timelines, dictionary and atlas resources. Select the appropriate grade level.', 'false', 'true', '2016-12-28 17:27:55', '', 1),
(7, '', 'wpexplorer', 'First Search', 'http://firstsearch.oclc.org/', 'Professional and educational magazine and journal articles. Includes ERIC , WorldCat , Article-First , and others.', 'false', 'true', '2016-12-29 14:41:43', '', 1),
(8, '', 'laptop', 'Student Resources in Context', 'http://infotrac.galegroup.com/itweb/cps?db=SUIC', 'A fully integrated database for high school containing thousands of curriculum-targeted primary documents, biographies, essays, critical analyses, full-text coverage of over 1,000 magazines, newspapers, photographs, illustrations, and audio.', 'false', 'true', '2016-12-28 17:27:57', '', 1),
(14, '', 'connectdevelop', 'Research in Context', 'http://infotrac.galegroup.com/itweb/cps?db=MSIC', 'Access continuously updated reference content with full-text magazines, academic journals, news articles, primary source documents, images, videos, audio files and links to vetted websites organized in a user friendly website.', 'false', 'true', '2016-12-28 17:27:56', '', 1),
(15, '', 'book', 'TeachingBooks', 'http://teachingbooks.net/home/', 'Provides original, in-studio movies of authors and illustrators and a wealth of multimedia resources on K-12 books that generate enthusiasm for books and reading.', 'false', 'true', '2016-12-28 16:56:21', '', 1),
(16, '', 'book', 'Flipster', 'http://search.ebscohost.com/login.aspx?authtype=uid&amp;profile=eon', 'Access Cricket Media magazine titles via the EBSCO Flipster Carousal. Click on the login information link above for the user ID and password information. This is a one-year donation that expires June 30, 2017.', 'false', 'true', '2016-12-29 14:42:00', '', 1),
(17, '', 'video-camera', 'Safari Montage', 'http://safari.cps.k12.il.us/', 'View curriculum and standards-focused educational videos from leading publishers.', 'false', 'true', '2016-12-28 16:33:36', '', 1),
(18, '', 'book', 'Encyclopedia of Chicago', 'http://encyclopedia.chicagohistory.org/', 'Free, comprehensive reference source of Chicago history.', 'false', 'true', '2016-12-28 16:34:15', '', 1),
(19, 'cpl.png', '', 'CPL', 'http://www.chipublib.org/', 'Provides subscriber access to over 30 databases for children and adults, including JuniorQuest Magazines; ProQuest Newspapers; SIRS Discoverer; Spanish-language databases; and WorldBook.', 'true', 'true', '2016-12-29 14:44:02', '', 1),
(20, '', 'laptop', 'e CUIP Digital Library', 'http://ecuip.lib.uchicago.edu/', 'Reference and reading materials specially created in support of the CPS curriculum for teachers and students.', 'false', 'true', '2016-12-29 14:43:41', '', 1),
(21, 'PBS_logo_icon.jpg', '', 'PBS Learning Media', 'http://illinois.pbslearningmedia.org/help/Tools-FAQ/', 'The PBS Learning Media site will help you navigate your students through the various resources developed by PBS &amp; WGBH Educational Foundation. Teachers can create their own learning pathways, complete with quizzes and storyboards.', 'false', 'true', '2016-12-28 16:40:59', '', 1),
(22, '', 'simplybuilt', 'The History Makers', 'http://thehistorymakers.com/', 'Free online source for African American biographies, history, timelines, events.', 'false', 'true', '2016-12-28 16:42:48', '', 1),
(23, '', 'connectdevelop', 'Library of Congress', 'http://www.loc.gov/', 'Free online resource for American history. Digital collection includes more than 8 million primary source materials, including historic maps, documents, audio and video.', 'false', 'true', '2016-12-28 16:43:42', '', 1),
(24, '', 'wpexplorer', 'Explore', 'http://cpswebapp.tlcdelivers.com/page.php?loc_id=1', '', 'true', 'true', '2017-01-04 14:36:44', '', 1),
(25, '', 'database', 'Databases', 'http://cpswebapp.tlcdelivers.com/databases.php?loc_id=1', '', 'true', 'true', '2017-01-04 17:09:54', '', 1),
(27, '', 'book', 'Encyclopedia Universal en Espanol', 'http://www.spanish.eb.com/', 'Our subscription includes Britannica&#039;s Spanish language version.', 'false', 'true', '2016-12-29 14:40:32', '', 2),
(28, '', 'book', 'Britannica', 'http://school.eb.com/', 'In addition to millions of articles on as many topics, this online encyclopedia includes Internet links, journal and magazine articles, teacher resources, timelines, dictionary and atlas resources. Select the appropriate grade level.', 'false', 'true', '2016-12-28 17:27:55', '', 2),
(29, '', 'wpexplorer', 'First Search', 'http://firstsearch.oclc.org/', 'Professional and educational magazine and journal articles. Includes ERIC , WorldCat , Article-First , and others.', 'false', 'true', '2016-12-29 14:40:21', '', 2),
(30, '', 'laptop', 'Student Resources in Context', 'http://infotrac.galegroup.com/itweb/cps?db=SUIC', 'A fully integrated database for high school containing thousands of curriculum-targeted primary documents, biographies, essays, critical analyses, full-text coverage of over 1,000 magazines, newspapers, photographs, illustrations, and audio.', 'false', 'true', '2016-12-29 14:40:37', '', 2),
(31, '', 'connectdevelop', 'Research in Context', 'http://infotrac.galegroup.com/itweb/cps?db=MSIC', 'Access continuously updated reference content with full-text magazines, academic journals, news articles, primary source documents, images, videos, audio files and links to vetted websites organized in a user friendly website.', 'false', 'true', '2016-12-28 17:27:56', '', 2),
(32, '', 'book', 'TeachingBooks', 'http://teachingbooks.net/home/', 'Provides original, in-studio movies of authors and illustrators and a wealth of multimedia resources on K-12 books that generate enthusiasm for books and reading.', 'false', 'true', '2016-12-28 16:56:21', '', 2),
(33, '', 'book', 'Flipster', 'http://search.ebscohost.com/login.aspx?authtype=uid&amp;profile=eon', 'Access Cricket Media magazine titles via the EBSCO Flipster Carousal. Click on the login information link above for the user ID and password information. This is a one-year donation that expires June 30, 2017.', 'false', 'true', '2016-12-28 16:32:41', '', 2),
(51, '', 'video-camera', 'Safari Montage', 'http://safari.cps.k12.il.us/', 'View curriculum and standards-focused educational videos from leading publishers.', 'false', 'true', '2016-12-28 16:33:36', '', 2),
(52, '', 'book', 'Encyclopedia of Chicago', 'http://encyclopedia.chicagohistory.org/', 'Free, comprehensive reference source of Chicago history.', 'false', 'true', '2016-12-28 16:34:15', '', 2),
(53, 'cpl.png', '', 'CPL', 'http://www.chipublib.org/', 'Provides subscriber access to over 30 databases for children and adults, including JuniorQuest Magazines; ProQuest Newspapers; SIRS Discoverer; Spanish-language databases; and WorldBook.', 'true', 'true', '2016-12-29 14:42:48', '', 2),
(54, '', 'laptop', 'e CUIP Digital Library', 'http://ecuip.lib.uchicago.edu/', 'Reference and reading materials specially created in support of the CPS curriculum for teachers and students.', 'false', 'true', '2016-12-28 18:19:57', '', 2),
(55, 'PBS_logo_icon.jpg', '', 'PBS Learning Media', 'http://illinois.pbslearningmedia.org/help/Tools-FAQ/', 'The PBS Learning Media site will help you navigate your students through the various resources developed by PBS &amp; WGBH Educational Foundation. Teachers can create their own learning pathways, complete with quizzes and storyboards.', 'false', 'true', '2016-12-28 16:40:59', '', 2),
(56, '', 'simplybuilt', 'The History Makers', 'http://thehistorymakers.com/', 'Free online source for African American biographies, history, timelines, events.', 'false', 'true', '2016-12-28 16:42:48', '', 2),
(57, '', 'connectdevelop', 'Library of Congress', 'http://www.loc.gov/', 'Free online resource for American history. Digital collection includes more than 8 million primary source materials, including historic maps, documents, audio and video.', 'false', 'true', '2017-01-03 22:05:04', '', 10),
(58, '', 'wpexplorer', 'Explore', 'http://cpswebapp.tlcdelivers.com/page.php?loc_id=1', '', 'true', 'true', '2017-01-04 14:36:44', '', 2),
(59, '', 'laptop', 'Databases', 'http://cpswebapp.tlcdelivers.com/databases.php?loc_id=2', '', 'true', 'true', '2017-01-04 17:10:07', '', 2),
(60, '', 'book', 'Encyclopedia Universal en Espanol', 'http://www.spanish.eb.com/', 'Our subscription includes Britannica&#039;s Spanish language version.', 'false', 'true', '2017-01-03 22:05:07', '', 10),
(61, '', 'book', 'Britannica', 'http://school.eb.com/', 'In addition to millions of articles on as many topics, this online encyclopedia includes Internet links, journal and magazine articles, teacher resources, timelines, dictionary and atlas resources. Select the appropriate grade level.', 'false', 'true', '2017-01-03 22:05:09', '', 10),
(62, '', 'wpexplorer', 'First Search', 'http://firstsearch.oclc.org/', 'Professional and educational magazine and journal articles. Includes ERIC , WorldCat , Article-First , and others.', 'false', 'true', '2017-01-03 22:05:11', '', 10),
(63, '', 'laptop', 'Student Resources in Context', 'http://infotrac.galegroup.com/itweb/cps?db=SUIC', 'A fully integrated database for high school containing thousands of curriculum-targeted primary documents, biographies, essays, critical analyses, full-text coverage of over 1,000 magazines, newspapers, photographs, illustrations, and audio.', 'false', 'true', '2017-01-03 22:05:13', '', 10),
(64, '', 'connectdevelop', 'Research in Context', 'http://infotrac.galegroup.com/itweb/cps?db=MSIC', 'Access continuously updated reference content with full-text magazines, academic journals, news articles, primary source documents, images, videos, audio files and links to vetted websites organized in a user friendly website.', 'false', 'true', '2017-01-03 22:05:15', '', 10),
(65, '', 'book', 'TeachingBooks', 'http://teachingbooks.net/home/', 'Provides original, in-studio movies of authors and illustrators and a wealth of multimedia resources on K-12 books that generate enthusiasm for books and reading.', 'false', 'true', '2017-01-03 22:05:18', '', 10),
(66, '', 'book', 'Flipster', 'http://search.ebscohost.com/login.aspx?authtype=uid&amp;profile=eon', 'Access Cricket Media magazine titles via the EBSCO Flipster Carousal. Click on the login information link above for the user ID and password information. This is a one-year donation that expires June 30, 2017.', 'false', 'true', '2017-01-03 22:05:21', '', 10),
(67, '', 'video-camera', 'Safari Montage', 'http://safari.cps.k12.il.us/', 'View curriculum and standards-focused educational videos from leading publishers.', 'false', 'true', '2017-01-03 22:05:23', '', 10),
(68, '', 'book', 'Barry Encyclopedia of Chicago', 'http://encyclopedia.chicagohistory.org/', 'Free, comprehensive reference source of Chicago history.', 'false', 'true', '2017-01-06 01:20:42', 'admin', 10),
(69, 'cpl.png', '', 'CPL', 'http://www.chipublib.org/', 'Provides subscriber access to over 30 databases for children and adults, including JuniorQuest Magazines; ProQuest Newspapers; SIRS Discoverer; Spanish-language databases; and WorldBook.', 'true', 'true', '2017-01-03 22:05:27', '', 10),
(71, 'pbs_logo_icon.jpg', '', 'PBS Learning Media', 'http://illinois.pbslearningmedia.org/help/Tools-FAQ/', 'The PBS Learning Media site will help you navigate your students through the various resources developed by PBS & WGBH Educational Foundation. Teachers can create their own learning pathways, complete with quizzes and storyboards.', 'false', 'true', '2017-01-04 17:07:51', '', 10),
(72, '', 'simplybuilt', 'The History Makers', 'http://thehistorymakers.com/', 'Free online source for African American biographies, history, timelines, events.', 'false', 'true', '2017-01-06 01:17:50', '', 10),
(74, '', 'wpexplorer', 'Explore', 'http://cpswebapp.tlcdelivers.com/page.php?loc_id=10', '', 'true', 'true', '2017-01-06 01:17:47', '', 10),
(75, '', 'laptop', 'Databases', 'http://cpswebapp.tlcdelivers.com/databases.php?loc_id=10', '', 'true', 'true', '2017-01-04 17:10:21', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `featured`
--

CREATE TABLE IF NOT EXISTS `featured` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `introtext` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `image_align` text NOT NULL,
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `featured`
--

INSERT INTO `featured` (`id`, `heading`, `introtext`, `content`, `image`, `image_align`, `use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(1, 'SOAR - Seeking Online Access to Resources', '', '<p>Welcome to the Chicago Public Schools Integrated Library System...Bringing together print and electronic materials for students and teachers who are Seeking Online Access to Resources. &nbsp; &nbsp; &nbsp;&nbsp;</p>', '', 'right', 'false', '2017-01-05 19:59:57', 'admin', 1),
(2, 'Curie Metro High School', 'Virtual Library', '<p>We Strive for Excellence!</p>', '', 'right', 'false', '2017-01-06 03:35:11', 'admin', 2),
(3, 'John Barry Elementary School', 'Virtual Library', '<p>Level 1 school</p>', '', 'right', 'false', '2017-01-06 01:38:14', 'admin', 10),
(4, '', '', '', '', '', 'true', '2017-01-05 16:55:07', 'admin', 5),
(5, '', '', '', '', '', 'true', '2017-01-05 17:45:35', 'admin', 100);

-- --------------------------------------------------------

--
-- Table structure for table `generalinfo`
--

CREATE TABLE IF NOT EXISTS `generalinfo` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `generalinfo`
--

INSERT INTO `generalinfo` (`id`, `heading`, `content`, `use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(1, 'Information', '<p>Chicago Public Schools is the third largest school district in the United States with more than 600 schools providing education to approximately 400,000 children. Our vision is that every student in every neighborhood will be engaged in a rigorous, well-rounded instructional program and will graduate prepared for success in college, career and life.</p>', '', '2016-12-21 17:21:28', '', 1),
(2, 'Information', '<p>Curie HS Chicago Public Schools is the third largest school district in the United States with more than 600 schools providing education to approximately 400,000 children. Our vision is that every student in every neighborhood will be engaged in a rigorous, well-rounded instructional program and will graduate prepared for success in college, career and life.</p>', 'true', '2017-01-06 03:34:32', 'admin', 2),
(3, 'Information', '<p>test Chicago Public Schools is the third largest school district in the United States with more than 600 schools providing education to approximately 400,000 children. Our vision is that every student in every neighborhood will be engaged in a rigorous, well-rounded instructional program and will graduate prepared for success in college, career and life.</p>', 'true', '2017-01-06 02:24:23', 'admin', 10),
(4, '', '', 'true', '2017-01-05 17:20:47', 'admin', 5);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=468 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `datetime`, `active`) VALUES
(1, 'CPS', '2017-01-09 14:28:53', 'true'),
(2, 'Curie Metro High School', '2017-01-04 16:16:00', 'true'),
(3, 'Northside Prep High School', '0000-00-00 00:00:00', 'true'),
(4, 'Hyde Park High School', '0000-00-00 00:00:00', 'true'),
(5, 'Crane Tech Prep', '0000-00-00 00:00:00', 'true'),
(6, 'DuSable Campus', '0000-00-00 00:00:00', 'true'),
(7, 'Amundsen High School', '0000-00-00 00:00:00', 'true'),
(8, 'Professional Library', '0000-00-00 00:00:00', 'true'),
(9, 'Amundsen High School', '0000-00-00 00:00:00', 'true'),
(10, 'Barry Elementary School', '2017-01-04 16:16:30', 'true'),
(11, 'Belding Elementary School', '0000-00-00 00:00:00', 'true'),
(12, 'Budlong Elementary School', '0000-00-00 00:00:00', 'true'),
(13, 'Caldwell Academy', '0000-00-00 00:00:00', 'true'),
(14, 'Clissold Elementary School', '0000-00-00 00:00:00', 'true'),
(15, 'Franklin Fine Arts', '0000-00-00 00:00:00', 'true'),
(16, 'Fulton Elementary School', '0000-00-00 00:00:00', 'true'),
(17, 'Kohn Elementary School', '0000-00-00 00:00:00', 'true'),
(18, 'Locke Elementary School', '0000-00-00 00:00:00', 'true'),
(19, 'May Community', '0000-00-00 00:00:00', 'true'),
(20, 'Jackson Language', '0000-00-00 00:00:00', 'true'),
(21, 'Mt. Vernon Elementary School', '0000-00-00 00:00:00', 'true'),
(22, 'Mozart Elementary School', '0000-00-00 00:00:00', 'true'),
(23, 'The Nettelhorst School', '0000-00-00 00:00:00', 'true'),
(24, 'Sandoval Elementary School , Socorro', '0000-00-00 00:00:00', 'true'),
(25, 'Hurley Elementary School , Edward N', '0000-00-00 00:00:00', 'true'),
(26, 'Norwood Park Elementary School', '0000-00-00 00:00:00', 'true'),
(27, 'Onahan Elementary School', '0000-00-00 00:00:00', 'true'),
(28, 'Palmer Elementary School', '0000-00-00 00:00:00', 'true'),
(29, 'Pirie Elementary School', '0000-00-00 00:00:00', 'true'),
(30, 'Reilly Elementary School', '0000-00-00 00:00:00', 'true'),
(31, 'Frazier Int. Magnet', '0000-00-00 00:00:00', 'true'),
(32, 'Thorp Academy', '0000-00-00 00:00:00', 'true'),
(33, 'Twain Elementary School', '0000-00-00 00:00:00', 'true'),
(34, 'Whistler Elementary School, John', '0000-00-00 00:00:00', 'true'),
(35, 'Whitney Elementary School', '0000-00-00 00:00:00', 'true'),
(36, 'Douglass Academy', '0000-00-00 00:00:00', 'true'),
(37, 'Price Elementary School', '0000-00-00 00:00:00', 'true'),
(38, 'Johnson Elementary School', '0000-00-00 00:00:00', 'true'),
(39, 'Davis Academy', '0000-00-00 00:00:00', 'true'),
(40, 'Higgins Community', '0000-00-00 00:00:00', 'true'),
(41, 'Grant Campus', '0000-00-00 00:00:00', 'true'),
(42, 'Marshall Middle School', '0000-00-00 00:00:00', 'true'),
(43, 'LaSalle II Magnet', '0000-00-00 00:00:00', 'true'),
(44, 'DePriest Elementary School', '0000-00-00 00:00:00', 'true'),
(45, 'Harlan High School', '0000-00-00 00:00:00', 'true'),
(46, 'Tilden High School', '0000-00-00 00:00:00', 'true'),
(47, 'Vaughn Occ High School', '0000-00-00 00:00:00', 'true'),
(48, 'Uplift Community High School', '0000-00-00 00:00:00', 'true'),
(49, 'Haley Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(50, 'Cameron Elementary School', '0000-00-00 00:00:00', 'true'),
(51, 'Copernicus Elementary School', '0000-00-00 00:00:00', 'true'),
(52, 'Gale Academy', '0000-00-00 00:00:00', 'true'),
(53, 'Greene Elementary School', '0000-00-00 00:00:00', 'true'),
(54, 'Gunsaulus Academy', '0000-00-00 00:00:00', 'true'),
(55, 'Kershaw Elementary School', '0000-00-00 00:00:00', 'true'),
(56, 'Lloyd Elementary School', '0000-00-00 00:00:00', 'true'),
(57, 'Mayer Magnet', '0000-00-00 00:00:00', 'true'),
(58, 'Keller Magnet Elementary School', '0000-00-00 00:00:00', 'true'),
(59, 'Owen Academy', '0000-00-00 00:00:00', 'true'),
(60, 'Pasteur Elementary School', '0000-00-00 00:00:00', 'true'),
(61, 'Prussing Elementary School', '0000-00-00 00:00:00', 'true'),
(62, 'Pulaski International School of Chicago', '0000-00-00 00:00:00', 'true'),
(63, 'Armstrong L Elementary School', '0000-00-00 00:00:00', 'true'),
(64, 'Spencer Academy', '0000-00-00 00:00:00', 'true'),
(65, 'Stockton Elementary School', '0000-00-00 00:00:00', 'true'),
(66, 'Trumbull Elementary School', '0000-00-00 00:00:00', 'true'),
(67, 'Banneker Elementary School', '0000-00-00 00:00:00', 'true'),
(68, 'Dumas Elementary School', '0000-00-00 00:00:00', 'true'),
(69, 'Woods Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(70, 'Lenart Gifted', '0000-00-00 00:00:00', 'true'),
(71, 'Payton Coll Prep High School', '0000-00-00 00:00:00', 'true'),
(72, 'Little Village High School Campus', '0000-00-00 00:00:00', 'true'),
(73, 'Hancock Coll Prep', '0000-00-00 00:00:00', 'true'),
(74, 'Fenger High School', '0000-00-00 00:00:00', 'true'),
(75, 'Robeson High School', '0000-00-00 00:00:00', 'true'),
(76, 'Hirsch Metro High School', '0000-00-00 00:00:00', 'true'),
(77, 'Kennedy High School', '0000-00-00 00:00:00', 'true'),
(78, 'Lake View High School', '0000-00-00 00:00:00', 'true'),
(79, 'Manley High School', '0000-00-00 00:00:00', 'true'),
(80, 'Brooks Coll Prep High School', '0000-00-00 00:00:00', 'true'),
(81, 'Schurz High School', '0000-00-00 00:00:00', 'true'),
(82, 'Senn Campus', '0000-00-00 00:00:00', 'true'),
(83, 'Taft High School', '0000-00-00 00:00:00', 'true'),
(84, 'Lincoln Park High School', '0000-00-00 00:00:00', 'true'),
(85, 'Wells Academy High School', '0000-00-00 00:00:00', 'true'),
(86, 'Chicago Military High School', '0000-00-00 00:00:00', 'true'),
(87, 'Orr Academy High School', '0000-00-00 00:00:00', 'true'),
(88, 'Carver Military High School', '0000-00-00 00:00:00', 'true'),
(89, 'Corliss High School', '0000-00-00 00:00:00', 'true'),
(90, 'Armstrong G Elementary School', '0000-00-00 00:00:00', 'true'),
(91, 'Beaubien Elementary School', '0000-00-00 00:00:00', 'true'),
(92, 'Bradwell Elementary School', '0000-00-00 00:00:00', 'true'),
(93, 'Bridge Elementary School', '0000-00-00 00:00:00', 'true'),
(94, 'Cassell Elementary School', '0000-00-00 00:00:00', 'true'),
(95, 'Greeley Elementary School', '0000-00-00 00:00:00', 'true'),
(96, 'Clay Elementary School', '0000-00-00 00:00:00', 'true'),
(97, 'Clinton Elementary School', '0000-00-00 00:00:00', 'true'),
(98, 'Coles Academy', '0000-00-00 00:00:00', 'true'),
(99, 'Columbus Elementary School', '0000-00-00 00:00:00', 'true'),
(100, 'Jordan Community', '2017-01-05 20:39:00', 'true'),
(101, 'Eberhart Elementary School', '0000-00-00 00:00:00', 'true'),
(102, 'Edwards Elementary School', '0000-00-00 00:00:00', 'true'),
(103, 'Emmet Elementary School', '0000-00-00 00:00:00', 'true'),
(104, 'Ericson Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(105, 'Kanoon Magnet Elementary School', '0000-00-00 00:00:00', 'true'),
(106, 'Gary Elementary School', '0000-00-00 00:00:00', 'true'),
(107, 'Ninos Heroes AC', '0000-00-00 00:00:00', 'true'),
(108, 'Hitch Elementary School', '0000-00-00 00:00:00', 'true'),
(109, 'Holmes Elementary School', '0000-00-00 00:00:00', 'true'),
(110, 'Lewis Elementary School', '0000-00-00 00:00:00', 'true'),
(111, 'Lowell Elementary School, James R', '0000-00-00 00:00:00', 'true'),
(112, 'Till Academy', '0000-00-00 00:00:00', 'true'),
(113, 'Moos Elementary School', '0000-00-00 00:00:00', 'true'),
(114, 'Morrill Elementary School', '0000-00-00 00:00:00', 'true'),
(115, 'Beard Elementary School', '0000-00-00 00:00:00', 'true'),
(116, 'Murray Lang Academy', '0000-00-00 00:00:00', 'true'),
(117, 'West Park Academy', '0000-00-00 00:00:00', 'true'),
(118, 'Parker Academy', '0000-00-00 00:00:00', 'true'),
(119, 'Peterson Elementary School', '0000-00-00 00:00:00', 'true'),
(120, 'Pickard Elementary School', '0000-00-00 00:00:00', 'true'),
(121, 'Reinberg Elementary School', '0000-00-00 00:00:00', 'true'),
(122, 'Sawyer Elementary School', '0000-00-00 00:00:00', 'true'),
(123, 'Scammon Elementary School', '0000-00-00 00:00:00', 'true'),
(124, 'Seward Academy', '0000-00-00 00:00:00', 'true'),
(125, 'Sexton Elementary School', '0000-00-00 00:00:00', 'true'),
(126, 'Mireles Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(127, 'Shoop Academy', '0000-00-00 00:00:00', 'true'),
(128, 'Smyth Elementary School', '0000-00-00 00:00:00', 'true'),
(129, 'Swift Elementary School', '0000-00-00 00:00:00', 'true'),
(130, 'Talcott Elementary School', '0000-00-00 00:00:00', 'true'),
(131, 'Coleman Academy', '0000-00-00 00:00:00', 'true'),
(132, 'Tilton Elementary School', '0000-00-00 00:00:00', 'true'),
(133, 'Volta Elementary School', '0000-00-00 00:00:00', 'true'),
(134, 'Albany Park Campus', '0000-00-00 00:00:00', 'true'),
(135, 'Dvorak Academy', '0000-00-00 00:00:00', 'true'),
(136, 'Buckingham Center', '0000-00-00 00:00:00', 'true'),
(137, 'Ashburn Elementary School', '0000-00-00 00:00:00', 'true'),
(138, 'Westcott Elementary School', '0000-00-00 00:00:00', 'true'),
(139, 'Brighton Park Elementary School', '0000-00-00 00:00:00', 'true'),
(140, 'Roque de Duprey Elementary School', '0000-00-00 00:00:00', 'true'),
(141, 'Orozco Elementary School', '0000-00-00 00:00:00', 'true'),
(142, 'Ace Tech Campus', '0000-00-00 00:00:00', 'true'),
(143, 'Clemente Academy High School', '0000-00-00 00:00:00', 'true'),
(144, 'Skinner West ES', '0000-00-00 00:00:00', 'true'),
(145, 'Hernandez MS', '0000-00-00 00:00:00', 'true'),
(146, 'Dulles School of Excellence', '0000-00-00 00:00:00', 'true'),
(147, 'Hughes L ES', '0000-00-00 00:00:00', 'true'),
(148, 'Prieto ES', '0000-00-00 00:00:00', 'true'),
(149, 'South Shore Academy', '0000-00-00 00:00:00', 'true'),
(150, 'Westinghouse HS', '0000-00-00 00:00:00', 'true'),
(151, 'Cooper Elementary Dual Language Academy, Peter', '0000-00-00 00:00:00', 'true'),
(152, 'Clark Magnet High School', '0000-00-00 00:00:00', 'true'),
(153, 'Bethune Elementary School', '0000-00-00 00:00:00', 'true'),
(154, 'Blaine Elementary School', '0000-00-00 00:00:00', 'true'),
(155, 'Boone Elementary School', '0000-00-00 00:00:00', 'true'),
(156, 'Byrne Elementary School', '0000-00-00 00:00:00', 'true'),
(157, 'Carver Primary School', '0000-00-00 00:00:00', 'true'),
(158, 'Chappell Elementary School', '0000-00-00 00:00:00', 'true'),
(159, 'Chicago Academy High School', '0000-00-00 00:00:00', 'true'),
(160, 'Christopher Elementary School', '0000-00-00 00:00:00', 'true'),
(161, 'Daley Elementary Academy', '0000-00-00 00:00:00', 'true'),
(162, 'Dunbar Career Academy High School', '0000-00-00 00:00:00', 'true'),
(163, 'Dunne Elementary School', '0000-00-00 00:00:00', 'true'),
(164, 'Dvorak Elementary Specialty Academy', '0000-00-00 00:00:00', 'true'),
(165, 'Dyett High School', '0000-00-00 00:00:00', 'true'),
(166, 'Edward Coles Elementary Language Academy', '0000-00-00 00:00:00', 'true'),
(167, 'Farnsworth Elementary School', '0000-00-00 00:00:00', 'true'),
(168, 'Fort Dearborn Elementary School', '0000-00-00 00:00:00', 'true'),
(169, 'Garfield Park Preparatory Academy ES', '0000-00-00 00:00:00', 'true'),
(170, 'Garvy Elementary School, John W.', '0000-00-00 00:00:00', 'true'),
(171, 'Gregory Elementary School', '0000-00-00 00:00:00', 'true'),
(172, 'Hammond Elementary School', '0000-00-00 00:00:00', 'true'),
(173, 'Hancock College Preparatory High School', '0000-00-00 00:00:00', 'true'),
(174, 'Julian High School', '0000-00-00 00:00:00', 'true'),
(175, 'Kozminski Elementary Community Academy', '0000-00-00 00:00:00', 'true'),
(176, 'Lake View High School', '0000-00-00 00:00:00', 'true'),
(177, 'Marshall Metropolitan High School', '0000-00-00 00:00:00', 'true'),
(178, 'Nash Elementary School', '0000-00-00 00:00:00', 'true'),
(179, 'Ninos Heroes Elementary Academic Center', '0000-00-00 00:00:00', 'true'),
(180, 'Nixon Elementary School', '0000-00-00 00:00:00', 'true'),
(181, 'Ogden International High School', '0000-00-00 00:00:00', 'true'),
(182, 'Peirce International Studies ES', '0000-00-00 00:00:00', 'true'),
(183, 'Perez Elementary School', '0000-00-00 00:00:00', 'true'),
(184, 'Richards Career Academy High School', '0000-00-00 00:00:00', 'true'),
(185, 'Sabin Elementary Dual Language Magnet School', '0000-00-00 00:00:00', 'true'),
(186, 'Skinner North Classical Elementary', '0000-00-00 00:00:00', 'true'),
(187, 'Sullivan High School', '0000-00-00 00:00:00', 'true'),
(188, 'Talcott Elementary School', '0000-00-00 00:00:00', 'true'),
(189, 'Walsh Elementary School', '0000-00-00 00:00:00', 'true'),
(190, 'Ward Elementary School, James', '0000-00-00 00:00:00', 'true'),
(191, 'Beidler, Elementary School, Jacob', '0000-00-00 00:00:00', 'true'),
(192, 'Bennett Elementary School, Frank I', '0000-00-00 00:00:00', 'true'),
(193, 'Black Magnet Elementary School, Robert A ', '0000-00-00 00:00:00', 'true'),
(194, 'Black Magnet Elementary School, Robert A - Branch', '0000-00-00 00:00:00', 'true'),
(195, 'Brentano Math & Science Academy ES, Lorenz', '0000-00-00 00:00:00', 'true'),
(196, 'Burr Elementary School, Jonathan ', '0000-00-00 00:00:00', 'true'),
(197, 'Chase Elementary School, Salmon P', '0000-00-00 00:00:00', 'true'),
(198, 'Chavez Multicultural Academic Center ES, Cesar E - Lower Library', '0000-00-00 00:00:00', 'true'),
(199, 'Chavez Multicultural Academic Center ES, Cesar E', '0000-00-00 00:00:00', 'true'),
(200, 'Coonley Elementary School, John C.', '0000-00-00 00:00:00', 'true'),
(201, 'Disney Magnet Elementary School, Walt', '0000-00-00 00:00:00', 'true'),
(202, 'Durkin Park Elementary School', '0000-00-00 00:00:00', 'true'),
(203, 'Esmond Elementary School', '0000-00-00 00:00:00', 'true'),
(204, 'Falconer Elementary School, Laughlin', '0000-00-00 00:00:00', 'true'),
(205, 'Gage Park High School', '0000-00-00 00:00:00', 'true'),
(206, 'Gary Elementary School, Joseph E - New', '0000-00-00 00:00:00', 'true'),
(207, 'Gary Elementary School. Joseph E - Main', '0000-00-00 00:00:00', 'true'),
(208, 'Hale Elementary School, Nathan', '0000-00-00 00:00:00', 'true'),
(209, 'Hamilton Elementary School, Alexander', '0000-00-00 00:00:00', 'true'),
(210, 'Hanson Park Elementary School - Branch', '0000-00-00 00:00:00', 'true'),
(211, 'Hanson Park Elementary School - Main Library', '0000-00-00 00:00:00', 'true'),
(212, 'Harte Elementary School, Bret', '0000-00-00 00:00:00', 'true'),
(213, 'Hedges Elementary School, James ', '0000-00-00 00:00:00', 'true'),
(214, 'Inter-American Elementary Magnet School', '0000-00-00 00:00:00', 'true'),
(215, 'Juarez Community Academy High School, Benito', '0000-00-00 00:00:00', 'true'),
(216, 'Kenwood Academy High School', '0000-00-00 00:00:00', 'true'),
(217, 'LaSalle Elementary Language Academy', '0000-00-00 00:00:00', 'true'),
(218, 'Lindblom Math & Science Academy HS, Robert', '0000-00-00 00:00:00', 'true'),
(219, 'Logandale Middle School', '0000-00-00 00:00:00', 'true'),
(220, 'Lovett Elementary School, Joseph', '0000-00-00 00:00:00', 'true'),
(221, 'McAuliffe Elementary School, Sharon Christa', '0000-00-00 00:00:00', 'true'),
(222, 'McPherson ES', '0000-00-00 00:00:00', 'true'),
(223, 'Metcalfe Elementary Community Academy, Ralph H', '0000-00-00 00:00:00', 'true'),
(224, 'Morgan Park High School', '0000-00-00 00:00:00', 'true'),
(225, 'National Teachers Elementary Academy', '0000-00-00 00:00:00', 'true'),
(226, 'Newberry Math & Science Academy ES, Walter L.', '0000-00-00 00:00:00', 'true'),
(227, 'North Lawndale HS', '0000-00-00 00:00:00', 'true'),
(228, 'Ogden Elementary School, William B.', '0000-00-00 00:00:00', 'true'),
(229, 'Powell Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(230, 'Powell Academy ES', '0000-00-00 00:00:00', 'true'),
(231, 'Pritzker School, A.N.', '0000-00-00 00:00:00', 'true'),
(232, 'Raby High School, Al', '0000-00-00 00:00:00', 'true'),
(233, 'Rudolph Elementary Learning Center, Wilma', '0000-00-00 00:00:00', 'true'),
(234, 'Ruiz Elementary School, Irma C', '0000-00-00 00:00:00', 'true'),
(235, 'Shoop Math-Science Technical Academy ES, John D ', '0000-00-00 00:00:00', 'true'),
(236, 'South Loop Elementary School', '0000-00-00 00:00:00', 'true'),
(237, 'Suder Montessori Magnet ES', '0000-00-00 00:00:00', 'true'),
(238, 'von Steuben Metropolitan Science HS, Friedrich W', '0000-00-00 00:00:00', 'true'),
(239, 'Washington High School, George', '0000-00-00 00:00:00', 'true'),
(240, 'Azuela Elementary School, Mariano', '0000-00-00 00:00:00', 'true'),
(241, 'Bradwell Communications Arts & Science ES, Myra', '0000-00-00 00:00:00', 'true'),
(242, 'Brennemann Elementary School, Joseph', '0000-00-00 00:00:00', 'true'),
(243, 'Calmeca Academy of Fine Arts and Dual Language', '0000-00-00 00:00:00', 'true'),
(244, 'Camras Elementary School, Marvin', '0000-00-00 00:00:00', 'true'),
(245, 'Clinton Elementary School, DeWitt', '0000-00-00 00:00:00', 'true'),
(246, 'Graham Training Center High School, Ray', '0000-00-00 00:00:00', 'true'),
(247, 'Lorca Elementary School, Federico Garcia', '0000-00-00 00:00:00', 'true'),
(248, 'Wadsworth Elementary School, James', '0000-00-00 00:00:00', 'true'),
(249, 'Zaragoza', '0000-00-00 00:00:00', 'true'),
(250, 'Parkman Elementary School, Francis', '0000-00-00 00:00:00', 'true'),
(251, 'Hammond Elementary School, Charles G', '0000-00-00 00:00:00', 'true'),
(252, 'Hale Elementary School, Nathan', '0000-00-00 00:00:00', 'true'),
(253, 'Washington Elementary School, George', '0000-00-00 00:00:00', 'true'),
(254, 'Solorio Academy High School, Eric', '0000-00-00 00:00:00', 'true'),
(255, 'Lorca Elementary School, Federico Garcia', '0000-00-00 00:00:00', 'true'),
(256, 'West Ridge Elementary School', '0000-00-00 00:00:00', 'true'),
(257, 'Fernwood Elementary School', '0000-00-00 00:00:00', 'true'),
(258, 'Woodson South Elementary School, Carter G', '0000-00-00 00:00:00', 'true'),
(259, 'Jefferson Alternative High School, Nancy B', '0000-00-00 00:00:00', 'true'),
(260, 'Galileo Math & Science Scholastic Academy', '0000-00-00 00:00:00', 'true'),
(261, 'Phillips Academy High School, Wendell', '0000-00-00 00:00:00', 'true'),
(262, 'Gillespie Elementary School, Frank L', '0000-00-00 00:00:00', 'true'),
(263, 'Lara Elementary Academy, Agustin', '0000-00-00 00:00:00', 'true'),
(264, 'Hibbard Elementary School, William G', '0000-00-00 00:00:00', 'true'),
(265, 'Funston Elementary School, Frederick', '0000-00-00 00:00:00', 'true'),
(266, 'Garvey Elementary School, Marcus Moziah', '0000-00-00 00:00:00', 'true'),
(267, 'Bowen High School', '0000-00-00 00:00:00', 'true'),
(268, 'Solomon Elementary School, Hannah G', '0000-00-00 00:00:00', 'true'),
(269, 'M. M. Garvey ES', '0000-00-00 00:00:00', 'true'),
(270, 'Sheridan (Mark) Math & Science Academy', '0000-00-00 00:00:00', 'true'),
(271, 'Kinzie Elementary School, John H', '0000-00-00 00:00:00', 'true'),
(272, 'Saucedo Elementary Scholastic Academy, Maria', '0000-00-00 00:00:00', 'true'),
(273, 'Belmont-Cragin', '0000-00-00 00:00:00', 'true'),
(274, 'Simeon Career Academy High School, Neal F', '0000-00-00 00:00:00', 'true'),
(275, 'Mather High School, Stephen T', '0000-00-00 00:00:00', 'true'),
(276, 'Roosevelt High School, Theodore', '0000-00-00 00:00:00', 'true'),
(277, 'Little Village Elementary School', '0000-00-00 00:00:00', 'true'),
(278, 'Lavizzo Elementary School, Mildred I', '0000-00-00 00:00:00', 'true'),
(279, 'Sandoval ES', '0000-00-00 00:00:00', 'true'),
(280, 'Chicago Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(281, 'North River Elementary School', '0000-00-00 00:00:00', 'true'),
(282, 'Agassiz Elementary School, Louis A', '0000-00-00 00:00:00', 'true'),
(283, 'Carter Elementary School, William W', '0000-00-00 00:00:00', 'true'),
(284, 'Cook Elementary School, John W', '0000-00-00 00:00:00', 'true'),
(285, 'Dirksen Elementary School, Everett McKinley', '0000-00-00 00:00:00', 'true'),
(286, 'Everett Elementary School, Edward', '0000-00-00 00:00:00', 'true'),
(287, 'Goethe Elementary School, Johann W von', '0000-00-00 00:00:00', 'true'),
(288, 'Hawthorne Elementary Scholastic Academy', '0000-00-00 00:00:00', 'true'),
(289, 'Kelvyn Park High School', '0000-00-00 00:00:00', 'true'),
(290, 'Mount Greenwood Elementary School', '0000-00-00 00:00:00', 'true'),
(291, 'Wentworth Elementary School, Daniel S', '0000-00-00 00:00:00', 'true'),
(292, 'Dirksen Elementary School', '0000-00-00 00:00:00', 'true'),
(293, 'Chicago High School for Agricultural Sciences', '0000-00-00 00:00:00', 'true'),
(294, 'Ariel Elementary Community Academy', '0000-00-00 00:00:00', 'true'),
(295, 'Bogan High School, William J', '0000-00-00 00:00:00', 'true'),
(296, 'Brighton Park Elementary School', '0000-00-00 00:00:00', 'true'),
(297, 'Castellanos Elementary School, Rosario', '0000-00-00 00:00:00', 'true'),
(298, 'Claremont Academy Elementary School', '0000-00-00 00:00:00', 'true'),
(299, 'Cleveland Elementary School, Grover', '0000-00-00 00:00:00', 'true'),
(300, 'Corkery Elementary School, Daniel J', '0000-00-00 00:00:00', 'true'),
(301, 'Dever Elementary School', '0000-00-00 00:00:00', 'true'),
(302, 'Dodge Elementary Renaissance Academy, Mary Mapes', '0000-00-00 00:00:00', 'true'),
(303, 'Ebinger Elementary School, Christian', '0000-00-00 00:00:00', 'true'),
(304, 'Field Elementary School, Eugene', '0000-00-00 00:00:00', 'true'),
(305, 'Graham Elementary School, Alexander', '0000-00-00 00:00:00', 'true'),
(306, 'Hamline Elementary School, John H', '0000-00-00 00:00:00', 'true'),
(307, 'Henderson Elementary School, Charles R', '0000-00-00 00:00:00', 'true'),
(308, 'King Jr Academy of Social Justice, Dr. Martin L.', '0000-00-00 00:00:00', 'true'),
(309, 'Hope College Preparatory High School', '0000-00-00 00:00:00', 'true'),
(310, 'Jamieson Elementary School, Minnie Mars', '0000-00-00 00:00:00', 'true'),
(311, 'Lee Elementary School, Richard Henry', '0000-00-00 00:00:00', 'true'),
(312, 'Libby Elementary School, Arthur A ', '0000-00-00 00:00:00', 'true'),
(313, 'Linne Elementary School, Carl von', '0000-00-00 00:00:00', 'true'),
(314, 'Manierre Elementary School, George', '0000-00-00 00:00:00', 'true'),
(315, 'Marquette Elementary School', '0000-00-00 00:00:00', 'true'),
(316, 'Marsh Elementary School, John L', '0000-00-00 00:00:00', 'true'),
(317, 'McDade Elementary Classical School, James E', '0000-00-00 00:00:00', 'true'),
(318, 'Morton School of Excellence', '0000-00-00 00:00:00', 'true'),
(319, 'Namaste Charter Elementary School', '0000-00-00 00:00:00', 'true'),
(320, 'New Sullivan Elementary School, William K', '0000-00-00 00:00:00', 'true'),
(321, 'Nightingale Elementary School, Florence', '0000-00-00 00:00:00', 'true'),
(322, 'Pershing Elementary Humanities Magnet, John J', '0000-00-00 00:00:00', 'true'),
(323, 'Ray Elementary School ', '0000-00-00 00:00:00', 'true'),
(324, 'Sandoval Elementary School, Socorro', '0000-00-00 00:00:00', 'true'),
(325, 'Sayre Language Academy, Harriet', '0000-00-00 00:00:00', 'true'),
(326, 'Goudy Elementary School, William C', '0000-00-00 00:00:00', 'true'),
(327, 'Haugan Elementary School, Helge A', '0000-00-00 00:00:00', 'true'),
(328, 'Smyser Elementary School, Washington D', '0000-00-00 00:00:00', 'true'),
(329, 'South Shore International College Prep High School', '0000-00-00 00:00:00', 'true'),
(330, 'Spry & Community Links, John', '0000-00-00 00:00:00', 'true'),
(331, 'Stowe Elementary School, Harriet Beecher', '0000-00-00 00:00:00', 'true'),
(332, 'Tarkington School of Excellence ES', '0000-00-00 00:00:00', 'true'),
(333, 'Vanderpoel Elementary Magnet School, John H', '0000-00-00 00:00:00', 'true'),
(334, 'Von Humboldt Elementary School, Alexander', '0000-00-00 00:00:00', 'true'),
(335, 'Waters Elementary School, Thomas J', '0000-00-00 00:00:00', 'true'),
(336, 'White Elementary Career Academy, Edward', '0000-00-00 00:00:00', 'true'),
(337, 'Whittier Elementary School, John Greenleaf', '0000-00-00 00:00:00', 'true'),
(338, 'Woodlawn Community Elementary School', '0000-00-00 00:00:00', 'true'),
(339, 'Zapata Elementary Academy, Emiliano', '0000-00-00 00:00:00', 'true'),
(340, 'Fernwood Elementary School', '0000-00-00 00:00:00', 'true'),
(341, 'McKay Elementary School, Francis M', '0000-00-00 00:00:00', 'true'),
(342, 'Hayt Elementary School, Stephen K', '0000-00-00 00:00:00', 'true'),
(343, 'Alcott High School for the Humanities', '0000-00-00 00:00:00', 'true'),
(344, 'Agassiz Elementary School', '0000-00-00 00:00:00', 'true'),
(345, 'Canty Elementary School, Arthur E', '0000-00-00 00:00:00', 'true'),
(346, 'Cardenas Elementary School, Lazaro', '0000-00-00 00:00:00', 'true'),
(347, 'Chicago Vocational Career Academy High School', '0000-00-00 00:00:00', 'true'),
(348, 'Columbia Explorers Elementary Academy', '0000-00-00 00:00:00', 'true'),
(349, 'Edgebrook Elementary School', '0000-00-00 00:00:00', 'true'),
(350, 'Farragut Career Academy High School, David G', '0000-00-00 00:00:00', 'true'),
(351, 'Schubert Elementary School, Franz Peter ', '0000-00-00 00:00:00', 'true'),
(352, 'Schubert Elementary School, Franz Peter ', '0000-00-00 00:00:00', 'true'),
(353, 'Herzl Elementary School, Theodore', '0000-00-00 00:00:00', 'true'),
(354, 'Murphy Elementary School, John B', '0000-00-00 00:00:00', 'true'),
(355, 'Lafayette Elementary School, Jean D', '0000-00-00 00:00:00', 'true'),
(356, 'Melody Elementary School, Genevieve', '0000-00-00 00:00:00', 'true'),
(357, 'New Field Elementary School', '0000-00-00 00:00:00', 'true'),
(358, 'Cuffe Math-Science Technology Academy ES, Paul', '0000-00-00 00:00:00', 'true'),
(359, 'Portage Park Elementary School', '0000-00-00 00:00:00', 'true'),
(360, 'Prescott Elementary School, William H', '0000-00-00 00:00:00', 'true'),
(361, 'Ryerson Elementary School, Martin A', '0000-00-00 00:00:00', 'true'),
(362, 'Kelly High School, Thomas', '0000-00-00 00:00:00', 'true'),
(363, 'Young Magnet High School, Whitney M', '0000-00-00 00:00:00', 'true'),
(364, 'STEM Magnet Academy', '0000-00-00 00:00:00', 'true'),
(365, 'Stevenson Elementary School, Adlai E', '0000-00-00 00:00:00', 'true'),
(366, 'Talman Elementary School', '0000-00-00 00:00:00', 'true'),
(367, 'Drummond Elementary School, Thomas', '0000-00-00 00:00:00', 'true'),
(368, 'Brown Elementary Community Academy, Ronald', '0000-00-00 00:00:00', 'true'),
(369, 'Bright Elementary School, Orville T', '0000-00-00 00:00:00', 'true'),
(370, 'Ross Elementary School, Betsy', '0000-00-00 00:00:00', 'true'),
(371, 'White Elementary Career Academy, Edward', '0000-00-00 00:00:00', 'true'),
(372, 'Yates Elementary School, Richard', '0000-00-00 00:00:00', 'true'),
(373, 'Brunson Math & Science Specialty ES, Brunson', '0000-00-00 00:00:00', 'true'),
(374, 'Burley Elementary School, Augustus H', '0000-00-00 00:00:00', 'true'),
(375, 'Evergreen Academy Middle School', '0000-00-00 00:00:00', 'true'),
(376, 'Foreman High School , Edwin G', '0000-00-00 00:00:00', 'true'),
(377, 'Gray Elementary School, William P', '0000-00-00 00:00:00', 'true'),
(378, 'Neil Elementary School, Jane A', '0000-00-00 00:00:00', 'true'),
(379, 'Nobel Elementary School, Alfred', '0000-00-00 00:00:00', 'true'),
(380, 'Northwest Middle School', '0000-00-00 00:00:00', 'true'),
(381, 'Stone Elementary Scholastic Academy', '0000-00-00 00:00:00', 'true'),
(382, 'Tonti Elementary School, Enrico', '0000-00-00 00:00:00', 'true'),
(383, 'McCutcheon Elementary School, John T', '0000-00-00 00:00:00', 'true'),
(384, 'Instituto Health Sciences Career Academy HS', '0000-00-00 00:00:00', 'true'),
(385, 'Bateman Elementary School, Newton', '0000-00-00 00:00:00', 'true'),
(386, 'Beasley Elementary Magnet Academic Center, Edward', '0000-00-00 00:00:00', 'true'),
(387, 'Burroughs Elementary School, John C', '0000-00-00 00:00:00', 'true'),
(388, 'Esmond Elementary School', '0000-00-00 00:00:00', 'true'),
(389, 'Fermi Elementary School , Enrico', '0000-00-00 00:00:00', 'true'),
(390, 'Lincoln Elementary School, Abraham', '0000-00-00 00:00:00', 'true'),
(391, 'North-Grand High School', '0000-00-00 00:00:00', 'true'),
(392, 'Pilsen Elementary Community Academy', '0000-00-00 00:00:00', 'true'),
(393, 'Wildwood Elementary School', '0000-00-00 00:00:00', 'true'),
(394, 'Chicago Quest North', '0000-00-00 00:00:00', 'true'),
(395, 'Learn South', '0000-00-00 00:00:00', 'true'),
(396, 'King Jr College Prep HS, Dr Martin Luther', '0000-00-00 00:00:00', 'true'),
(397, 'Shields Middle School, James', '0000-00-00 00:00:00', 'true'),
(398, 'Bell Elementary School, Alexander Graham', '0000-00-00 00:00:00', 'true'),
(399, 'Falconer Elementary School, Laughlin', '0000-00-00 00:00:00', 'true'),
(400, 'Stewart Elementary School, Graeme', '0000-00-00 00:00:00', 'true'),
(401, 'Randolph Elementary School, Asa Philip', '0000-00-00 00:00:00', 'true'),
(402, 'Burbank Elementary School, Luther', '0000-00-00 00:00:00', 'true'),
(403, 'Holden Elementary School, Charles N', '0000-00-00 00:00:00', 'true'),
(404, 'Burley Elementary School, Augustus H', '0000-00-00 00:00:00', 'true'),
(405, 'Marine Leadership Academy', '0000-00-00 00:00:00', 'true'),
(406, 'Lyon Elementary School, Mary', '0000-00-00 00:00:00', 'true'),
(407, 'Carnegie Elementary School, Andrew', '0000-00-00 00:00:00', 'true'),
(408, 'Healy Elementary School, Robert', '0000-00-00 00:00:00', 'true'),
(409, 'Black Magnet Elementary School, Robert A', '0000-00-00 00:00:00', 'true'),
(410, 'Rogers Elementary School , Philip', '0000-00-00 00:00:00', 'true'),
(411, 'Montefiore Special Elementary School, Moses', '0000-00-00 00:00:00', 'true'),
(412, 'Haines Elementary School, John Charles', '0000-00-00 00:00:00', 'true'),
(413, 'Carson Elementary School, Rachel', '0000-00-00 00:00:00', 'true'),
(414, 'Finkl Elementary School, William F', '0000-00-00 00:00:00', 'true'),
(415, 'Henry Elementary School, Patrick', '0000-00-00 00:00:00', 'true'),
(416, 'McNair Elementary School, Ronald E', '0000-00-00 00:00:00', 'true'),
(417, 'Penn Elementary School, William', '0000-00-00 00:00:00', 'true'),
(418, 'Reavis Math & Science Specialty ES, William C', '0000-00-00 00:00:00', 'true'),
(419, 'Gallistel Elementary Language Academy, Mathew', '0000-00-00 00:00:00', 'true'),
(420, 'Ellington Elementary School, Edward K', '0000-00-00 00:00:00', 'true'),
(421, 'Burnside Elementary Scholastic Academy', '0000-00-00 00:00:00', 'true'),
(422, 'Brighton Park Elementary School', '0000-00-00 00:00:00', 'true'),
(423, 'Addams Elementary School, Jane', '0000-00-00 00:00:00', 'true'),
(424, 'Taylor Elementary School , Douglas', '0000-00-00 00:00:00', 'true'),
(425, 'Davis Elementary School, Nathan S', '0000-00-00 00:00:00', 'true'),
(426, 'Jones College Preparatory High School , William', '0000-00-00 00:00:00', 'true'),
(427, 'Monroe Elementary School, James', '0000-00-00 00:00:00', 'true'),
(428, 'Kellogg Elementary School , Kate S', '0000-00-00 00:00:00', 'true'),
(429, 'Sumner Math & Science Community Acad ES, Charles', '0000-00-00 00:00:00', 'true'),
(430, 'Mount Vernon Elementary School ', '0000-00-00 00:00:00', 'true'),
(431, 'Colemon Elementary Academy, Johnnie', '0000-00-00 00:00:00', 'true'),
(432, 'McCormick Elementary School, Cyrus H', '0000-00-00 00:00:00', 'true'),
(433, 'Hubbard High School, Gurdon S', '0000-00-00 00:00:00', 'true'),
(434, 'Jenner Elementary Academy of the Arts, Edward', '0000-00-00 00:00:00', 'true'),
(435, 'Leland Elementary School, George', '0000-00-00 00:00:00', 'true'),
(436, 'Faraday Elementary School, Michael', '0000-00-00 00:00:00', 'true'),
(437, 'Kellman Corporate Community ES, Joseph', '0000-00-00 00:00:00', 'true'),
(438, 'Wells Preparatory Elementary Academy, Ida B', '0000-00-00 00:00:00', 'true'),
(439, 'Ward Elementary School, Laura S', '0000-00-00 00:00:00', 'true'),
(440, 'Fiske Elementary School , John', '0000-00-00 00:00:00', 'true'),
(441, 'Harvard Elementary School of Excellence, John', '0000-00-00 00:00:00', 'true'),
(442, 'Air Force Academy High School', '0000-00-00 00:00:00', 'true'),
(443, 'ASPIRA Charter - Haugan Campus', '0000-00-00 00:00:00', 'true'),
(444, 'Intrinsic Schools', '0000-00-00 00:00:00', 'true'),
(445, 'Hearst Elementary School, Phobe Apperson', '0000-00-00 00:00:00', 'true'),
(446, 'Alcott Elementary School, Louisa May', '0000-00-00 00:00:00', 'true'),
(447, 'Dixon Elementary School, Arthur', '0000-00-00 00:00:00', 'true'),
(448, 'Lane Technical High School, Albert G', '0000-00-00 00:00:00', 'true'),
(449, 'North Lawndale College Prep Charter', '0000-00-00 00:00:00', 'true'),
(450, 'Steinmetz College Preparatory HS, Charles P', '0000-00-00 00:00:00', 'true'),
(451, 'Chicago Intl Charter - Northtown', '0000-00-00 00:00:00', 'true'),
(452, 'Mitchell Elementary School, Ellen', '0000-00-00 00:00:00', 'true'),
(453, 'Turner-Drew Elementary Language Academy', '0000-00-00 00:00:00', 'true'),
(454, 'Shields Elementary School, James', '0000-00-00 00:00:00', 'true'),
(455, 'Dubois Elementary School, William E B', '0000-00-00 00:00:00', 'true'),
(456, 'Marine Leadership Academy at Ames', '0000-00-00 00:00:00', 'true'),
(457, 'Gresham Elementary School, Walter Q', '0000-00-00 00:00:00', 'true'),
(458, 'Langford Community Academy, Anna R', '0000-00-00 00:00:00', 'true'),
(459, 'Earhart Options for Knowledge ES, Amelia', '0000-00-00 00:00:00', 'true'),
(460, 'Gage Park High School', '0000-00-00 00:00:00', 'true'),
(461, 'Chicago High School for the Arts', '0000-00-00 00:00:00', 'true'),
(462, 'Mireles Elementary Academy, Arnold', '0000-00-00 00:00:00', 'true'),
(463, 'Fulton Elementary School, Robert', '0000-00-00 00:00:00', 'true'),
(464, 'Goode STEM Academy, Sarah E.', '0000-00-00 00:00:00', 'true'),
(465, 'Back of the Yards High School', '0000-00-00 00:00:00', 'true'),
(466, 'Prosser Career Academy High School, Charles Allen', '0000-00-00 00:00:00', 'true'),
(467, 'Oglesby Elementary School, Richard J', '0000-00-00 00:00:00', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE IF NOT EXISTS `navigation` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `url` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '29',
  `section` text NOT NULL,
  `win` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `sort`, `name`, `url`, `catid`, `section`, `win`, `loc_id`, `datetime`, `author_name`) VALUES
(37, 1, 'Contact Us', 'contact.php?loc_id=2', 0, 'Footer', 'false', 2, '2016-12-29 16:12:42', ''),
(43, 3, 'Virtual Library High School', 'https://pac.library.cps.edu/?config=11', 0, 'Top', 'true', 1, '2017-01-04 16:22:20', ''),
(48, 3, 'Positions', 'page.php?page_id=34&loc_id=1', 0, 'Footer', 'false', 2, '2017-01-03 21:40:42', ''),
(50, 2, 'Services', 'services.php?loc_id=2', 0, 'Footer', 'false', 2, '2016-12-29 16:12:42', ''),
(51, 4, 'About', 'about.php?loc_id=2', 0, 'Footer', 'false', 2, '2016-12-29 16:12:42', ''),
(54, 2, 'Virtual Library Elementary School', 'https://pac.library.cps.edu/?config=12', 0, 'Top', 'true', 1, '2017-01-04 16:22:20', ''),
(56, 5, 'Contact', 'contact.php?loc_id=1', 0, 'Top', 'false', 1, '2017-01-04 16:22:20', ''),
(57, 3, 'Virtual Library High School', 'https://pac.library.cps.edu/?config=11', 0, 'Top', 'true', 2, '2017-01-04 16:26:48', ''),
(58, 4, 'Databases', 'databases.php?loc_id=2', 0, 'Top', 'false', 2, '2017-01-04 16:26:48', ''),
(59, 2, 'Virtual Library Elementary School', 'https://pac.library.cps.edu/?config=12', 0, 'Top', 'true', 2, '2017-01-04 16:26:48', ''),
(60, 4, 'Databases', 'databases.php?loc_id=1', 0, 'Top', 'false', 1, '2017-01-04 16:22:20', ''),
(61, 1, 'LS2PAC', 'https://pac.library.cps.edu/?config=1#section=home', 0, 'Search', 'true', 1, '2017-01-04 01:25:33', ''),
(62, 2, 'LS2Kids', 'https://pac.library.cps.edu/?config=1#section=home', 0, 'Search', 'true', 1, '2017-01-04 01:25:33', ''),
(63, 3, 'Help', 'http://ls2pachelp.tlcdelivers.com/3_3_0/UserApp/LS2PAC.htm', 0, 'Search', 'true', 1, '2017-01-04 01:25:33', ''),
(64, 1, 'LS2PAC', 'https://pac.library.cps.edu/?config=1820#section=home', 0, 'Search', 'true', 2, '2017-01-04 01:26:02', ''),
(65, 2, 'LS2Kids', 'https://pac.library.cps.edu/?config=1820#section=home', 0, 'Search', 'true', 2, '2017-01-04 01:26:03', ''),
(66, 3, 'Help', 'http://ls2pachelp.tlcdelivers.com/3_3_0/UserApp/LS2PAC.htm', 0, 'Search', 'true', 2, '2017-01-04 01:26:05', ''),
(67, 5, 'Team', 'team.php?loc_id=2', 0, 'Footer', 'off', 2, '2016-12-29 16:12:42', ''),
(68, 5, 'Contact', 'contact.php?loc_id=2', 0, 'Top', 'off', 2, '2017-01-04 16:26:48', ''),
(90, 1, 'Contact Us', 'contact.php?loc_id=1', 47, 'Footer', 'false', 1, '2016-12-29 15:13:32', ''),
(91, 3, 'Positions', 'page.php?page_id=34&loc_id=1', 50, 'Footer', 'false', 1, '2016-12-29 15:13:32', ''),
(92, 2, 'Services', 'services.php?loc_id=1', 47, 'Footer', 'false', 1, '2016-12-29 15:13:32', ''),
(93, 4, 'About', 'about.php?loc_id=1', 50, 'Footer', 'false', 1, '2016-12-29 15:13:32', ''),
(94, 5, 'Team', 'team.php?loc_id=1', 50, 'Footer', 'off', 1, '2016-12-29 15:18:48', ''),
(95, 1, 'School Library Home', 'index.php?loc_id=2', 0, 'Top', 'off', 2, '2017-01-04 16:26:48', ''),
(96, 1, 'SOAR Home', 'index.php?loc_id=1', 0, 'Top', 'off', 1, '2017-01-04 16:22:20', ''),
(97, 3, 'Virtual Library High School', 'https://pac.library.cps.edu/?config=11', 0, 'Top', 'true', 10, '2017-01-06 03:17:46', 'admin'),
(98, 2, 'Virtual Library Elementary School', 'https://pac.library.cps.edu/?config=12', 0, 'Top', 'true', 10, '2017-01-06 03:17:46', 'admin'),
(99, 5, 'Contact', 'contact.php?loc_id=10', 0, 'Top', 'false', 10, '2017-01-06 03:17:46', 'admin'),
(100, 4, 'Databases', 'databases.php?loc_id=10', 0, 'Top', 'false', 10, '2017-01-06 03:17:46', 'admin'),
(101, 1, 'LS2PAC', 'https://pac.library.cps.edu/?config=2160#section=home', 0, 'Search', 'true', 10, '2017-01-04 01:24:19', ''),
(102, 2, 'LS2Kids', 'https://pac.library.cps.edu/?config=2160#section=home', 0, 'Search', 'true', 10, '2017-01-04 01:24:19', ''),
(103, 3, 'Help', 'http://ls2pachelp.tlcdelivers.com/3_3_0/UserApp/LS2PAC.htm', 0, 'Search', 'true', 10, '2017-01-04 01:24:19', ''),
(104, 1, 'Contact Us', 'contact.php?loc_id=10', 47, 'Footer', 'false', 10, '2017-01-03 21:42:35', ''),
(105, 3, 'Positions', 'page.php?page_id=34&loc_id=10', 50, 'Footer', 'false', 10, '2017-01-03 21:42:35', ''),
(106, 2, 'Services', 'services.php?loc_id=10', 47, 'Footer', 'false', 10, '2017-01-03 21:42:35', ''),
(107, 4, 'About', 'about.php?loc_id=10', 50, 'Footer', 'false', 10, '2017-01-03 21:42:35', ''),
(108, 5, 'Team', 'team.php?loc_id=10', 50, 'Footer', 'off', 10, '2017-01-03 21:42:35', ''),
(109, 1, 'School Library Home', 'index.php?loc_id=10', 0, 'Top', 'off', 10, '2017-01-06 03:17:46', 'admin'),
(110, 4, 'My Account', 'https://pac.library.cps.edu/?config=2160#section=myaccount', 0, 'Search', 'true', 10, '2017-01-04 01:26:21', ''),
(111, 4, 'My Account', 'https://pac.library.cps.edu/?config=1820#section=myaccount', 0, 'Search', 'true', 2, '2017-01-04 01:26:06', ''),
(112, 4, 'My Account', 'https://pac.library.cps.edu/?config=1#section=myaccount', 0, 'Search', 'true', 1, '2017-01-04 01:25:37', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `image` text NOT NULL,
  `content` text NOT NULL,
  `active` text NOT NULL,
  `disqus` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `image`, `content`, `active`, `disqus`, `datetime`, `author_name`, `image_align`, `loc_id`) VALUES
(28, 'Join Our Team', '', '<p>Our work is driven&nbsp;by challenges that impact communities across our country and around the world. That is a&nbsp;nice way of saying that we are solving some of the toughest issues facing the public sector.&nbsp;How are we doing it? Through&nbsp;<strong style="box-sizing: border-box;">building the best team in the&nbsp;industry</strong>.</p>\r\n<p>Our team consists of developers, architects, data analysts, requirements gatherers, project managers, support engineers and much more.</p>\r\n<p><a href="page.php?loc_id=1&amp;page_id=34">View Open Positions</a></p>', 'true', 'false', '2016-12-28 18:37:53', '', 'right', 1),
(34, 'Positions', '', '<p>Job posting appear here if available.</p>', 'true', 'false', '2016-12-28 18:37:31', '', 'right', 1),
(42, 'Explore', '', '<p>Online Resources Page</p>', 'true', 'true', '2016-12-28 17:25:07', '', 'right', 1),
(43, 'Explore', '', '<p>Online Resources Page</p>', 'true', 'true', '2016-12-28 17:25:07', '', 'right', 2),
(44, 'Birth to Pre-K', '', '<p>The pre-K experience is critical, as it helps 3 and 4-year-old children develop the academic and life skills that will carry them into adulthood. Pre-K provides children with essential opportunities to learn and practice the social-emotional, problem-solving, and academic skills that they will use throughout their lives.</p>\r\n<p><strong>Our high-quality Early Childhood Programs&hellip;</strong></p>\r\n<ul>\r\n<li>Boost academic skills</li>\r\n<li>Fuel intellectual curiosity</li>\r\n<li>Foster independence</li>\r\n<li>Instill a love of lifelong learning</li>\r\n</ul>\r\n<p>Through common goals and high expectations, Chicago Public Schools is dedicated to building a strong foundation and igniting a lifelong passion for learning for children and their families.</p>\r\n<p><a href="http://www.cps.edu/schools/earlychildhood/Pages/EarlyChildhood.aspx" target="_blank" rel="noopener noreferrer">Read More</a></p>', 'true', 'false', '2016-12-29 17:35:04', '', 'right', 1),
(45, 'Getting to the Next Grade', '', '<p>The Chicago Public Schools elementary and high school promotion policy documents include a variety of measures to ensure that all students are prepared for the grade to which they are promoted.</p>\r\n<p><strong>Elementary School Promotion Policy</strong><br />The School/Parent Guide to the Elementary Promotion Policy is an at-a-glance summary of the Elementary Promotion Policy for the 2015-2016 school year. The guide assists schools and parents in determining the promotion status of students in benchmark grades 3, 6, and 8 and the requirements associated with each promotion status.</p>\r\n<p>CPS urges parents to closely monitor their child''s academic progress to ensure he or she stays on track throughout the school year. Parents can assist their child in meeting the promotion criteria by reviewing homework assignments with him or her, requesting to see quizzes and tests, and maintaining communication with their child''s school and teacher with regards to his or her academic progress.</p>\r\n<p>Students who do not satisfy the promotion criteria above will be required to attend and satisfactorily complete Summer School in order to attain promotion to the next grade.</p>\r\n<p><a href="http://www.cps.edu/Pages/Gettingtothenextgrade.aspx" target="_blank" rel="noopener noreferrer">Read More</a></p>', 'true', 'false', '2016-12-29 17:32:54', '', 'right', 1),
(46, '8 Ways Parents Can Help With Homework', '', '<p>Although it may be hard to believe, you can actually help your child enjoy doing homework. When you provide the necessary support and encouragement, most children will rise to the occasion and do their best on their assignments.</p>\r\n<p>Here are 8 ways that you can help your child with homework:</p>\r\n<ol>\r\n<li><strong>Offer encouragement.</strong> Give your child praise for efforts and for completing assignments.</li>\r\n<li><strong>Be available.</strong> Encourage your child to do the work independently, but be available for assistance.</li>\r\n<li><strong>Maintain a schedule.</strong> Establish a set time to do homework each day. You may want to use a calendar to keep track of assignments and due dates.</li>\r\n<li><strong>Designate space.</strong> Provide a space for homework, stocked with necessary supplies, such as pencils, pens, paper, dictionaries, a computer, and other reference materials.</li>\r\n<li><strong>Provide discipline.</strong> Help your child focus on homework by removing distractions, such as television, radio, telephone, and interruptions from siblings and friends.</li>\r\n<li><strong>Be a role model.</strong> Consider doing some of your work, such as paying bills or writing letters, during your child''s homework time.</li>\r\n<li><strong>Be supportive.</strong> Talk to your child about difficulties with homework. Be willing to talk to your child''s teacher to resolve problems in a positive manner.</li>\r\n<li><strong>Stay involved.</strong> Familiarize yourself with the CPS Homework Policy. Make sure that you and your child understand the teacher''s expectations. At the beginning of the year, you may want to ask your child''s teacher:</li>\r\n</ol>\r\n<ul>\r\n<li>What kinds of assignments will you give?</li>\r\n<li>How often do you give homework?</li>\r\n<li>How much time are the students expected to spend on them?</li>\r\n<li>What type of involvement do you expect from parents?</li>\r\n</ul>\r\n<p><a href="http://www.cps.edu/Pages/8waysparentscanhelpwithhomework.aspx" target="_blank" rel="noopener noreferrer">Read More</a></p>', 'true', 'false', '2016-12-29 17:40:17', '', 'right', 1),
(47, 'Education Policy and Procedures', '', '<p>The Department of Education Policy and Procedures promotes equity, fair standards, and the academic success of all students. The department is responsible for developing and implementing research-based education policies and procedures.</p>\r\n<p><strong>Resources</strong></p>\r\n<ul>\r\n<li>Adult Transgender Guidelines</li>\r\n<li>Board Policy Handbook</li>\r\n<li>Elementary/High School Promotion Policy</li>\r\n<li>Enrollment and Procedures</li>\r\n<li>Getting to the Next Grade</li>\r\n<li>High School Graduation Requirements</li>\r\n<li>Home Schooling</li>\r\n<li>Operation Recognition</li>\r\n<li>Student Code of Conduct</li>\r\n<li>Transgender and Gender Nonconforming Students</li>\r\n</ul>\r\n<p>To learn more about the Department of Education Policy and Procedures, contact Executive Director, Tony Howard, 773-553-2131.</p>\r\n<p><a href="http://www.cps.edu/Pages/EducationPolicyProcedures.aspx" target="_blank" rel="noopener noreferrer">Read More</a></p>', 'true', 'true', '2016-12-29 17:43:45', '', 'right', 1),
(48, 'Full Day Kindergarten', '', '<p><strong>Why is full day kindergarten so important?</strong><br />Research proves that full day kindergarten gives students a strong foundation they build on for the rest of their lives.</p>\r\n<ul>\r\n<li>Have improved social emotional and physical health</li>\r\n<li>Are more prepared for first grade</li>\r\n<li>Spend more time developing reading, writing, speaking, listening and math skills</li>\r\n<li>Exhibit higher levels of independence and reflectiveness</li>\r\n<li>Demonstrate more advanced language proficiencies</li>\r\n</ul>\r\n<p><a href="http://www.cps.edu/Schools/EarlyChildhood/Pages/GradesK-2.aspx" target="_blank" rel="noopener noreferrer">Read More</a></p>', 'true', 'true', '2016-12-29 17:51:32', '', 'right', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL,
  `icon` text NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `link` int(11) NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `image`, `title`, `content`, `link`, `active`, `datetime`, `author_name`, `loc_id`) VALUES
(2, 'car', '', 'PUBLIC SAFETY', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-12-28 16:52:02', '', 1),
(3, 'id-badge', '', 'SITUATIONAL AWARENESS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 20:32:50', '', 1),
(4, 'bicycle', '', 'INNOVATION CONSULTING', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-12-28 16:51:24', '', 1),
(5, 'calendar', '', 'INSIDER THREAT DETECTION', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 36, 'true', '2016-12-21 17:22:33', '', 1),
(6, 'address-card', '', 'PUBLIC SAFETY APPLICATIONS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-11-14 22:04:13', '', 2),
(7, 'id-badge', '', 'SITUATIONAL AWARENESS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 20:32:50', '', 2),
(8, 'bicycle', '', 'INNOVATION CONSULTING', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-15 21:43:58', '', 2),
(9, '', 'webide.png', 'INSIDER THREAT DETECTION', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 36, 'true', '2016-11-29 14:49:35', '', 2),
(10, 'car', '', 'PUBLIC SAFETY', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 28, 'true', '2016-12-28 21:52:02', '', 10),
(11, 'id-badge', '', 'SITUATIONAL AWARENESS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-11-16 01:32:50', '', 10),
(12, 'bicycle', '', 'INNOVATION CONSULTING', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 33, 'true', '2016-12-28 21:51:24', '', 10),
(13, 'calendar', '', 'INSIDER THREAT DETECTION', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 36, 'true', '2016-12-21 22:22:33', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `services_icons`
--

CREATE TABLE IF NOT EXISTS `services_icons` (
  `id` int(11) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

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
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `headercode` text NOT NULL,
  `config` text NOT NULL,
  `logo` text NOT NULL,
  `ls2pac` text NOT NULL,
  `ls2kids` text NOT NULL,
  `searchdefault` int(11) NOT NULL,
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
  `slider_use_defaults` text NOT NULL,
  `databases_use_defaults` text NOT NULL,
  `navigation_use_defaults_1` text NOT NULL,
  `navigation_use_defaults_2` text NOT NULL,
  `navigation_use_defaults_3` text NOT NULL,
  `services_use_defaults` text NOT NULL,
  `team_use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=468 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `headercode`, `config`, `logo`, `ls2pac`, `ls2kids`, `searchdefault`, `author`, `googleanalytics`, `tinymce`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `customersheading`, `servicescontent`, `customerscontent`, `teamcontent`, `disqus`, `slider_use_defaults`, `databases_use_defaults`, `navigation_use_defaults_1`, `navigation_use_defaults_2`, `navigation_use_defaults_3`, `services_use_defaults`, `team_use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(1, 'Chicago Public School Libraries', '', '', '', '1', 'cpslogo@2x.png', 'true', 'true', 1, '', '', 1, 'Pages', 'Services', 'Slides ', 'Meet the Librarians', 'Resources', '', 'Download the login information with your CPS login. (en EspaÃ±ol). Charter schools: Contact library@cps.edu for login information.', '', '', '', '', '', '', '', '', '', '2017-01-09 14:28:53', 'admin', 1),
(2, 'Curie Metro High School', '', 'Marie Sklodowska Curie Metropolitan High School is a public 4â€“year magnet high school located in the Archer Heights neighborhood on the southwest side of Chicago, Illinois, United States. Curie is operated by Chicago Public Schools district.', '', '1820', 'header_logo.png', 'true', 'false', 1, '', '', 1, '', 'Curie HS - Services', '', 'Curie - Meet the Librarians', 'Resources', '', '', '', '', 'false', 'false', 'false', 'false', 'false', 'false', 'true', '2017-01-06 21:38:34', 'admin', 2),
(3, 'Northside Prep High School', '', '', '', '1740', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 3),
(4, 'Hyde Park High School', '', '', '', '1390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 4),
(5, 'Crane Tech Prep', '', '', '', '1270', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 5),
(6, 'DuSable Campus', '', '', '', '1280', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 6),
(7, 'Amundsen High School', '', '', '', '1210', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 7),
(8, 'Professional Library', '', '', '', '390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 8),
(9, 'Amundsen High School', '', '', '', '1210', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 7),
(10, 'Barry Elementary School', '', 'School in Chicago, Illinois Â· Belmont Gardens', '', '2160', '1446552243.png', 'true', 'true', 2, '', '', 1, '', '', 'Slides', 'Meet the Librarians', 'Barry Resources', '', '', 'Great Things are ALWAYS happening at Barry', '', 'false', 'false', 'false', '', '', '', '', '2017-01-06 03:18:25', 'admin', 10),
(11, 'Belding Elementary School', '', '', '', '2260', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 11),
(12, 'Budlong Elementary School', '', '', '', '2440', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 12),
(13, 'Caldwell Academy', '', '', '', '2580', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 13),
(14, 'Clissold Elementary School', '', '', '', '2820', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 14),
(15, 'Franklin Fine Arts', '', '', '', '3420', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 15),
(16, 'Fulton Elementary School', '', '', '', '3450', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 16),
(17, 'Kohn Elementary School', '', '', '', '4360', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 17),
(18, 'Locke Elementary School', '', '', '', '4510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 18),
(19, 'May Community', '', '', '', '4670', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 19),
(20, 'Jackson Language', '', '', '', '4690', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 20),
(21, 'Mt. Vernon Elementary School', '', '', '', '4980', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 21),
(22, 'Mozart Elementary School', '', '', '', '5000', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 22),
(23, 'The Nettelhorst School', '', '', '', '5070', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 23),
(24, 'Sandoval Elementary School , Socorro', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 24),
(25, 'Hurley Elementary School , Edward N', '', '', '', '4120', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 25),
(26, 'Norwood Park Elementary School', '', '', '', '5120', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 26),
(27, 'Onahan Elementary School', '', '', '', '5190', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 27),
(28, 'Palmer Elementary School', '', '', '', '5260', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 28),
(29, 'Pirie Elementary School', '', '', '', '5440', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 29),
(30, 'Reilly Elementary School', '', '', '', '5590ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 30),
(31, 'Frazier Int. Magnet', '', '', '', '5850', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 31),
(32, 'Thorp Academy', '', '', '', '6190', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 32),
(33, 'Twain Elementary School', '', '', '', '6240', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 33),
(34, 'Whistler Elementary School, John', '', '', '', '6420', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 34),
(35, 'Whitney Elementary School', '', '', '', '6440ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 35),
(36, 'Douglass Academy', '', '', '', '6630', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 36),
(37, 'Price Elementary School', '', '', '', '6810', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 37),
(38, 'Johnson Elementary School', '', '', '', '6940', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 38),
(39, 'Davis Academy', '', '', '', '7180', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 39),
(40, 'Higgins Community', '', '', '', '7210', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 40),
(41, 'Grant Campus', '', '', '', '7310', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 41),
(42, 'Marshall Middle School', '', '', '', '7520', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 42),
(43, 'LaSalle II Magnet', '', '', '', '8040', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 43),
(44, 'DePriest Elementary School', '', '', '', '8050', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 44),
(45, 'Harlan High School', '', '', '', '1350', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 45),
(46, 'Tilden High School', '', '', '', '1590', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 46),
(47, 'Vaughn Occ High School', '', '', '', '1920', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 47),
(48, 'Uplift Community High School', '', '', '', '2210', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 48),
(49, 'Haley Academy Elementary School', '', '', '', '2360', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 49),
(50, 'Cameron Elementary School', '', '', '', '2610', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 50),
(51, 'Copernicus Elementary School', '', '', '', '2900', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 51),
(52, 'Gale Academy', '', '', '', '3480', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 52),
(53, 'Greene Elementary School', '', '', '', '3650', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 53),
(54, 'Gunsaulus Academy', '', '', '', '3690', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 54),
(55, 'Kershaw Elementary School', '', '', '', '4270', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 55),
(56, 'Lloyd Elementary School', '', '', '', '4500', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 56),
(57, 'Mayer Magnet', '', '', '', '4680', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 57),
(58, 'Keller Magnet Elementary School', '', '', '', '4960', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 58),
(59, 'Owen Academy', '', '', '', '5240', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 59),
(60, 'Pasteur Elementary School', '', '', '', '5310', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 60),
(61, 'Prussing Elementary School', '', '', '', '5510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 61),
(62, 'Pulaski International School of Chicago', '', '', '', '5520', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 62),
(63, 'Armstrong L Elementary School', '', '', '', '5700', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 63),
(64, 'Spencer Academy', '', '', '', '6000', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 64),
(65, 'Stockton Elementary School', '', '', '', '6060', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 65),
(66, 'Trumbull Elementary School', '', '', '', '6230', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 66),
(67, 'Banneker Elementary School', '', '', '', '6880', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 67),
(68, 'Dumas Elementary School', '', '', '', '6890', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 68),
(69, 'Woods Academy Elementary School', '', '', '', '7080', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 69),
(70, 'Lenart Gifted', '', '', '', '7240', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 70),
(71, 'Payton Coll Prep High School', '', '', '', '1090', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 71),
(72, 'Little Village High School Campus', '', '', '', '1130', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 72),
(73, 'Hancock Coll Prep', '', '', '', '1200', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 73),
(74, 'Fenger High School', '', '', '', '1310', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 74),
(75, 'Robeson High School', '', '', '', '1320', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 75),
(76, 'Hirsch Metro High School', '', '', '', '1380', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 76),
(77, 'Kennedy High School', '', '', '', '1420', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 77),
(78, 'Lake View High School', '', '', '', '1430', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 78),
(79, 'Manley High School', '', '', '', '1460', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 79),
(80, 'Brooks Coll Prep High School', '', '', '', '1500', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 80),
(81, 'Schurz High School', '', '', '', '1530', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 81),
(82, 'Senn Campus', '', '', '', '1540', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 82),
(83, 'Taft High School', '', '', '', '1580', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 83),
(84, 'Lincoln Park High School', '', '', '', '1620', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 84),
(85, 'Wells Academy High School', '', '', '', '1640', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 85),
(86, 'Chicago Military High School', '', '', '', '1800', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 86),
(87, 'Orr Academy High School', '', '', '', '1830', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 87),
(88, 'Carver Military High School', '', '', '', '1850', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 88),
(89, 'Corliss High School', '', '', '', '1860', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 89),
(90, 'Armstrong G Elementary School', '', '', '', '2080', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 90),
(91, 'Beaubien Elementary School', '', '', '', '2240', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 91),
(92, 'Bradwell Elementary School', '', '', '', '2340', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 92),
(93, 'Bridge Elementary School', '', '', '', '2380', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 93),
(94, 'Cassell Elementary School', '', '', '', '2720', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 94),
(95, 'Greeley Elementary School', '', '', '', '2730', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 95),
(96, 'Clay Elementary School', '', '', '', '2790', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 96),
(97, 'Clinton Elementary School', '', '', '', '2810', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 97),
(98, 'Coles Academy', '', '', '', '2830', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 98),
(99, 'Columbus Elementary School', '', '', '', '2850', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 99),
(100, 'Jordan Community', '', '', '', '2870', '', 'true', 'true', 1, '', '', 1, '', '', 'Slides', 'Meet the Librarians', '', '', '', '', '', 'false', 'true', '', '', '', '', '', '2017-01-05 21:39:34', 'admin', 100),
(101, 'Eberhart Elementary School', '', '', '', '3140', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 101),
(102, 'Edwards Elementary School', '', '', '', '3200', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 102),
(103, 'Emmet Elementary School', '', '', '', '3230', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 103),
(104, 'Ericson Academy Elementary School', '', '', '', '3240', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 104),
(105, 'Kanoon Magnet Elementary School', '', '', '', '3370', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 105),
(106, 'Gary Elementary School', '', '', '', '3520', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 106),
(107, 'Ninos Heroes AC', '', '', '', '3720', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 107),
(108, 'Hitch Elementary School', '', '', '', '4010', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 108),
(109, 'Holmes Elementary School', '', '', '', '4030', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 109),
(110, 'Lewis Elementary School', '', '', '', '4450', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 110),
(111, 'Lowell Elementary School, James R', '', '', '', '4540', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 111),
(112, 'Till Academy', '', '', '', '4740', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 112),
(113, 'Moos Elementary School', '', '', '', '4870', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 113),
(114, 'Morrill Elementary School', '', '', '', '4880', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 114),
(115, 'Beard Elementary School', '', '', '', '4950', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 115),
(116, 'Murray Lang Academy', '', '', '', '5030', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 116),
(117, 'West Park Academy', '', '', '', '5140', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 117),
(118, 'Parker Academy', '', '', '', '5270', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 118),
(119, 'Peterson Elementary School', '', '', '', '5410', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 119),
(120, 'Pickard Elementary School', '', '', '', '5430', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 120),
(121, 'Reinberg Elementary School', '', '', '', '5600', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 121),
(122, 'Sawyer Elementary School', '', '', '', '5710', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 122),
(123, 'Scammon Elementary School', '', '', '', '5730', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 123),
(124, 'Seward Academy', '', '', '', '5820', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 124),
(125, 'Sexton Elementary School', '', '', '', '5830', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 125),
(126, 'Mireles Academy Elementary School', '', '', '', '5880', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 126),
(127, 'Shoop Academy', '', '', '', '5930', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 127),
(128, 'Smyth Elementary School', '', '', '', '5970ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 128),
(129, 'Swift Elementary School', '', '', '', '6130', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 129),
(130, 'Talcott Elementary School', '', '', '', '6140', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 130),
(131, 'Coleman Academy', '', '', '', '6170', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 131),
(132, 'Tilton Elementary School', '', '', '', '6210', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 132),
(133, 'Volta Elementary School', '', '', '', '6270', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 133),
(134, 'Albany Park Campus', '', '', '', '6290', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 134),
(135, 'Dvorak Academy', '', '', '', '6760', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 135),
(136, 'Buckingham Center', '', '', '', '6980', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 136),
(137, 'Ashburn Elementary School', '', '', '', '7100', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 137),
(138, 'Westcott Elementary School', '', '', '', '7260', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 138),
(139, 'Brighton Park Elementary School', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 139),
(140, 'Roque de Duprey Elementary School', '', '', '', '7510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 140),
(141, 'Orozco Elementary School', '', '', '', '7610', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 141),
(142, 'Ace Tech Campus', '', '', '', '7950', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 142),
(143, 'Clemente Academy High School', '', '', '', '1840', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 143),
(144, 'Skinner West ES', '', '', '', '5940', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 144),
(145, 'Hernandez MS', '', '', '', '8021', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 145),
(146, 'Dulles School of Excellence', '', '', '', '6860', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 146),
(147, 'Hughes L ES', '', '', '', '8060', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 147),
(148, 'Prieto ES', '', '', '', '8023', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 148),
(149, 'South Shore Academy', '', '', '', '2015', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 149),
(150, 'Westinghouse HS', '', '', '', '1160', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 150),
(151, 'Cooper Elementary Dual Language Academy, Peter', '', '', '', '2890', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 151),
(152, 'Clark Magnet High School', '', '', '', '6620', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 152),
(153, 'Bethune Elementary School', '', '', '', '8020', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 153),
(154, 'Blaine Elementary School', '', '', '', '2300', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 154),
(155, 'Boone Elementary School', '', '', '', '2320', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 155),
(156, 'Byrne Elementary School', '', '', '', '2570', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 156),
(157, 'Carver Primary School', '', '', '', '2690', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 157),
(158, 'Chappell Elementary School', '', '', '', '2750', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 158),
(159, 'Chicago Academy High School', '', '', '', '7770', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 159),
(160, 'Christopher Elementary School', '', '', '', '2780', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 160),
(161, 'Daley Elementary Academy', '', '', '', '6560', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 161),
(162, 'Dunbar Career Academy High School', '', '', '', '1030', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 162),
(163, 'Dunne Elementary School', '', '', '', '6050ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 163),
(164, 'Dvorak Elementary Specialty Academy', '', '', '', '6760', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 164),
(165, 'Dyett High School', '', '', '', '1600', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 165),
(166, 'Edward Coles Elementary Language Academy', '', '', '', '2830', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 166),
(167, 'Farnsworth Elementary School', '', '', '', '3280', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 167),
(168, 'Fort Dearborn Elementary School', '', '', '', '3400', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 168),
(169, 'Garfield Park Preparatory Academy ES', '', '', '', '8064', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 169),
(170, 'Garvy Elementary School, John W.', '', '', '', '3510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 170),
(171, 'Gregory Elementary School', '', '', '', '3660', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 171),
(172, 'Hammond Elementary School', '', '', '', '3750', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 172),
(173, 'Hancock College Preparatory High School', '', '', '', '1200', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 173),
(174, 'Julian High School', '', '', '', '1870', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 174),
(175, 'Kozminski Elementary Community Academy', '', '', '', '4390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 175),
(176, 'Lake View High School', '', '', '', '1430', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 78),
(177, 'Marshall Metropolitan High School', '', '', '', '1470', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 177),
(178, 'Nash Elementary School', '', '', '', '5050', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 178),
(179, 'Ninos Heroes Elementary Academic Center', '', '', '', '3720', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 179),
(180, 'Nixon Elementary School', '', '', '', '5100ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 180),
(181, 'Ogden International High School', '', '', '', '8083', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 181),
(182, 'Peirce International Studies ES', '', '', '', '5360', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 182),
(183, 'Perez Elementary School', '', '', '', '2930', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 183),
(184, 'Richards Career Academy High School', '', '', '', '1110', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 184),
(185, 'Sabin Elementary Dual Language Magnet School', '', '', '', '7790', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 185),
(186, 'Skinner North Classical Elementary', '', '', '', '8024', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 186),
(187, 'Sullivan High School', '', '', '', '1570', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 187),
(188, 'Talcott Elementary School', '', '', '', '6140', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 130),
(189, 'Walsh Elementary School', '', '', '', '6320', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 189),
(190, 'Ward Elementary School, James', '', '', '', '6330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 190),
(191, 'Beidler, Elementary School, Jacob', '', '', '', '2250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 191),
(192, 'Bennett Elementary School, Frank I', '', '', '', '2280', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 192),
(193, 'Black Magnet Elementary School, Robert A ', '', '', '', '7860ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 193),
(194, 'Black Magnet Elementary School, Robert A - Branch', '', '', '', '7861', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 194),
(195, 'Brentano Math & Science Academy ES, Lorenz', '', '', '', '2370', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 195),
(196, 'Burr Elementary School, Jonathan ', '', '', '', '2530', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 196),
(197, 'Chase Elementary School, Salmon P', '', '', '', '2760', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 197),
(198, 'Chavez Multicultural Academic Center ES, Cesar E - Lower Library', '', '', '', '5641', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 198),
(199, 'Chavez Multicultural Academic Center ES, Cesar E', '', '', '', '5640', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 199),
(200, 'Coonley Elementary School, John C.', '', '', '', '2880', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 200),
(201, 'Disney Magnet Elementary School, Walt', '', '', '', '8000', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 201),
(202, 'Durkin Park Elementary School', '', '', '', '7870', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 202),
(203, 'Esmond Elementary School', '', '', '', '3250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 203),
(204, 'Falconer Elementary School, Laughlin', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 204),
(205, 'Gage Park High School', '', '', '', '1340', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 205),
(206, 'Gary Elementary School, Joseph E - New', '', '', '', '3520ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 206),
(207, 'Gary Elementary School. Joseph E - Main', '', '', '', '3520ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 207),
(208, 'Hale Elementary School, Nathan', '', '', '', '3710', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 208),
(209, 'Hamilton Elementary School, Alexander', '', '', '', '3730', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 209),
(210, 'Hanson Park Elementary School - Branch', '', '', '', '4770ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 210),
(211, 'Hanson Park Elementary School - Main Library', '', '', '', '4770ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 211),
(212, 'Harte Elementary School, Bret', '', '', '', '3780', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 212),
(213, 'Hedges Elementary School, James ', '', '', '', '3900', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 213),
(214, 'Inter-American Elementary Magnet School', '', '', '', '4890', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 214),
(215, 'Juarez Community Academy High School, Benito', '', '', '', '1890', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 215),
(216, 'Kenwood Academy High School', '', '', '', '1710', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 216),
(217, 'LaSalle Elementary Language Academy', '', '', '', '4420', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 217),
(218, 'Lindblom Math & Science Academy HS, Robert', '', '', '', '7110', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 218),
(219, 'Logandale Middle School', '', '', '', '7560', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 219),
(220, 'Lovett Elementary School, Joseph', '', '', '', '4530', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 220),
(221, 'McAuliffe Elementary School, Sharon Christa', '', '', '', '3770', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 221),
(222, 'McPherson ES', '', '', '', '4800', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 222),
(223, 'Metcalfe Elementary Community Academy, Ralph H', '', '', '', '3190', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 223),
(224, 'Morgan Park High School', '', '', '', '1490', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 224),
(225, 'National Teachers Elementary Academy', '', '', '', '6480', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 225),
(226, 'Newberry Math & Science Academy ES, Walter L.', '', '', '', '5080', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 226),
(227, 'North Lawndale HS', '', '', '', '1106', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 227),
(228, 'Ogden Elementary School, William B.', '', '', '', '5150', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 228),
(229, 'Powell Academy Elementary School', '', '', '', '7010', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 229),
(230, 'Powell Academy ES', '', '', '', '7010', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 230),
(231, 'Pritzker School, A.N.', '', '', '', '6460', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 231),
(232, 'Raby High School, Al', '', '', '', '7690', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 232),
(233, 'Rudolph Elementary Learning Center, Wilma', '', '', '', '7350', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 233),
(234, 'Ruiz Elementary School, Irma C', '', '', '', '5390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 234),
(235, 'Shoop Math-Science Technical Academy ES, John D ', '', '', '', '5930', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 235),
(236, 'South Loop Elementary School', '', '', '', '3960', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 236),
(237, 'Suder Montessori Magnet ES', '', '', '', '6340', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 237),
(238, 'von Steuben Metropolitan Science HS, Friedrich W', '', '', '', '1610', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 238),
(239, 'Washington High School, George', '', '', '', '1630', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 239),
(240, 'Azuela Elementary School, Mariano', '', '', '', '8660', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 240),
(241, 'Bradwell Communications Arts & Science ES, Myra', '', '', '', '2340', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 241),
(242, 'Brennemann Elementary School, Joseph', '', '', '', '6600', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 242),
(243, 'Calmeca Academy of Fine Arts and Dual Language', '', '', '', '7880', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 243),
(244, 'Camras Elementary School, Marvin', '', '', '', '8600', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 244),
(245, 'Clinton Elementary School, DeWitt', '', '', '', '2810', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 245),
(246, 'Graham Training Center High School, Ray', '', '', '', '1950', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 246),
(247, 'Lorca Elementary School, Federico Garcia', '', '', '', '8330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 247),
(248, 'Wadsworth Elementary School, James', '', '', '', '6300', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 248),
(249, 'Zaragoza', '', '', '', '8550', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 249);
INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `headercode`, `config`, `logo`, `ls2pac`, `ls2kids`, `searchdefault`, `author`, `googleanalytics`, `tinymce`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `customersheading`, `servicescontent`, `customerscontent`, `teamcontent`, `disqus`, `slider_use_defaults`, `databases_use_defaults`, `navigation_use_defaults_1`, `navigation_use_defaults_2`, `navigation_use_defaults_3`, `services_use_defaults`, `team_use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(250, 'Parkman Elementary School, Francis', '', '', '', '5280', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 250),
(251, 'Hammond Elementary School, Charles G', '', '', '', '3750', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 251),
(252, 'Hale Elementary School, Nathan', '', '', '', '3710', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 208),
(253, 'Washington Elementary School, George', '', '', '', '6360', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 253),
(254, 'Solorio Academy High School, Eric', '', '', '', '8550', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 254),
(255, 'Lorca Elementary School, Federico Garcia', '', '', '', '8330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 247),
(256, 'West Ridge Elementary School', '', '', '', '8440', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 256),
(257, 'Fernwood Elementary School', '', '', '', '3330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 257),
(258, 'Woodson South Elementary School, Carter G', '', '', '', '7820', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 258),
(259, 'Jefferson Alternative High School, Nancy B', '', '', '', '2120', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 259),
(260, 'Galileo Math & Science Scholastic Academy', '', '', '', '4160', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 260),
(261, 'Phillips Academy High School, Wendell', '', '', '', '1510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 261),
(262, 'Gillespie Elementary School, Frank L', '', '', '', '3530', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 262),
(263, 'Lara Elementary Academy, Agustin', '', '', '', '3980', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 263),
(264, 'Hibbard Elementary School, William G', '', '', '', '4000', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 264),
(265, 'Funston Elementary School, Frederick', '', '', '', '3460', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 265),
(266, 'Garvey Elementary School, Marcus Moziah', '', '', '', '5420', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 266),
(267, 'Bowen High School', '', '', '', '7550', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 267),
(268, 'Solomon Elementary School, Hannah G', '', '', '', '5980', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 268),
(269, 'M. M. Garvey ES', '', '', '', '5420', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 269),
(270, 'Sheridan (Mark) Math & Science Academy', '', '', '', '4920', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 270),
(271, 'Kinzie Elementary School, John H', '', '', '', '4330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 271),
(272, 'Saucedo Elementary Scholastic Academy, Maria', '', '', '', '4250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 272),
(273, 'Belmont-Cragin', '', '', '', '3390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 273),
(274, 'Simeon Career Academy High School, Neal F', '', '', '', '1150', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 274),
(275, 'Mather High School, Stephen T', '', '', '', '1480', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 275),
(276, 'Roosevelt High School, Theodore', '', '', '', '1520', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 276),
(277, 'Little Village Elementary School', '', '', '', '2590', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 277),
(278, 'Lavizzo Elementary School, Mildred I', '', '', '', '6260', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 278),
(279, 'Sandoval ES', '', '', '', '6430', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 279),
(280, 'Chicago Academy Elementary School', '', '', '', '6670', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 280),
(281, 'North River Elementary School', '', '', '', '7890', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 281),
(282, 'Agassiz Elementary School, Louis A', '', '', '', '2030', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 282),
(283, 'Carter Elementary School, William W', '', '', '', '2670', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 283),
(284, 'Cook Elementary School, John W', '', '', '', '2860', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 284),
(285, 'Dirksen Elementary School, Everett McKinley', '', '', '', '2950', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 285),
(286, 'Everett Elementary School, Edward', '', '', '', '3260', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 286),
(287, 'Goethe Elementary School, Johann W von', '', '', '', '3560', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 287),
(288, 'Hawthorne Elementary Scholastic Academy', '', '', '', '3830', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 288),
(289, 'Kelvyn Park High School', '', '', '', '1410', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 289),
(290, 'Mount Greenwood Elementary School', '', '', '', '4940', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 290),
(291, 'Wentworth Elementary School, Daniel S', '', '', '', '6390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 291),
(292, 'Dirksen Elementary School', '', '', '', '2950', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 292),
(293, 'Chicago High School for Agricultural Sciences', '', '', '', '1790', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 293),
(294, 'Ariel Elementary Community Academy', '', '', '', '3640', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 294),
(295, 'Bogan High School, William J', '', '', '', '1230', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 295),
(296, 'Brighton Park Elementary School', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 139),
(297, 'Castellanos Elementary School, Rosario', '', '', '', '2510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 297),
(298, 'Claremont Academy Elementary School', '', '', '', '7830', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 298),
(299, 'Cleveland Elementary School, Grover', '', '', '', '2800', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 299),
(300, 'Corkery Elementary School, Daniel J', '', '', '', '2910', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 300),
(301, 'Dever Elementary School', '', '', '', '3020', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 301),
(302, 'Dodge Elementary Renaissance Academy, Mary Mapes', '', '', '', '3050', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 302),
(303, 'Ebinger Elementary School, Christian', '', '', '', '3150', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 303),
(304, 'Field Elementary School, Eugene', '', '', '', '3350', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 304),
(305, 'Graham Elementary School, Alexander', '', '', '', '3600ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 305),
(306, 'Hamline Elementary School, John H', '', '', '', '3740ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 306),
(307, 'Henderson Elementary School, Charles R', '', '', '', '3920', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 307),
(308, 'King Jr Academy of Social Justice, Dr. Martin L.', '', '', '', '7250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 308),
(309, 'Hope College Preparatory High School', '', '', '', '1940', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 309),
(310, 'Jamieson Elementary School, Minnie Mars', '', '', '', '4180', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 310),
(311, 'Lee Elementary School, Richard Henry', '', '', '', '7170', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 311),
(312, 'Libby Elementary School, Arthur A ', '', '', '', '4470', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 312),
(313, 'Linne Elementary School, Carl von', '', '', '', '4490', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 313),
(314, 'Manierre Elementary School, George', '', '', '', '4580', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 314),
(315, 'Marquette Elementary School', '', '', '', '4620', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 315),
(316, 'Marsh Elementary School, John L', '', '', '', '4630', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 316),
(317, 'McDade Elementary Classical School, James E', '', '', '', '4750', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 317),
(318, 'Morton School of Excellence', '', '', '', '6800', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 318),
(319, 'Namaste Charter Elementary School', '', '', '', '7920', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 319),
(320, 'New Sullivan Elementary School, William K', '', '', '', '6100', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 320),
(321, 'Nightingale Elementary School, Florence', '', '', '', '5090', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 321),
(322, 'Pershing Elementary Humanities Magnet, John J', '', '', '', '5400', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 322),
(323, 'Ray Elementary School ', '', '', '', '5560', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 323),
(324, 'Sandoval Elementary School, Socorro', '', '', '', '6430', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 324),
(325, 'Sayre Language Academy, Harriet', '', '', '', '5720', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 325),
(326, 'Goudy Elementary School, William C', '', '', '', '3590', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 326),
(327, 'Haugan Elementary School, Helge A', '', '', '', '3810', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 327),
(328, 'Smyser Elementary School, Washington D', '', '', '', '5960', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 328),
(329, 'South Shore International College Prep High School', '', '', '', '8676', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 329),
(330, 'Spry & Community Links, John', '', '', '', '6010', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 330),
(331, 'Stowe Elementary School, Harriet Beecher', '', '', '', '6080ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 331),
(332, 'Tarkington School of Excellence ES', '', '', '', '7160', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 332),
(333, 'Vanderpoel Elementary Magnet School, John H', '', '', '', '6250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 333),
(334, 'Von Humboldt Elementary School, Alexander', '', '', '', '6280', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 334),
(335, 'Waters Elementary School, Thomas J', '', '', '', '6370', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 335),
(336, 'White Elementary Career Academy, Edward', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 336),
(337, 'Whittier Elementary School, John Greenleaf', '', '', '', '6450', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 337),
(338, 'Woodlawn Community Elementary School', '', '', '', '3860', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 338),
(339, 'Zapata Elementary Academy, Emiliano', '', '', '', '3820', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 339),
(340, 'Fernwood Elementary School', '', '', '', '3330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 257),
(341, 'McKay Elementary School, Francis M', '', '', '', '4760', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 341),
(342, 'Hayt Elementary School, Stephen K', '', '', '', '3850', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 342),
(343, 'Alcott High School for the Humanities', '', '', '', '8035', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 343),
(344, 'Agassiz Elementary School', '', '', '', '2030', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 344),
(345, 'Canty Elementary School, Arthur E', '', '', '', '2620', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 345),
(346, 'Cardenas Elementary School, Lazaro', '', '', '', '4320', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 346),
(347, 'Chicago Vocational Career Academy High School', '', '', '', '1010', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 347),
(348, 'Columbia Explorers Elementary Academy', '', '', '', '5860', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 348),
(349, 'Edgebrook Elementary School', '', '', '', '3170', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 349),
(350, 'Farragut Career Academy High School, David G', '', '', '', '1300', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 350),
(351, 'Schubert Elementary School, Franz Peter ', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 351),
(352, 'Schubert Elementary School, Franz Peter ', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 351),
(353, 'Herzl Elementary School, Theodore', '', '', '', '3970', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 353),
(354, 'Murphy Elementary School, John B', '', '', '', '5020', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 354),
(355, 'Lafayette Elementary School, Jean D', '', '', '', '4400', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 355),
(356, 'Melody Elementary School, Genevieve', '', '', '', '7190', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 356),
(357, 'New Field Elementary School', '', '', '', '7060', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 357),
(358, 'Cuffe Math-Science Technology Academy ES, Paul', '', '', '', '4090', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 358),
(359, 'Portage Park Elementary School', '', '', '', '5490', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 359),
(360, 'Prescott Elementary School, William H', '', '', '', '5500', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 360),
(361, 'Ryerson Elementary School, Martin A', '', '', '', '5680', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 361),
(362, 'Kelly High School, Thomas', '', '', '', '1400', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 362),
(363, 'Young Magnet High School, Whitney M', '', '', '', '1810', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 363),
(364, 'STEM Magnet Academy', '', '', '', '8678', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 364),
(365, 'Stevenson Elementary School, Adlai E', '', '', '', '6030', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 365),
(366, 'Talman Elementary School', '', '', '', '6680', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 366),
(367, 'Drummond Elementary School, Thomas', '', '', '', '3120', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 367),
(368, 'Brown Elementary Community Academy, Ronald', '', '', '', '5040', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 368),
(369, 'Bright Elementary School, Orville T', '', '', '', '2390', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 369),
(370, 'Ross Elementary School, Betsy', '', '', '', '5650', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 370),
(371, 'White Elementary Career Academy, Edward', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 336),
(372, 'Yates Elementary School, Richard', '', '', '', '6510', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 372),
(373, 'Brunson Math & Science Specialty ES, Brunson', '', '', '', '2550', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 373),
(374, 'Burley Elementary School, Augustus H', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 374),
(375, 'Evergreen Academy Middle School', '', '', '', '7490', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 375),
(376, 'Foreman High School , Edwin G', '', '', '', '1330', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 376),
(377, 'Gray Elementary School, William P', '', '', '', '3620', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 377),
(378, 'Neil Elementary School, Jane A', '', '', '', '5060', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 378),
(379, 'Nobel Elementary School, Alfred', '', '', '', '5110', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 379),
(380, 'Northwest Middle School', '', '', '', '4600', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 380),
(381, 'Stone Elementary Scholastic Academy', '', '', '', '6070', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 381),
(382, 'Tonti Elementary School, Enrico', '', '', '', '6220', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 382),
(383, 'McCutcheon Elementary School, John T', '', '', '', '6910', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 383),
(384, 'Instituto Health Sciences Career Academy HS', '', '', '', '8026', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 384),
(385, 'Bateman Elementary School, Newton', '', '', '', '2190', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 385),
(386, 'Beasley Elementary Magnet Academic Center, Edward', '', '', '', '6660', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 386),
(387, 'Burroughs Elementary School, John C', '', '', '', '2540', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 387),
(388, 'Esmond Elementary School', '', '', '', '3250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 203),
(389, 'Fermi Elementary School , Enrico', '', '', '', '3320', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 389),
(390, 'Lincoln Elementary School, Abraham', '', '', '', '4480', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 390),
(391, 'North-Grand High School', '', '', '', '1140', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 391),
(392, 'Pilsen Elementary Community Academy', '', '', '', '4210', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 392),
(393, 'Wildwood Elementary School', '', '', '', '6470', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 393),
(394, 'Chicago Quest North', '', '', '', '8672', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 394),
(395, 'Learn South', '', '', '', '8029', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 395),
(396, 'King Jr College Prep HS, Dr Martin Luther', '', '', '', '1760', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 396),
(397, 'Shields Middle School, James', '', '', '', '9597', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 397),
(398, 'Bell Elementary School, Alexander Graham', '', '', '', '2270', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 398),
(399, 'Falconer Elementary School, Laughlin', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 204),
(400, 'Stewart Elementary School, Graeme', '', '', '', '6040', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 400),
(401, 'Randolph Elementary School, Asa Philip', '', '', '', '3550', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 401),
(402, 'Burbank Elementary School, Luther', '', '', '', '2450', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 402),
(403, 'Holden Elementary School, Charles N', '', '', '', '4020', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 403),
(404, 'Burley Elementary School, Augustus H', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 374),
(405, 'Marine Leadership Academy', '', '', '', '2090', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 405),
(406, 'Lyon Elementary School, Mary', '', '', '', '4560', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 406),
(407, 'Carnegie Elementary School, Andrew', '', '', '', '2630', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 407),
(408, 'Healy Elementary School, Robert', '', '', '', '3880ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 408),
(409, 'Black Magnet Elementary School, Robert A', '', '', '', '7860ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 193),
(410, 'Rogers Elementary School , Philip', '', '', '', '5630', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 410),
(411, 'Montefiore Special Elementary School, Moses', '', '', '', '4860', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 411),
(412, 'Haines Elementary School, John Charles', '', '', '', '3700', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 412),
(413, 'Carson Elementary School, Rachel', '', '', '', '2660', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 413),
(414, 'Finkl Elementary School, William F', '', '', '', '3760', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 414),
(415, 'Henry Elementary School, Patrick', '', '', '', '3940', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 415),
(416, 'McNair Elementary School, Ronald E', '', '', '', '7040', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 416),
(417, 'Penn Elementary School, William', '', '', '', '5370', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 417),
(418, 'Reavis Math & Science Specialty ES, William C', '', '', '', '5580', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 418),
(419, 'Gallistel Elementary Language Academy, Mathew', '', '', '', '3490', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 419),
(420, 'Ellington Elementary School, Edward K', '', '', '', '3220', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 420),
(421, 'Burnside Elementary Scholastic Academy', '', '', '', '2520', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 421),
(422, 'Brighton Park Elementary School', '', '', '', '0', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 139),
(423, 'Addams Elementary School, Jane', '', '', '', '2020', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 423),
(424, 'Taylor Elementary School , Douglas', '', '', '', '6150', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 424),
(425, 'Davis Elementary School, Nathan S', '', '', '', '2970', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 425),
(426, 'Jones College Preparatory High School , William', '', '', '', '1060', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 426),
(427, 'Monroe Elementary School, James', '', '', '', '4850', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 427),
(428, 'Kellogg Elementary School , Kate S', '', '', '', '4240', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 428),
(429, 'Sumner Math & Science Community Acad ES, Charles', '', '', '', '6110', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 429),
(430, 'Mount Vernon Elementary School ', '', '', '', '4980', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 430),
(431, 'Colemon Elementary Academy, Johnnie', '', '', '', '6170', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 431),
(432, 'McCormick Elementary School, Cyrus H', '', '', '', '4720', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 432),
(433, 'Hubbard High School, Gurdon S', '', '', '', '1670', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 433),
(434, 'Jenner Elementary Academy of the Arts, Edward', '', '', '', '4200', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 434),
(435, 'Leland Elementary School, George', '', '', '', '7320', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 435),
(436, 'Faraday Elementary School, Michael', '', '', '', '4640', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 436),
(437, 'Kellman Corporate Community ES, Joseph', '', '', '', '3410', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 437),
(438, 'Wells Preparatory Elementary Academy, Ida B', '', '', '', '5250', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 438),
(439, 'Ward Elementary School, Laura S', '', '', '', '5470', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 439),
(440, 'Fiske Elementary School , John', '', '', '', '3360', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 440),
(441, 'Harvard Elementary School of Excellence, John', '', '', '', '3800', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 441),
(442, 'Air Force Academy High School', '', '', '', '1055', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 442),
(443, 'ASPIRA Charter - Haugan Campus', '', '', '', '3500', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 443),
(444, 'Intrinsic Schools', '', '', '', '9619', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 444),
(445, 'Hearst Elementary School, Phobe Apperson', '', '', '', '3890', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 445),
(446, 'Alcott Elementary School, Louisa May', '', '', '', '2040', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 446),
(447, 'Dixon Elementary School, Arthur', '', '', '', '3040', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 447),
(448, 'Lane Technical High School, Albert G', '', '', '', '1440', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 448),
(449, 'North Lawndale College Prep Charter', '', '', '', '1105ALL', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 449),
(450, 'Steinmetz College Preparatory HS, Charles P', '', '', '', '1560', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 450),
(451, 'Chicago Intl Charter - Northtown', '', '', '', '7740', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 451),
(452, 'Mitchell Elementary School, Ellen', '', '', '', '4840', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 452),
(453, 'Turner-Drew Elementary Language Academy', '', '', '', '3110', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 453),
(454, 'Shields Elementary School, James', '', '', '', '5910', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 454),
(455, 'Dubois Elementary School, William E B', '', '', '', '8010', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 455),
(456, 'Marine Leadership Academy at Ames', '', '', '', '2090', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 456),
(457, 'Gresham Elementary School, Walter Q', '', '', '', '3670', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 457),
(458, 'Langford Community Academy, Anna R', '', '', '', '2900', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 458),
(459, 'Earhart Options for Knowledge ES, Amelia', '', '', '', '7450', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 459),
(460, 'Gage Park High School', '', '', '', '1340', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 205),
(461, 'Chicago High School for the Arts', '', '', '', '8047', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 461),
(462, 'Mireles Elementary Academy, Arnold', '', '', '', '5880', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 462),
(463, 'Fulton Elementary School, Robert', '', '', '', '3450', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 463),
(464, 'Goode STEM Academy, Sarah E.', '', '', '', '9598', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 464),
(465, 'Back of the Yards High School', '', '', '', '9623', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 465),
(466, 'Prosser Career Academy High School, Charles Allen', '', '', '', '1070', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 466),
(467, 'Oglesby Elementary School, Richard J', '', '', '', '5170', '', '', '', 0, '', '', 1, '', '', '', 'Meet the Librarians', '', '', '', '', '', '', '', '', '', '', '', '', '2017-01-03 22:12:04', '', 467);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `link` text NOT NULL,
  `content` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image`, `title`, `link`, `content`, `active`, `datetime`, `author_name`, `loc_id`) VALUES
(3, 'parallax_3-5_med.jpg', 'Grades 3-5', '45', 'Advancing in Elementary School', 'true', '2016-12-29 17:55:15', '', 1),
(4, 'parallax_6-8_med.jpg', 'Grades 6-8', '46', '8 ways parents can help with homework', 'true', '2016-12-29 17:55:07', '', 1),
(5, '2290_1_624_0_0.jpg', 'Vim ea omnes discere', '', 'Tibique singulis nam id, aliquid mediocrem definitiones nam ne.', 'true', '2016-12-28 19:50:20', '', 2),
(7, 'CPS_5938.jpg', 'Grades K-2', '48', 'Learn About our K-2 Programs', 'true', '2016-12-29 17:55:18', '', 1),
(9, '2290_0_624_0_0.jpg', 'Inani singulis efficiantur ut mel, et regione repudiare ius', '', 'Vim ea omnes discere molestie. Cu vix facilisis efficiendi, vix ne ipsum inermis. Te cum possit voluptua expetendis. Cibo integre virtute ius ut.', 'true', '2016-12-28 19:49:34', '', 2),
(10, '2290_14_624_0_24.jpg', 'Inani singulis efficiantur ut mel, et regione repudiare ius', '35', '', 'true', '2016-12-28 19:50:41', '', 2),
(11, '2290_7_624_0_95.jpg', 'Tibique singulis nam id, aliquid mediocrem definitiones nam ne', '35', 'Inani singulis efficiantur ut mel, et regione repudiare ius', 'true', '2016-12-28 19:49:02', '', 2),
(12, 'parallax_9-12_med.jpg', 'Grades 9-12', '47', 'High School Course Catalog', 'true', '2016-12-29 17:55:02', '', 1),
(13, '8852042_orig.jpg', 'Welcome to â€‹John Barry Elementary School!', '', '', 'true', '2017-01-03 21:52:52', '', 10),
(14, '8245353_orig.jpg', 'Welcome to â€‹John Barry Elementary School!', '', '', 'true', '2017-01-03 21:53:38', '', 10),
(15, '1113546_orig.jpg', 'Welcome to â€‹John Barry Elementary School!', '', '', 'true', '2017-01-03 21:53:48', '', 10),
(16, '46301_orig.jpg', 'Welcome to â€‹John Barry Elementary School!', '', '', 'true', '2017-01-03 21:55:11', '', 10),
(17, 'spaces-desktop-backgrounds-2.jpg', 'Vim ea omnes discere molestie', '', '', 'true', '2017-01-05 20:38:15', 'admin', 100);

-- --------------------------------------------------------

--
-- Table structure for table `socialmedia`
--

CREATE TABLE IF NOT EXISTS `socialmedia` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `facebook` text NOT NULL,
  `twitter` text NOT NULL,
  `pinterest` text NOT NULL,
  `google` text NOT NULL,
  `instagram` text NOT NULL,
  `youtube` text NOT NULL,
  `tumblr` text NOT NULL,
  `use_defaults` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `socialmedia`
--

INSERT INTO `socialmedia` (`id`, `heading`, `facebook`, `twitter`, `pinterest`, `google`, `instagram`, `youtube`, `tumblr`, `use_defaults`, `loc_id`) VALUES
(1, 'Follow Us', 'https://www.facebook.com/chicagopublicschools', 'https://twitter.com/ChiPubSchools', '', '', '', 'http://www.youtube.com/user/ChiPubSchools', '', '', 1),
(2, 'Follow Us', 'https://www.facebook.com/curiehs', 'https://twitter.com/@CurieHS', '', '', '', '', '', 'false', 2),
(3, 'Follow Us', 'https://www.facebook.com/Barry-School-Chicago-173117329701907/', 'http://Barry%20School%20Chicago%20@barryschoolchi1/', '', '', '', '', '', 'false', 10),
(4, '', '', '', '', '', '', '', '', 'true', 100);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `name` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `image`, `title`, `content`, `name`, `active`, `datetime`, `author_name`, `loc_id`) VALUES
(3, 'space-desktop-backgrounds.jpg', 'Chief Financial Officer', 'More than 30 years of experience in large and small aerospace and defense companies, most recently as the Chief Financial Officer of Applied Signal Technology.', 'Cindy Dole', 'true', '2016-12-05 22:01:38', '', 1),
(4, 'z7whdbw.jpg', 'Chief Operations Officer', 'President and CEO since in 1995. Provides executive oversight and leadership of day-to-day company operations, integration of shared company resources.', 'John Doe', 'true', '2016-12-05 22:00:59', '', 1),
(5, 'space-desktop-backgrounds.jpg', 'CTO', 'Mr. Anderson has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Anderson', 'true', '2016-12-29 15:53:10', '', 1),
(7, 'Ubuntu-Mate-Cold-no-logo.png', 'President', 'Mr. Smith has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Smith', 'true', '2016-12-05 22:01:18', '', 1),
(8, 'CURIE1442203060344.jpg', 'Librarian', 'I am Ms. Adams. I am the librarian in the Media Center. We have lots of great books and about 30 computers with internet, word processing and PowerPoint.', 'Carmen Adams', 'true', '2016-12-29 16:11:58', '', 2),
(9, 'Ubuntu-Mate-Radioactive-no-logo.png', 'Chief Operations Officer', 'President and CEO since in 1995. Provides executive oversight and leadership of day-to-day company operations, integration of shared company resources.', 'John Doe', 'true', '2016-11-14 21:59:52', '', 2),
(10, 'Ubuntu-Mate-Radioactive-no-logo.png', 'CTO', 'Mr. Anderson has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Anderson', 'true', '2016-11-14 21:59:55', '', 2),
(11, 'Ubuntu-Mate-Radioactive-no-logo.png', 'President', 'Mr. Smith has more than 20 years of experience in information technology strategy, program management, strategic planning and process improvement.', 'Mr. Smith', 'true', '2016-11-14 21:59:54', '', 2),
(12, '1446552243.png', 'Librarian', 'I TOUCH THE FUTURE.\r\nâ€‹I TEACH', 'Ms. Smith', 'true', '2017-01-03 22:09:35', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `level` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `clientip` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `level`, `datetime`, `clientip`, `loc_id`) VALUES
(1, 'admin', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'rjones@tlcdelivers.com', 1, '2017-01-09 16:10:30', '192.168.2.105', 1),
(2, 'rjones', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'rjones@tlcdelivers.com', 0, '2016-12-22 14:51:19', '127.0.0.1', 2),
(3, 'kgray', '*7561F5295A1A35CB8E0A7C46921994D383947FA5', 'kgray@tlcdelivers.com', 1, '2017-01-04 16:15:34', '192.168.2.46', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `featured`
--
ALTER TABLE `featured`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `generalinfo`
--
ALTER TABLE `generalinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=468;
--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `services_icons`
--
ALTER TABLE `services_icons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=468;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `socialmedia`
--
ALTER TABLE `socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
