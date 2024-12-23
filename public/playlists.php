<?php
session_start();
require '../config/database.php';
require '../app/models/Playlist.php';

/**
 * Redirect to login page if the user is not logged in.
 */
if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

// Instantiate the Playlist model
$playlistModel = new Playlist($pdo);

/**
 * Fetch playlists for the logged-in user.
 *
 * @var int $userId The ID of the logged-in user.
 * @var array $playlists The playlists retrieved for the user.
 */
$userId = $_SESSION['user_id'];
$playlists = $playlistModel->getUserPlaylists($userId);

// Ensure $playlists is always an array
$playlists = $playlists ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Playlists</title>
    <link rel="stylesheet" href="css/playlists.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="navigation">
            <ul>
                <li><a href="#"><span>My Playlist</span></a></li>
                <li><a href="#" onclick="openAddPlaylistPopup()"> <span>Add New Playlist</span></a></li>
                <li><a href="#"><span>Genres</span></a></li>
                <li>
                    <form action="../logout.php" method="POST" style="display: inline;">
                        <button type="submit" name="logout" style="background: none; border: none; color: inherit; cursor: pointer; text-align: left;">
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Playlists Section -->
        <div class="spotify-playlists">
            <h2>My Playlists</h2>

            <div class="list">
                <?php if (empty($playlists)): ?>
                    <p>No playlists found. Create your first playlist!</p>
                <?php else: ?>
                    <?php foreach ($playlists as $playlist): ?>
                        <div class="item">
                            <div class="info">
                                <h4><?php echo htmlspecialchars($playlist['name']); ?></h4>
                                <p>Created on <?php echo htmlspecialchars($playlist['created_at']); ?></p>
                            </div>
                            <div class="play">
                                <form action="../app/controllers/PlaylistController.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="playlist_id" value="<?php echo $playlist['id']; ?>">
                                    <button type="submit" name="delete_playlist" class="play-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add Playlist Popup -->
    <div id="addPlaylistPopup" class="popup">
        <div class="popup-content">
            <h3>Add New Playlist</h3>
            <form id="addPlaylistForm" action="../app/controllers/PlaylistController.php" method="POST">
                <input type="text" name="playlist_name" placeholder="Playlist Name" required>
                <button type="submit" name="add_playlist">Add</button>
                <button type="button" onclick="closeAddPlaylistPopup()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        /**
         * Open the "Add Playlist" popup.
         */
        function openAddPlaylistPopup() {
            document.getElementById('addPlaylistPopup').style.display = 'block';
        }

        /**
         * Close the "Add Playlist" popup.
         */
        function closeAddPlaylistPopup() {
            document.getElementById('addPlaylistPopup').style.display = 'none';
        }
    </script>
</body>
</html>
