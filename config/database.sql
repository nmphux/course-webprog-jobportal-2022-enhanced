CREATE DATABASE IF NOT EXISTS `job_portal_db`;
USE `job_portal_db`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =========================================================
-- Normalized Job Portal Schema (English entities)
-- =========================================================

-- ---------------------------------------------------------
-- Table: users
-- ---------------------------------------------------------

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT 0 COMMENT '0=job seeker, 1=employer',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about_me` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Admin User', 'admin@jobportal.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 3),
(2, 'Vo Hoang Nhat Anh', 'seeker1@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 0),
(3, 'Cao Thi Quynh Dao', 'seeker2@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 0),
(4, 'Nguyen Minh Quan', 'employer1@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(5, 'Rajesh Sharma', 'employer2@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(6, 'John Smith', 'employer3@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(7, 'Hans Weber', 'employer4@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(8, 'Tran Thu Ha', 'employer5@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(9, 'Priya Patel', 'employer6@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(10, 'Emily Davis', 'employer7@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(11, 'Pierre Dubois', 'employer8@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(12, 'Le Hoang Nam', 'employer9@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(13, 'Amit Kumar', 'employer10@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(14, 'Michael Johnson', 'employer11@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1),
(15, 'Charlotte Walker', 'employer12@gmail.com', '$2y$10$qK43gSZ1wvOdOMthO3hqPOYoz5Si4/WRmhLNSBnDntPHxQt72WunS', 1);

-- ---------------------------------------------------------
-- Table: companies
-- ---------------------------------------------------------

CREATE TABLE `companies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `slogan` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_size` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `founded_year` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `companies` (`id`, `name`, `slogan`, `logo`, `city`, `address`, `email`, `description`, `website`, `company_size`, `founded_year`) VALUES
(1, 'FPT Software', 'Technology For A Better Life', 'company_logos/samples/FPTSoftware.png', 'Ha Noi', '17 Duy Tan, Cau Giay District, Ha Noi', 'careers@fpt.com', 'Vietnam''s largest IT services company and a subsidiary of FPT Corporation, serving over 1,000 global clients including nearly 100 Fortune 500 companies. Specializes in cloud, AI, data analytics, IoT, and digital platforms.', 'https://fptsoftware.com', '5000+', 1999),
(2, 'VNG Corporation', 'A Leading Technology Ecosystem', NULL, 'Ho Chi Minh', 'Z06, Tan Thuan Export Processing Zone, District 7, Ho Chi Minh City', 'hr@vng.com.vn', 'Vietnam''s first tech unicorn. Owns Zalo (75M+ users), ZaloPay, and a major gaming platform. Active in AI research, cloud services, and fintech.', 'https://www.vng.com.vn', '5000+', 2004),
(3, 'CMC Corporation', 'Leading Digital Transformation', NULL, 'Ha Noi', 'CMC Tower, Duy Tan Street, Cau Giay District, Ha Noi', 'info@cmc.com.vn', 'One of Vietnam''s largest technology groups with 5,000+ employees, operating in IT services, cloud computing, cybersecurity, and telecommunications.', 'https://www.cmc.com.vn', '5000+', 1993),
(4, 'KMS Technology', 'Co-innovation for a Better Future', NULL, 'Ho Chi Minh', 'Etown 2 Building, 364 Cong Hoa, Tan Binh District, Ho Chi Minh City', 'info@kms-technology.com', 'Leading software services company providing custom development, QA testing, and digital transformation consulting to global enterprises.', 'https://kms-technology.com', '1000-5000', 2009),
(5, 'NashTech', 'Enabling Business Transformation Through Technology', NULL, 'Ho Chi Minh', 'Etown Central, 11 Doan Van Bo, District 4, Ho Chi Minh City', 'info@nashtechglobal.com', 'UK-headquartered tech company with 2,000+ professionals in Vietnam, delivering enterprise software, cloud migration, and data engineering solutions.', 'https://www.nashtechglobal.com', '1000-5000', 2000),
(6, 'TECHVIFY Software', 'Leading Global AI & Software Consulting', NULL, 'Ha Noi', 'Detech Building, 8 Ton That Thuyet, Nam Tu Liem District, Ha Noi', 'contact@techvify.com.vn', 'Fast-growing AI and software consulting firm with 500+ developers and AI specialists across offices in Vietnam, Japan, and the US.', 'https://techvify.com', '500-1000', 2018),
(7, 'Samsung Vietnam R&D Center', 'Inspire the World, Create the Future', 'company_logos/samples/samsung.png', 'Ho Chi Minh', 'SHTP, Thu Duc City, Ho Chi Minh City', 'hr.svmc@samsung.com', 'Samsung''s largest R&D center outside Korea, focusing on mobile software, AI, 5G, and semiconductor design.', 'https://www.samsung.com/vn/', '5000+', 2012),
(8, 'MoMo (M_Service)', 'Vietnam''s Leading Super App', NULL, 'Ho Chi Minh', 'TNR Building, 180-192 Nguyen Cong Tru, District 1, Ho Chi Minh City', 'careers@momo.vn', 'Vietnam''s top fintech super app with 31M+ users, offering mobile payments, financial services, and lifestyle features.', 'https://momo.vn', '1000-5000', 2007),
(9, 'Tiki Corporation', 'Fast & Reliable E-Commerce', NULL, 'Ho Chi Minh', '52 Ut Tich, Tan Binh District, Ho Chi Minh City', 'careers@tiki.vn', 'One of Vietnam''s largest e-commerce platforms, known for fast delivery (TikiNOW) and a strong engineering team building logistics and recommendation systems.', 'https://tiki.vn', '1000-5000', 2010),
(10, 'Viettel Software', 'Pioneering Digital Society', NULL, 'Ha Noi', 'Viettel Building, 1 Giang Van Minh, Ba Dinh District, Ha Noi', 'info@viettelsoftware.vn', 'The software arm of Viettel Group (Vietnam''s largest telecom), developing e-government platforms, cybersecurity solutions, and AI/ML products.', 'https://viettelsoftware.vn', '5000+', 2018),
(11, 'MISA Software', 'Empowering Vietnamese Businesses', 'company_logos/samples/misa_software.jpg', 'Ha Noi', 'N03-T1, Diplomatic Quarter, Xuan Dinh Ward, Bac Tu Liem District, Ha Noi', 'hr@misa.com.vn', 'Vietnam''s leading enterprise software company specializing in accounting, ERP, and business management SaaS products used by 250,000+ businesses.', 'https://www.misa.vn', '1000-5000', 1994),
(12, 'NTT DATA Vietnam', 'Trusted Global Innovator', 'company_logos/samples/NTTDATA.jpg', 'Da Nang', 'Vietinbank Building, 36 Tran Quoc Toan, Hai Chau District, Da Nang', 'careers.vn@nttdata.com', 'Japanese IT giant''s Vietnam branch providing consulting, system integration, and managed services for automotive, finance, and telecom sectors.', 'https://www.nttdata.com', '1000-5000', 2006),
(13, 'Axon Active Vietnam', 'Passion for Quality Software', NULL, 'Da Nang', 'Vinh Trung Plaza, 255-257 Hung Vuong, Thanh Khe District, Da Nang', 'info@axonactive.com', 'Swiss software company with development centers in Vietnam, specializing in Agile software development, cloud-native apps, and DevOps.', 'https://www.axonactive.com', '200-500', 2008),
(14, 'Saigon Technology', 'Quality-Driven Software Development', NULL, 'Ho Chi Minh', 'Flemington Building, 182 Le Dai Hanh, District 11, Ho Chi Minh City', 'info@saigontechnology.com', 'ISO-certified custom software development company serving global clients in healthcare, fintech, logistics, and e-commerce.', 'https://saigontechnology.com', '200-500', 2012),
(15, 'Orient Software', 'Your Trusted Technology Partner', NULL, 'Ho Chi Minh', 'CirCO Building, 222 Dien Bien Phu, District 3, Ho Chi Minh City', 'info@orientsoftware.com', 'Award-winning outsourcing firm with 350+ engineers, ranked in Financial Times'' Top 500 High Growth Companies Asia Pacific.', 'https://www.orientsoftware.com', '200-500', 2005),
(16, 'Designveloper', 'We Build Your Ideas', NULL, 'Ho Chi Minh', '33 D52 Street, Tan Binh District, Ho Chi Minh City', 'info@designveloper.com', 'Full-service software development agency specializing in web/mobile apps, blockchain solutions, and AI integration.', 'https://www.designveloper.com', '50-200', 2013),
(17, 'mgm technology partners Vietnam', 'Software Engineers to the Bones', 'company_logos/samples/TopDev-mgm-logo-1659328798.png', 'Da Nang', '7 Phan Chau Trinh, Hai Chau District, Da Nang', 'careers.vn@mgm-tp.com', 'German software company building enterprise platforms for Fortune 100 insurance and travel clients. Strong frontend and fullstack engineering culture.', 'https://www.mgm-tp.com', '200-500', 1994),
(18, 'Positive Thinking Company', 'Global Independent Tech Consultancy', 'company_logos/samples/positive.png', 'Ha Noi', 'TNR Tower, 54A Nguyen Chi Thanh, Dong Da District, Ha Noi', 'careers@positivethinking.tech', 'International tech consultancy delivering modern web applications, CMS integrations, and cloud-native solutions using React, GraphQL, and headless architectures.', 'https://positivethinking.tech', '1000-5000', 2009),
(19, 'Golden Gate Group (Technology Division)', 'The First F&B Choice', 'company_logos/samples/TopDev-goldengate-1669279966.png', 'Ha Noi', '315 Truong Chinh, Thanh Xuan District, Ha Noi', 'tech@ggg.com.vn', 'Vietnam''s largest F&B group with 400+ restaurants. Their tech division builds internal POS systems, supply chain platforms, and customer-facing mobile apps.', 'https://ggg.com.vn', '5000+', 2005),
(20, 'Shopee Vietnam (SEA Group)', 'Here For Every Stage of Your Life', NULL, 'Ho Chi Minh', 'Mapletree Business Centre, 1060 Nguyen Van Linh, District 7, Ho Chi Minh City', 'careers@shopee.vn', 'Southeast Asia''s leading e-commerce platform, with a large engineering hub in Vietnam working on search, recommendations, payments, and logistics.', 'https://shopee.vn', '5000+', 2015);

-- ---------------------------------------------------------
-- Table: categories
-- ---------------------------------------------------------

CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Backend Developer', 'backend-developer'),
(2, 'Frontend Developer', 'frontend-developer'),
(3, 'Fullstack Developer', 'fullstack-developer'),
(4, 'Mobile Developer', 'mobile-developer'),
(5, 'DevOps / SRE Engineer', 'devops-sre-engineer'),
(6, 'Data Engineer', 'data-engineer'),
(7, 'AI / Machine Learning Engineer', 'ai-ml-engineer'),
(8, 'QA / Test Engineer', 'qa-test-engineer'),
(9, 'Business Analyst', 'business-analyst'),
(10, 'Project Manager', 'project-manager'),
(11, 'UI / UX Designer', 'ui-ux-designer'),
(12, 'Cloud / Platform Engineer', 'cloud-platform-engineer'),
(13, 'Cybersecurity Engineer', 'cybersecurity-engineer'),
(14, 'Embedded / IoT Engineer', 'embedded-iot-engineer');

-- ---------------------------------------------------------
-- Table: skill_categories
-- ---------------------------------------------------------

CREATE TABLE `skill_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `skill_categories` (`id`, `name`) VALUES
(1, 'Software Engineering'),
(2, 'AI & Machine Learning'),
(3, 'IT Infrastructure'),
(4, 'Cybersecurity'),
(5, 'Data Science & Mathematics'),
(6, 'Engineering'),
(7, 'Physical Sciences'),
(8, 'Life Sciences'),
(9, 'Medical & Healthcare'),
(10, 'Architecture & Urban Planning'),
(11, 'Environmental Science'),
(12, 'Business & Management'),
(13, 'Design & User Experience'),
(14, 'Writing & Linguistics'),
(15, 'Education & Teaching'),
(16, 'Other');

