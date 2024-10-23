import Handlebars from 'handlebars';
import {loadSpectaclesDeLaSoiree} from "./soireeLoader";
import {loadArtisteDeSpectacle} from "./spectaclesLoader";
import {load} from "./loader";

const source = document.getElementById('soireeTemplate').innerHTML;
const template = Handlebars.compile(source);
export async function display_soiree(soiree) {
    let spectacles = await loadSpectaclesDeLaSoiree(soiree.ID);

    for (let i = 0; i < spectacles.spectacles.length; i++) {
        spectacles.spectacles[i].artiste = await load(spectacles.spectacles[i].links.artistes.href);
    }


    soiree.spectacles = spectacles;

    console.log(soiree.spectacles);

    document.getElementById('template').innerHTML = template(soiree);
}