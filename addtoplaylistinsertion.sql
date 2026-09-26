SELECT artist_id FROM artists WHERE name = ? -- If unknown artist
INSERT INTO artists (name, age, bio) VALUES (?, ?, ?)
SELECT artist_id FROM artists WHERE name = 'Unknown Artist' -- return to unknown category if name not specified
INSERT INTO artists (name, age, bio) VALUES ('Unknown Artist', 0, 'Default category for unknown artists') -- update database for unknown artists
