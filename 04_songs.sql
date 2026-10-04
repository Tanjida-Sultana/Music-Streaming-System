USE Music_Library;

-- Table SONGS

CREATE TABLE `SONGS` (
  `song_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `duration` TIME NOT NULL,
  `genre` VARCHAR(50),
  `play_count` INT NOT NULL DEFAULT 0,
  `artist_id` INT NOT NULL,
  FOREIGN KEY (artist_id) REFERENCES artists(artist_id) ON DELETE CASCADE
);

ALTER TABLE songs ADD COLUMN youtube_url VARCHAR(255) DEFAULT NULL;
ALTER TABLE songs ADD COLUMN album_id INT(11) DEFAULT NULL;
ALTER TABLE songs ADD CONSTRAINT fk_song_album FOREIGN KEY (album_id) REFERENCES albums(album_id) ON DELETE SET NULL;
