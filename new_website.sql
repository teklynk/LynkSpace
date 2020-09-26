SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_navigation`
--

CREATE TABLE `category_navigation` (
  `id` int(11) NOT NULL,
  `cat_name` text NOT NULL,
  `nav_section` text NOT NULL,
  `nav_loc_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_navigation`
--

INSERT INTO `category_navigation` (`id`, `cat_name`, `nav_section`, `nav_loc_id`, `datetime`, `author_name`) VALUES
  (0, 'None', '', 0, CURRENT_TIMESTAMP(), '');

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
  `loc_types` text NOT NULL,
  `homepageurl` text NOT NULL,
  `setuppacurl` text NOT NULL,
  `searchlabel_ls2pac` text NOT NULL,
  `searchlabel_ls2kids` text NOT NULL,
  `searchplaceholder_ls2pac` text NOT NULL,
  `searchplaceholder_ls2kids` text NOT NULL,
  `searchform` text NOT NULL,
  `session_timeout` int(11) NOT NULL,
  `carousel_speed` text NOT NULL,
  `analytics` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `customer_id`, `theme`, `iprange`, `multibranch`, `loc_types`, `homepageurl`, `setuppacurl`, `searchlabel_ls2pac`, `searchlabel_ls2kids`, `searchplaceholder_ls2pac`, `searchplaceholder_ls2kids`, `searchform`, `session_timeout`, `carousel_speed`, `analytics`, `datetime`, `author_name`) VALUES
  (1, '', 'default', '', 'false', '1,2,3', '', '', 'Catalog', 'Kid\'s Catalog', 'Find anything at the library. Start here.', 'Find children\'s books and more.', '', 60, '5', '', CURRENT_TIMESTAMP(), '');

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
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `guid` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `section` text NOT NULL,
  `featured` text NOT NULL,
  `active` text NOT NULL,
  `sort` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `heading` text NOT NULL,
  `alert` text NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `calendar` text NOT NULL,
  `use_defaults` text NOT NULL,
  `author_name` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` text NOT NULL,
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
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` text NOT NULL,
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
  `guid` text NOT NULL,
  `loc_type` text NOT NULL,
  `sort` int(11) NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hottitles`
--

