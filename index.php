<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理アプリ</title>

    <!-- Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body style="text-align: center;">
    <header style="display: flex;
        align-items: center;
        background-color: red;
        color: white;
        height: 8vh;
    ">
        <nav>
            <a href="index.php" style="
                text-decoration: none;
                color: white;
                margin-left: 5rem;
            ">
                商品管理アプリ
            </a>
        </nav>
    </header>
    <main style="display: flex;
        flex-flow: column;
        align-items: center;
        justify-content: center;
        height: 80vh;
    ">
        <article style=
            "display: flex;
            flex-flow: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        ">
            <h1>商品管理アプリ</h1>
            <p style="margin: 1rem;">『PHPとデータベースを連携しよう』成果物</p>
            <a href="read.php" class="btn" style="
                text-decoration: none;
                color: black;
                background-color: yellow;
                padding: 0.5rem;
                margin: 4rem;
                border-radius: 0.2rem;
                box-shadow: 0.2rem 0.2rem 0.2rem rgb(0 0 0 / 15%);
            ">
                商品一覧
            </a>
        </article>
    </main>
    <footer>
        <p>&copy; 商品管理アプリ All rights reserved.</p>
    </footer>
</body>

</html>
