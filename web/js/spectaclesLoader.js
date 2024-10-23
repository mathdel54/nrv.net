import {load} from './loader.js';

export async function loadSpectacles(){
    return await load('/spectacles');
}

export async function loadSpectaclesParStyle(style){
    return await load(`/spectacles?style=${style}`);
}