-- ---------------------------------------------------------
-- Table: skills
-- ---------------------------------------------------------

CREATE TABLE `skills` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `fk_skill_category` (`category_id`),
  CONSTRAINT `fk_skill_category` FOREIGN KEY (`category_id`) REFERENCES `skill_categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `skills` (`id`, `name`, `category_id`) VALUES
-- 1. Software Engineering
(18, 'Python', 1),
(19, 'JavaScript', 1),
(20, 'TypeScript', 1),
(21, 'Java', 1),
(22, 'C/C++', 1),
(23, 'C#', 1),
(24, 'Go', 1),
(25, 'Rust', 1),
(26, 'PHP', 1),
(27, 'Ruby', 1),
(28, 'Swift', 1),
(29, 'Kotlin', 1),
(30, 'SQL', 1),
(31, 'Bash / Shell Scripting', 1),
(32, 'MATLAB', 1),
(33, 'R', 1),
(34, 'Scala', 1),
(35, 'Solidity', 1),
(36, 'Lua', 1),
(37, 'Haskell', 1),
(38, 'Objective-C', 1),
(39, 'React', 1),
(40, 'Vue.js', 1),
(41, 'Angular', 1),
(42, 'Next.js', 1),
(43, 'Node.js', 1),
(44, '.NET', 1),
(45, 'Spring Boot', 1),
(46, 'Django', 1),
(47, 'FastAPI', 1),
(48, 'Laravel', 1),
(49, 'Flutter', 1),
(50, 'React Native', 1),

-- 2. Artificial Intelligence & Machine Learning
(51, 'LLM / GenAI', 2),
(52, 'Machine Learning', 2),
(53, 'Deep Learning', 2),
(54, 'PyTorch', 2),
(55, 'TensorFlow', 2),
(56, 'Natural Language Processing', 2),
(57, 'Computer Vision', 2),
(58, 'Data Engineering', 2),
(59, 'Spark', 2),
(60, 'Airflow', 2),
(61, 'dbt', 2),

-- 3. IT Foundation & Infrastructure
(1, 'Linux', 3),
(2, 'Git', 3),
(3, 'Docker', 3),
(4, 'Kubernetes', 3),
(5, 'AWS', 3),
(6, 'Azure', 3),
(7, 'GCP', 3),
(8, 'Terraform', 3),
(9, 'CI/CD', 3),
(10, 'PostgreSQL', 3),
(11, 'MySQL', 3),
(12, 'MongoDB', 3),
(13, 'Redis', 3),
(14, 'GraphQL', 3),
(15, 'REST API', 3),
(16, 'Kafka', 3),
(17, 'Elasticsearch', 3),

-- 4. Cybersecurity
(62, 'Cloud Security', 4),
(63, 'Application Security', 4),
(64, 'Network Security', 4),
(65, 'Incident Response & Forensics', 4),
(66, 'Security Compliance & Governance', 4),

-- 5. Data Science & Mathematics
(67, 'Data Science', 5),
(68, 'Statistics', 5),
(69, 'Probability', 5),
(70, 'Applied Mathematics', 5),
(71, 'Calculus', 5),
(72, 'Linear Algebra', 5),
(73, 'Algebra', 5),
(74, 'Discrete Mathematics', 5),
(75, 'Number Theory', 5),
(76, 'Trigonometry', 5),

-- 6. Engineering
(77, 'Mechanical Engineering', 6),
(78, 'Electrical Engineering', 6),
(79, 'Civil Engineering', 6),
(80, 'Biomedical Engineering', 6),
(81, 'Aerospace Engineering', 6),
(82, 'Chemical Engineering', 6),
(83, 'Industrial Engineering', 6),
(84, 'Environmental Engineering', 6),

-- 7. Physical Sciences
(85, 'Physics', 7),
(86, 'Quantum Physics', 7),
(87, 'Astrophysics', 7),
(88, 'Astronomers', 7),
(89, 'Chemistry', 7),
(90, 'Organic Chemistry', 7),
(91, 'Analytical Chemistry', 7),
(92, 'Materials Science', 7),
(93, 'Geoscience & Geology', 7),

-- 8. Life Sciences
(94, 'Genetics & Genomics', 8),
(95, 'Neuroscience', 8),
(96, 'Biochemists and Biophysicists', 8),
(97, 'Biologists', 8),
(98, 'Microbiologists', 8),
(99, 'Medical Scientists', 8),
(100, 'Epidemiologists', 8),
(101, 'Marine Biology', 8),

-- 9. Medical & Healthcare
(102, 'Physician (All Specialties)', 9),
(103, 'Surgeon (All Specialties)', 9),
(104, 'Registered Nurses', 9),
(105, 'Physician Assistants / Nurse Practitioners', 9),
(106, 'Emergency Medicine', 9),
(107, 'Radiology & Imaging', 9),
(108, 'Psychiatry', 9),
(109, 'Pharmacists', 9),
(110, 'Dentists / Orthodontists / OMS', 9),
(111, 'Health Informatics', 9),
(112, 'Public Health', 9),
(113, 'Healthcare Policy & Regulation', 9),
(114, 'Medical Billing & Coding', 9),

-- 10. Architecture & Urban Planning
(115, 'Architectural Design', 10),
(116, 'Landscape Architecture', 10),
(117, 'Urban Planning', 10),

-- 11. Environmental Science
(118, 'Sustainability', 13),
(119, 'Climate Science', 13),
(120, 'Conservation & Ecology', 13),
(121, 'Environmental Policy', 13),

-- 12. Business & Management
(122, 'Product Management', 12),
(123, 'Project Management', 12),
(124, 'Agile / Scrum', 12),
(125, 'Entrepreneurship', 12),
(126, 'Strategy', 12),
(127, 'Marketing', 12),
(128, 'Sales', 12),
(129, 'Human Resources', 12),
(130, 'Operations Management', 12),
(131, 'Supply Chain & Logistics', 12),

-- 13. Design & User Experience
(132, 'Figma', 13),
(133, 'UX / UI Design', 13),
(134, 'Graphic Design', 13),
(135, 'Industrial Design', 13),
(136, 'Interior Design', 13),

-- 14. Writing & Linguistics
(137, 'Technical Writing', 14),
(138, 'Computational Linguistics', 14),
(139, 'Content Writing', 14),
(140, 'Academic Writing', 14),
(141, 'Grant Writing', 14),
(142, 'Professional / Business Writing', 14),
(143, 'Journalism', 14),
(144, 'Translation', 14),
(145, 'Editing', 14),
(146, 'Creative Writing', 14),
(147, 'Screenwriting', 14),
(148, 'Applied Linguistics', 14),
(149, 'Phonetics & Phonology', 14),
(150, 'Semantics & Pragmatics', 14),
(151, 'Sociolinguistics', 14),

-- 15. Education & Teaching
(152, 'Post-Secondary Education', 15),
(153, 'Secondary Education', 15),
(154, 'Primary Education', 15),

-- 16. Other
(155, 'Admin & Customer Support', 16),
(156, 'Finance & Accounting', 16),
(157, 'Law & Legal Services', 16),
(158, 'Real Estate', 16),
(159, 'Social Sciences', 16),
(160, 'Humanities', 16),
(161, 'Mental Health & Counseling', 16),
(162, 'Veterinary Medicine', 16),
(163, 'Lifestyle & Personal Care', 16);

-- ---------------------------------------------------------
-- Table: job_posts
-- ---------------------------------------------------------

CREATE TABLE `job_posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `requirements` text COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `experience_years` int(50) NOT NULL DEFAULT 0,
  `employment_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salary` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `interview_rounds` int(50) NOT NULL DEFAULT 1,
  `status` ENUM('draft','published','closed') NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_job_user` (`user_id`),
  KEY `fk_job_company` (`company_id`),
  KEY `fk_job_category` (`category_id`),
  CONSTRAINT `fk_job_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_job_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_job_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `job_posts` (`id`, `user_id`, `company_id`, `category_id`, `title`, `description`, `requirements`, `level`, `experience_years`, `employment_type`, `salary`, `interview_rounds`) VALUES
