<?php
/*paperstore*/




/** Administración **/
define("LST_USER", 				"lst_users"); 
define("FRM_CONTACT", 			"frm_contact");
define("LST_PROYECT", 			"lst_proyect"); 
define("FRM_PROYECT", 			"frm_proyect");
define("LST_PDV", 				"lst_pdv"); 
define("FRM_PDV", 				"frm_pdv");
define("LST_CGF", 				"lst_cgf"); 
define("LST_BAFA", 				"lst_bafa"); 
define("LST_TRUCK", 			"lst_truck");
define("FRM_TRUCK", 			"frm_truck");
define("LST_PAYMENT", 			"lst_payment");
define("LST_DEPOSIT", 			"lst_deposit");
define("LST_INVOICE", 			"lst_invoice");
define("LST_PAYING", 			"lst_paying");
define("LST_TASK",	 			"lst_task");
define("LST_ACTIVITIES",		"lst_activities");
define("LST_PDV_TYPE",			"lst_pdv_type");

define("LST_PROSPECT", 			"lst_prospect");

/** Catálogos **/

define("LST_CITY", 				"lst_city");
 
define("LST_COMPANIES", 		"lst_companies"); 
define("LST_STATE", 			"lst_state"); 
define("LST_EVIDENCE_TYPE", 	"lst_evidence_type"); 
define("LST_TASK_OMITION", 		"lst_task_omition"); 
define("LST_VISIT_OMITION", 	"lst_visit_omition"); 
define("LST_SUPPLIER", 			"lst_suppplier"); 
define("LST_REGION", 			"lst_region");   
define("LST_FORM_TYPE", 		"lst_pry_form_type");

/** Proyects **/
define("PRY_DASHBOARD", 		"pry_dashboard");
define("PRY_INFO", 				"pry_info"); 
define("PRY_USER",	 			"pry_user"); 
define("PRY_PDV", 				"pry_pdv");
define("PRY_PRODUCT", 			"pry_product");
define("PRY_CYCLE", 			"pry_cycle"); 
define("PRY_MEDIA", 			"pry_media");
//define("PRY_TYPE_FORMS", 		"pry_form_type");
define("PRY_FORMS",				"pry_forms"); 
define("PRY_FRM_FORM",			"pry_form_frm"); 
define("PRY_EVIDENCE_TYPE", 	"pry_evidence_type");
define("PRY_TASK_OMITION", 		"pry_task_omition");
define("PRY_VISIT_OMITION", 	"pry_visit_omition");
define("PRY_SUPPLIER",			"pry_supplier"); 
define("LST_VISIT", 			"lst_visits"); 
define("LST_VISITS", 			"lst_visits"); 
define("LST_ORDER", 			"lst_order");
define("PRY_SUPERVISORS", 		"pry_supervisors");
define("PRY_PENDING", 			"pry_pendientes");
define("PRY_REPORTS", 			"pry_reportes"); 

define("PRY_TYPE_FORMS",		"pry_tipos_formularios"); 
define("PRY_FREE_DAYS", 		"pry_free_days");

define("PRY_VISIT_FRM", 		"pry_visit_frm");
define("PRY_VISITS", 			"lst_visits");
define("PRY_VISIT", 			"lst_visits");

/*<paper store>*/
define("HOME", 					"dashboard");
define("LOGIN",	 				"login");

define("LST_PRODUCT", 			"lst_product"); 
define("FRM_PRODUCT", 			"frm_product");
define("PAPERSTORE",			"paperstore");
define("LST_BAR_STOCK",			"lst_bar_stock");
define("LST_WAREHOUSE",			"lst_warehouse");
define("LST_COMPUTER",			"lst_pc");
define("LEASING",				"leasing");
define("LST_LEASING",			"lst_leasing");
define("FRM_SELL",				"frm_sell");
define("LST_SERVICE",			"lst_service");
define("FRM_SERVICE",			"frm_service");

define("LST_DOWNLOADS", 		"download");

define("ERR_403", 				"403");
define("ERR_404", 				"404");

/** Configuración **/
define("FRM_APPEARANCE",		"frm_appearance");
define("FRM_VERSION_CTRL",		"frm_version_ctrl");
define("FRM_VERSION_APP",		"frm_version_app");
define("FRM_MESSAGING",			"frm_messaging");
define("FRM_CONTACT_META", 		"frm_contact_meta");
define("FRM_PRODUCT_META", 		"frm_product_meta");
define("FRM_PDV_META", 			"frm_pdv_meta");

define("FRM_SITEMAP", 			"frm_sitemap");
define("FRM_TAXES", 			"frm_taxes");

define("ADMIN_CATALOGUE", 		"admin_catalogue");

define("REPORT_BALANCE", 		"report_balance");

/*</paper store>*/

