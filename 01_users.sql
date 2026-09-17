USE Music_Library;

-- Table USERS

CREATE TABLE `USERS` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL DEFAULT 'Unknown',
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert values in USERS table

INSERT INTO `users` (`username`, `email`, `password`) VALUES
('faisal', 'faisalhossain@acd.com', 'faisal123'),
('Zana', 'zana123@acd.com', 'faisal123'),
('Arfin', 'ar127@acd.com', 'faisal123'),
('Elena', 'elenahuston@acd.com', 'faisal123'),
('Wise', 'wise@acd.com', 'faisal123'),
('John', 'johnsmith@acd.com', 'faisal123'),
('Ezar', 'ezar189@acd.com', 'faisal123'),
('Elijah', 'elijahvolford@acd.com', 'faisal123'),
('Rishiki', 'rishikiahmed@acd.com', 'faisal123'),
('Sultan', 'sultan334@acd.com', 'faisal123'),
('Farhan', 'farhanchoewdhurry@acd.com', 'faisal123'),
('Zinia', 'ziniauiu@acd.com', 'faisal123'),
('Rubaet', 'rubaetaicu@acd.com', 'faisal123'),
('Rakib', 'rakibislam@acd.com', 'faisal123');

ALTER TABLE users AUTO_INCREMENT = 1;
