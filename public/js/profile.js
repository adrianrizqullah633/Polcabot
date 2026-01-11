/**
 * Profile Modal Functions
 */

function openProfile() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.add('active');
    }
}

function closeProfile() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const profileModal = document.getElementById('profileModal');
    
    if (profileModal) {
        profileModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeProfile();
            }
        });
    }
    
    // Handle profile form submission
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateProfile(this);
        });
    }
});

// Update profile via AJAX
function updateProfile(form) {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    fetch('/profile', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile berhasil diupdate!');
            closeProfile();
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate profile');
    });
}

// Logout function
function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}