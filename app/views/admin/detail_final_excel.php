<!DOCTYPE html>
<html>
<head>
  <title>Data Peserta Finalisasi</title>
</head>
<body>

<h3>Data Peserta Finalisasi <?= $jenis; ?></h3>
<a href="<?= site_url('me/download/'.$jenis); ?>">Download</a>
<br><br>

<table border="1" cellspacing="0" cellpadding="3">
  <tr>
    <th>No. Peserta</th>
    <th>Nama</th>
  </tr>

  <?php foreach($data as $item): ?>

    <tr>
      <td style="font-size: 20px;"><?= strtoupper($item->no_peserta_fix); ?></td>
      <td style="font-size: 20px;"><?= strtoupper($item->nama); ?></td>
    </tr>

  <?php endforeach; ?>
</table>

</body>
</html>