import './bootstrap';
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import auth from './App.vue';
import Registr from './components/registr.vue';
import UpdateUserData from './components/updateUserData.vue';
import userList from "./components/userList.vue";
/*import App from './App.vue';
import router from './router';*/

/*createApp(App).use(router).mount('#app');*/


// Список пользователей
const app = createApp(userList);
app.mount('#userList');

// Обновить данные пользователя
const app1 = createApp(UpdateUserData);
app1.mount('#updateUserData');
