import './bootstrap';
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import auth from './App.vue';
import Registr from './components/registr.vue';
import UsersList from './components/UsersList.vue';
import userList from "./components/userList.vue";
/*import App from './App.vue';
import router from './router';*/

/*createApp(App).use(router).mount('#app');*/

/*const app = createApp({userList})
app.component('userList', userList)
app.mount('#app');*/

// Определяем основной компонент для страницы CRUD
/*
const crudUsers = {
    data() {
        return {
            // Данные будут переданы из Blade
        }
    },

    methods: {
        onUserSelected(user) {
            console.log('Пользователь выбран:', user);
            // Можно обновить форму слева
            this.$emit('user-selected', user);
        },

        onAddUser() {
            console.log('Добавить пользователя');
            // Логика открытия формы добавления
        },

        onEditUser(user) {
            console.log('Редактировать пользователя:', user);
            // Логика редактирования
        },

        onDeleteUser(user) {
            console.log('Удалить пользователя:', user);
            if (confirm(`Удалить пользователя ${user.fio}?`)) {
                this.deleteUserRequest(user.id);
            }
        },

        deleteUserRequest(userId) {
            fetch(`/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        alert('Пользователь удален');
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
};
*/

/*// Создаём приложение
const app = createApp({});

// Регистрируем компонент ГЛОБАЛЬНО
app.component('registr', Registr);

// Монтируем на элемент с id="app"
app.mount('#app');*/
// Создаём приложение
const app = createApp(userList);
app.mount('#userList');
