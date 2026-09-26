-- Library query to display all songs

SELECT 
    s.song_id, 
    s.title AS song_title, 
    s.duration, 
    s.genre, 
    s.play_count, 
    COALESCE(a.name, 'Unknown Artist') AS artist_name 
FROM songs s 
LEFT JOIN artists a ON s.artist_id = a.artist_id 
ORDER BY s.title ASC;
