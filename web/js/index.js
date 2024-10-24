import {display_spectacles} from "./spectacles_ui";
import {loadSpectacles} from "./spectaclesLoader";
import {display_buttons} from "./boutons_ui";
import {loadLieux} from "./lieuLoader";
import {display_panier} from "./panier_ui";

//On ajoute un ecouteur d'événement sur le bouton le festival
document.getElementById("accueil").addEventListener("click", function() {
    accueil();
});


export async function accueil(){

    let spectacles = await loadSpectacles();
    display_spectacles(spectacles);

    //On ajoute un ecouteur d'événement sur le bouton de panier
    document.getElementById("panier").addEventListener("click", function() {
        display_panier();
    });

    //On récupere les styles différents des spectacles
    let styles = [];
    for (let i = 0; i < spectacles.spectacles.length; i++) {
        if (!styles.includes(spectacles.spectacles[i].spectacle.style)) {
            styles.push(spectacles.spectacles[i].spectacle.style);
        }
    }

    //On récupere les dates différentes des spectacles
    let dates = [];
    for (let i = 0; i < spectacles.spectacles.length; i++) {
        if (!dates.includes(spectacles.spectacles[i].spectacle.date)) {
            dates.push(spectacles.spectacles[i].spectacle.date);
        }
    }

    //On récupere les lieux
    let lieux = await loadLieux();

    display_buttons(styles, lieux.lieux, dates);
}

accueil();