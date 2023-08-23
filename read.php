<?php
$dsn = 'mysql:dbname=php_db_app;host=localhost;charset=utf8mb4';
$user = 'root';
// MAMPを利用しているMacユーザーの方は、''ではなく'root'を代入してください
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);

    // productsテーブルからすべてのカラムのデータを取得するためのSQL文を変数$sqlに代入する
    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    } else {
        $order = NULL;
    }

         // keywordパラメータの値が存在すれば（商品名を検索したとき）、その値を変数$keywordに代入する    
     if (isset($_GET['keyword'])) {
         $keyword = $_GET['keyword'];
     } else {
         $keyword = NULL;
     }

    if ($order === 'desc') {
        $sql_select = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at DESC';    
    } else {
        $sql_select = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at ASC';
    }

     // SQL文を用意する
     $stmt_select = $pdo->prepare($sql_select);
 
     // SQLのLIKE句で使うため、変数$keyword（検索ワード）の前後を%で囲む（部分一致）
     // 補足：partial match＝部分一致
     $partial_match = "%{$keyword}%";
 
     // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
     $stmt_select->bindValue(':keyword', $partial_match, PDO::PARAM_STR);
 
     // SQL文を実行する
     $stmt_select->execute();

    // SQL文の実行結果を配列で取得する
    $products = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>

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
    <main style="
        display: flex;
        flex-flow: column;
        align-items: center;
        justify-content: center;
    ">
        <article>
            <h1>商品一覧</h1>
            <?php
             // （商品の登録・編集・削除後）messageパラメータの値を受け取っていれば、それを表示する
             if (isset($_GET['message'])) {
                 echo "<p>{$_GET['message']}</pclass=>";
             }
             ?>
            <div style="display: flex;">
                <div style="display: flex; justify-content: start;">
                    <a href="read.php?order=desc&keyword=<?= $keyword ?>" style="text-decoration: none; margin-top: 1rem;">
                        <img src="images/desc.png" alt="降順に並び替え" style="width: 2rem;">
                    </a>
                    <a href="read.php?order=asc&keyword=<?= $keyword ?>" style="margin-top: 1rem;">
                        <img src="images/asc.png" alt="昇順に並び替え" style="width: 2rem;">
                    </a>
                    <form action="read.php" method="get" style="margin: 1rem;">
                        <input type="hidden" name="order" value="<?= $order ?>">
                        <input type="text" placeholder="商品名で検索" name="keyword" value="<?= $keyword ?>">
                    </form>
                </div>
                <div style="
                    width:100%;
                    display: flex;
                    margin: 1rem;
                    justify-content: end;
                ">
                <a href="create.php" style="
                    text-decoration: none;
                    color: black;
                    background-color: yellow;
                    padding: 0.5rem;
                    border-radius: 0.2rem;
                    box-shadow: 0.2rem 0.2rem 0.2rem rgb(0 0 0 / 15%);                    
                ">
                    商品登録
                </a>

                </div>
            </div>
            <table style="border-collapse: collapse; margin: 1rem;">
                <tr>
                    <th>商品コード</th>
                    <th>商品名</th>
                    <th>単価</th>
                    <th>在庫数</th>
                    <th>仕入先コード</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
                <?php
                // 配列の中身を順番に取り出し、表形式で出力する
                foreach ($products as $product) {
                    $table_row = "
                        <tr style='border-bottom: 1px solid gray; width: 100%; height: 4rem;'>
                        <td>{$product['product_code']}</td>
                        <td>{$product['product_name']}</td>
                        <td style='width: 4rem;'>{$product['price']}</td>
                        <td style='width: 4rem;'>{$product['stock_quantity']}</td>
                        <td style='width: 8rem;'>{$product['vendor_code']}</td>
                        <td style='width: 4rem;'>
                            <a href='update.php?id={$product['id']}'>
                                <img src='images/edit.png' alt='編集' style='width: 1rem;'>
                            </a>
                        </td>                     
                        <td style='width: 4rem;'>
                            <a href='delete.php?id={$product['id']}'>
                                <img src='images/delete.png' alt='削除' style='width: 1rem;'>
                            </a>
                        </td>                     
                        </tr>
                    ";
                    echo $table_row;
                }
                ?>
            </table>
        </article>
    </main>
    <footer style="margin: 4rem;">
        <p>&copy; 商品管理アプリ All rights reserved.</p>
    </footer>
</body>

</html>
