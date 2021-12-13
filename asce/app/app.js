//Copyright@ MPS Ltd 2015
/**
 * app management
 * @author satheesh
 */
function classApp(){
	var thisObj = this;
	this.objConnect = new JSDBC();
	this.init = function(){
        this.loadAppData();		
	}
	
	this.loadAppData = function(){
		this.objConnect.setService('Book')
		this.objConnect.setMethod('get_app_info')
        this.objConnect.setCallback(objApp.call_back_loadAppData)
		this.objConnect.submit();		
	}		
	
	this.call_back_loadAppData = function(dbDataSet){
		thisObj.appData = dbDataSet;
		thisObj.loadModule();	
	}
	this.loadModule = function(){
	  //alert(thisObj.appData.book_type);
		objModule = new classModule();
		//alert('Anuj');
		/*--------- Handling Single User Type-----------*/
		// alert(thisObj.appData.book_type);
		if(thisObj.appData.book_type == 'SINGLE'){
			debugger;
		  	objModule.arrModule.notes_popup.active = true;
			objModule.arrModule.highlight.active = true;
			objModule.arrModule.bookmark.active = true;
			objModule.arrModule.myaccount.bookType = 'SINGLE';
			objModule.arrModule.bookself.bookType = 'SINGLE';
		}
		/*------------------Handling Multi User Type-------*/
		else if(thisObj.appData.book_type == 'MULTI'){
			//debugger
			objModule.arrModule.notes_popup.active = true;
			objModule.arrModule.highlight.active = true;
			objModule.arrModule.bookmark.active = true;
			objModule.arrModule.myaccount.bookType = 'MULTI';
			objModule.arrModule.bookself.bookType = 'MULTI';
		}
		/*------------------- Handling IP Based-----------*/
		else if(thisObj.appData.book_type == 'IPBASED'){
			debugger;
			objModule.arrModule.notes_popup.active = true;
			
			objModule.arrModule.notes_popup.cssClass="class5 notes_btn abhi"; 
			objModule.arrModule.highlight.active = false;
			objModule.arrModule.bookmark.active = true;
			objModule.arrModule.bookmark.cssClass="class6 bookmark_btn abhi";
			objModule.arrModule.myaccount.active = true;
			objModule.arrModule.myaccount.cssClass="class2 myaccount";
			if(thisObj.appData.login != 'login')
			{
			objModule.arrModule.myaccount.label = '<a href="https://ascetst2ebiz.personifycloud.com/ascewebapp/signin/signin.aspx?logoff=Y&ASCEURL=" . base_url();>LOGIN</a>';
			objModule.arrModule.myaccount.tooltip = 'LOGIN';
			}
			if(thisObj.appData.login == 'notlogin'  )
			{
			objModule.arrModule.notes_popup.cssClass="class5 notes_btn "; 
			objModule.arrModule.highlight.active = false;
			objModule.arrModule.bookmark.active = true;
			objModule.arrModule.bookmark.cssClass="class6 bookmark_btn abhi";
			 objModule.arrModule.myaccount.isModulePopup = false;	
				
			}
			if(thisObj.appData.login == 'login')
			{
			objModule.arrModule.highlight.active = true;
			objModule.arrModule.notes_popup.cssClass="class5 notes_btn"; 
            objModule.arrModule.bookmark.cssClass="class6 bookmark_btn";
             objModule.arrModule.myaccount.isModulePopup = true;			
			}
			objModule.arrModule.myaccount.isModulePopup = false;
			objModule.arrModule.myaccount.bookType = 'IPBASED';
			objModule.arrModule.bookself.bookType = 'IPBASED';
		}
		/*--------------Handling Admin-------------------*/
		else if(thisObj.appData.book_type == 'PRIMARY'){
			objModule.arrModule.notes_popup.active = true;
			objModule.arrModule.highlight.active = true;
			objModule.arrModule.bookmark.active = true;
			objModule.arrModule.myaccount.bookType = 'PRIMARY';
			objModule.arrModule.bookself.bookType = 'PRIMARY';
		}
		objModule.init();
//		objModule.loadScript();
	}
	
	this.destroy = function(){
		
	}
	
    this.doStuff = function(data) {
		console.log(data.toSource());
    }
	
	$('.main_header .container-fluid, #myNavbar').css('position','fixed');
}
