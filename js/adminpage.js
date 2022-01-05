function transformChars(text) {
    return text
     .replace(/&amp;/g, "&")
     .replace(/&lt;/g, "<")
     .replace(/&gt;/g, ">")
     .replace(/&quot;/g, "\"")
     .replace(/&#039;/g, "'");
}


// Switching sides
const stockTitle = document.querySelector(".cont-titres h2:first-child");
const loanTitle = document.querySelector(".cont-titres h2:last-child");
const adminSection = document.querySelector(".admin");
const loanSection = document.querySelector(".loans");

stockTitle.addEventListener("click", () => {
    stockTitle.classList.add("cat-active");
    loanTitle.classList.remove("cat-active");
    adminSection.style.display = "block";
    loanSection.style.display = "none";
})
loanTitle.addEventListener("click", () => {
    stockTitle.classList.remove("cat-active");
    loanTitle.classList.add("cat-active");
    adminSection.style.display = "none";
    loanSection.style.display = "block";
})


// Modale emprunts

const modale = document.querySelector(".user-info-modal");
const overlay = document.querySelector(".admin-overlay");
const btnCloseModal = document.querySelector(".close-modal");
const allLoanedBooks = Array.from(document.querySelectorAll(".loans .table-loanpage .trb"));
const inputLoanName = document.querySelector(".user-info-modal #name");
const inputLoanSurname = document.querySelector(".user-info-modal #surname");
const inputLoanEmail = document.querySelector(".user-info-modal #email");
const inputLoanNumber = document.querySelector(".user-info-modal #adherentNumber");
const inputLoanIsbn = document.querySelector(".user-info-modal #book_isbn");
const inputLoanBookTitle = document.querySelector(".user-info-modal #book_title");
const inputLoanBookAuthor = document.querySelector(".user-info-modal #book_author");
const warningBtn = document.querySelector(".user-info-modal #warningBtn");

warningBtn.addEventListener("click", () => {
    alert("Rappel envoyé !");
    modale.style.display = "none";
    overlay.style.display = "none";
})


allLoanedBooks.forEach(book => {
    book.addEventListener("click", (e) => {

        let member = book.getAttribute("data-book");
        member = JSON.parse(member);

        inputLoanName.value = transformChars(member.member_name);
        inputLoanSurname.value = transformChars(member.surname);
        inputLoanEmail.value = transformChars(member.email);
        inputLoanNumber.value = transformChars(member.id);
        inputLoanIsbn.value = transformChars(member.ISBN);
        inputLoanBookTitle.value = transformChars(member.book_title);
        inputLoanBookAuthor.value = transformChars(member.book_author);


        modale.style.top = e.pageY-50 + "px" ;
        modale.style.display = "block";

        // Compromis...
        overlay.style.height = window.innerHeight + e.screenY + "px";
        overlay.style.display = "block";
    })
});

btnCloseModal.addEventListener("click", () => {
    modale.style.display = "none";
    overlay.style.display = "none";
})


// Modale stocks
// Commande

const commandModale = document.querySelector(".command-more-book-modal");
const inputCommandModalBookIsbn = document.querySelector(".command-more-book-modal #book_isbn");
const stockOverlay = document.querySelector(".admin-stock-overlay");
const btnCloseCommandkModal = document.querySelector(".command-more-book-modal .close-stock-modal");
const openCommandModale = document.querySelectorAll(".cont-btn-actions .commandBook");


openCommandModale.forEach(openBtnModale =>
    openBtnModale.addEventListener("click", () => {
        const book_isbn = openBtnModale.getAttribute("data-book");
        commandModale.style.display = "block";
        inputCommandModalBookIsbn.value = book_isbn;
        stockOverlay.style.display = "block";
    })
)

btnCloseCommandkModal.addEventListener("click", () => {
    commandModale.style.display = "none";
    stockOverlay.style.display = "none";
    
})


// Delete book
const deleteModale = document.querySelector(".delete-modal");
const btnCloseDeleteModal = document.querySelector(".delete-modal .close-stock-modal");
const inputDeleteModalBookIsbn = document.querySelector(".delete-modal #book_isbn");
const openDeleteModale = document.querySelectorAll(".cont-btn-actions .deleteBook");

openDeleteModale.forEach(openBtnModale => {
    openBtnModale.addEventListener("click", () => {
        const book_isbn = openBtnModale.getAttribute("data-book");
        inputDeleteModalBookIsbn.value = book_isbn;
        deleteModale.style.display = "block";
        stockOverlay.style.display = "block";
    })
})

btnCloseDeleteModal.addEventListener("click", () => {
    deleteModale.style.display = "none";
    stockOverlay.style.display = "none";
    
})

// Transfer the stock
const transferModale = document.querySelector(".transfer-modal");
const btnCloseTransferModal = document.querySelector(".transfer-modal .close-stock-modal");
const inputTransferModalBookIsbn = document.querySelector(".transfer-modal #book_isbn");
const openTransferModale = document.querySelectorAll(".cont-btn-actions .validateBook");


openTransferModale.forEach(openBtnModale => {
    openBtnModale.addEventListener("click", () => {
        const book_isbn = openBtnModale.getAttribute("data-book");
        inputTransferModalBookIsbn.value = book_isbn;
        transferModale.style.display = "block";
        stockOverlay.style.display = "block";
    })
})

btnCloseTransferModal.addEventListener("click", () => {
    transferModale.style.display = "none";
    stockOverlay.style.display = "none";
    
})

// Add new book to db
const addModale = document.querySelector(".add-modal");
const btnCloseAddModal = document.querySelector(".add-modal .close-stock-modal");
const openAddModale = document.querySelector(".addbook .add-new-book");

openAddModale.addEventListener("click", (e) => {
    stockOverlay.style.height = 200 + "%";
    addModale.style.display = "block";
    stockOverlay.style.display = "block";
})

btnCloseAddModal.addEventListener("click", () => {
    stockOverlay.style.height = 130 + "%";
    addModale.style.display = "none";
    stockOverlay.style.display = "none";
    
})

// Modify book
const modifyModale = document.querySelector(".modify-modal");
const btnCloseModifyModal = document.querySelector(".modify-modal .close-stock-modal");
const inputModifyModalBookIsbn = document.querySelector(".modify-modal #book_isbn");
const openModifyModale = Array.from(document.querySelectorAll(".cont-btn-actions .modifyBook"));

// All inputs of the modify item
const inputModifyISBN = document.querySelector(".modify-modal #isbn");
const inputModifyTitle = document.querySelector(".modify-modal #bookTitle");
const inputModifyAuthor = document.querySelector(".modify-modal #bookAuthor");
const inputModifyEditor = document.querySelector(".modify-modal #bookEditor");
const inputModifyReleaseDate = document.querySelector(".modify-modal #bookDate");
const inputModifyCover = document.querySelector(".modify-modal #bookCover");
const currentBookCover = document.querySelector(".modify-modal .current-book-cover");
const inputKeepPic = document.querySelector(".modify-modal #keepPic");
const inputModifyCategorySelfHelp = document.querySelector(".modify-modal #self-help");
const inputModifyCategoryFinance = document.querySelector(".modify-modal #finance");
const inputModifyCategoryEntrepreneurship = document.querySelector(".modify-modal #entrepreneurship");
const inputModifyCategoryPolitics = document.querySelector(".modify-modal #politics");
const inputModifyCategory = Array(inputModifyCategorySelfHelp, inputModifyCategoryFinance, inputModifyCategoryEntrepreneurship, inputModifyCategoryPolitics);
const inputModifyAbstract = document.querySelector(".modify-modal #bookAbstract");
let modalIndex;


openModifyModale.forEach(openBtnModale => {

    openBtnModale.addEventListener("click", () => {

        let book = openBtnModale.getAttribute("data-book");
        book = JSON.parse(book);

        modalIndex = openModifyModale.indexOf(openBtnModale);
        // Car le chemin d'accès contient 25 caractères
        let filename = book.pic.substring(25);

        inputModifyISBN.value = transformChars(book.ISBN);
        inputModifyTitle.value = transformChars(book.title);
        inputModifyAuthor.value = transformChars(book.author);
        inputModifyEditor.value = transformChars(book.editor);
        inputModifyReleaseDate.value = transformChars(book.release_date);
        currentBookCover.innerText = filename;
        let category = book.subject;
        inputModifyCategory.forEach(checkbox => {
            if (checkbox.getAttribute("id") === category) {
                checkbox.checked = true;
            }
        })
        inputModifyAbstract.value = transformChars(book.abstract);

        stockOverlay.style.height = 200 + "%";
        modifyModale.style.display = "block";
        stockOverlay.style.display = "block";

    })
})

inputKeepPic.value = true;
inputModifyCover.addEventListener("input", () => {
    if(inputModifyCover.files) {
        inputKeepPic.value = false;
        let filename = inputModifyCover.files[0].name;
        currentBookCover.innerText = filename;
    }
})

btnCloseModifyModal.addEventListener("click", () => {
    stockOverlay.style.height = 150 + "%";
    modifyModale.style.display = "none";
    stockOverlay.style.display = "none";

    inputModifyCategory.forEach(checkbox => {
        checkbox.checked = false;
    })
})



// Search-bar - Stocks
const searchStockInput = document.querySelectorAll(".cont-search-addbook .search-bar input")[0];
const allBooks = document.querySelectorAll(".table-cont-btn-actions .trb.stock");

// Search-bar - Loans
const searchLoanInput = document.querySelectorAll(".cont-search-addbook .search-bar input")[1];
const allLoans = document.querySelectorAll(".table-cont-btn-actions .trb.loans");

searchStockInput.addEventListener("input", () => {
    filtrer(allBooks, searchStockInput);
})

searchLoanInput.addEventListener("input", () => {
    filtrer(allLoans, searchLoanInput);
})

function filtrer(array, input) {
    let search = input.value.toUpperCase();
    for (el of array) {
        el.innerText.toUpperCase().indexOf(search) > -1 ? el.style.display = window.innerWidth > 620 ? 'flex' : 'block' : el.style.display = "none";
    }
}

// cursor disabled
// attribut title
// focus adminpage
// connexion admin