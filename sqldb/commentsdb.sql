

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database: `commentsdb`

-- Table structure for table `maincomments`

CREATE TABLE IF NOT EXISTS `maincomments` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


-- Table structure for table `othercomments`

CREATE TABLE IF NOT EXISTS `othercomments` (
`id` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;


-- Table structure for table `users`

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `fname` varchar(233) NOT NULL,
  `lname` varchar(233) NOT NULL,
  `email` varchar(233) NOT NULL,
  `password` varchar(233) NOT NULL,
  `date` varchar(233) NOT NULL,
  `user_ip` varchar(233) NOT NULL,
  `activation_code` varchar(233) NOT NULL,
  `ctime` varchar(233) NOT NULL,
  `ckey` varchar(233) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


-- Indexes for dumped tables


-- Indexes for table `maincomments`

ALTER TABLE `maincomments`
 ADD PRIMARY KEY (`id`);

-- Indexes for table `othercomments`

ALTER TABLE `othercomments`
 ADD PRIMARY KEY (`id`);

-- Indexes for table `users`

ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);



-- AUTO_INCREMENT for table `maincomments`

ALTER TABLE `maincomments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;

-- AUTO_INCREMENT for table `othercomments`

ALTER TABLE `othercomments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;

-- AUTO_INCREMENT for table `users`

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;

