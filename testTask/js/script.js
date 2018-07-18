// Валидность електронной почты
function checkEmail(email) {
    var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(String(email).toLowerCase());
}
//Валидность логина
function checkLogin(loginString) {
    var pattern = /^[a-zA-Z](.[a-zA-Z0-9_-]*)$/;
    return pattern.test(loginString);
}
//Валидность имени
function checkUserName(UserName) {
    var pattern = /^[a-zA-Zа-яА-Я'][a-zA-Zа-яА-Я-' ]+[a-zA-Zа-яА-Я']?$/;
    return pattern.test(UserName);
}

//Валидность пароля
function checkPass(pass) {
    var pattern = /^[a-zA-Z0-9]+$/;
    return pattern.test(pass);
}


function checkPassword() {

    var password = document.getElementById('input-type-input-password').value; // Получаем пароль из формы
    var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
    var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
    var digits = "0123456789"; // Цифры
    var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
    var is_s = false; // Есть ли в пароле буквы в нижнем регистре
    var is_b = false; // Есть ли в пароле буквы в верхнем регистре
    var is_d = false; // Есть ли в пароле цифры
    var is_sp = false; // Есть ли в пароле спецсимволы
    for (var i = 0; i < password.length; i++) {
        /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
        if (!is_s && s_letters.indexOf(password[i]) != -1) is_s = true;
        else if (!is_b && b_letters.indexOf(password[i]) != -1) is_b = true;
        else if (!is_d && digits.indexOf(password[i]) != -1) is_d = true;
        else if (!is_sp && specials.indexOf(password[i]) != -1) is_sp = true;
    }
    //Проверка сложности в зависимости от регистра
    var rating = 0;
    var color_input = "";
    if (is_s) rating++;
    if (is_b) rating++;
    if (is_d) rating++;
    if (is_sp) rating++;

    if (password.length < 6 && rating < 3) color_input = "#c74646"; //Простой
    else if (password.length < 6 && rating >= 3) color_input = "#c7c046"; //Средний
    else if (password.length >= 8 && rating < 3) color_input = "#c7c046"; //Средний
    else if (password.length >= 8 && rating >= 3) color_input = "#35a137"; //Сложный
    else if (password.length >= 6 && rating == 1) color_input = "#c74646"; //Простой
    else if (password.length >= 6 && rating > 1 && rating < 4) color_input = "#c7c046"; //Средний
    else if (password.length >= 6 && rating == 4) color_input = "#35a137"; //Сложный
    document.getElementById('input-type-input-password').style.backgroundColor = color_input;
    if (password == "") document.getElementById('input-type-input-password').style.backgroundColor = "#f1f1f1";

    return false;
}

//Валидность даты
function checkDate(date) {
    var pattern = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    return pattern.test(date);
}




function dataverification(e) {
    var finish = false;
    var email = document.getElementById('input-type-input-email').value;
    var login = document.getElementById('input-type-input-login').value;
    var name = document.getElementById('input-type-input-name').value;
    var password = document.getElementById('input-type-input-password').value;
    var datebirth = document.getElementById('input-type-input-date-day').value + "/" + document.getElementById('input-type-input-date-month').value + "/" + document.getElementById('input-type-input-date-year').value;
    var country = document.getElementById('input-type-select').value;
    var error = new Object();

    var kat = document.getElementById('input-type-input-password').style.backgroundColor;
    var checkBox = document.getElementById('input-type-checkbox');

    error.Email = {
        sost: checkEmail(email) ? true : false,
        mess: "Вы ввели некорректный Email!",
        addr: document.getElementById('input-type-input-email')
    };

    error.Login = {
        sost: checkLogin(login) ? true : false,
        mess: "Вы ввели некорректный логин!",
        addr: document.getElementById('input-type-input-login')
    };

    error.Name = {
        sost: checkUserName(name) ? true : false,
        mess: "Вы ввели некорректное имя!",
        addr: document.getElementById('input-type-input-name')
    };

    error.Pass = {
        sost: kat == 'rgb(53, 161, 55)' || kat == 'rgb(199, 192, 70)' && checkPass(password) ? true : false,
        mess: 'Вы ввели некорректный пароль! \n Разрешены только латинские буквы и цифры!',
        addr: document.getElementById('input-type-input-password')
    };

    error.Date = {
        sost: checkDate(datebirth) ? true : false,
        mess: "Вы ввели некорректную дату!",
    };

    error.Confirm = {
        sost: checkBox.checked ? true : false,
        mess: "Для звершения регистрации вы должны прочитать и согласиться с условиями пользования!",
    };

    for (var key in error) {
        if (error[key]['sost']) {
            if (error[key]['addr']) error[key]['addr'].style.backgroundColor = "#f1f1f1";
        } else {
            message(error[key]['mess']);
            finish = true;
            if (error[key]['addr']) error[key]['addr'].style.backgroundColor = "rgba(156, 72, 72, 0.7)";
            break;
        }
    }
    if (finish) e.preventDefault();

}

//Анимация измененния элемента всплывающего изображения 1-сворачивание 2-развёртывание
function myMove(typeanim) {
    var elem = document.getElementById("message-verification");
    var id = setInterval(frame, 10);
    if (typeanim == 1) {
        var pos = elem.offsetHeight;
    } else {
        var pos = 0;
    }

    function frame() {
        if (typeanim == 1) {
            if (pos == 0) {
                clearInterval(id);
            } else {
                pos--;
                elem.style.height = pos + 'px';
            }
        } else {
            if (pos == 68) {
                clearInterval(id);
            } else {
                pos++;
                elem.style.height = pos + 'px';
            }
        }
    }
}

function message(mess) {

    var messageblock = document.getElementById("message-verification");
    var messagebody = document.getElementById("message-body");
    messageblock.style.display = "block";
    messagebody.innerHTML = mess;
    myMove(2);

    setTimeout(function () {
        closewindowopen(3);
    }, 5000);


}




function closewindowopen(b) {
    switch (b) {
        case 1:
            var closepanel = document.getElementById("message-close-window");
            closepanel.style.height = "15px";
            break;

        case 2:
            var closepanel = document.getElementById("message-close-window");
            closepanel.style.height = "0px";
            break;

        case 3:
            var messageblock = document.getElementById("message-verification");
            var messagebody = document.getElementById("message-body");

            myMove(1);

            setTimeout(function () {
                messageblock.style.display = "none";
                messagebody.innerHTML = "";
            }, 2000);

            break;
    }
}

//window.onload = function () {
//    message("Вы ввели неправильно пароль");
//}


function toLogin() {
    document.getElementById('form-registration').style.display = "none";
    document.getElementById('form-login').style.display = "block";
}

function dataverificationlogin(e) {
    var finish = false;
    var first = document.getElementById('input-type-first').value;
    var password = document.getElementById('input-type-password').value;

    var error = new Object();

    var kat = document.getElementById('input-type-password').style.backgroundColor;

    error.First = {
        sost: checkEmail(first) || checkLogin(first) ? true : false,
        mess: "Вы ввели некорректный Email!",
        addr: document.getElementById('input-type-first')
    };

    error.Pass = {
        sost: checkPass(password) ? true : false,
        mess: 'Вы ввели некорректный пароль! \n Разрешены только латинские буквы и цифры!',
        addr: document.getElementById('input-type-password')
    };

    for (var key in error) {
        if (error[key]['sost']) {
            if (error[key]['addr']) error[key]['addr'].style.backgroundColor = "#f1f1f1";
        } else {
            message(error[key]['mess']);
            finish = true;
            if (error[key]['addr']) error[key]['addr'].style.backgroundColor = "rgba(156, 72, 72, 0.7)";
            break;
        }
    }
    if (finish) e.preventDefault();


}

function toRegistration() {
    document.getElementById('form-login').style.display = "none";
    document.getElementById('form-registration').style.display = "block";

}
