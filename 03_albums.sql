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

-- Insert values in ALBUMS table

INSERT INTO `albums` (`title`, `release_date`, `cover_url`, `artist_id`) VALUES
("Alan walker 2018 releases", "2018-09-12", "www.url1.com",
 (SELECT artist_id FROM artists WHERE name = "Alan Walker")),
("Alan walker 2020 releases", "2020-05-21", "www.url2.com",
 (SELECT artist_id FROM artists WHERE name = "Alan Walker")),
("Ina Worldsen Music", "2016-02-11", "www.url3.com",
 (SELECT artist_id FROM artists WHERE name = "Ina Christine Wroldsen")),
("Heaven and Hell", "2021-03-22", "www.url4.com",
 (SELECT artist_id FROM artists WHERE name = "Ava Max")),
("Salt", "2018-04-22", "www.url5.com",
 (SELECT artist_id FROM artists WHERE name = "Ava Max")),
("Everyday is christmas", "2017-11-11", "www.url6.com",
 (SELECT artist_id FROM artists WHERE name = "Sia Kate"));

ALTER TABLE albums AUTO_INCREMENT = 1;
