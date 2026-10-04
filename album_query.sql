-- album query

SELECT al.album_id, al.title AS album_title, COALESCE(a.name, 'Unknown Artist') AS artist_name, COUNT(s.song_id) AS song_count 
    FROM albums al 
    LEFT JOIN artists a ON al.artist_id = a.artist_id 
    LEFT JOIN songs s ON al.album_id = s.album_id 
    GROUP BY al.album_id, al.title, a.name 
    ORDER BY al.title ASC

-- view album query
-- fetch album details
SELECT al.*, COALESCE(a.name, 'Unknown Artist') AS artist_name 
    FROM albums al 
    LEFT JOIN artists a ON al.artist_id = a.artist_id 
    WHERE al.album_id = ?

-- fetch song details

SELECT s.song_id, s.title AS song_title, s.duration, s.youtube_url, 
           COALESCE(a.name, 'Unknown Artist') AS artist_name
    FROM songs s
    LEFT JOIN artists a ON s.artist_id = a.artist_id
    WHERE s.album_id = ?
    ORDER BY s.title ASC

