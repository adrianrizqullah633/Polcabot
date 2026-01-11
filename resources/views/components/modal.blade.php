<div class="profile-modal" id="profileModal">
    <div class="profile-modal-content">
        <span class="close-btn" onclick="closeProfile()">×</span>
        <div class="profile-header">
            <img src="https://i.pravatar.cc/150?img=12" alt="Profile">
            <h2>Profile</h2>
        </div>
        <form class="profile-form" id="profileForm">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" value="{{ Auth::user()->nim ?? '' }}">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" required>
            </div>
            <div class="profile-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-logout" onclick="logout()">Log Out</button>
            </div>
        </form>
    </div>
</div>