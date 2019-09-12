<?php
session_start();

require_once('./BlackJack.php');

if (isset($_POST['action'])) {
    $blackjack = new BlackJack(new Dealer, new User, new Deck);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BlackJack</title>
</head>
<body>

<?php if (!isset($blackjack)) : ?>

    <h2>ゲームを開始します</h2>
    <form action="" method="POST">
        <input type="submit" name="action" value="start">
    </form>

<?php else : ?>

    <?php foreach ($_SESSION['message'] as $row) : ?>
    <p><?= $row ?></p>
    <?php endforeach; ?>

    <p>あなたの得点は<?= $_SESSION['user']['score'] ?>です。</p>

    <?php if (isset($_SESSION['judge'])) : ?>

        <?php if ($_SESSION['judge']['isBurst']) : ?>
        
        <p><?= $_SESSION['judge']['looser'] ?>はバーストしました。</p>

        <?php endif; ?>
    
    <p>ディーラーの得点は<?= $_SESSION['dealer']['score']; ?>でした。</p>
        
    <p><?= $_SESSION['judge']['winner'] ?>の勝ちです。</p>

    <?php elseif (isset($_SESSION['tie'])) : ?>

    <p>同点です。</p>
    <p>ディーラーの得点は<?= $_SESSION['dealer']['score']; ?>でした。</p>

    <?php else : ?>

    <p>どうしますか？</p>
    <form action="" method="POST">
        <input type="submit" name="action" value="draw">
        <input type="submit" name="action" value="stop">
    </form>

    <?php endif; ?>

    <form action="" method="POST">
        <input type="submit" name="action" value="reset">
    </form>

<?php endif; ?>
</body>
</html>
