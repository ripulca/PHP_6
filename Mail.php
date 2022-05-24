<?php

require_once "DB.php";

class Mail extends DB
{
    public function getMailTimeByEmail($email)  //получение времени письма по email
    {
        $proc = $this->pdo->prepare("SELECT MAX(mail_time)
                                    FROM mails WHERE email=?;");
        $proc->bindValue(1, $email, PDO::PARAM_STR);
        $proc->execute();
        return $proc->fetch(PDO::FETCH_ASSOC);
    }

    public function addMail($FIO, $email, $phone, $datetime, $comment){     //добавить запись с письмом, аргументы(фио, email, телефон, время, содержание)
        try {
            $proc = $this->pdo->prepare("INSERT INTO mails (FIO, email, phone, mail_time, comment) 
                                            VALUES (:FIO, :email, :phone, :mail_time, :comment); ");
;
            $save_FIO = htmlspecialchars($FIO);
            $save_email = htmlspecialchars($email);
            $save_phone = htmlspecialchars($phone);
            $save_comment = htmlspecialchars($comment);
            $proc->bindValue(":FIO" , $save_FIO);
            $proc->bindValue(":email" , $save_email);
            $proc->bindValue(":phone" , $save_phone);
            $proc->bindValue(":mail_time" , $datetime);
            $proc->bindValue(":comment" , $save_comment);
            
            $proc->execute();
        } catch (PDOException $e) {
            echo "Ошибка сохранения: " . $e->getMessage();
            return false;
        }
        return true;
    }
}
