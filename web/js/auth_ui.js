
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