<?php

declare(strict_types=1);

require "../templates/components/user-header.php";
?>

<section>
    <table class="striped">
        <thead>
        <tr>
            <th>Numer identyfikacyjny</th>
            <th>Nazwa</th>
            <th>Data inseminacji</th>
            <th>Status</th>
            <th>Data wycielenia</th>
            <th>Możliwa akcja</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cows as $cow): ?>
        <tr>
            <td><a href="/cow?id=<?= $cow["cow_id"] ?>"><?= $cow["cow_id"] ?></a></td>
            <td><?= $cow["name"] ?></td>
            <td><?= $cow["ins_date"] ?></td>
            <td><?= $cow["status"] ?></td>
            <td><?= $cow["due_date"] ?></td>
            <td><?= $cow["next_event"] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<hr>
<div class="right">
    <a href="/cow-form">Dodaj krowę</a>
</div>

<?php require "../templates/components/user-footer.php"; ?>
