
function changedate(datedebut){
    var date=datedebut.value;

    jQuery('#datetimepicker1').datetimepicker({
        startDate:date,
        minDate:date,
    });
}

function changedate2(datedebut){
    var date=datedebut.value;

    jQuery('#datetimepicker').datetimepicker({
        startDate:date,
        maxDate:date,
    });
}
function verif(){
    var valid = true;


    var libelle = document.getElementById("libelle").value;
    if(libelle == ""){

        document.getElementById("libelle").classList.add('form-control-danger');
        document.getElementById("libelle").focus();
        document.getElementById("libelle_war").hidden = false;
        valid = false;
    }
    else
    {
        if ( document.getElementById("libelle").classList.contains('form-control-danger') )
        {document.getElementById("libelle").classList.toggle('form-control-danger');
            document.getElementById("libelle_war").hidden = true;
        }
    }
    var description = document.getElementById("description").value;
    if(description == ""){

        document.getElementById("description").classList.add('form-control-danger');
        document.getElementById("description").focus();
        document.getElementById("description_war").hidden = false;
        valid = false;
    }
    else
    {
        if ( document.getElementById("description").classList.contains('form-control-danger') )
        {document.getElementById("description").classList.toggle('form-control-danger');
            document.getElementById("description_war").hidden = true;
        }
    }

    var nbrParticipant = document.getElementById("nbrParticipant").value;
    if(nbrParticipant == ""){

        document.getElementById("nbrParticipant").classList.add('form-control-danger');
        document.getElementById("nbrParticipant").focus();
        document.getElementById("nbrParticipant_war").hidden = false;
        valid = false;
    }
    else
    {
        if ( document.getElementById("nbrParticipant").classList.contains('form-control-danger') )
        {document.getElementById("nbrParticipant").classList.toggle('form-control-danger');
            document.getElementById("nbrParticipant_war").hidden = true;
        }
    }




    if(!valid){
        return false;
    }
    Push.create("🔔 JobBook 🔔",{
        body: " ✏ ✏️Formation Modifiee ✔✔ ",
        timeout: 10000,


    });


    document.getElementById("form").submit();
    return true;
}