import {load} from './loader.js';

export async function loadSpectaclesDeLaSoiree(idSoiree){
    return await load(`/soirees/${idSoiree}/spectacles`);
}