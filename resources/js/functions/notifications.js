// Глобальная переменная для хранения таймера
import {ref} from "vue";

let notificationTimeout = null;
export const form = ref({
    id: null,
    fio: '',
    email: '',
    phone: '',
    role: '1',
});
export const showNotification = (type, message, errors = null) => {
    const notificationDiv = document.querySelector('.form-msg');

    if (!notificationDiv) return;

    // Очищаем предыдущий таймер
    if (notificationTimeout) {
        clearTimeout(notificationTimeout);
        notificationTimeout = null;
    }

    let notificationMessage = message;

    if (errors && typeof errors === 'object') {
        notificationMessage += '<br>';
        const errorMessages = [];

        for (const [field, messages] of Object.entries(errors)) {
            if (Array.isArray(messages)) {
                errorMessages.push(...messages);
            }
        }

        if (errorMessages.length > 0) {
            notificationMessage += errorMessages.join('<br>');
        }
    }

    notificationDiv.innerHTML = `
        <div class="notification-content">
            <div class="notification ${type}">${notificationMessage}</div>
        </div>
    `;

    // Устанавливаем новый таймер
    notificationTimeout = setTimeout(() => {
        notificationDiv.innerHTML = '';
        notificationTimeout = null;
    }, 5000);
};
export const cancelUser = async () =>{

    form.value = {
        id: '',
        fio: '',
        email: '',
        phone: '',
        role: '1',
    };
}
export function resetForms() {
    // Сбрасываем форму создания
    const createForm = document.querySelector('#createUser form');
    if (createForm) {
        createForm.reset();
    }

    // Сбрасываем форму обновления
    const updateForm = document.querySelector('#updateUserData form');
    if (updateForm) {
        updateForm.reset();
    }
    form.value = {
        id: '',
        fio: '',
        email: '',
        phone: '',
        role: '1',
    };
}
const formModes = {
    create: { update: false, create: true, message: 'Режим создания нового пользователя' },
    update: { update: true, create: false, message: 'Режим редактирования пользователя' }
};

// Единая функция управления формами
let currentView = 'create'; // 'create' или 'update'
export const setFormMode = (mode) => {
    currentView = mode;
    const config = formModes[mode];

    const updateForm = document.querySelector('#updateUserData');
    const createForm = document.querySelector('#createUser');

    updateForm?.setAttribute('data-status', config.update.toString());
    createForm?.setAttribute('data-status', config.create.toString());

    if (config.message) {
        showNotification('info', config.message);
    }
};
