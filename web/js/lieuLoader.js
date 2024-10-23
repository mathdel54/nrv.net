import {load} from './loader.js';

export async function loadLieux(){
    return await load('/lieux');
}