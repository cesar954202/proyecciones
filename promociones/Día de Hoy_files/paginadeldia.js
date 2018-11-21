function fillElem(id, value) {
   var e = document.getElementById(id);
   if (e != null) {
      e.innerHTML = value;
      }
   }

function rellenaCalendario()
{
	var miFechaActual = new Date();
	var dia_del_mes = miFechaActual.getDate();
	var num_mes = parseInt(miFechaActual.getMonth()) + 1;
	var ano = miFechaActual.getFullYear();
	var num_dia_semana = miFechaActual.getDay();
	var hora = miFechaActual.getHours();
	var minutos = miFechaActual.getMinutes();
	var segundos = miFechaActual.getSeconds();

	var dia_semana;
	switch (num_dia_semana) {
	   case 1 : dia_semana = "Lunes";
	   break;
	   case 2 : dia_semana = "Martes";
	   break;
	   case 3 : dia_semana = "Miercoles";
	   break;
	   case 4 : dia_semana = "Jueves";
	   break;
	   case 5 : dia_semana = "Viernes";
	   break;
	   case 6 : dia_semana = "Sabado";
	   break;
	   case 0 : dia_semana = "Domingo";
	   break;
	   default : dia_semana = "Error dia";
	   break;
	   }
	var mes;
	switch(num_mes) {
	   case 1 : mes = "Enero";
	   break;
	   case 2 : mes = "Febrero";
	   break;
	   case 3 : mes = "Marzo";
	   break;
	   case 4 : mes = "Abril";
	   break;
	   case 5 : mes = "Mayo";
	   break;
	   case 6 : mes = "Junio";
	   break;
	   case 7 : mes = "Julio";
	   break;
	   case 8 : mes = "Agosto";
	   break;
	   case 9 : mes = "Septiembre";
	   break;
	   case 10 : mes = "Octubre";
	   break;
	   case 11 : mes = "Noviembre";
	   break;
	   case 12 : mes = "Diciembre";
	   break;
	   default : mes = "Error mes";
	   break;
	   }
	var mes_minus = mes.toLowerCase();
	var dia_nuevo = "05";
	if ((dia_del_mes > 0) && (dia_del_mes < 10)) {
	   dia_nuevo = "0" + dia_del_mes;
	   }
	else {
	   dia_nuevo = dia_del_mes;
	   }
	var direccion = "http://www.euroresidentes.com/calendario/dia-" + ano + "/" + mes_minus + "/" + dia_nuevo + ".htm";


   fillElem('diasemana', dia_semana);
   fillElem('dia', dia_del_mes);
   fillElem('mesano', mes + " " + ano);
   fillElem('direccion', '<a href="http://www.euroresidentes.com/hoy/diadehoy.html" rel="nofollow" target=\"_blank\">HOY</a>');
}

//reloj
function tick() {
   var hours, minutes, seconds;
   var intHours, intMinutes, intSeconds;
   var today;
   today = new Date();
   intHours = today.getHours();
   intMinutes = today.getMinutes();
   intSeconds = today.getSeconds();
   hours = "" + intHours + ":";
   if (intMinutes < 10) {
      minutes = "0" + intMinutes + ":";
      }
   else {
      minutes = intMinutes + ":";
      }
   if (intSeconds < 10) {
      seconds = "0" + intSeconds + " ";
      }
   else {
      seconds = intSeconds + " ";
      }
   fillElem('Clock', hours + minutes + seconds);
   window.setTimeout("tick();", 100);
   }



function addLoadEvent(func) {
   var oldonload = window.onload;
   if (typeof window.onload != 'function') {
      window.onload = func;
      }
   else {
      window.onload = function() {
         if (oldonload) {
            oldonload();
            }
         func();
         }
      }
   }

addLoadEvent(rellenaCalendario);
addLoadEvent(tick);