$uiCommand = array(); 	//Controla los permisos			Titulo						PHP													JS						CSS				AJAX			MODALS
$uiCommand[LOGIN]			= 	array( 	array(1,2,3,4,5), 	"Iniciar Sesion", 			"frm.login.php",									"",						"",				"",				""		);
$uiCommand[HOME]			= 	array( 	array(1,2,3,4,5),  	"Dashboard", 				DIRECTORY_VIEWS.DIRECTORY_BASE."dashboard.php", 	"",						"",				"",				""		);
$uiCommand[LST_PRODUCT]  	=	array(	array(1,2),  		"Productos", 				DIRECTORY_VIEWS."admin/lst.product.php", 			array("admin.product.js"),	"",				"",			array("mdl.product.php","mdl.admin.bafa.php",  "mdl.admin.product.php","mdl.frm.upload.product.php") );
$uiCommand[PAPERSTORE]  	=	array(	array(1,2,3,4,5),  	"Papeleria", 				DIRECTORY_VIEWS."admin/admin.paperstore.php", 		array("admin.paperstore.js"),	"",				"",		array("mdl.sell.php", "mdl.admin.sell.php") );
$uiCommand[LST_USER]		= 	array( 	array(1 ),			"Usuarios", 				DIRECTORY_VIEWS."admin/usuarios.php",  				array("admin.users.js"),	"",				"",			array("mdl.user.php","mdl.admin.user.php") );
$uiCommand[LST_BAR_STOCK]  	=	array(	array(1,2),		  	"Mostrador", 				DIRECTORY_VIEWS."admin/lst.bar.stock.php", 			array("admin.bar.stock.js"),	"",				"",		array("mdl.admin.bar.supply.php", "mdl.supply.list.php", "mdl.frm.upload.product.php") );
$uiCommand[LST_WAREHOUSE]  	=	array(	array(1,2),		  	"Bodega", 					DIRECTORY_VIEWS."admin/lst.warehouse.php", 			array("admin.warehouse.js"),	"",				"",		array("mdl.admin.warehouse.php") );
$uiCommand[LST_COMPUTER]  	=	array(	array(1,2),		  	"Computadoras", 			DIRECTORY_VIEWS."admin/lst.computer.php", 			array("admin.computer.js"),	"",				"",			array("mdl.admin.computer.php") );
$uiCommand[LEASING]  		=	array(	array(1,2),		  	"Ciber",		 			DIRECTORY_VIEWS."leasing/leasing.php", 				array("admin.leasing.js"),	"",				"",			array("mdl.paybox.php") );
$uiCommand[FRM_SITEMAP]  	=	array(	array(1,2),		  	"Configurar Ciber",		 	DIRECTORY_VIEWS."config/frm.sitemap.php", 			array("admin.sitemap.js"),	"",				"",			array("mdl.admin.sitemap.php", ) );
$uiCommand[FRM_TAXES]  		=	array(	array(1,2),		  	"Configurar Tarifa Ciber",	DIRECTORY_VIEWS."config/frm.tax.php", 				array("admin.tax.js"),	"",				"",				array("mdl.admin.tax.php" ) );
$uiCommand[ADMIN_CATALOGUE] = 	array(	array(1,2),  		"Administración de Catálogo",DIRECTORY_VIEWS."admin/admin.catalogues.php", 		array("admin.catalogues.js"), "",			""		);
$uiCommand[FRM_SELL]		= 	array(	array(1,2),  		"Registro de Venta",		DIRECTORY_VIEWS."admin/admin.sell.php", 			array("admin.sell.js"), 		"",		"",				array("mdl.admin.tax.php", "mdl.paybox.sell.php", "mdl.srch.sell.product.php" ) 		);
$uiCommand[LST_SERVICE]		= 	array(	array(1,2),  		"Servicios",				DIRECTORY_VIEWS."admin/admin.service.php", 			array("admin.service.js"), 		"",		"",				array("mdl.admin.service.php") 		);
$uiCommand[FRM_SERVICE]		= 	array(	array(1,2),  		"Productos por Servicio",	DIRECTORY_VIEWS."admin/admin.frm.service.php", 		array("admin.service.js"), 		"",		"",				array("mdl.admin.frm.service.php") 		);
$uiCommand[LST_LEASING]		= 	array(	array(1,2),  		"Rentas del Ciber",			DIRECTORY_VIEWS."leasing/lst.leasing.php", 			array("leasing.js"), 		"",		"",					array("mdl.admin.frm.service.php") 		);

/*CATALOGUES*/
$uiCommand[ADMIN_CATALOGUE	. "&cat=brand"] 			= array(array(1));
$uiCommand[ADMIN_CATALOGUE	. "&cat=state"] 			= array(array(1));
$uiCommand[ADMIN_CATALOGUE	. "&cat=country"] 			= array(array(1));
$uiCommand[ADMIN_CATALOGUE	. "&cat=evidence_type"] 	= array(array(1));
$uiCommand[ADMIN_CATALOGUE	. "&cat=task_omition_cause"] = array(array(1));
$uiCommand[ADMIN_CATALOGUE	. "&cat=visit_reschedule_cause"] = array(array(1));
$uiCommand[ADMIN_CATALOGUE	. "&cat=region"] 			= array(array(1)); 

