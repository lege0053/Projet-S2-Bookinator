


function addGenre() {
    var genreId = 'genre-' + document.getElementById("genres-list").childElementCount;
    var genre = '                <div id="' + genreId + '" class="d-flex" style="margin-top: 5px;">' +
        '                            <input type="text" name="genre[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5 margin-right" placeholder="Genre" required>' +
        '                            <div onclick="removeGenre(\''+ genreId +'\')">' +
        '                                <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="5" fill="#E1534A"/><path d="M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z" fill="#2F2F2F"/></svg>' +
        '                            </div>' +
        '                        </div>';
    document.getElementById("genres-list").innerHTML += genre;
}

function removeGenre(idGenre) {
    var genre = document.getElementById(idGenre);
    document.getElementById("genres-list").removeChild(genre);
}


function addAuthor() {
    var authorId = 'author-' + document.getElementById("authors-list").childElementCount;
    var author = '             <div id="' + authorId + '" class="p-0 d-flex flex-fill align-items-center align-items-md-end flex-column flex-md-row w-100 align-items-end" style="margin-top: 5px;">' +
        '                        <div class="d-flex flex-fill flex-column w-100 margin-right">' +
        '                            <input type="text" id="prenomAuteur" name="prenomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Prénom Auteur" required>' +
        '                        </div>' +
        '                        <div class="d-flex flex-fill flex-column w-100 margin-right">' +
        '                            <input type="text" id="nomAuteur" name="nomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Nom Auteur" required>' +
        '                        </div>' +
        '                        <div class="" onclick="removeAuthor(\''+ authorId +'\')">' +
        '                           <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="5" fill="#E1534A"/><path d="M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z" fill="#2F2F2F"/></svg>' +
        '                        </div>' +
        '                    </div>';
    document.getElementById("authors-list").innerHTML += author;
}

function removeAuthor(idAuthor) {
    var author = document.getElementById(idAuthor);
    document.getElementById("authors-list").removeChild(author);
}