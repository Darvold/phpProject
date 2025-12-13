<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{--@yield('title')--}}phpProject</title>
    <link rel="stylesheet" href="{{asset('css/main/msg.css')}}">
    @php
    $profileStyles = [
        'authUsers' => 'auth/',
        'homeProfile' => 'main/',
        'crudUsers' => 'main/',

    ];
    @endphp

    @foreach ($profileStyles as $styleVar => $stylePath)
    @if (isset($$styleVar) && is_array($$styleVar))
    @foreach ($$styleVar as $style)
    <link rel="stylesheet" href="{{ asset('css/' . $stylePath . $style) }}">
    @endforeach
    @endif
    @endforeach
</head>
<body>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/NumberMask/imask.js') }}"></script>
    @include('template.msg')
    <div class="allBody">
        @if(Route::currentRouteName() !== 'login.index' && Route::currentRouteName() !== 'regist.index')
        <div class="head">
            <div class="head-left">
                <div class="logo">
                    <span class="logo-text">
                        <span class="logo-php">php</span>
                        <span class="logo-project">Project</span>
                    </span>
                    <div class="logo-subtitle">Панель управления</div>
                </div>
            </div>

            <div class="head-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        <div class="avatar-wrapper">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#667eea" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->fio ?? 'Гость' }}</div>
                        <div class="user-role">{{ auth()->user()->getRoleName() }}</div>
                    </div>
                </div>

                <div class="logout-section">
                    <form method="POST" action="{{ route('logoutUser.store') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Выйти</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="body">
            @if(Route::currentRouteName() !== 'login.index' && Route::currentRouteName() !== 'regist.index')
            <div class="mainBlock">
                <div class="leftColumn">
                    <div class="menu-section">
                        <div class="menu-header">Навигация</div>
                        <div class="menu-links">
                            <a href="{{route('home.index')}}" class="menu-link">
                                <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                Профиль
                            </a>
                            <a href="{{route('crudUsers.index')}}" class="menu-link">
                                <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                                </svg>
                                CRUD-операции
                            </a>
                        </div>
                    </div>
                    <div class="menu-section">
                        @yield('leftBlockFunctions')
                    </div>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".notification").css('top', '-100px');
            setTimeout(function () {
                $(".notification").animate({top: 20}, 500, function () {
                    setTimeout(function () {
                        $(".notification").animate({top: '-100px'}, 500, function () {
                            $(this).remove();
                        });
                }, 6000); // 3 секунды
                });
            }, 0);
        });
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>
