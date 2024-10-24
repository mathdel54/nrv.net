import { post } from './api.js';

export async function inscrireUtilisateur(email, password) {
    try {
        const response = await post('/api/register', { email, password });
        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('token', data.token);
            alert('Inscription réussie');
        } else {
            alert('Erreur lors de l\'inscription: ' + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'inscription');
    }
}