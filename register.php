<?php
// Simple registration endpoint for local XAMPP development.
// Accepts POST: name, email, password (password is not used securely here — demo only).
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Only POST allowed']);
    exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (!$name || !$email || !$password) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

// sanitize filename: allow letters, numbers, dash, underscore
$base = preg_replace('/[^a-zA-Z0-9_-]/', '_', substr($name, 0, 40));
$timestamp = time();
$filename = "users/{$timestamp}_{$base}.html";

// basic HTML user page template
$html = "<!doctype html>\n<html lang=\"ru\">\n<head>\n  <meta charset=\"utf-8\">\n  <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n  <title>Профиль пользователя - " . htmlspecialchars($name, ENT_QUOTES) . "</title>\n  <link rel=\"stylesheet\" href=\"../style.css?v=2\">\n</head>\n<body>\n  <main class=\"container\">\n    <section class=\"profile\">\n      <h1>" . htmlspecialchars($name, ENT_QUOTES) . "</h1>\n      <p>Email: " . htmlspecialchars($email, ENT_QUOTES) . "</p>\n      <p>Это автоматически сгенерированная страница профиля (демо).</p>\n      <p><a href=\"../account.html\">Вернуться в аккаунт</a></p>\n    </section>\n  </main>\n</body>\n</html>";

// attempt to write file
if (file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . $filename, $html) === false) {
    echo json_encode(['success' => false, 'error' => 'Не удалось записать файл']);
    exit;
}

// return the created URL (relative)
$url = $filename;
echo json_encode(['success' => true, 'url' => $url]);
exit;
?>