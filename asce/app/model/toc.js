//Copyright@ MPS Ltd 2015
/**
 * module management
 * @author satheesh
 * @co-author Arulkumar
 */
function modelToc (){
	this.moduleName = "toc";
	this.objConnect = new JSDBC();
	this.init = function(){
	}
	this.getChapterList = function(){
		this.objConnect.setService('Book')
		this.objConnect.setMethod('chapandsec')
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.getChapters)
		this.objConnect.submit();		
	}
	this.getNavigationList = function(){
		this.objConnect.setService('Book')
		this.objConnect.setMethod('navigatesec')
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setNavigationList)
		this.objConnect.submit();		
	}
}

