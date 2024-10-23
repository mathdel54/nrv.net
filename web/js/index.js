import {display_spectacles} from "./spectacles_ui";
import {loadSpectacles} from "./spectaclesLoader";
import {display_buttons} from "./boutons_ui";



export async function init(){

    let spectacles = await loadSpectacles();

    //On récupere les styles différents des spectacles
    let styles = [];
    for (let i = 0; i < spectacles.spectacles.length; i++) {
        if (!styles.includes(spectacles.spectacles[i].spectacle.style)) {
            styles.push(spectacles.spectacles[i].spectacle.style);
        }
    }

    display_spectacles(spectacles);
    display_buttons(styles);
}


init();