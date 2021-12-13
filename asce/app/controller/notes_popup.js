function controlerNotes (){
    thisNotesObj = this;
    this.moduleName = "notes_popup";
    this.arrNotes ="";
	this.notesValue = "";
	this.sec_id = "";
	this.start_pos = "";
	this.end_pos = "";
	this.parent_tag = "";
	this.paremt_id = "";
	this.content = "";
	this.chap_id = "";
	var userdefines ;
	var statusnew;
	var subuser;

    
    this.init = function(){
       this.loadNotes();
   }
    
    this.destroy = function(){
		this.closePanel();
	}
	this.getUserInfo = function(){
	 
	
		return this.arrUserInfo;
	}
	
	this.setUserInfo = function(dbData){
	
		if(dbData=="subuser"){
			subuser = true;
		//this.userdefines="subuser";
		}else{
			subuser = false;
		}	
	}
	
	this.closePanel = function(){
		this.cancel();
		$('#notes_popup').hide();
		$('nav.navbar .menus li.notes_btn').removeClass("active");
	}
    
    this.loadNotes = function(){
	
		$('#notes_popup').load(CONFIG.viewPath+"notes.html",function(){
			thisNotesObj.start();				
		});
	}
    
    this.start = function(){
     	this.setDynamicEvents();
		this.localizationString();
	}
	
	
	this.highlightEvent = function(){ 
	//console.log($(this));
		var frame = document.getElementById('page_frame'); 
		var frameWindow = frame && frame.contentWindow; 
		var frameDocument = frameWindow && frameWindow.document; 	
		$(frameDocument).find("[class^='hightlight_']").unbind('click');
		
		
		$(frameDocument).find("[class^='hightlight_']").click(function(){
			var className=$(this).attr('class');
			$(this).css("background",'');
			$(this).removeClass(className);
			var highLightId=$(this).attr("newhigh_id");
			
			if(!parseInt(highLightId)>0){
				highLightId = $(this).attr("high_id");
			}
			//alert(highLightId);
			//$(this).parent().replaceWith($(this).parent().text().trim());
			objThis.deleteHighlight(highLightId);
		});
	}
	this.getPublicNots = function(data){
		CONFIG.objModule[this.moduleName].model.getPublicNots(data);
	}
	this.getPublicIndex = function(paraData,t_txndata,notesId){
		//t_txndata=t_txndata.trim();
		var AcuratmacheIndex=0;
		var rx = RegExp(t_txndata,'g');
		if(paraData.match(rx)==null){
			rx = RegExp(t_txndata.trim(),'g');
		}
		if(paraData.match(rx).length > 0){
			//handle miultiple time
			var rx2=new RegExp("<u[^>]+>"+t_txndata+"\s*<\/u>|"+t_txndata,'g');
			if(paraData.match(rx2)==null){
				rx2=new RegExp("<u[^>]+>"+t_txndata.trim()+"\s*<\/u>|"+t_txndata.trim(),'g');
			}
			var maches=paraData.match(rx2);
			for(i=0; i< maches.length; i++){
			  	if(maches[i].match(/<u[^>]+>/g)!== null){
					//machesIndexs.push(i);
					//that is not a acuret maches index in case of multiple note in same word
					var multiNotes=maches[i].match(/<u[^>]+>/g);
					for(j=0; j< multiNotes.length; j++){
						var rx3=new RegExp('highbook_id="'+notesId+'"',"g");
						if(multiNotes[j].match(rx3)){
							AcuratmacheIndex=i+1;
							break;
						}
					}
				}
			}
		}
		return AcuratmacheIndex;			
	}
	
	this.callbackgetPublicNots = function(dbResultset){
		var paraData=dbResultset['paraData'];
		var notesId=dbResultset['t_txnid'];
		var t_txndata=dbResultset['t_txndata'];
		var getndex= thisNotesObj.getPublicIndex(paraData,t_txndata,notesId);
		if(dbResultset.t_txnchpid){ 
			var profix=dbResultset.t_txnchpid.replace(/[0-9]/g,'');
		}
		var $frame=$('.Page iframe');
		if(profix=='chc'){
			$frame=$('.Commentry iframe');
		}
		var testvalue =$frame.contents().find("#"+dbResultset.t_txhparaid).html();
		var rx2=new RegExp("<u[^>]+>"+t_txndata+"\s*<\/u>|"+t_txndata,'g');
		var publicNot='<u title="public" newhigh_id="'+notesId+'" highbook_id="'+notesId+'" class="data-tooltip" data-tooltip="Click to See Note" style="background-color:#00FFFF">'+t_txndata+'</u>';
		
		var nth = 0;
		testvalue = testvalue.replace(rx2, function (match, i, original) {
			nth++;
			return (nth === getndex) ? publicNot : match;
		});
		var testvalue =$frame.contents().find("#"+dbResultset.t_txhparaid).html(testvalue);
		//var maches=testvalue.replace(rx2,function(match, getndex) {
        //if( i === at ) return repl;}));
		//$(div).find('[newhigh_id="88667"').length
		//replaceIndex(paraData, getndex, publicNot);
		
	}
	this.getNotes = function(){
		

        if(!arguments.length){
			CONFIG.objModule[this.moduleName].model.getNotesList();         
		}else{
            thisNotesObj.arrNotes = arguments;
          //  thisNotesObj.setUserInfo(); 
			thisNotesObj.populateNotes();
			thisNotesObj.setDynamicEvents();
			thisNotesObj.managePanelSize();
		}
				
		allnotes = arguments[0];
		$.each(allnotes,function(key,value){//alert(value.toSource())
		///code for adding public notes of super user
		
		var setLoaded=true;
			if(setLoaded){
			var highLightInterval=setInterval(function(){
				if(value.t_txnchpid){ var profix=value.t_txnchpid.replace(/[0-9]/g,'');}
				var $frame=$('.Page iframe');if(profix=='chc'){$frame=$('.Commentry iframe');}
				var testvalue =$frame.contents();
               if(value.t_txntagname){
				srcStr = $frame.contents().find(value.t_txntagname.toLowerCase()+"#"+value.t_txnpgeid);
				}else{
					srcStr = $frame.contents().find(value.tag_name.toLowerCase()+"#"+value.t_txnpgeid);
				}
				if(srcStr.length > 0){
					setLoaded=false;
					clearInterval(highLightInterval);
					//var noteLoad=false;
					
					var noteLoad=false;
					if(value.t_textstatus=="Corporate"){
						thisNotesObj.getPublicNots(value);
					}
					$frame.contents().find('u').each(function(){
					$( this ).click(function(){
						var test, note_status, NoteId;
						for(i=0; i<thisNotesObj.arrNotes[0].length; i++ ){
							if(thisNotesObj.arrNotes[0][i].t_txnid==$(this).attr("newhigh_id")){
								test=thisNotesObj.arrNotes[0][i].t_txncontent;
								note_status=thisNotesObj.arrNotes[0][i].t_textstatus;
								NoteId=thisNotesObj.arrNotes[0][i].t_txnid;
								txnchpid=thisNotesObj.arrNotes[0][i].t_txnchpid;
								txnsecid=thisNotesObj.arrNotes[0][i].t_txnsecid;
								txntagname=thisNotesObj.arrNotes[0][i].t_txntagname;
								txnpgeid=thisNotesObj.arrNotes[0][i].t_txnpgeid;
								thisNotesObj.showNotePopup(NoteId,txnchpid,txnsecid,txntagname,txnpgeid,test,note_status);
							}
						} 
					  });
					});
					objThis.highlightEvent();
				}
			},200);
			}
		});
		
		return true;
		
	}
	
    this.populateNotes = function(){
       $('.notes_list .note_list_container').empty();

       $.each(this.arrNotes[0],function(key,value){
		    if(value.t_textstatus=="Private")
			{
				value.t_textstatus="Personal";
			}
			if(value.t_textstatus=="Public")
			{
				value.t_textstatus="Corporate";
			}
            var objRootNoteArray = thisNotesObj.getNotesListStructure(value);
            $('.notes_list .note_list_container').append(objRootNoteArray);
       });    
	   this.noteSearchValue($('#notes_popup .notes_filter .search_area input').val());    
    }
              
    this.getNotesListStructure = function(value){
		
       rootTRoption = $('<tr/>',{'class':'notes','note_id':value.t_txnid,'sec_id':value.t_txnsecid,'chap_id':value.t_txnchpid,'parent_id':value.t_txnpgeid,'modifycontent':value.t_txncontent,'modifygender':value.t_textstatus,'content':value.t_txndata,'p_tag':value.t_txntagname});
        
        noteContent =  $('<td/>',{'class':'note_content'});
		noteContent.append(value.t_txncontent);
        rootTRoption.append(noteContent);
        noteSecId =  $('<td/>',{'class':'note_sec_id'});
		noteSecId.append(value.t_txnsecid);
        rootTRoption.append(noteSecId);
		
		 noteGenderId =  $('<td/>',{'class':'note_gender_id'});
		noteGenderId.append(value.t_textstatus);
        rootTRoption.append(noteGenderId);
		if(value.t_textstatus=="Corporate" && subuser==true)
		{
		 noteListRemove =  $('<td/>').append($('<span/>',{'class':'glyphicongray glyphicon glyphicon-ban-circle','title':'CAN NOT DELETE'}));
		}
		else
		{
        noteListRemove =  $('<td/>').append($('<span/>',{'class':'glyphicon glyphicon-remove','title':'DELETE'}));
        }
		rootTRoption.append(noteListRemove);
  
        return rootTRoption;     
    }  
	
	this.showForm = function(){
		$('#notes').addClass("show");
		$('#notes .delete_btn').addClass('hide');
		$(".save_btn").attr('disabled',true);
		if(subuser==true)
		{
			 $("#Personal").css("display", "none");
		// $(".Private").attr('disabled',true);
		// $('#notes .notes_cont_input textarea').attr('disabled',true);
		 //$(".public").attr('disabled',true);
		//$("#notes .notes_cont_input textarea").prop("disabled", true);
		 $("#Corporate").css("display", "none");
		}else 
		{
		 $(".Private").attr('disabled',false);
		//$('#notes .notes_cont_input textarea').attr('disabled',false);
		 $(".public").attr('disabled',false);
		}
		//$('#notes textarea').focus();
		 var emoticon = ' ';
    $('#notes textarea').focus().val('').val(emoticon);
	}
	
	this.hideForm = function(){
		$('#notes').removeClass("show");	
		$('#notes textarea').val("");	
	}
	
	this.save = function(){
		note_content = $('#notes textarea').val();
		note_gender = ($('input[name=gender]:checked').val());
       if(note_gender=="Public" && subuser==false)
		{
		   node_status ='2'; 
		}
		else if(note_gender=="Private" && subuser==false)
		{
		  node_status ='1';
		}
		else
		{
		  node_status ='0';
		}
		
		if($('#notes .notes_main').hasClass('edit_note')){
			if(note_content.length){
				
				noteId = $('#notes .notes_main').attr('note_id')
				CONFIG.objModule[thisNotesObj.moduleName].model.updateNote(noteId,note_content,note_gender,node_status);
				$('#notes .notes_cont_input textarea').attr('disabled',false);
				$(".Private").attr('checked', 'checked');
			}			
		}else{
			if(note_content.length){
				
				if(subuser==true)
				{
					var userdefines ="subuser";
				}
				
				
				CONFIG.objModule[this.moduleName].model.addNote(this.sec_id,this.start_pos,this.end_pos,this.parent_tag,this.paremt_id,this.content,this.chap_id,note_content,note_gender,node_status,this.paraData,this.noteId,userdefines);	
             $('#notes .notes_cont_input textarea').attr('disabled',false);	
             $(".Private").attr('checked', 'checked');			 
			}else{
				this.clearNoteDetails();
			}
		}
	}
	
	this.addNotePopup = function(){
	
		this.showForm();
		$('#notes .notes_main').removeAttr('note_id');
		$('#notes .notes_main').removeClass('edit_note');
		$('#notes .glyphicon-pencil').addClass('hide');
		$('#notes .notes_cont_output').addClass('hide');
		$('#notes .notes_cont_input').removeClass('hide');
	}
	
	this.showNotePopup = function(noteID,txnchpid,txnsecid,txntagname,txnpgeid,note_title,note_status){
	debugger
		this.showForm();
		$('#notes_popup').hide();
		document.getElementById("notes").focus();
		$('nav.navbar .menus li.notes_btn').removeClass("active");
		$('#notes .notes_main').attr('note_id',noteID);
		$('#notes .notes_main').attr('txnchpid',txnchpid);
		$('#notes .notes_main').attr('txnsecid',txnsecid);
		$('#notes .notes_main').attr('txntagname',txntagname);
		$('#notes .notes_main').attr('txnpgeid',txnpgeid);
		$('#notes .notes_main').addClass('edit_note');
		$('#notes .glyphicon-pencil').removeClass('hide');
		$('#notes .notes_cont_output').removeClass('hide');
		$('#notes .notes_cont_output').html(note_title);
		
        if(note_status=="Personal")
		{
         $(".Private").attr('checked', 'checked');
		 }
		 else
		 {
		  $(".public").attr('checked', 'checked');
		 }		
		$('#notes .notes_cont_input').addClass('hide');
		statusnew =note_status; 
		this.editNotePopup();
	}
	
	this.editNotePopup = function(){
	debugger
	$('#notes .delete_btn').removeClass('hide');
		if(statusnew=="Corporate" && subuser==true)
		{
			$('#notes .delete_btn').addClass('hide');
			 $("#Personal").css("display", "none");
		// $(".Private").attr('disabled',true);
		 $('#notes .notes_cont_input textarea').attr('disabled',true);
		// $(".public").attr('disabled',true);
		 $("#Corporate").css("display", "none");
		//$("#notes .notes_cont_input textarea").prop("disabled", true);
		}else if(statusnew=="Personal" && subuser==false) 
		{
		 $(".Private").attr('disabled',false);
		$('#notes .notes_cont_input textarea').attr('disabled',false);
		 $(".public").attr('disabled',false);
		}
		
		
	

		$('#notes .glyphicon-pencil').addClass('hide');
		$('#notes .notes_cont_output').addClass('hide');
		$('#notes .notes_cont_input').removeClass('hide');
		$('#notes .notes_cont_input textarea').val($('#notes .notes_cont_output').html());	
//		$('#notes textarea').focus();
		SearchInput = $('#notes .notes_cont_input textarea');
		var strLength= SearchInput.val().length;
		SearchInput.focus();
		SearchInput[0].setSelectionRange(strLength, strLength);
	}
	this.cancel = function(){
		//debugger
		////////////////////CANCEL UNDER LINE////////////////////////////////////
		var isSaved=true;
		if(typeof this.arrNotes === "object"){
			for( i=0; i < this.arrNotes[0].length; i++){  
				if(this.arrNotes[0][i].t_txnid==this.noteId ){ 
					isSaved=false; 
				} 
			}	
		}
	    var pageName=this.chap_id;
		if(pageName!='' && isSaved){
		var profix=pageName.replace(/[0-9]/g,'');
		var $frame=(profix!='chc')?$('.Page iframe'):$('.Commentry iframe');
		var notedTags=$frame.contents().find("#"+this.paremt_id)[0].getElementsByTagName("u");
		for(i=0; i< notedTags.length; i++){
			if(notedTags[i].hasAttribute("newhigh_id") && notedTags[i].getAttribute("newhigh_id")==this.noteId){
				var range= document.createRange();
				var frag =range.createContextualFragment(notedTags[i].innerHTML);
				notedTags[i].parentNode.replaceChild(frag,notedTags[i]);
			}
		 }
		}
		this.hideForm();
		this.clearNoteDetails();
		$('#notes .notes_cont_input textarea').attr('disabled',false);
		$(".Private").attr('checked', 'checked');
		$('#notes_popup .notes_filter .search_area input').val("");
		$('#notes_popup .notes_filter .search_area .clear').hide();
	}

	this.localizationString = function(){
	this.showAllNotes();
		$( "#notes_popup .notes .panel-heading" ).append(localizedStrings.note_popup_pannel.header.title.text);
		$( "#notes_popup .panel-body .radio .current" ).text(localizedStrings.note_popup_pannel.current_chap.radio.text);
		$( "#notes_popup .panel-body .radio .all" ).text(localizedStrings.note_popup_pannel.all_chap.radio.text);
		$( "#notes_popup .search_area input" ).attr('placeholder',localizedStrings.note_popup_pannel.input_search.placeholder.text);
		$( ".notes_list thead tr th:nth-child(1)" ).text(localizedStrings.note_popup_pannel.note.title.text);
		$( ".notes_list thead tr th:nth-child(2)" ).text(localizedStrings.note_popup_pannel.page_chap.title.text);
		 $( ".notes_list thead tr th:nth-child(3)" ).text(localizedStrings.note_popup_pannel.action.title.text);
		$( ".notes_list thead tr th:nth-child(4)" ).text(localizedStrings.note_popup_pannel.delete.title.text);
		
                
                var myStringVar = $( "#notes .notes_main .panel-heading" ).html();
                if (myStringVar.indexOf("NOTE") < 0){
                    $( "#notes .notes_main .panel-heading" ).append(localizedStrings.notePopup.label.header.Note);
                } 
		$( "#notes .delete_btn" ).text(localizedStrings.notePopup.label.button.delete);
		$( "#notes .cancel_btn" ).text(localizedStrings.notePopup.label.button.cancel);
		$( "#notes .save_btn" ).text(localizedStrings.notePopup.label.button.save);
	}
	
	this.setDynamicEvents = function(){
		$('#notes .close_btn,#notes .cancel_btn').unbind( "click" );
		$('#notes .close_btn,#notes .cancel_btn').click(function(){
			thisNotesObj.cancel();
			
		});
			$('#notes .content').bind('keyup',function(){
    var note_val=$('#notes textarea').val();
    console.log(note_val);
    if(note_val=='' || note_val==' '){
     $(".save_btn").attr('disabled',true);
    }else{
      $(".save_btn").attr('disabled',false);
    }  
  });
  
		
		$( "#notes .save_btn" ).unbind( "click" );
		$('#notes .save_btn').click(function(){
				thisNotesObj.save();
				setTimeout(function(){ $("#notes").addClass("hide").removeClass("show"); }, 100);
				
				
		});
		
		var a=$('.Page iframe').contents().find('u');
		
		$('#notes_popup .note_list_container .notes .glyphicon-remove').unbind( "click" );
		$('#notes_popup .note_list_container .notes .glyphicon-remove').click(function(event){
			event.stopPropagation();
			$(this).parents().eq(1).addClass('delete')
			noteId=$(this).parents().eq(1).attr('note_id');
			parent_Id=$(this).parents().eq(1).attr('parent_id');
			content=$(this).parents().eq(1).attr('content');
			modifycontent=$(this).parents().eq(1).attr('modifycontent');
			modifygender=$(this).parents().eq(1).attr('modifygender');
			p_tag=$(this).parents().eq(1).attr('p_tag');
			chap_id=$(this).parents().eq(1).attr('chap_id');
			sec_id=$(this).parents().eq(1).attr('sec_id');
			//alert(parent_Id+noteId+content+modifycontent+p_tag);
			 /* if(modifygender=="Public" && subuser==true)
			{
			bootbox.alert(localizedStrings.note_popup_pannel.conformsubuser.alertmsg.deleteNote, function() {
			});
			//bootbox.confirm(localizedStrings.note_popup_pannel);
			}
			else  */
			//alert(1);
			
			
			bootbox.confirm(localizedStrings.note_popup_pannel.conform.alertmsg.deleteNote, function(result) {
		    if(result){
				bkmkData={
						noteId:noteId,
						parent_Id:parent_Id,
						sec_id:sec_id,
						chap_id:chap_id
					}
			CONFIG.objModule[thisNotesObj.moduleName].model.deleteNote(bkmkData);
				if(chap_id){
				var profix=chap_id.replace(/[0-9]/g,'');
				}
				var $frame=$('.Page iframe');
				if(profix=='chc'){
				$frame=$('.Commentry iframe');	
				}
				$elements=$frame.contents().find(p_tag.toLowerCase()+"#"+parent_Id).contents();
				for(i=0; i< $elements; i++){
					if($elements.eq(i).is('u') && $elements.eq(i).hasAttribute("newhigh_id") &&  $elements.eq(i).getAttribute()==noteId){
						var range= document.createRange();
						var frag =range.createContextualFragment($elements.eq(i).html());
						$elements.replaceChild(frag, $elements.eq(i));
					}
				}					
				}else{
					$('#notes_popup .note_list_container .notes').removeClass("delete");	
				}
			});
			
		});
		$('#notes_popup .note_list_container .notes').unbind("click");
		$('#notes_popup .note_list_container .notes').click(function(){
			thisTocObj.referID={"noteId":$(this).attr('note_id')};
			thisTocObj.goToSection($(this).attr('sec_id'),$(this).attr('chap_id'));
			thisNotesObj.showNotePopup($(this).attr('note_id'),$(this).attr('chap_id'),$(this).find('.note_sec_id').html(),$(this).attr('p_tag'),$(this).attr('parent_id'),$(this).find('.note_content').html(),$(this).find('.note_gender_id').html())
		});
		$('#notes .glyphicon-pencil').unbind( "click" );
		$('#notes .glyphicon-pencil').click(function(){
			thisNotesObj.editNotePopup();
		});
		$('#notes_popup .close_btn').unbind( "click" );
		$('#notes_popup .close_btn').click(function(){
			$('#notes_popup').hide();
			$('nav.navbar .menus li.notes_btn').removeClass("active");
		});
		$('#notes_popup .radio input#current').unbind( "click" );
		$('#notes_popup .radio input#current').click(function(){
				CONFIG.objModule[thisNotesObj.moduleName].model.getNotesList(thisTocObj.lastChapter);         
		});
		$('#notes_popup .radio input#all').unbind( "click" );
		$('#notes_popup .radio input#all').click(function(){
				CONFIG.objModule[thisNotesObj.moduleName].model.getNotesList();         
		});
		$('nav.navbar .menus li.notes_btn').unbind('click');
		$('nav.navbar .menus li.notes_btn').click(function(){
			
			thisNotesObj.hideForm();
			$('.custom_tooltip').addClass('hide');
			objModule.destroyModule(thisNotesObj.moduleName);
			$( "#notes_popup" ).toggle();
			//$('#notes_popup').show();
                        $("#all").attr('checked', 'checked');
			$(this).addClass("active");
			if($("input[name='history_rdo_btn']:checked").attr('id') == "current"){
				CONFIG.objModule[thisNotesObj.moduleName].model.getNotesList(thisTocObj.lastChapter);
			}else if($("input[name='history_rdo_btn']:checked").attr('id') == "all"){
				CONFIG.objModule[thisNotesObj.moduleName].model.getNotesList();
			}else{
				CONFIG.objModule[thisNotesObj.moduleName].model.getNotesList();
			}
			if($(window).width() < 1020){																				//bootstrap 3.x by Richard	
				$( '#container' ).addClass( "hidetoc" ).removeClass( "opentoc" );
			}
		});
		$('#notes_popup .notes_filter .search_area input').unbind( "keyup" );
		$('#notes_popup .notes_filter .search_area input').keyup(function(){
				thisNotesObj.noteSearchValue($(this).val());
		});
		$('#notes_popup .notes_filter .search_area input').unbind( "keypress" );
		$('#notes_popup .notes_filter .search_area input').keypress(function(e){
			 if(e.keyCode === 13){
				thisNotesObj.noteSearchValue($(this).val());
			 }
		});
		$('#notes_popup .notes_filter .search_area .clear').unbind( "click" );
		$('#notes_popup .notes_filter .search_area .clear').click(function(){
			$('#notes_popup .notes_filter .search_area input').val("");
			$('#notes_popup .notes_filter .search_area input').focus();
			$('#notes_popup .notes_filter .search_area .clear').hide();
			$('#notes_popup .note_list_container').find('.notes').show();
		});
	}
	this.noteSearchValue = function(val){
		$('#notes_popup .notes_filter .search_area .clear').show();
		if(val != ""){
			thisNotesObj.noteSearch(val);
		}else{
			$('#notes_popup .notes_filter .search_area .clear').hide();
			$('#notes_popup .note_list_container').find('.notes').show();
		}
	}
	this.noteSearch = function(keyword){
		var Len=$('#notes_popup .note_list_container').children().length;
		$('#notes_popup .note_list_container').find('.notes').hide();
		for(var i=0;i<Len;i++)
		{
			var Str=$('#notes_popup .note_list_container').find('.notes').eq(i).find('.note_content').text().toLowerCase();
			if(Str.indexOf(keyword.toLowerCase(),0)!=-1)
			{
				$('#notes_popup .note_list_container').find('.notes').eq(i).show();
			}
		}
	}
	
	
	
	
	
	 this.setNote = function(note_sec_id,note_sec_start_val,note_sec_end_val,targetTag,targetId,content,chapId,paraData,noteId){
		
                
                         if(note_sec_id==undefined){
                         var   t_Id= thisTocObj.objIframeMouse.firstElementChild.parentElement.id ;       
                         var myvar=null; 
                         if(t_Id.length > 0){
                         var res = t_Id.replace("t", "s");
                         var myarr = res.split("-");
                         var myvar = myarr[0];
                            note_sec_id=null;
                            note_sec_id=myvar;
              
                      var res1 = t_Id.replace("t", "table_inner_t"); 
                      var res2 = res1 .replace(".", "_");
                          targetId=null;
                          targetId=res2;
               
          }
          
    }
                
                
		this.noteId=noteId;
		this.paraData=paraData;
		this.addNotePopup();
		this.sec_id = note_sec_id;
		this.start_pos = note_sec_start_val;
		this.end_pos = note_sec_end_val;
		this.parent_tag = targetTag;
		this.paremt_id = targetId;
		this.content = content;
		this.chap_id = chapId;
	},this.getRendomId=function(min,max){
	  min=(min)?min:10000; max=(max)?max:99999;
	  return Math.floor(Math.random() * (max - min + 1)) + min;
	 },this.coveretNote=function(range){
		var setHighleted=this.getRendomId();
		var selectionContents =range.extractContents();
		var frame = document.getElementById('page_frame');
			var frameWindow = frame && frame.contentWindow; 
			var frameDocument = frameWindow && frameWindow.document;
		var span=frameDocument.createElement('u');
		span.setAttribute("newhigh_id",setHighleted);
		span.setAttribute("highbook_id",setHighleted);
		span.setAttribute("class","data-tooltip");
		span.setAttribute("data-tooltip","Click to See Note");
		span.setAttribute("style","background-color:#00FFFF");
		span.appendChild(selectionContents)
		range.insertNode(span);
		return setHighleted;
	},this.coveretNotes=function(range){
		var setHighleted=this.getRendomId();
		var selectionContents =range.extractContents();
		var frame = document.getElementById('commentry_frame');
			var frameWindow = frame && frame.contentWindow; 
			var frameDocument = frameWindow && frameWindow.document;
		var span=frameDocument.createElement('u');
		span.setAttribute("newhigh_id",setHighleted);
		span.setAttribute("highbook_id",setHighleted);
		span.setAttribute("class","data-tooltip");
		span.setAttribute("data-tooltip","Click to See Note");
		span.setAttribute("style","background-color:#00FFFF");
		span.appendChild(selectionContents)
		range.insertNode(span);
		return setHighleted;
	}  
	
	
	
	
	
	this.clearNoteDetails = function(){
		this.sec_id = "";
		this.start_pos = "";
		this.end_pos = "";
		this.parent_tag = "";
		this.paremt_id = "";
		this.content = "";
		this.chap_id = "";
	}
	this.callbackAddNotes = function(dbResultset){
		thisNotesObj.showNotePopup(dbResultset.t_txnid,dbResultset.t_txncontent);
	}
	this.callbackUpdateNotes = function(dbResultset){
		thisNotesObj.hideForm();
		thisNotesObj.showNotePopup(dbResultset.t_txnid,dbResultset.t_txncontent);
	}
	this.callbackDeleteNotes = function(dbResultset){
		$('#notes_popup .notes_list .note_list_container .notes.delete').remove();
	}
	
	
	this.managePanelSize = function(){
		//windowHeight = $(window).outerHeight();
		//mainHeaderHeight = $('header.main_header').outerHeight();
		//notesHeaderHeight = $('#notes_popup .notes').outerHeight();	
		//resultHeadHeight = $('#notes_popup .notes_list table thead').outerHeight();	
		//search_container = windowHeight - (mainHeaderHeight + notesHeaderHeight + resultHeadHeight + 6 );
		//$('#notes_popup .notes_list table tbody').css({'max-height':search_container});	
	}
	this.showAllNotes = function()
	{
		
		//CONFIG.objModule[thisNotesObj.moduleName].model.getNotesList();
		//CONFIG.objModule['highlight'].model.saveHighlightData();
CONFIG.objModule[this.moduleName].model.getUserInfo();
	CONFIG.objModule[this.moduleName].model.getNotesList();	
	
	//this.getNotes();
	}
	$( "#notes .delete_btn" ).unbind( "click" );
	$( "#notes .delete_btn" ).click(function(event){
			//alert("dsdsds");
			event.stopPropagation();
			//$(this).parents().eq(1).addClass('delete')
			var noteId= $('#notes .notes_main').attr('note_id');
			//alert(noteId);
			parent_Id=$('#notes .notes_main').attr('txnpgeid');
			
			p_tag=$('#notes .notes_main').attr('txntagname');
			chap_id=$('#notes .notes_main').attr('txnchpid');
			sec_id=$('#notes .notes_main').attr('txnsecid');
			
		
		bootbox.confirm(localizedStrings.note_popup_pannel.conform.alertmsg.deleteNote, function(result) {
		    if(result){
			
			
		 
				bkmkData={
						noteId:noteId,
						parent_Id:parent_Id,
						sec_id:sec_id,
						chap_id:chap_id
					}
					//alert("notedelete");
			CONFIG.objModule[thisNotesObj.moduleName].model.deleteNote(bkmkData);
			//debugger
				if(chap_id){
				var profix=chap_id.replace(/[0-9]/g,'');
				}
				var $frame=$('.Page iframe');
				if(profix=='chc'){
				$frame=$('.Commentry iframe');	
				}
				
				$elements=$frame.contents().find(p_tag.toLowerCase()+"#"+parent_Id).contents();
				for(i=0; i< $elements; i++){
				
					if($elements.eq(i).is('u') && $elements.eq(i).hasAttribute("newhigh_id") &&  $elements.eq(i).getAttribute()==noteId){
						var range= document.createRange();
						var frag =range.createContextualFragment($elements.eq(i).html());
						$elements.replaceChild(frag, $elements.eq(i));
					}
					//break;
				}
				setTimeout(function(){
			$(".notes_btn").trigger('click');
				 setTimeout(function(){
				$(".close_btn").trigger('click');
				},10); 
			},100);
				//alert(1);
				//$('nav.navbar .menus li.notes_btn').addClass("active");
				setTimeout(function(){ $("#notes").addClass("hide").removeClass("show"); }, 100);
				//return true;
                            $frame.contents().find('.fancybox-close').trigger('click');   //mmm
                        
                             }
				else{
					$('#notes_popup .note_list_container .notes').removeClass("delete");	
				}
				});
		});	
	
	
}

