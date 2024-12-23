<?php
require '../../config/database.php';
require '../models/Playlist.php';

session_start();

/**
 * Redirect to login page if the user is not logged in.
 */
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../public/auth.php');
    exit();
}

// Instantiate the Playlist model
$playlistModel = new Playlist($pdo);

/**
 * Handle POST requests for adding or deleting playlists.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * Handle adding a new playlist.
     */
    if (isset($_POST['add_playlist'])) {
        $playlistName = trim($_POST['playlist_name']);

        // Debugging: Log form data
        error_log("Add playlist triggered: " . $playlistName);

        // Validate input
        if (empty($playlistName)) {
            $_SESSION['error'] = "Playlist name cannot be empty.";
            header('Location: ../../public/playlists.php');
            exit();
        }

        // Create playlist
        if ($playlistModel->createPlaylist($_SESSION['user_id'], $playlistName)) {
            $_SESSION['message'] = "Playlist added successfully.";
        } else {
            $_SESSION['error'] = "Failed to add playlist. It may already exist.";
        }

        header('Location: ../../public/playlists.php');
        exit();
    }

    /**
     * Handle deleting a playlist.
     */
    if (isset($_POST['delete_playlist'])) {
        $playlistId = $_POST['playlist_id'];

        // Debugging: Log the playlist ID
        error_log("Delete playlist triggered: Playlist ID " . $playlistId);

        // Validate and delete the playlist
        if ($playlistModel->deletePlaylist($playlistId, $_SESSION['user_id'])) {
            $_SESSION['message'] = "Playlist deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete playlist.";
        }

        header('Location: ../../public/playlists.php');
        exit();
    }
}
?>
