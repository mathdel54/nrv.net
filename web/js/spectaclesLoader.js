import {load} from './loader.js';

export async function loadSpectacles(){
    return await load('/spectacles');
}

export async function loadArtisteDeSpectacle(idSpectacle){
    return await load(`/spectacles/${idSpectacle}/artistes`);
}