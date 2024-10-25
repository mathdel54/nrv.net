
export function display_auth() {
    document.getElementById('templateBoutons').innerHTML = "";
    document.getElementById('template').innerHTML = "";
    document.getElementById('connexionTemplate').style.display = "none";

    document.getElementById('authTemplate').style.display = "block";
}

export function display_connexion() {
    document.getElementById('templateBoutons').innerHTML = "";
    document.getElementById('template').innerHTML = "";
    document.getElementById('authTemplate').style.display = "none";

    document.getElementById('connexionTemplate').style.display = "block";
}

export function hide_imgFond() {
    document.getElementById('imageDeFond').style.backgroundImage = "none";
    document.getElementsByClassName('banniere').item(0).style.display = "none";
    document.getElementsByTagName('header').item(0).style.backgroundColor = "#E08F7E";
    document.getElementById('imageDeFond').style.minHeight = "0vh";
}

export function display_imgFond() {
    document.getElementById('imageDeFond').style.backgroundImage = "url('../images/nrv_accueil.webp')";
    document.getElementsByClassName('banniere').item(0).style.display = "block";
    document.getElementsByTagName('header').item(0).style.backgroundColor = "transparent";
    document.getElementById('imageDeFond').style.minHeight = "100vh";
}