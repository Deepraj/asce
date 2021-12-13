// JavaScript Document

function modelPrint(){

	this.moduleName = "print";
	this.objConnect = new JSDBC();
	
	this.init = function(){
	}
	
	this.getChapterSectionList = function(){
		this.objConnect.setService('Book')
		this.objConnect.setMethod('printsec')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setChapterSectionList);
		this.objConnect.submit();		
	}
}

