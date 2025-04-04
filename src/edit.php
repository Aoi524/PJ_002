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
    </div>
    <!-- 編集画面 -->
    <div class="container my-3">
        <h3>編集画面</h3>
        <?php
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

            // データベースから投稿を取得
            $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
            $stmt->execute([':id' => $_GET['id']]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$post) {
                echo '<p class="text-danger">投稿が見つかりません。</p>';
                exit;
            }
        ?>
        <form method="post" action="/update.php?id=<?php echo htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">内容</label>
                <textarea class="form-control" id="content" name="content" rows="5"><?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>