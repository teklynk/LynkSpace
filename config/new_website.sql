-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2017 at 02:59 PM
-- Server version: 5.5.54-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.6.30-10+deb.sury.org~trusty+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `businessCMS_test`
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
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_customers`
--

CREATE TABLE `category_customers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `section` text NOT NULL,
  `cust_loc_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_navigation`
--

CREATE TABLE `category_navigation` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `nav_section` text NOT NULL,
  `nav_loc_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `customer_id` text NOT NULL,
  `theme` text NOT NULL,
  `iprange` text NOT NULL,
  `multibranch` text NOT NULL,
  `homepageurl` text NOT NULL,
  `setuppacurl` text NOT NULL,
  `searchform` text NOT NULL,
  `session_timeout` int(11) NOT NULL,
  `carousel_speed` text NOT NULL,
  `analytics` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `customer_id`, `theme`, `iprange`, `multibranch`, `homepageurl`, `setuppacurl`, `searchform`, `session_timeout`, `carousel_speed`, `analytics`, `datetime`, `author_name`) VALUES
(1, '', 'default', '', 'false', '', '', '', 3600, '5000', '', '2017-04-14 18:31:52', '');

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
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `icon` text NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `content` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `section` text NOT NULL,
  `featured` text NOT NULL,
  `active` text NOT NULL,
  `sort` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `generalinfo`
--

CREATE TABLE `generalinfo` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hottitles`
--