//$uiCommand[LST_USER]	= array( 	array(1 ),			"Usuarios", 				DIRECTORY_VIEWS."admin/usuarios.php",  			array("admin.users.js"),	"",				"",				""     );
//$uiCommand[FRM_CONTACT_META]= array(array(1), 			"Información de Contacto ", DIRECTORY_VIEWS."admin/frm.contact_meta.php",  	array("admin.contact_meta.js"), "",			"",				""		);
$uiCommand[FRM_CONTACT] = array(	array(1,2,3), 		"Edición de Contacto",  	DIRECTORY_VIEWS."agenda/frm.contact.php",  		array("contact.js"),		"",				"",				""		); 
//$uiCommand[FRM_CONTACT_META]=array(	array(1), 			"Opciones de Contacto", 	DIRECTORY_VIEWS."admin/frm.contact_meta.php",   array("admin.contact_meta.js"),"",			"",				""		);
$uiCommand[LST_PROYECT]  =	array(	array(1),  			"Proyectos", 				DIRECTORY_VIEWS."admin/lst_proyect.php", 		array("admin.proyect.js" , "proyect.js"),"","",			array("mdl.proyect.php") );
$uiCommand[FRM_PROYECT]	 =	array(  array(1,2),			"Edición de Proyecto",		DIRECTORY_VIEWS."admin/frm.proyect.php",		array("admin.proyect.js"),	"",				"",				""		);
$uiCommand[FRM_PRODUCT]	 =	array(  array(1,2),			"Edición de Producto",		DIRECTORY_VIEWS."admin/frm.product.php",		array("admin.product.js"),	"",				"",				""		); 
$uiCommand[LST_PDV] 	 =	array(	array(1),  			"PDVs", 					DIRECTORY_VIEWS."admin/lst.pdv.php", 			array("admin.pdv.js"),		"",				"",			array("mdl.pdv.php","mdl.admin.cgf.php", "mdl.frm.upload.pdv.php") );
$uiCommand[FRM_PDV]		 =	array(  array(1,2),			"Edición de PDV",			DIRECTORY_VIEWS."admin/frm.pdv.php",			array("admin.pdv.js"),		"",				"",				""		);

$uiCommand[LST_TRUCK] 	 =	array(	array(1),  			"Camionetas",				DIRECTORY_VIEWS."admin/lst.truck.php", 			array("admin.truck.js"),	"",				"",			array("mdl.pdv.php","mdl.admin.cgf.php") );
$uiCommand[FRM_TRUCK]	 =	array(  array(1,2),			"Edición de Camioneta",		DIRECTORY_VIEWS."admin/frm.truck.php",			array("admin.truck.js"),	"",				"",				""		);
$uiCommand[LST_CITY] 	 = array(	array(1),  			"Ciudades", 				DIRECTORY_VIEWS."admin/lst.city.php", 			array("admin.city.js"),		"",				"",				"" 		);

$uiCommand[LST_CGF] 	 =	array(	array(1),  			"Canal, Grupo, Formato", 	DIRECTORY_VIEWS."admin/lst.cgf.php", 			array("admin.cgf.js"),		"",				"",			array( "mdl.admin.cgf.php" ) );
$uiCommand[LST_BAFA]  	 =	array(	array(1),  			"Marca y Familia", 			DIRECTORY_VIEWS."admin/lst.bafa.php", 			array("admin.bafa.js"),		"",				"",			array( "mdl.admin.bafa.php") );
$uiCommand[LST_PAYMENT]  =	array(	array(1),  			"Pagos",		 			DIRECTORY_VIEWS."admin/lst.payment.php", 		array("payment.js"),		"",				"",			array( "mdl.payment.php") );
$uiCommand[LST_DEPOSIT]  =	array(	array(1),  			"Depósitos",		 		DIRECTORY_VIEWS."admin/lst.deposit.php", 		array("deposit.js"),		"",				"",			array( "mdl.deposit.php") );
$uiCommand[LST_INVOICE]  =	array(	array(1),  			"Facturas",		 			DIRECTORY_VIEWS."admin/lst.invoice.php", 		array("admin.invoice.js","invoice.js"),		"",				"",			array( "mdl.frm.upload.invoice.php","mdl.invoice.php") );
$uiCommand[LST_PAYING]   =	array(	array(1),  			"Liquidación",		 		DIRECTORY_VIEWS."admin/lst.paying.php", 		array("paying.js"),			"",				"",			array() );
$uiCommand[LST_ACTIVITIES] =array(	array(1),  			"Actividades",				DIRECTORY_VIEWS."admin/lst.activity.php", 		array("admin.activity.js"),	"",				"",			array( "mdl.activity.php" , "mdl.admin.activity.php" , "mdl.admin.activity.type.php") );
$uiCommand[LST_TASK] 	 =	array(	array(1),  			"Tareas",					DIRECTORY_VIEWS."admin/lst.task.type.php", 			array("admin.task.type.js"),		"",		"",			array("mdl.admin.task.type.php", "mdl.task.type.php" ,"mdl.admin.tasktype.activity.php", "mdl.tasktype.activity.php") );
$uiCommand[LST_PDV_TYPE]  =	array(	array(1),  			"Tipos de PDV y Tareas",	DIRECTORY_VIEWS."admin/lst.pdv.type.php", 			array("admin.pdv.type.js"),		"",		"",			array("mdl.admin.pdv.type.php", "mdl.admin.pdvtype.tasktype.php", "mdl.pdv.type.task.type.php") );

