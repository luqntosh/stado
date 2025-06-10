<?php require "../templates/partials/header.php"; ?>

<div class="grid">
    <div></div>
    <div>
        <section>
            <h6>Dane</h6>
            <table class="striped tble">
            <tr>
                <th scope="row">Numer identyfikacyjny:</th>
                <td><?= $cow["id"] ?></td>
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
            <section class="history">
            <h6>Historia</h6>
            <table class="striped">
            <thead>
                <tr>
                <th>Data zdarzenia</th>
                <th>Zdarzenie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $event): ?>
                <tr>
                    <td><?= $event["date"] ?></td>
                    <td><?= $event["event"] ?></td>
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
            <input type="date" name="event_date" required value="<?= date(
                "Y-m-d"
            ) ?>">
            <select name="event" required>
                <option selected disabled value="">Wybierz zdarzenie</option>
                <?php foreach ($events as $event): ?>
                <option value="<?= $event ?>"><?= $event ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Dodaj</button>
            </form>
        </section>
    </div>
    <div></div>
</div>

<?php require "../templates/partials/footer.php"; ?>
