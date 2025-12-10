export const phoneMaskDirective = {
    mounted(el, binding) {
        if (window.IMask) {
            const mask = IMask(el, {
                mask: '+{7}(000)000-00-00',
                lazy: false
            });

            // Сохраняем объект маски в элементе
            el._mask = mask;

            // При изменении в маске обновляем v-model
            mask.on('accept', () => {
                const event = new Event('input', { bubbles: true });
                el.value = mask.unmaskedValue; // Только цифры
                el.dispatchEvent(event);
            });
        }
    },

    updated(el, binding) {
        if (el._mask && binding.value !== el._mask.unmaskedValue) {
            el._mask.value = binding.value || '';
        }
    },

    unmounted(el) {
        if (el._mask) {
            el._mask.destroy();
        }
    }
};
