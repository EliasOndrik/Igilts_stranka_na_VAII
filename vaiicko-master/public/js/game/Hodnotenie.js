import {GameAPI} from "./GameAPI.js";

class Hodnotenie{
    #gameService;
    constructor(game) {
        this.#gameService = game;
        let like = document.getElementById("like");
        if (like === null) {
            return;
        }
        like.onclick = async () => {
            await this.evaluation("like");

        }
        let dislike = document.getElementById("dislike");
        dislike.onclick = async () => {
            await this.evaluation("dislike");
        }
    }
    async evaluation(state){
        let game = document.getElementById("secret-id").value;
        let returnValue = await this.#gameService.appreciation(state, game);
        document.getElementById("hodnotenie").innerText = Math.floor(JSON.parse(returnValue)) + " %";
    }
}
export {Hodnotenie}