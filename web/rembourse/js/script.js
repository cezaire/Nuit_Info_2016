var totalpaiement = 0;
var nombreParticipants = 0;
var nombrePaiements = 0;
var tableauParticipants = [];
var tableauPaiements = [];

function ajoutParticipant(){
	"use strict";
	var listeParticipants = document.getElementById("liste_participants"),
	participant = document.getElementById("ajout_participant"),
	select = document.getElementById("select_participant"),
	option = document.createElement("option"),
	table_participants = document.getElementById("table_participants"),
	contenuA = "<tr><td>"+participant.value+"</td>",
	contenuB = "<td><button type='button' class='btn btn-primary' onclick='suppressionParticipant(this)'>Supprimer</button></td></tr>";
	if(participant.value !==""){
		listeParticipants.innerHTML += contenuA + contenuB;
		option.text = participant.value;
		select.add(option);
		nombreParticipants +=1;
		tableauParticipants.push(participant.value);
		tableauPaiements.push(0);
		participant.value ="";
		select.style.visibility = "visible";
		table_participants.style.visibility = "visible";
	}
}

function suppressionParticipant(obj){
	"use strict";
	var select = document.getElementById("select_participant"),
	paiements = document.getElementById("liste_paiements"),
	table_participants = document.getElementById("table_participants"),	
	i=0,
	tableau = [];
	for(i=0;i<select.length;i+=1){
		if(select[i].value === obj.parentElement.parentElement.childNodes[0].innerText){
			select.remove(select[i]);
			break;
		}
	}
	for(i=0;i<liste_paiements.childNodes.length;i+=1){
		if(liste_paiements.childNodes[i].childNodes[1].innerText === obj.parentElement.parentElement.childNodes[0].innerText){
			tableau.push(i);
		}
	}
	for(i=tableau.length;i>0;i-=1){
		totalpaiement -= parseInt(liste_paiements.childNodes[tableau[i-1]].childNodes[0].innerText);
		liste_paiements.removeChild(liste_paiements.childNodes[tableau[i-1]]);
	}
	obj.parentElement.parentElement.remove();
	nombreParticipants -=1;
	if(nombreParticipants === 0){
		select.style.visibility = "hidden";
		table_participants.style.visibility = "hidden";
	}
}

function ajoutPaiement(){
	"use strict";
	var select = document.getElementById("select_participant"),
	paiement = document.getElementById("ajout_paiement"),
	listePaiements = document.getElementById("liste_paiements"),
	table_paiements = document.getElementById("table_paiements"),
	contenuA = "<tr><td>"+paiement.value+"</td>",
	contenuB = "<td>"+select.value+"</td>",
	contenuC = "<td><button type='button' class='btn btn-primary' onclick='suppressionPaiement(this)'>Supprimer</button></td></tr>";
	if(paiement.value !=="" && select.value !== ""){
		listePaiements.innerHTML += contenuA + contenuB+ contenuC;
		nombrePaiements +=1;
		totalpaiement += parseInt(paiement.value);
		for(var i=0;i<tableauParticipants.length;i+=1){
			if(tableauParticipants[i] === select.value){
				tableauPaiements[i] += parseInt(paiement.value);
			}
		}
		paiement.value ="";
		table_paiements.style.visibility = "visible";
		creationRecap();
	}
}

function suppressionPaiement(obj){
	"use strict";
	var table_paiements = document.getElementById("table_paiements");
	for(var i=0;i<tableauParticipants.length;i+=1){
		if(tableauParticipants[i] === obj.parentElement.parentElement.childNodes[1].innerText){
			tableauPaiements[i] -= parseInt(obj.parentElement.parentElement.childNodes[0].innerText);
			totalpaiement -= parseInt(obj.parentElement.parentElement.childNodes[0].innerText);
			break;
		}
	}
	obj.parentElement.parentElement.remove();
	nombrePaiements -=1;
	if(nombrePaiements === 0){
		table_paiements.style.visibility = "hidden";
	}
	creationRecap();
}

function creationRecap(){
	"use strict";
	var contenu = "",
	table_recap = document.getElementById("table_recap"),
	i=0,
	delta=0;
	for(i=0;i<tableauParticipants.length;i+=1){
		delta = totalpaiement/tableauParticipants.length-tableauPaiements[i];
		contenu += "<tr><td>"+tableauParticipants[i]+"</td>"+
		"<td>"+tableauPaiements[i]+"</td>"+
		"<td>"+delta+"</td></tr>";
	}
	if(nombrePaiements === 0){
		table_recap.style.visibility = "hidden";
	}else{
		table_recap.style.visibility = "visible";
	}
	document.getElementById("liste_recap").innerHTML = contenu;
}

function contains(a, obj){
	var i = 0,
	resultat = -1;
	for(i=0;i<a.length;i+=1){
		if (a[i] === obj) {
			resultat = i;
			break;
		}
	}
	return resultat;
}