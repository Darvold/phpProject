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
<!--        <div class="form-group">
            <label class="form-label">
                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                     height="12" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                </svg>
                Пароль
            </label>
            <input type="password" class="form-input" placeholder="Новый пароль">
        </div>-->
        <div class="content-main">
            <div class="main-container">
                <!-- Блок с формой и списком пользователей -->
                <div class="content-grid">
                    <!-- Левая колонка -->
                    <div class="user-form-section">
                        {{-- Левая колонка создать/обновить данные пользователя --}}
                        <div id="updateUserData"
                             data-pagination-url="{{ route('userUpdate.api.get') }}">
                        </div>
                        {{-- Конец левой колонки создать/обновить данные пользователя --}}
                    </div>
                    {{-- Конец левой колонки --}}
                    <!-- Правая колонка: Список пользователей -->
                    <div id="userList"
                         data-users='@json($users)'
                         data-my-id="{{Auth::id()}}"
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
                    {{--Конец списка пользователей --}}
                </div>
            </div>
        </div>
    </div>
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
