<?php
// Admin panel with simple password protection
session_start();

// Load admin config
$configFile = __DIR__ . DIRECTORY_SEPARATOR . 'admin_config.php';
$ADMIN_PASSWORD_HASH = null;
if (file_exists($configFile)) {
    include $configFile; // sets $ADMIN_USERNAME and $ADMIN_PASSWORD_HASH
}

// Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_authenticated']);
    header('Location: admin.php');
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_pass'])) {
    $pass = $_POST['admin_pass'];
    $user = isset($_POST['admin_user']) ? trim($_POST['admin_user']) : '';
    if (isset($ADMIN_USERNAME) && $ADMIN_USERNAME !== '' && $user !== $ADMIN_USERNAME) {
        $error = 'Wrong username.';
    } elseif ($ADMIN_PASSWORD_HASH && password_verify($pass, $ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_authenticated'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Wrong password.';
    }
}

// Require authentication
if (empty($_SESSION['admin_authenticated'])) {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Admin Panel Login</title>
      <style>.auth-card{max-width:420px;margin:3rem auto;padding:1.2rem}</style>
    </head>
    <body>
      <main class="auth-card">
        <h2>Admin Panel Login</h2>
        <?php if (!empty($error)) echo '<p style="color:#c00">'.htmlspecialchars($error).'</p>'; ?>
        <form method="post">
          <label>Username
            <input name="admin_user" type="text" required>
          </label><br>
          <label>Password
            <input name="admin_pass" type="password" required>
          </label><br>
          <button type="submit">Login</button>
        </form>
      </main>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        h1 { text-align: center; }
        ul { list-style: none; padding: 0; text-align: center; }
        li { display: inline-block; margin: 10px; }
        a { text-decoration: none; padding: 10px 20px; background: #333; color: #fff; border-radius: 5px; }
        a:hover { background: #555; }
        .content { width: 80%; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>Welcome to Admin Panel</h1>
    <ul>
        <li><a href="?page=users">Users</a></li>
        <li><a href="?page=recipes">Recipes</a></li>
        <li><a href="?page=settings">Settings</a></li>
        <li><a href="?page=files">Files</a></li>
        <li><a href="?page=stats">Statistics</a></li>
        <li><a href="admin.php?action=logout">Logout</a></li>
    </ul>

    <div class="content">
        <?php
        if(isset($_GET['page'])) {
            switch($_GET['page']) {
                case "users":
                echo "<h2>User Management</h2>";

                // Database connection (replace with your data)
                $conn = new mysqli("localhost","root","","cookingdb");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Add user
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
                    $username = $conn->real_escape_string($_POST['username']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $conn->query("INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')");
                    echo "<p style='color:green'>User added successfully!</p>";
                }

                // Delete user
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
                    $id = (int)$_POST['delete_user'];
                    $conn->query("DELETE FROM users WHERE id=$id");
                    echo "<p style='color:red'>User deleted!</p>";
                }

                // Display user list
                $result = $conn->query("SELECT id, username, email FROM users");
                if ($result->num_rows > 0) {
                    echo "<table border='1' cellpadding='6' style='width:100%;border-collapse:collapse'>";
                    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Actions</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".htmlspecialchars($row['username'])."</td>";
                        echo "<td>".htmlspecialchars($row['email'])."</td>";
                        echo "<td>
                            <form method='post' style='display:inline'>
                              <input type='hidden' name='delete_user' value='".$row['id']."'>
                              <button type='submit' onclick='return confirm(\"Delete user?\")'>Delete</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No users.</p>";
                }

                // Add form
                ?>
                <h3>Add new user</h3>
                <form method="post">
                  <input type="hidden" name="add_user" value="1">
                  <label>Username: <input type="text" name="username" required></label><br>
                  <label>Email: <input type="email" name="email" required></label><br>
                  <label>Password: <input type="password" name="password" required></label><br>
                  <button type="submit">Add</button>
                </form>
                <?php

                $conn->close();
                break;

                    
                case "recipes":
                    echo "<h2>Recipe Management</h2>";
                    echo "<p>Add new recipes or edit existing ones.</p>";
                    break;
                case "settings":
                    echo "<h2>Site Settings</h2>";
                    echo "<p>Change site name, language, header text.</p>";
                    break;
                case "files":
                    echo "<h2>File Management</h2>";
                    echo "<p>Upload new images or delete old ones.</p>";
                    break;
                case "stats":
                    echo "<h2>Statistics</h2>";
                    echo "<p>Show number of visits, latest logins.</p>";
                    break;
                default:
                    echo "<h2>Welcome to Admin Panel</h2>";
            }
        } else {
            echo "<h2>Select section from menu</h2>";
        }
        ?>
    </div>
</body>
</html>
