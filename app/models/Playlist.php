<?php
class Playlist {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch all playlists for a user
    public function getUserPlaylists($userId) {
        $stmt = $this->pdo->prepare('SELECT * FROM playlists WHERE user_id = ?');
        $stmt->execute([$userId]);
        $playlists = $stmt->fetchAll();
        return $playlists ? $playlists : []; // Return an empty array if no playlists
    }

    // Create a new playlist for a user
    public function createPlaylist($userId, $name) {
        // Check if the playlist name already exists for the user
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM playlists WHERE user_id = ? AND name = ?');
        $stmt->execute([$userId, $name]);
        if ($stmt->fetchColumn() > 0) {
            return false; // Playlist already exists
        }

        // Insert the new playlist
        $stmt = $this->pdo->prepare('INSERT INTO playlists (user_id, name) VALUES (?, ?)');
        return $stmt->execute([$userId, $name]);
    }

    // Delete a playlist
    public function deletePlaylist($playlistId, $userId) {
        $stmt = $this->pdo->prepare('DELETE FROM playlists WHERE id = ? AND user_id = ?');
        return $stmt->execute([$playlistId, $userId]); // Ensures only the owner's playlist is deleted
    }

    // Add a song to a playlist
    public function addSongToPlaylist($playlistId, $songName, $userId) {
        // Validate that the playlist exists and belongs to the user
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM playlists WHERE id = ? AND user_id = ?');
        $stmt->execute([$playlistId, $userId]);
        if ($stmt->fetchColumn() === 0) {
            return false; // Playlist does not exist or does not belong to the user
        }

        // Insert the song into the playlist
        $stmt = $this->pdo->prepare('INSERT INTO playlist_songs (playlist_id, song_name) VALUES (?, ?)');
        return $stmt->execute([$playlistId, $songName]);
    }

    // Fetch all songs for a specific playlist
    public function getPlaylistSongs($playlistId) {
        $stmt = $this->pdo->prepare('SELECT * FROM playlist_songs WHERE playlist_id = ?');
        $stmt->execute([$playlistId]);
        return $stmt->fetchAll();
    }

    // Delete a song from a playlist
    public function deleteSongFromPlaylist($songId, $playlistId) {
        $stmt = $this->pdo->prepare('DELETE FROM playlist_songs WHERE id = ? AND playlist_id = ?');
        return $stmt->execute([$songId, $playlistId]);
    }
}
?>
