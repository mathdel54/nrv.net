import {patch, post} from './api.js';

export async function creerPanier(panier) {

    let idBillet = [];
    for (let i = 0; i < panier.length; i++) {

        let tarif = "Normal";
        if (panier[i] === panier[i].soiree.tarifReduit) {
            tarif = "Réduit";
        }

        let data = {
            id_user: sessionStorage.getItem('user_id'),
            tarif: tarif,
            id_soiree: panier[i].soiree.ID,
        };
        console.log(data);

        await post(data, '/billets')
            .then((response) => {

                if (response.ok) {


                    const responseData = response.json();
                    console.log(responseData);
                }
            });
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