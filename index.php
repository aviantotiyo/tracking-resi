<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Track Pengiriman</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h1 class="text-center">Track Pengiriman</h1>
        <form method="POST" action="">
          <div class="mb-3">
            <label for="awb" class="form-label">Nomor AWB:</label>
            <input type="text" class="form-control" id="awb" name="awb" required>
          </div>
          <div class="mb-3">
            <label for="courier" class="form-label">Pilih Kurir:</label>
            <select class="form-select" id="courier" name="courier" required>
              <option value="jne">JNE</option>
              <option value="pos">POS Indonesia</option>
              <option value="jnt">J&T Express</option>
              <option value="tiki">TIKI</option>
              <option value="anteraja">AnterAja</option>
              <option value="wahana">Wahana</option>
              <option value="ninja">Ninja Xpress</option>
              <option value="lion">Lion Parcel</option>
              <option value="pcp">PCP Express</option>
              <option value="jet">JET Express</option>
              <option value="rex">REX Express</option>
              <option value="first">First Logistics</option>
              <option value="ide">ID Express</option>
              <option value="spx">Shopee Express</option>
              <option value="jxe">JX Express</option>
              <option value="rpx">RPX</option>
              <option value="lex">Lazada Express</option>
              <option value="indah_cargo">Indah Cargo</option>
              <option value="dakota">Dakota Cargo</option>
              <option value="kurir_tokopedia">Kurir Rekomendasi</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Lacak Pengiriman</button>
        </form>
      </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $awb = $_POST['awb'];
      $courier = $_POST['courier'];

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.binderbyte.com/v1/track?api_key=2d7d1422cc1f8056377a0e825871892f4142b4bXXXXXXXXXXXX&courier=' . $courier . '&awb=' . $awb,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      // Mengecek jika response tidak kosong
      if (!empty($response)) {
        $responseData = json_decode($response, true);
        if (isset($responseData['data']) && !empty($responseData['data'])) {
          echo '<div class="row">';
          echo '<div class="col-md-6 offset-md-3">';
          echo '<div class="mt-3">';
          echo '<h2 class="text-center">Detail Pengiriman</h2>';
          echo '<table class="table">';
          echo '<thead><tr><th>Info</th><th>Detail</th></tr></thead>';
          echo '<tbody>';
          echo '<tr><td>Nomor AWB</td><td>' . $responseData['data']['summary']['awb'] . '</td></tr>';
          echo '<tr><td>Kurir</td><td>' . $responseData['data']['summary']['courier'] . '</td></tr>';
          echo '<tr><td>Layanan</td><td>' . $responseData['data']['summary']['service'] . '</td></tr>';
          echo '<tr><td>Status</td><td>' . $responseData['data']['summary']['status'] . '</td></tr>';
          echo '<tr><td>Tanggal</td><td>' . $responseData['data']['summary']['date'] . '</td></tr>';
          echo '<tr><td>Deskripsi</td><td>' . $responseData['data']['summary']['desc'] . '</td></tr>';
          echo '<tr><td>Berat</td><td>' . $responseData['data']['summary']['weight'] . '</td></tr>';
          echo '<tr><td>Asal</td><td>' . $responseData['data']['detail']['origin'] . '</td></tr>';
          echo '<tr><td>Tujuan</td><td>' . $responseData['data']['detail']['destination'] . '</td></tr>';
          echo '<tr><td>Pengirim</td><td>' . $responseData['data']['detail']['shipper'] . '</td></tr>';
          echo '<tr><td>Penerima</td><td>' . $responseData['data']['detail']['receiver'] . '</td></tr>';
          echo '</tbody></table>';

          echo '<h2 class="text-center">Riwayat Pengiriman</h2>';
          echo '<table class="table">';
          echo '<thead><tr><th>Tanggal</th><th>Deskripsi</th></tr></thead>';
          echo '<tbody>';
          foreach ($responseData['data']['history'] as $history) {
            echo '<tr><td>' . $history['date'] . '</td><td>' . $history['desc'] . '</td></tr>';
          }
          echo '</tbody></table>';
          echo '</div></div></div>';
        } else {
          echo '<div class="alert alert-warning" role="alert">Data pengiriman tidak ditemukan.</div>';
        }
      } else {
        echo '<div class="alert alert-danger" role="alert">Gagal melacak pengiriman. Silakan coba lagi.</div>';
      }
    }
    ?>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