/** Configuración **/
$uiCommand[FRM_APPEARANCE]	= array( array(1),  		"Apariencia", 				DIRECTORY_VIEWS."config/frm.appearance.php", 		"",						"",				"",				""		);
$uiCommand[FRM_VERSION_APP] = array( array(1), 			"Versión de App",  			DIRECTORY_VIEWS."config/frm.version_app.php",		"",						"",				"",				""		);
$uiCommand[FRM_VERSION_CTRL]= array( array(1), 			"Versión de Backend", 		DIRECTORY_VIEWS."config/frm.version_backend.php",   "",						"",				"",				""		);
  
$uiCommand[FRM_CONTACT_META]= array(	array(1),		"Información de Contacto ", DIRECTORY_VIEWS."config/frm.contact_meta.php",  	array("admin.contact_meta.js"), "",			"",				""		);
$uiCommand[FRM_PRODUCT_META]= array(	array(1),		"Información de Producto ", DIRECTORY_VIEWS."config/frm.product_meta.php",  	array("admin.product_meta.js"), "",			"",				""		);  
$uiCommand[FRM_PDV_META]	= array(	array(1),		"Información de PDV ", 		DIRECTORY_VIEWS."config/frm.pdv_meta.php",  		array("admin.pdv_meta.js"), "",				"",				""		);

/*** Catálogos ****/
$uiCommand[ADMIN_CATALOGUE] = array(	array(1),  		"Administración de Catálogo",DIRECTORY_VIEWS."admin/admin.catalogues.php", 	array("admin.catalogues.js"), "",			""		);
$uiCommand[LST_FORM_TYPE] 	= array(	array(1),  		"Tipos de Formularios", 	DIRECTORY_VIEWS."proyect/lst_type_form.php", 	array("admin.pry.type.form.js"),	"",		""		);

$uiCommand[ADMIN_CATALOGUE] = array(	array(1),  		"Administración de Catálogo",DIRECTORY_VIEWS."admin/admin.catalogues.php", 	array("admin.catalogues.js"),"",			"",				""		);
$uiCommand[LST_SUPPLIER] 	= array(	array(1),  		"Mayoristas", 				DIRECTORY_VIEWS."admin/lst_supplier.php", 		array("admin.supplier.js"),	"",				"",			array("mdl.supplier.php","mdl.admin.supplier.php") );

/*** Proyect ****/
$uiCommand[PRY_DASHBOARD]	= array(	array(1),  		"Dashboard de Proyecto",	DIRECTORY_VIEWS."proyect/dashboard.php", 		array("proyect.js"), 		"",				"",				""		);
$uiCommand[PRY_INFO]		= array(	array(1),  		"Información de Proyecto",	DIRECTORY_VIEWS."proyect/info.php", 			array("proyect.js"), 		"",				"",				""		);
 
