import Handlebars from 'handlebars';
import {
    getPanier,
    initPanier,
    modifierNbPlaces,
    modifierTarif,
    supprimerDuPanier,
    validerPanier,
    viderPanier
} from "./panier";

Handlebars.registerHelper('ifCond', function (v1, v2, options) {
    if (v1 == v2) {
        return options.fn(this);
    }
    return options.inverse(this);
});

const source = document.getElementById('panierTemplate').innerHTML;
const template = Handlebars.compile(source);

export function display_panier() {
    document.getElementById('connexionTemplate').style.display = "none";
    document.getElementById('authTemplate').style.display = "none";

    initPanier();

    document.getElementById('templateBoutons').innerHTML = "";
    let panier = getPanier();
    document.getElementById('template').innerHTML = template(panier);
    calculTotal();

    //On rajoute un evenement sur les select nbPlaces et sur les select tarif
    document.querySelectorAll('.nbPlaces').forEach(nbPlaces => {
        nbPlaces.addEventListener('change', function() {
            let index = nbPlaces.dataset.index;
            modifierNbPlaces(index, nbPlaces.value);
            calculTotal();
        });
    });

    document.querySelectorAll('.tarif').forEach(tarif => {
        tarif.addEventListener('change', function() {
            let index = tarif.dataset.index;
            modifierTarif(index, tarif.value);
            calculTotal();
        });
    });

    //On rajoute un evenement sur les boutons supprimer
    document.querySelectorAll('.supprimerPanier').forEach(supprimer => {
        supprimer.addEventListener('click', function() {
            let index = supprimer.dataset.index;
            supprimerDuPanier(index);
            display_panier();
        });
    });

    //On rajoute un evenement sur le bouton vider
    document.getElementById('vider').addEventListener('click', function() {
        viderPanier();
        display_panier();
    });

    //On rajoute un evenement sur le bouton valider
    document.getElementById('validerPanier').addEventListener('click', function() {
        validerPanier();
        display_panier();
    });
}

function calculTotal() {
    let total = 0;
    getPanier().forEach(element => {
        total += element.nbPlaces * element.tarif;
    });
    document.getElementById('total').innerHTML = "Total : " + total + " €";
}