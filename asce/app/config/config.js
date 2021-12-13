// JavaScript Document

var objBoiler ;
var objApp ;
var objJSDBC;
var objModule;
var CONFIG = {
	webServicePath : "http://beta.asce.mpstechnologies.com/asce_service/index.php/",
	productPath1 : "http://beta.asce.mpstechnologies.com/product",
	productPath : "http://beta.asce.mpstechnologies.com/",
	frontLogout: "http://beta.asce.mpstechnologies.com/LoginHandling/sessiondestroy",
	modelPath : 'app/model/',
	controlerPath : 'app/controller/',
	viewPath : 'app/view/',
	objModule : {},
	bookPath : '../asce_content/book',
	bookHistoryPath : '../asce_content/history/',
	pagePath : 'pages',
	commentryPath : 'commentary',
	prefix_volume : 'vol-',
	topMenuSelector : ".menu-item .navbar-right.menus",
	library_path:"Custombook_library/show_custombook",
	book_path:"Book_library/list_book",
	boilerStringPath: "local/"
};

var MODULE = {
	note : "true",
	search : 'true',
	objModule : {},
};
