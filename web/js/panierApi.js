import { post } from './api.js';

export async function creerPanier(panier) {

    for (let i = 0; i < panier.length; i++) {

        let tarif;
        if (panier[i] === panier[i].soiree.tarifNormal) {
            tarif = "Normal";
        }
        if (panier[i] === panier[i].soiree.tarifReduit) {
            tarif = "Réduit";
        }

        let data = {
            id_user: sessionStorage.getItem('user_id'),
            tarif: tarif,
            id_soiree: panier[i].soiree.ID,
        };

        await post(data, '/billets');
    }
}

export async function payerPanierPatch(panier) {

    for (let i = 0; i < panier.length; i++) {

        await patch(panier[i].soiree.ID);
    }
}