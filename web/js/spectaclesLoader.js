import {load} from './loader.js';

export async function loadSpectacles(){
    return await load('/spectacles');
}

export async function loadSpectaclesParStyle(style){
    return await load(`/spectacles?style=${style}`);
}

export async function loadSpectaclesParLieu(idLieu){
    return await load(`/lieux/${idLieu}/spectacles`);
}

export async function loadSpectaclesParDate(date){
    return await load(`/spectacles?date=${date}`);
}