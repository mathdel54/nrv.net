import {display_spectacles} from "./spectacles_ui";
import {loadSpectacles} from "./spectaclesLoader";
import {display_buttons} from "./boutons_ui";
import {loadLieux} from "./lieuLoader";

export async function init(){

    let spectacles = await loadSpectacles();
    display_spectacles(spectacles);

    //On récupere les styles différents des spectacles
    let styles = [];
    for (let i = 0; i < spectacles.spectacles.length; i++) {
        if (!styles.includes(spectacles.spectacles[i].spectacle.style)) {
            styles.push(spectacles.spectacles[i].spectacle.style);
        }
    }

    let lieux = await loadLieux();
    console.log(lieux.lieux);

    display_buttons(styles, lieux.lieux);
}

init();