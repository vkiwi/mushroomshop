<?php
    require_once 'parts/header.php';

    if (isset($_GET['cat'])) {
        $currentCat = $_GET['cat'];
        if ($currentCat == 'edible' || $currentCat == 'wood' || $currentCat == 'poisonous') {
            $products = $connect->query("SELECT * FROM products WHERE cat='$currentCat'");
            $products = $products->fetchAll(PDO::FETCH_ASSOC);
        } else {
           echo "<script>alert('Не балуй!') </script>";
           echo "<h1>Такой категории нет.</h1>";
        }
    } else {
        $products = $connect->query("SELECT * FROM products");
        $products = $products->fetchAll(PDO::FETCH_ASSOC);
    }

//    echo "<pre>";
//    var_dump($products);
//    echo "</pre>";

?>

    <div class="main">
        <? foreach ($products as $product) {?>
        <div class="card">
            <a href="product.php?product=<?=$product['title']?>">
                <img src="img/<?= $product['img'] ?>" alt="<?= $product['rus_name'] ?>">
            </a>
            <div class="label"><?= $product['rus_name'] ?> (<?= $product['price'] ?> рублей)</div>
            <? require 'parts/add-form.php'?>
        </div>
        <?}?>

    </div>

</body>
</html>

