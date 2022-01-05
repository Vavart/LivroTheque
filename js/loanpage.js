const allLoanedBooks = Array.from(document.querySelectorAll(".table-loanpage .trb"));

allLoanedBooks.forEach(book => {
    book.addEventListener("click", () => {
        const book_isbn = book.getAttribute("data-book");
        console.log(window.location);
        window.location.href = `book.php?id=${book_isbn}`
    })
});

// Switching sides
const loanTitle = document.querySelector(".cont-titres h2:first-child");
const historyTitle = document.querySelector(".cont-titres h2:last-child");
const loanPageSection = document.querySelector(".loanpage-section");
const historyLoansSection = document.querySelector(".history-section");

loanTitle.addEventListener("click", () => {
    loanTitle.classList.add("cat-active");
    historyTitle.classList.remove("cat-active");
    loanPageSection.style.display = "block";
    historyLoansSection.style.display = "none";
})
historyTitle.addEventListener("click", () => {
    loanTitle.classList.remove("cat-active");
    historyTitle.classList.add("cat-active");
    loanPageSection.style.display = "none";
    historyLoansSection.style.display = "block";
})