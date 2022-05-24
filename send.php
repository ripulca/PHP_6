<?php

require_once "Mail.php";
$mail=new Mail();
$FIO = htmlspecialchars($_POST['FIO']); //экранируем все лишние символы в полученных из формы данных
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$comment = htmlspecialchars($_POST['comment']);

function validate($FIO, $email, $phone) //валидируем фио, email и телефон
{
    return !empty($FIO) && preg_match("/[a-zA-Z._]{3,25}@[a-z]{2,20}\.[a-z]{2,3}/", $email) && preg_match("/\+?[0-9]{11}/", $phone);
}
$errors=array();

if(validate($FIO, $email, $phone)){
    $current_datetime = date("y-m-d H:i:s");    //если прошло валидацию получаем текущую дату и время
    $sus_mail_dates=$mail->getMailTimeByEmail($email);  //получаем время отправленных с этой почты писем
    if($sus_mail_dates["MAX(mail_time)"]!=NULL){    //если такое письмо есть(т.е. не новый почтовый адрес)
        foreach ($sus_mail_dates as $sus_date){     //для всех писем делаем проверку по времени
            $time_from_last = time() - strtotime($sus_date); //разница между текущим временем и временем последней заявки
            if ($time_from_last < 3600) //если с момента последней заявки прошло меньше часа.
            {
                array_push($errors, "Заявки можно отправлять раз в час. Подождите ещё " . strval( round((3600 - $time_from_last)/60) ) . " минут.");    //формируем ошибку
                $response =[
                    "status" =>false,
                    "errors" =>$errors
                ];
                echo json_encode($response);    //отправляем ответ
                die();
            }
        }
    }
    if($mail->addMail($FIO, $email, $phone, $current_datetime, $comment)){  //формируем письмо
        $message = "ФИО: $FIO\nE-mail: $email\nТелефон: $phone\nКомментарий: $comment\nВремя отправки: $current_datetime";
        if(mail('reneitpa@gmail.com', 'TESTTESTTESTTEST', $message)){   //отправка письма
            $message = "ФИО: $FIO<br>E-mail: $email<br>Телефон: $phone<br>Комментарий: $comment<br>Время отправки: $current_datetime<br>";
            $response =[    //формируем оповещение об успешной отправке
                "status" =>true,
                "datas"=>$message,
            ];
        }
        else{
            array_push($errors, "Не удалось отправить письмо на почту.");
        }
    }
    else{
        array_push($errors, "Не удалось сохранить письмо");
    }
}
else{
    array_push($errors, "Не валидные данные");
}
    
if (!empty($errors)) {
    $response =[
        "status" =>false,
        "errors" =>$errors
    ];
}
echo json_encode($response);  //отправка ответа
