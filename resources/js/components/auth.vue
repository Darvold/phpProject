
<template>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" required>
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                        <label>
                            <a href="#">Forgot password?</a>
                        </label>
                    </div>
                    <button>Log in</button>
                    <div class="register">
                        <p>Don't have a account ? <a href="{{route('regist.index')}}">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<script setup>
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

<style scoped>

</style>
