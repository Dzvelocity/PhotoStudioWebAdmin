<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
        }
        .description {
            color: #666;
            max-width: 600px;
            margin-bottom: 30px;
            line-height: 1.6;
            padding: 0 20px;
        }
        .get-started-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .get-started-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>D'Photo Studio Admin</h1>
    <p class="description">
    This platform allows administrators to manage customer data, photo sessions,
    and additional services of D'Photo Studio.
    </p>
    <a href="index.php?page=user&action=login" class="get-started-btn">
        Mulai
    </a>
</body>
</html>