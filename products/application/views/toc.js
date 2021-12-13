//Copyright@ MPS Ltd 2015
/**
 * module management
 * 
 * @author satheesh
 * @author Arulkumar Updated Date:17-08-15
 */
var historyarray = [];
function controlerToc() {
	
	thisTocObj = this;
	var bookName = '';
	// thisHistoryObj=this;
	this.moduleName = "toc";
	this.viewSrc = objModule.getView(this.moduleName);
	this.arrChapters = new Array();
	this.arrContents = new Array();
	this.arrSection = new Array();
	this.arrNavigation = new Array();
	this.arrRawSection = new Array();
	this.arrNavigationList = new Array();
	this.arrNavigationListLink = new Array();
	this.commentryFilePrefix = {
		'CONTENT' : {
			'commentry' : "chc",
			'page' : 'ch'
		},
		'APPENDIX' : {
			'commentry' : "apc",
			'page' : 'ap'
		},
		'FRONT_MATTER' : {
			'commentry' : "cfm",
			'page' : 'fm'
		}
	};

	this.fileExt = ".html";
	this.lastChapter = 0;
	this.lastCommentary = 0;
	this.lastPanelType = '';
	this.lastSec = 0;
	this.bufferChapter = 0;
	this.chapterPath = "";
	this.commentaryPath = "";
	this.historyPagePath=CONFIG.bookHistoryPath;
	this.init = function() {
		this.setChapterPath();
		this.setCommentaryPath();
		this.loadView();

		// CONFIG.objModule[this.moduleName].model
	}

	$(document).ready(function() {
		$('#commentry_frame').bind('mouseover', function() {
			var iframeID = $(this).attr('id');
			$(this).contents().unbind();
			$(this).contents().bind('click', function() {
				currentFrame = 'commentry'
			});
		});
	});
	$(document).ready(function() {
		$('#page_frame').bind('mouseover', function() {
			var iframeID = $(this).attr('id');
			$(this).contents().unbind();
			$(this).contents().bind('click', function() {
				currentFrame = 'pagevalue'
			});
		});
	});

	this.destroy = function() {
		this.chapterPath = ""
		this.commentaryPath = ""
	}

	this.loadView = function() {
		thisTocObj.start();
		// thisHistoryObj.start();
		/*
		 * $('#toc').load(CONFIG.viewPath+this.viewSrc,function(){ });
		 */
	}
	this.setChapterPath = function() {
		this.chapterPath = CONFIG.bookPath + "/"
				+ CONFIG.objModule['commonInfo'].controler.getISBN() + "/"
				+ CONFIG.prefix_volume
				+ CONFIG.objModule['commonInfo'].controler.getVolumeNo() + "/"
				+ CONFIG.pagePath + "/";
	}

	this.setCommentaryPath = function() {
		this.commentaryPath = CONFIG.bookPath + "/"
				+ CONFIG.objModule['commonInfo'].controler.getISBN() + "/"
				+ CONFIG.prefix_volume
				+ CONFIG.objModule['commonInfo'].controler.getVolumeNo() + "/"
				+ CONFIG.commentryPath + "/";
	}

	this.start = function() {
		this.manageCustomScroll();
		this.getChapters();
		this.generateNavigationList();
	}

	this.getChapters = function() {
		if (!arguments.length) {
			CONFIG.objModule[this.moduleName].model.getChapterList();
			console.log(arguments);
		} else if (arguments[0]['ChapterDetails'].length) {
			/*
			 * console.log('Get Chapters Start');
			 * console.log(arguments[0]['ChapterDetails']);
			 * console.log('End....');
			 */
			thisTocObj.arrChapters = arguments[0]['ChapterDetails'];
			thisTocObj.historyContents = arguments[0]['historyContents'];
			thisTocObj.arrSection = arguments[0]['SectionDetails'];
			thisTocObj.arrRawSection = arguments[0]['RawSection'];
			thisTocObj.populateToc();
			CONFIG.objModule['commonInfo'].controler.getReady();
			thisTocObj.getFirstLevelSection();
			thisTocObj.loadChapter(thisTocObj.arrChapters[0].chapSrc);
			thisTocObj.bookName = arguments[0]['ChapterDetails'][0].m_boktitle;
			// alert(thisTocObj.bookName);
			$("#currentBookTitle").html(thisTocObj.bookName);
			// alert(thisTocObj.bookName);
		} else {
			bootbox.alert(localizedStrings.TOC.error.alertmsg.noChapter,
					function() {
						CONFIG.objModule.myaccount.model.doLogout();
					});
		}
	}
	/*-----------------------For Getting List Of Contents-----------*/
	/*
	 * this.getHistoryContents = function(){ if(!arguments.length){
	 * CONFIG.objModule[this.moduleName].model.getHistoryContentList();
	 * console.log('Start Get Chapters'); console.log(arguments[0]);
	 * console.log('End Get Chapters'); } else if(
	 * arguments['historyContents'].length ){ alert('Under Contents');
	 * thisHistoryObj.arrContents = arguments[0]['historyContents'];
	 * CONFIG.objModule['commonInfo'].controler.getReady(); }else{
	 * bootbox.alert(localizedStrings.TOC.error.alertmsg.noChapter, function(){
	 * CONFIG.objModule.myaccount.model.doLogout(); }); } }
	 */
	this.getContentList = function() {
		return this.historyContents;
	}
	/*--------------------------------End---------------------------*/
	this.getChaptersList = function() {
		return this.arrChapters;
	}
	this.getFirstLevelSection = function() {
		return this.arrSection[0];
	}

	this.generateNavigationList = function() {
		CONFIG.objModule[this.moduleName].model.getNavigationList()
	}

	this.getCurrentChapter = function() {
		return this.lastChapter;
	}
	this.getCurrentCommentary = function() {
		return this.getCurrentCommentary;
	}
	this.populateToc = function() {
		this.clearForm();
		// build chapter
		chapterUl = $("<ul/>").addClass('main_toc');
		$.each(this.arrChapters, function(key, value) {
			if (value.chappaneltype == "PAGES") {
				$(chapterUl).append(
						thisTocObj.getChpaterStructure(value, "chap", 0));
			}
		});
		$('div#toc').append(chapterUl);

		// build Section

		secLevel = -1;
		section = $.extend(true, {}, this.arrSection);
		$
				.each(
						section,
						function(keyLevel, valueLevel) {
							if (secLevel != keyLevel) {
								secLevel = keyLevel;
								$
										.each(
												valueLevel,
												function(keyMasId, valueMasId) {
													$
															.each(
																	valueMasId,
																	function(
																			key1,
																			valueSec) {
																		if (secLevel == 0) {
																			if (!$(
																					"#toc li[chapid='"
																							+ valueSec.chapId
																							+ "']")
																					.children(
																							"ul").length) {
																				secUl = $(
																						"<ul/>",
																						{
																							'secLevel' : secLevel
																						});
																				$(
																						"#toc li[chapid='"
																								+ valueSec.chapId
																								+ "'] a")
																						.append(
																								$(
																										"<div/>")
																										.addClass(
																												'arrow down'));
																				$(
																						"#toc li[chapid='"
																								+ valueSec.chapId
																								+ "']")
																						.append(
																								secUl);
																			}
																		} else {
																			if (!$(
																					"#toc li[secid='"
																							+ valueSec.secMasterId
																							+ "']")
																					.children(
																							"ul").length) {
																				secUl = $(
																						"<ul/>",
																						{
																							'secLevel' : secLevel
																						});
																				$(
																						"#toc li[secid='"
																								+ valueSec.secMasterId
																								+ "'] a")
																						.append(
																								$(
																										"<div/>")
																										.addClass(
																												'arrow down'));
																				$(
																						"#toc li[secid='"
																								+ valueSec.secMasterId
																								+ "']")
																						.append(
																								secUl);
																			}
																		}

																		$(secUl)
																				.append(
																						thisTocObj
																								.getChpaterStructure(
																										valueSec,
																										"sec",
																										secLevel));
																	})
												})
							}
						});

		setTimeout(function() {
			thisTocObj.dynamicEvenHandler();
		}, 500)
		this.dynamicEvenHandler();
	}

	this.getChpaterStructure = function(chapValue, type, levle) {// alert(chapValue.toSource())

		if (type == "sec") {
			chapValue.chapId = chapValue.secId;
			chapValue.chapSrc = chapValue.secSrc;
			chapValue.chapLabel = chapValue.secLabel;
			chapValue.chapTitle = chapValue.secTitle;
			chapValue.chapPaneltype = chapValue.secPaneltype;
		}
		chapterLi = $("<li/>", {
			"listType" : type,
			'level' : levle
		});
		$(chapterLi).attr((type == "chap" ? "chapId" : "secId"),
				chapValue.chapId);
		$(chapterLi).attr((type == "chap" ? "chapSrc" : "secSrc"),
				chapValue.chapSrc);
		$(chapterLi).attr((type == "chap" ? "chapType" : "chapType"),
				chapValue.contenttype);
		$(chapterLi).attr((type == "chap" ? "chapLabel" : "secLabel"),
				chapValue.chapLabel);
		$(chapterLi).attr((type == "chap" ? "panelType" : "panelType"),
				chapValue.chapPaneltype);
		chapterA = $("<a/>");
		chapterDivTopic = $("<div/>").addClass('toc_topic');
		$(chapterLi).append(chapterA);
		$(chapterA).append(chapterDivTopic);
		if (chapValue.chapLabel != '') {
			$(chapterDivTopic).append($("<span/>", {
				class : "chapNo"
			}).append(chapValue.chapLabel + ":"));
		} else {
			$(chapterDivTopic).append($("<span/>", {
				class : "chapNo"
			}).append(chapValue.chapLabel));
		}
		chapter_title = chapValue.chapTitle;
		if (chapter_title.charAt(chapter_title.length - 1) == ".") {
			chapter_title = chapter_title.slice(0, -1);
		} // Remove last char [{.},{dot}] in chapter title
		$(chapterDivTopic).append($("<span/>", {
			class : "chapTitle"
		}).append(chapter_title));
		return chapterLi;
	}

	this.clearForm = function() {
		$('#toc').empty();
	}

	this.commonClose = function() {
		objModule.destroyModule(this.moduleName);
		$('.custom_tooltip').addClass('hide');
	}
	this.distroyFrames=function(){
		$('.Commentry iframe').contents().find("body").html("still loading please wait...");
		$('.Page iframe').contents().find("body").html("still loading please wait...");
	}

	this.dynamicEvenHandler = function() {
		// this.localizationString();
		$("#toc li[listType='chap']").unbind('click');
		$("#toc li[listType='chap']").click(function() {
			//debugger
			thisTocObj.commonClose();
			if (typeof ($(this).attr('chapSrc')) != "undefined") {
				if(thisTocObj.lastChapter!=$(this).attr('chapSrc')){
					thisTocObj.distroyFrames();
				}				
				thisTocObj.loadChapter($(this).attr('chapSrc'));
			}
			if ($(window).width() < 1020) { // bootstrap 3.x by Richard
				$('#container').addClass("hidetoc").removeClass("opentoc");
			}
		})
		$("#toc li[listType='sec']").unbind('click');
		$("#toc li[listType='sec']").click(function(event){
			//thisTocObj.distroyFrames();
			thisTocObj.commonClose();
			event.stopPropagation();
			if (typeof ($(this).attr('secsrc')) != "undefined") {
				var secTion1=$(this).attr('secsrc');
				var secTion2=$(this).parents("li[listType='chap']").attr('chapsrc');
				//debugger
				thisTocObj.goToSection(secTion1, secTion2);
				$('nav.navbar .section_no .present').val($(this).attr('secLabel'));
			}
			if ($(window).width() < 1020) { // bootstrap 3.x by Richard
				$('#container').addClass("hidetoc").removeClass("opentoc");
			}
		})
		$('.main_toc li a .arrow').unbind('click');
		$('.main_toc li a .arrow').click(function(event) {
			thisTocObj.commonClose();
			event.stopPropagation();
			$(this).toggleClass('down').toggleClass('up'); // for arrow
			$(this).parent('a').next('ul').toggleClass('open'); // for display
																// sub list
		});
		$('.expandall').unbind('click');
		$('.expandall').click(function() {
			thisTocObj.commonClose();
			$('.main_toc li a .arrow').removeClass('down').addClass('up');
			$('.main_toc li a .arrow').parent('a').next('ul').addClass('open');
		});
		$('.collapseall').unbind('click');
		$('.collapseall').click(
				function() {
					thisTocObj.commonClose();
					$('.main_toc li a .arrow').removeClass('up').addClass(
							'down');
					$('.main_toc li a .arrow').parent('a').next('ul')
							.removeClass('open');
				});

		$('.colorpicker li').unbind('click');
		$('.colorpicker li').click(function() {
			$('.colorpicker').addClass('hide');
		});
		// higlight events

		$('.custom_tooltip li').unbind('click');
		$('.custom_tooltip li').click(function(){
					//debugger
					var selectStaus = $(this).attr('class');
					$('.custom_tooltip').addClass('hide');
					var selected = thisTocObj.SelectionData.selected;
					var range = thisTocObj.SelectionData.range;
					var content = thisTocObj.SelectionData.content;
					var endNode = thisTocObj.SelectionData.endNode;
					var endOffset = thisTocObj.SelectionData.endOffset;
					var startNode = thisTocObj.SelectionData.startNode;
					var startOffset = thisTocObj.SelectionData.startOffset;
					var nodeName = thisTocObj.SelectionData.nodeName;
					var aa = thisTocObj.lastChapter;
					var bb = thisTocObj.lastCommentary;
					var paraContent=$(thisTocObj.objIframeMouse).find('#'+endNode).html();
					var secId=$(thisTocObj.objIframeMouse).find('[id^=s]').attr('id');
					if (!objModule.arrModule.highlight.active)
						return false;
					
					if (selectStaus == "highlight" && currentFrame=='pagevalue') {
					CONFIG.objModule["highlight"].controler.addHighlightText(secId,startOffset,endOffset,nodeName,					startNode, content, range,paraContent,aa);
					$('.colorpicker').removeClass('hide');
					} else if (selectStaus == "highlight"
							&& currentFrame == 'commentry') {
						CONFIG.objModule["highlight"].controler
								.addHighlightTexts($(thisTocObj.objIframeMouse)
										.children('[id^=s]').attr('id'),
										startOffset, endOffset, nodeName,
										startNode, content, range, bb);
										
						$('.colorpicker').removeClass('hide');
					}

					if (selectStaus == "note" && currentFrame == 'pagevalue') {
						// alert("vgfghfgf");
						var noteId=CONFIG.objModule["notes_popup"].controler.coveretNote(range);
						var secId=$(thisTocObj.objIframeMouse).find("[newhigh_id='"+noteId+"']").closest('.section').attr('id'); 
						CONFIG.objModule["notes_popup"].controler.setNote(secId, startOffset, endOffset, nodeName,
								startNode, content, thisTocObj.lastChapter,$(thisTocObj.objIframeMouse).find('[id='+startNode+']').html(),noteId);
						$('.colorpicker').addClass('hide');
					} else if (selectStaus == "note"
							&& currentFrame == 'commentry') {
						// alert("vgfghfgf");
						var noteId=CONFIG.objModule["notes_popup"].controler.coveretNotes(range);
						var secId=$(thisTocObj.objIframeMouse).find("[newhigh_id='"+noteId+"']").closest('.section').attr('id');
						CONFIG.objModule["notes_popup"].controler.setNote(secId, startOffset, endOffset, nodeName,
								startNode, content, bb,$(thisTocObj.objIframeMouse).find('[id='+startNode+']').html(),noteId);
						$('.colorpicker').addClass('hide');
					}
//debugger   
					if (selectStaus == "bookmark" && currentFrame == 'pagevalue') {
						var bookMarkId=CONFIG.objModule["bookmark"].controler.coveredboookmark(range);
						CONFIG.objModule["bookmark"].controler.bookmarkSecId(
						$(thisTocObj.objIframeMouse).children('[id^=s]').attr('id'),
						startOffset, endOffset, nodeName, startNode, content, thisTocObj.lastChapter,
						$(thisTocObj.objIframeMouse).find('[id='+startNode+']').html(),bookMarkId);
						$('.colorpicker').addClass('hide');
					} else if (selectStaus == "bookmark"
							&& currentFrame == 'commentry') {
						var bookMarkId=CONFIG.objModule["bookmark"].controler.coveredboookmarks(range);
						CONFIG.objModule["bookmark"].controler.bookmarkSecId($(
								thisTocObj.objIframeMouse).children('[id^=s]')
								.attr('id'), startOffset, endOffset, nodeName,
								startNode, content, bb,$(thisTocObj.objIframeMouse).find('[id='+startNode+']').html(),bookMarkId);
						$('.colorpicker').addClass('hide');
					}
					if (selectStaus == "copy" && currentFrame == 'pagevalue') {
						$('.colorpicker').addClass('hide');
					} else if (selectStaus == "copy"
							&& currentFrame == 'commentry') {
						$('.colorpicker').addClass('hide');
					}
					selected.removeAllRanges();

				});

		/** *************** TOC Active class ***************** */

		$("nav.navbar .section_no .prop_value .left").unbind("click");
		$("nav.navbar .section_no .prop_value .left").click(function() {
			thisTocObj.commonClose();
			temp = "move_backward";
			thisTocObj.section_change(temp);
		});
		$("nav.navbar .section_no .prop_value .right").unbind("click");
		$("nav.navbar .section_no .prop_value .right").click(function() {
			thisTocObj.commonClose();
			temp = "move_forward";
			thisTocObj.section_change(temp);
		});
		$('nav.navbar .section_no .present').unbind("keypress");
		$('nav.navbar .section_no .present').keypress(function(e) {
			thisTocObj.commonClose();
			if (e.keyCode == 13) {
				last_sec_id = $('nav.navbar .section_no .present').val();
				temp = "move_current_position";
				thisTocObj.section_change(temp);
				// thisTocObj.goToSection($('nav.navbar .section_no
				// .present').val());
			}
		});
		$('aside header .pull-right').click(
				function() {
					thisTocObj.commonClose();
					if ($(this).hasClass('expandall')) {
						// alert("expand all");
						$('[data-accordion]').addClass('open');
						$('aside').toggleClass('expand_contain').toggleClass(
								'collapse_contain');
						// $('#multiple *').removeClass( "open" ).removeClass(
						// "close" ).removeAttr("style");
						$('#multiple *').removeAttr("style");
					} else {
						// alert("collapse all");
						$('[data-accordion]').removeClass('open');
						$('[data-content]').css({
							'max-height' : 0,
							'overflow' : 'hidden'
						});
						$('aside').toggleClass('expand_contain').toggleClass(
								'collapse_contain');
					}
				});

		$('.nav li').on('click', function() { // toggle nav bar function
			if ($(window).width() < 1020) {
				// $('aside,section.main_section section' ).addClass( "hide" );
				$(".btn-navbar").click(); // bootstrap 2.x
				$(".navbar-toggle").click(); // bootstrap 3.x by Richard
				$('#container').addClass("hidetoc").removeClass("opentoc");
			}
		});

		$("nav.navbar .split_design span").unbind("click");
		$("nav.navbar .split_design span").click(function() {
			thisTocObj.commonClose();
			$('#container').toggleClass("horizontal").toggleClass("vertical");
			thisTocObj.set_height_and_width();
		});

		$("nav li.toc").unbind("click");
		$("nav li.toc").click(function() {
			thisTocObj.commonClose();
			$('#container').toggleClass("hidetoc").toggleClass("opentoc");
			// $( "aside .glyphicon" )[0].click();
		});

		$("aside .glyphicon").unbind("click");
		$("aside .glyphicon").click(function() {
			thisTocObj.commonClose();
			$('#container').toggleClass("hidetoc").toggleClass("opentoc");
		});

		$(".page_article header .glyphicon").unbind("click");
		$(".page_article header .glyphicon").click(
				function() {
					thisTocObj.commonClose();
					$('#container').toggleClass("full_size_page").toggleClass(
							"non_full_view");
					thisTocObj.set_height_and_width();
				});

		$(".Commentry_article header .glyphicon").unbind("click");
		$(".Commentry_article header .glyphicon").click(
				function() {
					thisTocObj.commonClose();
					$('#container').toggleClass("full_size_commentry")
							.toggleClass("non_full_view");
					thisTocObj.set_height_and_width();
				});

		$("nav.navbar .font_prop .font_img").unbind("click");
		$("nav.navbar .font_prop .font_img")
				.click(
						function() {
							thisTocObj.commonClose();
							if (($('nav.navbar .zoom .present').text().replace(
									"%", "")) == 100) {
								$('#container').toggleClass("font_120");
								$('iframe').contents().find('body').attr({
									"style" : ""
								});
								$('iframe').contents().find('body')
										.toggleClass("font_120_iframe");
							} else {
								zoom_type = "reset";
								thisTocObj.pageZoom(zoom_type);
							}
						});

		$("nav.navbar .zoom .prop_value .plus").unbind("click");
		$("nav.navbar .zoom .prop_value .plus").click(function() {
			thisTocObj.commonClose();
			zoom_type = "plus";
			thisTocObj.pageZoom(zoom_type);
		});
		$("nav.navbar .zoom .prop_value .minus").unbind("click");
		$("nav.navbar .zoom .prop_value .minus").click(function() {
			thisTocObj.commonClose();
			zoom_type = "minus";
			thisTocObj.pageZoom(zoom_type);
		});

		// higlight events
	}

	this.localizationString = function() {

	}

	this.set_height_and_width = function() // set height width for all
	{
		CONFIG.objModule['commonInfo'].controler.set_height_and_width();
	}

	this.pageZoom = function(zoom_type) {
		$('#container').removeClass("font_120");
		zoom_perc = $('nav.navbar .zoom .present').text().replace("%", "");
		if (zoom_perc < 200 && zoom_perc >= 70 && zoom_type == "plus") {
			zoom_perc = parseInt(zoom_perc) + 10;
		}
		if (zoom_perc <= 200 && zoom_perc > 70 && zoom_type == "minus") {
			zoom_perc = parseInt(zoom_perc) - 10;
		}
		if (zoom_type == "reset") {
			zoom_perc = 100;
		}
		$("iframe").contents().find('body').css({
			'font-size' : zoom_perc + "%"
		});
		$('nav.navbar .zoom .present').text(zoom_perc + "%");
	}

	this.iframeEventss = function() {
                $('#page_frame').contents().find(".deletion").hide();
                $('#page_frame').contents().find(".insertion").css('color','black');
                $('#page_frame').contents().find(".section").each(function() {
                    var idvalue = $(this).attr('id');
                    var lenghofstring = idvalue.length;
                    var res = idvalue.charAt((lenghofstring-1))
                    if(res=="v"){
                        $(this).hide();
                        //$(this).attr("id",$(this).attr("id").replace('.',"_"));
                        var linkvalue = $("<a id='"+idvalue+"_history' class='history_view' href='#"+idvalue+"' style='color: white;font-size: 13px;cursor:pointer;'>>>Show Comparison to 7-10</a>");
                        var divsection = $("<div style='background-color: #808080;padding: 5px 10px;'><div>");
                        var finallinkdiv  = $(divsection).append(linkvalue)
                        $(this).before(finallinkdiv);
                        historyarray.push(idvalue);
                    }
                    $(linkvalue).click(function(){
                        var sectionid = $(this).attr('href');
                        //$(this).fancybox();
                        sectionid = sectionid.replace('#',"");
                        //debugger;
                        var contentvaluefancybox = $('#page_frame').contents().find("div[class='section'][id='"+sectionid+"']").html();
                        //var newvalue = $(contentvaluefancybox).contents()[0];
                        var stylesheetval = '<style>.deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}</style>';
                        var stylejs = '<script>$(".deletion").show();$(".insertion").css("color","green");</script>';
                        //debugger;
                        var divE=document.createElement("div");
                        divE.innerHTML=contentvaluefancybox;
                        var valuewithoutv = divE.firstChild.innerHTML ;
                        valuewithoutv = valuewithoutv.replace("v","");
                        divE.firstChild.innerHTML = valuewithoutv;
                        contentvaluefancybox = divE.innerHTML;
                        contentvaluefancybox = stylesheetval+contentvaluefancybox+stylejs;
                        $.fancybox({
                            content: contentvaluefancybox,
                            helpers : {
                            overlay : {
                            locked: false
                            }
                            },
                            'scrolling': 'yes',
                            'fitToView': false,
                            beforeLoad: function () {
				parent.show_table();
				$('.fancybox-outer').addClass('fancybox-skin');
                                
				},
                            beforeShow: function () {
                            $('.fancybox-outer').addClass('fancybox-skin');
                            $(".fancybox-skin").css("height", 600);
                            // set new values for parent container
                            this.width = 820;
                            this.height = 600;
                            },
                            beforeClose:function(){
                                parent.show_table();
                            },
                            afterShow: function() {
                                setTimeout(function(){ 
                                    $(".fancybox-skin").css("height", 300);
                                }, 1000);
                                
                            }
                        });
                    })
                });
                $('#page_frame').contents().find(".section").each(function() {
                    var idvalue = $(this).attr('id');
                    var lenghofstring = idvalue.length;
                    var res = idvalue.charAt((lenghofstring-1))
                    if(res!=='v'){
                        //debugger;
                        var withVIdValue = idvalue+"v";
                        if(historyarray.indexOf(withVIdValue)>-1){
                         $(this).css('border-left',' thick solid grey'); 
                         $(this).css('padding-left','10px'); 
                         
                        }
                    }
                });
                
                 
                
                
                
                //console.log(historyarray);
                
		$('.Commentry iframe').contents().find('book-part > .section').unbind(
				'mouseup');
		$('.Commentry iframe')
				.contents()
				.find('book-part > .section')
				.mouseup(
						function(event) {
							$('.colorpicker').addClass('hide');

							$($(this).siblings()).removeClass(
									'deselect_other_content');
							var frame = document
									.getElementById('commentry_frame');
							// alert("dsds");
							var frameWindow = frame && frame.contentWindow;
							var frameDocument = frameWindow
									&& frameWindow.document;
							var fullString = frameDocument
									.getElementsByTagName("body")[0].textContent;
							// alert(fullString);
							//debugger;
							if (frame.contentDocument) {
								var selected = frameWindow.getSelection();
								 var selobj =  window.getSelection();
								var range = selected.getRangeAt(0);
								var content = selected.toString();
								if (!$.trim(content).length) {

									if (frameDocument.getSelection) {
										if (frameDocument.getSelection().empty) { // Chrome
											frameDocument.getSelection()
													.empty();
										}/*  else if (frameDocument.getSelection().removeAllRanges) { // Firefox
											frameDocument.getSelection()
													.removeAllRanges();
										} */
									} else if (frameDocument.selection) { // IE?
										frameDocument.selection.empty();
									}
								}
								// console.log(getSelectedText('page_frame'));
								// debugger;
								if (thisTocObj
										.getSelectedText('commentry_frame') != ""
										&& $.trim(content).length) {
									if ($(window).width() > 1020) {
										$('.non_full_view .custom_tooltip')
												.removeClass('hide')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 115
																	+ ($(
																			'#toc .main_toc')
																			.width() + $(
																			'.page_article')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
														});
										$('.full_size_page .custom_tooltip')
												.removeClass('hide')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 180
																	+ ($(
																			'#toc .main_toc')
																			.width() + $(
																			'.page_article')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
														});
										$('.non_full_view .colorpicker')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 180
																	+ ($(
																			'#toc .main_toc')
																			.width() + $(
																			'.page_article')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
																	- 20
														});
										$('.full_size_page .colorpicker')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 180
																	+ ($(
																			'#toc .main_toc')
																			.width() + $(
																			'.page_article')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
																	- 20
														});
										$('.custom_tooltip').addClass(
												'current_highlight');
									}
									thisTocObj.objIframeMouseEvent = event;
									thisTocObj.objIframeMouse = this;

								} else {
									// console.log("text un select");
									$('.custom_tooltip').addClass('hide');
									$('.colorpicker').addClass('hide');
								}
								var endOffset = range.endOffset;
								var startOffset = range.startOffset;
								elemParentNodeStart = range.startContainer;
								elemParentNodeEnd = range.endContainer;
								run = true;
								while (run) {
									elemParentNodeStart = elemParentNodeStart.parentNode;
									elemParentNodeEnd = elemParentNodeEnd.parentNode;
									if ($.trim(elemParentNodeStart.id).length) {
										var endNode = elemParentNodeEnd.id;
										var nodeName = elemParentNodeEnd.nodeName;
										var startNode = elemParentNodeStart.id;
										run = false;
									}
								}
							}
							// debugger;
							thisTocObj.SelectionData = {
								selected : selected,
								range : range,
								content : content,
								endNode : endNode,
								endOffset : endOffset,
								startNode : startNode,
								startOffset : startOffset,
								nodeName : nodeName
							}

						});

		if ($('#container').hasClass('font_120') == true) {
			$("iframe").contents().find('body').addClass("font_120_iframe");
			$("iframe").contents().find('body').css({
				'style' : ''
			});
		} else {
			$("iframe").contents().find('body').css({
				'font-size' : $('nav.navbar .zoom .present').text()
			});
		}
                
	}

	this.iframeEvents = function() {
		
		$('.Page iframe').contents().find('book-part > .section').unbind('mouseup');
		$('.Page iframe').contents().find('book-part > .section').mouseup(function(event) {
							$('.colorpicker').addClass('hide');
							$($(this).siblings()).removeClass(
									'deselect_other_content');
									//debugger
							var frame = document.getElementById('page_frame');
							var frameWindow = frame && frame.contentWindow;
							var frameDocument = frameWindow&& frameWindow.document;
							var fullString = frameDocument
									.getElementsByTagName("body")[0].textContent;

							if (frame.contentDocument) {
								var selected = frameWindow.getSelection();
								 var selobj =  window.getSelection();
								var range = selected.getRangeAt(0);
								var content = selected.toString();
								if (!$.trim(content).length) {

									if (frameDocument.getSelection) {
										if (frameDocument.getSelection().empty) { // Chrome
											frameDocument.getSelection()
													.empty();
										} /* else if (frameDocument.getSelection().removeAllRanges) { // Firefox
											frameDocument.getSelection()
													.removeAllRanges();
										} */
									} else if (frameDocument.selection) { // IE?
										frameDocument.selection.empty();
									}
								}
								// console.log(getSelectedText('page_frame'));
								if (thisTocObj.getSelectedText('page_frame') != ""
										&& $.trim(content).length) {
									if ($(window).width() > 1020) {
										$('.non_full_view .custom_tooltip')
												.removeClass('hide')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 80
																	+ ($('#toc .main_toc')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
														});
										$('.full_size_page .custom_tooltip')
												.removeClass('hide')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 80
																	+ ($('#toc .main_toc')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
														});
										$('.non_full_view .colorpicker')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 80
																	+ ($('#toc .main_toc')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
																	- 20
														});
										$('.full_size_page .colorpicker')
												.css(
														{
															"position" : "absolute",
															"left" : event.pageX
																	- 80
																	+ ($('#toc .main_toc')
																			.width()),
															"top" : event.clientY
																	+ ($('#container .main_header')
																			.outerHeight())
																	- 20
														});
										$('.custom_tooltip').addClass(
												'current_highlight');
									}
									thisTocObj.objIframeMouseEvent = event;
									thisTocObj.objIframeMouse = this;

								} else {
									// console.log("text un select");
									$('.custom_tooltip').addClass('hide');
									$('.colorpicker').addClass('hide');
								}
								var endOffset = range.endOffset;
								var startOffset = range.startOffset;
								elemParentNodeStart = range.startContainer;
								elemParentNodeEnd = range.endContainer;
								run = true;
								while (run) {
									elemParentNodeStart = elemParentNodeStart.parentNode;
									elemParentNodeEnd = elemParentNodeEnd.parentNode;
									if ($.trim(elemParentNodeStart.id).length) {
										var endNode = elemParentNodeEnd.id;
										var nodeName = elemParentNodeEnd.nodeName;
										var startNode = elemParentNodeStart.id;
										run = false;
									}
								}
							}
							thisTocObj.SelectionData = {
								selected : selected,
								range : range,
								content : content,
								endNode : endNode,
								endOffset : endOffset,
								startNode : startNode,
								startOffset : startOffset,
								nodeName : nodeName
							}
						});

		if ($('#container').hasClass('font_120') == true) {
			$("iframe").contents().find('body').addClass("font_120_iframe");
			$("iframe").contents().find('body').css({
				'style' : ''
			});
		} else {
			$("iframe").contents().find('body').css({
				'font-size' : $('nav.navbar .zoom .present').text()
			});
		}

	}

	this.manageCustomScroll = function() {
		// $(".main_toc").mCustomScrollbar();
	}

	this.getSelectedText = function(frameId) {
		var frame = document.getElementById(frameId);
		var frameWindow = frame && frame.contentWindow;
		var frameDocument = frameWindow && frameWindow.document;
		if (frameDocument) {
			if (frameDocument.getSelection) {
				// Most browsers
				return String(frameDocument.getSelection());
			} else if (frameDocument.selection) {
				// Internet Explorer 8 and below
				return frameDocument.selection.createRange().text;
			} else if (frameWindow.getSelection) {
				// Safari 3
				return String(frameWindow.getSelection());
			}
		}
		return '';
	}

	this.loadSectionNavigation = function(chapSrc) {
		chapId = this.getChapIdWithChapSrc(chapSrc);
		$.each(this.getFirstLevelSection()[0], function(key, value) {
			if (chapId == value.chapId) {
				$('nav.navbar .section_no .present').val(value.secLabel);
				return false;
			}
		});
	}

	this.loadPageTitle = function() {
		$.each(this.getChaptersList(), function(key, value) {
			if (value.chapSrc == thisTocObj.lastChapter) {
				$('.content_container .page_article .title').html(
						"Chapter" + " " + value.chapSrc.replace("ch", "") + " "
								+ value.chapTitle);
			}
		});
	}
	/*------------------------------------------For Loading History Title------------------------*/
	this.loadHistoryTitle = function(oldVal) {
		isbn = CONFIG.objModule['commonInfo'].controler.getISBN();
		volume = CONFIG.objModule['commonInfo'].controler.getVolumeNo();
		$.each(this.getChaptersList(), function(key, value) {
			if (value.chapSrc == oldVal) {
				$('.content_container .page_article .title').html(
						"Chapter" + " " + value.chapSrc.replace("ch", "") + " "
								+ value.chapTitle);
			}
		});
	}
	/*-------------------------------------------------End---------------------------------------*/
	/*-------------------------------------------------Function For Checking File Exists Or Not------------------*/
	this.checkFileUrl = function(url) {
		if (url) {
			var req = new XMLHttpRequest();
			req.open('GET', url, false);
			req.send();
			return req.status == 200;
		} else {
			return false;
		}
	}
	/*------------------------------------------------------------------End--------------------------------------*/
	/*-------------------------------------------------Function For getting File Name Before _------------------*/
	this.getFirstUrl = function(url) {
		var n = url.indexOf('_');
		url = url.substring(0, n != -1 ? n : url.length);
		return url;
	}
	/*------------------------------------------------------------------End--------------------------------------*/
	this.loadChapter = function(chap) {// alert(chap)
	//debugger
		this.loadSectionNavigation(chap);
		chaptype = this.getChapContentTypeWithChapSrc(chap);
		paneltype = this.getChapPanelTypeWithChapSrc(chap);
		lastChapterTemp = 0;
		chapTemp = 1;
		if (this.lastChapter != '') {
                        chapTemp = chap.replace(this.commentryFilePrefix[chaptype].commentry, '');
			lastChapterTemp = this.lastChapter.replace(this.commentryFilePrefix[chaptype].commentry, '');
			chapTemp = chapTemp.replace(this.commentryFilePrefix[chaptype].page, '')
			lastChapterTemp = lastChapterTemp.replace(this.commentryFilePrefix[chaptype].page, '');
		}

		if (lastChapterTemp == chapTemp) {
			$("#page_frame").contents().find('html,body').animate({
				'scrollTop' : 0
			}, 'slow');
			$("#commentry_frame").contents().find('html,body').animate({
				'scrollTop' : 0
			}, 'slow');
			return true;
		}

		this.lastChapter = chap;
		this.lastPanelType = paneltype;
		this.loadPageTitle();
		if (paneltype == "PAGES") {
			commentryChap = chap.replace(
					this.commentryFilePrefix[chaptype].page,
					this.commentryFilePrefix[chaptype].commentry)
		} else {
			commentryChap = chap;
			chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
					this.commentryFilePrefix[chaptype].page);
		}

		this.lastPageChapter = chap;
		this.lastCommChapter = commentryChap;

		this.loadCommentary(commentryChap);
		checkFileStatus = this.checkFileUrl(this.chapterPath + chap
				+ this.fileExt);
                        
		chap = this.chapterPath + chap;
		newVal = CONFIG.bookPath + '/blank';
		chapWithPath = checkFileStatus == true ? chap : newVal;
		$(".Page iframe").attr("src", chapWithPath + this.fileExt);
		$('.Page iframe').unbind('load');
		$('.Page iframe').load(
				function() {
					thisTocObj.goToSection(0, 0);
					thisTocObj.iframeEvents();
					$('.Page iframe').contents().find('book-part > .section')
							.bind(
									'mousedown',
									function(event) {
										$($(this).siblings()).addClass(
												'deselect_other_content');
									});
					/*--------------------------Code for Unit Toggling--------------------------*/
					selected_Unit = $('select[name=unit_toogling]').val();
					thisTocObj.loadToggling(selected_Unit);
					/*----------------------------------End--------------------------------------*/
				});
		if (objModule.arrModule.highlight.active) {
			CONFIG.objModule["highlight"].controler
					.getHighlightText(this.lastChapter);
			CONFIG.objModule["notes_popup"].controler.showAllNotes();
			CONFIG.objModule["bookmark"].controler.showAllBookmark();
		}
	}
	/*-----------------------------------------------For Diffrent Edition Book--------------------------------*/
	/*------------------------------------------------------------------End--------------------------------------*/
	this.loadOriginalChapter = function(chap) {
		this.loadSectionNavigation(chap);
		chaptype = this.getChapContentTypeWithChapSrc(chap);
		paneltype = this.getChapPanelTypeWithChapSrc(chap);
		lastChapterTemp = 0;
		chapTemp = 1;
		if (this.lastChapter != '') {
			chapTemp = chap.replace(
					this.commentryFilePrefix[chaptype].commentry, '');
			lastChapterTemp = this.lastChapter.replace(
					this.commentryFilePrefix[chaptype].commentry, '');
			chapTemp = chapTemp.replace(
					this.commentryFilePrefix[chaptype].page, '')
			lastChapterTemp = lastChapterTemp.replace(
					this.commentryFilePrefix[chaptype].page, '');
		}
		this.lastChapter = chap;
		this.lastPanelType = paneltype;
		this.loadPageTitle();
		if (paneltype == "PAGES") {
			commentryChap = chap.replace(
					this.commentryFilePrefix[chaptype].page,
					this.commentryFilePrefix[chaptype].commentry)
		} else {
			commentryChap = chap;
			chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
					this.commentryFilePrefix[chaptype].page);
		}
		this.lastPageChapter = chap;
		this.lastCommChapter = commentryChap;
		this.loadCommentary(commentryChap);
		checkFileStatus = this.checkFileUrl(this.chapterPath + chap
				+ this.fileExt);
		chap = this.chapterPath + chap;
		newVal = CONFIG.bookPath + '/blank';
		chapWithPath = checkFileStatus == true ? chap : newVal;
		$(".Page iframe").attr("src", chapWithPath + this.fileExt);
		$('.Page iframe').unbind('load');
		$('.Page iframe').load(
				function() {
					thisTocObj.goToSection(0, 0);
					thisTocObj.iframeEvents();
					$('.Page iframe').contents().find('book-part > .section')
							.bind(
									'mousedown',
									function(event) {
										$($(this).siblings()).addClass(
												'deselect_other_content');
									});
					/*--------------------------Code for Unit Toggling--------------------------*/
					selected_Unit = $('select[name=unit_toogling]').val();
					thisTocObj.loadToggling(selected_Unit);
					/*----------------------------------End--------------------------------------*/
				});
		if (objModule.arrModule.highlight.active) {
			//alert(this.lastCommentary);
			CONFIG.objModule["highlight"].controler
					.getHighlightText(this.lastChapter);
		}
	}
	/*--------------------------------------------------------End---------------------------------------------*/
	/*------------------------------Method For Loading History Dynamic Contents Same Edition-------------------*/
	this.loadHistoryChapter = function(chap, oldVal, section) {// alert(chap)
		// alert('From Load History'+section);
		//debugger;
		this.loadSectionNavigation(chap);
		chaptype = this.getChapContentTypeWithChapSrc(chap);
		chaptype = chaptype != '' ? chaptype : 'CONTENT';
		paneltype = this.getChapPanelTypeWithChapSrc(oldVal);
		// alert(paneltype);
		lastChapterTemp = 0;
		chapTemp = 1;
		if (this.lastChapter != '') {
			chapTemp = chap.replace(
					this.commentryFilePrefix[chaptype].commentry, '');
			lastChapterTemp = this.lastChapter.replace(
					this.commentryFilePrefix[chaptype].commentry, '');
			chapTemp = chapTemp.replace(
					this.commentryFilePrefix[chaptype].page, '')
			lastChapterTemp = lastChapterTemp.replace(
					this.commentryFilePrefix[chaptype].page, '');
		}

		if (lastChapterTemp == chapTemp) {
			$("#page_frame").contents().find('html,body').animate({
				'scrollTop' : 0
			}, 'slow');
			$("#commentry_frame").contents().find('html,body').animate({
				'scrollTop' : 0
			}, 'slow');
			return true;
		}

		this.lastChapter = chap;
		this.lastPanelType = paneltype;
		this.loadHistoryTitle(oldVal);
		if (paneltype == "PAGES") {
			commentryChap = chap.replace(
					this.commentryFilePrefix[chaptype].page,
					this.commentryFilePrefix[chaptype].commentry)
		} else {
			commentryChap = chap;
			chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
					this.commentryFilePrefix[chaptype].page);
		}
		this.lastPageChapter = chap;
		this.lastCommChapter = commentryChap;

		stat = this.loadHistoryCommentary(commentryChap);
		checkFileStatus = this.checkFileUrl(this.chapterPath + chap
				+ this.fileExt);
		newVal = this.getFirstUrl(chap);
		chap = checkFileStatus == true ? chap : newVal;
		$(".Page iframe").attr("src", this.chapterPath + chap + this.fileExt);
		$('.Page iframe').unbind('load');
		$('.Page iframe').load(
				function() {
					thisTocObj.goToSection(section, chap);
					thisTocObj.iframeEvents();
					$('.Page iframe').contents().find('book-part > .section')
							.bind(
									'mousedown',
									function(event) {
										$($(this).siblings()).addClass(
												'deselect_other_content');
									});
				});
		if (objModule.arrModule.highlight.active) {
			CONFIG.objModule["highlight"].controler
					.getHighlightText(this.lastChapter);
		}
	}
	/*-----------------------------------------------End------------------------------------------*/
	/*------------------------------Method For Loading History Dynamic Contents Different Edition-------------------*/
	this.loadHistoryChapterDiff = function(history_diff_version,chap, oldVal, section) { // alert(chap)
		// alert('From Load History'+section);
                //debugger;
		this.loadSectionNavigation(chap);
		chaptype = this.getChapContentTypeWithChapSrc(chap);
		chaptype = chaptype != '' ? chaptype : 'CONTENT';
		paneltype = this.getChapPanelTypeWithChapSrc(oldVal);
		// alert(paneltype);
		lastChapterTemp = 0;
		chapTemp = 1;
		if (this.lastChapter != '') {
			chapTemp = chap.replace(
					this.commentryFilePrefix[chaptype].commentry, '');
			lastChapterTemp = this.lastChapter.replace(
					this.commentryFilePrefix[chaptype].commentry, '');
			chapTemp = chapTemp.replace(
					this.commentryFilePrefix[chaptype].page, '')
			lastChapterTemp = lastChapterTemp.replace(
					this.commentryFilePrefix[chaptype].page, '');
		}
	/*	if (lastChapterTemp == chapTemp) {
			$("#page_frame").contents().find('html,body').animate({
				'scrollTop' : 0
			}, 'slow');
			$("#commentry_frame").contents().find('html,body').animate({
				'scrollTop' : 0
			}, 'slow');
			return true;
		}
*/
		this.lastChapter = chap;
		this.lastPanelType = paneltype;
		this.loadHistoryTitle(oldVal);
		if (paneltype == "PAGES") {
			commentryChap = chap.replace(
					this.commentryFilePrefix[chaptype].page,
					this.commentryFilePrefix[chaptype].commentry)
		} else {
			commentryChap = chap;
			chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
					this.commentryFilePrefix[chaptype].page);
		}
		this.lastPageChapter = chap;
		this.lastCommChapter = commentryChap;
       // this.lastCommentary=this.lastCommChapter;
		stat = this.loadHistoryCommentaryDiff(commentryChap);
		checkFileStatus = this.checkFileUrl(this.historyPagePath + history_diff_version+'/'+chap
				+ this.fileExt);
		//alert('From Check file Status'+checkFileStatus);
		newVal = this.getFirstUrl(chap);
		chap = checkFileStatus == true ? chap : newVal;
		$(".Page iframe").attr("src", this.historyPagePath + history_diff_version+'/' + chap + this.fileExt);
		$('.Page iframe').unbind('load');
		$('.Page iframe').load(
				function() {
					thisTocObj.goToSection(section, chap);
					thisTocObj.iframeEvents();
					$('.Page iframe').contents().find('book-part > .section')
							.bind(
                                                            'mousedown',
                                                            function(event) {
                                                                    $($(this).siblings()).addClass('deselect_other_content');
                                                            });
                                                           
                                                           //debugger
                                                           var newresponse='';
                                                          
                                                            //check for all chapter or single chapter
//                                                            $('#history_popup input').on('change', function() {
//                                                                //debugger;
//                                                                var selectedvalue = $("input[name='history_rdo_btn']:checked").val();
//                                                                if(selectedvalue = 'all_chapter'){
//                                                                    //history_diff_version
//                                                                    //ajax for get all list
//                                                                    $.ajax({
//                                                                            type : "POST",
//                                                                            url : CONFIG.webServicePath
//                                                                                            + "Book_library/GetDataForAllChapter",
//                                                                            data : {
//                                                                                    direcotryname : history_diff_version
//                                                                            },
//                                                                            async : false,
//                                                                            success : function(text) {
//                                                                                    response = text;
//                                                                                    // alert(response);
//                                                                            }
//                                                                    });
//                                                                }
//                                                            });
                                                            
                                                            
                                                           var alldelinstag = $("#page_frame").contents().find("[id^='chanes_']");
                                                           for(totalid=0;totalid<alldelinstag.length;totalid++){
                                                            var stringvalue = alldelinstag[totalid];
                                                            newresponse=newresponse+'<div class="row" onclick="gotoPage(this)"><div class=" date" >'+chap.toUpperCase()+'</div><div style="cursor: pointer; cursor: hand;">' +stringvalue.outerHTML+ '</div></div>';  
                                                           }
                                                            /*$.each( alldelinstag, function( indexDom, valueDom ){
                                                                //newresponse = newresponse+valueDom;
                                                                newresponse=newresponse+'<div class="row"><div class="pull-right date"></div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">'+chap+'</div><div class="h_result_updated_diff" style="cursor: pointer; cursor: hand;" version="1" chapter_no="2" section_no="2">' +valueDom.innerHTML+ '</div></div>';  
                                                            });*/
                                                            $('#container #history_popup .panel-data').html(newresponse);
                                                           
                                                           
				});
		if (objModule.arrModule.highlight.active) {
			CONFIG.objModule["highlight"].controler
					.getHighlightText(this.lastChapter);
		}
	}
	/*-----------------------------------------------End------------------------------------------*/
	this.goToSection = function(secNo, chapId) {
		//debugger
		if(secNo==0){secNo=this.lastSec;}
		if(chapId==0){chapId=this.lastChapter;}
		section_type = "";
		content_type = "";
		toc_type = "";
		if (typeof (arguments[2]) != "undefined") {
			section_type = arguments[2];
			content_type = arguments[3];
			toc_type = arguments[4];
		}

		if (secNo != 0)
			this.lastSec = secNo;

		if (this.lastSec == 0)
			return true;
		var pos = chapId.indexOf("chc");
		// alert(pos);
		if (pos >= 0) {
			if (this.lastCommentary != chapId && chapId != 0) {
				if (section_type != "Figure" && section_type != "Table"
						&& section_type != "References") {
					chapId = this.getChapIdWithSecId(secNo);
					chapSrc = this.getChapSrcWithChapId(chapId);
				} else {
					chapSrc = chapId;
				}
				this.loadChapter(chapSrc)
				secNo_nav_top = secNo.replace("s", "");
				$('nav.navbar .section_no .present').val(secNo_nav_top);
				return true;
			}

		} else {
			if (this.lastChapter != chapId && chapId != 0) {
				if (section_type != "Figure" && section_type != "Table"
						&& section_type != "References") {
					chapId = this.getChapIdWithSecId(secNo);
					chapSrc = this.getChapSrcWithChapId(chapId);
				} else {
					chapSrc = chapId;
				}
				this.distroyFrames();
				this.loadChapter(chapSrc)
				
				secNo_nav_top = secNo.replace("s", "");
				$('nav.navbar .section_no .present').val(secNo_nav_top);
				return true;
			}
		}
		secNo = this.lastSec.replace(/\./gi, "\\.");

		if (section_type == "Section" && content_type == "PAGES") {
			comNo = secNo.replace("s", "sc");
		} else if (section_type == "Section" && content_type == "COMMENTARY") {
			comNo = secNo;
			secNo = secNo.replace("sc", "s");
		} else if (section_type == "Table" && content_type == "PAGES") {
			comNo = secNo.replace("t", "tc");
		} else if (section_type == "Table" && content_type == "COMMENTARY") {
			comNo = secNo;
			secNo = secNo.replace("tc", "t");
		} else if (section_type == "Figure" && content_type == "PAGES") {
			comNo = secNo.replace("f", "fc");
		} else if (section_type == "Figure" && content_type == "COMMENTARY") {
			comNo = secNo;
			secNo = secNo.replace("fc", "f");
		} else if (section_type == "References" && content_type == "PAGES") {
			comNo = secNo.replace("c", "cc");
		} else if (section_type == "References" && content_type == "COMMENTARY") {
			comNo = secNo;
			secNo = secNo.replace("cc", "c");
		} else {
			if(secNo!="" && secNo.indexOf('sc')>-1){
				comNo = secNo;
			}else{
				comNo = secNo.replace("s", "sc");
			}
		}

		// alert(secNo+"-----------"+comNo)
		if ($("#page_frame").contents().find('html,body').find('.section')
				.children('#' + secNo).length > 0) {
			$("#page_frame").contents().find('html,body').animate(
					{
						'scrollTop' : $("#page_frame").contents().find(
								'html,body').find('.section').children(
								'#' + secNo).position().top
					}, 'slow');
		}
		if ($("#commentry_frame").contents().find('html,body').find('.section')
				.children('#' + comNo).length > 0) {
			$("#commentry_frame").contents().find('html,body').animate(
					{
						'scrollTop' : $("#commentry_frame").contents().find(
								'html,body').find('.section').children(
								'#' + comNo).position().top
					}, 'slow');
		}

		secNo = this.lastSec.replace(/\\/gi, "");

		CONFIG.objModule["search"].controler.highlightText(secNo);
	}

	this.getChapIdWithSecId = function(secId) {
		chapId = 0;
		$.each(thisTocObj.arrRawSection, function(key, value) {
			if (value.secSrc == secId) {
				chapId = value.chapId;
			}
		});
		return chapId;
	}

	this.getChapIdWithChapSrc = function(chapSrc) {
		chapId = 0;
		$.each(thisTocObj.arrChapters, function(key, value) {
			if (value.chapSrc == chapSrc) {
				chapId = value.chapId;
			}
		});
		return chapId;
	}

	this.getChapSrcWithChapId = function(chapId) {
		chapSrc = 0;
		$.each(thisTocObj.arrChapters, function(key, value) {
			if (value.chapId == chapId) {
				chapSrc = value.chapSrc;
			}
		});
		return chapSrc;
	}

	this.getChapContentTypeWithChapId = function(chapId) {
		contentType = '';
		$.each(thisTocObj.arrChapters, function(key, value) {
			if (value.chapId == chapId) {
				contentType = value.contenttype;
			}
		});
		return contentType;
	}

	this.getChapPanelTypeWithChapId = function(secId) {
		panelType = '';
		$.each(thisTocObj.arrChapters, function(key, value) {
			if (value.chapId == chapId) {
				panelType = value.chapPaneltype;
			}
		});
		return panelType;
	}

	this.getChapContentTypeWithChapSrc = function(chapSrc) {
		contentType = '';
		$.each(thisTocObj.arrChapters, function(key, value) {
			if (value.chapSrc == chapSrc) {
				contentType = value.contenttype;
			}
		});
		return contentType;
	}

	this.getChapPanelTypeWithChapSrc = function(chapSrc) {
		panelType = '';
		$.each(thisTocObj.arrChapters, function(key, value) {
			if (value.chapSrc == chapSrc) {
				panelType = value.chapPaneltype;
			}
		});
		return panelType;
	}

	this.loadCommentary = function(comm) {
		this.lastCommentary = comm;
		if (typeof (arguments[1]) != "undefined")
			secNo1 = arguments[1];
		else
			secNo1 = false;
		checkCommentaryStatus = this.checkFileUrl(this.commentaryPath + comm
				+ this.fileExt);
		//alert(checkCommentaryStatus);
		commVal = this.commentaryPath + comm;
		//alert(commVal+this.fileExt);
		newComVal = CONFIG.bookPath + '/blank';
		commWithPath = checkCommentaryStatus == true ? commVal : newComVal;
		if (this.commentryFilePrefix)
			$(".Commentry iframe").attr("src", commWithPath + this.fileExt);
		$(".Commentry iframe").load(function() {
			thisTocObj.iframeEvents();
	thisTocObj.iframeEventss();
	selected_Unit = $('select[name=unit_toogling]').val();
			thisTocObj.loadTogglingCommentary(selected_Unit);
		
		});
		return true;
	}
	/*--------------------------------------------For Loading Commentary For History-------------------*/
	this.loadHistoryCommentary = function(comm) {
		this.lastCommentary = comm;
		if (typeof (arguments[1]) != "undefined")
			secNo1 = arguments[1];
		else
			secNo1 = false;
		/*---------------------------------For Checking Whether File Exists or Not-----------------------*/
		checkFileStatus = this.checkFileUrl(this.commentaryPath + comm
				+ this.fileExt);
		newVal = this.getFirstUrl(comm);
		comm = checkFileStatus == true ? comm : newVal;
		commFileURL = this.commentaryPath + comm;
		checkCom = this.checkFileUrl(this.commentaryPath + comm + this.fileExt);
		coomPath = CONFIG.bookPath + '/blank';
		comm = checkCom == true ? commFileURL : coomPath;
		/*----------------------------------------------End----------------------------------------------*/
		if (this.commentryFilePrefix)
			$(".Commentry iframe").attr("src", comm + this.fileExt);
		$(".Commentry iframe").load(function() {
			thisTocObj.iframeEvents();
		});
		return true;
	}
	/*-------------------------------------------------------End---------------------------------------*/
	/*--------------------------------------------For Loading Commentary For History Different Edition-------------------*/
	this.loadHistoryCommentaryDiff = function(comm) {
		this.lastCommentary = comm;
		if (typeof (arguments[1]) != "undefined")
			secNo1 = arguments[1];
		else
			secNo1 = false;
		/*---------------------------------For Checking Whether File Exists or Not-----------------------*/
		checkFileStatus = this.checkFileUrl(this.historyPagePath + history_diff_version+'/'+ comm
				+ this.fileExt);
		newVal = this.getFirstUrl(comm);
		comm = checkFileStatus == true ? comm : newVal;
		commFileURL = this.historyPagePath + history_diff_version+'/'+ comm;
		checkCom = this.checkFileUrl(this.historyPagePath + history_diff_version+'/'+ comm + this.fileExt);
		coomPath = CONFIG.bookPath + '/blank';
		comm = checkCom == true ? commFileURL : coomPath;
		/*----------------------------------------------End----------------------------------------------*/
		if (this.commentryFilePrefix)
			$(".Commentry iframe").attr("src", comm + this.fileExt);
		$(".Commentry iframe").load(function() {
			thisTocObj.iframeEvents();
		});
		return true;
	}
	/*-------------------------------------------------------End---------------------------------------*/
	this.setNavigationList = function(dbResultset) {
		thisTocObj.arrNavigation = dbResultset[0];
		thisTocObj.setArrSection(thisTocObj.arrNavigation);
	}

	this.setArrSection = function(arrNavigation) {
		$('nav.navbar .section_no .present').val(arrNavigation[0].m_seclabel);
		for (i = 0; i < arrNavigation.length; i++) {
			thisTocObj.arrNavigationList[i] = arrNavigation[i].m_seclabel;
			thisTocObj.arrNavigationListLink[i] = arrNavigation[i].m_seclinkpage;
		}
	}

	this.section_change = function(temp) {
		chapId = 0;
		current_sec = $('nav.navbar .section_no .present').val();
		current_pos = this.arrNavigationList.indexOf(current_sec);
		if ((temp == "move_forward")
				&& (current_pos < (this.arrNavigation.length - 1))) {
			current_pos++;
		} else if ((temp == "move_backward") && (current_pos > 0)) {
			current_pos--;
		} else if (temp == "move_current_position") {
			current_pos;
		} else if (current_pos == -1 || current_pos == "undefined"
				|| current_pos == " ") {
		}
		$('nav.navbar .section_no .present').val(
				this.arrNavigationList[current_pos]);

		if (current_pos == -1) {
			bootbox.alert(localizedStrings.TOC.error.alertmsg.incorrectSecNo);
			$('nav.navbar .section_no .present').val(current_sec);
		} else {
			chapId = thisTocObj
					.getChapIdWithSecId(thisTocObj.arrNavigationListLink[current_pos]);
			thisTocObj.goToSection(
					thisTocObj.arrNavigationListLink[current_pos], thisTocObj
							.getChapSrcWithChapId(chapId));
		}
	}
	/*----------------------------Functions For Unit Toggling------------------------------------*/
	this.loadToggling = function(selected_Unit) {
		var f = $('#page_frame')
		if (selected_Unit == 'customary') {
			f.contents().find('.si').hide();
			f.contents().find('.toggle').hide();
			f.contents().find('.customary').show();
		}
		if (selected_Unit == 'si') {
			f.contents().find('.customary').hide();
			f.contents().find('.toggle').hide();
			f.contents().find('.si').show();
		}
		if (selected_Unit == 'both') {
			f.contents().find('.customary').show();
			f.contents().find('.toggle').show();
			f.contents().find('.si').show();
		}
	}
	this.loadTogglingCommentary = function(selected_Unit) {
		var f = $('#commentry_frame')
		if (selected_Unit == 'customary') {
			f.contents().find('.si').hide();
			f.contents().find('.toggle').hide();
			f.contents().find('.customary').show();
		}
		if (selected_Unit == 'si') {
			f.contents().find('.customary').hide();
			f.contents().find('.toggle').hide();
			f.contents().find('.si').show();
		}
		if (selected_Unit == 'both') {
			f.contents().find('.customary').show();
			f.contents().find('.toggle').show();
			f.contents().find('.si').show();
		}
	}
}
function gotoPageHistory(obj){
    //debugger
    var pageName=$(obj).find(".data").text().toLowerCase()+".html"
    $(divname).contents().each(function(){
        if(pageName.trim()==$(this).attr("data-set").trim()){
            var pageContents=$(this).html();
            $("#page_frame").contents().find("body")[0].innerHTML=pageContents;
            gotoPage(obj);
        }
    });
    $("#page_frame").contents().find("body")
    $("#chapertHistoryAll").length;
}
function gotoPage(obj){
    //debugger
    var attID=$(obj).find("[id^='chanes_']").attr("id");
    var $frameElm= $("#page_frame").contents().find("#"+attID);
    $("#page_frame").contents().find("body").animate({scrollTop:$frameElm.offset().top},300);
    //$("#page_frame").contents().find("body").scrollTop($frameElm.offset().top);
}
function gotoPageNew(obj){
    var iframe = $('#page_frame').contents();
    var attID=$(obj).find("[id^='chanes_']").attr("id");
    var $frameElm= $("#page_frame").contents().find("#"+attID);
    iframe.scrollTop($frameElm.offset().top);
}
function gotoPageNewHistory(obj){
    //debugger
    var iframe = $('#page_frame').contents();
    //var iframe = $('#page_frame').contents();
    var currentsectionId = $(obj).find(".h_result").attr("section_no");
    var hreflinkid = currentsectionId+"_history";
    var linkhtml = $('#page_frame').contents().find("[id='"+hreflinkid+"']");
    //var linkhtml1 = $('#page_frame').contents().find("div[class='section'][id='"+currentsectionId+"']");
    $(linkhtml).trigger('click');
    var topdivid = $(linkhtml).parent().prev(); 
    iframe.scrollTop(topdivid.offset().top);
}