<?php

/** 
  title: На почту
  name: email
**/

Class EmailFormAddon {

public static function send($form, $data) {

  foreach ($_POST as $key => $value) {
    $data['message'] = str_replace('{{'.$key.'}}', $value, $data['message']);
    $data['subject'] = str_replace('{{'.$key.'}}', $value, $data['subject']);
  }

  $data['message'] = preg_replace("#\r\n#", '<br>', $data['message'] ?? '');

  // Отправляем письмо
  $to      = $data['to_email'];
  $subject = $data['subject'];
  $message = $data['message'];
  $headers = "From: " . $data['from_name'] . " <" . $data['from_email'] . ">\r\n" .
      // 'Reply-To: ' . $form['from_email'] . "\r\n" .
      "Content-Type: text/html; charset=UTF-8\r\n" .
      'X-Mailer: PHP/' . phpversion();
  $result = mail($to, $subject, $message, $headers);

  if ($result) {
    return [
      'result' => 'ok', 
      'html' => 'Спасибо! Сообщение успешно отправлено!'
    ];
  } else {
    return [
      'result' => 'error', 
      'html' => 'Ошибка! Скорее всего сервер не отправляет письма незащищенным способом. Пожалуста настройте отправку писем через SMTP'
    ];
  }

}

}
