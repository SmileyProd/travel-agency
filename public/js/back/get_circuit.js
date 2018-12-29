$(document).ready( function() {
    $("#search_by_id_id").keyup(function() {
        $.get('http://localhost:8000/admin/circuit/json/'+this.value, function (data) {

            $("#idCircuit").text(data["id"]);
            $("#description").text(data["description"]);
            $("#departureCountry").text(data["departureCountry"]);
            $("#departureCity").text(data["departureCity"]);
            $("#arrivalCity").text(data["arrivalCity"]);
            $("#duration").text(data["duration"] + ' jours');
            $("#category").text(data["category"]);

            var tbodyStepsElt = document.querySelector('#js-tbody-steps');
            tbodyStepsElt.innerHTML = "";
            $.each(data["steps"], function(index, step) {
                var trElt = document.createElement("tr");
                $.each(step, function(attr, value) {
                    if(attr !== "circuit" && attr !=='id') {
                        var tdElt=document.createElement("td");
                        tdElt.innerHTML=value;
                        trElt.appendChild(tdElt);
                    }
                })
                tbodyStepsElt.appendChild(trElt);
            })

            var tbodyProgramsElt = document.querySelector('#js-tbody-programs');
            tbodyProgramsElt.innerHTML = "";
            $.each(data["programs"], function(index, program) {
                var trElt = document.createElement("tr");
                $.each(program, function(attr, value) {
                    if(attr !== "circuit" && attr !=='id') {
                        var tdElt=document.createElement("td");
                        if(attr === "departureDate") {
                            date = new Date(value['date']);
                            tdElt.innerHTML=date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() ;
                        }
                        else tdElt.innerHTML=value+(attr === "price" ? "€" : "");
                        trElt.appendChild(tdElt);
                    }
                })
                tbodyProgramsElt.appendChild(trElt);
            })

        }).fail(function() {
                $("#idCircuit").text("");
                $("#description").text("")
                $("#departureCountry").text("");
                $("#departureCity").text("");
                $("#arrivalCity").text("");
                $("#duration").text("");
                $("#category").text("");
                $("#js-tbody-steps").text("");
                $("#js-tbody-programs").text("");
            })
    })
})