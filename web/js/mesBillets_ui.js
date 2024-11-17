import Handlebars from 'handlebars';
import {loadBillets} from "./mesBilletsLoader";

const source = document.getElementById('mesBilletsTemplate').innerHTML;
const template = Handlebars.compile(source);