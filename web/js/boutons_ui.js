import Handlebars from 'handlebars';
import { loadSpectaclesParDate, loadSpectaclesParLieu, loadSpectaclesParStyle } from "./spectaclesLoader";
import { display_spectacles } from "./spectacles_ui";

const source = document.getElementById('buttonsTemplate').innerHTML;
const template = Handlebars.compile(source);
export function display_buttons(styles, lieux, dates) {

    document.getElementById('templateBoutons').innerHTML = template({ styles: styles, lieux: lieux, dates: dates });

    //On rajoute un evenement sur les dates
    document.querySelectorAll('.filtreDate').forEach(date => {
        date.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParDate(date.dataset.date);
            display_spectacles(spectacles, date.dataset.date);
        });
    })

    //On rajoute un evenement sur les styles
    document.querySelectorAll('.filtreStyle').forEach(style => {
        style.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParStyle(style.dataset.style);
            display_spectacles(spectacles, style.dataset.style);
        });
    })

    //On rajoute un evenement sur les lieux
    document.querySelectorAll('.filtreLieu').forEach(lieu => {
        lieu.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParLieu(lieu.dataset.lieu);
            display_spectacles(spectacles, lieu.innerHTML);
        });
    })

    //On rajoute un evenement sur les lieux
    document.querySelectorAll('.filtreLieu').forEach(lieu => {
        lieu.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParLieu(lieu.dataset.lieu);
            display_spectacles(spectacles, lieu.innerHTML);
        });
    })

    // Fonction pour masquer tous les filtres
    function masquerTousLesFiltres() {
        document.querySelectorAll('.filtreDate').forEach(filter => filter.hidden = true);
        document.querySelectorAll('.filtreStyle').forEach(filter => filter.hidden = true);
        document.querySelectorAll('.filtreLieu').forEach(filter => filter.hidden = true);
    }

    // Lorsqu'un bouton selectionStyle est cliqué, on affiche uniquement les filtres de style
    document.querySelector('#selectionStyle').addEventListener('click', () => {
        masquerTousLesFiltres(); // Masquer les autres filtres
        document.querySelectorAll('.filtreStyle').forEach(filter => {
            filter.hidden = false; // Afficher uniquement les filtres de style
        });
    });

    // Lorsqu'un bouton selectionDate est cliqué, on affiche uniquement les filtres de date
    document.querySelector('#selectionDate').addEventListener('click', () => {
        masquerTousLesFiltres(); // Masquer les autres filtres
        document.querySelectorAll('.filtreDate').forEach(filter => {
            filter.hidden = false; // Afficher uniquement les filtres de date
        });
    });

    // Lorsqu'un bouton selectionLieu est cliqué, on affiche uniquement les filtres de lieu
    document.querySelector('#selectionLieu').addEventListener('click', () => {
        masquerTousLesFiltres(); // Masquer les autres filtres
        document.querySelectorAll('.filtreLieu').forEach(filter => {
            filter.hidden = false; // Afficher uniquement les filtres de lieu
        });
    });
}