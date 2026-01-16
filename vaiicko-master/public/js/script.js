import {Register} from "./authorization/Register.js";
import {AuthAPI} from "./authorization/AuthAPI.js";
import {ProfileChanges} from "./authorization/ProfileChanges.js";
import {GameAPI} from "./game/GameAPI.js";
import {GameChanges} from "./game/GameChanges.js";
import {SearchAPI} from "./search/SearchAPI.js";
import {SearchGames} from "./search/SearchGames.js";

let auth = new AuthAPI();
document.authorization = new Register(auth);
document.profile = new ProfileChanges(auth);
let gameApi = new GameAPI();
document.gameChanges = new GameChanges(gameApi);
let search = new SearchAPI();
document.search = new SearchGames(search);
