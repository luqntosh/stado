<?php

declare(strict_types=1);

require "../templates/components/user-header.php";
?>

<ul class="red">
    <?php foreach ($error_messages as $msg): ?>
    <li><?= $msg ?></li>
    <?php endforeach; ?>
</ul>
<section>
    <h6>Dane</h6>
    <table class="striped tble">
    <tr>
        <th scope="row">Numer identyfikacyjny:</th>
        <td><?= $cow["cow_id"] ?></td>
    </tr>
    <tr>
        <th scope="row">Nazwa:</th>
        <td><?= $cow["name"] ?></td>
    </tr>
    <tr>
        <th scope="row">Data inseminacji:</th>
        <td><?= $cow["ins_date"] ?></td>
    </tr>
    <tr>
        <th scope="row">Status:</th>
        <td><?= $cow["status"] ?></td>
    </tr>
    <tr>
        <th scope="row">Data wycielenia:</th>
        <td><?= $cow["due_date"] ?></td>
    </tr>
    <tr>
        <th scope="row">Możliwa akcja:</th>
        <td><?= $cow["next_event"] ?></td>
    </tr>
    </table>
</section>
<section class="grid">
    <button class="secondary" type="button" onclick="location.href='/cow-edit?id=<?= $cow["cow_id"] ?>'">Edytuj</button>
    <button class="secondary" type="button" onclick="show_dialog()">Usuń</button>
    <script src="cow.js"></script>
    <dialog id="del_dialog">
       <article class="small_pad">
           <hr>
           <form id="del_form" method="POST" action="/cow-delete">
               <input type="text" name="token" hidden value="<?= $token ?>" >
               <label for="cow_id">Czy napewno checesz usunąć krowe o numereze <?= $cow["cow_id"] ?>?</label>
               <p><strong>Czynności nie da się cofnąć!</strong></p>
               <input name="cow_id" type="text" value="<?= $cow["cow_id"] ?>" hidden>
               <div class="grid top_space">
                   <div></div>
                   <div></div>
                   <button type="button" onclick="close_dialog()">Nie</button>
                   <button type="submit">Tak</button>
               </div>
           </form>
       </article>
    </dialog>
</section>
<?php if (!empty($old_events)): ?>
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
            <?php foreach ($old_events as $event): ?>
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
    <form method="POST" action="/cow-event">
        <input type="text" name="token" hidden value="<?= $token ?>" >
        <input type="text" name="cow_id" hidden value="<?= $cow["cow_id"] ?>">
        <label for="event_date">Data:</label>
        <input type="date" name="event_date" required value="<?= date("Y-m-d") ?>">
        <label for="event">Zdarzenie:</label>
        <select name="event" required>
            <?php if (!$cow["next_event"]): ?>
                <option selected disabled value="">Wybierz zdarzenie</option>
                <?php foreach ($events as $event): ?>
                <option value="<?= $event ?>"><?= $event ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option disabled value="">Wybierz zdarzenie</option>
                <?php foreach ($events as $event): ?>
                <option <?= $cow["next_event"] == $event ||
                ($cow["next_event"] == "Sprawdzenie" && $event == "Cielna (sprawdzenie)")
                    ? "selected"
                    : "" ?> value="<?= $event ?>"><?= $event ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <label for="text">Uwagi:</label>
        <textarea name="text"></textarea>
        <button type="submit">Dodaj</button>
    </form>
</section>

<?php require "../templates/components/user-footer.php"; ?>
