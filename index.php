<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Mail</title>
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
        }
        
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .tab-btn {
            padding: 12px 20px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            color: #999;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
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
            white-space: nowrap;
            transition: background 0.3s;
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
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
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
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 20px;
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
        }
        
        .modal.show {
            display: block;
        }
        
        .modal-content {
            background-color: white;
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
        
        .modal-field {
            margin-bottom: 15px;
        }
        
        .modal-field label {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 5px;
            display: block;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Temporary Mail</h1>
            <p>Email sementara gratis</p>
        </div>
        
        <div class="main-card">
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('guerrillamail', event)">🐻 Guerrillamail</button>
                <button class="tab-btn" onclick="switchTab('maildrop', event)">📮 Maildrop</button>
            </div>
            
            <!-- GUERRILLAMAIL -->
            <div id="guerrillamail" class="tab-content active">
                <div class="info-box">ℹ️ Email sementara, berlaku 60 menit, support receive & forward</div>
                <div class="alert" id="alert-gm"></div>
                
                <div class="form-group">
                    <label>📧 Email:</label>
                    <div class="email-display">
                        <span id="gm-email">-</span>
                        <button class="copy-btn" onclick="copyGM()">📋 Copy</button>
                    </div>
                </div>
                
                <div class="btn-group">
                    <button class="btn" onclick="generateGM()">🔄 Generate Baru</button>
                    <button class="btn btn-secondary" onclick="refreshGM()">🔍 Refresh</button>
                </div>
                
                <div>
                    <label style="margin-top: 20px;">📬 Pesan:</label>
                    <div class="message-list" id="gm-messages">
                        <div class="empty-state"><p>Belum ada pesan</p></div>
                    </div>
                </div>
            </div>
            
            <!-- MAILDROP -->
            <div id="maildrop" class="tab-content">
                <div class="info-box">ℹ️ Email custom instant, support custom nama</div>
                <div class="alert" id="alert-md"></div>
                
                <div class="form-group">
                    <label>✏️ Custom Email:</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="md-input" placeholder="nama@maildrop.cc" 
                               style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <button class="btn" onclick="createMD()">✓ Buat</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>📧 Email:</label>
                    <div class="email-display">
                        <span id="md-email">-</span>
                        <button class="copy-btn" onclick="copyMD()">📋 Copy</button>
                    </div>
                </div>
                
                <div class="btn-group">
                    <button class="btn" onclick="generateMD()">🎲 Random</button>
                    <button class="btn btn-secondary" onclick="refreshMD()">🔍 Refresh</button>
                </div>
                
                <div>
                    <label style="margin-top: 20px;">📬 Pesan:</label>
                    <div class="message-list" id="md-messages">
                        <div class="empty-state"><p>Belum ada pesan</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📖 Baca Pesan</h2>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            <div class="modal-field">
                <label>Dari:</label>
                <p id="modal-from">-</p>
            </div>
            <div class="modal-field">
                <label>Subjek:</label>
                <p id="modal-subject">-</p>
            </div>
            <div class="modal-field">
                <label>Waktu:</label>
                <p id="modal-time">-</p>
            </div>
            <div class="modal-field">
                <label>Isi:</label>
                <p id="modal-body">-</p>
            </div>
        </div>
    </div>
    
    <script>
        const API = '/mail-api.php';
        let gmData = { email: null, sid: null, messages: [] };
        let mdData = { email: null, messages: [] };
        let gmInterval, mdInterval;
        
        async function fetch_(url) {
            const res = await fetch(url);
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON Parse Error:', text.substring(0, 200));
                throw new Error('Invalid response from server');
            }
        }
        
        function switchTab(tab, e) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById(tab).classList.add('active');
            e.target.classList.add('active');
        }
        
        function alert_(type, msg) {
            const el = type === 'gm' ? document.getElementById('alert-gm') : document.getElementById('alert-md');
            el.textContent = msg;
            el.className = `alert show alert-${msg.includes('❌') ? 'error' : msg.includes('✓') ? 'success' : 'info'}`;
            setTimeout(() => el.classList.remove('show'), 4000);
        }
        
        // GUERRILLAMAIL
        async function generateGM() {
            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span>...';
            try {
                const data = await fetch_(`${API}?action=guerrillamail_generate`);
                if (data.success) {
                    gmData = { email: data.email, sid: data.sid, messages: [] };
                    document.getElementById('gm-email').textContent = data.email;
                    alert_('gm', `✓ ${data.email}`);
                    if (gmInterval) clearInterval(gmInterval);
                    gmInterval = setInterval(refreshGM, 3000);
                    setTimeout(refreshGM, 500);
                }
            } catch (e) {
                alert_('gm', '❌ Error: ' + e.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = '🔄 Generate Baru';
            }
        }
        
        async function refreshGM() {
            if (!gmData.email || !gmData.sid) return;
            try {
                const data = await fetch_(`${API}?action=guerrillamail_messages&email=${gmData.email}&sid=${gmData.sid}`);
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        if (!gmData.messages.find(m => m.mail_id === msg.mail_id)) {
                            gmData.messages.unshift(msg);
                        }
                    });
                }
                renderGM();
            } catch (e) {}
        }
        
        function renderGM() {
            const list = document.getElementById('gm-messages');
            if (gmData.messages.length === 0) {
                list.innerHTML = '<div class="empty-state"><p>Belum ada pesan</p></div>';
            } else {
                list.innerHTML = gmData.messages.map(m => `
                    <div class="message-item" onclick="viewGM('${m.mail_id}')">
                        <div class="message-from">📧 ${m.mail_from}</div>
                        <div class="message-subject">${m.mail_subject}</div>
                        <div class="message-time">${m.mail_date}</div>
                    </div>
                `).join('');
            }
        }
        
        async function viewGM(id) {
            try {
                const data = await fetch_(`${API}?action=guerrillamail_read&sid=${gmData.sid}&id=${id}`);
                if (data.success) {
                    const body = data.mail_body ? data.mail_body.replace(/<[^>]*>/g, '') : '-';
                    document.getElementById('modal-from').textContent = data.mail_from || '-';
                    document.getElementById('modal-subject').textContent = data.mail_subject || '-';
                    document.getElementById('modal-time').textContent = new Date(data.mail_timestamp * 1000).toLocaleString('id-ID');
                    document.getElementById('modal-body').textContent = body;
                    document.getElementById('modal').classList.add('show');
                }
            } catch (e) {
                alert_('gm', '❌ Error: ' + e.message);
            }
        }
        
        function copyGM() {
            if (gmData.email) navigator.clipboard.writeText(gmData.email);
        }
        
        // MAILDROP
        async function generateMD() {
            try {
                const data = await fetch_(`${API}?action=maildrop_generate`);
                if (data.success) {
                    mdData = { email: data.email, messages: [] };
                    document.getElementById('md-email').textContent = data.email;
                    alert_('md', `✓ ${data.email}`);
                    if (mdInterval) clearInterval(mdInterval);
                    mdInterval = setInterval(refreshMD, 3000);
                    setTimeout(refreshMD, 500);
                }
            } catch (e) {
                alert_('md', '❌ Error: ' + e.message);
            }
        }
        
        function createMD() {
            const input = document.getElementById('md-input').value.trim();
            if (!input) { alert_('md', '❌ Masukkan email'); return; }
            const email = input.includes('@') ? input : input + '@maildrop.cc';
            mdData = { email, messages: [] };
            document.getElementById('md-email').textContent = email;
            document.getElementById('md-input').value = '';
            alert_('md', `✓ ${email}`);
            if (mdInterval) clearInterval(mdInterval);
            mdInterval = setInterval(refreshMD, 3000);
            setTimeout(refreshMD, 500);
        }
        
        async function refreshMD() {
            if (!mdData.email) return;
            try {
                const mailbox = mdData.email.split('@')[0];
                const data = await fetch_(`${API}?action=maildrop_messages&mailbox=${mailbox}`);
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        if (!mdData.messages.find(m => m.id === msg.id)) {
                            mdData.messages.unshift(msg);
                        }
                    });
                }
                renderMD();
            } catch (e) {}
        }
        
        function renderMD() {
            const list = document.getElementById('md-messages');
            if (mdData.messages.length === 0) {
                list.innerHTML = '<div class="empty-state"><p>Belum ada pesan</p></div>';
            } else {
                list.innerHTML = mdData.messages.map(m => `
                    <div class="message-item" onclick="viewMD('${m.id}')">
                        <div class="message-from">📧 ${m.headerfrom || 'Unknown'}</div>
                        <div class="message-subject">${m.subject || '(no subject)'}</div>
                        <div class="message-time">${new Date(m.date).toLocaleString('id-ID')}</div>
                    </div>
                `).join('');
            }
        }
        
        async function viewMD(id) {
            try {
                const mailbox = mdData.email.split('@')[0];
                const data = await fetch_(`${API}?action=maildrop_read&mailbox=${mailbox}&id=${id}`);
                if (data.success && data.message) {
                    const body = data.message.data || data.message.html || '';
                    document.getElementById('modal-from').textContent = data.message.headerfrom || '-';
                    document.getElementById('modal-subject').textContent = data.message.subject || '-';
                    document.getElementById('modal-time').textContent = new Date(data.message.date).toLocaleString('id-ID') || '-';
                    document.getElementById('modal-body').textContent = body.replace(/<[^>]*>/g, '');
                    document.getElementById('modal').classList.add('show');
                }
            } catch (e) {
                alert_('md', '❌ Error: ' + e.message);
            }
        }
        
        function copyMD() {
            if (mdData.email) navigator.clipboard.writeText(mdData.email);
        }
        
        function closeModal() {
            document.getElementById('modal').classList.remove('show');
        }
        
        window.onclick = (e) => {
            const modal = document.getElementById('modal');
            if (e.target === modal) modal.classList.remove('show');
        };
        
        window.addEventListener('load', generateGM);
    </script>
</body>
</html>
