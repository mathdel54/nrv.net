import Handlebars from 'handlebars';
import {load} from "./loader";

const source = document.getElementById('spectaclesTemplate').innerHTML;
const template = Handlebars.compile(source);
export function display_spectacles(spectacles){
    document.getElementById('template').innerHTML = template(spectacles);
}