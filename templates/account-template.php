<?php
declare(strict_types=1);

require "../templates/components/user-header.php";
?>
<h5>Dane</h5>
<section class="grid">
    <table class="stiped tble">
        <tr>
            <th>Email:</th>
            <td><?= $user["email"] ?></td>
        </tr>
        <tr>
            <th>Ilość krów:</th>
            <td><?= $cow_data["total"] ?></td>
        </tr>
        <tr>
            <th>Ilość krów niezacielonych:</th>
            <td><?= $cow_data["Niezacielona"] ?></td>
        </tr>
        <tr>
            <th>Ilość krów zacielonych:</th>
            <td><?= $cow_data["Zacielona"] ?></td>
        </tr>
        <tr>
            <th>Ilość krów sprawdzonych:</th>
            <td><?= $cow_data["Sprawdzona"] ?></td>
        </tr>
        <tr>
            <th>Ilość krów zasuszonych:</th>
            <td><?= $cow_data["Zasuszona"] ?></td>
        </tr>
    </table>
    <div></div>
</section>

<form method="POST" action="/account-update" acc>
    <input name="token" type="text" value="<?= $token ?>" hidden ?>
    <section>
    <h5>Długość ciąży</h5>
     <label for="ges_period">Średnia długość ciąży w dniach:</label>
     <input name="ges_period" type="number" value="<?= $user["ges_period"] ?>" required>
    </section>
    <h5>Powiadomienia:</h5>
    <input type="text" value="<?= $token ?>" hidden required>
    <h6>Sprawdzenie cielności</h6>
    <label for="preg_check">Ilość dni od daty inseminacji:</label>
    <input name="preg_check" type="number" value="<?= $user["preg_check"] ?>" required>
    <h6>Zasuszenie</h6>
    <label for="dry_check">Ilość dni przed wycieleniem:</label>
    <input name="dry_check" type="number" value="<?= $user["dry_check"] ?>" required>
    <h6>Wycielenie</h6>
    <label for="due_check">Ilość dni przed wycieleniem:</label>
    <input name="due_check" type="number" value="<?= $user["due_check"] ?>" required>
    <button type="submit">Aktualizuj dane</button>
</form>
<hr>
<p><sup>Ostatnia aktualizacja: <?= date("d-m-Y G:i", $user["last_update"]) ?>.</sup></p>


<?php require "../templates/components/user-footer.php"; ?>
