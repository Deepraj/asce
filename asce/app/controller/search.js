// JavaScript Document

function controllerSearch(){

	thisSearchObj = this;
	this.moduleName = "search";
	this.timer = null;
	this.arrSearchChapter = "";
	this.advanceSearchStatus = false;
	this.search_rawtext ="";
	this.searchContentType = "";
	this.last_search_sec_id = "";
	this.searchSecId = 0;
		
	this.init = function(){
		this.loadPanel();
	}
	
	this.destroy = function(){
		this.resetHighlight(); 	
		this.closePanel();
		this.timer = null;
		$('#booksearch').empty();
		$('#booksearch').hide();
		$('nav.navbar .menus li.search_btn').removeClass("active");
	}
	
	this.closePanel = function(){
		$('#booksearch .advance_filter .refine_search').hide();
		$('#booksearch .search_panel').show();
		$('#booksearch .search_result').show();
		$('#booksearch .search_area').show();
		$('#booksearch .advance_filter .filter_chapter').hide();
		$('#booksearch .advance_filter .btn_container').hide();
	}
	
	this.loadPanel = function(){
		$("#booksearch").load(CONFIG.viewPath+"search.html",function(){
			thisSearchObj.start();
		});	
	}
	
	this.start = function(){
		this.clearSearchContent();
		this.setDynamicEvents();
		this.refineSearchPanel();
		this.loadChapterList();
		this.localizationString();
	}
	
	this.loadChapterList = function(){
		$('.filter_chapter .radio #adv_srch_chap_from').empty();
		$('.filter_chapter .radio #adv_srch_chap_to').empty();
		this.arrSearchChapter = CONFIG.objModule["toc"].controler.getChaptersList();         
		$.each(this.arrSearchChapter,function(key,value){
			//debugger;
			//if(value.chappaneltype != "PAGES")
			//	return true;		
			$('.filter_chapter .radio #adv_srch_chap_from').append(thisSearchObj.generateSearchChapter(value));
			$('.filter_chapter .radio #adv_srch_chap_to').append(thisSearchObj.generateSearchChapter(value));
		});
	};

	this.generateSearchChapter = function(value){
		rootLoadOption = $('<option/>').attr('id',value.chapId).append(value.chapSrc);
		
		return rootLoadOption;
	}
	
	this.searchContent = function(){
		//debugger;
		if(thisSearchObj.getSearchContent().length){
			CONFIG.objModule[this.moduleName].model.getSearchList(thisSearchObj.advanceSearchFilter());
		}else{
			bootbox.alert("Please enter a term to search");
		}
	}
	
	this.getSearchContent = function(){
		return $('#booksearch .search_panel input').val();
	}
	
	this.setRecordCount = function(count,total){
		$('#booksearch .search_panel .search_result .b_blue .pull-right').html(count+" / "+total);
	}
	
	this.getListCount = function(){
		return $('#booksearch .search_panel .search_container .search_content').length;
	}
	
	this.setSearchList = function(dbResultset){
		if(!Number(dbResultset.count)){			
			noResultDiv = $('<div/>',{'class':'noresult'});
			$('#booksearch .search_panel .search_container').append(noResultDiv.append(localizedStrings.search_popup_pannel.label.information.noResultFound));
			thisSearchObj.setRecordCount(0,0);
			$('#booksearch .search_result').show();		
			return true;
		}
		
		if(dbResultset.count == thisSearchObj.getListCount()){
			$('#booksearch .search_panel .search_container .search_load').remove();
			thisSearchObj.setRecordCount(thisSearchObj.getListCount(),dbResultset.count);
			return true;
		}
		
		$.each(dbResultset.record,function(key,value){
			$('#booksearch .search_panel .search_container').append(thisSearchObj.generateSearchContainer(value));
		});
		thisSearchObj.refineSearchPanel();
		$('#booksearch .search_panel .search_container .search_load').remove();
		rootLoadDiv = $('<div/>',{'class':'row text-center search_load'});	
		rootLoadDiv.append($('<i/>',{'class':'fa fa-circle-o-notch fa-spin','style':"color:#19A1CF"}));
		$('#booksearch .search_panel .search_container').append(rootLoadDiv);
		$('#booksearch .search_panel .search_container .search_load').hide();
		thisSearchObj.setRecordCount(thisSearchObj.getListCount(),dbResultset.count);
		thisSearchObj.managePanelSize();
		thisSearchObj.setDynamicEvents();
	}
	
	this.generateSearchContainer = function(value){
		rootDivOption = $('<div/>',{'class':'row search_content','chap_link_id':value.m_cntchapid,'sec_link_id':value.m_cntlinkid,'content_type': value.m_cntpaneltype,'section_type':value.m_cnttype,'toc_type':value.toctype});	
		notification = $("<div class='notification'></div>");
		noti_span = $("<span></span>");
		notification.append(noti_span);
		if(value.m_cntpaneltype == "PAGES"){
			noti_span.append(localizedStrings.search_popup_pannel.searchresult.notification.page);
		}else if(value.m_cntpaneltype == "COMMENTARY"){
			noti_span.append(localizedStrings.search_popup_pannel.searchresult.notification.commentry);
		}
		rootDivOption.append(notification);
		resultCell = $('<div/>',{'class':'resultcell'});
		rootDivOption.append(resultCell);
		strSearch = thisSearchObj.getSearchContent()
		var regex = new RegExp("(" + (strSearch == '.' ? '\\' + strSearch:strSearch) + ")", "gi");	
		var seachTitle = value.m_cntlabel+" "+value.m_cnttitle;
		var searchSectionHighlight = seachTitle.replace(regex, '<span class="search_highlight_section">$&</span>');	
		SectionNameOption = $('<div/>',{'class':'sec_name'});
		resultCell.append(SectionNameOption.append(searchSectionHighlight));
		SearchContentOption = $('<div/>',{'class':'h_result'});
		if(typeof(value.m_cntcaption) != "undefined" && typeof(value.m_cntcaption) == "string"){
		   var searchContentHighlight = value.m_cntcaption.replace(regex, '<span class="highlight_search"><b>$&</b></span>');	
			resultCell.append(SearchContentOption.append(searchContentHighlight));
		}
		return rootDivOption;				
	}
	
	this.EmptyListContainer = function(){
		$('#booksearch .search_panel .search_container').empty();	
	}
	
	this.clearSearchContent = function(){
		$('#booksearch .search_panel input').val("");
		$('#booksearch .search_panel input').focus();
		$('#booksearch .advance_filter .filter_chapter').hide();
		$('#booksearch .advance_filter .btn_container').hide();
		this.EmptyListContainer(); 
		this.setRecordCount(0,0);
	}
	
	this.advanceSearchPanel = function(){
		$('#booksearch .advance_filter .refine_search').show();
		$('#booksearch .advance_filter .filter_chapter').show();
		$('#booksearch .advance_filter .btn_container').show();
		//$('#booksearch .search_result').hide();
		this.managePanelSize();
	}

	this.advanceSearchBtn = function(){
		$('#booksearch .search_result').show();
		//this.refineSearchPanel();
		this.managePanelSize();
		if(!thisSearchObj.getSearchContent().length){
			$('#booksearch .advance_filter .refine_search').hide();
			$('#booksearch .search_result').hide();		
		}
	}	
	
	this.refineSearchPanel = function(){
		if($('#booksearch .search_panel .search_container .search_content').length){
			$('#booksearch .advance_filter .refine_search').show();
			$('#booksearch .search_result').show();		
		}else{
			$('#booksearch .advance_filter .refine_search').hide();
			$('#booksearch .search_result').hide();		
		}
		$('#booksearch .search_panel input').focus();
	}
	
	this.setAdvanceSearchModeBtn = function(icon_status){
		//$("input[name='page_seach']").attr('checked', true);
		//$("input[name='commentry_seach']").attr('checked', true);
		//debugger
		// here code   for disabiled   from  and to  dropdown-------------
		$("#adv_srch_chap_from").prop("disabled",true);
            $("#adv_srch_chap_to").prop("disabled",true);
		$("input[name='chapter_search']").click(function(){
		 if($("input[name='chapter_search']:checked").attr('id')=="Selected"){
			 $("#adv_srch_chap_from").prop("disabled",false);
			 $("#adv_srch_chap_to").prop("disabled",false);
		 }
		})
		//end here------
		if(icon_status == "down"){
			$('#booksearch .search_panel .advance_filter .b_darkblue').find('span').removeClass('glyphicon-chevron-down');
			$('#booksearch .search_panel .advance_filter .b_darkblue').find('span').addClass('glyphicon-chevron-up');
			thisSearchObj.advanceSearchPanel();
		}else if(icon_status == "up"){
			$('#booksearch .search_panel .advance_filter .b_darkblue').find('span').removeClass('glyphicon-chevron-up');
			$('#booksearch .search_panel .advance_filter .b_darkblue').find('span').addClass('glyphicon-chevron-down');
			if(thisSearchObj.getListCount){
				$('#booksearch .advance_filter .filter_chapter').hide();
				$('#booksearch .advance_filter .btn_container').hide();
				$("input[name='page_seach']").attr('checked', true);
				$("input[name='commentry_seach']").attr('checked', true);
			}
			thisSearchObj.advanceSearchBtn();
		}
	}
		
	this.managePanelSize = function(){
		windowHeight = $(window).outerHeight();
		search_header = $('#booksearch .search_header').outerHeight();	
		search_area = $('#booksearch .search_area').outerHeight();	
		advance_filter = $('#booksearch .advance_filter').outerHeight();	
		advance_filter_btn = $('#booksearch .search_result .panel-heading').outerHeight();
		mainHeaderHeight = $('header.main_header').outerHeight();
		btn_container = $('.advance_filter .btn_container').outerHeight();
		search_container = windowHeight - (search_header + search_area + advance_filter + advance_filter_btn + mainHeaderHeight + btn_container);
		$('#booksearch .search_container').css({'max-height':search_container});	
	}
	
	this.advanceSearchFilter = function(){
		debugger;
		//$("input[name='page_seach']").attr('checked', true);
		//$("input[name='commentry_seach']").attr('checked', true);
		figure_caption = $("input[name='figure_caption']").is(':checked');
		table_caption = $("input[name='table_caption']").is(':checked');
		table_content = $("input[name='table_content']").is(':checked');
		reference = $("input[name='reference']").is(':checked');
		appendixes = $("input[name='appendixes']").is(':checked');
		front_matter = $("input[name='front_matter']").is(':checked');
		page_seach = $("input[name='page_seach']").is(':checked');
		commentry_seach = $("input[name='commentry_seach']").is(':checked');
		chapter_search = $("input[name='chapter_search']:checked").attr('id');
		adv_srch_chap_from = $("#adv_srch_chap_from option:selected").val();
		adv_srch_chap_to = $("#adv_srch_chap_to option:selected").val();
		
		if(thisSearchObj.advanceSearchStatus){
			advanceSearchStatus = "on";
		}else{
			advanceSearchStatus = "off";
		}
		
 		if(chapter_search == "Current" && page_seach ==false){
			chapter_search = CONFIG.objModule["toc"].controler.lastCommentary;
		}
		if(chapter_search == "Current" && commentry_seach ==false)
		{
			
			chapter_search = CONFIG.objModule["toc"].controler.lastChapter;
			
		}
		if(chapter_search == "Current" && page_seach ==true){
			chapter_search = CONFIG.objModule["toc"].controler.lastChapter;
		}
		
		search_value={
			"figure_caption":figure_caption,
			"table_caption":table_caption,
			"table_content":table_content,
			"reference":reference,
			"appendixes":appendixes,
			"front_matter":front_matter,
			"page_seach":page_seach,
			"commentry_seach":commentry_seach,
			"chapter_search":chapter_search,
			"adv_srch_chap_from":adv_srch_chap_from,
			"adv_srch_chap_to":adv_srch_chap_to,
			"searchText":thisSearchObj.getSearchContent(),
			"searchContentLength":thisSearchObj.getListCount(),
			"advanceSearchStatus":advanceSearchStatus
		}		
		thisSearchObj.advanceSearchStatus = false;
		
		return search_value;		
	}
	
	this.highlightText = function(link_id){
		link_id = link_id.replace("s","");
		thisSearchObj.resetHighlight(); 	
		strSearch = thisSearchObj.getSearchContent();
		var regex = new RegExp("(" + (strSearch == '.' ? '\\' + strSearch:strSearch) + ")", "gi");	
		thisSearchObj.last_search_sec_id =link_id.replace(/\./gi, "\\.");
		if(thisSearchObj.searchContentType == "COMMENTARY"){
			thisSearchObj.search_rawtext = $('.Commentry iframe').contents().find("#sc"+thisSearchObj.last_search_sec_id).html();
			high_search = thisSearchObj.search_rawtext.replace(regex, '<span class="search_highlight_section">$&</span>');
			$('.Commentry iframe').contents().find("#sc"+thisSearchObj.last_search_sec_id).html(high_search);
		}else if(thisSearchObj.searchContentType == "PAGES"){
			thisSearchObj.search_rawtext = $('.Page iframe').contents().find("#s"+thisSearchObj.last_search_sec_id).html();
			high_search = thisSearchObj.search_rawtext.replace(regex, '<span class="search_highlight_section">$&</span>');
			$('.Page iframe').contents().find("#s"+thisSearchObj.last_search_sec_id).html(high_search);
		}
	}
	
	this.resetHighlight = function(){
		if(typeof(thisSearchObj.last_search_sec_id) != "" && typeof(thisSearchObj.search_rawtext) != ""){
			if(thisSearchObj.searchContentType == "COMMENTARY"){
				$('.Commentry iframe').contents().find("#sc"+this.last_search_sec_id).html(thisSearchObj.search_rawtext);
			}else if(thisSearchObj.searchContentType == "PAGES"){
				$('.Page iframe').contents().find("#s"+this.last_search_sec_id).html(thisSearchObj.search_rawtext);
			}
		}
	}
	
	this.localizationString = function(){
		$( "#booksearch .search_header > .panel-heading" ).append(localizedStrings.search_popup_pannel.label.title.text);
		$( "#booksearch .advance_filter .cancel").text(localizedStrings.search_popup_pannel.cancel_btn.button.text);
		$( "#booksearch .advance_filter .search_btn").text(localizedStrings.search_popup_pannel.search_btn.button.text);
		$( "#booksearch .search_area input" ).attr('placeholder',localizedStrings.search_popup_pannel.input_search.placeholder.text);
		$( "#booksearch .advanced_search_pannel > .panel-heading" ).append(localizedStrings.search_popup_pannel.advance_srch_btn.button.text);
		$( "#booksearch .refine_search .panel-heading" ).append(localizedStrings.search_popup_pannel.refine_srch.title.text);
		$( "#booksearch .refine_search .figure_caption" ).append(localizedStrings.search_popup_pannel.refine_srch.checkbox.Figure_Captions);
		$( "#booksearch .refine_search .table_caption" ).append(localizedStrings.search_popup_pannel.refine_srch.checkbox.Tables_with_Captions);
		$( "#booksearch .refine_search .table_content" ).append(localizedStrings.search_popup_pannel.refine_srch.checkbox.Table_of_Contents);
		$( "#booksearch .refine_search .reference" ).append(localizedStrings.search_popup_pannel.refine_srch.checkbox.References);
		$( "#booksearch .refine_search .appendixes" ).append(localizedStrings.search_popup_pannel.refine_srch.checkbox.Appendixes);
		$( "#booksearch .refine_search .front_matter" ).append(localizedStrings.search_popup_pannel.refine_srch.checkbox.Front_matter);
		$( "#booksearch .filter_chapter .page_seach" ).append(localizedStrings.search_popup_pannel.adv_srch.checkbox.Page);
		$( "#booksearch .filter_chapter .commentry_seach" ).append(localizedStrings.search_popup_pannel.adv_srch.checkbox.Commentry);
		$( "#booksearch .filter_chapter .Current" ).append(localizedStrings.search_popup_pannel.adv_srch.radio.current_Chap);
		$( "#booksearch .filter_chapter .All" ).append(localizedStrings.search_popup_pannel.adv_srch.radio.All_Chapter);
		$( "#booksearch .filter_chapter .Selected" ).append(localizedStrings.search_popup_pannel.adv_srch.radio.selected_Chapter);
		$( "#booksearch .filter_chapter .adv_srch_chap_from" ).append(localizedStrings.search_popup_pannel.adv_srch.label.From);
		$( "#booksearch .filter_chapter .adv_srch_chap_to" ).append(localizedStrings.search_popup_pannel.adv_srch.label.To);
		$( "#booksearch .search_result .b_blue .pull-left" ).text(localizedStrings.search_popup_pannel.srch_result.title.text);
	}
	
	this.setDynamicEvents = function(){
		$( "#booksearch #adv_srch_chap_from" ).unbind('change');
		$( "#booksearch #adv_srch_chap_from" ).change(function(){ 
			selectedValue = $("#adv_srch_chap_from option:selected").val();
			$( '#adv_srch_chap_to' ).val(selectedValue);
		})
		$( "#booksearch #adv_srch_chap_to" ).unbind('change');
		$( "#booksearch #adv_srch_chap_to" ).change(function(){
			from = Number($("#adv_srch_chap_from option:selected").val());
			to = Number($("#adv_srch_chap_to option:selected").val());
			if(from > to){
				bootbox.alert(localizedStrings.search_popup_pannel.information.alertmsg.chapter_should_be_high,function(){
					selectedValue = $("#adv_srch_chap_from option:selected").val();
					$( '#adv_srch_chap_to' ).val(selectedValue);
				});
			}
		})
		
		
		$('nav.navbar .menus li.search_btn').unbind('click');
		$('nav.navbar .menus li.search_btn').click(function(){
			$('.custom_tooltip').addClass('hide');
			objModule.destroyModule(thisSearchObj.moduleName);
			$( "#booksearch" ).toggle();
			//$('#booksearch').show();
			$(this).addClass("active");
			thisSearchObj.init();
		});	
		$('#booksearch .close_btn,#booksearch .cancel').unbind('click');
		$('#booksearch .close_btn,#booksearch .cancel').click(function(){
			thisSearchObj.destroy();
		});	
		$('#booksearch .search_btn').unbind('click');
		$('#booksearch .search_btn').click(function(){
			if(thisSearchObj.getSearchContent().length){
				thisSearchObj.advanceSearchStatus = true;
				thisSearchObj.advanceSearchBtn();
				thisSearchObj.setRecordCount(0,0);
				thisSearchObj.EmptyListContainer(); 
			}
			thisSearchObj.searchContent();
		});	
		$('#booksearch .advance_filter .refine_search .checkbox label input').unbind('change');
		/* $('#booksearch .advance_filter .refine_search .checkbox label input').change(function(){
			thisSearchObj.setRecordCount(0,0);
			thisSearchObj.EmptyListContainer(); 
			thisSearchObj.searchContent();
		});	 */			
		$('#booksearch .search_panel input').unbind('keyup');
		$('#booksearch .search_panel input').keyup(function(e){
			if(e.keyCode >= 37 && e.keyCode <= 40 || e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode == 8 || e.keyCode == 13 || e.keyCode >= 96 && e.keyCode <= 111 || e.keyCode == 46){
				objSearchContent = this;
				thisSearchObj.setRecordCount(0,0);
				thisSearchObj.EmptyListContainer(); 
				clearTimeout(thisSearchObj.timer);
				searchvalue=$(objSearchContent).val().trim();
				//when empty search field hide unwanted thinks
				if(searchvalue.length == 0){
					//debugger;
					//thisSearchObj.refineSearchPanel();
					$('#booksearch .search_panel .clear').hide();
				}else{
					$('#booksearch .search_panel .clear').show();
				}
				thisSearchObj.timer = setTimeout(function (event) {				
					if(searchvalue.length > 0){
						thisSearchObj.searchContent();
					}
					thisSearchObj.timer = null;
				},1000);
			}
		});		
		$('#booksearch .search_panel .clear').unbind('click');
		$('#booksearch .search_panel .clear').click(function(){
			thisSearchObj.setAdvanceSearchModeBtn("up");
			thisSearchObj.clearSearchContent();
			thisSearchObj.refineSearchPanel();
			thisSearchObj.resetHighlight();
		});
		$('#booksearch .search_panel .advance_filter .b_darkblue').unbind('click');
		$('#booksearch .search_panel .advance_filter .b_darkblue').click(function(){
			this.setAdvanceSearchModeBtn 
			if($(this).find('span').hasClass('glyphicon-chevron-down')){
				thisSearchObj.setAdvanceSearchModeBtn("down");
			}else{
				thisSearchObj.setAdvanceSearchModeBtn("up");
				$(".refine_search").hide();
			}
		});		
		$('#booksearch .search_panel .search_container .search_content').unbind('click');
		$('#booksearch .search_panel .search_container .search_content').click(function(){
			chapId = $(this).attr('chap_link_id');
			content_type = $(this).attr('content_type'); 
			section_type = $(this).attr('section_type');
			toc_type = $(this).attr('toc_type');
			thisSearchObj.searchContentType = content_type;	
			if(thisSearchObj.searchContentType == "COMMENTARY"){
				thisSearchObj.searchSecId = $(this).attr('sec_link_id');//.replace("sc","s");
			}else if(thisSearchObj.searchContentType == "PAGES"){
				thisSearchObj.searchSecId = $(this).attr('sec_link_id');
			}
			CONFIG.objModule["toc"].controler.goToSection(thisSearchObj.searchSecId,chapId,section_type,content_type,toc_type);
		});
		$('#booksearch .search_panel .search_container').unbind('scroll');
		$('#booksearch .search_panel .search_container').scroll(function() {
			if ($(this).scrollTop()+ $(this).innerHeight() == $(this)[0].scrollHeight && $('#booksearch .search_panel .search_container .search_content').length ){
				thisSearchObj.searchContent();
				$('#booksearch .search_panel .search_container .search_load').show();
			}
		});
	}
}