CREATE TABLE `hottitles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `url` text NOT NULL,
  `loc_type` text NOT NULL,
  `sort` int(11) NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `icons_list`
--

CREATE TABLE `icons_list` (
  `id` int(11) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `icons_list`
--

INSERT INTO `icons_list` (`id`, `icon`) VALUES
(1, 'wpexplorer'),
(2, 'adjust'),
(3, 'adn'),
(4, 'align-center'),
(5, 'align-justify'),
(6, 'align-left'),
(7, 'align-right'),
(8, 'ambulance'),
(9, 'anchor'),
(10, 'android'),
(11, 'angellist'),
(12, 'angle-double-down'),
(13, 'angle-double-left'),
(14, 'angle-double-right'),
(15, 'angle-double-up'),
(16, 'angle-down'),
(17, 'angle-left'),
(18, 'angle-right'),
(19, 'angle-up'),
(20, 'apple'),
(21, 'archive'),
(22, 'area-chart'),
(23, 'arrow-circle-down'),
(24, 'arrow-circle-left'),
(25, 'arrow-circle-o-down'),
(26, 'arrow-circle-o-left'),
(27, 'arrow-circle-o-right'),
(28, 'arrow-circle-o-up'),
(29, 'arrow-circle-right'),
(30, 'arrow-circle-up'),
(31, 'arrow-down'),
(32, 'arrow-left'),
(33, 'arrow-right'),
(34, 'arrow-up'),
(35, 'arrows'),
(36, 'arrows-alt'),
(37, 'arrows-h'),
(38, 'arrows-v'),
(39, 'asterisk'),
(40, 'at'),
(41, 'automobile'),
(42, 'backward'),
(43, 'ban'),
(44, 'bank'),
(45, 'bar-chart'),
(46, 'bar-chart-o'),
(47, 'barcode'),
(48, 'bars'),
(49, 'bed'),
(50, 'beer'),
(51, 'behance'),
(52, 'behance-square'),
(53, 'bell'),
(54, 'bell-o'),
(55, 'bell-slash'),
(56, 'bell-slash-o'),
(57, 'bicycle'),
(58, 'binoculars'),
(59, 'birthday-cake'),
(60, 'bitbucket'),
(61, 'bitbucket-square'),
(62, 'bitcoin'),
(63, 'bold'),
(64, 'bolt'),
(65, 'bomb'),
(66, 'book'),
(67, 'bookmark'),
(68, 'bookmark-o'),
(69, 'briefcase'),
(70, 'btc'),
(71, 'bug'),
(72, 'building'),
(73, 'building-o'),
(74, 'bullhorn'),
(75, 'bullseye'),
(76, 'bus'),
(77, 'buysellads'),
(78, 'cab'),
(79, 'calculator'),
(80, 'calendar'),
(81, 'calendar-o'),
(82, 'camera'),
(83, 'camera-retro'),
(84, 'car'),
(85, 'caret-down'),
(86, 'caret-left'),
(87, 'caret-right'),
(88, 'caret-square-o-down'),
(89, 'caret-square-o-left'),
(90, 'caret-square-o-right'),
(91, 'caret-square-o-up'),
(92, 'caret-up'),
(93, 'cart-arrow-down'),
(94, 'cart-plus'),
(95, 'cc'),
(96, 'cc-amex'),
(97, 'cc-discover'),
(98, 'cc-mastercard'),
(99, 'cc-paypal'),
(100, 'cc-stripe'),
(101, 'cc-visa'),
(102, 'certificate'),
(103, 'chain'),
(104, 'chain-broken'),
(105, 'check'),
(106, 'check-circle'),
(107, 'check-circle-o'),
(108, 'check-square'),
(109, 'check-square-o'),
(110, 'chevron-circle-down'),
(111, 'chevron-circle-left'),
(112, 'chevron-circle-right'),
(113, 'chevron-circle-up'),
(114, 'chevron-down'),
(115, 'chevron-left'),
(116, 'chevron-right'),
(117, 'chevron-up'),
(118, 'child'),
(119, 'circle'),
(120, 'circle-o'),
(121, 'circle-o-notch'),
(122, 'circle-thin'),
(123, 'clipboard'),
(124, 'clock-o'),
(125, 'close'),
(126, 'cloud'),
(127, 'cloud-download'),
(128, 'cloud-upload'),
(129, 'cny'),
(130, 'code'),
(131, 'code-fork'),
(132, 'codepen'),
(133, 'coffee'),
(134, 'cog'),
(135, 'cogs'),
(136, 'columns'),
(137, 'comment'),
(138, 'comment-o'),
(139, 'comments'),
(140, 'comments-o'),
(141, 'compass'),
(142, 'compress'),
(143, 'connectdevelop'),
(144, 'copy'),
(145, 'copyright'),
(146, 'credit-card'),
(147, 'crop'),
(148, 'crosshairs'),
(149, 'css3'),
(150, 'cube'),
(151, 'cubes'),
(152, 'cut'),
(153, 'cutlery'),
(154, 'dashboard'),
(155, 'dashcube'),
(156, 'database'),
(157, 'dedent'),
(158, 'delicious'),
(159, 'desktop'),
(160, 'deviantart'),
(161, 'diamond'),
(162, 'digg'),
(163, 'dollar'),
(164, 'dot-circle-o'),
(165, 'download'),
(166, 'dribbble'),
(167, 'dropbox'),
(168, 'drupal'),
(169, 'edit'),
(170, 'eject'),
(171, 'ellipsis-h'),
(172, 'ellipsis-v'),
(173, 'empire'),
(174, 'envelope'),
(175, 'envelope-o'),
(176, 'envelope-square'),
(177, 'eraser'),
(178, 'eur'),
(179, 'euro'),
(180, 'exchange'),
(181, 'exclamation'),
(182, 'exclamation-circle'),
(183, 'exclamation-triangle'),
(184, 'expand'),
(185, 'external-link'),
(186, 'external-link-square'),
(187, 'eye'),
(188, 'eye-slash'),
(189, 'eyedropper'),
(190, 'facebook'),
(191, 'facebook-f'),
(192, 'facebook-official'),
(193, 'facebook-square'),
(194, 'fast-backward'),
(195, 'fast-forward'),
(196, 'fax'),
(197, 'female'),
(198, 'fighter-jet'),
(199, 'file'),
(200, 'file-archive-o'),
(201, 'file-audio-o'),
(202, 'file-code-o'),
(203, 'file-excel-o'),
(204, 'file-image-o'),
(205, 'file-movie-o'),
(206, 'file-o'),
(207, 'file-pdf-o'),
(208, 'file-photo-o'),
(209, 'file-picture-o'),
(210, 'file-powerpoint-o'),
(211, 'file-sound-o'),
(212, 'file-text'),
(213, 'file-text-o'),
(214, 'file-video-o'),
(215, 'file-word-o'),
(216, 'file-zip-o'),
(217, 'files-o'),
(218, 'film'),
(219, 'filter'),
(220, 'fire'),
(221, 'fire-extinguisher'),
(222, 'flag'),
(223, 'flag-checkered'),
(224, 'flag-o'),
(225, 'flash'),
(226, 'flask'),
(227, 'flickr'),
(228, 'floppy-o'),
(229, 'folder'),
(230, 'folder-o'),
(231, 'folder-open'),
(232, 'folder-open-o'),
(233, 'font'),
(234, 'forumbee'),
(235, 'forward'),
(236, 'foursquare'),
(237, 'frown-o'),
(238, 'futbol-o'),
(239, 'gamepad'),
(240, 'gavel'),
(241, 'gbp'),
(242, 'ge'),
(243, 'gear'),
(244, 'gears'),
(245, 'genderless'),
(246, 'gift'),
(247, 'git'),
(248, 'git-square'),
(249, 'github'),
(250, 'github-alt'),
(251, 'github-square'),
(252, 'gittip'),
(253, 'glass'),
(254, 'globe'),
(255, 'google'),
(256, 'google-plus'),
(257, 'google-plus-square'),
(258, 'google-wallet'),
(259, 'graduation-cap'),
(260, 'gratipay'),
(261, 'group'),
(262, 'h-square'),
(263, 'hacker-news'),
(264, 'hand-o-down'),
(265, 'hand-o-left'),
(266, 'hand-o-right'),
(267, 'hand-o-up'),
(268, 'hdd-o'),
(269, 'header'),
(270, 'headphones'),
(271, 'heart'),
(272, 'heart-o'),
(273, 'heartbeat'),
(274, 'history'),
(275, 'home'),
(276, 'hospital-o'),
(277, 'hotel'),
(278, 'html5'),
(279, 'ils'),
(280, 'image'),
(281, 'inbox'),
(282, 'indent'),
(283, 'info'),
(284, 'info-circle'),
(285, 'inr'),
(286, 'instagram'),
(287, 'institution'),
(288, 'ioxhost'),
(289, 'italic'),
(290, 'joomla'),
(291, 'jpy'),
(292, 'jsfiddle'),
(293, 'key'),
(294, 'keyboard-o'),
(295, 'krw'),
(296, 'language'),
(297, 'laptop'),
(298, 'lastfm'),
(299, 'lastfm-square'),
(300, 'leaf'),
(301, 'leanpub'),
(302, 'legal'),
(303, 'lemon-o'),
(304, 'level-down'),
(305, 'level-up'),
(306, 'life-bouy'),
(307, 'life-buoy'),
(308, 'life-ring'),
(309, 'life-saver'),
(310, 'lightbulb-o'),
(311, 'line-chart'),
(312, 'link'),
(313, 'linkedin'),
(314, 'linkedin-square'),
(315, 'linux'),
(316, 'list'),
(317, 'list-alt'),
(318, 'list-ol'),
(319, 'list-ul'),
(320, 'location-arrow'),
(321, 'lock'),
(322, 'long-arrow-down'),
(323, 'long-arrow-left'),
(324, 'long-arrow-right'),
(325, 'long-arrow-up'),
(326, 'magic'),
(327, 'magnet'),
(328, 'mail-forward'),
(329, 'mail-reply'),
(330, 'mail-reply-all'),
(331, 'male'),
(332, 'map-marker'),
(333, 'mars'),
(334, 'mars-double'),
(335, 'mars-stroke'),
(336, 'mars-stroke-h'),
(337, 'mars-stroke-v'),
(338, 'maxcdn'),
(339, 'meanpath'),
(340, 'medium'),
(341, 'medkit'),
(342, 'meh-o'),
(343, 'mercury'),
(344, 'microphone'),
(345, 'microphone-slash'),
(346, 'minus'),
(347, 'minus-circle'),
(348, 'minus-square'),
(349, 'minus-square-o'),
(350, 'mobile'),
(351, 'mobile-phone'),
(352, 'money'),
(353, 'moon-o'),
(354, 'mortar-board'),
(355, 'motorcycle'),
(356, 'music'),
(357, 'navicon'),
(358, 'neuter'),
(359, 'newspaper-o'),
(360, 'openid'),
(361, 'outdent'),
(362, 'pagelines'),
(363, 'paint-brush'),
(364, 'paper-plane'),
(365, 'paper-plane-o'),
(366, 'paperclip'),
(367, 'paragraph'),
(368, 'paste'),
(369, 'pause'),
(370, 'paw'),
(371, 'paypal'),
(372, 'pencil'),
(373, 'pencil-square'),
(374, 'pencil-square-o'),
(375, 'phone'),
(376, 'phone-square'),
(377, 'photo'),
(378, 'picture-o'),
(379, 'pie-chart'),
(380, 'pied-piper'),
(381, 'pied-piper-alt'),
(382, 'pinterest'),
(383, 'pinterest-p'),
(384, 'pinterest-square'),
(385, 'plane'),
(386, 'play'),
(387, 'play-circle'),
(388, 'play-circle-o'),
(389, 'plug'),
(390, 'plus'),
(391, 'plus-circle'),
(392, 'plus-square'),
(393, 'plus-square-o'),
(394, 'power-off'),
(395, 'print'),
(396, 'puzzle-piece'),
(397, 'qq'),
(398, 'qrcode'),
(399, 'question'),
(400, 'question-circle'),
(401, 'quote-left'),
(402, 'quote-right'),
(403, 'ra'),
(404, 'random'),
(405, 'rebel'),
(406, 'recycle'),
(407, 'reddit'),
(408, 'reddit-square'),
(409, 'refresh'),
(410, 'remove'),
(411, 'renren'),
(412, 'reorder'),
(413, 'repeat'),
(414, 'reply'),
(415, 'reply-all'),
(416, 'retweet'),
(417, 'rmb'),
(418, 'road'),
(419, 'rocket'),
(420, 'rotate-left'),
(421, 'rotate-right'),
(422, 'rouble'),
(423, 'rss'),
(424, 'rss-square'),
(425, 'rub'),
(426, 'ruble'),
(427, 'rupee'),
(428, 'save'),
(429, 'scissors'),
(430, 'search'),
(431, 'search-minus'),
(432, 'search-plus'),
(433, 'sellsy'),
(434, 'send'),
(435, 'send-o'),
(436, 'server'),
(437, 'share'),
(438, 'share-alt'),
(439, 'share-alt-square'),
(440, 'share-square'),
(441, 'share-square-o'),
(442, 'shekel'),
(443, 'sheqel'),
(444, 'shield'),
(445, 'ship'),
(446, 'shirtsinbulk'),
(447, 'shopping-cart'),
(448, 'sign-in'),
(449, 'sign-out'),
(450, 'signal'),
(451, 'simplybuilt'),
(452, 'sitemap'),
(453, 'skyatlas'),
(454, 'skype'),
(455, 'slack'),
(456, 'sliders'),
(457, 'slideshare'),
(458, 'smile-o'),
(459, 'soccer-ball-o'),
(460, 'sort'),
(461, 'sort-alpha-asc'),
(462, 'sort-alpha-desc'),
(463, 'sort-amount-asc'),
(464, 'sort-amount-desc'),
(465, 'sort-asc'),
(466, 'sort-desc'),
(467, 'sort-down'),
(468, 'sort-numeric-asc'),
(469, 'sort-numeric-desc'),
(470, 'sort-up'),
(471, 'soundcloud'),
(472, 'space-shuttle'),
(473, 'spinner'),
(474, 'spoon'),
(475, 'spotify'),
(476, 'square'),
(477, 'square-o'),
(478, 'stack-exchange'),
(479, 'stack-overflow'),
(480, 'star'),
(481, 'star-half'),
(482, 'star-half-empty'),
(483, 'star-half-full'),
(484, 'star-half-o'),
(485, 'star-o'),
(486, 'steam'),
(487, 'steam-square'),
(488, 'step-backward'),
(489, 'step-forward'),
(490, 'stethoscope'),
(491, 'stop'),
(492, 'street-view'),
(493, 'strikethrough'),
(494, 'stumbleupon'),
(495, 'stumbleupon-circle'),
(496, 'subscript'),
(497, 'subway'),
(498, 'suitcase'),
(499, 'sun-o'),
(500, 'superscript'),
(501, 'support'),
(502, 'table'),
(503, 'tablet'),
(504, 'tachometer'),
(505, 'tag'),
(506, 'tags'),
(507, 'tasks'),
(508, 'taxi'),
(509, 'tencent-weibo'),
(510, 'terminal'),
(511, 'text-height'),
(512, 'text-width'),
(513, 'th'),
(514, 'th-large'),
(515, 'th-list'),
(516, 'thumb-tack'),
(517, 'thumbs-down'),
(518, 'thumbs-o-down'),
(519, 'thumbs-o-up'),
(520, 'thumbs-up'),
(521, 'ticket'),
(522, 'times'),
(523, 'times-circle'),
(524, 'times-circle-o'),
(525, 'tint'),
(526, 'toggle-down'),
(527, 'toggle-left'),
(528, 'toggle-off'),
(529, 'toggle-on'),
(530, 'toggle-right'),
(531, 'toggle-up'),
(532, 'train'),
(533, 'transgender'),
(534, 'transgender-alt'),
(535, 'trash'),
(536, 'trash-o'),
(537, 'tree'),
(538, 'trello'),
(539, 'trophy'),
(540, 'truck'),
(541, 'try'),
(542, 'tty'),
(543, 'tumblr'),
(544, 'tumblr-square'),
(545, 'turkish-lira'),
(546, 'twitch'),
(547, 'twitter'),
(548, 'twitter-square'),
(549, 'umbrella'),
(550, 'underline'),
(551, 'undo'),
(552, 'university'),
(553, 'unlink'),
(554, 'unlock'),
(555, 'unlock-alt'),
(556, 'unsorted'),
(557, 'upload'),
(558, 'usd'),
(559, 'user'),
(560, 'user-md'),
(561, 'user-plus'),
(562, 'user-secret'),
(563, 'user-times'),
(564, 'users'),
(565, 'venus'),
(566, 'venus-double'),
(567, 'venus-mars'),
(568, 'viacoin'),
(569, 'video-camera'),
(570, 'vimeo-square'),
(571, 'vine'),
(572, 'vk'),
(573, 'volume-down'),
(574, 'volume-off'),
(575, 'volume-up'),
(576, 'warning'),
(577, 'wechat'),
(578, 'weibo'),
(579, 'weixin'),
(580, 'whatsapp'),
(581, 'wheelchair'),
(582, 'wifi'),
(583, 'windows'),
(584, 'won'),
(585, 'wordpress'),
(586, 'wrench'),
(587, 'xing'),
(588, 'xing-square'),
(589, 'yahoo'),
(590, 'yelp'),
(591, 'yen'),
(592, 'youtube'),
(593, 'youtube-play'),
(594, 'youtube-square');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `active` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`, `datetime`, `active`) VALUES
(1, 'My Library', 'default', '0000-00-00 00:00:00', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `url` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `section` text NOT NULL,
  `win` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `image_align` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `link` text NOT NULL,
  `active` text NOT NULL,
  `sort` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setup`
--

CREATE TABLE `setup` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `config` text NOT NULL,
  `logo` text NOT NULL,
  `ls2pac` text NOT NULL,
  `ls2kids` text NOT NULL,
  `searchdefault` int(11) NOT NULL,
  `author` text NOT NULL,
  `pageheading` text NOT NULL,
  `servicesheading` text NOT NULL,
  `sliderheading` text NOT NULL,
  `teamheading` text NOT NULL,
  `hottitlesheading` text NOT NULL,
  `customersheading_1` text NOT NULL,
  `customersheading_2` text NOT NULL,
  `customersheading_3` text NOT NULL,
  `servicescontent` text NOT NULL,
  `customerscontent_1` text NOT NULL,
  `customerscontent_2` text NOT NULL,
  `customerscontent_3` text NOT NULL,
  `teamcontent` text NOT NULL,
  `slider_use_defaults` text NOT NULL,
  `databases_use_defaults_1` text NOT NULL,
  `databases_use_defaults_2` text NOT NULL,
  `databases_use_defaults_3` text NOT NULL,
  `navigation_use_defaults_1` text NOT NULL,
  `navigation_use_defaults_2` text NOT NULL,
  `navigation_use_defaults_3` text NOT NULL,
  `services_use_defaults` text NOT NULL,
  `team_use_defaults` text NOT NULL,
  `hottitles_use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `config`, `logo`, `ls2pac`, `ls2kids`, `searchdefault`, `author`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `hottitlesheading`, `customersheading_1`, `customersheading_2`, `customersheading_3`, `servicescontent`, `customerscontent_1`, `customerscontent_2`, `customerscontent_3`, `teamcontent`, `slider_use_defaults`, `databases_use_defaults_1`, `databases_use_defaults_2`, `databases_use_defaults_3`, `navigation_use_defaults_1`, `navigation_use_defaults_2`, `navigation_use_defaults_3`, `services_use_defaults`, `team_use_defaults`, `hottitles_use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
(1, 'My Library', '', '', 'ysm', '', 'false', 'false', 0, '', 'Pages', 'Services', 'Slides', 'Meet the Team', 'New Titles', 'Resources', 'Recommended Websites', 'Librarian Links', '', '', '', '', '', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', '', '2017-04-14 18:59:07', 'admin', 1);

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
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `loc_type` text NOT NULL,
  `active` text NOT NULL,
  `sort` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `use_defaults` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `sort` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `clientip` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aboutus_loc_id_fk` (`loc_id`);

--
-- Indexes for table `category_customers`
--
ALTER TABLE `category_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_customers_loc_id_fk` (`cust_loc_id`);

--
-- Indexes for table `category_navigation`
--
ALTER TABLE `category_navigation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_loc_id_fk` (`nav_loc_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contactus_loc_id_fk` (`loc_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_loc_id_fk` (`loc_id`);

--
-- Indexes for table `featured`
--
ALTER TABLE `featured`
  ADD PRIMARY KEY (`id`),
  ADD KEY `featured_loc_id_fk` (`loc_id`);

--
-- Indexes for table `generalinfo`
--
ALTER TABLE `generalinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generalinfo_loc_id_fk` (`loc_id`);

--
-- Indexes for table `hottitles`
--
ALTER TABLE `hottitles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hottitles_loc_id_fk` (`loc_id`);

--
-- Indexes for table `icons_list`
--
ALTER TABLE `icons_list`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `navigation_loc_id_fk` (`loc_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_loc_id_fk` (`loc_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_loc_id_fk` (`loc_id`);

--
-- Indexes for table `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setup_loc_id_fk` (`loc_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slider_loc_id_fk` (`loc_id`);

--
-- Indexes for table `socialmedia`
--
ALTER TABLE `socialmedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socialmedia_loc_id_fk` (`loc_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_loc_id_fk` (`loc_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_loc_id_fk` (`loc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category_customers`
--
ALTER TABLE `category_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category_navigation`
--
ALTER TABLE `category_navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `featured`
--
ALTER TABLE `featured`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `generalinfo`
--
ALTER TABLE `generalinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hottitles`
--
ALTER TABLE `hottitles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `icons_list`
--
ALTER TABLE `icons_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=595;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=571;
--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=569;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `socialmedia`
--
ALTER TABLE `socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=567;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD CONSTRAINT `aboutus_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_customers`
--
ALTER TABLE `category_customers`
  ADD CONSTRAINT `category_customers_loc_id_fk` FOREIGN KEY (`cust_loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_navigation`
--
ALTER TABLE `category_navigation`
  ADD CONSTRAINT `category_loc_id_fk` FOREIGN KEY (`nav_loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contactus`
--
ALTER TABLE `contactus`
  ADD CONSTRAINT `contactus_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `featured`
--
ALTER TABLE `featured`
  ADD CONSTRAINT `featured_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `generalinfo`
--
ALTER TABLE `generalinfo`
  ADD CONSTRAINT `generalinfo_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hottitles`
--
ALTER TABLE `hottitles`
  ADD CONSTRAINT `hottitles_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `navigation`
--
ALTER TABLE `navigation`
  ADD CONSTRAINT `navigation_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `setup`
--
ALTER TABLE `setup`
  ADD CONSTRAINT `setup_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `slider_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `socialmedia`
--
ALTER TABLE `socialmedia`
  ADD CONSTRAINT `socialmedia_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
