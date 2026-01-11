<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PolCaBot Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #e5e5e5;
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background-color: #0099ff;
            padding-top: 60px;
            color: white;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #007acc;
        }

        /* Top navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #0099ff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 10;
        }

        .navbar .logo {
            display: flex;
            align-items: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .navbar .logo img {
            width: 28px;
            margin-right: 8px;
        }

        .navbar input[type="text"] {
            padding: 6px 10px;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        .navbar .profile {
            display: flex;
            align-items: center;
            color: white;
        }

        .navbar .profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-left: 10px;
            background: linear-gradient(45deg, #5f2eea, #4bc0c8);
            padding: 4px;
        }

        /* Main content */
        .main-content {
            flex: 1;
            margin-top: 60px;
            margin-left: 200px;
            padding: 20px;
            background-color: white;
            border-top-left-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712104.png" alt="Bot">
            PolCaBot
        </div>

        <input type="text" placeholder="cari disini..">

        <div class="profile">
            Hi, Admin!
            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712104.png" alt="Admin">
        </div>
    </div>

    <div class="sidebar">
        <a href="#">☰ Dashboard</a>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>