//Copyright@ MPS Ltd 2015
/**
 * module management
 * @author satheesh
 */
 
function controlerCommonInfo(){
	thisCommonInfoObj = this;
	this.moduleName = "commonInfo";
	this.arrBookInfo = Array();
	this.bookInfoLoaded = false;
	this.arrUserInfo = Array();
	this.arrUserComonInfo = Array();
	this.userInfoLoaded = false;
	this.pageLoadCompleted = false;
	this.commantryLoadCompleted = false;
        this.userrolename = '';
	
	this.init = function(){
		CONFIG.objModule[this.moduleName].model.getBookInfo('','1');
		CONFIG.objModule[this.moduleName].model.getUserInfo();
		CONFIG.objModule[this.moduleName].model.getUserComonInfo();
		
	}
	this.setBookInfo = function(dbData){
		
		console.log(dbData);
		thisCommonInfoObj.bookInfoLoaded = true;
		thisCommonInfoObj.arrBookInfo = dbData[0];
		thisCommonInfoObj.start();
	}
	this.setUserInfo = function(dbData){
		
		if(typeof(dbData.error)!="undefined"){
			thisCommonInfoObj.logout();
		}
		thisCommonInfoObj.userInfoLoaded = true;
		thisCommonInfoObj.arrUserInfo = dbData[0];
		thisCommonInfoObj.start();
	}
	this.setUserComonInfo = function(dbData){
	/* debugger
		if(!!dbData[0] && !!dbData[0].master_id){
			subuser = true;
		}else{
			subuser = false;
		}	 */
		//debugger 
                 // if(dbData.length==0)
                 // {
                  // thisCommonInfoObj.arrUserComonInfo = '';
                 // }
	
                // thisCommonInfoObj.arrUserComonInfo = dbData[0];
		// thisCommonInfoObj.start();
		//thisCommonInfoObj.arrUserComonInfo = dbData[0];
		//debugger;
		//return thisCommonInfoObj.arrUserComonInfo.m_licence_type;
		
	}
	this.start = function(){
		if(this.bookInfoLoaded && this.userInfoLoaded){
			this.showUserName();
			objModule.autoLoad();
			this.localizationString();
		}
	}
	
	this.localizationString = function()																							
	{	
		//nav
		$( "nav.navbar .zoom .prop_value .plus" ).attr('title',localizedStrings.headerPropertiesTool.zoom.tooltip.zoomin );
		$( "nav.navbar .zoom .prop_value .minus" ).attr('title',localizedStrings.headerPropertiesTool.zoom.tooltip.zoomout );
		$( "nav.navbar .font_prop .font_img" ).attr('title',localizedStrings.headerPropertiesTool.font.tooltip.text );
		$( "nav.navbar .section_no" ).attr('title',localizedStrings.headerPropertiesTool.section.tooltip.text );
		$( "nav.navbar .split_design span" ).attr('title',localizedStrings.headerPropertiesTool.split.tooltip.text );
		$( "nav.navbar .zoom .prop" ).text(localizedStrings.headerPropertiesTool.zoom.title.text);
		$( "nav.navbar .font_prop .prop" ).text(localizedStrings.headerPropertiesTool.font.title.text);
		$( "nav.navbar .section_no .prop" ).text(localizedStrings.headerPropertiesTool.section.title.text);
		$( "nav.navbar .split_view .prop" ).text(localizedStrings.headerPropertiesTool.split.title.text);
		//aside
		$( "aside header .prop_name" ).text(localizedStrings.aside_toc.label.title.text);
		$( "aside header span.expandall" ).attr('title',localizedStrings.aside_toc.expand_collapse.tooltip.expandall);
		$( "aside header span.collapseall" ).attr('title',localizedStrings.aside_toc.expand_collapse.tooltip.collapseall);
		$( "aside .glyphicon-chevron-left" ).attr('title',localizedStrings.aside_toc.hide_show.tooltip.hide);
		$( "aside .glyphicon-chevron-right" ).attr('title',localizedStrings.aside_toc.hide_show.tooltip.show);
		//custom tooltip
		$( ".custom_tooltip li.copy" ).text(localizedStrings.custom_tooltip.label.button.Copy);
		$( ".custom_tooltip li.highlight" ).text(localizedStrings.custom_tooltip.label.button.Highlight);
		$( ".custom_tooltip li.note" ).text(localizedStrings.custom_tooltip.label.button.Note);
		$( ".custom_tooltip li.bookmark" ).text(localizedStrings.custom_tooltip.label.button.Bookmark);

		//pageCommentrySection
		$( ".Commentry_article header .title" ).text(localizedStrings.pageCommentrySection.commentary.title.text );
		$( "section.main_section section header .glyphicon-resize-full" ).attr('title',localizedStrings.pageCommentrySection.full_view.tooltip.text);
		$( "section.main_section section header .glyphicon-resize-small" ).attr('title',localizedStrings.pageCommentrySection.exit_full_view.tooltip.text);
		//popup tool
		$( ".popup_tool .close_btn" ).attr('title',localizedStrings.popup_pannel.close.tooltip.text);
	}	   
	
	this.logout = function(){
                //debugger;
		//window.location.href = CONFIG.webServicePath;
		//window.location.href = CONFIG.productPath;
		window.location.href = CONFIG.frontLogout;
	}
	
	this.showUserName = function(){
		$('.main_header .username').html(this.getUserName());
	}
	
	this.getVolumeNo = function(){
		return this.arrBookInfo.vol_no;
	}
	
	this.getVolumeName = function(){
		
		return this.arrBookInfo.m_voltitle;
	}
	this.getISBN = function(){
		return this.arrBookInfo.m_bokisbn;
	}
	this.getBookName = function(){
		return this.arrBookInfo.m_bokname;
	}
	this.getBookTitle = function(){
		return this.arrBookInfo.m_boktitle;
	}
	this.getLang = function(){
		return this.arrBookInfo.m_lanname;
	}
	
	this.getUserName = function(){
		
		return this.arrUserInfo.username;
		//return this.arrUserInfo.m_usrfirstname + " " + this.arrUserInfo.m_usrlastname;
	}
	
	this.getUserComonName = function(){
		//debugger;
		//return this.arrUserComonInfo.m_licence_type;
		//return this.arrUserInfo.m_usrfirstname + " " + this.arrUserInfo.m_usrlastname;
	}
	
	this.getEmail = function(){
		return this.arrUserInfo.email;
	}
	
	this.getUserInfo = function(){
		return this.arrUserInfo;
	}
	
	this.destroy = function(){
		
	}
	
	this.set_height_and_width = function()// set height width for all
	{	
		$('.properties_contaniner').width($(window).width() - 720 );
		$('#homepage .middle_table').height($(window).height() - 90);
		$('#loginpage .middle_table').height($(window).height() - 90);
		if($(window).width() > 1020){
		//  $( '#container' ).addClass( "vertical" ).removeClass( "horizontal" );
		//	$('.non_full_view section.main_section').height($(window).height() - 94);
				
			//$('.full_size_page section.main_section,.full_size_commentry section.main_section').height( $(window).height() );
			
			$('.non_full_view section.main_section section').height($(window).height() - 80);
			$('.full_size_page section.main_section section,.full_size_commentry section.main_section section').height( $(window).height() );
			$('.horizontal.non_full_view .Commentry,.horizontal .Page').height( ($(window).height() - 170) / 2 );
			$('.vertical.non_full_view .Commentry,.vertical .Page').height( $(window).height() - 120 );
			$('.horizontal.non_full_view .Commentry iframe,.horizontal .Page iframe').height( ($(window).height() - 189) / 2 );
			$('.vertical.non_full_view .Commentry iframe,.vertical .Page iframe').height( $(window).height() - 145 );
			$('.main_toc').height( $(window).height() - 140 );
			$('nav.navbar .menus').height( 1 );
				try{
					$('#booksearch').css({'left':$('.class1').offset().left - 432});
				}catch(er){};
				try{
					$('#history_popup').css({'left':$('.class3').offset().left - 432});
				}catch(er){};
				try{
					$('#notes_popup').css({'left':$('.class5').offset().left - 432});
				}catch(er){};
				try{
					$('#print_popup').css({'left':$('.class7').offset().left - 432});
				}catch(er){};
				try{
					$('#bookmarks').css({'left':$('.class6').offset().left - 432});
				}catch(er){};
				try{
					$('#myaccount_popup').css({'left':$('.class2').offset().left - 432});
				}catch(er){};
				/*
				try{
					$('#booksearch,#history_popup,#notes_popup,#print_popup,#bookmarks,#myaccount_popup').css({'left':$('.class2').offset().left - 432});
				}catch(er){};*/
			}
		else{
			//$( '#container' ).addClass( "horizontal" ).removeClass( "vertical" );
			$('.navbar-nav').height($(window).height() - 73);
			$('.non_full_view section.main_section section').height( $(window).height());
			$('.horizontal.non_full_view .Commentry,.horizontal.non_full_view .Page').height( ($(window).height() - 155)/2 );
			$('.horizontal.non_full_view .Commentry iframe,.horizontal.non_full_view .Page iframe').height( ($(window).height() - 165)/2 );
			$('.vertical.non_full_view .Commentry,.vertical.non_full_view .Page').height( ($(window).height() - 155)/2 );
			$('.vertical.non_full_view .Commentry iframe,.vertical.non_full_view .Page iframe').height( ($(window).height() - 165)/2 );
			$('.main_toc').height( ($(window).height() - 113) );
			$('nav.navbar .menus').height( ($(window).height() - 76) );
			$('.popup_tool').css({'left':0}); // remove styles for devices
		}
		$('#login_details,#register_form,#forgetPassword').height( $(window).height() -  $('#formControl .header').height());
		$('.full_size_commentry .Commentry,.full_size_page .Page').height( $(window).height() - 40 );
		$('.full_size_commentry .Commentry iframe,.full_size_page .Page iframe').height( $(window).height() - 45 );
	}
	
	this.remove_styles_for_mobile = function()// remove styles for devices
	{	
		if($(window).width() > 1020){
		} else{
		}
	}
	
	this.hideLoder = function(){
		$('.loader').hide();
	}
	
	this.showLoder = function(){ 
		$('.loader').show();
	}
	
	this.getReady = function(){
		this.hideLoder();
		this.set_height_and_width();
		this.remove_styles_for_mobile();
	}
	this.appReadyToAccess = function(){
		$('.loader').addClass('appReadyToAccess');
		$('.loader').attr('pageLoad','false')
		$('.loader').attr('commantryLoad','false')
	}
	
	this.appResize = function(){
		CONFIG.objModule['search'].controler.managePanelSize();
		CONFIG.objModule['print'].controler.managePrintPannel();
		CONFIG.objModule['notes_popup'].controler.managePanelSize();
		CONFIG.objModule['bookmark'].controler.managePanelSize();
	}
	
}


$(window).resize(function(){ //resize window
	if(typeof(CONFIG.objModule['commonInfo'].controler)!="undefined")
	{
		CONFIG.objModule['commonInfo'].controler.getReady();
		CONFIG.objModule['commonInfo'].controler.appResize();
	}	
});
