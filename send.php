<?php
session_start();

// Настройки SMTP
$smtp_host = 'smtp.yandex.ru';
$smtp_port = 465; // SSL
$smtp_user = 'your_email';  // твой логин
$smtp_pass = 'your_password';     // пароль или пароль приложения

$to_email = 'your_email';   // Куда отправлять письмо
$from_email = $smtp_user;
$from_name = 'Сайт Вывоза Мусора';

function smtp_send_mail($host, $port, $user, $pass, $to, $from_email, $from_name, $subject, $body) {
    $contextOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];
    $socket = stream_socket_client("ssl://$host:$port", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, stream_context_create($contextOptions));
    if (!$socket) {
        return "Не удалось подключиться к SMTP серверу: $errstr ($errno)";
    }

    function smtp_read($socket) {
        $data = '';
        while ($str = fgets($socket, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) == ' ') break;
        }
        return $data;
    }

    function smtp_command($socket, $cmd) {
        fwrite($socket, $cmd . "\r\n");
        return smtp_read($socket);
    }

    $response = smtp_read($socket);

    $response = smtp_command($socket, "EHLO " . gethostname());
    if (strpos($response, '250') === false) {
        return "Ошибка EHLO: $response";
    }

    $response = smtp_command($socket, "AUTH LOGIN");
    if (strpos($response, '334') === false) {
        return "Ошибка AUTH LOGIN: $response";
    }

    $response = smtp_command($socket, base64_encode($user));
    if (strpos($response, '334') === false) {
        return "Ошибка логина: $response";
    }

    $response = smtp_command($socket, base64_encode($pass));
    if (strpos($response, '235') === false) {
        return "Ошибка пароля: $response";
    }

    $response = smtp_command($socket, "MAIL FROM:<$from_email>");
    if (strpos($response, '250') === false) {
        return "Ошибка MAIL FROM: $response";
    }

    $response = smtp_command($socket, "RCPT TO:<$to>");
    if (strpos($response, '250') === false && strpos($response, '251') === false) {
        return "Ошибка RCPT TO: $response";
    }

    $response = smtp_command($socket, "DATA");
    if (strpos($response, '354') === false) {
        return "Ошибка DATA: $response";
    }

    $headers = "From: $from_name <$from_email>\r\n";
    $headers .= "To: <$to>\r\n";
    $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";

    $data = $headers . "\r\n\r\n" . $body . "\r\n.\r\n";

    fwrite($socket, $data);
    $response = smtp_read($socket);
    if (strpos($response, '250') === false) {
        return "Ошибка отправки письма: $response";
    }

    $response = smtp_command($socket, "QUIT");
    fclose($socket);

    return true;
}

function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? clean_input($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? clean_input($_POST['phone']) : '';
    $comment = isset($_POST['comment']) ? clean_input($_POST['comment']) : '';

    if (!$name || !$phone) {
        $_SESSION['form_status'] = ['success' => false, 'message' => 'Ошибка: имя и телефон обязательны.'];
        header('Location: index.php');
        exit;
    }

    $subject = "Новая заявка с сайта по вывозу мусора";
    $body = "Новая заявка с сайта:\n\n";
    $body .= "Имя: $name\n";
    $body .= "Телефон: $phone\n";
    if ($comment) {
        $body .= "Комментарий: $comment\n";
    }

    $result = smtp_send_mail($smtp_host, $smtp_port, $smtp_user, $smtp_pass, $to_email, $from_email, $from_name, $subject, $body);

    if ($result === true) {
        $_SESSION['form_status'] = ['success' => true, 'message' => 'Спасибо! Ваша заявка отправлена.'];
    } else {
        $_SESSION['form_status'] = ['success' => false, 'message' => "Ошибка отправки: $result"];
    }

    header('Location: index.php');
    exit;
} else {
    http_response_code(405);
    echo "Метод не поддерживается.";
}