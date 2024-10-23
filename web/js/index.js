import {display_spectacles} from "./spectacles_ui";
import {loadSpectacles} from "./spectaclesLoader";



export async function showSpectacles(){

    let spectacles = await loadSpectacles();

    //On récupere les styles différents des spectacles
    let styles = [];
    for (let i = 0; i < spectacles.spectacles.length; i++) {
        if (!styles.includes(spectacles.spectacles[i].spectacle.style)) {
            styles.push(spectacles.spectacles[i].spectacle.style);
        }
    }

    display_spectacles(spectacles, styles);
}


//On Ajoute un écouteur d'événement sur le bouton "spectacles" pour afficher les spectacles
showSpectacles();