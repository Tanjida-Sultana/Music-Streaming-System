USE Music_Library;

CREATE TABLE `PLAYLISTS_SONGS` (
    `playlist_id` INT NOT NULL,
    `song_id` INT NOT NULL,
    `added_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`playlist_id`, `song_id`),
    FOREIGN KEY (`playlist_id`) REFERENCES `playlists`(`playlist_id`) ON DELETE CASCADE,
    FOREIGN KEY (`song_id`) REFERENCES `songs`(`song_id`) ON DELETE CASCADE
) ENGINE=InnoDB;
