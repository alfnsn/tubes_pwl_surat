<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .unauthorized-container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .unauthorized-container h1 {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .unauthorized-container p {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .unauthorized-container a,
        .unauthorized-container button {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .unauthorized-container a:hover,
        .unauthorized-container button:hover {
            background-color: #0056b3;
        }

        .unauthorized-container button {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="unauthorized-container">
        <h1>403 - Unauthorized Access</h1>
        <p>Maaf, Anda tidak mempunyai akses untuk membuka halaman ini.</p>
        <button onclick="history.back()">Kembali ke Halaman Sebelumnya</button>
    </div>
</body>

</html>