(1, 4, 1, 3, 'Fullstack Developer (React + Node.js)', 'Build and maintain microservices and React-based SPAs for enterprise digital transformation projects.<br/>\r\nCollaborate with cross-functional teams across Vietnam, Japan, and the US.<br/>\r\nDesign RESTful APIs and integrate with cloud services (AWS/Azure).<br/>\r\nParticipate in code reviews, architecture discussions, and sprint planning.<br/>\r\nMentor junior developers and contribute to internal tech talks.', 'Bachelor''s degree in Computer Science or related field.<br/>\r\n3+ years of fullstack development experience with React and Node.js/Express.<br/>\r\nStrong understanding of TypeScript, REST APIs, and relational databases (PostgreSQL/MySQL).<br/>\r\nExperience with Docker, CI/CD pipelines, and cloud platforms (AWS preferred).<br/>\r\nFamiliar with Agile/Scrum methodologies.<br/>\r\nGood English communication skills.', 'Middle', 3, 'Full-time', '$1,200 - $2,500', 3),

(2, 5, 2, 7, 'AI / Machine Learning Engineer', 'Research and develop ML/AI models for Zalo''s recommendation engine and content moderation systems.<br/>\r\nBuild and optimize LLM-based features for Vietnamese language understanding.<br/>\r\nDesign data pipelines for training and inference at scale.<br/>\r\nCollaborate with product teams to ship AI-powered features to 75M+ users.<br/>\r\nPublish research papers and contribute to the open-source community.', 'Master''s or PhD in Computer Science, Machine Learning, or related field.<br/>\r\n3+ years of hands-on ML engineering experience.<br/>\r\nProficiency in Python, PyTorch or TensorFlow.<br/>\r\nExperience with LLMs, transformers, and NLP for Vietnamese language is a strong plus.<br/>\r\nFamiliarity with MLOps tools (MLflow, Kubeflow, or similar).<br/>\r\nStrong publication record or open-source contributions preferred.', 'Senior', 3, 'Full-time', '$3,000 - $6,000', 4),

