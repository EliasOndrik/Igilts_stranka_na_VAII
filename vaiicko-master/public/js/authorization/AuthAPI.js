import {DataService} from "../DataService.js";

/**
 * Class containing all calls to AuthApiController
 */
class AuthAPI extends DataService {

    constructor() {
        super("auth");
    }

    async usernameStatus(username) {
        return await this.sendRequest(
            "register",
            "POST",
            200,
            {
                username: username
            },
            null
        );
    }

    async emailStatus(email) {
        return await this.sendRequest(
            "register",
            "POST",
            200,
            {
                email: email
            },
            null
        );
    }

    async passwordStrength(password) {
        return await this.sendRequest(
            "register",
            "POST",
            200,
            {
                password: password
            },
            null
        );
    }

}
export {AuthAPI}