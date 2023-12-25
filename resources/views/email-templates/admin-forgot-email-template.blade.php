<p> Dear {{ $admin->name }}</p>
<p>
    Kami menerima permintaan untuk mereset kata sandi akun larave.com yang terkait dengan {{ $admin->email }}
    Anda dapat mengatur ulang kata sandi Anda dengan mengklik button di bawah ini:
    <br>
    <a href="{{ $actionLink }}" target="_blank" style="color: #fff;border-color:#22bc66;border-style:solid;
    border-width:5px 10px;background-color:#1a422b;display:inline-block;text-decoration:none;border-radius:3px;
    box-shadow:0 2px 3px rgba(0,0,0,0.16);-webkit-text-size-adjust:none;box-sizing:border-box;"
    >Reset Password</a>
    <br>
    <b>NB:</b> Tautan ini akan berlaku dalam waktu 15 menit
    <br>
    jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini
</p>