(3, 6, 3, 5, 'DevOps / SRE Engineer', 'Design, build, and maintain CI/CD pipelines and infrastructure automation for CMC Cloud platform.<br/>\r\nManage Kubernetes clusters and container orchestration across multiple regions.<br/>\r\nImplement monitoring, alerting, and incident response procedures (PagerDuty, Grafana, Prometheus).<br/>\r\nAutomate infrastructure provisioning with Terraform and Ansible.<br/>\r\nCollaborate with development teams to improve deployment frequency and reliability.', 'Bachelor''s degree in IT or related field.<br/>\r\n2+ years of DevOps/SRE experience.<br/>\r\nStrong Linux administration skills.<br/>\r\nHands-on experience with Docker, Kubernetes, Terraform, and CI/CD tools (Jenkins, GitLab CI, or GitHub Actions).<br/>\r\nExperience with cloud platforms (AWS, GCP, or Azure).<br/>\r\nKnowledge of monitoring stacks (Prometheus, Grafana, ELK).', 'Middle', 2, 'Full-time', '$1,500 - $3,000', 3),

(4, 7, 4, 8, 'QA Automation Engineer', 'Design and implement automated test frameworks for web and mobile applications.<br/>\r\nWrite and maintain test scripts using Selenium, Cypress, or Playwright.<br/>\r\nPerform API testing with Postman and REST-assured.<br/>\r\nIntegrate automated tests into CI/CD pipelines.<br/>\r\nCollaborate with developers to define test strategies and quality gates.', 'Bachelor''s degree in Computer Science or related field.<br/>\r\n2+ years of QA automation experience.<br/>\r\nProficiency in at least one programming language (Java, Python, or JavaScript).<br/>\r\nExperience with test automation frameworks (Selenium, Cypress, Playwright).<br/>\r\nFamiliarity with CI/CD integration and test reporting tools.<br/>\r\nISTQB certification is a plus.', 'Middle', 2, 'Full-time', '$1,000 - $2,000', 2),

