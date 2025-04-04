<?php
// 必ずファイルの先頭からコードを記述
session_start();

// フォームデータの取得
$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';

// データベース接続や処理
try {
    $pdo = new PDO('mysql:host=mysql;dbname=blog_db;charset=utf8mb4', 'user', 'password');
    $stmt = $pdo->prepare('INSERT INTO posts (title, content) VALUES (:title, :content)');
    $stmt->execute([
        ':title' => $_POST['title'],
        ':content' => $_POST['content'],
    ]);
} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
    exit;
}

// ヘッダー送信前に出力がないことを確認
header('Location: /list.php');
exit;

?>