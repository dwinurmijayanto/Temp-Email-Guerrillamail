<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Mail - Guerrillamail</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .main-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .email-display {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            color: #333;
            word-break: break-all;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }
        
        .copy-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.3s;
            white-space: nowrap;
        }
        
        .copy-btn:hover {
            background: #5568d3;
        }
        
        .btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .message-list {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .message-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .message-item:hover {
            background: #f8f9fa;
        }
        
        .message-item:last-child {
            border-bottom: none;
        }
        
        .message-from {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .message-subject {
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .message-excerpt {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .message-time {
            font-size: 0.85em;
            color: #999;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert.show {
            display: block;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal.show {
            display: block;
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        
        .modal-header h2 {
            margin: 0;
            color: #333;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }
        
        .close-btn:hover {
            color: #333;
        }
        
        .modal-body {
            margin-bottom: 15px;
        }
        
        .modal-field {
            margin-bottom: 15px;
        }
        
        .modal-field label {
            display: block;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .modal-field p {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            word-break: break-word;
            white-space: pre-wrap;
            color: #333;
        }
        
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #999;
        }
        
        .empty-state p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Temporary Mail</h1>
            <p>Email sementara gratis dengan Guerrillamail</p>
        </div>
        
        <div class="main-card">
            <div class="info-box">
                ℹ️ Guerrillamail - Email sementara yang reliable, berlaku 60 menit, support receive & forward
            </div>
            
            <div class="alert" id="alert"></div>
            
            <div class="form-group">
                <label>📧 Email Anda:</label>
                <div class="email-display">
                    <span id="email-display">-</span>
                    <button class="copy-btn" onclick="copyToClipboard()">📋 Copy</button>
                </div>
            </div>
            
            <div class="btn-group">
                <button class="btn" id="generateBtn" onclick="generateEmail()">🔄 Generate Email Baru</button>
                <button class="btn btn-secondary" id="refreshBtn" onclick="refreshMessages()">🔍 Refresh Pesan</button>
            </div>
            
            <div style="margin-top: 30px;">
                <label style="margin-bottom: 15px; display: block;">📬 Pesan Masuk:</label>
                <div class="message-list" id="messageList">
                    <div class="empty-state">
                        <p>Belum ada pesan</p>
                        <small>Generate email dulu, lalu tunggu pesan masuk</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal untuk baca pesan -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📖 Baca Pesan</h2>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="modal-field">
                    <label>Dari:</label>
                    <p id="modalFrom">-</p>
                </div>
                <div class="modal-field">
                    <label>Subjek:</label>
                    <p id="modalSubject">-</p>
                </div>
                <div class="modal-field">
                    <label>Waktu:</label>
                    <p id="modalTime">-</p>
                </div>
                <div class="modal-field">
                    <label>Isi Pesan:</label>
                    <p id="modalBody">-</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const API_URL = '/mail-api.php';
        let currentEmail = null;
        let currentSid = null;
        let autoRefreshInterval = null;
        let allMessages = []; // Simpan semua pesan yang pernah diambil
        
        async function fetchAPI(url) {
            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                });
                const text = await response.text();
                return JSON.parse(text);
            } catch (error) {
                throw error;
            }
        }
        
        function showAlert(message, type = 'info') {
            const alertEl = document.getElementById('alert');
            alertEl.textContent = message;
            alertEl.className = `alert show alert-${type}`;
            setTimeout(() => alertEl.classList.remove('show'), 5000);
        }
        
        function copyToClipboard() {
            if (!currentEmail) return;
            navigator.clipboard.writeText(currentEmail).then(() => {
                showAlert('✓ Email tersalin ke clipboard!', 'success');
            });
        }
        
        async function generateEmail() {
            const btn = document.getElementById('generateBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span>Generating...';
            
            try {
                const data = await fetchAPI(`${API_URL}?action=guerrillamail_generate`);
                
                if (data.success) {
                    currentEmail = data.email;
                    currentSid = data.sid;
                    allMessages = []; // Reset pesan saat generate baru
                    document.getElementById('email-display').textContent = data.email;
                    showAlert(`✓ Email berhasil dibuat: ${data.email}`, 'success');
                    
                    // Clear messages
                    document.getElementById('messageList').innerHTML = `
                        <div class="empty-state">
                            <p>Sedang menunggu pesan...</p>
                        </div>
                    `;
                    
                    // Auto refresh setiap 3 detik
                    if (autoRefreshInterval) clearInterval(autoRefreshInterval);
                    autoRefreshInterval = setInterval(() => {
                        if (currentEmail && currentSid) {
                            refreshMessages();
                        }
                    }, 3000);
                    
                    // Refresh pertama setelah 1 detik
                    setTimeout(() => refreshMessages(), 1000);
                } else {
                    showAlert('❌ Gagal membuat email', 'error');
                }
            } catch (error) {
                showAlert('❌ Error: ' + error.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '🔄 Generate Email Baru';
            }
        }
        
        async function refreshMessages() {
            if (!currentEmail || !currentSid) {
                showAlert('⚠️ Generate email dulu', 'info');
                return;
            }
            
            try {
                const data = await fetchAPI(`${API_URL}?action=guerrillamail_messages&email=${currentEmail}&sid=${currentSid}`);
                
                const messageList = document.getElementById('messageList');
                
                if (data.messages && data.messages.length > 0) {
                    // Merge dengan pesan lama, hindari duplikat
                    data.messages.forEach(newMsg => {
                        if (!allMessages.find(msg => msg.mail_id === newMsg.mail_id)) {
                            allMessages.unshift(newMsg); // unshift untuk tambah di awal array
                        }
                    });
                }
                
                if (allMessages.length === 0) {
                    messageList.innerHTML = `
                        <div class="empty-state">
                            <p>Belum ada pesan</p>
                            <small>Tunggu pesan masuk atau cek di https://www.guerrillamail.com/</small>
                        </div>
                    `;
                } else {
                    messageList.innerHTML = allMessages.map(msg => `
                        <div class="message-item" onclick="readMessage('${msg.mail_id}')">
                            <div class="message-from">📧 ${msg.mail_from || 'Unknown'}</div>
                            <div class="message-subject">${msg.mail_subject || '(no subject)'}</div>
                            <div class="message-excerpt">${msg.mail_excerpt || ''}</div>
                            <div class="message-time">${msg.mail_date || ''}</div>
                        </div>
                    `).join('');
                }
            } catch (error) {
                showAlert('❌ Error: ' + error.message, 'error');
            }
        }
        
        async function readMessage(messageId) {
            try {
                const data = await fetchAPI(`${API_URL}?action=guerrillamail_read&sid=${currentSid}&id=${messageId}`);
                
                if (data.success) {
                    // Hapus tag HTML dengan regex
                    const cleanBody = data.mail_body ? data.mail_body.replace(/<[^>]*>/g, '') : '-';
                    
                    document.getElementById('modalFrom').textContent = data.mail_from || '-';
                    document.getElementById('modalSubject').textContent = data.mail_subject || '-';
                    document.getElementById('modalTime').textContent = new Date(data.mail_timestamp * 1000).toLocaleString('id-ID') || '-';
                    document.getElementById('modalBody').textContent = cleanBody;
                    
                    document.getElementById('messageModal').classList.add('show');
                }
            } catch (error) {
                showAlert('❌ Error: ' + error.message, 'error');
            }
        }
        
        function closeModal() {
            document.getElementById('messageModal').classList.remove('show');
        }
        
        // Tutup modal saat klik di luar
        window.onclick = function(event) {
            const modal = document.getElementById('messageModal');
            if (event.target == modal) {
                modal.classList.remove('show');
            }
        }
        
        // Generate email saat page load
        window.addEventListener('load', () => {
            generateEmail();
        });
    </script>
</body>
</html>
