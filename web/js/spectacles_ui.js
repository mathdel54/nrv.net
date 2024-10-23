import Handlebars from 'handlebars';
import {display_soiree} from "./soiree_ui";
import {load} from "./loader";
import {loadSpectaclesParStyle} from "./spectaclesLoader";


const source = document.getElementById('spectaclesTemplate').innerHTML;
const template = Handlebars.compile(source);

export function display_spectacles(spectacles, styles, styleSelected) {

    document.getElementById('template').innerHTML = template({spectacles: spectacles.spectacles, styles: styles, styleSelected: styleSelected});

    document.querySelectorAll('.spectacle').forEach(spectacle => {
        spectacle.addEventListener('click', async () => {
            let soiree = await load(spectacle.dataset.liensoiree);
            display_soiree(soiree.soiree);
        });
    });

    //On rajoute un evenement sur les styles
    document.querySelectorAll('.filtreStyle').forEach(style => {
        style.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParStyle(style.dataset.style);
            display_spectacles(spectacles, styles, style.dataset.style);
        });
    })
}