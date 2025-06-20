<?php
declare(strict_types=1);

require "../templates/components/user-header.php";
?>
<section>
    <h5>Dane</h5>
    <table class="stiped">
        <tr>
            <th>Email:</th>
            <td><?= $user["email"] ?></td>
        </tr>
    </table>
</section>
<h5>Powiadomienia:</h5>
<form method="POST" action="/account-update" acc>
    <input type="text" value="<?= $token ?>" hidden required>
    <h6>Sprawdzenie cielności</h6>
    <label for="preg_check">Ilość dni od daty inseminacji:</label>
    <input type="number" value="<?= $user["preg_check"] ?>" required>
    <h6>Zasuszenie</h6>
    <label for="dry_check">Ilość dni przed wycieleniem:</label>
    <input type="number" value="<?= $user["dry_check"] ?>" required>
    <h6>Wycielenie</h6>
    <label for="due_check">Ilość dni przed wycieleniem:</label>
    <input type="number" value="<?= $user["due_check"] ?>" required>
    <button type="submit">Aktualizuj dane</button>
</form>
<hr>
<p><sup>Ostatnia aktualizacja: <?= date("d-m-Y G:i", $user["last_update"]) ?>.</sup></p>


<?php require "../templates/components/user-footer.php"; ?>
