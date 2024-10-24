import {creerPanier, payerPanierPatch} from "./panierApi";

let panier = [];

/**
 * Fonction qui initialise le panier
 */
export function initPanier() {
    panier = JSON.parse(localStorage.getItem('panier')) || [];
}

export function ajouterAuPanier(soiree, nbPlaces) {
    panier.push({soiree: soiree, nbPlaces: nbPlaces, tarif: soiree.tarifNormal});
    localStorage.setItem('panier', JSON.stringify(panier));

    showNbElements();
}

export function getPanier() {
    return panier;
}

/**
 * Fonction qui modifie le nombre de places d'un spectacle dans le panier
 * @param index
 * @param nbPlaces
 */
export function modifierNbPlaces(index, nbPlaces) {
    panier[index].nbPlaces = nbPlaces;
    localStorage.setItem('panier', JSON.stringify(panier));
    showNbElements();
}

export function viderPanier() {
    panier = [];
    localStorage.setItem('panier', JSON.stringify(panier));
    showNbElements();
}

export function modifierTarif(index, tarif) {
    panier[index].tarif = tarif;
    localStorage.setItem('panier', JSON.stringify(panier));
}

export function supprimerDuPanier(index) {
    panier.splice(index, 1);
    localStorage.setItem('panier', JSON.stringify(panier));
    showNbElements();
}

export function validerPanier() {

    creerPanier(panier)
        .then(() => {
            viderPanier();
            alert("Panier validé");
        });
}

export function payerPanier() {

    payerPanierPatch()
        .then(() => {
            viderPanier();
            localStorage.setItem('panierValide', false);
            alert("Paiement effectué");
        });
}

/**
 * Fonction qui affiche le nombre d'éléments dans le panier
 */
function showNbElements() {
    let nbElements = 0;
    panier.forEach(element => {
        nbElements += parseInt(element.nbPlaces);
    });

    if (nbElements > 0) {
        document.getElementById('panier').innerHTML = "Panier (" + nbElements + ")";
    }
    else {
        document.getElementById('panier').innerHTML = "Panier";
    }
}