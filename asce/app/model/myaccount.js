// JavaScript Document

function myAccount(){
	this.moduleName = "myaccount";
	this.objConnect = new JSDBC();
	
	this.init = function(){
	}

	this.doLogout = function(){
		bookType=objModule.arrModule.myaccount.bookType;
		//alert(bookType);
		if(bookType=='SINGLE'){
			this.objConnect.setService('Book')
			this.objConnect.setMethod('logout')
//	        this.objConnect.setCallback();
	         this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.logout_callback);
			this.objConnect.submit();
			window.location.href = CONFIG.productPath+'LoginHandling/unset_session_data';
		}
		else if(bookType=='MULTI'){
			this.objConnect.setService('Book')
			this.objConnect.setMethod('logout')
//	        this.objConnect.setCallback();
	         this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.logout_callback);
			this.objConnect.submit();
			window.location.href = CONFIG.productPath+'LoginHandling/unset_session_data';
		}
		else if(bookType=='IPBASED'){
			this.objConnect.setService('Book')
			this.objConnect.setMethod('logout')
//	        this.objConnect.setCallback();
	         this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.logout_callback);
			this.objConnect.submit();
			window.location.href = CONFIG.productPath+'LoginHandling/unset_session_data';
		}
		else{
		this.objConnect.setService('Book')
		this.objConnect.setMethod('logout')
//        this.objConnect.setCallback();
         this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.logout_callback);
		 this.objConnect.submit();
		}
	}
}