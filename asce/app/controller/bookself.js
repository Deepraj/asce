 function controllerBookself(){
	this.moduleName = "bookself";
	this.init = function(){
		this.setDynamicEvents();
	}
	this.destroy = function(){
	}
	this.setDynamicEvents = function(){
		$('nav.navbar .menus li.bookshelf_btn').unbind('click');
		$('nav.navbar .menus li.bookshelf_btn').click(function(){
			bookType=objModule.arrModule.bookself.bookType;
			
			if(bookType=='SINGLE'){
			// alert('anuj');
			  //  window.location.href = "https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL="+CONFIG.productPath1;
			  window.location.href = CONFIG.productPath1;
			}else if(bookType=='MULTI'){
			  //  alert(CONFIG.productPath);
			//	window.location.href = "https://secure.asce.org/PUPGASCEWebsite/SECURE/SignIn/SignIn.aspx?ASCEURL="+CONFIG.productPath1;
			window.location.href = CONFIG.productPath1;
			}else if(bookType=='IPBASED'){
				window.location.href = CONFIG.productPath1;
			}else if(bookType=='PRIMARY'){
			 window.location.href = CONFIG.webServicePath+CONFIG.book_path;
			}else{
		     window.location.href = CONFIG.webServicePath+CONFIG.book_path;
			}
		});		
	}
}