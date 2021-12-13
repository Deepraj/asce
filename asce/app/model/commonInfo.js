//Copyright@ MPS Ltd 2015
/**
 * module management
 * @author satheesh
 */
function modelCommonInfo (){
	this.moduleName = "commonInfo";
	this.objConnect = new JSDBC();
	this.init = function(){
	}
	this.getBookInfo = function(isbn,volNo){
		this.objConnect.setService('Book')
		this.objConnect.setMethod('bookdetails')
//		this.objConnect.setParam({'isbn':isbn,'volNo':volNo});
		this.objConnect.setParam();
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setBookInfo)
		this.objConnect.submit();		
	}
	this.getUserInfo = function(){
		this.objConnect.setService('Book')
		this.objConnect.setMethod('userinfo')
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setUserInfo)
		this.objConnect.submit();		
	}
	
	this.getUserComonInfo = function(){
	
		this.objConnect.setService('Book')
		this.objConnect.setMethod('subuserComoninfo')
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setUserComonInfo)
		this.objConnect.submit();		
	}
}