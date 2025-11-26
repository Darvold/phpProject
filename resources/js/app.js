import './bootstrap';
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import auth from './components/auth.vue';

// Создай первое приложение для ExampleComponent
const app1 = createApp(ExampleComponent);
app1.mount('#example-component');

// Создай второе приложение для auth
const app2 = createApp(auth);
app2.mount('#auth');
