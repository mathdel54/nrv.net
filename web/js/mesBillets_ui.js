import Handlebars from 'handlebars';
import {loadBillets} from "./mesBilletsLoader";

const source = document.getElementById('mesBilletsTemplate').innerHTML;
const template = Handlebars.compile(source);
export async function display_mesBillets() {
    let billets = await loadBillets();
    document.getElementById('template').innerHTML = template({billets: billets.billets});
}