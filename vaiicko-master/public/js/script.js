import {Register} from "./authorization/Register.js";
import {AuthAPI} from "./authorization/AuthAPI.js";
import {ProfileChanges} from "./authorization/ProfileChanges.js";

let auth = new AuthAPI();
document.authorization = new Register(auth);
document.profile = new ProfileChanges(auth);