$uiCommand[PRY_CYCLE]		= array(	array(1,2),  	"Cíclos de Proyecto",		DIRECTORY_VIEWS."proyect/lst.cycle.php", 		array("admin.proyect.js"), 						"",		""		);
$uiCommand[PRY_USER]		= array(	array(1,2),  	"Usuarios de Proyecto",		DIRECTORY_VIEWS."proyect/lst.user.php", 		array("admin.proyect.js", "user.js"), 			"",		""		);
$uiCommand[PRY_PDV]			= array(	array(1,2),  	"PDVs de Proyecto",			DIRECTORY_VIEWS."proyect/lst.pdv.php", 			array("admin.proyect.js", "pdv.js"), 			"",		""		);
$uiCommand[PRY_PRODUCT]		= array(	array(1,2),  	"Productos de Proyecto",	DIRECTORY_VIEWS."proyect/lst.product.php", 		array("admin.proyect.js", "product.js"), 		"",		""		);
$uiCommand[PRY_FREE_DAYS]	= array(	array(1,2),  	"Días Libres",			DIRECTORY_VIEWS."proyect/lst.free.day.php", 		array("admin.free.day.js"),	"",		""		);
$uiCommand[PRY_FORMS]		= array(	array(1,2),  	"Formularios de Proyecto",	DIRECTORY_VIEWS."proyect/lst.form.php", 		array("admin.pry.type.form.js", "admin.pry.form.js"),	"",		""		);
$uiCommand[PRY_FRM_FORM]	= array(	array(1,2),  	"Edición de Formulario",	DIRECTORY_VIEWS."proyect/frm.form.php", 		array("admin.proyect.js", "admin.pry.form.js"), "",		""		);
$uiCommand[PRY_TYPE_FORMS]	= array(	array(1,2),  	"Tipos de Formulario de Proyecto",	DIRECTORY_VIEWS."proyect/lst.type.form.php", 		array("admin.proyect.js", "admin.pry.type.form.js"), "",		""		);
$uiCommand[PRY_MEDIA]		= array(	array(1,2), 	"Archivos de Proyecto",		DIRECTORY_VIEWS."proyect/lst.media.php", 		array("admin.proyect.js"), 						"",		""		);
$uiCommand[PRY_SUPPLIER]	= array(	array(1,2), 	"Mayoristas de Proyecto",	DIRECTORY_VIEWS."proyect/lst.supplier.php", 	array("admin.proyect.js"), 						"",		""		);
$uiCommand[PRY_VISITS]      = array(	array(1,2),     "Visitas", 					DIRECTORY_VIEWS."proyect/frm.visit.php", 		array("admin.visit.js", "visit.js"), 		   	"",		"" 		);
$uiCommand[PRY_EVIDENCE_TYPE] = array(	array(1,2), 	"Tipos de Evidencia",		DIRECTORY_VIEWS."proyect/lst.evidence_type.php", 	array("admin.proyect.js"), "",		""		);
$uiCommand[PRY_TASK_OMITION]  = array(	array(1,2),		"Motivos de Omisión de Tarea",DIRECTORY_VIEWS."proyect/lst.task_omition.php", 	array("admin.proyect.js"), "",		""		);
$uiCommand[PRY_VISIT_OMITION] = array(	array(1,2),		"Motivo de Reagendación",	DIRECTORY_VIEWS."proyect/lst.visit_omition.php", 	array("admin.proyect.js"), "",		""		);
$uiCommand[PRY_CYCLE]		= array(	array(1,2),  	"Cíclos de Proyecto",		DIRECTORY_VIEWS."proyect/lst.cycle.php", 		array("admin.proyect.js"), 	"",				"",				""		);
$uiCommand[PRY_USER]		= array(	array(1,2),  	"Usuarios de Proyecto",		DIRECTORY_VIEWS."proyect/lst.user.php", 		array("admin.proyect.js", "user.js"),"",	"",			array("mdl.user.php")	);
$uiCommand[PRY_PDV]			= array(	array(1,2),  	"PDVs de Proyecto",			DIRECTORY_VIEWS."proyect/lst.pdv.php", 			array("admin.proyect.js", "pdv.js"), "",	"",			array("mdl.pdv.php") 	);
$uiCommand[PRY_PRODUCT]		= array(	array(1,2),  	"Productos de Proyecto",	DIRECTORY_VIEWS."proyect/lst.product.php", 		array("admin.proyect.js", "product.js"),"",	"",				""		);
$uiCommand[PRY_FORMS]		= array(	array(1,2),  	"Formularios de Proyecto",	DIRECTORY_VIEWS."proyect/lst.form.php", 		array("admin.pry.form.js"),	"",				"",				""		);
$uiCommand[PRY_FRM_FORM]	= array(	array(1,2),  	"Edición de Formulario",	DIRECTORY_VIEWS."proyect/frm.form.php", 		array("admin.proyect.js", "admin.pry.form.js"), "",	"", 	""		);
$uiCommand[PRY_TYPE_FORMS]	= array(	array(1,2),  	"Tipos de Formulario ",		DIRECTORY_VIEWS."proyect/lst.type.form.php",	array("admin.proyect.js", "admin.pry.type.form.js"),"","",  ""		);
$uiCommand[PRY_MEDIA]		= array(	array(1,2), 	"Archivos de Proyecto",		DIRECTORY_VIEWS."proyect/lst.media.php", 		array("admin.proyect.js"), 	"",				"",			array("mdl.media.php", "mdl.admin.media.php"));
$uiCommand[PRY_SUPPLIER]	= array(	array(1,2), 	"Mayoristas de Proyecto",	DIRECTORY_VIEWS."proyect/lst.supplier.php", 	array("admin.proyect.js"), 	"",				"",				""		);
$uiCommand[REPORT_BALANCE]	= array(	array(1,2), 	"Balance de Productos",		DIRECTORY_VIEWS."reports/reports.php", 			array("reports.js"), 	"",				"",				""		);


$uiCommand[LST_VISIT]		= array(	array(1,2), 	"Visitas",					DIRECTORY_VIEWS."admin/lst.visit.php", 			array("pry.visit.js","stock.js"), 		"",				"",			array("mdl.frm.upload.visit.php", "mdl.pry.visit.detail.php")	);
$uiCommand[PRY_VISIT_FRM]	= array(	array(1,2), 	"Edición de Visitas",		DIRECTORY_VIEWS."proyect/frm.visit.php", 		array("admin.visit.js", "visit.js"), 		"",				"",			array("mdl.visit.php", "mdl.pry.visit.detail.php")	);

