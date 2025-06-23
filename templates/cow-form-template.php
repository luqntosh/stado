<?php

declare(strict_types=1);

require "../templates/components/user-header.php";
?>

<div class="grid">
    <div></div>
    <div>
        <h3>Dane krowy:</h3>
        <form method="POST" action="/cow-add">
            <input type="text" name="token" hidden required value="<?= $token ?>"
            <label for="id">Numer identyfikacyjny:<br>(np. PL005669126852)</label>
            <input type="text" name="id" value="<?= $id ?? "" ?>" required>
            <label for="name">Nazwa:</label>
            <input type="text" name="name" value="<?= $name ?? "" ?>">
            <button type="submit">Dodaj krowe</button>
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
