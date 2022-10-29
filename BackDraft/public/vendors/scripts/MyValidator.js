function fichier(myFile){

    var file = myFile.files[0];
    var filename = file.name;
    document.getElementById('cvdoc_label').innerHTML=filename;
}




function verif(){
    var valid = true;

    var letters = /^[a-zA-Z]+[a-zA-Z]+$/;

    var nom = document.getElementById("nom").value;
    if(letters.test(nom) == false){
        document.getElementById("nom").value = '';
        document.getElementById("nom").classList.add('form-control-danger');
        document.getElementById("nom").focus();
        document.getElementById("nom_war").hidden = false;
        valid = false;
    }
    else
    {
        if ( document.getElementById("nom").classList.contains('form-control-danger') )
        {document.getElementById("nom").classList.toggle('form-control-danger');
            document.getElementById("nom_war").hidden = true;
        }
    }

    var prenom = document.getElementById("prenom").value;
    if(letters.test(prenom) == false){
        document.getElementById("prenom").value = '';
        document.getElementById("prenom").classList.add('form-control-danger');
        document.getElementById("prenom").focus();
        document.getElementById("prenom_war").hidden = false;
        valid = false;
    }
    else
    {
        if ( document.getElementById("prenom").classList.contains('form-control-danger') )
        {document.getElementById("prenom").classList.toggle('form-control-danger');
            document.getElementById("prenom_war").hidden = true;
        }
    }

    var allowedExtensions = /(\.pdf|\.docx)$/i;
    var Filename =document.getElementById('cvdoc_label').innerHTML;
    if(allowedExtensions.test(Filename) == false){
        document.getElementById("cvdoc").value = '';
        document.getElementById('cvdoc_label').innerHTML = 'Choisir Fichier';
        document.getElementById("cvdoc_label").classList.add('form-control-danger');
        document.getElementById("cvdoc").focus();
        document.getElementById("cvdoc_war").hidden = false;
        valid = false;
    }
    else
    {
        if ( document.getElementById("cvdoc_label").classList.contains('form-control-danger') )
        {document.getElementById("cvdoc_label").classList.toggle('form-control-danger');
            document.getElementById("cvdoc_war").hidden = true;
        }
    }



    if(!valid){
        return false;
    }
    Push.create("🔔 JobBook 🔔",{
        body: " ✏ ✏️Fichier Uploadee ✔✔ ",
        timeout: 10000,


    });

    document.getElementById("form").submit();
    return true;
}