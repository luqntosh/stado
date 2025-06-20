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
            <th></th>
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
            <td><?= isset($cow["action"]) ? "🔴" : "" ?></td>
            <td><a onclick="delete_cow(<?= $cow["id"] ?>, '<?= $cow["cow_id"] ?>');">Usuń</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="right">
    <a href="/add">Dodaj krowę</a>
</div>
 <script src="cows.js"></script>
 <dialog id="del_dialog">
    <article class="small_pad">
        <hr>
        <form id="del_form" method="POST" action="/del">
            <label for="id" id="label_id"></label>
            <p><strong>Czynności nie da się cofnąć!</strong></p>
            <input id="del_id" name="id" type="number" hidden>
            <div class="grid top_space">
                <div></div>
                <div></div>
                <button type="button" onclick="close_dialog()">Nie</button>
                <button type="submit">Tak</button>
            </div>
        </form>
    </article>
 </dialog>
<?php require "../templates/components/user-footer.php"; ?>
