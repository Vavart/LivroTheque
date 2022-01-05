// Modale
const btnOpenModal = document.querySelector(".danger-zone .open-danger-modal");
const btnCloseModal = document.querySelector(".danger-modal .close-danger-modal");
const dangerModal = document.querySelector(".danger-modal");
const dangerOverlay = document.querySelector(".danger-overlay");

btnOpenModal.addEventListener("click", () => {
    dangerModal.style.display = "block";
    dangerOverlay.style.display = "block";
})

btnCloseModal.addEventListener("click", () => {
    dangerModal.style.display = "none";
    dangerOverlay.style.display = "none";
})
