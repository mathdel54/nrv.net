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

    if (localStorage.getItem('token')) {
        return fetch(`${pointEntree}${url}`, {
            headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` },
            signal
        })
            .then(response => response.json())
            .catch(error => {
                if (error.name === 'AbortError') {
                    console.log('Fetch aborted');
                } else {
                    console.error('Erreur lors du chargement de la ressource', error);
                }
            });
    }
    else {
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
}

export function post(data, url) {
    // Si une requête est en cours, l'annuler
    if (controller) {
        controller.abort();
    }

    // Créer un nouveau contrôleur pour la nouvelle requête
    controller = new AbortController();
    signal = controller.signal;


    if (localStorage.getItem('token')) {
        return fetch(`${pointEntree}${url}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(data),
            signal
        });
    }
    else {
        return fetch(`${pointEntree}${url}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data),
            signal
        });
    }
}

export function patch(url) {
    // Si une requête est en cours, l'annuler
    if (controller) {
        controller.abort();
    }

    // Créer un nouveau contrôleur pour la nouvelle requête
    controller = new AbortController();
    signal = controller.signal;

    if (localStorage.getItem('token')) {
        return fetch(`${pointEntree}${url}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            signal
        });
    }
    else {
        return fetch(`${pointEntree}${url}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            signal
        });
    }
}