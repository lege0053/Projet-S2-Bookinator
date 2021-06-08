
function addFilter() {
    var types = { 'year' : "Année", 'author' : "Auteur", 'editeur' : "Editeur", 'genre' : "Genre", 'language' : "Langue"};
    var filterList = document.getElementById("filter-list");
    filterType = filterList.value;
    var filterId = document.getElementById("filters").childElementCount + 1;

    var filter = '<div id="' + filterId + '" class="d-flex flex-row"> <div class="border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center">' + types[filterType]  + ' </div> <input type="text" name="' + filterType +'[]"class="border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline"> <div class="font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center" onClick="removeFilter(\'' + filterId + '\')"> <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="5" fill="#E1534A"/><path d="M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z" fill="#2F2F2F"/></svg></div> </div>';
    document.getElementById("filters").innerHTML += filter;
}

function removeFilter(idFilter) {
    var filter = document.getElementById(idFilter);
    document.getElementById("filters").removeChild(filter);
}