<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stado</title>
 <link rel="stylesheet" href="pico.min.css">
 <link rel="stylesheet" href="main.css">
</head>

<body>
  <main class="container">
    <h3><a href="/">Stado</a></h3>
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
  </main>
</body>


</html>
