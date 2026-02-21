<?php
// Simple order handler (demo). Writes order to orders/ as JSON and returns a confirmation page.
header('Content-Type: text/html; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<p>Invalid request.</p>';
    exit;
}
$package = isset($_POST['package']) ? preg_replace('/[^a-z0-9_\-]/i','',$_POST['package']) : 'starter';
$name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$email = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
$address = isset($_POST['customer_address']) ? trim($_POST['customer_address']) : '';
if (!$name || !$email) {
    echo '<p>Пожалуйста заполните имя и email. <a href="order.html?package='.htmlspecialchars($package).'">Назад</a></p>';
    exit;
}
$timestamp = time();
$filename = "orders/{$timestamp}_" . preg_replace('/[^a-z0-9_\-]/i','_',substr($name,0,30)) . ".json";
$order = [
    'package'=>$package,
    'name'=>$name,
    'email'=>$email,
    'address'=>$address,
    'created_at'=>date('c'),
];
file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . $filename, json_encode($order, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$displayPackage = ['starter'=>'Старт','$price_starter'=>5, 'popular'=>'Популярный', 'premium'=>'Премиум'];
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Спасибо за заказ</title>
  <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
  <main class="container">
    <h1>Спасибо, <?php echo htmlspecialchars($name); ?>!</h1>
    <p>Ваш заказ пакета <strong><?php echo htmlspecialchars($package); ?></strong> зарегистрирован.</p>
    <p>Мы отправили подтверждение на <strong><?php echo htmlspecialchars($email); ?></strong> (демо).</p>
    <p>Файл заказа: <code><?php echo htmlspecialchars($filename); ?></code></p>
    <p><a href="admin.php">Админ: посмотреть заказы</a> (dev)</p>
    <p><a href="index.html">Вернуться на сайт</a></p>
  </main>
</body>
</html>
