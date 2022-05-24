// function form_validation(){

// 	//возвращаем результат валидации
// 	return fio_reg.test(FIO) && email_reg.test(email) && phone_reg.test(phone);
// }

$('.submit_btn').click(function(e){ 	//обработчик кнопки отпрвки
    e.preventDefault();
    var FIO = document.mail_form.FIO.value;
    var email = document.mail_form.email.value;
    var phone = document.mail_form.phone.value;
    var comment = document.mail_form.comment.value;
    var fio_reg = /[А-я]{1,25} [А-я]{1,25} [А-я]{1,25}/;
	var email_reg = /[a-zA-Z._]{3,25}@[a-z]{2,20}\.[a-z]{2,3}/;
	var phone_reg = /\+?[0-9]{11}/;
    if($('#FIO').hasClass('error')){		//убираем все классы ошибок из верстки
        $('#FIO').removeClass('error');
    }
    if($('#email').hasClass('error')){
        $('#email').removeClass('error');
    }
    if($('#phone').hasClass('error')){
        $('#phone').removeClass('error');
    }

    $('.error_msg').text("");		//снова добавляем классы ошибок если находим таковые
	if ( !fio_reg.test( FIO )){
        $('#FIO').addClass(' error');
		$('.error_msg').append("ФИО должно быть в формате <Пупкин Василий Васильевич><br />");
    }
	if ( !email_reg.test( email )){
        $('#email').addClass(' error');
        $('.error_msg').append("E-mail должен быть в формате test@gmail.com<br />");
    }
	if ( !phone_reg.test( phone )){
        $('#phone').addClass(' error');
        $('.error_msg').append("Телефон должен быть в формате 89205109999 или +79205109999<br />");
    }

    if(fio_reg.test(FIO) && email_reg.test(email) && phone_reg.test(phone)){		//отправка запроса на бэк
        $.ajax({
            url: 'send.php',
            type: 'POST',
            dataType: 'json',
            data: {
                FIO: FIO,
                comment: comment,
                email: email,
                phone: phone
            },
            success(data) {
                if(data.status) {
                    $('.feedback_form').removeClass('close').addClass(' open');
                    $('.form').addClass(' close');
                    $('.feedback_form_msg').text("");
                    $('.feedback_form_msg').append(data.datas);
                    $('.feedback_form_msg').append("<br>");
                }
                else{
                    $('.error_msg').text("");
                    data.errors.forEach(error => {
                        $('.error_msg').addClass(' open').append(error);
                        $('.error_msg').append("<br>");
                    });
                }
            }
        })
    }
});
