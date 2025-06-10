<?php require "../templates/partials/header.php"; ?>

<table class="striped">
    <thead>
    <tr>
        <th>Numer identyfikacyjny</th>
        <th>Data inseminacji</th>
        <th>Status</th>
        <th>Data wycielenia</th>
        <th>Możliwa akcja</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($cows as $cow): ?>
    <tr>

        <td><a href="/cow?id=<?= $cow["id"] ?>"><?= $cow["id"] ?></a></td>
        <td><?= $cow["ins_date"] ?></td>
        <td><?= $cow["state"] ?></td>
        <td><?= $cow["due_date"] ?></td>
        <td><?= isset($cow["action"]) ? "🔴" : "" ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require "../templates/partials/footer.php"; ?>
