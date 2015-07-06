function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    /*for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }*/
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "imprimir");
    hiddenField.setAttribute("value", params);
    form.appendChild(hiddenField);
    form.submit();
}


function setearCampoForm( tabla ){
 var form = document.getElementById("form_imprimir");
 form.reset();
 var hiddenField = document.createElement("input");
 hiddenField.setAttribute("type", "hidden");
 hiddenField.setAttribute("name", "imprimir");
 var filas="";
 var arrayLength = tabla.length;
 for (var i = 0; i < arrayLength; i++) {
    if(i %2 ==0){
	filas+= "<tr class='alt'>"+tabla[i].innerHTML+"</tr>";
    }
    else{
	filas+="<tr>"+tabla[i].innerHTML+"</tr>";
    }
 }
 alert(tabla.length);
 if(tabla.length!=0){//solo seteo el campo si habia cursos para ese alumno
  hiddenField.setAttribute("value",filas); 
 }
 else{
   hiddenField.setAttribute("value","vacio"); 
 }
 form.appendChild(hiddenField);	
}
$(document).ready( function() { 

	var formImprimir= document.getElementById("form_imprimir");
	var tabla = document.getElementById("grades");
	var filasTabla = document.getElementsByClassName("filas");	
	//seteo el valor inicial del pdf	
	setearCampoForm(filasTabla);
	// me encargo de que cada cambio a la tabla tambien modifique lo que se usa para armar el 
	for(var i= 0;i < filasTabla.length; i++){
		filasTabla[i].onchange= function(){ var filasTabla = document.getElementsByClassName("filas");
					setearCampoForm(filasTabla);};
	}
        tabla.onchange= function(){ var filasTabla = document.getElementsByClassName("filas");
					setearCampoForm(filasTabla);};
	var combobox = 	document.getElementsByName("grades_length")[0];
	combobox.onchange= function(){var filasTabla = document.getElementsByClassName("filas");
					setearCampoForm(filasTabla);}
	var ant=document.getElementById("grades_previous");
	ant.onclick=function(){var filasTabla = document.getElementsByClassName("filas");
					setearCampoForm(filasTabla);}
	var next=document.getElementById("grades_next");
	next.onclick=function(){var filasTabla = document.getElementsByClassName("filas");
					setearCampoForm(filasTabla);}
        var buscar= document.getElementById("grades_filter").childNodes[0].childNodes[1];
	buscar.onblur=function(){filasTabla = document.getElementsByClassName("filas");
					setearCampoForm(filasTabla);}
}
);
