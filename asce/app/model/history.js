// JavaScript Document

function modelHistory(){
	this.moduleName = "history";
	this.objConnect = new JSDBC();
	
	this.init = function(){
	}

	this.getHistoryList = function(content){
		arrParm = {
			cont_search:content
		}
		this.objConnect.setService('Book')
		this.objConnect.setMethod('contentdetails')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.getHistory);
		this.objConnect.submit();		
	}
}