<section id="contact">
    <div class="contact-wrapper">
        <div class="contact-form">
            <h2>Contact Us</h2>
            <p class="subtext">Feel free to contact us at anytime. We will get back as soon as possible.</p>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
                @error('name')<span class="error">{{ $message }}</span>@enderror
                
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')<span class="error">{{ $message }}</span>@enderror
                
                <textarea name="message" placeholder="Message" required>{{ old('message') }}</textarea>
                @error('message')<span class="error">{{ $message }}</span>@enderror
                
                <button type="submit">Send</button>
            </form>
        </div>
        
        <div class="contact-info">
            <h3>Info</h3>
            <p>📧 info@polibatam.ac.id</p>
            <p>📞 +0858-0537-0324</p>
            <p>👤 Polibatam</p>
            <p>🕒 07:00 - 15:00</p>
            <div class="social-icons">
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" alt="Google"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp"></a>
            </div>
        </div>
    </div>
</section>
