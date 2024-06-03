<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title> 
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        Pilih file: <input type="file" name="berkas" />
        <input type="submit" name="upload" value="upload" />
    </form> 
</body> 
</html>

<?php 

set_time_limit(300);

function panggil_model(){
    $perintah = "python C:\Dasildat-Tes\heart_failure.py";
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
        $hasil = panggil_model();
        echo 'Hasil: ' . nl2br($hasil);
               
	    echo "Link hasil: <a href=hasil_heart.csv>hasil_heart.csv</a><br/>";
    } else {
        echo 'Upload Gagal';
    }
}
?>

