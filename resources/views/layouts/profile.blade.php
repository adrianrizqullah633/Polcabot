<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - PolCaBot</title>
    
    <!-- Tailwind CSS CDN (Ganti dengan Vite nanti) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 overflow-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 bg-gradient-to-b from-blue-900 to-blue-500 text-white flex flex-col p-5">
            <!-- Logo -->
            <div class="flex items-center gap-3 p-4 border-2 border-white rounded-lg mb-8">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-2xl">
                    🤖
                </div>
                <div class="text-xl font-semibold">PolCaBot</div>
            </div>

            <!-- History Section -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold mb-4">History</h3>
                <div class="space-y-3">
                    <div class="p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 cursor-pointer transition text-sm">
                        Ada Organisasi apa saja di Polibatam
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 cursor-pointer transition text-sm">
                        Ada jurusan apa saja di Polibatam
                    </div>
                    <div class="p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 cursor-pointer transition text-sm">
                        Jadwal Perkuliahan kelas pagi
                    </div>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <div class="flex items-center gap-4 p-4 hover:bg-white hover:bg-opacity-10 rounded-lg cursor-pointer transition mt-auto mb-4">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    🌙
                </div>
                <div class="text-sm">Dark Mode</div>
            </div>

            <!-- User Info -->
            <div class="flex items-center gap-4 p-4 bg-white bg-opacity-10 rounded-lg">
                <img id="sidebar-avatar" 
                     src="https://ui-avatars.com/api/?name=Alex+Marshall&background=3b82f6&color=fff&size=100" 
                     alt="User Avatar" 
                     class="w-12 h-12 rounded-full border-2 border-white object-cover">
                <div class="text-sm font-semibold" id="sidebar-name">Alex Marshall</div>
            </div>

            <!-- Logout Button -->
            <button onclick="handleLogout()" 
                    class="w-full mt-3 py-2.5 px-5 bg-white bg-opacity-10 border border-white rounded-lg text-sm hover:bg-opacity-20 transition">
                🚪 Log Out
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-cyan-400 text-white p-10">
                <h1 class="text-5xl font-bold mb-4">
                    Profile
                </h1>
            </div>

            <!-- Content Area -->
            <div class="p-10 bg-white flex-1">
                <!-- Success Alert (Hidden by default) -->
                <div id="success-alert" 
                     class="hidden mb-5 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg animate-slideDown">
                    ✅ Profile berhasil diperbarui!
                </div>

                <!-- Profile Form -->
                <form id="profile-form" onsubmit="handleSubmit(event)">
                    <div class="bg-white rounded-2xl p-8 shadow-lg mb-5">
                        <!-- Profile Photo Section -->
                        <div class="flex items-center gap-5 mb-8">
                            <div class="relative">
                                <img id="profile_preview"
                                     src="https://ui-avatars.com/api/?name=Alex+Marshall&background=3b82f6&color=fff&size=200" 
                                     alt="Profile Photo" 
                                     class="w-24 h-24 rounded-full border-4 border-blue-500 object-cover">
                                <div onclick="document.getElementById('profile_photo_input').click()"
                                     class="absolute bottom-0 right-0 w-8 h-8 bg-white border-2 border-blue-500 rounded-full flex items-center justify-center cursor-pointer hover:bg-gray-50">
                                    📷
                                </div>
                                <input type="file" 
                                       id="profile_photo_input" 
                                       accept="image/*"
                                       onchange="previewImage(event)"
                                       class="hidden">
                            </div>
                        </div>

                        <!-- Form Grid -->
                        <div class="grid grid-cols-2 gap-5">
                            <!-- Name -->
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-600 uppercase mb-1.5 font-medium">Name</label>
                                <input type="text" 
                                       id="name" 
                                       value="Alex Marshall"
                                       class="px-3 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                                       required>
                                <span class="text-red-500 text-xs mt-1" id="name-error"></span>
                            </div>

                            <!-- Username -->
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-600 uppercase mb-1.5 font-medium">Username</label>
                                <input type="text" 
                                       id="username" 
                                       value="alex_marshall"
                                       class="px-3 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                                       required>
                                <span class="text-red-500 text-xs mt-1" id="username-error"></span>
                            </div>

                            <!-- Phone -->
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-600 uppercase mb-1.5 font-medium">Phone Number</label>
                                <input type="text" 
                                       id="phone" 
                                       value="+1 815 555 9655"
                                       class="px-3 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                                <span class="text-red-500 text-xs mt-1" id="phone-error"></span>
                            </div>

                            <!-- Email -->
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-600 uppercase mb-1.5 font-medium">Email</label>
                                <input type="email" 
                                       id="email" 
                                       value="alexmarshall2022@gmail.com"
                                       class="px-3 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                                       required>
                                <span class="text-red-500 text-xs mt-1" id="email-error"></span>
                            </div>

                            <!-- Password -->
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-600 uppercase mb-1.5 font-medium">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" 
                                       id="password"
                                       class="px-3 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                                <span class="text-red-500 text-xs mt-1" id="password-error"></span>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-600 uppercase mb-1.5 font-medium">Konfirmasi Password</label>
                                <input type="password" 
                                       id="password_confirmation"
                                       class="px-3 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                                <span class="text-red-500 text-xs mt-1" id="password-confirmation-error"></span>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" 
                                class="w-full mt-5 py-3 bg-blue-900 text-white rounded-lg text-base font-semibold hover:bg-blue-800 hover:-translate-y-1 hover:shadow-lg transition duration-300">
                            Save
                        </button>
                    </div>
                </form>

    <script>
        // Simpan data profile di memori sementara
        let profileData = {
            name: 'Alex Marshall',
            username: 'alex_marshall',
            phone: '+1 815 555 9655',
            email: 'alexmarshall2022@gmail.com',
            photo: 'https://ui-avatars.com/api/?name=Alex+Marshall&background=3b82f6&color=fff&size=200'
        };

        // Preview gambar saat upload
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile_preview').src = e.target.result;
                    document.getElementById('sidebar-avatar').src = e.target.result;
                    profileData.photo = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Validasi form
        function validateForm() {
            let isValid = true;
            
            // Clear semua error messages
            document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validasi name
            if (name.trim().length < 3) {
                document.getElementById('name-error').textContent = 'Nama minimal 3 karakter';
                isValid = false;
            }

            // Validasi email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email-error').textContent = 'Email tidak valid';
                isValid = false;
            }

            // Validasi password jika diisi
            if (password) {
                if (password.length < 8) {
                    document.getElementById('password-error').textContent = 'Password minimal 8 karakter';
                    isValid = false;
                }
                if (password !== passwordConfirmation) {
                    document.getElementById('password-confirmation-error').textContent = 'Password tidak cocok';
                    isValid = false;
                }
            }

            return isValid;
        }

        // Handle submit form
        function handleSubmit(event) {
            event.preventDefault();
            
            if (!validateForm()) {
                return;
            }

            // Update data profile
            profileData.name = document.getElementById('name').value;
            profileData.username = document.getElementById('username').value;
            profileData.phone = document.getElementById('phone').value;
            profileData.email = document.getElementById('email').value;

            // Update tampilan
            document.getElementById('sidebar-name').textContent = profileData.name;
            document.getElementById('header-subtitle').textContent = 
                `Hai ${profileData.name}, PolCaBot siap membantu menjawab segala pertanyaan akademik dari kampus Polibatam`;

            // Tampilkan success alert
            const alert = document.getElementById('success-alert');
            alert.classList.remove('hidden');
            
            // Smooth scroll ke atas
            document.querySelector('.overflow-y-auto').scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            // Sembunyikan alert setelah 3 detik
            setTimeout(() => {
                alert.classList.add('hidden');
            }, 3000);

            console.log('Profile updated:', profileData);
        }

        // Handle Logout
        function handleLogout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                alert('Logout berhasil! Anda akan diarahkan ke halaman login.');
                window.location.href = "/"; // sementara redirect ke halaman utama
            }
        }

        // Log untuk debugging
        console.log('Profile page loaded successfully!');
    </script>
</body>
</html>