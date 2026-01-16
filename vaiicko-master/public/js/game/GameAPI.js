import {DataService} from "../DataService.js";


class GameAPI extends DataService {

    constructor() {
        super("game");
    }

    async getZanre(zaner) {
        return await this.sendRequest(
            "form",
            "POST",
            200,
            {
                zaner: zaner
            },
            null
        );
    }
    async checkUrl(link) {
        return await this.sendRequest(
            "form",
            "POST",
            200,
            {
                link: link
            },
            null
        );
    }

    async appreciation(value,game){
        return await this.sendRequest(
            "game",
            "POST",
            200,
            {
                value: value,
                game: game
            },
            null
        );
    }
}
export {GameAPI}