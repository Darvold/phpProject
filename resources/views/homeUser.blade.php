@extends('layouts.app', ['homeProfile' => ['mainCSS.css', 'head.css', 'homeUser.css']])
@section('content')
<div class="rightBlock">
    <div class="profile-wrapper">
        <!-- Шапка профиля -->
        <div class="profile-header">
            <h1 class="profile-title">
                <svg class="profile-title-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Профиль пользователя
            </h1>
            <div class="profile-subtitle">Управление персональными данными</div>
        </div>

        <!-- Основной контент профиля -->
        <div class="profile-content">
            <!-- Аватар -->
            <div class="profile-avatar-section">
                <div class="avatar-container">
                    <div class="avatar-wrapper-large">
                        <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#667eea" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <div class="avatar-status">
                            <div class="status-dot"></div>
                            <span class="status-text">Online</span>
                        </div>
                    </div>
                    <button class="avatar-change-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Изменить фото
                    </button>
                </div>
            </div>

            <!-- Форма с данными -->
            <div class="profile-form-section">
                <form method="POST" action="{{route('home.put')}}" class="profile-form">
                    @csrf
                    @method('PUT')

                    <!-- Карточка с персональными данными -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">
                                <svg class="form-card-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Персональные данные
                            </h3>
                        </div>

                        <div class="form-fields">
                            <!-- ФИО -->
                            <div class="form-field-group">
                                <div class="field-header">
                                    <label for="fio" class="field-label">
                                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="26" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                        </svg>
                                        ФИО
                                    </label>
                                    <div class="field-required">*</div>
                                </div>
                                <div class="field-input-wrapper">
                                    <input type="text" id="fio" name="fio" value="{{ auth()->user()->fio }}"
                                    class="form-input-field" placeholder="Введите ваше полное имя">
                                    <div class="field-hint">Полное имя как в паспорте</div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-field-group">
                                <div class="field-header">
                                    <label for="email" class="field-label">
                                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        Email
                                    </label>
                                    <div class="field-required">*</div>
                                </div>
                                <div class="field-input-wrapper">
                                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                    class="form-input-field" placeholder="example@mail.ru">
                                </div>
                            </div>

                            <!-- Телефон -->
                            <div class="form-field-group">
                                <div class="field-header">
                                    <label for="phone" class="field-label">
                                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                        Телефон
                                    </label>
                                </div>
                                <div class="field-input-wrapper">
                                    <div class="phone-input-wrapper">
                                        <div class="phone-prefix">+7</div>
                                        <input type="tel" id="phone" data-mask="phone" value="{{ auth()->user()->phone }}"
                                        class="form-input-field phone-input" placeholder="">
                                    </div>
                                    <input type="hidden" name="phone" value="" required>
                                    <div class="field-hint">Будет использоваться для входа</div>
                                </div>
                            </div>

                            <!-- Дополнительная информация -->
                            <div class="form-field-group">
                                <div class="field-header">
                                    <label class="field-label">
                                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        Дата регистрации
                                    </label>
                                </div>
                                <div class="field-static-value">
                                    {{ auth()->user()->data_reg->format('d-m-Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопки действий -->
                    <div class="form-actions-section">
                        <button type="submit" id="submit-form-user" class="submit-btn-primary">
                            <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#submit-form-user').click(function(e) {
            e.preventDefault();
            $('input[name="phone"]').val($('#phone').val().replace(/\D/g, ''));
            $(this).closest('form').submit();
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
