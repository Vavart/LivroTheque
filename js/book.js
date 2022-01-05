const bookAvailabilityParagraph = document.querySelector(".footer .availability span");
const bookAvailability = bookAvailabilityParagraph.getAttribute("data-stock");

if (bookAvailability == "0") {
    bookAvailabilityParagraph.classList.add("nostock");
    bookAvailabilityParagraph.classList.remove("yesstock");
    bookAvailabilityParagraph.innerText = "❌ Indisponible - "
}


// Modal
const loanpageModal = document.querySelector(".loanpage-modal");
const loanpageOverlay = document.querySelector(".loan-overlay");
const btnOpenLoanModal = document.querySelector(".book-reservation");
const btnCloseModal = document.querySelector(".loanpage-modal .close-modal");

btnOpenLoanModal.addEventListener("click", () => {
    loanpageModal.style.display = "block";
    loanpageOverlay.style.display = "block";
})

btnCloseModal.addEventListener("click", () => {
    loanpageModal.style.display = "none";
    loanpageOverlay.style.display = "none";
})