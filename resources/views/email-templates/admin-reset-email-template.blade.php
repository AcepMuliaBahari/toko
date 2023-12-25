<p>Dear {{ $admin->name }}</p>
<br>
<p>
    Kata sandi Anda pada sistem Laravecom berhasil diubah.
    Ini kredensial login baru Anda:
<br>
<b>Login ID: </b>{{ $admin->username }} or {{ $admin->email }}
<br>
<b>Password </b>{{ $new_password }}
</p>
<br>
---------------------------------------------
Harap jaga kerahasiaan kredensial Anda. Nama pengguna dan kata sandi Anda adalah kredensial Anda sendiri dan Anda harus melakukannya
jangan pernah membaginya dengan orang lain.
<p>
    Laravecom tidak bertanggung jawab atas penyalahgunaan nama pengguna atau kata sandi Anda.
</p>
<br>
<p>
    Email ini secara otomatis dikirim oleh sistem Laravecom. Jangan membalasnya.
</p>