(5, 8, 5, 1, 'Senior Backend Developer (Java / Spring Boot)', 'Architect and develop high-throughput backend services for enterprise clients in finance and insurance sectors.<br/>\r\nDesign event-driven microservice architectures using Kafka and RabbitMQ.<br/>\r\nOptimize database performance (PostgreSQL, Redis caching).<br/>\r\nLead technical design reviews and enforce coding standards.<br/>\r\nMentor team members and drive best practices adoption.', 'Bachelor''s or Master''s in Computer Science.<br/>\r\n5+ years of backend development with Java and Spring Boot.<br/>\r\nDeep understanding of microservice patterns, event sourcing, and CQRS.<br/>\r\nStrong database skills (PostgreSQL, Redis, Elasticsearch).<br/>\r\nExperience with Docker, Kubernetes, and AWS.<br/>\r\nExcellent English communication for working with UK-based stakeholders.', 'Senior', 5, 'Full-time', '$2,500 - $4,500', 3),

(6, 9, 6, 7, 'GenAI Engineer', 'Build and deploy generative AI solutions for enterprise clients using LLMs (GPT, Claude, Gemini).<br/>\r\nDevelop RAG (Retrieval-Augmented Generation) pipelines and AI agents.<br/>\r\nFine-tune and evaluate language models for domain-specific tasks.<br/>\r\nDesign prompt engineering strategies and evaluation frameworks.<br/>\r\nContribute to TECHVIFY''s AI product roadmap and research initiatives.', 'Bachelor''s or Master''s in Computer Science, AI, or related field.<br/>\r\n2+ years of experience with LLMs and generative AI applications.<br/>\r\nProficiency in Python, LangChain/LlamaIndex, and vector databases (Pinecone, Weaviate, pgvector).<br/>\r\nExperience with cloud AI services (AWS Bedrock, Azure OpenAI, or GCP Vertex AI).<br/>\r\nStrong understanding of transformer architectures and fine-tuning techniques.<br/>\r\nGood English skills; Japanese is a plus.', 'Middle', 2, 'Full-time', '$2,000 - $4,000', 3),

(7, 10, 7, 14, 'Embedded Software Engineer (5G/AI)', 'Develop embedded software for 5G modem and AI chipsets at Samsung''s largest R&D center outside Korea.<br/>\r\nOptimize low-level firmware for performance and power efficiency.<br/>\r\nImplement and test communication protocols (5G NR, LTE).<br/>\r\nCollaborate with hardware teams on SoC bring-up and driver development.<br/>\r\nWrite technical documentation and participate in design reviews.', 'Bachelor''s/Master''s in EE, CE, or CS.<br/>\r\n3+ years of embedded C/C++ development.<br/>\r\nExperience with RTOS (FreeRTOS, Zephyr) and bare-metal programming.<br/>\r\nKnowledge of communication protocols (UART, SPI, I2C, PCIe).<br/>\r\nFamiliarity with 5G NR standards or AI/ML on edge devices is a strong plus.<br/>\r\nEnglish working proficiency required.', 'Senior', 3, 'Full-time', '$2,000 - $4,000', 3),

(8, 11, 8, 4, 'Senior Mobile Developer (React Native)', 'Build and enhance features for MoMo''s super app used by 31M+ Vietnamese users.<br/>\r\nDevelop cross-platform components with React Native and native modules (iOS/Android).<br/>\r\nOptimize app performance, startup time, and bundle size.<br/>\r\nIntegrate payment SDKs, biometric authentication, and push notifications.<br/>\r\nCollaborate with backend and product teams in an Agile environment.', 'Bachelor''s in CS or related field.<br/>\r\n4+ years of mobile development, with 2+ years in React Native.<br/>\r\nStrong JavaScript/TypeScript fundamentals.<br/>\r\nExperience with native iOS (Swift) or Android (Kotlin) for bridging.<br/>\r\nFamiliarity with state management (Redux, MobX) and testing frameworks (Jest, Detox).<br/>\r\nExperience with fintech or high-traffic consumer apps is a strong plus.', 'Senior', 4, 'Full-time', '$2,500 - $5,000', 3),

(9, 12, 9, 6, 'Data Engineer', 'Design and build data pipelines powering Tiki''s recommendation engine, search ranking, and business analytics.<br/>\r\nDevelop ETL/ELT workflows using Spark, Airflow, and dbt.<br/>\r\nBuild and maintain the data lakehouse architecture on AWS (S3, Glue, Athena, Redshift).<br/>\r\nEnsure data quality, lineage, and governance across the platform.<br/>\r\nCollaborate with data scientists and product analysts to deliver actionable insights.', 'Bachelor''s in CS, Data Science, or related field.<br/>\r\n3+ years of data engineering experience.<br/>\r\nProficiency in Python and SQL.<br/>\r\nHands-on experience with Spark, Airflow, and at least one cloud data platform (AWS/GCP/Azure).<br/>\r\nFamiliarity with data modeling, warehousing concepts, and tools like dbt.<br/>\r\nExperience with streaming systems (Kafka, Flink) is a plus.', 'Middle', 3, 'Full-time', '$1,500 - $3,000', 3),

(10, 13, 10, 13, 'Cybersecurity Engineer', 'Perform security assessments, penetration testing, and vulnerability analysis for Viettel''s digital platforms.<br/>\r\nDevelop and maintain security monitoring tools and SIEM integrations.<br/>\r\nRespond to security incidents and conduct forensic analysis.<br/>\r\nDesign secure architectures for cloud-native applications.<br/>\r\nContribute to Viettel''s threat intelligence and red team operations.', 'Bachelor''s in CS, Cybersecurity, or related field.<br/>\r\n3+ years of cybersecurity experience.<br/>\r\nHands-on penetration testing skills (OWASP Top 10, network pentesting).<br/>\r\nExperience with SIEM tools (Splunk, ELK, QRadar) and security frameworks (NIST, ISO 27001).<br/>\r\nCertifications such as CEH, OSCP, or CISSP are preferred.<br/>\r\nKnowledge of cloud security (AWS/Azure) and container security.', 'Senior', 3, 'Full-time', '$2,000 - $4,000', 3),

