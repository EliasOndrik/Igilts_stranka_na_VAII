import {DataService} from "../DataService.js";

/**
 * Class containing all calls to AuthApiController
 */
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

}
export {GameAPI}