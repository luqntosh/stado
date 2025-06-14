<?php require "../templates/partials/header.php"; ?>

<section>
    <h6>Dane</h6>
    <table class="striped tble">
    <tr>
        <th scope="row">Numer identyfikacyjny:</th>
        <td><?= $cow["cow_id"] ?></td>
    </tr>
    <tr>
        <th scope="row">Data inseminacji:</th>
        <td><?= $cow["ins_date"] ?></td>
    </tr>
    <tr>
        <th scope="row">Status:</th>
        <td><?= $cow["state"] ?></td>
    </tr>
    <tr>
        <th scope="row">Data wycielenia:</th>
        <td><?= $cow["due_date"] ?></td>
    </tr>
    </table>
</section>
    <?php if (!empty($history)): ?>
    <h6>Historia</h6>
    <section class="history">
    <table class="striped">
        <thead>
            <tr>
            <th>Data zdarzenia</th>
            <th>Zdarzenie</th>
            <th>Uwagi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $event): ?>
            <tr>
                <td><?= $event["date"] ?></td>
                <td><?= $event["event"] ?></td>
                <td><?= $event["text"] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </section>
    <?php endif; ?>
<section>
    <h6>Dodaj zdarzenie</h6>
    <form method="POST">
    <input type="text" name="cow_id" hidden value="<?= $cow["id"] ?>">
    <label for="event_date">Data:</label>
    <input type="date" name="event_date" required value="<?= date("Y-m-d") ?>">
    <label for="event">Zdarzenie:</label>
    <select name="event" required>
        <option selected disabled value="">Wybierz zdarzenie</option>
        <?php foreach ($events as $event): ?>
        <option value="<?= $event ?>"><?= $event ?></option>
        <?php endforeach; ?>
    </select>
    <label for="text">Uwagi:</label>
    <textarea name="text"></textarea>
    <button type="submit">Dodaj</button>
    </form>
</section>

<?php require "../templates/partials/footer.php"; ?>
