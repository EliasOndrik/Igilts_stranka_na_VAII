import {GameAPI} from "./GameAPI.js";

class GameChanges {
    #gameService;
    constructor(gameApi) {
        this.#gameService = gameApi;

        let input = document.getElementById("zaner-input");
        if (input === null){
            return;
        }
        input.onkeyup = async () => {
            let zanerList = await this.#gameService.getZanre(input.value);
            let zanre = JSON.parse(zanerList);
            if (zanre === null){
                return;
            }
            let dropdown = document.getElementById("dropdown-options");
            dropdown.innerHTML = '';
            for (let i = 0; i < zanre.length; i++){
                dropdown.innerHTML += "<li class='dropdown-item' onclick='document.gameChanges.addZaner("+'"'+zanre[i].Zaner+'"'+','+zanre[i].ID_zaner+")'>"+zanre[i].Zaner+"</li>";
            }

        }
        let link = document.getElementById("link");
        link.onkeyup = async () => {
            let url = await this.#gameService.checkUrl(link.value);
            link.className = "form-control is-valid";
            document.getElementById("submit-game").disabled = false;
            if(JSON.parse(url) === false){
                link.className = "form-control is-invalid";
                document.getElementById("submit-game").disabled = true;
            }
        }

    }
    addZaner(zaner,id) {
        let container = document.getElementById("genre-container");
        container.innerHTML += "<span class='btn bg-secondary m-1' onclick='document.gameChanges.removeZaner(this)'>" + zaner + "<input type='hidden' name='genres[]' value='"+id+"'/></span>";
    }
    removeZaner(element) {
        element.remove();
    }


}

export {GameChanges}