// Search-bar
const searchInput = document.querySelector(".search-bar input");
const allBooks = Array.from(document.querySelectorAll(".searched-item"));

searchInput.addEventListener("input", (e) => {

    let search = searchInput.value.toUpperCase();

    for (book of allBooks) {
        if (book.innerText.toUpperCase().indexOf(search) > -1) {
            book.style.display = "flex";
        } else {
            book.style.display = "none";
        }
    }

})

// Récupération de l'url et ajout des checks
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
const allInputs = Array.from(document.querySelectorAll(".criteria input"));
const paramsKeys = Object.keys(params);

for (let i = 0; i < allInputs.length; i++) {
    for (let j = 0; j < paramsKeys.length; j++) {
        if (allInputs[i].id === paramsKeys[j]) {
            allInputs[i].checked = true;
        } 
    }
}

// Affichage conditionnel en fonction des paramètres de l'url
allBooks.forEach(book => {

    // De base
    book.style.display = "none";

    let dataCategory = book.getAttribute('data-category');
    let dataDisponibility = book.getAttribute('data-disponibility');
    let dataDate = book.getAttribute('data-date');

    // Si cela correspond à une catégorie
    if (paramsKeys.includes(dataCategory) || paramsKeys.includes("all")) {
        book.style.display = "flex";

        // Et avec une disponibilité
        if (paramsKeys.includes("dispo-only") && dataDisponibility > 0) {
            book.style.display = "flex";
        } else if (paramsKeys.includes("dispo-only") && dataDisponibility <= 0) {
            book.style.display = "none";
        }
    } else {
        book.style.display = "none";
    }

    // Comparaison avec la date
    if (paramsKeys.includes("new-only") && dataDate != '') {
        book.style.display = "flex";
    } else if (paramsKeys.includes("new-only") && dataDate == '') {
        book.style.display = "none";
    }
})