// JavaScript Document

function controlerBookmark(){

	thisBookmarkObj = this;
	this.arrBookmark = "";
	this.moduleName = "bookmark";
	this.current_sec_id = "";
	
	this.init = function(){
		this.loadBookmark();
	}
	this.destroy = function(){
		this.current_sec_id = "";
		this.closePanel();
	}
	
	this.closePanel = function(){
		$('#bookmarks textarea').val("");
		$('#bookmarks').removeClass("show");
		this.cancel();
	}
	
	this.loadBookmark = function(){
		$('#bookmarks').load(CONFIG.viewPath+"bookmark.html",function(){
			thisBookmarkObj.start();				
		});
	}
	
	this.start = function(){
		this.setDynamicEvents();
		this.localizationString();
	}
	
	this.getBookmark = function(){
		if(!arguments.length){
			CONFIG.objModule[this.moduleName].model.getBookmarkList();   
		}else{
			thisBookmarkObj.arrBookmark = arguments;
			
		thisBookmarkObj.generateBookmark();
			thisNotesObj.setDynamicEvents();
			return true;
		
		}
	}		
	
	
	this.generateBookmark = function(){
		$('.bookmark_list .bookmark_list_container').empty();
		$.each(this.arrBookmark[0],function(key,value){
            var objRootBookmarkArray = thisBookmarkObj.setBookmarkList(value);
            $('.bookmark_list .bookmark_list_container').append(objRootBookmarkArray);
		});	
		this.setDynamicEvents();
		this.bookmarkSearchValue($('#bookmarks .search_area input').val());
	}
	
	this.setBookmarkList = function(value){
		rootTRoption = $('<tr/>',{'class':'bookmark','bookmark_id':value.t_bmkid,'chap_id':value.t_bmkchapid,'sec_id':value.t_bmksecid,'content':value.t_bmkdata,'parent_Id':value.t_bmkpgeid,'p_tag':value.t_bmktagname});
		
		bookmarkContent =  $('<td/>',{'class':'bookmark_content'});
		bookmarkContent.append(value.t_bmktitle);
		rootTRoption.append(bookmarkContent);
		bookmarkSecId =  $('<td/>',{'class':'bookmark_sec_id'});
		if(value.t_bmksecid != ""){
			bookmarkSecId.append(value.t_bmksecid);
		}else{
			bookmarkSecId.append(value.t_bmkchapid);
		}
		rootTRoption.append(bookmarkSecId);
		bookmarkContentRemove =  $('<td/>').append($('<span/>',{'class':'glyphicon glyphicon-remove','title':'DELETE'}));
		rootTRoption.append(bookmarkContentRemove);
	
		return rootTRoption;
	}
	this.showForm = function(){
		$('#bookmarks').addClass("show");
		$('#bookmarks textarea').focus();
		this.managePanelSize();
	}
	
	this.hideForm = function(){
		$('#bookmarks').removeClass("show");	
		$('#bookmarks textarea').val("");
        $('#bookmarks').css("display", "none");			
	}
	
	this.bookmarkSecId = function(sec_id,bookmark_sec_start_val,bookmark_sec_end_val,targetTag,targetId,content,chapId,paraData ,bookMarkId){
		//alert(33); debugger
                
               
                 if(sec_id==undefined){
          var   t_Id= thisTocObj.objIframeMouse.firstElementChild.parentElement.id ;       
          var myvar=null; 
          if(t_Id.length > 0){
               var res = t_Id.replace("t", "s");
               var myarr = res.split("-");
               var myvar = myarr[0];
               sec_id=null;
               sec_id=myvar;
              
                      var res1 = t_Id.replace("t", "table_inner_t"); 
                      var res2 = res1 .replace(".", "_");
                        targetId=null;
                        targetId=res2;
               
          }   
        }
        //console.log(sec_id);
      //  console.log(targetId);
               
               
               
		this.current_sec_id = sec_id;
		this.current_chapId = chapId;
		this.start_pos = bookmark_sec_start_val;
		this.end_pos = bookmark_sec_end_val;
		this.parent_tag = targetTag;
		this.paremt_id = targetId;
		this.content = content;
		this.paraData=paraData;
		this.bookMarkId=bookMarkId;
		thisBookmarkObj.loadBookmarkTable();
	},this.getRendomId=function(min,max){
	  min=(min)?min:10000; max=(max)?max:99999;
	  return Math.floor(Math.random() * (max - min + 1)) + min;
	 },this.coveredboookmark=function(range){
		var setHighleted=this.getRendomId();
		var selectionContents =range.extractContents();
		var frame = document.getElementById('page_frame');
			var frameWindow = frame && frame.contentWindow; 
			var frameDocument = frameWindow && frameWindow.document;
		var span=frameDocument.createElement('mark');
		span.setAttribute("newhighbook_id",setHighleted);
		span.setAttribute("highbook_id",setHighleted);
		span.setAttribute("class","data-tooltip");
		span.setAttribute("data-tooltip","Bookmark");
		span.setAttribute("style","background-color:#D3D3D3");
		span.appendChild(selectionContents)
		range.insertNode(span);
		return setHighleted;
	},this.coveredboookmarks=function(range){
		var setHighleted=this.getRendomId();
		var selectionContents =range.extractContents();
		var frame = document.getElementById('commentry_frame');
			var frameWindow = frame && frame.contentWindow; 
			var frameDocument = frameWindow && frameWindow.document;
		var span=frameDocument.createElement('mark');
		span.setAttribute("newhighbook_id",setHighleted);
		span.setAttribute("highbook_id",setHighleted);
		span.setAttribute("class","data-tooltip");
		span.setAttribute("data-tooltip","Bookmark");
		span.setAttribute("style","background-color:#D3D3D3");
		span.appendChild(selectionContents)
		range.insertNode(span);
		return setHighleted;
	} 
	this.save = function(){
		bookmark_content = $('#bookmarks textarea').val();
	if(bookmark_content.length && thisBookmarkObj.current_sec_id!=""){
			CONFIG.objModule[this.moduleName].model.addBookmark(thisBookmarkObj.current_chapId,bookmark_content,thisBookmarkObj.current_sec_id,thisBookmarkObj.start_pos,thisBookmarkObj.end_pos,thisBookmarkObj.parent_tag,thisBookmarkObj.paremt_id,thisBookmarkObj.content,thisBookmarkObj.paraData,
			thisBookmarkObj.bookMarkId);			        
		}
		else{
			//alert("Allready in Used.");
		}
		//this.hideForm();
	}
	
	this.loadBookmarkTable = function(){
		$('.custom_tooltip').addClass('hide');
		objModule.destroyModule(thisBookmarkObj.moduleName);
		$('nav.navbar .menus li.bookmark_btn').addClass("active");
	//	thisBookmarkObj.showForm();
	   $( "#bookmarks" ).toggle();
		if($("input[name='bookmark_radio_btn']:checked").attr('id') == "current_chap"){
			CONFIG.objModule[thisBookmarkObj.moduleName].model.getBookmarkList(thisTocObj.lastChapter);
		}else if($("input[name='bookmark_radio_btn']:checked").attr('id') == "all_chap"){
			CONFIG.objModule[thisBookmarkObj.moduleName].model.getBookmarkList();
		}
	}
	
	this.cancel = function(){
		// debugger
		var isSaved=true;
		if(typeof this.arrBookmark === "object"){
		for( i=0; i < this.arrBookmark[0].length; i++){  
			if(this.arrBookmark[0][i].t_bmkid==this.bookMarkId ){ 
				isSaved=false; 
			} 
		}}
		if(this.bookMarkId && isSaved){
			 var pageName=this.current_chapId;
		if(pageName!=''){
		var profix=pageName.replace(/[0-9]/g,'');
		var $frame=(profix!='chc')?$('.Page iframe'):$('.Commentry iframe');
		var markTag=$frame.contents().find("#"+this.paremt_id)[0].getElementsByTagName("mark");
			for(i=0; i< markTag.length; i++){
				if(markTag[i].hasAttribute("newhighbook_id") && markTag[i].getAttribute("newhighbook_id")==this.bookMarkId){
					var range= document.createRange();
					var frag =range.createContextualFragment(markTag[i].innerHTML);
					markTag[i].parentNode.replaceChild(frag,markTag[i]);
				}
			 }
		  }
		}
		//current_chapId
		this.hideForm();
		this.current_sec_id = "";
		$('#bookmarks .search_area input').val("");
		$('#bookmarks .search_area .clear').hide();
		$('nav.navbar .menus li.bookmark_btn').removeClass("active");
	}

	this.localizationString = function(){
		$( "#bookmarks .bookmark_add .panel-heading" ).append(localizedStrings.bookmark_popup_pannel.label.title.text);
		$( "#bookmarks .panel-body .radio .current" ).text(localizedStrings.bookmark_popup_pannel.current_chap.radio.text);
		$( "#bookmarks .panel-body .radio .all" ).text(localizedStrings.bookmark_popup_pannel.all_chap.radio.text);
		$( "#bookmarks .search_area input" ).attr('placeholder',localizedStrings.bookmark_popup_pannel.input_search.placeholder.text);
		$( "#bookmarks thead th:nth-child(1)" ).text(localizedStrings.bookmark_popup_pannel.note.title.text);
		$( "#bookmarks thead th:nth-child(2)" ).text(localizedStrings.bookmark_popup_pannel.page_chap.title.text);
		$( "#bookmarks thead th:nth-child(3)" ).text(localizedStrings.bookmark_popup_pannel.delete.title.text);
		$( "#bookmarks form button" ).text(localizedStrings.bookmark_popup_pannel.add_btn.button.text);
		$( "#bookmarks textarea" ).attr('placeholder',localizedStrings.bookmark_popup_pannel.textarea.placeholder.text);
	}

	this.setDynamicEvents = function(){
		$('#bookmarks .close_btn,#bookmarks .cancel_btn').unbind( "click" );
		$('#bookmarks .close_btn,#bookmarks .cancel_btn').click(function(){
                    thisBookmarkObj.cancel();
                        	$('#bookmarks').hide();	
		});
		$('#bookmarks .add_btn').unbind( "click" );
		$('#bookmarks .add_btn').click(function(){
			thisBookmarkObj.save();
		});
		$('#bookmarks .bookmark_list_container .bookmark .glyphicon-remove').unbind( "click" );
		$('#bookmarks .bookmark_list_container .bookmark .glyphicon-remove').click(function(event){
			event.stopPropagation();
			//debugger
			$(this).parents().eq(1).addClass('delete')
			bookmarkId=$(this).parents().eq(1).attr('bookmark_id');
			content=$(this).parents().eq(1).attr('content');
			parent_Id=$(this).parents().eq(1).attr('parent_Id');
			p_tag=$(this).parents().eq(1).attr('p_tag');
			sec_id=$(this).parents().eq(1).attr('sec_id');
			chap_id=$(this).parents().eq(1).attr('chap_id');
			bootbox.confirm(localizedStrings.bookmark_popup_pannel.conform.alertmsg.deleteBookmark, function(result) {
				if(result){
					bkmkData={
						bookmarkId:bookmarkId,
						parent_Id:parent_Id,
						sec_id:sec_id,
						chap_id:chap_id
					}
					CONFIG.objModule[thisBookmarkObj.moduleName].model.deleteBookmark(bkmkData);
					
							var regex = new RegExp("(" + content + ")", "g");
				
				if(chap_id){
				var profix=chap_id.replace(/[0-9]/g,'');
				}
				var $frame=$('.Page iframe');
				if(profix=='chc'){
				$frame=$('.Commentry iframe');	
				}
					
				var testvalue =$frame.contents();
				parentid = parent_Id;
				srcStr = $frame.contents().find(p_tag.toLowerCase()+"#"+parentid.replace(/\./gi, "\\.")).html();
				srcStr = srcStr.replace(/ +(?= )/g,'');
				srcStr = srcStr.replace(/(\r\n|\n|\r)/gm,"")
				var finalstring = '<mark newhighbook_id="'+bookmarkId+'" highbook_id="'+bookmarkId+'" class="data-tooltip" data-tooltip="Bookmark" style=" background-color:#D3D3D3">'+content+'</mark>';
				var finalstring = new RegExp(finalstring, "g");
				srcStr1 = srcStr.replace(finalstring, content);
				$frame.contents().find(p_tag.toLowerCase()+"#"+parent_Id.replace(/\./gi, "\\.")).html(srcStr1);	
				}else{
					$('#bookmarks .bookmark_list_container .bookmark').removeClass('delete')
				}
			});
		});
		$('#bookmarks .bookmark_list_container .bookmark').unbind( "click" );
		$('#bookmarks .bookmark_list_container .bookmark').click(function(){
			if($(this).attr('sec_id') != ""){
				//alert("sdfdfd");
				thisTocObj.referID={"bookmarkId":$(this).attr('bookmark_id')};
				thisTocObj.bookMarkId='bookmark';
				thisTocObj.goToSection($(this).attr('sec_id'),$(this).attr('chap_id'),$(this).attr('bookmark_id'));
				
			}else{
				//alert("sdsfdsfdfdfdfdfdfdfdfdfd");
				thisTocObj.loadChapter($(this).attr('chap_id'));
			}
			thisBookmarkObj.destroy();
		});
		$('#bookmarks .radio input#current_chap').unbind( "click" );
		$('#bookmarks .radio input#current_chap').click(function(){
				CONFIG.objModule[thisBookmarkObj.moduleName].model.getBookmarkList(thisTocObj.lastChapter);         
		});
		$('#bookmarks .radio input#all_chap').unbind( "click" );
		$('#bookmarks .radio input#all_chap').click(function(){
				CONFIG.objModule[thisBookmarkObj.moduleName].model.getBookmarkList();         
		});
		$('nav.navbar .menus li.bookmark_btn').unbind('click');
		$('nav.navbar .menus li.bookmark_btn').click(function(){
			$(this).addClass("active");
			thisBookmarkObj.loadBookmarkTable();
		});
		$('#bookmarks .search_area input').unbind( "keyup" );
		$('#bookmarks .search_area input').keyup(function(){
			thisBookmarkObj.bookmarkSearchValue($(this).val()); 		
		});
		$('#bookmarks .search_area input').unbind( "keypress" );
		$('#bookmarks .search_area input').keypress(function(e){
			 if(e.keyCode === 13){
				thisBookmarkObj.bookmarkSearchValue($(this).val()); 		
			 }
		});
		$('#bookmarks .search_area .clear').unbind( "click" );
		$('#bookmarks .search_area .clear').click(function(){
			$('#bookmarks .search_area input').val("");
			$('#bookmarks .search_area input').focus();
			$('#bookmarks .search_area .clear').hide();
			$('#bookmarks .bookmark_list_container').find('.bookmark').show();
		});

	}

	this.bookmarkSearchValue = function(val){
		$('#bookmarks .search_area .clear').show();
		if(val){
			thisBookmarkObj.bookmarkSearch(val);
		}else{
			$('#bookmarks .search_area .clear').hide();
			$('#bookmarks .bookmark_list_container').find('.bookmark').show();
		}
	}	
	this.bookmarkSearch = function(keyword){
		var Len=$('#bookmarks .bookmark_list_container').children().length;
		$('#bookmarks .bookmark_list_container').find('.bookmark').hide();
		for(var i=0;i<Len;i++)
		{
			var Str=$('#bookmarks .bookmark_list_container').find('.bookmark').eq(i).find('.bookmark_content').text().toLowerCase();
			if(Str.indexOf(keyword.toLowerCase(),0)!=-1)
			{
				$('#bookmarks .bookmark_list_container').find('.bookmark').eq(i).show();
			}
		}
	}
	
	this.callbackAddBookmark = function(){
		//alert('bkmk');debugger
		$('#bookmarks textarea').val("");
		$('#bookmarks textarea').focus();
		thisBookmarkObj.current_sec_id ="";
		 if($("input[name='bookmark_radio_btn']:checked").attr('id') == "current_chap"){
			CONFIG.objModule[thisBookmarkObj.moduleName].model.getBookmarkList(thisTocObj.lastChapter);         
		}else if($("input[name='bookmark_radio_btn']:checked").attr('id') == "all_chap"){
			CONFIG.objModule[thisBookmarkObj.moduleName].model.getBookmarkList();   
		} 
		
	}
	this.callbackDeleteBookmark = function(dbResultset){
		$('#bookmarks .bookmark_list_container .bookmark.delete').remove();
	}

	this.managePanelSize = function(){
		windowHeight = $(window).outerHeight();
		mainHeaderHeight = $('header.main_header').outerHeight();
		bookmark_topSec = $('#bookmarks .bookmark_add').outerHeight();	
		resultHeadHeight = $('#bookmarks .bookmark_list table thead').outerHeight();	
		search_container = windowHeight - (mainHeaderHeight + bookmark_topSec + resultHeadHeight + 6 );
		$('#bookmarks .bookmark_list table tbody').css({'max-height':search_container});	
	}	

	this.showAllBookmark = function()
	{
		//debugger;
	//CONFIG.objModule[this.moduleName].model.getBookmarkList();	
	}
	
	
	
}