USE Music_Library;

-- Table ALBUMS

CREATE TABLE `ALBUMS` (
  `album_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL DEFAULT 'Unknown Artist',
  `release_date` DATE NOT NULL,
  `cover_url` VARCHAR(255) NOT NULL,
  `artist_id` INT,
  FOREIGN KEY (artist_id) REFERENCES artists(artist_id) ON DELETE CASCADE
);

-- ON DELETE CASCADE because if an artist is deleted,
-- the related albums are also deleted.

ALTER TABLE albums AUTO_INCREMENT = 1;
