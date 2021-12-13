//Copyright@ MPS Ltd 2015
/**
 * module management
 * @author satheesh
 */
var $global = this; 
function classModule(){
	this.scriptStatus = {};
	this.autoLoadModel = Array();
	tempObj = this;
	//debugger;
	this.arrModule = { 
		// Top menu contents
		// array index and module name should be in same
		"commonInfo" :	{ 
			name : 'commonInfo',
			label :"App common data",
			tooltip :"App common data", 
			active : true, 
			model:'modelCommonInfo',
			view:'',
			controler : 'controlerCommonInfo',
			hasModule : true,
			autoLoad : false,
			hasTopMenu : false,
			selector :'',
			selectorType:'',
			location:''
		},		
		
        "toc" :	{ 
			name : 'toc',
			label :localizedStrings.headermenu.table_of_content.title.text,
			tooltip :localizedStrings.headermenu.table_of_content.tooltip.text, 
			active : true, 
			model:'modelToc',
			view:'toc.html',
			controler : 'controlerToc',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : false,
			selector :'toc',
			selectorType:'class',
			cssClass :'toc',
			hasTopMenu : true,
			isModulePopup : false,
			selector :'toc',
			selectorType:'class',
			cssClass :'hidden_desktop toc',			
		},
        "bookself" :	{ 
			name : 'bookself',
			label :localizedStrings.headermenu.bookshelf.title.text,
			tooltip :localizedStrings.headermenu.bookshelf.tooltip.text, 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'',
			view:'',
			controler : 'controllerBookself',
			hasModule : false,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'',
			selectorType:'class',
			cssClass :'class4 hidden_device bookshelf_btn',
			bookType:'',
			
		},        
		"notes_popup" :	{ 
			name : 'notes_popup',
			label :localizedStrings.headermenu.notes.title.text,
			tooltip :localizedStrings.headermenu.notes.tooltip.text, 
			active : true, 
			selector :'class5',
			selectorType:'class',
			location:'',
			model:'modelNotes',
			view:'notes.html',
			controler : 'controlerNotes',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'notes_btn',
			selectorType:'class',
			cssClass :'class5 notes_btn',
			
			
		},
		"highlight" :	{ 
			name : 'highlight',
			label :"HIGHLIGHTS",
			tooltip :"HIGHLIGHTS", 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'modelHighlight',
			view:'',
			controler : 'controllerHighlight',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : false,
			isModulePopup : false,
			selector :'',
			selectorType:'',
			cssClass :'',
			
		},		
		"bookmark" :	{ 
			name : 'bookmark',
			label :localizedStrings.headermenu.bookmarks.title.text,
			tooltip :localizedStrings.headermenu.bookmarks.tooltip.text, 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'modelBookmark',
			view:'bookmark.html',
			controler : 'controlerBookmark',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'bookmark_btn',
			selectorType:'class6',
			cssClass :'class6 bookmark_btn',
		},		
        "search" :	{ 
			name : 'search',
			label :localizedStrings.headermenu.search.title.text,
			tooltip :localizedStrings.headermenu.search.tooltip.text, 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'modelSearch',
			view:'search.html',
			controler : 'controllerSearch',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'search_btn',
			selectorType:'class1',
			cssClass :'class1 search_btn',
		},	
        "print" :	{ 
			name : 'print',
			label :localizedStrings.headermenu.print.title.text,
			tooltip :localizedStrings.headermenu.print.tooltip.text, 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'modelPrint',
			view:'print.html',
			controler : 'controllerPrint',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'print_panel',
			selectorType:'class7',
			cssClass :'class7 print_panel',
		},	
        "history" :	{ 
			name : 'history',
			label :localizedStrings.headermenu.history.title.text,
			tooltip :localizedStrings.headermenu.history.tooltip.text, 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'modelHistory',
			view:'history.html',
			controler : 'controllerHistory',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'print_panel',
			selectorType:'class3',
			cssClass :'class3 history_panel',
		},	
        "myaccount" :	{ 
			name : 'myaccount',
			label :localizedStrings.headermenu.my_account.title.text,
			tooltip :localizedStrings.headermenu.my_account.tooltip.text, 
			active : true, 
			selector :'',
			selectorType:'',
			location:'',
			model:'myAccount',
			view:'myaccount.html',
			controler : 'controllerMyaccount',
			hasModule : true,
			autoLoad : true,
			hasTopMenu : true,
			isModulePopup : true,
			selector :'print_panel',
			selectorType:'class2',
			cssClass :'class2 myaccount',
			bookType:'',
		},
	}
	this.setScriptStatus = function(){
		$.each(this.arrModule,function(key,value){
			if(!value.active)
				return true;
			tempObj.scriptStatus[key] = {};
			tempObj.scriptStatus[key].controler = false;
			tempObj.scriptStatus[key].model = false;
			tempObj.scriptStatus[key].view = false;
			CONFIG.objModule[key] = {};
			CONFIG.objModule[key] = {};
//			CONFIG.objModule[key].model = 
			if(typeof(value.autoLoad) != "undefined" && value.autoLoad && key != "commonInfo")
				tempObj.autoLoadModel.push(key);
			
		});
	}
/*	function factory(class_) {
		return new class_();
	}	*/
	this.init = function(){
		$(CONFIG.topMenuSelector).empty();
		this.setScriptStatus();
		this.loadModule();
	}
	this.loadModule = function(){
		$.each(this.arrModule,function(key,value){
			if(!value.active)
				return true;		
			if(!tempObj.scriptStatus[key].controler){
				//tempObj.scriptStatus[key].controler = true
				tempObj.loadScript(CONFIG.controlerPath+key+".js",key,'controler',tempObj.arrModule[key].controler);
				return false;
			}
			if(!tempObj.scriptStatus[key].model && tempObj.arrModule[key].hasModule){
				//tempObj.scriptStatus[key].model = true
				tempObj.loadScript(CONFIG.modelPath+key+".js",key,'model',tempObj.arrModule[key].model);
				return false;
			}
		});
		if(this.hasLoaded()){
			CONFIG.objModule['commonInfo'].controler.init();
//			this.autoLoad();
		}
	}
	
	this.autoLoad = function(){
		$.each(this.autoLoadModel,function(key,value){
			CONFIG.objModule[value].controler.init();
		})
	}
	
	this.hasLoaded = function(){
		returnStatus = true;
		$.each(this.scriptStatus, function(key,value){
			if(!value.controler || (!value.model && tempObj.arrModule[key].hasModule)){
				returnStatus = false
				return false;
			}
		})
		return returnStatus;
	}
	
	this.loadScript = function(url,key,type,className){
		tempObj = this;
		$.getScript(url).done(function() {
			//console.log( " script : "+ url)
			tempObj.scriptStatus[key][type] = true;
			CONFIG.objModule[key][type] = new window[className];
			if(type == 'controler')
				tempObj.manageTopMenu(key);
			tempObj.loadModule()
		}).fail(  function() {
			console.log("Error load script : " + url);
		})
	}
	
	this.getView = function(strModule){
		return this.arrModule[strModule].view;
	}
	
	this.manageTopMenu = function(module){
		if(typeof(this.arrModule[module].hasTopMenu) != "undefined" && this.arrModule[module].hasTopMenu){
			menuStruc = this.getTopMenuStructure(this.arrModule[module]);
			$(CONFIG.topMenuSelector).append(menuStruc);
	//		menuStruc
		}
	}
	// destroy othar than current module
	this.destroyModule = function(current_module){
		$.each(this.arrModule,function(key,value){
			if(!value.active)
				return true;
			if(key != current_module && (typeof(value.isModulePopup) != "undefined" && value.isModulePopup) ){
				CONFIG.objModule[key].controler.destroy();
			}
		});	
	} 
	
	this.getTopMenuStructure = function(module){
		menuLi = $("<li/>",{class : module.cssClass});
		$(menuLi).attr('title',module.tooltip);
		//debugger
		/* if(module.name=="myaccount"){
			debugger
			try{
				 var xmlString = module.label, parser = new DOMParser(), doc = parser.parseFromString(xmlString, "text/xml"),hrfVal=doc.getElementsByTagName("a")[0].getAttribute("href");
				 var loginLing = $("<a href='"+hrfVal+"'/>");
				 $(menuLi).append(loginLing);
			}catch(e){
				
			}
		} */
		menuSpanIcon = $("<span/>",{'class' : 'icon'});
		//menuSpanIcon =  "<a>'"+menuSpanIcon+"'</a>";
		
		
		menuSpanName = $("<span/>",{'class' : 'pro_name'}).html(module.label);
		menuSpanArrow = $("<span/>",{'class' : 'arrow'});
		$(menuLi).append(menuSpanIcon).append(menuSpanName).append(menuSpanArrow);
		return menuLi;
//		<li class="hidden_desktop toc" title="SEARCH"><span class="icon"></span><span class="pro_name">TABLE OF CONTENT</span><span class="arrow"></span></li>
	}

}

