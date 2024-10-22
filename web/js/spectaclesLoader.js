import {load} from './loader.js';

export async function loadSpectacles(){
    return await load('/spectacles');
}