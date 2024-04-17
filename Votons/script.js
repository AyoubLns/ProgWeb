function creer() {  
    $.ajax({
    type: "POST",
    url: "creerscrutin.php",

    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}

function creerjson() {  
    var deadline = document.getElementById('deadline').value;
    var currentDate = new Date().toISOString().slice(0, 10);
    
    if (deadline <= currentDate) {
        alert("La date limite doit être supérieure à la date actuelle.");
        return;
    }
    
    var formData = $('#scrutinForm').serialize();

    $.ajax({
        type: "POST",
        url: "creer.php",
        data: formData,
        dataType: "json",
    }).done(function(msg) {
        if (msg.success) {
            alert("Votre scrutin a été enregistré.");
            accueil();
        } else {
            alert("Erreur lors de l'enregistrement du scrutin.");
        }
    }).fail(function(msg) {
        console.log(msg);
        alert("Erreur lors de l'enregistrement du scrutin.");
    });
}


function updateTotalElecteurs(radio) {
    var totalElecteurs = parseInt(document.getElementById('totalElecteurs').value.match(/\d+/)[0]);
    if (radio.checked && radio.value >= -1) {
        totalElecteurs = totalElecteurs - parseInt(radio.value) - 1;
    }
    document.getElementById('totalElecteurs').value = 'Nombre de vote restant à attribuer (au maximum) : ' + totalElecteurs;
}



var choixCount = 2; 

function ajouterChoix() {
    if (choixCount < 5) {
        choixCount++;
        var choix = "<input type='text' name='Choix" + choixCount + "' class='choix-input' placeholder='choix " + choixCount + "' required> <br>";
        document.getElementById('choicesContainer').insertAdjacentHTML('beforeend', choix);
    }
}


function participer() {  
    $.ajax({
    type: "POST",
    url: "participerscrutin.php",
    
    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}

function participervote(scrutinName) {
    var choixId = 'choix_' + scrutinName;
    var choix = document.getElementById(choixId).value; 

    $.ajax({
        type: "POST",
        url: "participervote.php",
        data: { scrutin: scrutinName, choix: choix }, 
        dataType: "json",
    }).done(function(msg) {
        $("#contentsparticiper").html(msg); 
        alert("Votre vote a été enregistré.");
        accueil();
    }).fail(function(msg) {
        console.log(msg);
        alert("Erreur lors de l'enregistrement du vote.");
    });
}



function resultat() {  
    $.ajax({
    type: "POST",
    url: "resultatscrutin.php",
    
    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}

function modifier() {  
    $.ajax({
    type: "POST",
    url: "modifierscrutin.php",
    
    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}

function accueil() {  
    $.ajax({
    type: "POST",
    url: "pagedaccueil.php",
    
    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}

function connexion() {
    $.ajax({
    type: "POST",
    url: "connexion.php",

    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}

function inscription() {  
    $.ajax({
    type: "POST",
    url: "inscription.php",
    
    }).done(function(msg) {
        $("#contents").html(msg);
    }).fail(function(msg) {
        console.log(msg);
        alert("error");
    });
}


function deleteScrutin(scrutinId) {
    $.ajax({
        type: "POST",
        url: "deletescrutin.php",
        data: { scrutinId: scrutinId },
        dataType: "json",
    }).done(function(msg) {
        $("#contentsmodifier").html(msg); 
        alert("Votre scrutin a été supprimé.");
        accueil();
    }).fail(function(msg) {
        console.log(msg);
        alert("Erreur.");
    });
}



function endScrutin(scrutinId) {
    $.ajax({
        type: "POST",
        url: "endscrutin.php",
        data: { scrutinId: scrutinId },
        dataType: "json",
    }).done(function(msg) {
        $("#contentsmodifier").html(msg); 
        alert("Votre scrutin a été cloturé.");
        accueil();
    }).fail(function(msg) {
        console.log(msg);
        alert("Erreur.");
    });
}

