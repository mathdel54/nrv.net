import {load} from './api.js';

export async function loadBillets(){
    if (sessionStorage.getItem('user_id') === null) {
        return
    }
    return await load('/users/' + sessionStorage.getItem('user_id') + '/billets');
}