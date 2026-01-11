<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | PolCaBot</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- ✅ TAMBAHKAN TAILWIND CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f3f6fa;
        }

        /* === NAVBAR === */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 65px;
            background: linear-gradient(90deg, #007bff, #00aaff);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* --- Kiri: Logo & Hamburger --- */
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand img {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            object-fit: cover;
        }

        /* Hamburger Menu Button - In Navbar */
        .hamburger {
            display: none;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .hamburger:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .hamburger:active {
            transform: scale(0.95);
        }

        .hamburger-inner {
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: center;
            justify-content: center;
        }

        .hamburger span {
            width: 22px;
            height: 2.5px;
            background-color: white;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* --- Tengah: Search bar --- */
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
        }

        .navbar-center input {
            width: 380px;
            max-width: 400px;
            padding: 9px 15px;
            border-radius: 10px;
            border: none;
            outline: none;
            box-shadow: 0 0 6px rgba(0,0,0,0.15);
        }

        /* --- Kanan: Profil Admin --- */
        .navbar-right {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            margin-right: 20px;
        }

        .navbar-right span {
            font-weight: 500;
        }

        .navbar-right img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            object-fit: cover;
        }

        /* === DROPDOWN PROFILE === */
        .dropdown {
            position: absolute;
            top: 58px;
            right: 0;
            background: white;
            color: #333;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: none;
            flex-direction: column;
            min-width: 180px;
            overflow: hidden;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-5px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .dropdown a {
            padding: 12px 16px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: background 0.2s;
        }

        .dropdown a:hover {
            background-color: #f4f4f4;
        }

        /* === SIDEBAR === */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            height: 100vh;
            background: linear-gradient(180deg, #007bff, #0099ff);
            display: flex;
            flex-direction: column;
            padding-top: 80px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            z-index: 999;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 13px 22px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            gap: 10px;
            transition: background 0.3s, padding-left 0.2s;
        }

        .sidebar a:hover {
            background-color: rgba(0,0,0,0.15);
            padding-left: 26px;
        }

        .sidebar a.active {
            background-color: #005fcc;
        }

        /* === MAIN CONTENT === */
        .content {
            margin-left: 230px;
            padding: 90px 35px 30px 35px;
            width: calc(100% - 230px);
            overflow-y: auto;
            min-height: 100vh;
        }

        /* === OVERLAY === */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            /* Show hamburger button in navbar */
            .hamburger {
                display: flex;
            }

            /* Adjust navbar left */
            .navbar-left {
                gap: 10px;
            }

            /* Keep brand visible on mobile */
            .brand {
                font-size: 18px;
            }

            .brand img {
                width: 36px;
                height: 36px;
            }

            /* Hide search bar on mobile */
            .navbar-center {
                display: none;
            }

            /* Adjust navbar right */
            .navbar-right {
                margin-right: 10px;
            }

            .navbar-right span {
                display: none;
            }

            .navbar-right img {
                width: 38px;
                height: 38px;
            }

            /* Sidebar mobile behavior */
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Full width content on mobile */
            .content {
                margin-left: 0;
                width: 100%;
                padding: 80px 20px 30px 20px;
            }

            /* Adjust navbar padding */
            .navbar {
                padding: 0 15px;
                height: 60px;
            }
        }

        @media (max-width: 480px) {
            .brand {
                font-size: 16px;
            }

            .brand img {
                width: 32px;
                height: 32px;
            }

            .navbar-right img {
                width: 36px;
                height: 36px;
            }

            .content {
                padding: 75px 15px 20px 15px;
            }

            .hamburger {
                width: 36px;
                height: 36px;
            }

            .hamburger span {
                width: 20px;
                height: 2px;
            }
        }
    </style>
</head>
<body>
    <!-- OVERLAY FOR MOBILE SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="navbar-left">
            <!-- Hamburger Menu Button (In Navbar) -->
            <div class="hamburger" id="hamburgerBtn">
                <div class="hamburger-inner">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="PolCaBot Logo">
                <span>PolCaBot</span>
            </div>
        </div>

        {{-- <div class="navbar-center">
            <input type="text" placeholder="Cari di sini...">
        </div> --}}

        <div class="navbar-right" id="profileMenu">
            <span>Hi, {{ Auth::user()->username }}</span>
            <img
                src="{{ Auth::user()->profile_photo
                    ? asset('storage/profile/' . Auth::user()->profile_photo)
                    : 'https://cdn-icons-png.flaticon.com/512/4712/4712107.png' }}"
                alt="Admin">

            <div class="dropdown" id="dropdownMenu">
                <a href="{{ route('admin.profile') }}">🧑‍💼 Ubah Profil</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
            </div>
        </div>
        
        <!-- Form Logout (Hidden) -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('admin.knowledge') }}" class="{{ request()->is('admin/knowledge*') || request()->is('admin/organisasi*') ? 'active' : '' }}">📚 Knowledge Base</a>
        <a href="{{ route('admin.training') }}" class="{{ request()->is('admin/training') ? 'active' : '' }}">🧠 Training AI</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">
        @yield('content')
    </div>

    <script>
        // Profile Dropdown
        const profileMenu = document.getElementById('profileMenu');
        const dropdown = document.getElementById('dropdownMenu');

        profileMenu.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!profileMenu.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Mobile Sidebar Toggle
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            hamburgerBtn.classList.toggle('active');
        }

        hamburgerBtn.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking a link on mobile
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>