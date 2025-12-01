<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>phpProject</title>
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
</head>
<body>
<script src="{{ asset('js/NumberMask/imask.js') }}"></script>
<div class="form-msg">
    @if (session('success'))
        <div class="notification-content">
            <div class="notification"> {{ session('success') }}</div>
        </div>

    @elseif (session('error'))
        <div class="notification-content">
            <div class="notification"> {{ session('error') }}</div>
        </div>

    @endif
</div>
<section>
    <div class="form-box">
        <div class="form-value">
            <form method="POST" action="{{route('regist.store')}}">
                @csrf
                <h2>Регистрация</h2>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="fio" placeholder="Иванов Иван Иванович" value="{{ old('fio') }}" required>
                    <label for="">ФИО</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" placeholder="PiGarage.2024@mail.ru" value="{{ old('email') }}" required>
                    <label for="">Почта</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" data-mask="phone" id="phone" class="phone" value="{{ old('phone') }}" required placeholder="+7">
                    <input type="hidden" name="phone" value="" required>
                    <label for="">Телефон</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password" placeholder="" required>
                    <label for="">Пароль</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password_confirmation" placeholder="Менее 6 символов (макс. 255)" required>
                    <label for="">Подтверждение пароля</label>
                </div>
                <button type="submit">Создать аккаунт</button>
                <div class="register">
                    <p>У вас уже есть аккаунт? <a href="{{ route('login.index') }}">Войти</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
    document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
        e.preventDefault();
        const phoneInput = document.querySelector('#phone');
        const phoneHidden = document.querySelector('input[name="phone"]');
        phoneHidden.value = phoneInput.value.replace(/\D/g, '');
        this.closest('form').submit();
    });
    const cards = document.querySelectorAll(".card");

    /* View Controller
    -----------------------------------------*/
    const btns = document.querySelectorAll(".js-btn");
    btns.forEach((btn) => {
        btn.addEventListener("click", on_btn_click, true);
        btn.addEventListener("touch", on_btn_click, true);
    });

    function on_btn_click(e) {
        const nextID = e.currentTarget.getAttribute("data-target");
        const next = document.getElementById(nextID);
        if (!next) return;
        bg_change(nextID);
        view_change(next);
        return false;
    }

    /* Add class to the body */
    function bg_change(next) {
        document.body.className = "";
        document.body.classList.add("is-" + next);
    }

    /* Add class to a card */
    function view_change(next) {
        cards.forEach((card) => {
            card.classList.remove("is-show");
        });
        next.classList.add("is-show");
    }

</script>
<script>
    $(document).ready(function() {
        $(".notification").css('top', '-100px'); // Скрываем уведомление за пределами видимой области
        setTimeout(function() {
            $(".notification").animate({top: 20}, 500, function() {
                setTimeout(function() {
                    $(".notification").animate({top: '-100px'}, 500, function() {
                        $(this).remove();
                    });
                }, 6000); // 3 секунды
            });
        }, 0); // Задержка перед появлением
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputElement = document.querySelector('[data-mask="phone"]')
        const maskOptions = { // создаем объект параметров
            mask: '+{7}(000)000-00-00' // задаем единственный параметр mask
        }
        IMask(inputElement, maskOptions) // запускаем плагин с переданными параметрами
    })
</script>
</body>
</html>
