//Copyright@ MPS Ltd 2015
/**
 * Database conectivity driver (JSDBC)
 * @author satheesh
 */
 
JSDBC = function(){
	this.servicePath = CONFIG.webServicePath;
	this.service = "";
	this.method = "";
	this.connectionType = "POST";
	this.callback = "";
	this.dataType = 'json',
	this.param	= {};
	tempObjJSDBC = this;
	
	this.init = function(){
	}
	this.destroy = function(){
		this.servicePath = CONFIG.webServicePath;
		this.service = "";
		this.method = "";
		this.connectionType = "POST";
		this.callback = "";
		this.dataType = 'json',
		this.param	= {};		
	}
	this.setService = function(strService){
		this.service = strService;
	}
	this.setMethod = function(strMethod){
		this.method = strMethod;
	}
	this.setDataType = function(strDataType){
		this.dataType = strDataType;
	}
	
	this.setConnectionType = function(strConnectionType){
		this.connectionType = strConnectionType;
	}
	this.setCallback = function(callback){
		this.callback = callback;
	}
	this.setParam = function(arrParam){
		this.param = arrParam;
	}
	this.submit = function(){
		$.ajax({
			type      :  this.connectionType,
			dataType  :  this.dataType,
			url       :  this.servicePath+this.service+'/'+this.method,
			async     :  false,
			context	  :  this,
			data      :  this.param,
			success   :  function(data) {
				this.callback.call(this,data);
			},
			error: function(data){
				console.log(tempObjJSDBC.servicePath+tempObjJSDBC.service+'/'+tempObjJSDBC.method + " while laoding data error in web servcies");
				console.log(data);
			}
			
		}); 		
	}
	this.close = function(){
		this.destroy();
	}
	
};