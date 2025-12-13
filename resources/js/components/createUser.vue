<template>
    <div class="form-card">
        <div class="form-header">
            <h3 class="form-title">
                <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                </svg>
                Создать пользователя
            </h3>
            <div class="form-actions">
                <button class="btn-save create" @click="createUser">Создать</button>
                <button class="btn-cancel" @click="cancelUser">Отменить</button>
            </div>
        </div>

        <form class="user-form" @submit.prevent="createUser">
            <div class="form-group">
                <label class="form-label">
                    <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                         height="12" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                    </svg>
                    ФИО
                </label>
                <input type="text" v-model="form.fio" class="form-input" placeholder=""
                       value="">
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
                <input type="email" v-model="form.email" class="form-input" placeholder=""
                       value="">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="12"
                         height="12" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                    </svg>
                    Телефон
                </label>
                <input type="tel" data-mask="phone" maxlength="16" v-model="form.phone" class="form-input" >
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
                <input type="password" class="form-input" v-model="form.password" placeholder="Новый пароль">
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
                <select
                    v-model="form.role"
                    class="form-select"
                >
                    <option
                        v-for="role in roleOptions"
                        :key="role.value"
                        :value="role.value"
                        :selected="form.role === role.value"
                    >
                        {{ role.label }}
                    </option>
                </select>
            </div>
        </form>
    </div>
</template>
<script setup>
import {ref, watch, onMounted, onUnmounted} from 'vue';
import {showNotification, cancelUser } from '../functions/notifications.js';
import { eventBus, SEARCH_EVENTS } from '../utils/eventBus.js';

const roleOptions = [
    { value: '1', label: 'Пользователь' },
    { value: '2', label: 'Администратор' },
    { value: '3', label: 'Модератор' }
];
const form = ref({
    id: null,
    fio: '',
    email: '',
    phone: '',
    password: '',
    role: '1',
});
const paginationUrl = ref('');
// Функция преобразования цифры в маску
// 1. Слушаем событие из другого компонента
onMounted(() => {
    const container = document.getElementById('createUser');
    if (container) {
        paginationUrl.value = container.dataset.paginationUrl;
    }
    /*eventBus.on(SEARCH_EVENTS.USERS_UPDATED, (data) => {
        console.log('Пользователи обновлены:', data.users.length);
        // Делаем что-то с обновленными данными
    });*/
});
onUnmounted(() => {
   /* eventBus.off(SEARCH_EVENTS.USERS_UPDATED);*/
});

// Сохранение изменений
const createUser = async () => {
    try {
        // Находим кнопку
        const createButton = document.querySelector('.btn-save.create');

        if (!createButton) {
            console.error('Кнопка создания не найдена');
            return;
        }

        // Блокируем кнопку сразу
    createButton.disabled = true;
    createButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Создание...';

        if (document.querySelector('#createUser').getAttribute('data-status') !== 'true') {
            showNotification('info', 'Выберите пользователя для создания');
            // Разблокируем кнопку если форма не активна
            createButton.disabled = false;
            createButton.innerHTML = 'Создать';
            return;
        }

        // 1. Копируем form.value, чтобы не мутировать исходный объект
        const dataToSend = { ...form.value };

        // 2. Очищаем телефон (убираем всё кроме цифр)
        if (dataToSend.phone) {
            dataToSend.phone = dataToSend.phone.replace(/\D/g, '');
            console.log('Телефон очищен:', form.value.phone, '→', dataToSend.phone);
        }

        console.log('Создание пользователя:', dataToSend);

        // Отправка на сервер
        const response = await fetch(paginationUrl.value, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(dataToSend)
        });

        const result = await response.json();

        // Обработка ответа
        if (result.success) {
            // Успех
            console.log('Успешно:', result.message);

            // 1. Показываем уведомление
            showNotification('success', result.message);
            // 2. Оповещаем таблицу об обновлении через eventBus
            eventBus.emit(SEARCH_EVENTS.RESET_SEARCH);
            // 2. Оповещаем таблицу об обновлении
            const event = new CustomEvent('user-updated', { detail: result.user });
            window.dispatchEvent(event);

            // 3. Задержка на 3 секунды
            await new Promise(resolve => setTimeout(resolve, 3000));


            // 5. Разблокируем кнопку через 3 секунды
            createButton.disabled = false;
            createButton.innerHTML = 'Создать';

        } else {
            // Ошибка
            console.error('Ошибка от сервера:', result);

            // Разблокируем кнопку при ошибке
            createButton.disabled = false;
            createButton.innerHTML = 'Создать';

            if (result.errors) {
                // Ошибки валидации
                showNotification('error', result.message, result.errors);
            } else {
                // Общая ошибка
                showNotification('error', result.message || 'Ошибка сохранения');
            }
        }

    } catch (error) {
        console.error('Ошибка сети:', error);
        showNotification('error', 'Ошибка соединения с сервером');

        // Разблокируем кнопку при ошибке сети
        const createButton = document.querySelector('.btn-save.create');
        if (createButton) {
            createButton.disabled = false;
            createButton.innerHTML = 'Создать';
        }
    }
};

</script>

<style scoped>

</style>
