// JavaScript Document

function controllerPrint(){
	
	thisPrintObj = this;
	this.moduleName = "print";
	this.arrChapters = new Array();
	this.arrSection = new Array();	
	
	this.init = function(){
		this.loadPrintPanel();
	}

	this.destroy = function(){
		this.arrChapters = new Array();
		this.arrSection = new Array();	
		this.hideForm();	
	}
	
	this.loadPrintPanel = function(){
		$('#print_popup').load(CONFIG.viewPath+"print.html",function(){
			thisPrintObj.start();
		});
	}
 
 	this.start = function(){
		this.arrChapters = CONFIG.objModule["toc"].controler.getChaptersList();         
		this.arrSection = CONFIG.objModule["toc"].controler.getFirstLevelSection();  
		this.setChapterList();
		this.getSection(this.getActiveChapterId());
		//this.printChapter(thisPrintObj.currentChapter,"ALL");
		this.setDynamicEvents();
		this.localizationString();
	}
	
	this.setChapterList = function(){
		$('#print_popup .chap_select select.chapter_list').empty();
		$.each(this.arrChapters,function(key,value){
			$('#print_popup .chap_select select.chapter_list').append(thisPrintObj.generateChapterList(value));
		});		
	}
	
	this.getActiveChapter = function(){
		return $('#print_popup .chap_select select.chapter_list option:selected').attr('chapSrc');
	}
	this.getActiveChapterId = function(){
		return $('#print_popup .chap_select select.chapter_list option:selected').attr('chapId');
	}
	this.getActiveSection = function(){
		return $('#print_popup .chap_select select.section_list option:selected').attr('secsrc');
	}
	this.generateChapterList = function(value){
		rootChapOption = $('<option/>',{'chapId':value.chapId,'chapSrc':value.chapSrc});
		rootChapOption.append(value.chapLabel+" : "+value.chapTitle); 
		
		return rootChapOption ;		
	}
	
	this.getSection = function(chapId){
		returnArrSection = new Array();
		$.each(this.arrSection[0],function(key,value){
			if(value.chapId == chapId)
				returnArrSection.push(value);
		})
		this.setSectionList(returnArrSection);
	}
	
	this.setSectionList = function(returnArrSection){
		$('#print_popup .chap_select select.section_list').empty();
		$('#print_popup .chap_select select.section_list').append($('<option/>',{'secId':'ALL','secSrc':'ALL'}).append("All"));
		$.each(returnArrSection,function(key,value){
			$('#print_popup .chap_select select.section_list').append(thisPrintObj.generateSectionList(value));
		});		
	}

	this.generateSectionList = function(value){
                if(!(value.secSrc.indexOf("v") > -1 )){
                    rootChapOption = $('<option/>',{'secId':value.secId,'secSrc':value.secSrc});
                    rootChapOption.append(value.secLabel+" : "+value.secTitle) 
                    return rootChapOption ;	
                }else{
                    return false;
                }
			
	}

	this.hideForm = function(){
		$('#print_popup').hide();
		$('nav.navbar .menus li.print_panel').removeClass("active");
	}
	
	this.localizationString = function(){
		$( "#print_popup .panel-heading" ).append(localizedStrings.print_popup_pannel.label.title.text);
		$( "#print_popup .panel-body .radio label:first-child span" ).text(localizedStrings.print_popup_pannel.current_chapter.radio.text);
		$( "#print_popup .panel-body .radio label:last-child span" ).text(localizedStrings.print_popup_pannel.selected_chapter.radio.text);
		$( "#print_popup .form-group:first-child .chap_label .pull-right" ).text(localizedStrings.print_popup_pannel.selected_chapter.label.chapter);
		$( "#print_popup .form-group:last-child .chap_label .pull-right" ).text(localizedStrings.print_popup_pannel.selected_chapter.label.section);
		$( "#print_popup button.cancel" ).text(localizedStrings.print_popup_pannel.cancel_btn.button.text);
		$( "#print_popup button.print_btn" ).text(localizedStrings.print_popup_pannel.print_btn.button.text);
	}
	
	this.setDynamicEvents = function(){
		$('nav.navbar .menus li.print_panel').unbind('click');
		$('nav.navbar .menus li.print_panel').click(function(){
			$('.custom_tooltip').addClass('hide');
			objModule.destroyModule(thisPrintObj.moduleName);
			$( "#print_popup" ).toggle();
			//$('#print_popup').show();
			$(this).addClass("active");
		});
		$('#print_popup .close_btn,#print_popup .cancel').unbind( "click" );
		$('#print_popup .close_btn,#print_popup .cancel').click(function(){
			thisPrintObj.hideForm();
		});		
		$("#print_popup .chap_select select.chapter_list").change(function () {
			
			thisPrintObj.arrChapters = CONFIG.objModule["toc"].controler.getChaptersList();         
		thisPrintObj.arrSection = CONFIG.objModule["toc"].controler.getFirstLevelSection();
			thisPrintObj.getSection(thisPrintObj.getActiveChapterId());   
       });
	   $("#print_popup .radio label").unbind( "click" );
	   $("#print_popup .radio label").click(function(){
		   	if($(this).find('input').attr('id')  == "curChap"){
				$("#print_popup .filter_container").addClass('hide');
			}else{
				$("#print_popup .filter_container").removeClass('hide');
			}
			thisPrintObj.managePrintPannel();
	   });
		$('#print_popup .print_btn').unbind( "click" );
		$('#print_popup .print_btn').click(function(){
			if($("input[name='print_chap']:checked").attr('id') == "curChap"){
				thisPrintObj.currentChapter = CONFIG.objModule["toc"].controler.getCurrentChapter(); 
				thisPrintObj.printChapter(thisPrintObj.currentChapter,"ALL");
			}else if($("input[name='print_chap']:checked").attr('id') == "selChap"){
				thisPrintObj.printChapter(thisPrintObj.getActiveChapter(), thisPrintObj.getActiveSection());
			}
		});		
	}

	this.managePrintPannel = function(){	
		if($(window).width() > 1020){
			$('#print_popup .chap_select').css('width', '320px')
		}else{
			$('#print_popup .chap_select').css('width', '100%').css('width', '-=153px');
		}     
	}

	this.printChapter = function(chap_id,sec_id){	
		chapterUrl=CONFIG.bookPath + "/" + CONFIG.objModule['commonInfo'].controler.getISBN() + "/" + CONFIG.prefix_volume + CONFIG.objModule['commonInfo'].controler.getVolumeNo()  + "/" + CONFIG.pagePath + "/"+chap_id+".html";
		$("#container iframe#hidden_container").attr("src",chapterUrl);	
		$("#container iframe#hidden_container").unbind('load');
		$("#container iframe#hidden_container").load(function(){
			if(sec_id == "ALL"){
                                
                                cssStr = "";
				
                                
				$("#container iframe#hidden_container").ready(function(e) {  
					$("#container iframe#hidden_container")[0].contentWindow.MathJax.Hub.Queue(function () 
					{ 
                                            
                                            $(window.frames["hidden_container"].document.getElementsByClassName("section")).each(function(){
                                                if($(this).attr("id").indexOf("v") > -1 ){
                                                    $(this).attr("style","display:none;");
                                                }
                                            });
                                             
                                             //var mathJaxCss='<style type="text/css"> @media print{  .MathJax span {display: none; position: static; border: 0; padding: 0; margin: -10px; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   }} </style>';
                                            $("#container iframe#hidden_container").contents().find('html,body').print(cssStr);
                                            //window.frames["hidden_container"].print();
					});
				})
			}else{
				cssStr = "";
				$.each($("#container iframe#hidden_container").contents().find('html,body').find('link'),function(){
					path = CONFIG.bookPath + "/" + CONFIG.objModule['commonInfo'].controler.getISBN() + "/" + CONFIG.prefix_volume + CONFIG.objModule['commonInfo'].controler.getVolumeNo()  + "/" + CONFIG.pagePath + "/";
					cssName = $(this).attr('href')
					
					$(this).removeAttr('href') ;
					cssStr +=  '<link rel="stylesheet" type="text/css" href="'+path+cssName+'">'
				})
				headData = $("#container iframe#hidden_container").contents().find('html,body').find('head').html();
                                
                                    $(window.frames["hidden_container"].document.getElementsByClassName("section")).each(function(){
                                    if($(this).attr("id").indexOf("v") > -1 ){
                                        $(this).attr("style","display:none;");
                                    }
                                    });
                                
				$("#container iframe#hidden_container").contents().find('html,body').find('.section#'+sec_id.replace(/\./gi, "\\.")).print(cssStr);
			}
		});
	}
}


