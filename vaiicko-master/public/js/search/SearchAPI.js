import {DataService} from "../DataService.js";


class SearchAPI extends DataService {

    constructor() {
        super("search");
    }

    async filterGames(filters,names) {
        return await this.sendRequest(
            "index",
            "POST",
            200,
            {
                filters: filters,
                names: names
            },
            null
        );
    }


}
export {SearchAPI}