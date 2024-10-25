
export function display_auth() {
    document.getElementById('templateBoutons').innerHTML = "";
    document.getElementById('template').innerHTML = "";
    document.getElementById('connexionTemplate').style.display = "none";

    document.getElementById('inscriptionTemplate').style.display = "block";
}

export function display_connexion() {
    document.getElementById('templateBoutons').innerHTML = "";
    document.getElementById('template').innerHTML = "";
    document.getElementById('inscriptionTemplate').style.display = "none";

    document.getElementById('connexionTemplate').style.display = "block";
}

export function display_hidden_img() {
    document.getElementById('imageDeFond').style.backgroundImage = "none";
    document.getElementsByClassName('banniere').item(0).style.display = "none";
    document.getElementsByTagName('header').item(0).style.backgroundColor = "#E08F7E";
    document.getElementById('imageDeFond').style.minHeight = "0vh";
}