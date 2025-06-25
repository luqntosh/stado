<?php

declare(strict_types=1);

require "../templates/components/user-header.php";
?>

<div class="grid">
    <div></div>
    <div>
        <h3>Edytuj krowe o numerze <?= $cow["cow_id"] ?></h3>
        <form method="POST" action="/cow-update">
            <input type="text" name="token" hidden required value="<?= $token ?>">
            <input type="text" name="old_id" hidden required value="<?= $cow["cow_id"] ?>">
            <label for="id">Numer identyfikacyjny:</label>
            <input type="text" name="id" value="<?= $cow["cow_id"] ?>" required>
            <label for="name">Nazwa:</label>
            <input type="text" name="name" value="<?= $name ?? $cow["name"] ?>">
            <button type="submit">Zaktualizuj</button>
            <ul class="red">
                <?php foreach ($error_messages as $msg): ?>
                <li><?= $msg ?></li>
                <?php endforeach; ?>
            </ul>
        </form>
    </div>
    <div></div>
</div>

<?php require "../templates/components/user-footer.php"; ?>
