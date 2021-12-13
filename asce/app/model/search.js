// JavaScript Document

function modelSearch(){
	this.moduleName = "search";
	this.objConnect = new JSDBC();
	
	this.init = function(){
	}

	this.getSearchList = function(content){
		arrParm = {
			cont_search:content
		}
		this.objConnect.setService('Searchcontent')
		this.objConnect.setMethod('contentdetails')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setSearchList);
		this.objConnect.submit();		
	}
}