import {display_spectacles} from "./spectacles_ui";
import {loadSpectacles} from "./spectaclesLoader";

export async function showSpectacles(){
    let spectacles = await loadSpectacles();
    display_spectacles(spectacles);
}

showSpectacles().catch(
    (error) => console.error('Error displaying spectacles: ', error)
);