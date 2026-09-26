-- Songs tag
("SELECT s.title, s.duration, s.genre, s.play_count, COALESCE(a.name, 'Unknown Artist') AS artist_name 
                               FROM songs s LEFT JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE s.title LIKE ? OR a.name LIKE ?");
--Artist tags
("SELECT s.title, s.duration, s.genre, s.play_count, a.name AS artist_name 
                               FROM songs s JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE a.name LIKE ?");
-- Genre tag
("SELECT s.title, s.duration, s.genre, s.play_count, COALESCE(a.name, 'Unknown Artist') AS artist_name 
                               FROM songs s LEFT JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE s.genre LIKE ?");
-- Album tag
("SELECT s.title, s.duration, s.genre, s.play_count, a.name AS artist_name 
                               FROM songs s 
                               JOIN albums al ON s.artist_id = al.artist_id 
                               LEFT JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE al.title LIKE ?");
