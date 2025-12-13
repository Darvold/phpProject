import './bootstrap';
import { createApp } from 'vue';
import UpdateUserData from './components/updateUserData.vue';
import userList from "./components/userList.vue";
import CreateUser from "./components/createUser.vue";


// Список пользователей
const app = createApp(userList);
app.mount('#userList');

// Обновить данные пользователя
const app1 = createApp(UpdateUserData);
app1.mount('#updateUserData');

// Создать пользователя
const app2 = createApp(CreateUser);
app2.mount('#createUser');
