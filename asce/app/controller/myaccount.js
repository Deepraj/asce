// JavaScript Document

function controllerMyaccount(){
	
	thisMyaccountObj = this;
	this.currentComonNames;
	this.moduleName = "myaccount";	
	this.init = function(){
		this.loadmyaccountPanel();
	}

	this.destroy = function(){
		this.hideForm();
	}
	
	this.loadmyaccountPanel = function(){
		$('#myaccount_popup').load(CONFIG.viewPath+"myaccount.html",function(){ 
			thisMyaccountObj.start();
		});
	}
 	this.start = function(){
		//debugger;
currentUserName=CONFIG.objModule["commonInfo"].controler.getUserName();
currentBookName=CONFIG.objModule["commonInfo"].controler.getBookTitle();
currentComonName=CONFIG.objModule["commonInfo"].controler.getUserComonName();
//currentComonName=CONFIG.objModule["commonInfo"].controler.getUserComonInfo();
//debugger;
		this.setDynamicEvents();
		this.localizationString();
	}
	
	this.showForm = function(){
		$('nav.navbar .menus li.myaccount').addClass("active");
		if($(".pro_name").has("a").length >0){
			$('#myaccount_popup').removeClass("show");
		}else{
			//$('#myaccount_popup').addClass("show");
			$( "#myaccount_popup" ).toggle();
		}
		
	}
	
	this.hideForm = function(){
		$('nav.navbar .menus li.myaccount').removeClass("active");
		$('#myaccount_popup').removeClass("show");
		$('#myaccount_popup').css("display", "none");
	}
	
	this.cancel = function(){
		thisMyaccountObj.hideForm();
	}
	
	this.localizationString = function(){
		$( "#myaccount_popup .panel-heading" ).append(localizedStrings.myaccount_popup_pannel.label.title.text);
		$( "#myaccount_popup .logout_btn" ).text(localizedStrings.myaccount_popup_pannel.logout.button.text);	
		$( "#myaccount_popup .userName" ).append(currentUserName);	
		$( "#myaccount_popup .bookName" ).append(currentBookName);
		//debugger;
                
		if( currentComonName=="MULTI" || currentComonName=="IPBASED" )
		{
			//alert(currentComonName);
			//this.currentComonNames="Admins";
			var htmlvalue = '<span class="glyphicon glyphicon pull-left" style="font-size: 20px; padding-right: 10px; margin-top:10px;"></span><a href="http://beta.asce.mpstechnologies.com/products/index.php/Dashboard/show_dashboard">Admin  </a> </strong>';
			
			
          $( "#myaccount_popup .admincomomn" ).html(htmlvalue);
		}	   
	}
	this.setDynamicEvents = function(){
	
		$("nav.navbar .menus li.myaccount").unbind( "click" );
		$("nav.navbar .menus li.myaccount").click(function(){
			objModule.destroyModule(thisMyaccountObj.moduleName);
			thisMyaccountObj.showForm();
		});
		
		$('#myaccount_popup .close_btn').unbind( "click" );
		$('#myaccount_popup .close_btn').click(function(){
			thisMyaccountObj.cancel();
		});
		
		$('#myaccount_popup .logout_btn').unbind( "click" );
		$('#myaccount_popup .logout_btn').click(function(){
			thisMyaccountObj.logout();
		});
	}
	this.logout = function(){
		CONFIG.objModule[this.moduleName].model.doLogout();
	}
	this.logout_callback = function(){
		CONFIG.objModule.commonInfo.controler.logout();
	}
}
