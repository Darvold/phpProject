<!-- ExampleComponent.vue -->
<template>
    <div>
        <h1>Привет, мир!</h1>
        <button @click="increment">Нажми меня</button>
        <p>Счётчик: {{ count }}</p>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';

const count = ref(0);

function increment() {
    count.value++;
}
</script>
