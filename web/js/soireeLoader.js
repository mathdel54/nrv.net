import {load} from './api.js';

export async function loadSpectaclesDeLaSoiree(idSoiree){
    return await load(`/soirees/${idSoiree}/spectacles`);
}