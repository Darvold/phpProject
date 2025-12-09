@extends('layouts.app', ['authUsers' => ['auth.css']])
@section('content')
<section>
    <div class="form-box">
        <div class="form-value">
            <form method="POST" action="{{route('regist.store')}}" id="loginForm">
                @csrf
                <h2>Регистрация</h2>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="fio" placeholder="" value="{{ old('fio') }}" required>
                    <label for="">ФИО</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" placeholder="" value="{{ old('email') }}" required>
                    <label for="">Почта</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" data-mask="phone" id="phone" class="phone" value="{{ old('phone') }}" required placeholder="">
                    <label for="">Телефон</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password" placeholder="" required>
                    <label for="">Пароль</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password_confirmation" placeholder="" required>
                    <label for="">Подтверждение пароля</label>
                </div>
                <button type="submit" id="submitBtn">Создать аккаунт</button>
                <div class="register">
                    <p>У вас уже есть аккаунт? <a href="{{ route('login.index') }}">Войти</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
    // Обработка отправки формы
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            const $phoneInput = $('#phone');
            const $form = $(this);

        // Очищаем номер от всех символов кроме цифр
            let phoneValue = $phoneInput.val().replace(/\D/g, '');

        // Проверяем длину номера
            if (phoneValue.length === 10) {
            // Если пользователь ввел 10 цифр без +7
                phoneValue = '7' + phoneValue;
            }

        // Проверяем валидность
            if (phoneValue.length !== 11 || !phoneValue.startsWith('7')) {
                alert('Пожалуйста, введите корректный номер телефона в формате +7 XXX XXX-XX-XX');
                $phoneInput.focus();
                return false;
            }

        // Формируем номер в нужном формате
            const formattedPhone = '7' + phoneValue.substring(1);

        // Создаем скрытое поле или обновляем существующее
            let $hiddenPhone = $('input[name="phone"][type="hidden"]', $form);

            if ($hiddenPhone.length === 0) {
            // Создаем новое скрытое поле
                $hiddenPhone = $('<input>', {
                    type: 'hidden',
                    name: 'phone',
                    value: formattedPhone
                });
                $form.append($hiddenPhone);
            } else {
            // Обновляем существующее
                $hiddenPhone.val(formattedPhone);
            }

        // Отправляем форму
            this.submit();
        });
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
@endsection
