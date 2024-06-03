<?php 
 // Menjalankan perintah dir
$hasil = shell_exec('dir');
echo $hasil;
?> 

<?php
$perintah = "python C:\\Dasildat Tes\\script PHP\\heart_failure.py";
$output = shell_exec($perintah); 
echo "hasil: <pre>$output</pre>"; 
?>