import {display_spectacles} from "./spectacles_ui";
import {loadSpectacles} from "./spectaclesLoader";

export async function showSpectacles(){
    let spectacles = await loadSpectacles();
    console.log('Spectacles loaded: ', spectacles);
    display_spectacles(spectacles);
}

showSpectacles().then(
    () => console.log('Spectacles displayed')
).catch(
    (error) => console.error('Error displaying spectacles: ', error)
);