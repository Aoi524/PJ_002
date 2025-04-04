<?php
// 必ずファイルの先頭からコードを記述
session_start();
// データベース接続
try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=blog_db;charset=utf8mb4',
        'user',
        'password',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
    exit;
}
// フォームデータの取得
$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$id = $_GET['id'] ?? '';
// データベースの更新
$stmt = $pdo->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
$stmt->execute([
    ':title' => $title,
    ':content' => $content,
    ':id' => $id,
]);
// ヘッダー送信前に出力がないことを確認
header('Location: /list.php');
exit;
?>