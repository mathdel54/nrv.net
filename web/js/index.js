import { display_spectacles } from "./spectacles_ui";
import { loadSpectacles } from "./spectaclesLoader";
import { display_buttons } from "./boutons_ui";
import { loadLieux } from "./lieuLoader";
import { display_panier } from "./panier_ui";
import { showNbElements } from "./panier";
import {display_auth, display_connexion, hide_imgFond, display_imgFond} from "./auth_ui";
import { connecterUtilisateur, inscrireUtilisateur } from "./auth";

//On ajoute un ecouteur d'événement sur le bouton le festival
document.getElementById("accueil").addEventListener("click", function () {
    accueil();
    display_imgFond();
});

//On ajoute un ecouteur d'événement sur le bouton Inscription
document.getElementById("inscription").addEventListener("click", function () {
    display_auth();
    display_imgFond();
});

//On ajoute un ecouteur d'événement sur le bouton Connexion
document.getElementById("connexion").addEventListener("click", function () {
    display_connexion();
    display_imgFond();
});

//On ajoute un ecouteur d'événement sur le formulaire d'inscription
document.getElementById("authTemplate").addEventListener("submit", async function () {
    event.preventDefault();
    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    await inscrireUtilisateur(nom, prenom, email, password);
});

//On ajoute un ecouteur d'événement sur le formulaire de connexion
document.getElementById("connexionTemplate").addEventListener("submit", async function () {
    event.preventDefault();
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    await connecterUtilisateur(email, password);
});

export async function accueil() {

    let spectacles = await loadSpectacles();
    display_spectacles(spectacles);

    //On ajoute un ecouteur d'événement sur le bouton de panier
    document.getElementById("panier").addEventListener("click", function () {
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
    showNbElements();
}

accueil();