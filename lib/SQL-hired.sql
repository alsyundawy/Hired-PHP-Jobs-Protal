CREATE TABLE `companies` (
  `company_id` bigint(20) NOT NULL,
  `company_slug` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_desc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `jobs` (
  `job_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_desc` longtext NOT NULL,
  `job_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `options` (
  `option_name` varchar(255) NOT NULL,
  `option_description` varchar(255) DEFAULT NULL,
  `option_value` varchar(255) NOT NULL,
  `option_group` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `password_reset` (
  `user_id` bigint(20) NOT NULL,
  `reset_hash` varchar(64) NOT NULL,
  `reset_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_role` varchar(1) NOT NULL DEFAULT 'U',
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `company_slug` (`company_slug`),
  ADD KEY `company_name` (`company_name`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `job_title` (`job_title`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `job_status` (`job_status`);

ALTER TABLE `options`
  ADD PRIMARY KEY (`option_name`),
  ADD KEY `option_group` (`option_group`);

ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_role` (`user_role`);

ALTER TABLE `companies`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `jobs`
  MODIFY `job_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `options` (`option_name`, `option_description`, `option_value`, `option_group`) VALUES
  ('EMAIL_FROM', 'System email from.', 'sys@site.com', 1),
  ('PAGE_PER', 'Number of entries per page.', '25', 1);
