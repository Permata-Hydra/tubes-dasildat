<!DOCTYPE html>
<html leng="en">
<head>
    <title>Prediksi Dataset</title>
</head>

<body>
    <h2>Model RandomForest</h2>
    <p>Model terbaik yang kami sarankan!</p>
    <form action="" method="POST" enctype="multipart/form-data">
        Pilih file: <input type="file" name="berkas" />
        <input type="submit" name="upload" value="upload" /><br><br>
    </form>
    
    <p>Ingin coba model lain?</p>
    <div style="display: flex; gap: 10px;">
        <form action="panggil_svm.php" method="GET">
            <button type="submit">SVM</button>
        </form>

        <form action="panggil_knn.php" method="GET">
            <button type="submit">k-NN</button>
        </form>
    </div>
</body> 
</html>

<?php 

set_time_limit(300);

function panggil_randomforest(){
    $perintah = "python C:\Dasildat-Tes\heart_failure_rf.py";
    $output = shell_exec($perintah); 
    return $output; 
}
?> 

<?php

if(isset($_POST["upload"])) {
    $namaFile = 'dataset.csv';
    $namaSementara = $_FILES['berkas']['tmp_name'];

    // tentukan lokasi file akan dipindahkan
    $dirUpload = "dataset/";

    // pindahkan file
    $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

    if ($terupload) {
        echo "Upload berhasil!<br/>";
        echo "Link dataset: <a href='".$dirUpload.$namaFile."'>".$namaFile."</a><br/>";

        # Cetak hasil prediksi
        $hasil = panggil_randomforest();
        echo 'Hasil: ' . nl2br($hasil);
               
	    echo "Link hasil: <a href=hasil_heart.csv>hasil_heart.csv</a><br/>";
    } else {
        echo 'Upload Gagal';
    }
}
?>

