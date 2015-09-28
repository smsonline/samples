<?
$login = 'login';
$secretKey = 'secret_key';
$testPhone = '79261234567';
$txt = 'Тестовое сообщение в Viber';

$debug = false;

// Загрузка изображения
$filePath = dirname(__FILE__) .'/image.jpg';
$sign = md5($login . md5_file($filePath) . $secretKey);

$ch = curl_init('http://media.sms-online.com/upload/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_VERBOSE, $debug);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
    'login' => $login,
    'image' => '@' . $filePath,
    'sign' => $sign
));
$result = json_decode(curl_exec($ch), true);
curl_close($ch);

$imageId = false;
if (!empty($result['image_id'])) {
    $imageId = $result['image_id'];
}

// Отправка сообщения
$data = array(
    'user' => $login,
    'from' => 'Viber',
    'phone' => $testPhone,
    'txt' => $txt,
    'image_id' => $imageId,
    'button_text' => 'Перейти',
    'button_link' => 'http://sms-online.com/',
    'sign' => $sign,
    'sending_method' => 'viber',
);
$data['sign'] = md5( $data['user'] . $data['from'] . $data['phone'] . $data['txt'] . $secretKey );

$ch = curl_init('https://bulk.sms-online.com/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_VERBOSE, $debug);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
curl_close($ch);

// Вывод результата отправки сообщения:
print_r($result);

