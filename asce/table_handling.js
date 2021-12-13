var full_count=0;
var comm_full_count=0;
function increase_full_count(){
	full_count++;
}
function decrease_full_count(){
	full_count--;
}
function increase_comm_full_count(){
	comm_full_count++;
}
function decrease_comm_full_count(){
	comm_full_count--;
}
function show_table() {
	current_class = $("#container").attr('class'); 
	if(full_count<1){
	$('#container').toggleClass("full_size_page").toggleClass(
	"non_full_view");
	set_height_and_width();
	}
	}
function show_commentary_table() {
	current_class = $("#container").attr('class'); 
	if(comm_full_count<1){
	$('#container').toggleClass("full_size_commentry").toggleClass(
	"non_full_view");
	set_height_and_width();
	}
	}
function set_height_and_width()// set height width for all
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