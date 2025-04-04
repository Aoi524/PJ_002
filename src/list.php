<?php
// src/list.php
// 投稿一覧を表示するページ

try {
    // データベース接続
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
    // エラーメッセージを表示
    echo 'データベース接続エラー: ' . $e->getMessage();
    exit;
}

// データベースの初期化
$create_table_sql = $pdo->prepare('
    CREATE TABLE IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
');
$create_table_sql->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>PHP Blog</title>
</head>
<body>
    <!-- ナビゲーション -->
    <div class="container my-3">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">PHP Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/list.php">一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form.php">投稿</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- テストデータ -->
        <?php
            // $posts = [
            //     ['title' => 'タイトル1', 'content' => '内容1'],
            //     ['title' => 'タイトル2', 'content' => '内容2'],
            //     ['title' => 'タイトル3', 'content' => '内容3'],
            // ];
            // データベースから投稿を取得
            $stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <!-- 投稿一覧 -->
        <div class="container my-3">
            <h3>投稿一覧</h3>
            <?php if (empty($posts)): ?>
                <p class="text-center">投稿はありません。</p>
            <?php endif; ?>
            <?php foreach ($posts as $post): ?>
                <div class="card my-3">
                    <div class="card-header">
                        <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start gap-3">
                                <div class="col-auto">
                                    <a href="/edit.php" class="btn btn-primary">編集</a>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-danger">削除</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0">投稿日時: <?php echo date('Y-m-d H:i:s'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>