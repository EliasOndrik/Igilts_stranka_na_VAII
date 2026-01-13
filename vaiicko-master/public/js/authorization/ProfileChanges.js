import {AuthAPI} from "./AuthAPI.js";

class ProfileChanges {
    /**
     * API for authentication
     * @type {AuthAPI}
     */
    #authService;

    constructor(auth) {
        this.#authService = auth;
        if (document.getElementById("profile-settings") === null){
            return
        }
        let user = document.getElementById("username")
        user.onkeyup = async () => {
            let exists = await this.#authService.usernameStatus(user.value);
            this.formControls("username-form",user,JSON.parse(exists));
        }

        let pass = document.getElementById("password")
        pass.onkeyup = async () => {
            let warnings = await this.#authService.passwordStrength(pass.value);
            this.formControls("password-form",pass,JSON.parse(warnings));
        }
        let correct = document.getElementById("confirmPassword");
        correct.onkeyup = async () => {
            if (correct.value.localeCompare(pass.value) !== 0){
                correct.className = "is-invalid" + " form-control";
            } else {
                correct.className = "is-valid" + " form-control";
            }
        }

        let image = document.getElementById("avatar");
        setInterval(
            () => this.imageCheck(image),
            1000
        )

    }

    formControls(formType, inputElement, warnings){
        document.getElementById(formType).getElementsByClassName("invalid-feedback")[0].innerText = warnings.join("\n");
        inputElement.className = (warnings.length === 0 ? "is-valid" : "is-invalid") + " form-control";
        if (inputElement.value === "") {
            inputElement.className = "is-invalid" + " form-control";
        }
        document.getElementById(formType).getElementsByTagName("button")[0].disabled = inputElement.classList.contains("is-invalid");
    }
    imageCheck(image){
        image.className = (image.files.length === 0 ? "is-invalid" : "is-valid") + " form-control";
        document.getElementById("image-form").getElementsByTagName("button")[0].disabled = image.classList.contains("is-invalid");
    }
}

export {ProfileChanges}