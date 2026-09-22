USE Music_Library;

CREATE TABLE `PLAYLISTS`(
    `playlist_id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    `title` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP);

-- Insert values in Playlists table

INSERT INTO `PLAYLISTS` (title) VALUES
("Pop playlist"),
("Leisure playlist"),
("Sweet songs"),
("Favourite songs"),
("Playlist 1");
