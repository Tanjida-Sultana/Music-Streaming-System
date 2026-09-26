SELECT p.playlist_id, p.title, u.username, COUNT(ps.song_id) AS song_count 
    FROM playlists p 
    LEFT JOIN users u ON p.user_id = u.user_id 
    LEFT JOIN PLAYLISTS_SONGS ps ON p.playlist_id = ps.playlist_id 
    GROUP BY p.playlist_id, p.title, u.username
    ORDER BY p.created_at DESC
