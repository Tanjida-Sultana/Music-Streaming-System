USE Music_Library;

CREATE TABLE `PLAYLISTS_SONGS`(
    `playlist_id` INT PRIMARY KEY,
    FOREIGN KEY (playlist_id) REFERENCES playlists(playlist_id) ON DELETE CASCADE,
    `song_id` INT,
    FOREIGN KEY (song_id) REFERENCES songs(song_id) ON DELETE CASCADE,
    `added_at` DATETIME DEFAULT CURRENT_TIMESTAMP);

-- Insert values in Playlists table

INSERT INTO `PLAYLISTS_SONGS` () VALUES
(),
(),
(),
(),
();
