<?php
// Admin panel with simple password protection (development only).
session_start();

// Load admin config if exists
$configFile = __DIR__ . DIRECTORY_SEPARATOR . 'admin_config.php';
$ADMIN_PASSWORD_HASH = null; // set by config
if (file_exists($configFile)) {
    include $configFile; // should set $ADMIN_PASSWORD_HASH
}

// If logout requested
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_authenticated']);
    header('Location: admin.php');
    exit;
}

// Handle login (username + password)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_pass'])) {
  $pass = $_POST['admin_pass'];
  $user = isset($_POST['admin_user']) ? trim($_POST['admin_user']) : '';
  if (isset($ADMIN_USERNAME) && $ADMIN_USERNAME !== '' && $user !== $ADMIN_USERNAME) {
    $error = 'Неверный логин.';
  } elseif ($ADMIN_PASSWORD_HASH && password_verify($pass, $ADMIN_PASSWORD_HASH)) {
    $_SESSION['admin_authenticated'] = true;
    header('Location: admin.php');
    exit;
  } else {
    $error = 'Неверный пароль.';
  }
}

// Require authentication
if (empty($_SESSION['admin_authenticated'])) {
    // show login form
    ?>
    <!doctype html>
    <html lang="ru">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Вход в админ — Кулинарный Класс</title>
      <link rel="stylesheet" href="style.css?v=2">
      <style>.auth-card{max-width:420px;margin:3rem auto;padding:1.2rem}</style>
    </head>
    <body>
      <main class="container auth-section">
        <div class="auth-card">
          <h2>Войти в админ-панель</h2>
          <?php if (!empty($error)) echo '<p style="color:#c00">'.htmlspecialchars($error).'</p>'; ?>
          <form method="post">
            <label>Логин
              <input name="admin_user" type="text" required>
            </label>
            <label>Пароль администратора
              <input name="admin_pass" type="password" required>
            </label>
            <div style="margin-top:.6rem;"><button class="btn" type="submit">Войти</button></div>
          </form>
          <p style="margin-top:.6rem;font-size:.9rem;color:#666">Если вы продаёте сайт, передайте покупателю этот пароль или попросите его установить свой.</p>
        </div>
      </main>
    </body>
    </html>
    <?php
    exit;
}

// Authenticated: list and delete
function list_users() {
    $dir = __DIR__ . DIRECTORY_SEPARATOR . 'users';
    $items = [];
    if (!is_dir($dir)) return $items;
    $files = scandir($dir);
    foreach ($files as $f) {
        if (in_array($f, ['.','..'])) continue;
        $path = 'users/' . $f;
        $items[] = ['name'=>$f, 'path'=>$path];
    }
    return $items;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $file = basename($_POST['delete']);
    $target = __DIR__ . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $file;
    if (file_exists($target)) {
        unlink($target);
        header('Location: admin.php');
        exit;
    }
}

$users = list_users();
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Админ — Кулинарный Класс</title>
  <link rel="stylesheet" href="style.css?v=2">
  <style>table{width:100%;border-collapse:collapse}td,th{padding:.6rem;border:1px solid #eee}</style>
</head>
<body>
  <main class="container">
    <h1>Админ: Пользовательские страницы</h1>
    <p><a href="admin.php?action=logout">Выйти</a></p>
    <?php if (empty($users)): ?>
      <p>Пользовательских страниц нет.</p>
    <?php else: ?>
      <table>
        <thead><tr><th>Файл</th><th>Действия</th></tr></thead>
        <tbody>
        <?php foreach($users as $u): ?>
          <tr>
            <td><a href="<?php echo htmlspecialchars($u['path']); ?>" target="_blank"><?php echo htmlspecialchars($u['name']); ?></a></td>
            <td>
              <form method="post" style="display:inline">
                <input type="hidden" name="delete" value="<?php echo htmlspecialchars($u['name']); ?>">
                <button type="submit" onclick="return confirm('Удалить?')" class="btn btn-danger">Удалить</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
    <p><a href="index.html">Вернуться на сайт</a></p>
  </main>
</body>
</html>
