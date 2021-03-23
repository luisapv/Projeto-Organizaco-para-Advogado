function addLi(contener,param){
    $(contener).append(param);
}

function dataAtual(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){
	    dd='0'+dd;
	} 
	if(mm<10){
	    mm='0'+mm;
	} 
	return dd+'/'+mm+'/'+yyyy;
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function getSiglaEstado(e){
	$.post('/require/php/lp/jpFuncoes.php',
		{
			status:'UF',
			cod:e
		},
		function(res)
		{
			if(res)
				return res;
		}
	);
}

String.prototype.replaceAll = function(de, para){
    var str = this;
    var pos = str.indexOf(de);
    while (pos > -1){
		str = str.replace(de, para);
		pos = str.indexOf(de);
	}
    return (str);
}

function DateTables(){
	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		"date-br-pre": function ( a ) {
			if (a == null || a == "") {
				return 0;
			}
			var brDatea = a.split('/');
			return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
		},
		"date-br-asc": function ( a, b ) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},
		"date-br-desc": function ( a, b ) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	});
}