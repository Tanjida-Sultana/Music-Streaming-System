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

-- Insert values in SONGS table

INSERT INTO `songs` (`title`, `duration`, `genre`, `play_count`, `artist_id`) VALUES
('Faded', '00:03:32', 'EDM', 998686,
 (SELECT artist_id FROM artists WHERE name = 'Alan Walker')),
('Alone', '00:02:41', 'EDM', 655487,
 (SELECT artist_id FROM artists WHERE name = 'Alan Walker')),
('Sweet but Psycho', '00:03:07', 'Pop', 99823,
 (SELECT artist_id FROM artists WHERE name = 'Ava Max')),
('Salt', '00:03:00', 'Pop', 995567,
 (SELECT artist_id FROM artists WHERE name = 'Ava Max')),
('Chandelier', '00:03:36', 'Pop', 43324,
 (SELECT artist_id FROM artists WHERE name = 'Sia Kate'));

ALTER TABLE songs ADD COLUMN youtube_url VARCHAR(255) DEFAULT NULL;
ALTER TABLE songs ADD COLUMN album_id INT(11) DEFAULT NULL;
ALTER TABLE songs ADD CONSTRAINT fk_song_album FOREIGN KEY (album_id) REFERENCES albums(album_id) ON DELETE SET NULL;
