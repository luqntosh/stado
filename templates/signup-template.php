<?php

declare(strict_types=1);

require "../templates/components/guest-header.php";
?>

<div class="top_space">
<h3>Załóż Konto</h3>
</div>
<form method="POST" action="/account-signup">
    <input type="text" name="token" value="<?= $token ?>" hidden>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <label for="password">Hasło</label>
    <input type="password" name="password" required>
    <button type="submit">Utwórz konto</button>
    <ul class="red">
        <?php foreach ($error_messages as $msg): ?>
        <li><?= $msg ?></li>
        <?php endforeach; ?>
    </ul>
</form>
<a href="/login">Logowanie</a>

<?php require "../templates/components/guest-footer.php"; ?>
