import {SearchAPI} from "./SearchAPI.js";

class SearchGames {
    #searchService;
    #numberOfGenres = 0;
    #gameSearch = "";
    constructor(search) {
        this.#searchService = search;
        if (document.getElementById("search-games") === null){
            return;
        }
        setInterval(
            async () => {
                let genres = document.getElementById("genre-container");
                let input = document.getElementById("search-box");
                if (this.#numberOfGenres !== genres.children.length || this.#gameSearch.localeCompare(input.value) !== 0){
                    this.#numberOfGenres = genres.children.length;
                    this.#gameSearch = input.value;
                    let filters = [];
                    for (let i = 0; i < this.#numberOfGenres; i++) {
                        filters.push(genres.children[i].children[0].value);
                    }
                    let games = await this.#searchService.filterGames(filters,this.#gameSearch);
                    games = JSON.parse(games);
                    let selection = document.getElementById("game-selection");
                    selection.innerHTML = "";
                    for (let i = 0; i < games.length; i++) {
                        selection.innerHTML += '<div class="col-lg-3 mb-4">' +
                            '<div class="card">' +
                                '<a href="?c=game&a=game&id=' + games[i].ID_hra +']) ?>" class="text-decoration-none">' +
                                    '<img src="/uploads/' + games[i].Obrazok + '" class="card-img-top" alt="Obrázok hry">'+
                                        '<div class="card-body ">'+
                                            '<h5 class="card-title">'+ games[i].Nazov +'</h5>'+
                                        '</div>'+
                                '</a>'+
                            '</div>'+
                        '</div>'
                    }
                }
            },
            1000
        )
    }
}

export {SearchGames}