$uiCommand[LST_ORDER]		= array(	array(1,2), 	"Pedidos",					DIRECTORY_VIEWS."admin/lst.order.php", 			array("order.js"), 		"",				"",			array("mdl.order.php")	);

$uiCommand[LST_PROSPECT]	= array(	array(1,2), 	"Prospectos",				DIRECTORY_VIEWS."admin/lst.prospect.php", 			array("prospect.js"), 		"",				"",			array("mdl.prospect.php")	);

$uiCommand[PRY_EVIDENCE_TYPE]	= array(array(1,2), 	"Tipos de Evidencia",		DIRECTORY_VIEWS."proyect/lst.evidence_type.php", 	array("admin.proyect.js"), "",			"",				""		);
$uiCommand[PRY_TASK_OMITION]	= array(array(1,2),		"Motivos de Omisión de Tarea",DIRECTORY_VIEWS."proyect/lst.task_omition.php", 	array("admin.proyect.js"), "",			"",				""		);
$uiCommand[PRY_VISIT_OMITION]	= array(array(1,2),		"Motivo de Reagendación",	DIRECTORY_VIEWS."proyect/lst.visit_omition.php", 	array("admin.proyect.js"), "",			"",				""		);

$uiCommand[PRY_SUPERVISORS] = array(	array(1),  		"Supervisores",	DIRECTORY_VIEWS."proyect/lst.supervisor.php", 		array("admin.proyect.js"), 			"",				"",				""	);

$uiCommand[LST_DOWNLOADS]	= array(	array(1,2), 	"Descargas",				"downloads.php", 								array(), "",		""	,		""	);
/*** Errors ***/
$uiCommand[ERR_403] =	array(	array(1),  			"Error 403: Restringido", 		DIRECTORY_VIEWS."base/403.php", 		"",	"",	"", "" );
$uiCommand[ERR_404] =	array(	array(1),  			"Error 404: No encontrado",		DIRECTORY_VIEWS."base/404.php", 		"",	"",	"", "" );

