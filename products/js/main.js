		$(window).resize(function(){adminJsEvents();});
		$(document).ready(function(){adminJsEvents();});
		function adminJsEvents(){
			if(typeof($('.searchToolSec .bookDetails').attr('class') ) == "undefined" )
				return false;
			windowHeight = $(window).outerHeight();
			adminPanelHeaderHeight = $('#adminHomePage header').outerHeight();	
			search_area = $('.searchToolSec .panel').outerHeight();	
			resultTitle = $('.searchToolSec .selectBookTitle').outerHeight();	
			manageAdminTool = $('.manageAdminTool').outerHeight();	
			//alert($('.searchResultSec .bookList').css('padding-left').replace("px",""));
			search_container = windowHeight - (adminPanelHeaderHeight + search_area + resultTitle + manageAdminTool);
			$('.searchResultSec .panel-body').css({'max-height':search_container});
			
			bookDetailsWidth = $(window).outerWidth() - ( (($('.searchResultSec .bookList').css('padding-left').replace("px",""))*2) + $('.searchToolSec .bookArea').outerWidth() + $('.searchToolSec .btn-area').outerWidth() );
			
			$('.searchToolSec .bookDetails').css({'width':bookDetailsWidth});
			
		}