jQuery.fn.print = function(head=''){
    // NOTE: We are trimming the jQuery collection down to the
    // first element in the collection.
    if (this.size() > 1){
        this.eq( 0 ).print();
        return;
    } else if (!this.size()){
        return;
    }

    // ASSERT: At this point, we know that the current jQuery
    // collection (as defined by THIS), contains only one
    // printable element.

    // Create a random name for the print frame.
    var strFrameName = ("printer-" + (new Date()).getTime());
    // Create an iFrame with the new name.
    var jFrame = $( "<iframe name='" + strFrameName + "'>" );

    // Hide the frame (sort of) and attach to the body.
    jFrame
        .css( "width", "1px" )
        .css( "height", "1px" )
        .css( "position", "absolute" )
        .css( "left", "-9999px" )
        .appendTo( $( "body:first" ) )
    ;

    // Get a FRAMES reference to the new frame.
    var objFrame = window.frames[ strFrameName ];

    // Get a reference to the DOM in the new frame.
    var objDoc = objFrame.document;

    // Grab all the style tags and copy to the new
    // document so that we capture look and feel of
    // the current document.

    // Create a temp document DIV to hold the style tags.
    // This is the only way I could find to get the style
    // tags into IE.
    var jStyleDiv = $( "<div>" ).append(
        $( "style" ).clone()
        );

    // Write the HTML for the document. In this, we will
    // write out the HTML of the current element.
    objDoc.open();
    objDoc.write( "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">" );
    objDoc.write( "<html xmlns:xs=\"http://www.w3.org/2001/XMLSchema\" xmlns:oasis=\"http://www.niso.org/standards/z39-96/ns/oasis-exchange/table\" xmlns:m=\"http://mulberrytech.com/xslt/oasis-html/util\">" );
    objDoc.write( "<body>" );
    objDoc.write( "<head>" );
    //debugger;
    
    //objDoc.write("<style>span.inline-formula {display: inline-block;margin-right: 121px;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 1.12em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>'");
    //objDoc.write("<style>.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style>#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style>.MathJax_Preview .MJXf-math {color: inherit!important} </style><style>.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style>#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style>.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style>.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: ''}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style>.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid;display:none;}</style>");
    //objDoc.write("<style>.MathJax{display:none;}.MathJax_Preview{display:none;}</style>");
    if(head !== 'undefined'){
        objDoc.write(head);
        /*if(head==''){
            head = '<link rel="stylesheet" type="text/css" href="../asce_content/book/1234123456788/vol-24/pages/jats-preview.css"><link rel="stylesheet" type="text/css" href="../asce_content/book/1234123456788/vol-24/pages/../../../../fancybox/jquery.fancybox.css?v=2.1.5">';
            objDoc.write(head);  
        }*/
    }
    
    //objDoc.write( '<script type="text/javascript" src="//cdn.mathjax.org/mathjax/2.4-latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>' );
    objDoc.write( '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML"></script>' );
    objDoc.write('<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script><script type="text/javascript"> $(this.document).ready(function(e) { MathJax.Hub.Queue(function () {window.print();});})</script>');
    //objDoc.write('<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script><script type="text/javascript"> $(this.document).ready(function(e) { window.print();})</script>');
    console.log("Testing is going on");
    objDoc.write( "<title>" );
    if(document.title!='undefined')
    objDoc.write( document.title );
    objDoc.write( "</title>" );
    objDoc.write( "</head>" );
    objDoc.write( jStyleDiv.html() );
    
    var mathJaxCss = '<style type="text/css">@page{size: auto;margin: 10mm 10mm 10mm 10mm;} MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MathJax_Preview .MJXf-math {color: inherit!important} </style><style type="text/css">.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style type="text/css">.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
    //var stylesheetval = '<style>span.inline-formula {display: inline-block;margin-right: 121px;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 1.12em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>';
                                    
    //var bodyforprint = $('#container').html();
    //bodyforprint = bodyforprint+mathJaxCss;
    $(this).find('img').remove();
    objDoc.write( this.html() +mathJaxCss);
    //objDoc.write(bodyforprint);
    objDoc.write( "</body>" );
    objDoc.write( "</html>" );
    objDoc.close();

    // Print the document.
    objFrame.focus();
    $(objFrame).load(function(){ 
	});
    // Have the frame remove itself in about a minute so that
    // we don't build up too many of these frames.
    setTimeout(
        function(){
            jFrame.remove();
        },
        (60 * 1000)
        );
}
