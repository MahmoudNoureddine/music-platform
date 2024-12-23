<?php
require '../../config/database.php';
require '../models/User.php';

/**
 * Class AuthController
 * Handles user authentication including signup, login, and logout actions.
 */
class AuthController {
    /**
     * @var User $userModel Instance of the User model for database operations.
     */
    private $userModel;

    /**
     * AuthController constructor.
     * Initializes the User model.
     *
     * @param PDO $pdo Database connection object.
     */
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    /**
     * Handles HTTP requests for authentication actions.
     * Determines the type of request (signup, login, logout) and processes it.
     *
     * @return void
     */
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['signup'])) {
                $this->signup($_POST['email'], $_POST['password'], $_POST['confirm_password']);
            } elseif (isset($_POST['login'])) {
                $this->login($_POST['email'], $_POST['password']);
            } elseif (isset($_POST['logout'])) {
                $this->logout();
            } else {
                echo "Invalid action.";
            }
        }
    }

    /**
     * Handles user signup.
     * Validates input, hashes the password, and creates a new user if valid.
     *
     * @param string $email The user's email address.
     * @param string $password The user's chosen password.
     * @param string $confirmPassword The confirmation of the user's password.
     *
     * @return void
     */
    private function signup($email, $password, $confirmPassword) {
        if ($password !== $confirmPassword) {
            echo 'Passwords do not match.';
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($this->userModel->emailExists($email)) {
            echo 'Email already exists.';
            return;
        }

        if ($this->userModel->createUser($email, $hashedPassword)) {
            header('Location: ../../public/auth.php');
        } else {
            echo 'Signup failed. Please try again.';
        }
    }

    /**
     * Handles user login.
     * Validates credentials and starts a session for the user if successful.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     *
     * @return void
     */
    private function login($email, $password) {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../../public/index.php');
        } else {
            echo 'Invalid email or password.';
        }
    }

    /**
     * Handles user logout.
     * Ends the user's session and redirects to the login page.
     *
     * @return void
     */
    private function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../../public/auth.php'); // Redirect to the login page
        exit(); // Prevent further execution
    }
}

// Instantiate the AuthController and handle the request.
$authController = new AuthController($pdo);
$authController->handleRequest();
?>
