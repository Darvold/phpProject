<script setup>

const element = document.getElementById('auth');
const registerUrl = element.getAttribute('register');
// Удаляем атрибут после получения значения
element.removeAttribute('register');

const cards = document.querySelectorAll(".card");

/* View Controller
-----------------------------------------*/
const btns = document.querySelectorAll(".js-btn");
btns.forEach((btn) => {
    btn.addEventListener("click", on_btn_click, true);
    btn.addEventListener("touch", on_btn_click, true);
});

function on_btn_click(e) {
    const nextID = e.currentTarget.getAttribute("data-target");
    const next = document.getElementById(nextID);
    if (!next) return;
    bg_change(nextID);
    view_change(next);
    return false;
}

/* Add class to the body */
function bg_change(next) {
    document.body.className = "";
    document.body.classList.add("is-" + next);
}

/* Add class to a card */
function view_change(next) {
    cards.forEach((card) => {
        card.classList.remove("is-show");
    });
    next.classList.add("is-show");
}

</script>
<template>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="">
                    <h2>Авторизация</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" required>
                        <label for="">Почта</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" required>
                        <label for="">Пароль</label>
                    </div>
                    <button>Log in</button>
                    <div class="register">
                        <p>У вас нет аккаунта? <a :href="registerUrl">Создать</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>


<style scoped>

</style>
