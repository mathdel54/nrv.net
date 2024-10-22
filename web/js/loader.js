import {pointEntree} from './config.js';

let controller = new AbortController();
let {signal} = controller;

export function load(url) {
    // Si une requête est en cours, l'annuler
    if (controller) {
        controller.abort();
    }

    // Créer un nouveau contrôleur pour la nouvelle requête
    controller = new AbortController();
    signal = controller.signal;

    return fetch(`${pointEntree}${url}`, {signal})
        .then(response => response.json())
        .catch(error => {
            if (error.name === 'AbortError') {
                console.log('Fetch aborted');
            } else {
                console.error('Erreur lors du chargement de la ressource', error);
            }
        });
}