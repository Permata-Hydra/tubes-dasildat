
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Prediksi Dataset</title>
        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .btn-group-custom {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }
    
            .btn-group-custom .btn {
                margin: 0 10px;
                font-size: 1.5rem;
                padding: 15px 30px;
                background-color: #6c757d;
                /* Warna abu-abu */
                border: none;
            }
    
            .btn-group-custom .btn:hover {
                background-color: #5a6268;
                /* Warna abu-abu lebih gelap saat di-hover */
            }
        </style>
    </head>
    
    <body>
        <div class="container mt-5">
            <div class="text-center">
                <h2>APLIKASI MACHINE LEARNING</h2>
                <p>Pilih Model</p>
            </div>
            <div class="btn-group-custom">
                <form action="panggil_svm.php" method="GET">
                    <button type="submit" class="btn btn-secondary">SVM</button>
                </form>
                <form action="panggil_randomforest.php" method="GET">
                    <button type="submit" class="btn btn-secondary">RandomForest</button>
                </form>
                <form action="panggil_knn.php" method="GET">
                    <button type="submit" class="btn btn-secondary">K-NN</button>
                </form>
            </div>
        </div>
    
        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    
    </html>