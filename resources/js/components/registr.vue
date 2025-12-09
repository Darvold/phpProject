
<template>
    <div>
        <h2>Список пользователей</h2>
        <ul>
            <li v-for="user in users" :key="user.id">
                {{ user.fio }} - {{ user.email }}
            </li>
        </ul>
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';

const users = ref([]);

onMounted(() => {
    // Получаем данные из data-атрибута
    const container = document.getElementById('registr');
    const usersData = container.dataset.users;

    if (usersData) {
        users.value = JSON.parse(usersData);
        console.log('Полученные пользователи:', users.value);
        console.log('Количество:', users.value.length);
    }
});
</script>