(11, 14, 11, 1, 'Backend Developer (.NET)', 'Develop and maintain MISA''s SaaS products serving 250,000+ businesses across Vietnam.<br/>\r\nBuild high-performance APIs using ASP.NET Core and C#.<br/>\r\nDesign and optimize SQL Server and PostgreSQL databases.<br/>\r\nImplement microservice patterns and message queues (RabbitMQ, Redis).<br/>\r\nParticipate in sprint planning, code reviews, and continuous improvement.', 'Bachelor''s in Computer Science or related field.<br/>\r\n2+ years of .NET development experience (ASP.NET Core, C#).<br/>\r\nStrong SQL skills (SQL Server or PostgreSQL).<br/>\r\nUnderstanding of OOP, SOLID principles, and design patterns.<br/>\r\nExperience with Docker and CI/CD pipelines.<br/>\r\nTeam-oriented with good communication skills.', 'Middle', 2, 'Full-time', '$1,000 - $2,000', 3),

(12, 15, 12, 10, 'Technical Project Manager', 'Lead cross-functional project teams delivering enterprise solutions for Japanese automotive and finance clients.<br/>\r\nManage project scope, schedule, budget, and risk across multiple concurrent projects.<br/>\r\nAct as the primary liaison between NTT DATA Japan headquarters and Vietnam development teams.<br/>\r\nDrive Agile adoption and continuous process improvement.<br/>\r\nSupport pre-sales activities including solution proposals and effort estimation.', 'Bachelor''s in CS or related field; Master''s is a plus.<br/>\r\n5+ years of software project management experience.<br/>\r\nExperience managing teams of 30+ members.<br/>\r\nPMP or Scrum Master certification preferred.<br/>\r\nFluent English required; Japanese (JLPT N2+) is a strong advantage.<br/>\r\nExperience in automotive or financial services software is preferred.', 'Senior', 5, 'Full-time', '$2,500 - $4,500', 3),

(13, 4, 13, 2, 'Frontend Developer (React / Next.js)', 'Develop modern responsive web applications for European clients in insurance and travel domains.<br/>\r\nBuild pixel-perfect UIs from Figma designs with accessibility and performance in mind.<br/>\r\nIntegrate with headless CMS (Contentful, Strapi) and backend APIs via GraphQL.<br/>\r\nWrite unit and integration tests with Jest and React Testing Library.<br/>\r\nContribute to the internal component library and design system.', 'Bachelor''s in CS or related field.<br/>\r\n2+ years of frontend development with React.<br/>\r\nStrong HTML5, CSS3, and JavaScript/TypeScript skills.<br/>\r\nExperience with Next.js and server-side rendering.<br/>\r\nFamiliarity with GraphQL, headless CMS, and responsive design.<br/>\r\nGood written English; German is a plus.', 'Junior', 2, 'Full-time', '$800 - $1,500', 2),

(14, 5, 14, 3, 'Fullstack Developer (Python + React)', 'Build healthcare and fintech platforms for US and Australian clients.<br/>\r\nDevelop backend services with Python (Django/FastAPI) and React frontends.<br/>\r\nDesign database schemas and write efficient queries (PostgreSQL).<br/>\r\nImplement authentication, authorization, and HIPAA-compliant data handling.<br/>\r\nWrite automated tests and maintain CI/CD pipelines.', 'Bachelor''s in CS or related field.<br/>\r\n3+ years of fullstack development experience.<br/>\r\nProficiency in Python (Django or FastAPI) and React/TypeScript.<br/>\r\nSolid understanding of PostgreSQL and REST API design.<br/>\r\nExperience with Docker, Git, and CI/CD.<br/>\r\nExperience in healthcare or fintech domains is a plus.', 'Middle', 3, 'Full-time', '$1,200 - $2,500', 3),

(15, 6, 15, 9, 'Business Analyst (Agile)', 'Gather and analyze business requirements from international clients.<br/>\r\nCreate detailed user stories, acceptance criteria, and process flow diagrams.<br/>\r\nFacilitate sprint planning, backlog grooming, and stakeholder demos.<br/>\r\nBridge communication between clients and development teams.<br/>\r\nConduct market research and competitive analysis for product features.', 'Bachelor''s in IT, Business, or related field.<br/>\r\n2+ years of BA experience in software projects.<br/>\r\nProficiency with wireframing tools (Figma, Balsamiq, or draw.io).<br/>\r\nStrong understanding of Agile/Scrum methodology.<br/>\r\nExcellent English communication skills (written and verbal).<br/>\r\nExperience with JIRA and Confluence.', 'Junior', 2, 'Full-time', '$800 - $1,500', 2),

(16, 7, 16, 3, 'Fullstack Developer (Blockchain)', 'Develop decentralized applications (dApps) and smart contracts for Web3 projects.<br/>\r\nBuild React/Next.js frontends integrated with blockchain wallets (MetaMask, WalletConnect).<br/>\r\nWrite and audit Solidity smart contracts on EVM-compatible chains.<br/>\r\nDevelop backend services with Node.js and integrate on-chain/off-chain data.<br/>\r\nStay current with DeFi, NFT, and Web3 industry trends.', 'Bachelor''s in CS or related field.<br/>\r\n2+ years of web development experience, with 1+ year in blockchain/Web3.<br/>\r\nProficiency in Solidity and at least one smart contract framework (Hardhat, Foundry).<br/>\r\nStrong React/Next.js and Node.js skills.<br/>\r\nUnderstanding of EVM, gas optimization, and common smart contract vulnerabilities.<br/>\r\nFamiliarity with The Graph, IPFS, or similar Web3 infrastructure.', 'Middle', 2, 'Full-time', '$1,500 - $3,500', 3),

