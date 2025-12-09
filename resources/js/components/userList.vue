<template>
    <div class="users-list-section">
        <div class="list-card">
            <!-- Заголовок -->
            <div class="list-header">
                <h3 class="list-title">Список пользователей</h3>
                <div class="list-actions">
                    <button class="btn-add-user">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Добавить
                    </button>
                    <div class="search-box">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <!-- Убрали v-model, пока не реализована логика поиска -->
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="search-input"
                            placeholder="Поиск по ФИО..."
                            @input="handleSearchInput"
                        >
                        <!-- Индикатор загрузки поиска -->
                        <div v-if="searchLoading" class="search-loading"></div>
                    </div>
                </div>
            </div>

            <!-- Таблица пользователей -->
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
                    <!-- Состояние загрузки -->
                    <div v-if="loading" class="loading-state">
                        <div class="spinner"></div>
                        <p>Загрузка пользователей...</p>
                    </div>

                    <!-- Если нет пользователей -->
                    <div v-else-if="!users || users.length === 0" class="no-results">
                        <p>Пользователей не найдено</p>
                    </div>

                    <!-- Список пользователей -->
                    <div v-else>
                        <div
                            v-for="user in users"
                            :key="user.id"
                            class="table-row user-row"
                            :class="{ 'inactive-user': !user.is_active }">

                            <!-- ФИО -->
                            <div class="table-cell">
                                <div class="user-cell">
                                    <div class="user-avatar-small">{{ getInitials(user.fio) }}</div>
                                    <div class="user-info-cell">
                                        <div class="user-name">{{ user.fio || 'Без имени' }}</div>
                                        <div class="user-email-small">{{ user.email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="table-cell">{{ user.email }}</div>

                            <!-- Роль -->
                            <div class="table-cell">
                                <span :class="['role-badge', getRoleBadgeClass(user.role)]">
                                    {{ getRoleName(user.role) }}
                                </span>
                            </div>

                            <!-- Статус -->
                            <div class="table-cell">
                                <span
                                    :class="['status-indicator', {
                                        active: user.is_active,
                                        inactive: !user.is_active
                                    }]"
                                    :title="user.is_active ? 'Активен' : 'Не активен'">
                                </span>
                                {{ user.is_active ? 'Активен' : 'Не активен' }}
                            </div>

                            <!-- Действия -->
                            <div class="table-cell">
                                <div class="action-buttons">
                                    <button
                                        class="btn-action edit"
                                        :title="`Редактировать ${user.fio}`"
                                        @click="editUser(user)">
                                        ✏️
                                    </button>
                                    <button
                                        class="btn-action delete"
                                        :title="`Удалить ${user.fio}`"
                                        @click="deleteUser(user)">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Пагинация -->
            <div class="list-footer" v-if="totalPages > 1">
                <div class="pagination">
                    <!-- Кнопки всех страниц -->
                    <button
                        v-for="page in totalPages"
                        :key="page"
                        class="pagination-btn"
                        :class="{ active: currentPage === page }"
                        @click="changePage(page)">
                        {{ page }}
                    </button>
                </div>
                <div class="pagination-info">
                    Страница <strong>{{ currentPage }}</strong> из <strong>{{ totalPages }}</strong>
                    <span class="divider">|</span>
                    Всего пользователей: <strong>{{ totalItems }}</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Реактивные данные
const users = ref([]);
const loading = ref(false);
const searchLoading = ref(false);
const currentPage = ref(1);
const totalPages = ref(1);
const totalItems = ref(0);
const perPage = ref(6);
const paginationUrl = ref('');
const paginationSearch = ref('');
const searchQuery = ref('');
const searchTimeout = ref(null);

// Инициализация данных при монтировании
onMounted(() => {
    const container = document.getElementById('userList');
    if (container) {
        try {
            users.value = JSON.parse(container.dataset.users || '[]');
            currentPage.value = parseInt(container.dataset.currentPage || '1');
            totalPages.value = parseInt(container.dataset.totalPages || '1');
            totalItems.value = parseInt(container.dataset.totalItems || '0');
            perPage.value = parseInt(container.dataset.perPage || '6');
            paginationUrl.value = container.dataset.paginationUrl || window.location.pathname;

            console.log('Инициализация данных:', {
                usersCount: users.value?.length || 0,
                currentPage: currentPage.value,
                totalPages: totalPages.value,
                totalItems: totalItems.value,
                perPage: perPage.value
            });
        } catch (error) {
            console.error('Ошибка парсинга данных:', error);
            users.value = [];
        }
    }
});

// Метод для получения инициалов
const getInitials = (name) => {
    if (!name || typeof name !== 'string') return '??';

    const parts = name.split(' ').filter(part => part.length > 0);
    if (parts.length >= 2) {
        return (parts[0][0] + parts[1][0]).toUpperCase();
    }
    return name.substring(0, 2).toUpperCase();
};

// Логика для ролей
const getRoleName = (roleId) => {
    const roles = {
        1: 'Пользователь',
        2: 'Администратор',
        3: 'Модератор'
    };
    return roles[roleId] || `Роль ${roleId}`;
};

const getRoleBadgeClass = (roleId) => {
    const classes = {
        1: 'role-user',
        2: 'role-admin',
        3: 'role-moderator'
    };
    return classes[roleId] || 'role-unknown';
};

