import Handlebars from 'handlebars';
import {display_soiree} from "./soiree_ui";
import {load} from "./loader";
import {loadSpectaclesParStyle} from "./spectaclesLoader";

Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
    console.log(arg1, arg2);
    return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
});


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
    let styleMusique = document.getElementById("styleMusique");
    styleMusique.addEventListener('change', async () => {

        let spectacles = await loadSpectaclesParStyle(styleMusique.value);
        display_spectacles(spectacles, styles, styleMusique.value);
    });
}