(17, 8, 17, 2, 'Frontend Developer (Vue.js)', 'Develop and maintain web interfaces for enterprise insurance platforms serving German-speaking markets.<br/>\r\nBuild reusable UI components with Vue 3 Composition API and TypeScript.<br/>\r\nImplement responsive designs and ensure cross-browser compatibility.<br/>\r\nCollaborate with UX designers and backend developers in an Agile team.<br/>\r\nOptimize frontend performance and bundle size.', 'Bachelor''s in CS or related field.<br/>\r\n2+ years of frontend development with Vue.js (Vue 3 preferred).<br/>\r\nSolid knowledge of HTML5, CSS3/SCSS, and TypeScript.<br/>\r\nExperience with state management (Pinia/Vuex) and build tools (Vite/Webpack).<br/>\r\nGood English communication skills.<br/>\r\nExperience with internationalization (i18n) is a plus.', 'Junior', 2, 'Remote', '$1,000 - $2,000', 2),

(18, 9, 18, 12, 'Cloud / Platform Engineer', 'Design and implement cloud infrastructure for React and CMS-based web applications.<br/>\r\nBuild serverless architectures using AWS Lambda, API Gateway, and DynamoDB.<br/>\r\nAutomate deployments with Terraform and CloudFormation.<br/>\r\nSet up monitoring, logging, and alerting with CloudWatch and Datadog.<br/>\r\nAdvise development teams on cloud-native best practices and cost optimization.', 'Bachelor''s in CS or related field.<br/>\r\n3+ years of cloud engineering experience.<br/>\r\nAWS Solutions Architect or equivalent certification preferred.<br/>\r\nStrong experience with IaC tools (Terraform, CloudFormation).<br/>\r\nFamiliarity with serverless architectures and container orchestration.<br/>\r\nKnowledge of networking, security groups, and IAM policies.', 'Senior', 3, 'Full-time', '$2,000 - $4,000', 3),

(19, 10, 19, 11, 'UI / UX Designer', 'Design user interfaces and experiences for F&B mobile ordering and restaurant management platforms.<br/>\r\nConduct user research, create personas, journey maps, and usability tests.<br/>\r\nProduce wireframes, prototypes, and high-fidelity mockups in Figma.<br/>\r\nCollaborate with product managers and engineers to ship polished features.<br/>\r\nMaintain and evolve the company''s design system.', 'Bachelor''s in Design, HCI, or related field.<br/>\r\n2+ years of UI/UX design experience for mobile and web products.<br/>\r\nExpert-level proficiency with Figma.<br/>\r\nStrong portfolio demonstrating user-centered design process.<br/>\r\nUnderstanding of design systems, accessibility, and mobile-first design.<br/>\r\nExperience with motion design (After Effects, Lottie) is a plus.', 'Middle', 2, 'Full-time', '$1,000 - $2,000', 2),

(20, 11, 20, 1, 'Backend Developer (Go)', 'Build high-performance backend services for Shopee''s marketplace platform handling millions of concurrent users.<br/>\r\nDesign and implement distributed systems with Go microservices.<br/>\r\nOptimize database queries and caching strategies (MySQL, Redis, TiDB).<br/>\r\nDevelop and maintain gRPC APIs and event-driven architectures (Kafka).<br/>\r\nParticipate in on-call rotations and system reliability initiatives.', 'Bachelor''s or Master''s in CS or related field.<br/>\r\n3+ years of backend development, with Go experience preferred (Java/Python also considered).<br/>\r\nStrong understanding of distributed systems, concurrency, and networking.<br/>\r\nExperience with MySQL, Redis, Kafka, and gRPC.<br/>\r\nFamiliarity with Kubernetes and cloud infrastructure.<br/>\r\nAbility to work in a fast-paced, high-scale environment.', 'Senior', 3, 'Full-time', '$2,500 - $5,000', 4);

-- ---------------------------------------------------------
-- Table: job_skills (many-to-many)
-- ---------------------------------------------------------

-- =========================================================
-- Table: job_skills (many-to-many) - Đã cập nhật tương thích với 163 skills mới
-- =========================================================

