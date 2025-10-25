# 📧 Temporary Mail Integration

Aplikasi web sederhana untuk menghasilkan dan mengelola email sementara menggunakan **Guerrillamail** dan **Maildrop** API. Sempurna untuk testing, verifikasi akun, atau situasi yang memerlukan email disposable.

🔗 **Live Demo**: [https://mail.vbi1.my.id/](https://mail.vbi1.my.id/)

## ✨ Fitur

- 🎯 **Generate Email Instan** - Buat email sementara dalam hitungan detik
- 📬 **Receive Messages** - Terima email secara real-time
- 🔄 **Auto Refresh** - Pesan diperbarui otomatis setiap 3 detik
- 📖 **Read Messages** - Baca isi pesan lengkap dengan modal viewer
- 🔐 **Dua Provider** - Support Guerrillamail & Maildrop
- 📱 **Responsive Design** - Tampilan modern dan mobile-friendly
- 📋 **Copy to Clipboard** - Copy email dengan satu klik
- ⏱️ **60 Menit Validity** - Email berlaku selama 60 menit

## 🚀 Teknologi

- **Backend**: PHP 7.4+ dengan cURL
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **API Integration**: 
  - Guerrillamail API
  - Maildrop GraphQL API

## 📦 Instalasi

### Prerequisites

- PHP 7.4 atau lebih tinggi
- cURL extension enabled
- Web server (Apache/Nginx)

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/temp-mail-integration.git
   cd temp-mail-integration
   ```

2. **Upload ke server**
   ```bash
   # Upload file ke web server Anda
   - mail-api.php
   - index.html
   ```

3. **Konfigurasi (opsional)**
   
   Edit `index.html` jika perlu mengubah API URL:
   ```javascript
   const API_URL = '/mail-api.php'; // Sesuaikan dengan path Anda
   ```

4. **Akses aplikasi**
   ```
   http://yourdomain.com/
   ```

## 📖 Cara Penggunaan

### Melalui Web Interface

1. Buka aplikasi di browser
2. Email akan otomatis di-generate saat page load
3. Copy email dan gunakan untuk registrasi/verifikasi
4. Tunggu pesan masuk (auto-refresh setiap 3 detik)
5. Klik pesan untuk membaca isi lengkapnya

### API Endpoints

#### Guerrillamail

**Generate Email**
```bash
GET /mail-api.php?action=guerrillamail_generate
```

Response:
```json
{
  "provider": "Guerrillamail",
  "email": "example@sharklasers.com",
  "sid": "abc123xyz",
  "success": true
}
```

**Check Messages**
```bash
GET /mail-api.php?action=guerrillamail_messages&email=EMAIL&sid=SID
```

Response:
```json
{
  "provider": "Guerrillamail",
  "email": "example@sharklasers.com",
  "count": 2,
  "messages": [
    {
      "mail_id": "123",
      "mail_from": "sender@example.com",
      "mail_subject": "Welcome",
      "mail_excerpt": "Thank you for signing up...",
      "mail_date": "2025-10-25 10:30:00"
    }
  ],
  "success": true
}
```

**Read Message**
```bash
GET /mail-api.php?action=guerrillamail_read&sid=SID&id=MESSAGE_ID
```

Response:
```json
{
  "provider": "Guerrillamail",
  "mail_from": "sender@example.com",
  "mail_subject": "Welcome",
  "mail_body": "<html>...</html>",
  "mail_timestamp": 1729850400,
  "success": true
}
```

#### Maildrop

**Generate Email**
```bash
GET /mail-api.php?action=maildrop_generate
```

**Check Messages**
```bash
GET /mail-api.php?action=maildrop_messages&mailbox=MAILBOX
```

**Read Message**
```bash
GET /mail-api.php?action=maildrop_read&mailbox=MAILBOX&id=MESSAGE_ID
```

## 🎨 Customization

### Mengubah Tema Warna

Edit CSS di `index.html`:

```css
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn {
    background: #667eea; /* Warna tombol */
}
```

### Mengubah Auto-Refresh Interval

Edit JavaScript di `index.html`:

```javascript
// Default: 3000ms (3 detik)
autoRefreshInterval = setInterval(() => {
    if (currentEmail && currentSid) {
        refreshMessages();
    }
}, 3000); // Ubah nilai ini
```

## 🔒 Keamanan

- ⚠️ **Jangan gunakan untuk data sensitif** - Email bersifat publik dan sementara
- 🔐 Tidak ada penyimpanan password atau data pribadi
- 🚫 Email otomatis terhapus setelah masa berlaku habis
- ✅ Hanya untuk testing dan verifikasi non-kritis

## 🐛 Troubleshooting

### Email tidak ter-generate

- Pastikan cURL extension PHP aktif
- Cek koneksi internet server
- Verifikasi API Guerrillamail/Maildrop tidak down

### Pesan tidak muncul

- Tunggu beberapa saat (email delivery bisa delay)
- Cek manual di https://www.guerrillamail.com/
- Pastikan auto-refresh berjalan (lihat console)

### Error CORS

- Pastikan `mail-api.php` dan `index.html` di domain yang sama
- Atau tambahkan CORS headers di PHP:
  ```php
  header('Access-Control-Allow-Origin: *');
  ```

## 📝 To-Do

- [ ] Support multiple email providers
- [ ] Email forwarding feature
- [ ] Custom email prefix
- [ ] Message search & filter
- [ ] Export messages
- [ ] Dark mode theme
- [ ] PWA support

## 🤝 Contributing

Kontribusi sangat diterima! Silakan:

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 👨‍💻 Author

**Your Name**
- Website: [https://vbi1.my.id](https://vbi1.my.id)
- GitHub: [@yourusername](https://github.com/yourusername)

## 🙏 Credits

- [Guerrillamail](https://www.guerrillamail.com/) - Temporary email service
- [Maildrop](https://maildrop.cc/) - Disposable email service

## ⚖️ Disclaimer

Aplikasi ini dibuat untuk tujuan edukatif dan testing. Penggunaan untuk spam, penipuan, atau aktivitas ilegal lainnya sangat tidak dianjurkan dan menjadi tanggung jawab pengguna sepenuhnya.

---

⭐ Jika project ini membantu, berikan star ya! ⭐
