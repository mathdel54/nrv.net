import {load} from './api.js';

export async function loadLieux(){
    return await load('/lieux');
}