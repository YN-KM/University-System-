const signUpBtn = document.getElementById('sign-up-btn');
const signInBtn = document.getElementById('sign-in-btn');
const loginForm = document.getElementById("login");
const registrForm = document.getElementById("registr");

signUpBtn.addEventListener("click", () => {
    loginForm.classList.add('login');
    registrForm.classList.remove('registr')
})
signInBtn.addEventListener("click", () => {
    registrForm.classList.add('registr');
    loginForm.classList.remove('login');
});

let createInpts = document.querySelectorAll('.form  input');
createInpts.forEach(input => {
    input.addEventListener("focus", e => {
      input.parentElement.classList.add("focus");
    });
    input.addEventListener("blur", e => {
        input.parentElement.classList.remove("focus");
      })
});