/*
$config_menu = array( 'cmd' => 'root', 'lnk' => array(
	array( 	"cmd" => HOME, 		"prf" => array(1,2,3,4,5), 		"lbl" => "Dashboard", 	"ico" => "fa-dashboard", 	"lnk" => array() 	),
	array(  
		"cmd" => "#",
		"lbl" => "Administración", 
		"prf" => array(1),
		"ico" => "fa-shield",
		"lnk" => array(
					array(
						'cmd' => '#',
						'prf' => array(1),
						'lbl' => 'Catálogos',  
						'ico' => "fa-th", 
						'lnk' => array( 
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=company", 			"prf" => array(1),		"lbl" => "Compañías",			 			"ico" => "fa-building-o", 	"lnk" => array() ),
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=state", 			"prf" => array(1),		"lbl" => "Estados",			 				"ico" => "fa-globe", 		"lnk" => array() ),
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=country", 			"prf" => array(1),		"lbl" => "Países",			 				"ico" => "fa-globe", 		"lnk" => array() ), 
							array( "cmd" => ADMIN_CATALOGUE . "&cat=evidence_type",		"prf" => array(1),		"lbl" => "Tipos de evidencia", 				"ico" => "fa-camera", 		"lnk" => array() ), 
							array( "cmd" => ADMIN_CATALOGUE . "&cat=task_omition_cause","prf" => array(1),		"lbl" => "Motivos de omisión de tarea", 	"ico" => "fa-minus-circle", "lnk" => array() ), 
							array( "cmd" => ADMIN_CATALOGUE . "&cat=visit_reschedule_cause", "prf" => array(1),	"lbl" => "Motivos de reagendación",			"ico" => "fa-minus-circle", "lnk" => array() ), 
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=region",	 		"prf" => array(1),		"lbl" => "Regiones",			 			"ico" => "fa-globe", 		"lnk" => array() ),
							array( "cmd" => LST_CGF , 									"prf" => array(1),		"lbl" => "Canal, Grupo, Formato",			"ico" => "fa-sitemap",	 	"lnk" => array() )  ,
							array( "cmd" => LST_BAFA , 									"prf" => array(1),		"lbl" => "Marcas",							"ico" => "fa-barcode",		"lnk" => array() )  ,
							array( "cmd" => LST_CITY , 									"prf" => array(1),		"lbl" => "Ciudades",						"ico" => "fa-globe",		"lnk" => array() )  ,
						) 
					), 
					array( 	'cmd' => LST_SUPPLIER, 	'prf' => array(1), 			'lbl' => 'Mayoristas', 	'ico' => "fa-truck",			'lnk' => array() ),
					//array( 	'cmd' => LST_PROYECT, 	'prf' => array(1,2,3,4), 	'lbl' => 'Proyectos', 	'ico' => "fa-puzzle-piece",  	'lnk' => array() ), 
					array( 	'cmd' => LST_USER, 		'prf' => array(1), 			'lbl' => 'Usuarios',	'ico' => "fa-male", 			'lnk' => array() ), 
				//	array( 	'cmd' => LST_TRUCK, 	'prf' => array(1), 			'lbl' => 'Camionetas',	'ico' => "fa-truck", 			'lnk' => array() ), 
				 )
	),
	array(
			'cmd' => '#',
			'prf' => array(1),
			'lbl' => 'Tareas y Actividades',  
			'ico' => "fa-th", 
			'lnk' => array(
				array( "cmd" => LST_TASK , 									"prf" => array(1),		"lbl" => "Tareas",						"ico" => "fa-globe",		"lnk" => array() )  ,
				array( "cmd" => LST_ACTIVITIES , 							"prf" => array(1),		"lbl" => "Actividades",					"ico" => "fa-barcode",		"lnk" => array() )  ,
			) 
	), 
	array(
		"cmd" => LST_PRODUCT,
		"prf" => array(1),
		"lbl" => "Productos",
		"ico" => "fa-tag",
		"lnk" => array()
	),
	array(
			'cmd' => '#',
			'prf' => array(1),
			'lbl' => 'Puntos de Venta',  
			'ico' => "fa-th", 
			'lnk' => array(
				array( "cmd" => LST_PDV ,			"prf" => array(1),		"lbl" => "Puntos de Venta",		"ico" => "fa-map-marker",	"lnk" => array() ),
				array( "cmd" => LST_PDV_TYPE, 		"prf" => array(1),		"lbl" => "Tipos y Tareas",		"ico" => "fa-barcode",		"lnk" => array() )  ,
			) 
	), 
	array(
		"cmd" => LST_VISIT,
		'prf' => array(1,2),
		"lbl" => "Visitas",
		"ico" => "fa-thumb-tack",
		"lnk" => array()
	),
	array(
		"cmd" => LST_ORDER,
		'prf' => array(1,2,3),
		"lbl" => "Pedidos",
		"ico" => "fa-film",
		"lnk" => array()
	),
	array(
		"cmd" => LST_PAYMENT,
		'prf' => array(1,2,3),
		"lbl" => "Pagos",
		"ico" => "fa-usd",
		"lnk" => array()
	),
	array(
		"cmd" => LST_DEPOSIT,
		'prf' => array(1,2,3),
		"lbl" => "Depósitos",
		"ico" => "fa-money",
		"lnk" => array()
	),
	array(
		"cmd" => LST_INVOICE,
		'prf' => array(1,2,3),
		"lbl" => "Facturas",
		"ico" => "fa-clipboard",
		"lnk" => array()
	),
	array(
		"cmd" => LST_PAYING,
		'prf' => array(1,2,3),
		"lbl" => "Liquidación",
		"ico" => "fa-suitcase",
		"lnk" => array()
	),
	array(
		"cmd" => LST_PROSPECT,
		'prf' => array(1,2,3),
		"lbl" => "Prospectos",
		"ico" => "fa-crosshairs",
		"lnk" => array()
	),
	array(  
		"cmd" => "#",
		"lbl" => "Configuración", 
		'prf' => array(1),
		"ico" => "fa-gear",
		"lnk" => array(
					array( "cmd" => FRM_APPEARANCE, 	"lbl" => "Apariencia", 		"ico" => "fa-tint",		 	"lnk" => array() ),
					array( "cmd" => FRM_VERSION_APP, 	"lbl" => "Aplicación", 		"ico" => "fa-android", 		"lnk" => array() ),
					array( "cmd" => FRM_VERSION_CTRL, 	"lbl" => "Backend",			"ico" => "fa-cloud",	 	"lnk" => array() ),
					 
					array( "cmd" => FRM_CONTACT_META, 	"prf" => array(1),		"lbl" => "Config. Contactos",	"ico" => "fa-group", 	"lnk" => array() ), 
					array( "cmd" => FRM_PRODUCT_META, 	"prf" => array(1),		"lbl" => "Config. Productos",	"ico" => "fa-barcode", 	"lnk" => array() ), 
					array( "cmd" => FRM_PDV_META, 		"prf" => array(1),		"lbl" => "Config. PDVs",		"ico" => "fa-bullseye", "lnk" => array() ) 
				 )
	),
	array(  
		"cmd" => LST_DOWNLOADS,
		"lbl" => "Descargas", 
		'prf' => array(1),
		"ico" => "fa-cloud-download",
		"lnk" => array()
	)
 )
);
*/
$config_menu = array( 'cmd' => 'root', 'lnk' => array(
	array( 	"cmd" => HOME, 			"prf" => array(1,2,3,4,5), 		"lbl" => "Dashboard", 		"ico" => "fa-dashboard", 	"lnk" => array() 	),
	array( 	"cmd" => PAPERSTORE, 	"prf" => array(1,2,3,4,5), 		"lbl" => "Papeleria", 		"ico" => "fa-paperclip", 	"lnk" => array() 	),
	array( 	"cmd" => LEASING,	 	"prf" => array(1,2,3,4,5), 		"lbl" => "Ciber",	 		"ico" => "fa-sitemap", 		"lnk" => array() 	),
	array(	"cmd" => LST_LEASING,	"prf" => array(1,2,3,4,5), 		"lbl" => "Rentas",	 		"ico" => "fa-sitemap", 		"lnk" => array() 	),
	array(
			"cmd" => "#",
			"prf" => array(1,2,3),
			"lbl" => "Administracion",
			"ico" => "fa-shield",
			"lnk" => array
			(
				array( "cmd" => LST_PRODUCT,	 	"prf" => array(1,2),		"lbl" => "Productos", 		"ico" => "fa-folder-open-o",	"lnk" => array() ),
				array( "cmd" => LST_SERVICE,	 	"prf" => array(1,2),		"lbl" => "Servicios", 		"ico" => "fa-gear",				"lnk" => array() ),
				array( "cmd" => LST_COMPUTER,		"prf" => array(1,2),		"lbl" => "Computadoras", 	"ico" => "fa-desktop",		 	"lnk" => array() ),
				/*array( "cmd" => LST_MAINTENANCE, 	"prf" => array(1,2),		"lbl" => "Mantenimiento", 	"ico" => "fa-gear",		 		"lnk" => array() ),*/
				array( "cmd" => LST_USER,		 	"prf" => array(1,2),		"lbl" => "Usuarios", 		"ico" => "fa-users",		 	"lnk" => array() ),
				array(
						"cmd" => "#",			 	"prf" => array(1),			"lbl" => "Catalogos", 		"ico" => "fa-tasks",
						"lnk" => array
						(
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=brand", 			"prf" => array(1),		"lbl" => "Marcas",			"ico" => "fa-briefcase", 	"lnk" => array() ),
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=supplier", 			"prf" => array(1),		"lbl" => "Proveedores",		"ico" => "fa-credit-card", 	"lnk" => array() ),
							array( "cmd" => ADMIN_CATALOGUE	. "&cat=product_category", 	"prf" => array(1),		"lbl" => "Categorías",		"ico" => "fa-certificate", 	"lnk" => array() ) 
						)
					),
			)
		 ),
	array(
			"cmd" => "#",
			"prf" => array(1,2),
			"lbl" => "Inventarios",
			"ico" => "fa-bars",
			"lnk" => array
			(
				array( "cmd" => LST_BAR_STOCK,	 	"prf" => array(1,2),		"lbl" => "Mostrador", 		"ico" => "fa-exchange",		 	"lnk" => array() ),
				/*array( "cmd" => LST_WAREHOUSE,		"prf" => array(1,2),		"lbl" => "Bodega", 			"ico" => "fa-building-o",		"lnk" => array() ),*/
			)
		 ),
	array(
			"cmd" => "#",
			"prf" => array(1,2),
			"lbl" => "Reportes",
			"ico" => "fa-bars",
			"lnk" => array
			(
				array( "cmd" => REPORT_BALANCE,	 	"prf" => array(1,2),		"lbl" => "Balance", 		"ico" => "fa-pencil-square-o",		 	"lnk" => array() ),				
			)
		 ),
	array(  
		"cmd" => "#",
		"lbl" => "Configuración", 
		'prf' => array(1),
		"ico" => "fa-gear",
		"lnk" => array(
					array( "cmd" => FRM_SITEMAP, 		"lbl" => "Ciber", 			"ico" => "fa-sitemap",		 "lnk" => array() ),
					array( "cmd" => FRM_TAXES, 			"lbl" => "Tarifas", 		"ico" => "fa-money",		 "lnk" => array() ),
					array( "cmd" => FRM_APPEARANCE, 	"lbl" => "Apariencia", 		"ico" => "fa-tint",		 	"lnk" => array() ),
					array( "cmd" => FRM_VERSION_APP, 	"lbl" => "Aplicación", 		"ico" => "fa-android", 		"lnk" => array() ),
					array( "cmd" => FRM_VERSION_CTRL, 	"lbl" => "Backend",			"ico" => "fa-cloud",	 	"lnk" => array() ),
					 
					array( "cmd" => FRM_CONTACT_META, 	"prf" => array(1),		"lbl" => "Config. Contactos",	"ico" => "fa-group", 	"lnk" => array() ), 
					array( "cmd" => FRM_PRODUCT_META, 	"prf" => array(1),		"lbl" => "Config. Productos",	"ico" => "fa-barcode", 	"lnk" => array() ), 
					array( "cmd" => FRM_PDV_META, 		"prf" => array(1),		"lbl" => "Config. PDVs",		"ico" => "fa-bullseye", "lnk" => array() ) 
				 )
	),
	array(  
		"cmd" => LST_DOWNLOADS,
		"lbl" => "Descargas", 
		'prf' => array(1),
		"ico" => "fa-cloud-download",
		"lnk" => array()
	)
  )
);
?>