CREATE TABLE `job_skills` (
  `job_id` int(10) NOT NULL,
  `skill_id` int(10) NOT NULL,
  PRIMARY KEY (`job_id`, `skill_id`),
  KEY `fk_js_skill` (`skill_id`),
  CONSTRAINT `fk_js_job` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_js_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `job_skills` (`job_id`, `skill_id`) VALUES
-- Job 1: Fullstack React+Node @ FPT (React, Node.js, TypeScript, JavaScript, PostgreSQL, Docker, Git, REST API)
(1, 2), (1, 3), (1, 10), (1, 15), (1, 19), (1, 20), (1, 39), (1, 43),
-- Job 2: AI/ML @ VNG (Python, PyTorch, TensorFlow, Machine Learning, LLM / GenAI, SQL)
(2, 18), (2, 30), (2, 51), (2, 52), (2, 54), (2, 55),
-- Job 3: DevOps @ CMC (Linux, Git, Docker, Kubernetes, AWS, Terraform, CI/CD, SQL)
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 8), (3, 9), (3, 30),
-- Job 4: QA Automation @ KMS (Git, Docker, Kubernetes, Java, Python, JavaScript, CI/CD)
(4, 2), (4, 3), (4, 4), (4, 9), (4, 19), (4, 21), (4, 18),
-- Job 5: Senior Backend Java @ NashTech (Java, Spring Boot, PostgreSQL, Redis, Elasticsearch, Docker, Kubernetes, AWS, Kafka)
(5, 3), (5, 4), (5, 5), (5, 10), (5, 13), (5, 16), (5, 17), (5, 21), (5, 45),
-- Job 6: GenAI @ TECHVIFY (Python, LLM / GenAI, PyTorch, LangChain/Vector DB context, AWS)
(6, 5), (6, 18), (6, 51), (6, 52), (6, 54),
-- Job 7: Embedded @ Samsung (C/C++, Linux, Git, Embedded/IoT context)
(7, 1), (7, 2), (7, 22),
-- Job 8: Mobile RN @ MoMo (React Native, JavaScript, TypeScript, Swift, Kotlin, Git, Docker)
(8, 2), (8, 3), (8, 19), (8, 20), (8, 28), (8, 29), (8, 50),
-- Job 9: Data Engineer @ Tiki (Python, SQL, Spark, Airflow, dbt, AWS, Kafka)
(9, 5), (9, 16), (9, 18), (9, 30), (9, 58), (9, 59), (9, 60), (9, 61),
-- Job 10: Cybersecurity @ Viettel (Linux, Docker, Cloud Security, Network Security, Application Security, SIEM/Elasticsearch)
(10, 1), (10, 3), (10, 17), (10, 62), (10, 63), (10, 64),
-- Job 11: Backend .NET @ MISA (.NET C#, SQL Server/PostgreSQL, Docker, RabbitMQ/Kafka, CI/CD)
(11, 3), (11, 9), (11, 10), (11, 16), (11, 23), (11, 44),
-- Job 12: PM @ NTT DATA (Agile / Scrum, Product Management, Project Management)
(12, 122), (12, 123), (12, 124),
-- Job 13: Frontend React @ Axon Active (React, Next.js, TypeScript, JavaScript, Git, Docker, GraphQL)
(13, 2), (13, 3), (13, 14), (13, 19), (13, 20), (13, 39), (13, 42),
-- Job 14: Fullstack Python+React @ Saigon Technology (Python, Django/FastAPI, React, TypeScript, PostgreSQL, Docker, Git)
(14, 2), (14, 3), (14, 10), (14, 18), (14, 19), (14, 20), (14, 39), (14, 46), (14, 47),
-- Job 15: BA @ Orient Software (Agile / Scrum, Project Management, Figma)
(15, 122), (15, 123), (15, 124), (15, 132), (15, 133),
-- Job 16: Fullstack Blockchain @ Designveloper (Solidity, React, Next.js, Node.js, Git, Docker)
(16, 2), (16, 3), (16, 19), (16, 20), (16, 35), (16, 39), (16, 42), (16, 43),
-- Job 17: Frontend Vue @ mgm (Vue.js, TypeScript, JavaScript, Vite/Webpack tools, Git, Docker)
(17, 2), (17, 3), (17, 19), (17, 20), (17, 40),
-- Job 18: Cloud Engineer @ Positive Thinking (AWS, Terraform, Docker, Kubernetes, Linux, CI/CD)
(18, 1), (18, 3), (18, 4), (18, 5), (18, 8), (18, 9),
-- Job 19: UI/UX @ Golden Gate (Figma, UX / UI Design, Graphic Design)
(19, 132), (19, 133), (19, 134),
-- Job 20: Backend Go @ Shopee (Go, MySQL, Redis, Kafka, Kubernetes, Docker, Linux)
(20, 1), (20, 3), (20, 4), (20, 11), (20, 13), (20, 16), (20, 24);

-- ---------------------------------------------------------
-- Table: user_skills (many-to-many)
-- ---------------------------------------------------------

CREATE TABLE `user_skills` (
  `user_id` int(10) NOT NULL,
  `skill_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`, `skill_id`),
  KEY `fk_us_skill` (`skill_id`),
  CONSTRAINT `fk_us_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_us_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_skills` (`user_id`, `skill_id`) VALUES
(2, 18), (2, 19), (2, 20), (2, 39), (2, 43), (2, 3), (2, 2),
(3, 18), (3, 21), (3, 45), (3, 10), (3, 5);

-- ---------------------------------------------------------
-- Table: user_profiles (1:1 with users)
-- ---------------------------------------------------------

CREATE TABLE `user_profiles` (
  `user_id` int(10) NOT NULL,
  `headline` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `portfolio_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `github_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_profiles` (`user_id`, `headline`) VALUES
(2, 'Fullstack Developer | React & Node.js'),
(3, 'Java Backend Developer');

-- ---------------------------------------------------------
-- Table: user_education
-- ---------------------------------------------------------

CREATE TABLE `user_education` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `school_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `degree` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_of_study` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_edu_user` (`user_id`),
  CONSTRAINT `fk_edu_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ---------------------------------------------------------
-- Table: user_experience
-- ---------------------------------------------------------

CREATE TABLE `user_experience` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `company_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_exp_user` (`user_id`),
  CONSTRAINT `fk_exp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ---------------------------------------------------------
-- Table: user_certifications
-- ---------------------------------------------------------

CREATE TABLE `user_certifications` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `issuing_org` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `credential_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cert_user` (`user_id`),
  CONSTRAINT `fk_cert_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ---------------------------------------------------------
-- Table: applications (was quanlyfile_cv)
-- ---------------------------------------------------------

CREATE TABLE `applications` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `applicant_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PENDING',
  `cover_letter` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_app_job` (`job_id`),
  KEY `fk_app_user` (`user_id`),
  CONSTRAINT `fk_app_job` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_app_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `applicant_name`, `file_path`, `status`) VALUES
(1, 1, 2, 'Vo Hoang Nhat Anh', 'cv/sample_cv_2.pdf', 'PENDING'),
(2, 2, 2, 'Vo Hoang Nhat Anh', 'cv/sample_cv_2.pdf', 'REVIEWED'),
(3, 5, 3, 'Cao Thi Quynh Dao', 'cv/sample_cv_3.pdf', 'PENDING');

-- ---------------------------------------------------------
-- Table: bookmarks
-- ---------------------------------------------------------

CREATE TABLE `bookmarks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_bm_job` (`job_id`),
  KEY `fk_bm_user` (`user_id`),
  CONSTRAINT `fk_bm_job` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bm_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `bookmarks` (`id`, `job_id`, `user_id`) VALUES
(1, 1, 2),
(2, 3, 2);

-- ---------------------------------------------------------
-- Table: saved_searches
-- ---------------------------------------------------------

CREATE TABLE `saved_searches` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `query_params` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ss_user` (`user_id`),
  CONSTRAINT `fk_ss_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
