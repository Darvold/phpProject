<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>phpProject</title>
    <link rel="stylesheet" href="{{asset('css/main/head.css')}}">
    <link rel="stylesheet" href="{{asset('css/main/homeUser.css')}}">
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
    <div class="allBody">
        <div class="head">
            <div class="nameProject">
                <span><b>php</b><span class="name">Project</span></span>
            </div>
            <div class="rightHeadBlock">
                <div class="user-info">
                    <div class="user-avatar">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#667eea">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="user-name">
                        {{ auth()->user()->fio ?? 'Гость' }}
                    </div>
                </div>
                <div class="exit">
                    <form method="POST" action="{{ route('logoutUser.store') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Выйти
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="mainBlock">
                
            </div>
        </div>
    </div>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
       /* document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
            e.preventDefault();
            const phoneInput = document.querySelector('#phone');
            const phoneHidden = document.querySelector('input[name="phone"]');
            phoneHidden.value = phoneInput.value.replace(/\D/g, '');
            this.closest('form').submit();
        });*/

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