INSERT INTO `hottitles` (`id`, `title`, `url`, `loc_type`, `sort`, `active`, `datetime`, `loc_id`) VALUES
  (1, 'New York Times', 'https://content.tlcdelivers.com/econtent/xml/NYTimes.xml', 'ALL', 1, 'true', CURRENT_TIMESTAMP(), 1);

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
  (1, '500px'),
  (2, 'address-book'),
  (3, 'address-book-o'),
  (4, 'address-card'),
  (5, 'address-card-o'),
  (6, 'adjust'),
  (7, 'adn'),
  (8, 'align-center'),
  (9, 'align-justify'),
  (10, 'align-left'),
  (11, 'align-right'),
  (12, 'amazon'),
  (13, 'ambulance'),
  (14, 'american-sign-language-interpreting'),
  (15, 'anchor'),
  (16, 'android'),
  (17, 'angellist'),
  (18, 'angle-double-down'),
  (19, 'angle-double-left'),
  (20, 'angle-double-right'),
  (21, 'angle-double-up'),
  (22, 'angle-down'),
  (23, 'angle-left'),
  (24, 'angle-right'),
  (25, 'angle-up'),
  (26, 'apple'),
  (27, 'archive'),
  (28, 'area-chart'),
  (29, 'arrow-circle-down'),
  (30, 'arrow-circle-left'),
  (31, 'arrow-circle-o-down'),
  (32, 'arrow-circle-o-left'),
  (33, 'arrow-circle-o-right'),
  (34, 'arrow-circle-o-up'),
  (35, 'arrow-circle-right'),
  (36, 'arrow-circle-up'),
  (37, 'arrow-down'),
  (38, 'arrow-left'),
  (39, 'arrow-right'),
  (40, 'arrow-up'),
  (41, 'arrows'),
  (42, 'arrows-alt'),
  (43, 'arrows-h'),
  (44, 'arrows-v'),
  (45, 'asl-interpreting'),
  (46, 'assistive-listening-systems'),
  (47, 'asterisk'),
  (48, 'at'),
  (49, 'audio-description'),
  (50, 'automobile'),
  (51, 'backward'),
  (52, 'balance-scale'),
  (53, 'ban'),
  (54, 'bandcamp'),
  (55, 'bank'),
  (56, 'bar-chart'),
  (57, 'bar-chart-o'),
  (58, 'barcode'),
  (59, 'bars'),
  (60, 'bath'),
  (61, 'bathtub'),
  (62, 'battery'),
  (63, 'battery-0'),
  (64, 'battery-1'),
  (65, 'battery-2'),
  (66, 'battery-3'),
  (67, 'battery-4'),
  (68, 'battery-empty'),
  (69, 'battery-full'),
  (70, 'battery-half'),
  (71, 'battery-quarter'),
  (72, 'battery-three-quarters'),
  (73, 'bed'),
  (74, 'beer'),
  (75, 'behance'),
  (76, 'behance-square'),
  (77, 'bell'),
  (78, 'bell-o'),
  (79, 'bell-slash'),
  (80, 'bell-slash-o'),
  (81, 'bicycle'),
  (82, 'binoculars'),
  (83, 'birthday-cake'),
  (84, 'bitbucket'),
  (85, 'bitbucket-square'),
  (86, 'bitcoin'),
  (87, 'black-tie'),
  (88, 'blind'),
  (89, 'bluetooth'),
  (90, 'bluetooth-b'),
  (91, 'bold'),
  (92, 'bolt'),
  (93, 'bomb'),
  (94, 'book'),
  (95, 'bookmark'),
  (96, 'bookmark-o'),
  (97, 'braille'),
  (98, 'briefcase'),
  (99, 'btc'),
  (100, 'bug'),
  (101, 'building'),
  (102, 'building-o'),
  (103, 'bullhorn'),
  (104, 'bullseye'),
  (105, 'bus'),
  (106, 'buysellads'),
  (107, 'cab'),
  (108, 'calculator'),
  (109, 'calendar'),
  (110, 'calendar-check-o'),
  (111, 'calendar-minus-o'),
  (112, 'calendar-o'),
  (113, 'calendar-plus-o'),
  (114, 'calendar-times-o'),
  (115, 'camera'),
  (116, 'camera-retro'),
  (117, 'car'),
  (118, 'caret-down'),
  (119, 'caret-left'),
  (120, 'caret-right'),
  (121, 'caret-square-o-down'),
  (122, 'caret-square-o-left'),
  (123, 'caret-square-o-right'),
  (124, 'caret-square-o-up'),
  (125, 'caret-up'),
  (126, 'cart-arrow-down'),
  (127, 'cart-plus'),
  (128, 'cc'),
  (129, 'cc-amex'),
  (130, 'cc-diners-club'),
  (131, 'cc-discover'),
  (132, 'cc-jcb'),
  (133, 'cc-mastercard'),
  (134, 'cc-paypal'),
  (135, 'cc-stripe'),
  (136, 'cc-visa'),
  (137, 'certificate'),
  (138, 'chain'),
  (139, 'chain-broken'),
  (140, 'check'),
  (141, 'check-circle'),
  (142, 'check-circle-o'),
  (143, 'check-square'),
  (144, 'check-square-o'),
  (145, 'chevron-circle-down'),
  (146, 'chevron-circle-left'),
  (147, 'chevron-circle-right'),
  (148, 'chevron-circle-up'),
  (149, 'chevron-down'),
  (150, 'chevron-left'),
  (151, 'chevron-right'),
  (152, 'chevron-up'),
  (153, 'child'),
  (154, 'chrome'),
  (155, 'circle'),
  (156, 'circle-o'),
  (157, 'circle-o-notch'),
  (158, 'circle-thin'),
  (159, 'clipboard'),
  (160, 'clock-o'),
  (161, 'clone'),
  (162, 'close'),
  (163, 'cloud'),
  (164, 'cloud-download'),
  (165, 'cloud-upload'),
  (166, 'cny'),
  (167, 'code'),
  (168, 'code-fork'),
  (169, 'codepen'),
  (170, 'codiepie'),
  (171, 'coffee'),
  (172, 'cog'),
  (173, 'cogs'),
  (174, 'columns'),
  (175, 'comment'),
  (176, 'comment-o'),
  (177, 'commenting'),
  (178, 'commenting-o'),
  (179, 'comments'),
  (180, 'comments-o'),
  (181, 'compass'),
  (182, 'compress'),
  (183, 'connectdevelop'),
  (184, 'contao'),
  (185, 'copy'),
  (186, 'copyright'),
  (187, 'creative-commons'),
  (188, 'credit-card'),
  (189, 'credit-card-alt'),
  (190, 'crop'),
  (191, 'crosshairs'),
  (192, 'css3'),
  (193, 'cube'),
  (194, 'cubes'),
  (195, 'cut'),
  (196, 'cutlery'),
  (197, 'dashboard'),
  (198, 'dashcube'),
  (199, 'database'),
  (200, 'deaf'),
  (201, 'deafness'),
  (202, 'dedent'),
  (203, 'delicious'),
  (204, 'desktop'),
  (205, 'deviantart'),
  (206, 'diamond'),
  (207, 'digg'),
  (208, 'dollar'),
  (209, 'dot-circle-o'),
  (210, 'download'),
  (211, 'dribbble'),
  (212, 'drivers-license'),
  (213, 'drivers-license-o'),
  (214, 'dropbox'),
  (215, 'drupal'),
  (216, 'edge'),
  (217, 'edit'),
  (218, 'eercast'),
  (219, 'eject'),
  (220, 'ellipsis-h'),
  (221, 'ellipsis-v'),
  (222, 'empire'),
  (223, 'envelope'),
  (224, 'envelope-o'),
  (225, 'envelope-open'),
  (226, 'envelope-open-o'),
  (227, 'envelope-square'),
  (228, 'envira'),
  (229, 'eraser'),
  (230, 'etsy'),
  (231, 'eur'),
  (232, 'euro'),
  (233, 'exchange'),
  (234, 'exclamation'),
  (235, 'exclamation-circle'),
  (236, 'exclamation-triangle'),
  (237, 'expand'),
  (238, 'expeditedssl'),
  (239, 'external-link'),
  (240, 'external-link-square'),
  (241, 'eye'),
  (242, 'eye-slash'),
  (243, 'eyedropper'),
  (244, 'fa'),
  (245, 'facebook'),
  (246, 'facebook-f'),
  (247, 'facebook-official'),
  (248, 'facebook-square'),
  (249, 'fast-backward'),
  (250, 'fast-forward'),
  (251, 'fax'),
  (252, 'feed'),
  (253, 'female'),
  (254, 'fighter-jet'),
  (255, 'file'),
  (256, 'file-archive-o'),
  (257, 'file-audio-o'),
  (258, 'file-code-o'),
  (259, 'file-excel-o'),
  (260, 'file-image-o'),
  (261, 'file-movie-o'),
  (262, 'file-o'),
  (263, 'file-pdf-o'),
  (264, 'file-photo-o'),
  (265, 'file-picture-o'),
  (266, 'file-powerpoint-o'),
  (267, 'file-sound-o'),
  (268, 'file-text'),
  (269, 'file-text-o'),
  (270, 'file-video-o'),
  (271, 'file-word-o'),
  (272, 'file-zip-o'),
  (273, 'files-o'),
  (274, 'film'),
  (275, 'filter'),
  (276, 'fire'),
  (277, 'fire-extinguisher'),
  (278, 'firefox'),
  (279, 'first-order'),
  (280, 'flag'),
  (281, 'flag-checkered'),
  (282, 'flag-o'),
  (283, 'flash'),
  (284, 'flask'),
  (285, 'flickr'),
  (286, 'floppy-o'),
  (287, 'folder'),
  (288, 'folder-o'),
  (289, 'folder-open'),
  (290, 'folder-open-o'),
  (291, 'font'),
  (292, 'font-awesome'),
  (293, 'fonticons'),
  (294, 'fort-awesome'),
  (295, 'forumbee'),
  (296, 'forward'),
  (297, 'foursquare'),
  (298, 'free-code-camp'),
  (299, 'frown-o'),
  (300, 'futbol-o'),
  (301, 'gamepad'),
  (302, 'gavel'),
  (303, 'gbp'),
  (304, 'ge'),
  (305, 'gear'),
  (306, 'gears'),
  (307, 'genderless'),
  (308, 'get-pocket'),
  (309, 'gg'),
  (310, 'gg-circle'),
  (311, 'gift'),
  (312, 'git'),
  (313, 'git-square'),
  (314, 'github'),
  (315, 'github-alt'),
  (316, 'github-square'),
  (317, 'gitlab'),
  (318, 'gittip'),
  (319, 'glass'),
  (320, 'glide'),
  (321, 'glide-g'),
  (322, 'globe'),
  (323, 'google'),
  (324, 'google-plus'),
  (325, 'google-plus-circle'),
  (326, 'google-plus-official'),
  (327, 'google-plus-square'),
  (328, 'google-wallet'),
  (329, 'graduation-cap'),
  (330, 'gratipay'),
  (331, 'grav'),
  (332, 'group'),
  (333, 'h-square'),
  (334, 'hacker-news'),
  (335, 'hand-grab-o'),
  (336, 'hand-lizard-o'),
  (337, 'hand-o-down'),
  (338, 'hand-o-left'),
  (339, 'hand-o-right'),
  (340, 'hand-o-up'),
  (341, 'hand-paper-o'),
  (342, 'hand-peace-o'),
  (343, 'hand-pointer-o'),
  (344, 'hand-rock-o'),
  (345, 'hand-scissors-o'),
  (346, 'hand-spock-o'),
  (347, 'hand-stop-o'),
  (348, 'handshake-o'),
  (349, 'hard-of-hearing'),
  (350, 'hashtag'),
  (351, 'hdd-o'),
  (352, 'header'),
  (353, 'headphones'),
  (354, 'heart'),
  (355, 'heart-o'),
  (356, 'heartbeat'),
  (357, 'history'),
  (358, 'home'),
  (359, 'hospital-o'),
  (360, 'hotel'),
  (361, 'hourglass'),
  (362, 'hourglass-1'),
  (363, 'hourglass-2'),
  (364, 'hourglass-3'),
  (365, 'hourglass-end'),
  (366, 'hourglass-half'),
  (367, 'hourglass-o'),
  (368, 'hourglass-start'),
  (369, 'houzz'),
  (370, 'html5'),
  (371, 'i-cursor'),
  (372, 'id-badge'),
  (373, 'id-card'),
  (374, 'id-card-o'),
  (375, 'ils'),
  (376, 'image'),
  (377, 'imdb'),
  (378, 'inbox'),
  (379, 'indent'),
  (380, 'industry'),
  (381, 'info'),
  (382, 'info-circle'),
  (383, 'inr'),
  (384, 'instagram'),
  (385, 'institution'),
  (386, 'internet-explorer'),
  (387, 'intersex'),
  (388, 'ioxhost'),
  (389, 'italic'),
  (390, 'joomla'),
  (391, 'jpy'),
  (392, 'jsfiddle'),
  (393, 'key'),
  (394, 'keyboard-o'),
  (395, 'krw'),
  (396, 'language'),
  (397, 'laptop'),
  (398, 'lastfm'),
  (399, 'lastfm-square'),
  (400, 'leaf'),
  (401, 'leanpub'),
  (402, 'legal'),
  (403, 'lemon-o'),
  (404, 'level-down'),
  (405, 'level-up'),
  (406, 'life-bouy'),
  (407, 'life-buoy'),
  (408, 'life-ring'),
  (409, 'life-saver'),
  (410, 'lightbulb-o'),
  (411, 'line-chart'),
  (412, 'link'),
  (413, 'linkedin'),
  (414, 'linkedin-square'),
  (415, 'linode'),
  (416, 'linux'),
  (417, 'list'),
  (418, 'list-alt'),
  (419, 'list-ol'),
  (420, 'list-ul'),
  (421, 'location-arrow'),
  (422, 'lock'),
  (423, 'long-arrow-down'),
  (424, 'long-arrow-left'),
  (425, 'long-arrow-right'),
  (426, 'long-arrow-up'),
  (427, 'low-vision'),
  (428, 'magic'),
  (429, 'magnet'),
  (430, 'mail-forward'),
  (431, 'mail-reply'),
  (432, 'mail-reply-all'),
  (433, 'male'),
  (434, 'map'),
  (435, 'map-marker'),
  (436, 'map-o'),
  (437, 'map-pin'),
  (438, 'map-signs'),
  (439, 'mars'),
  (440, 'mars-double'),
  (441, 'mars-stroke'),
  (442, 'mars-stroke-h'),
  (443, 'mars-stroke-v'),
  (444, 'maxcdn'),
  (445, 'meanpath'),
  (446, 'medium'),
  (447, 'medkit'),
  (448, 'meetup'),
  (449, 'meh-o'),
  (450, 'mercury'),
  (451, 'microchip'),
  (452, 'microphone'),
  (453, 'microphone-slash'),
  (454, 'minus'),
  (455, 'minus-circle'),
  (456, 'minus-square'),
  (457, 'minus-square-o'),
  (458, 'mixcloud'),
  (459, 'mobile'),
  (460, 'mobile-phone'),
  (461, 'modx'),
  (462, 'money'),
  (463, 'moon-o'),
  (464, 'mortar-board'),
  (465, 'motorcycle'),
  (466, 'mouse-pointer'),
  (467, 'music'),
  (468, 'navicon'),
  (469, 'neuter'),
  (470, 'newspaper-o'),
  (471, 'object-group'),
  (472, 'object-ungroup'),
  (473, 'odnoklassniki'),
  (474, 'odnoklassniki-square'),
  (475, 'opencart'),
  (476, 'openid'),
  (477, 'opera'),
  (478, 'optin-monster'),
  (479, 'outdent'),
  (480, 'pagelines'),
  (481, 'paint-brush'),
  (482, 'paper-plane'),
  (483, 'paper-plane-o'),
  (484, 'paperclip'),
  (485, 'paragraph'),
  (486, 'paste'),
  (487, 'pause'),
  (488, 'pause-circle'),
  (489, 'pause-circle-o'),
  (490, 'paw'),
  (491, 'paypal'),
  (492, 'pencil'),
  (493, 'pencil-square'),
  (494, 'pencil-square-o'),
  (495, 'percent'),
  (496, 'phone'),
  (497, 'phone-square'),
  (498, 'photo'),
  (499, 'picture-o'),
  (500, 'pie-chart'),
  (501, 'pied-piper'),
  (502, 'pied-piper-alt'),
  (503, 'pied-piper-pp'),
  (504, 'pinterest'),
  (505, 'pinterest-p'),
  (506, 'pinterest-square'),
  (507, 'plane'),
  (508, 'play'),
  (509, 'play-circle'),
  (510, 'play-circle-o'),
  (511, 'plug'),
  (512, 'plus'),
  (513, 'plus-circle'),
  (514, 'plus-square'),
  (515, 'plus-square-o'),
  (516, 'podcast'),
  (517, 'power-off'),
  (518, 'print'),
  (519, 'product-hunt'),
  (520, 'puzzle-piece'),
  (521, 'qq'),
  (522, 'qrcode'),
  (523, 'question'),
  (524, 'question-circle'),
  (525, 'question-circle-o'),
  (526, 'quora'),
  (527, 'quote-left'),
  (528, 'quote-right'),
  (529, 'ra'),
  (530, 'random'),
  (531, 'ravelry'),
  (532, 'rebel'),
  (533, 'recycle'),
  (534, 'reddit'),
  (535, 'reddit-alien'),
  (536, 'reddit-square'),
  (537, 'refresh'),
  (538, 'registered'),
  (539, 'remove'),
  (540, 'renren'),
  (541, 'reorder'),
  (542, 'repeat'),
  (543, 'reply'),
  (544, 'reply-all'),
  (545, 'resistance'),
  (546, 'retweet'),
  (547, 'rmb'),
  (548, 'road'),
  (549, 'rocket'),
  (550, 'rotate-left'),
  (551, 'rotate-right'),
  (552, 'rouble'),
  (553, 'rss'),
  (554, 'rss-square'),
  (555, 'rub'),
  (556, 'ruble'),
  (557, 'rupee'),
  (558, 's15'),
  (559, 'safari'),
  (560, 'save'),
  (561, 'scissors'),
  (562, 'scribd'),
  (563, 'search'),
  (564, 'search-minus'),
  (565, 'search-plus'),
  (566, 'sellsy'),
  (567, 'send'),
  (568, 'send-o'),
  (569, 'server'),
  (570, 'share'),
  (571, 'share-alt'),
  (572, 'share-alt-square'),
  (573, 'share-square'),
  (574, 'share-square-o'),
  (575, 'shekel'),
  (576, 'sheqel'),
  (577, 'shield'),
  (578, 'ship'),
  (579, 'shirtsinbulk'),
  (580, 'shopping-bag'),
  (581, 'shopping-basket'),
  (582, 'shopping-cart'),
  (583, 'shower'),
  (584, 'sign-in'),
  (585, 'sign-language'),
  (586, 'sign-out'),
  (587, 'signal'),
  (588, 'signing'),
  (589, 'simplybuilt'),
  (590, 'sitemap'),
  (591, 'skyatlas'),
  (592, 'skype'),
  (593, 'slack'),
  (594, 'sliders'),
  (595, 'slideshare'),
  (596, 'smile-o'),
  (597, 'snapchat'),
  (598, 'snapchat-ghost'),
  (599, 'snapchat-square'),
  (600, 'snowflake-o'),
  (601, 'soccer-ball-o'),
  (602, 'sort'),
  (603, 'sort-alpha-asc'),
  (604, 'sort-alpha-desc'),
  (605, 'sort-amount-asc'),
  (606, 'sort-amount-desc'),
  (607, 'sort-asc'),
  (608, 'sort-desc'),
  (609, 'sort-down'),
  (610, 'sort-numeric-asc'),
  (611, 'sort-numeric-desc'),
  (612, 'sort-up'),
  (613, 'soundcloud'),
  (614, 'space-shuttle'),
  (615, 'spinner'),
  (616, 'spoon'),
  (617, 'spotify'),
  (618, 'square'),
  (619, 'square-o'),
  (620, 'stack-exchange'),
  (621, 'stack-overflow'),
  (622, 'star'),
  (623, 'star-half'),
  (624, 'star-half-empty'),
  (625, 'star-half-full'),
  (626, 'star-half-o'),
  (627, 'star-o'),
  (628, 'steam'),
  (629, 'steam-square'),
  (630, 'step-backward'),
  (631, 'step-forward'),
  (632, 'stethoscope'),
  (633, 'sticky-note'),
  (634, 'sticky-note-o'),
  (635, 'stop'),
  (636, 'stop-circle'),
  (637, 'stop-circle-o'),
  (638, 'street-view'),
  (639, 'strikethrough'),
  (640, 'stumbleupon'),
  (641, 'stumbleupon-circle'),
  (642, 'subscript'),
  (643, 'subway'),
  (644, 'suitcase'),
  (645, 'sun-o'),
  (646, 'superpowers'),
  (647, 'superscript'),
  (648, 'support'),
  (649, 'table'),
  (650, 'tablet'),
  (651, 'tachometer'),
  (652, 'tag'),
  (653, 'tags'),
  (654, 'tasks'),
  (655, 'taxi'),
  (656, 'telegram'),
  (657, 'television'),
  (658, 'tencent-weibo'),
  (659, 'terminal'),
  (660, 'text-height'),
  (661, 'text-width'),
  (662, 'th'),
  (663, 'th-large'),
  (664, 'th-list'),
  (665, 'themeisle'),
  (666, 'thermometer'),
  (667, 'thermometer-0'),
  (668, 'thermometer-1'),
  (669, 'thermometer-2'),
  (670, 'thermometer-3'),
  (671, 'thermometer-4'),
  (672, 'thermometer-empty'),
  (673, 'thermometer-full'),
  (674, 'thermometer-half'),
  (675, 'thermometer-quarter'),
  (676, 'thermometer-three-quarters'),
  (677, 'thumb-tack'),
  (678, 'thumbs-down'),
  (679, 'thumbs-o-down'),
  (680, 'thumbs-o-up'),
  (681, 'thumbs-up'),
  (682, 'ticket'),
  (683, 'times'),
  (684, 'times-circle'),
  (685, 'times-circle-o'),
  (686, 'times-rectangle'),
  (687, 'times-rectangle-o'),
  (688, 'tint'),
  (689, 'toggle-down'),
  (690, 'toggle-left'),
  (691, 'toggle-off'),
  (692, 'toggle-on'),
  (693, 'toggle-right'),
  (694, 'toggle-up'),
  (695, 'trademark'),
  (696, 'train'),
  (697, 'transgender'),
  (698, 'transgender-alt'),
  (699, 'trash'),
  (700, 'trash-o'),
  (701, 'tree'),
  (702, 'trello'),
  (703, 'tripadvisor'),
  (704, 'trophy'),
  (705, 'truck'),
  (706, 'try'),
  (707, 'tty'),
  (708, 'tumblr'),
  (709, 'tumblr-square'),
  (710, 'turkish-lira'),
  (711, 'tv'),
  (712, 'twitch'),
  (713, 'twitter'),
  (714, 'twitter-square'),
  (715, 'umbrella'),
  (716, 'underline'),
  (717, 'undo'),
  (718, 'universal-access'),
  (719, 'university'),
  (720, 'unlink'),
  (721, 'unlock'),
  (722, 'unlock-alt'),
  (723, 'unsorted'),
  (724, 'upload'),
  (725, 'usb'),
  (726, 'usd'),
  (727, 'user'),
  (728, 'user-circle'),
  (729, 'user-circle-o'),
  (730, 'user-md'),
  (731, 'user-o'),
  (732, 'user-plus'),
  (733, 'user-secret'),
  (734, 'user-times'),
  (735, 'users'),
  (736, 'vcard'),
  (737, 'vcard-o'),
  (738, 'venus'),
  (739, 'venus-double'),
  (740, 'venus-mars'),
  (741, 'viacoin'),
  (742, 'viadeo'),
  (743, 'viadeo-square'),
  (744, 'video-camera'),
  (745, 'vimeo'),
  (746, 'vimeo-square'),
  (747, 'vine'),
  (748, 'vk'),
  (749, 'volume-control-phone'),
  (750, 'volume-down'),
  (751, 'volume-off'),
  (752, 'volume-up'),
  (753, 'warning'),
  (754, 'wechat'),
  (755, 'weibo'),
  (756, 'weixin'),
  (757, 'whatsapp'),
  (758, 'wheelchair'),
  (759, 'wheelchair-alt'),
  (760, 'wifi'),
  (761, 'wikipedia-w'),
  (762, 'window-close'),
  (763, 'window-close-o'),
  (764, 'window-maximize'),
  (765, 'window-minimize'),
  (766, 'window-restore'),
  (767, 'windows'),
  (768, 'won'),
  (769, 'wordpress'),
  (770, 'wpbeginner'),
  (771, 'wpexplorer'),
  (772, 'wpforms'),
  (773, 'wrench'),
  (774, 'xing'),
  (775, 'xing-square'),
  (776, 'y-combinator'),
  (777, 'y-combinator-square'),
  (778, 'yahoo'),
  (779, 'yc'),
  (780, 'yc-square'),
  (781, 'yelp'),
  (782, 'yen'),
  (783, 'yoast'),
  (784, 'youtube'),
  (785, 'youtube-play'),
  (786, 'youtube-square');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`, `datetime`, `active`) VALUES
  (1, 'My Library', 'Default', CURRENT_TIMESTAMP(), 'true');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `attempts` int(11) NOT NULL,
  `ip` text CHARACTER SET utf8 NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `url` text NOT NULL,
  `guid` text NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `section` text NOT NULL,
  `active` text NOT NULL,
  `win` text NOT NULL,
  `loc_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `guid` text NOT NULL,
  `keywords` text NOT NULL,
  `active` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sections_customers`
--

CREATE TABLE `sections_customers` (
  `id` int(11) NOT NULL,
  `heading` mediumtext NOT NULL,
  `content` mediumtext NOT NULL,
  `section` mediumtext NOT NULL,
  `guid` text NOT NULL,
  `use_defaults` mediumtext NOT NULL,
  `author_name` mediumtext NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `guid` text NOT NULL,
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
  `servicescontent` text NOT NULL,
  `teamcontent` text NOT NULL,
  `slider_use_defaults` text NOT NULL,
  `navigation_use_defaults_1` text NOT NULL,
  `navigation_use_defaults_2` text NOT NULL,
  `navigation_use_defaults_3` text NOT NULL,
  `services_use_defaults` text NOT NULL,
  `team_use_defaults` text NOT NULL,
  `hottitles_use_defaults` text NOT NULL,
  `logo_use_defaults` text NOT NULL,
  `theme_use_defaults` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `title`, `keywords`, `description`, `config`, `logo`, `ls2pac`, `ls2kids`, `searchdefault`, `author`, `pageheading`, `servicesheading`, `sliderheading`, `teamheading`, `hottitlesheading`, `servicescontent`, `teamcontent`, `slider_use_defaults`, `navigation_use_defaults_1`, `navigation_use_defaults_2`, `navigation_use_defaults_3`, `services_use_defaults`, `team_use_defaults`, `hottitles_use_defaults`, `logo_use_defaults`, `theme_use_defaults`, `datetime`, `author_name`, `loc_id`) VALUES
  (1, 'My Library', '', '', 'ysm', '', 'false', 'false', 0, '', 'Pages', 'Services', 'Slides', 'Meet the Team', 'New Titles', '', '', 'false', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', CURRENT_TIMESTAMP(), 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `orig_file_name` text NOT NULL,
  `file_name` text NOT NULL,
  `file_data` longblob,
  `file_ext` text NOT NULL,
  `file_mime` text NOT NULL,
  `shared` text,
  `file_size` int(11) NOT NULL,
  `guid` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_name` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `guid` text NOT NULL,
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
  `guid` text NOT NULL,
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
  `password_reset` text NOT NULL,
  `password_reset_date` date NOT NULL,
  `email` text NOT NULL,
  `level` int(11) NOT NULL,
  `guid` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clientip` text NOT NULL,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `theme_options`
--

CREATE TABLE `theme_options` (
  `id` int(11) NOT NULL,
  `themename` text NOT NULL,
  `selector` text NOT NULL,
  `property` text NOT NULL,
  `cssvalue` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `loc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `theme_options`
--
ALTER TABLE `theme_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_options_loc_id_fk` (`loc_id`);

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_loc_id_fk` (`loc_id`);

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
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
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
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `sections_customers`
--
ALTER TABLE `sections_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_customers_loc_id_fk` (`loc_id`);

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
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploads_loc_id_fk` (`loc_id`);

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
-- AUTO_INCREMENT for table `theme_options`
--
ALTER TABLE `theme_options`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sections_customers`
--
ALTER TABLE `sections_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `socialmedia`
--
ALTER TABLE `socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

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
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `sections_customers`
--
ALTER TABLE `sections_customers`
  ADD CONSTRAINT `sections_customers_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `theme_options`
--
ALTER TABLE `theme_options`
  ADD CONSTRAINT `theme_options_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_loc_id_fk` FOREIGN KEY (`loc_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
