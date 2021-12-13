//Copyright@ MPS Ltd 2015
/**
 * app localization management
 * @author satheesh
 * @see Quiz Student version
 * @see AbstractView
 */
 
 function classBoilerplate(){
	this.langSetting = {
		lang : 'en-us',
		userType : 'T',
		filePrefix : 'Boilerplate_',
		fileExt : "js"
	}
	
	this.boilerStringPath = CONFIG.boilerStringPath;
	
	this.settings = function(arrSett){
		this.langSetting = arrSett;
	}
	this.init = function(){
		this.loadLocalization()
	}
	
	this.destroy = function(){
	}
	
	this.loadLocalization = function(){ 
		url = this.getLangFileName();
		$.getScript(url,function() {
			objApp = new classApp();
			objApp.init();
		});  
	}	
	this.getLangFileName = function(){
		path = "";
		path =  this.boilerStringPath + this.langSetting.filePrefix + this.langSetting.lang +"." + this.langSetting.fileExt;
		
		if(this.langSetting.userType == "S"){
			path =  this.boilerStringPath + this.langSetting.filePrefix + "stu_" + this.langSetting.lang +"." + this.langSetting.fileExt;
		}
		return path;
	}	
 }