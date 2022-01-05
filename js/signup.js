// All password indicators

const validateChars = document.querySelector(".validated-chars");
const validateMajMin = document.querySelector(".validated-majmin");
const validateFigure = document.querySelector(".validated-figure");
const validateSpecialChars = document.querySelector(".validated-specialchar");
const validatedPassword = document.querySelector(".validated-password");

const psw = document.querySelector("#password");
const confirmPsw = document.querySelector("#confirm-password");

const specialchars = ['~', ':', "'", '+', '[', '\\', '@', '^', '{', '%', '(', '-', '"', '*', '|', ',', '&', '<', '`', '}', '.', '_', '=', ']', '!', '>', ';', '?', '#', '$', ')', '/'];

psw.addEventListener("input", () => {

    if (psw.value.length >= 8) {
        validateChars.classList.add("validated");
    } else {
        validateChars.classList.remove("validated");
    }

    if (Array.from(psw.value).some(char => specialchars.includes(char))) {
        validateSpecialChars.classList.add("validated");
    } else {
        validateSpecialChars.classList.remove("validated");
    }

    if (psw.value.search (/[0-9]/) >= 0) {
        validateFigure.classList.add("validated");
    } else {
        validateFigure.classList.remove("validated");
    }

    if (psw.value.search(/[a-z]/) >= 0 && psw.value.search(/[A-Z]/)  >= 0) {
        validateMajMin.classList.add("validated");
    } else {
        validateMajMin.classList.remove("validated");
    }

    if ((psw.value != "" && confirmPsw.value != "") && psw.value === confirmPsw.value) {
        validatedPassword.classList.add("validated");
    } else {
        validatedPassword.classList.remove("validated");
    }

})

confirmPsw.addEventListener("input", () => {
    if ((psw.value != "" && confirmPsw.value != "") && psw.value === confirmPsw.value) {
        validatedPassword.classList.add("validated");
    } else {
        validatedPassword.classList.remove("validated");
    }
})

// Checking everything before submiting
const form = document.querySelector("#form_signup");
console.log(form);

form.addEventListener("submit", (e) => {
    if (    
        validateChars.classList.contains("validated") && validateMajMin.classList.contains("validated") && validateFigure.classList.contains("validated") && validateSpecialChars.classList.contains("validated") && validatedPassword.classList.contains("validated")) {
    } else {
        e.preventDefault();
    }
})