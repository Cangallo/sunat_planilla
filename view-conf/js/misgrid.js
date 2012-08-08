// JavaScript Document


function tabla_Remuneracion(){
	
        $("#list").jqGrid({
            url:'sunat_planilla/controller/PeriodoRemuneracionController.php?oper=cargar_tabla',
            datatype: 'json',
            colNames:['','ID','Descripcion','Tasa'],
            colModel :[
				{name: 'myac', width:80, fixed:true, sortable:false, resize:false, formatter:'actions',
					formatoptions:{keys:true}
				},
				{
				name:'cod_periodo_remuneracion',
				sortable:true,
				key : true,
				index:'cod_periodo_remuneracion',
				width:55
				},		
  	
                {
                    name:'descripcion',
                    index:'descripcion',
                    search:true, 
					sortable:false,
                    editable:false,
                    width:120, 
                    align:'center' 
                },
                {
                    name:'tasa_pago', 
                    index:'tasa_pago',
                    search:true,
					sortable:false,
                    editable:true,
					editrules:{required:true},
                    width:90,
                    align:'center'
                }		


            ],
            pager: '#pager',
			heigth:'200px',
            rowNum:10,
            rowList:[10,20,30],
            sortname: 'cod_periodo_remuneracion',
            sortorder: 'asc',
            viewrecords: true,
			editurl: "sunat_planilla/controller/PeriodoRemuneracionController.php", 
            caption: 'Periodos de Remuneracion',
            //toolbar: [true,"top"],
            //multiselect: true,
            //hiddengrid: false,
			//jsonReader: {
			//repeatitems : false
			//},

			
        });
		
	
     //--- PIE GRID
	//jQuery("#list").jqGrid('navGrid','#pager',{add:false,edit:true,del:false,search:true});
	//---------

}






