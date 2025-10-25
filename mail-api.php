<?php
// Integration dengan Temporary Mail Services - Guerrillamail & Maildrop

class TempMailIntegration {
    
    // ===== GUERRILLAMAIL =====
    
    public static function guerrillamail_generate() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.guerrillamail.com/ajax.php?f=get_email_address&agent=Mozilla");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        return [
            "provider" => "Guerrillamail",
            "email" => $data['email_addr'] ?? null,
            "sid" => $data['sid_token'] ?? null,
            "success" => !empty($data['email_addr'])
        ];
    }
    
    public static function guerrillamail_messages($email, $sid) {
        $ch = curl_init();
        // Gunakan check_email dengan seq=0 untuk cek email baru
        curl_setopt($ch, CURLOPT_URL, "https://api.guerrillamail.com/ajax.php?f=check_email&sid_token=" . urlencode($sid) . "&seq=0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $data = json_decode($response, true);
        return [
            "provider" => "Guerrillamail",
            "email" => $email,
            "count" => $data['count'] ?? 0,
            "messages" => $data['list'] ?? [],
            "success" => true
        ];
    }
    
    public static function guerrillamail_read($sid, $messageId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.guerrillamail.com/ajax.php?f=fetch_email&sid_token=" . urlencode($sid) . "&email_id=" . urlencode($messageId));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if ($data) {
            $body = $data['mail_body'] ?? '';
            
            // Hapus header email dengan regex yang benar
            $body = preg_replace('/^(Received|DKIM-Signature|X-[^:]+|MIME-Version|References|In-Reply-To|Message-ID|Content-Transfer-Encoding):[^\n]*(\n\s+[^\n]*)*/im', '', $body);
            
            // Hapus boundary MIME
            $body = preg_replace('/--[a-f0-9]+(--)?\s*\n/i', '', $body);
            
            // Hapus Content-Type headers
            $body = preg_replace('/Content-Type:[^\n]*\n/i', '', $body);
            $body = preg_replace('/Content-Disposition:[^\n]*\n/i', '', $body);
            
            $body = trim($body);
            
            // Hapus HTML tags dengan str_replace (lebih aman)
            $body = strip_tags($body);
            
            // Decode HTML entities
            $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
            
            // Bersihkan multiple newlines
            $body = preg_replace('/\n\n+/', "\n\n", $body);
            
            $data['mail_body'] = $body;
        }
        
        return [
            "provider" => "Guerrillamail",
            "mail_from" => $data['mail_from'] ?? null,
            "mail_subject" => $data['mail_subject'] ?? null,
            "mail_body" => $data['mail_body'] ?? null,
            "mail_timestamp" => $data['mail_timestamp'] ?? null,
            "success" => true
        ];
    }
    
    // ===== MAILDROP =====
    
    public static function maildrop_generate() {
        $randomStr = bin2hex(random_bytes(6));
        $email = $randomStr . "@maildrop.cc";
        
        return [
            "provider" => "Maildrop",
            "email" => $email,
            "success" => true
        ];
    }
    
    public static function maildrop_messages($mailbox) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.maildrop.cc/graphql");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        
        $query = json_encode([
            "query" => "query { inbox(mailbox: \"$mailbox\") { id headerfrom subject date } }"
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        return [
            "provider" => "Maildrop",
            "mailbox" => $mailbox,
            "messages" => $data['data']['inbox'] ?? [],
            "http_code" => $httpCode,
            "success" => true
        ];
    }
    
    public static function maildrop_read($mailbox, $messageId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.maildrop.cc/graphql");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        
        $query = json_encode([
            "query" => "query { message(mailbox: \"$mailbox\", id: \"$messageId\") { id headerfrom subject date data html } }"
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        $message = $data['data']['message'] ?? null;
        
        if ($message) {
            $body = $message['data'] ?? $message['html'] ?? '';
            
            // Hapus header email
            $body = preg_replace('/^(Received|DKIM-Signature|X-[^:]+|MIME-Version|References|In-Reply-To|Message-ID|Content-Transfer-Encoding):[^\n]*(\n\s+[^\n]*)*/im', '', $body);
            
            // Hapus boundary MIME
            $body = preg_replace('/--[a-f0-9]+(--)?\s*\n/i', '', $body);
            
            // Hapus Content-Type headers
            $body = preg_replace('/Content-Type:[^\n]*\n/i', '', $body);
            $body = preg_replace('/Content-Disposition:[^\n]*\n/i', '', $body);
            
            $body = trim($body);
            
            // Hapus HTML tags dengan strip_tags
            $body = strip_tags($body);
            
            // Decode HTML entities
            $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
            
            // Bersihkan multiple newlines
            $body = preg_replace('/\n\n+/', "\n\n", $body);
            
            $message['data'] = $body;
        }
        
        return [
            "provider" => "Maildrop",
            "message" => $message,
            "success" => true
        ];
    }
}

// API ENDPOINTS
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? null;

if (!$action) {
    echo json_encode([
        "success" => false,
        "error" => "No action specified",
        "available_actions" => [
            "guerrillamail_generate",
            "guerrillamail_messages?email=XXX&sid=XXX",
            "guerrillamail_read?sid=XXX&id=XXX",
            "maildrop_generate",
            "maildrop_messages?mailbox=XXX",
            "maildrop_read?mailbox=XXX&id=XXX"
        ]
    ]);
    exit;
}

switch ($action) {
    case 'guerrillamail_generate':
        echo json_encode(TempMailIntegration::guerrillamail_generate());
        break;
    
    case 'guerrillamail_messages':
        $email = $_GET['email'] ?? null;
        $sid = $_GET['sid'] ?? null;
        if ($email && $sid) {
            echo json_encode(TempMailIntegration::guerrillamail_messages($email, $sid));
        } else {
            echo json_encode(["success" => false, "error" => "Email and SID required"]);
        }
        break;
    
    case 'guerrillamail_read':
        $sid = $_GET['sid'] ?? null;
        $messageId = $_GET['id'] ?? null;
        if ($sid && $messageId) {
            echo json_encode(TempMailIntegration::guerrillamail_read($sid, $messageId));
        } else {
            echo json_encode(["success" => false, "error" => "SID and message ID required"]);
        }
        break;
    
    case 'maildrop_generate':
        echo json_encode(TempMailIntegration::maildrop_generate());
        break;
    
    case 'maildrop_messages':
        $mailbox = $_GET['mailbox'] ?? null;
        if ($mailbox) {
            echo json_encode(TempMailIntegration::maildrop_messages($mailbox));
        } else {
            echo json_encode(["success" => false, "error" => "Mailbox required"]);
        }
        break;
    
    case 'maildrop_read':
        $mailbox = $_GET['mailbox'] ?? null;
        $messageId = $_GET['id'] ?? null;
        if ($mailbox && $messageId) {
            echo json_encode(TempMailIntegration::maildrop_read($mailbox, $messageId));
        } else {
            echo json_encode(["success" => false, "error" => "Mailbox and message ID required"]);
        }
        break;
    
    default:
        echo json_encode(["success" => false, "error" => "Unknown action: " . $action]);
}
?>
