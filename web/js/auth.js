import { post } from './api.js';

export async function inscrireUtilisateur(nom, prenom, email, mdp) {

    let data = {
        nom: nom,
        prenom: prenom,
        email: email,
        mdp: mdp
    };
    try {
        const response = await post(data, '/inscription');

        if (response.ok){
            alert('Inscription réussie');
        }
        else {
            alert('Inscription échouée');
        }
    }
    catch (error) {
        console.error('Erreur lors de l\'inscription', error);
        alert('Inscription échouée');
    }
}

export async function connecterUtilisateur(email, mdp) {

        let data = {
            email: email,
            mdp: mdp
        };
        try {
            const response = await post(data, '/connexion');

            if (response.ok){
                alert('Connexion réussie');
                sessionStorage.setItem('user_id', response.id);
                localStorage.setItem('token', response.token);
            }
            else {
                alert('Connexion échouée');
            }
        }
        catch (error) {
            console.error('Erreur lors de la connexion', error);
            alert('Connexion échouée');
        }
}