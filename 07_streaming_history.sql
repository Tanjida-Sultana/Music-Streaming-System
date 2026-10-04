USE Music_Library;

CREATE TABLE `streaming_history`(
    `history_id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT,
    `song_id` INT,
    FOREIGN KEY (song_id) REFERENCES songs(song_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    `played_at` DATETIME DEFAULT CURRENT_TIMESTAMP);

