@extends('layouts.app', ['crudUsers' => ['mainCSS.css', 'head.css', 'homeUser.css', 'crudUsers.css']])
@section('leftBlockFunctions')
    <div class="functions">
        <div class="menu-header">Управление</div>
        <div class="functions-links">
            <a href="{{route('crudUsers.index')}}" class="functions-link current">
                <svg class="functions-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                </svg>
                Пользователи
            </a>
            <a href="{{route('crudBooks.index')}}" class="functions-link">
                <svg class="functions-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                </svg>
                Книги
            </a>
        </div>
    </div>

@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-title">Управление пользователями</h1>
            <p class="page-subtitle">Список всех зарегистрированных пользователей системы</p>
        </div>

        <div class="content-main">
            <div class="main-container">
                <!-- Блок с формой и списком пользователей -->
                <div class="content-grid">
                    <!-- Левая колонка: Форма пользователя -->
                    <div class="user-form-section">
                        <div class="form-card">
                            <div class="form-header">
                                <h3 class="form-title">
                                    <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                         fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                    </svg>
                                    Данные пользователя
                                </h3>
                                <div class="form-actions">
                                    <button class="btn-save">Сохранить</button>
                                    <button class="btn-cancel">Отменить</button>
                                </div>
                            </div>

                            <form class="user-form">
                                <div class="form-group">
                                    <label class="form-label">
                                        <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="12" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                        </svg>
                                        ФИО
                                    </label>
                                    <input type="text" class="form-input" placeholder="Введите ФИО"
                                           value="Михаил Шевяков Дмитрович">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="12" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                        </svg>
                                        Email
                                    </label>
                                    <input type="email" class="form-input" placeholder="user@example.com"
                                           value="mikhail@example.com">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="12" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                        </svg>
                                        Пароль
                                    </label>
                                    <input type="password" class="form-input" placeholder="Новый пароль">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="12" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1h-11zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5v-11zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293L9 13.793z"/>
                                        </svg>
                                        Роль
                                    </label>
                                    <select class="form-select">
                                        <option value="user" selected>Пользователь</option>
                                        <option value="admin">Администратор</option>
                                        <option value="moderator">Модератор</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="userList"
                         data-users='@json($users)'
                         data-current-page="{{ $currentPage }}"
                         data-total-pages="{{ $totalPages }}"
                         data-total-items="{{ $totalItems }}"
                         data-per-page="{{ $perPage }}"
                         data-pagination-url="{{ route('users.api.get') }}">
                         data-paginationSearch-url="{{ route('crudUsers.index') }}">
                        @if(isset($searchQuery))
                            data-search-query="{{ $searchQuery }}"
                        @endif>
                    </div>
                    <!-- Правая колонка: Список пользователей -->
                     {{-- <div class="users-list-section">
                        <div class="list-card">
                            <div class="list-header">
                                <h3 class="list-title">Список пользователей</h3>
                                <div class="list-actions">
                                    <button class="btn-add-user">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                        Добавить
                                    </button>
                                    <div class="search-box">
                                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="14"
                                             height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                        <input type="text" class="search-input" placeholder="Поиск пользователей...">
                                    </div>
                                </div>
                            </div>

                            <div class="users-table">
                                <div class="table-header">
                                    <div class="table-row header-row">
                                        <div class="table-cell">ФИО</div>
                                        <div class="table-cell">Email</div>
                                        <div class="table-cell">Роль</div>
                                        <div class="table-cell">Статус</div>
                                        <div class="table-cell">Действия</div>
                                    </div>
                                </div>

                                <div class="table-body">
                                    <!-- Другие пользователи -->
                                    @foreach($allUsers as $user)
                                        <div class="table-row user-row">
                                            <div class="table-cell">
                                                <div class="user-cell">
                                                    <div class="user-avatar-small">{{$user->initials}}</div>
                                                    <div class="user-info-cell">
                                                        <div class="user-name">{{$user->fio}}</div>
                                                        <div class="user-email-small">{{$user->email}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-cell">{{$user->email}}</div>
                                            <div class="table-cell">
                                                @if($user->role == 1)
                                                    <span class="role-badge user">Пользователь</span>
                                                @elseif($user->role == 2)
                                                    <span class="role-badge admin">Администратор</span>
                                                @elseif($user->role == 3)
                                                    <span class="role-badge moderator">Модератор</span>
                                                @else
                                                    <span class="role-badge user">Неизвестно (ошибка)</span>
                                                @endif
                                            </div>
                                            <div class="table-cell">
                                                <span
                                                    class="status-indicator {{ $user->is_active ? 'active' : '' }}"></span>
                                                {{ $user->is_active ? 'Активен' : 'Не активен' }}
                                            </div>
                                            <div class="table-cell">
                                                <div class="action-buttons">
                                                    <button class="btn-action edit">✏️</button>
                                                    <button class="btn-action delete">🗑️</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="list-footer">
                                <div class="pagination">
                                    <button class="pagination-btn active">1</button>
                                    <button class="pagination-btn">2</button>
                                    <button class="pagination-btn">3</button>
                                    <span class="pagination-dots">...</span>
                                    <button class="pagination-btn">10</button>
                                </div>
                                <div class="total-users">
                                    Всего пользователей: <strong>25</strong>
                                </div>
                            </div>
                        </div>
                    </div>  --}}
                    {{--Конец списка пользователей --}}
                </div>
            </div>
        </div>
    </div>
@endsection
