SELECT s.song_id, s.title AS song_title, s.duration, 
           COALESCE(a.name, 'Unknown Artist') AS artist_name,
           COALESCE(al.title, 'Unknown Album') AS album_title
    FROM PLAYLISTS_SONGS ps
    JOIN songs s ON ps.song_id = s.song_id
    LEFT JOIN artists a ON s.artist_id = a.artist_id
    LEFT JOIN albums al ON a.artist_id = al.artist_id
    WHERE ps.playlist_id = ?
