// Focus input field function
const inputs = document.querySelectorAll(".input");

function addcl() {
    let parent = this.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode;
    if (this.value == "") {
        parent.classList.remove("focus");
    }
}

inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});
// Focus input field function


// Show password function
document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelectorAll(".toggle-password");

    togglePassword.forEach(function (icon) {
        icon.addEventListener("click", function () {
            const input = this.parentNode.querySelector("input");
            const type = input.getAttribute("type");

            if (type === "password") {
                input.setAttribute("type", "text");
            } else {
                input.setAttribute("type", "password");
            }

            this.querySelector("i").classList.toggle("fa-eye");
            this.querySelector("i").classList.toggle("fa-eye-slash");
        });
    });
});
// Show password function