// Функция смены страницы
const changePage = async (page) => {
    if (page < 1 || page > totalPages.value || page === currentPage.value) return;

    loading.value = true;

    try {
        // Загружаем новую страницу
        const response = await fetch(`${paginationUrl.value}?page=${page}&per_page=${perPage.value}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Ошибка загрузки');

        const data = await response.json();

        // Обновляем данные
        users.value = data.users || [];
        currentPage.value = data.current_page || 1;
        totalPages.value = data.total_pages || 1;
        totalItems.value = data.total_items || 0;

        // Обновляем URL в браузере (без перезагрузки)
        const url = new URL(window.location);
        url.searchParams.set('page', page);
        window.history.pushState({}, '', url);

    } catch (error) {
        console.error('Ошибка при загрузке страницы:', error);
        alert('Не удалось загрузить страницу');
    } finally {
        loading.value = false;
    }
};

// Функция поиска с debounce
const handleSearchInput = () => {
    // Очищаем предыдущий таймаут
    clearTimeout(searchTimeout.value);

    // Если поле пустое, сбрасываем поиск
    if (!searchQuery.value.trim()) {
        resetSearch();
        return;
    }

    // Показываем индикатор загрузки
    searchLoading.value = true;

    // Устанавливаем новый таймаут на 1 секунду
    searchTimeout.value = setTimeout(() => {
        performSearch();
    }, 1000);
};

// Основная функция поиска
const performSearch = async () => {
    if (!searchQuery.value.trim()) {
        console.log('❌ Поиск отменен: пустой запрос');
        return;
    }
// Если поле очистили
    if (!searchQuery.value.trim()) {
        console.log('🔄 Очистка поиска');
        resetSearch(); // ← Этот метод должен загружать первую страницу без поиска
        return;
    }
    // Проверяем формирование URL
    const params = new URLSearchParams({
        search: searchQuery.value,
        page: 1,
        per_page: perPage.value
    });

    const url = `${paginationSearch.value}?${params.toString()}`;
    console.log('🔗 Сформированный URL:', url);

    searchLoading.value = true;
    loading.value = true;

    try {
        // Формируем URL для отладки
        const url = `${paginationSearch.value}?search=${encodeURIComponent(searchQuery.value)}&page=1&per_page=${perPage.value}`;

        console.log('🚀 Отправляю запрос поиска:', {
            url: url,
            searchQuery: searchQuery.value,
            paginationUrl: paginationSearch.value
        });

        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        console.log('📥 Ответ от сервера:', {
            status: response.status,
            ok: response.ok,
            url: response.url
        });

        if (!response.ok) throw new Error('Ошибка поиска');

        const data = await response.json();

        console.log('📊 Данные от сервера:', {
            usersCount: data.users?.length || 0,
            searchQuery: data.search_query,
            currentPage: data.current_page,
            totalItems: data.total_items
        });

        // Обновляем данные
        users.value = data.users || [];
        currentPage.value = data.current_page || 1;
        totalPages.value = data.total_pages || 1;
        totalItems.value = data.total_items || 0;

    } catch (error) {
        console.error('❌ Ошибка при поиске:', error);
    } finally {
        searchLoading.value = false;
        loading.value = false;
    }
};
const resetSearch = async () => {
    console.log('🔄 Сброс поиска, загружаю первую страницу');

    searchQuery.value = ''; // Очищаем поисковый запрос
    searchLoading.value = true;
    loading.value = true;

    try {
        // Загружаем первую страницу БЕЗ параметра search
        const url = `${paginationSearch.value}?page=1&per_page=${perPage.value}`;

        console.log('📥 Загружаю без поиска:', url);

        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Ошибка загрузки');

        const data = await response.json();

        // Обновляем данные
        users.value = data.users || [];
        currentPage.value = data.current_page || 1;
        totalPages.value = data.total_pages || 1;
        totalItems.value = data.total_items || 0;

        console.log('✅ Поиск сброшен, загружено:', users.value.length, 'пользователей');

    } catch (error) {
        console.error('❌ Ошибка при сбросе поиска:', error);
    } finally {
        searchLoading.value = false;
        loading.value = false;
    }
};

// Методы для действий
const editUser = (user) => {
    console.log('Редактировать пользователя:', user);
    // Здесь будет логика редактирования
};

const deleteUser = (user) => {
    if (confirm(`Удалить пользователя ${user.fio || user.email}?`)) {
        console.log('Удалить пользователя:', user);
        // Здесь будет логика удаления
    }
};

// Обработка кнопок браузера "назад/вперед"
window.addEventListener('popstate', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const page = parseInt(urlParams.get('page') || '1');

    if (page !== currentPage.value) {
        changePage(page);
    }
});
</script>

<style scoped>
/* Стили для статусов и ролей */
.status-indicator {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
}

.status-indicator.active {
    background-color: #10b981;
}

.status-indicator.inactive {
    background-color: #ef4444;
}

.role-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.role-user {
    background-color: #e0f2fe;
    color: #0369a1;
}

.role-admin {
    background-color: #fef3c7;
    color: #92400e;
}

.role-moderator {
    background-color: #dcfce7;
    color: #166534;
}

.role-unknown {
    background-color: #f3f4f6;
    color: #6b7280;
}

/* Стиль для неактивных пользователей */
.inactive-user {
    opacity: 0.7;
}

/* Пагинация */
.list-footer {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #e5e7eb;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
    margin-bottom: 10px;
}

.pagination-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 8px;
    border: 1px solid #d1d5db;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.pagination-btn:hover:not(.active) {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.pagination-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    font-weight: 600;
}

.pagination-info {
    text-align: center;
    color: #6b7280;
    font-size: 14px;
}

.pagination-info strong {
    color: #374151;
}

.divider {
    margin: 0 10px;
    color: #d1d5db;
}

/* Стили для загрузки */
.loading-state {
    text-align: center;
    padding: 40px;
    color: #6b7280;
}

.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #e5e7eb;
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.no-results {
    text-align: center;
    padding: 40px;
    color: #9ca3af;
    font-style: italic;
}
</style>
