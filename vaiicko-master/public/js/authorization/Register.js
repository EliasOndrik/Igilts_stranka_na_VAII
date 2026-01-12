import {AuthAPI} from "./AuthAPI.js";

/**
 * Main chat class
 */
class Register {

    /**
     * API for authentication
     * @type {AuthAPI}
     */

    #authService;
    #register;

    constructor() {

        this.#authService = new AuthAPI();

        this.#register = document.getElementById("register");

        let user = this.#register.getElementsByTagName("input")[0];
        user.onkeyup = async () => {
            let exists = await this.#authService.usernameStatus(user.value);
            await this.showWarnings(JSON.parse(exists),0);
            if (user.value === "") {
                user.className = "is-invalid" + " form-control";
            }
        }

        let email = this.#register.getElementsByTagName("input")[1];
        email.onkeyup = async () => {
            let exists = await this.#authService.emailStatus(email.value);
            await this.showWarnings(JSON.parse(exists),1);
            if (email.value === "") {
                email.className = "is-invalid" + " form-control";
            }
        }

        let pass = this.#register.getElementsByTagName("input")[2];
        pass.onkeyup = async () => {
            let warnings = await this.#authService.passwordStrength(pass.value);
            await this.showWarnings(JSON.parse(warnings),2);
        }

        let correct = this.#register.getElementsByTagName("input")[3];
        correct.onkeyup = async () => {
            if (correct.value.localeCompare(pass.value) !== 0){
                correct.className = "is-invalid" + " form-control";
            } else {
                correct.className = "is-valid" + " form-control";
            }

        }

        setInterval(
            () => this.checkChanges(),
            1000
        )

    }

    async showWarnings(warnings,number) {
        this.#register.getElementsByTagName("input")[number].className = (warnings.length === 0 ? "is-valid" : "is-invalid") + " form-control";
        this.#register.getElementsByClassName("invalid-feedback")[number].innerText = warnings.join("\n");
    }

    async checkChanges() {
        document.getElementById("register-button").disabled = this.#register.querySelectorAll('.is-invalid').length !== 0;
    }
}

export {Register}