/* //compte zi bankaire:

class Comptes {
    constructor(numero,nom,prenom,solde,password) {
        this.numero = numero;
        this.nom = nom;
        this.prenom = prenom;
        this.solde = solde;
        this.password = password;
        this.historique = [];
    }

    virement(montant,type,destin) {
        montant = parseInt(montant);
        var isGood = false;
        if (montant <= 0) {
            alert("impossible d'envoyer une valeur negatif, voyons !");
            return;
        }
        if(type === "compte-Zibanke" && this.soldeControle(montant)) {
            for (let compte of comptes) {
                if(compte.numero == destin) {
                    var beneficieur = compte;
                    isGood = true;
                    break;
                }
            }
            if(isGood) {
                this.solde -= montant;
                this.ajoutHistorique(`${beneficieur.prenom} ${beneficieur.nom}`, `-${montant}`)
                beneficieur.solde += montant;
                beneficieur.ajoutHistorique(`${this.prenom} ${this.nom}`, `+${montant}`)
            }else {
                alert('destinataire invalide');
            }
        } else if (this.soldeControle(montant)) {
            this.solde -= montant
            this.ajoutHistorique(destin , `-${montant}`);
        } else {
            alert('solde insufisant !');
        }

    }

    depot(montant) {
        montant = parseInt(montant);
        if(montant >= 0){
            this.solde += montant;
            this.ajoutHistorique('depôt' , `+${montant}`);
        }else if (this.soldeControle(montant)) {
            this.solde += montant;
            this.ajoutHistorique('retrait' , `${montant}`);
        }else {
            alert('solde insufisant !');
        }
    }

    ajoutHistorique(reference,montant) {
        var now = new Date();
        if(reference == '') {reference = 'probablement du black'};
        this.historique.push(`<tr><td>${reference}</td><td>${montant}</td><td>${('0'+now.getDate()).slice(-2)} / ${('0'+(now.getMonth()+1)).slice(-2)} / ${now.getFullYear()}  ${('0'+now.getHours()).slice(-2)} : ${('0'+now.getMinutes()).slice(-2)}</td></tr>`);
    }

    soldeControle(montant) {
        if(Math.abs(montant) < this.solde) {
            return true;
        }else {
            return false;
        }
    }

}
//creation comptes
var bond = new Comptes('007', 'Bond' , 'james' , 768000 , 'GoldenEye');
var connor = new Comptes('2018' , 'Connor' , 'John' , 13800 , 'likeShwartzer');
var pauvre = new Comptes('00001' , 'Mec' , 'Lepauvre' , -20 , 'merde');
var lucifer = new Comptes('666' , 'Morningstar' , 'Lucifer' , 1250000 , 'fallini');

var comptes = [bond , connor , pauvre , lucifer];
let account;

//ze code

document.getElementById('connect').addEventListener('click' , loginConnect);
document.getElementById('identity').addEventListener('keypress' ,  enterEvent);
document.getElementById('passe').addEventListener('keypress' ,  enterEvent);

function loginConnect() {
    let good = false;
    for(let compte of comptes) {     
        if(document.querySelector('#identity').value == compte.numero && document.querySelector('#passe').value == compte.password ) {
            account = compte;
            good = true;
        }
    }
    if(good) {
        document.querySelector('#pseudo').innerText = `${account.prenom} ${account.nom}`;
        document.querySelector('#solde').innerText = `${account.solde.toLocaleString()} euro` ;
        document.getElementById('histoire').innerHTML = account.historique.join('');
        changePageConnect();
    } else {
        const incorrect = document.createElement('p');
        document.querySelector('.login-block > div').appendChild(incorrect);
        incorrect.innerText = 'identifiant ou mot de passe incorrect';
        document.getElementById('connect').addEventListener('click' , () => { incorrect.remove();}, {once:true});
    }
};

function enterEvent(e) {
   if(e.key === "Enter"){
       document.getElementById('connect').click(); 
   }
};


//virement:
const type = document.getElementById('select-beneficiare');
const montantVir = document.getElementById('virage-amount');
const benef = document.getElementById('compte-beneficiaire');

document.getElementById('virage-go').addEventListener('click' , () => {
    account.virement(montantVir.value , type.value , benef.value);
    document.querySelector('#solde').innerText = `${account.solde.toLocaleString()} euro` ;
    document.getElementById('histoire').innerHTML = account.historique.join('');
    type.value = "";
    montantVir.value = "";
    benef.value = "";
});

//depôt

const depose = document.getElementById('depose')

document.getElementById('depot-go').addEventListener('click' , () => {
    account.depot(depose.value);
    document.querySelector('#solde').innerText = `${account.solde.toLocaleString()} euro` ;
    document.getElementById('histoire').innerHTML = account.historique.join('');
    depose.value = '';
});


//pages:

const bloques = document.querySelectorAll('section');
const loading = document.querySelector('.login-load-stats');

bloques[1].style.display = "none";
bloques[2].style.display = "none";
document.getElementById('disconnect').addEventListener('click' , () => changePage(0));

function changePageConnect() {
    for (let bloque of bloques) {
        bloque.style.display = "none";
    }
    bloques[1].removeAttribute('style');
    window.setTimeout(() => {changePage(2)} , 3000);
    window.setTimeout(() => {loading.innerText = "mise en place de la securité"} , 1000);
    window.setTimeout(() => {loading.innerText = "voila vous êtes bien proteger ! "} , 2000);
    window.setTimeout(() => {loading.innerText = "chargement en cours..."} , 3000);

}

function changePage(index) {
    for (let bloque of bloques) {
        bloque.style.display = "none";
    }
    bloques[index].removeAttribute('style');
}
 */