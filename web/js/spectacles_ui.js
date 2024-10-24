import Handlebars from 'handlebars';
import {display_soiree} from "./soiree_ui";
import {load} from "./api";


const source = document.getElementById('spectaclesTemplate').innerHTML;
const template = Handlebars.compile(source);

export function display_spectacles(spectacles, styleSelected) {

    document.getElementById('template').innerHTML = template({spectacles: spectacles.spectacles, styleSelected: styleSelected});

    document.querySelectorAll('.spectacle').forEach(spectacle => {
        spectacle.addEventListener('click', async () => {
            let soiree = await load(spectacle.dataset.liensoiree);
            display_soiree(soiree.soiree);
        });
    });
}