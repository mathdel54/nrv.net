import {patch, post} from './api.js';

export async function creerPanier(panier) {

    let idBillet = [];
    for (let i = 0; i < panier.length; i++) {

        let tarif = "Normal";
        console.log(panier[i].tarif);
        console.log(panier[i].soiree.tarifReduit);
        //On compare ici un string et un nombre
        if (panier[i].tarif == panier[i].soiree.tarifReduit) {
            tarif = "Reduit";
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
}

export async function payerPanierPatch() {

    let idBillets = JSON.parse(localStorage.getItem('idBillets'));

    for (let i = 0; i < idBillets.length; i++) {

        await patch('/billets/' + idBillets[i]);
    }

    localStorage.removeItem('idBillets');

    alert('Paiement effectué');
}