<?php require "../templates/partials/header_login.php"; ?>

<div class="top_space">
    <h3>Logowanie</h3>
</div>
<form method="POST">
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <label for="password">Hasło</label>
    <input type="password" name="password" required>
    <button type="submit">Zaloguj</button>
    <ul>
        <?php foreach ($error_messages as $msg): ?>
        <li><?= $msg ?></li>
        <?php endforeach; ?>
    </ul>
</form>
<a href="/signup">Załóż konto</a>

<?php require "../templates/partials/footer_login.php"; ?>
