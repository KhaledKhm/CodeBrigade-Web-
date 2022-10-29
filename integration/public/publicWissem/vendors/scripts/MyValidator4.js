function fichier(myFile){

    var file = myFile.files[0];
    var filename = file.name;
    document.getElementById('cvdoc_label').innerHTML=filename;
}




function verif(){
    var valid = true;



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
        body: " ✏ ✏️Cv Modifiee ✔✔ ",
        timeout: 10000,


    });

    document.getElementById("form").submit();
    return true;
}