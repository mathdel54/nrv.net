import {load} from './api.js';

export async function loadSpectacles(){
    return await load('/spectacles');
}

export async function loadSpectaclesParStyle(style){

    //Si un & est présent dans la chaine de caractère, on le remplace par %26
    style = style.replace("&", "%26");
    return await load(`/spectacles?style=${style}`);
}

export async function loadSpectaclesParLieu(idLieu){
    return await load(`/lieux/${idLieu}/spectacles`);
}

export async function loadSpectaclesParDate(date){
    return await load(`/spectacles?date=${date}`);
}