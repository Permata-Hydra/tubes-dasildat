<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Dataset</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Model k-Nearest Neighbors</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="form-group">
                <label for="berkas">Pilih file:</label>
                <input type="file" name="berkas" class="form-control-file" id="berkas" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
        </form>

        <p class="text-center">Ingin coba model lain?</p>
        <div class="d-flex justify-content-center">
            <form action="panggil_svm.php" method="GET" class="mr-2">
                <button type="submit" class="btn btn-secondary">SVM</button>
            </form>
            <form action="panggil_randomforest.php" method="GET">
                <button type="submit" class="btn btn-secondary">RandomForest</button>
            </form>
        </div>

        <div class="mt-4">
            <?php
            if(isset($_POST["upload"])) {
                $namaFile = 'dataset.csv';
                $namaSementara = $_FILES['berkas']['tmp_name'];

                // tentukan lokasi file akan dipindahkan
                $dirUpload = "dataset/";

                // pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

                if ($terupload) {
                    echo "<div class='alert alert-success'>Upload berhasil!</div>";
                    echo "<p>Link dataset: <a href='".$dirUpload.$namaFile."'>".$namaFile."</a></p>";

                    // Cetak hasil prediksi
                    $hasil = panggil_knn();
                    echo "<p>Hasil: <pre>" . nl2br($hasil) . "</pre></p>";
                    
                    echo "<p>Link hasil: <a href='hasil_heart.csv'>hasil_heart.csv</a></p>";

                    $a = panggil_accuracy();
                    echo "<p>Grafik perbandingan nilai akurasi 3 model HPO: <a href='graph_accuracy.xlsx'>graph_accuracy.xlsx</a></p>";
                    
                    $b = panggil_precision();
                    echo "<p>Grafik perbandingan nilai presisi 3 model HPO: <a href='graph_precision.xlsx'>graph_precision.xlsx</a></p>";
                } else {
                    echo "<div class='alert alert-danger'>Upload Gagal</div>";
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
set_time_limit(300);

function panggil_knn() {
    $perintah = "python C:\\Dasildat-Tes\\heart_failure_knn.py";
    $output = shell_exec($perintah); 
    return $output; 
}

function panggil_accuracy() {
    $acc = "python C:\\Dasildat-Tes\\graph_accuracy.py";
    $output = shell_exec($acc);
    return $output;
}

function panggil_precision() {
    $pre = "python C:\\Dasildat-Tes\\graph_precision.py";
    $output = shell_exec($pre);
    return $output;
}
?>