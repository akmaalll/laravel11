<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .error-icon {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        h1 {
            color: #dc3545;
            margin-bottom: 10px;
        }

        p {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-icon">🚫</div>
        <h1>Unauthorized Access</h1>
        <p>Maaf, Anda tidak memiliki akses ke halaman ini.</p>
        <p>Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.</p>

        <div style="margin-top: 30px;">
            <a href="{{ route('admin') }}" class="btn">Dashboard</a>
            <a href="{{ route('logout') }}" class="btn btn-secondary">Logout</a>
        </div>
    </div>
</body>

</html>
