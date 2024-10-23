import Handlebars from 'handlebars';
import {loadSpectaclesParLieu, loadSpectaclesParStyle} from "./spectaclesLoader";
import {display_spectacles} from "./spectacles_ui";

const source = document.getElementById('buttonsTemplate').innerHTML;
const template = Handlebars.compile(source);
export function display_buttons(styles, lieux) {

    document.getElementById('templateBoutons').innerHTML = template({styles: styles, lieux: lieux});

    //On rajoute un evenement sur les styles
    document.querySelectorAll('.filtreStyle').forEach(style => {
        style.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParStyle(style.dataset.style);
            display_spectacles(spectacles,  style.dataset.style);
        });
    })

    //On rajoute un evenement sur les lieux
    document.querySelectorAll('.filtreLieu').forEach(lieu => {
        lieu.addEventListener('click', async () => {
            let spectacles = await loadSpectaclesParLieu(lieu.dataset.lieu);
            display_spectacles(spectacles,  lieu.innerHTML);
        });
    })
}