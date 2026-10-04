USE Music_Library;

-- Table ARTISTS

CREATE TABLE `ARTISTS` (
  `artist_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(200) NOT NULL DEFAULT 'Unknown Artist',
  `age` INT NOT NULL,
  `bio` TEXT NOT NULL
);

-- Insert values in ARTISTS table

INSERT INTO `artists` (`name`, `age`, `bio`) VALUES
('Alan Walker', 33, 'Alan Walker is a British-Norwegian DJ and record producer who became famous for his hit electronic song "Faded".'),
('Ava Max', 32, 'Ava Max is an American pop singer and songwriter born on February 16, 1994, in Milwaukee, Wisconsin, to Albanian immigrant parents.'),
('Robyn Rihanna Fenty', 38, 'Robyn Rihanna Fenty (known mononymously as Rihanna) is a globally renowned Barbadian singer, songwriter, actress, and billionaire businesswoman. Born on February 20, 1988, in Saint Michael, Barbados.'),
('Christina Aguilera', 45, 'Christina María Aguilera is an American pop singer and songwriter born on December 18, 1980, in Staten Island, New York. She rose to fame in the late 1990s as a leading pop icon known for her powerful four-octave vocal range and dynamic stage presence.'),
('Ina Christine Wroldsen', 42, 'Ina Christine Wroldsen is a highly successful Norwegian singer and songwriter, born on May 29, 1984, in Sandefjord, Norway, she has established herself as one of the international music industrys most sought-after pop songwriters.'),
('Sia Kate', 50, 'Sia Kate Isobelle Furler was born on December 18, 1975, in Adelaide, South Australia. She is a famous Australian singer, songwriter, and music video director.'),
('Alok Achkar Peres Petrillo', 35, 'Alok Achkar Peres Petrillo, known professionally as Alok, is a world-renowned Brazilian DJ and electronic music producer. Born on August 26, 1991, in Goiânia, Brazil.'),
('Sophia', 23, 'Born Sophia Laforteza on December 31, 2002, in New York and raised in Manila, Philippines. As the official leader of KATSEYE, she finished in first place during Dream Academy and comes from a musical background as the daughter of a prominent Filipina actress and singer.'),
('Marino', 24, 'Marino is an emerging American singer, songwriter, and producer who went viral on TikTok and YouTube. He is widely recognized for his signature look—wearing a brown paper bag over his head to keep his identity anonymous.'),
('Hugh Cornwell', 77, 'primary creator, lead lyricist, and vocalist of the song "Golden Brown".');

ALTER TABLE artists AUTO_INCREMENT = 1;
ALTER TABLE artists ADD COLUMN age INT(11) DEFAULT NULL;
ALTER TABLE artists ADD COLUMN bio TEXT DEFAULT NULL;
