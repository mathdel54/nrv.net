import {patch, post} from './api.js';

export async function creerPanier(panier) {

    let idBillet = [];
    for (let i = 0; i < panier.length; i++) {

        console.log(panier[i]);

        let tarif = "Normal";
        if (panier[i] === panier[i].soiree.tarifReduit) {
            tarif = "Réduit";
        }

        let data = {
            id_user: sessionStorage.getItem('user_id'),
            tarif: tarif,
            id_soiree: panier[i].soiree.ID,
        };

        const nbPlaces = panier[i].nbPlaces;

        for (let j = 0; j < nbPlaces; j++) {
            await post(data, '/billets')
                .then(async (response) => {

                    if (response.ok) {
                        const responseData = await response.json();
                        idBillet.push(responseData.billet.ID);
                    }
                });
        }

    }
    localStorage.setItem('idBillets', JSON.stringify(idBillet));
    alert('Panier validé');
}

export async function payerPanierPatch() {

    let idBillets = JSON.parse(localStorage.getItem('idBillets'));

    for (let i = 0; i < idBillets.length; i++) {

        await patch('/billets/' + idBillets[i]);
    }

    localStorage.removeItem('idBillets');

    alert('Paiement effectué');
}