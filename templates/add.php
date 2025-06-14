<?php require "../templates/partials/header.php"; ?>

<div class="grid">
    <div></div>
    <div>
        <h3>Dane krowy:</h3>
        <form method="POST">
            <label for="id">Numer identyfikacyjny:<br>(np. PL005669126852)</label>
            <input type="text" name="id" required>
            <label for="ins_date">Data inseminacji:</label>
            <input type="date" name="ins_date">
            <label for="status">Stan krowy:</label>
            <select name="status" required>
                <option selected disabled value="">Wybierz status</option>
                <?php foreach ($statuses as $status): ?>
                <option value="<?= $status ?>"><?= $status ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Dodaj krowe</button>
            <ul>
                <?php foreach ($error_messages as $msg): ?>
                <li><?= $msg ?></li>
                <?php endforeach; ?>
            </ul>
        </form>
    </div>
    <div></div>
</div>

<?php require "../templates/partials/footer.php"; ?>
