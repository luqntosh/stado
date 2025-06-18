<?php
declare(strict_types=1);

require "../templates/components/guest-header.php";
?>

<div class="top_space">
    <h3>Logowanie</h3>
</div>
<form method="POST" action="/account-login">
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <label for="password">Hasło</label>
    <input type="password" name="password" required>
    <button type="submit">Zaloguj</button>
    <ul class="red">
        <?php foreach ($error_messages as $msg): ?>
        <li><?= $msg ?></li>
        <?php endforeach; ?>
    </ul>
</form>
<a href="/signup">Załóż konto</a>

<?php require "../templates/components/guest-footer.php"; ?>
