DROP TABLE IF EXISTS `blogs`;

CREATE TABLE `blogs` (
  `blog_no` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idusers` bigint unsigned DEFAULT NULL,
  `blog_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`blog_no`),
  KEY `blogs_idusers_index` (`idusers`),
  CONSTRAINT `blogs_idusers_foreign` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `blogs` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `idusers` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usermail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userdp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification` tinyint NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idusers`),
  UNIQUE KEY `users_usermail_unique` (`usermail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`idusers`,`username`,`usermail`,`gender`,`userdp`,`verification`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Joelle Dunlap','detinahoj@mailinator.com','male',NULL,0,NULL,'$2y$10$PzS3X2WrjohEsbdShXN0uOwtF0kxjiFblZzNu/sBr0/7oVtGd4DUy',NULL,NULL,NULL);
