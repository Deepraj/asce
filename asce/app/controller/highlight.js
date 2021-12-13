// JavaScript Document
i=1,setHighleted=1;
var lastid;
function controllerHighlight(){
objThis = this;
var t_Id=null;
this.moduleName = "highlight";
this.init = function(){
	this.setDynamicEvents();
}
this.destroy = function(){}
this.setDynamicEvents = function(){
	
},this.getRendomId=function(min,max){
  min=(min)?min:10000; max=(max)?max:99999;
  return Math.floor(Math.random() * (max - min + 1)) + min;
  },
this.addHighlightText = function(sel_sec_id,start_pos,end_pos,targetTag,targetId,content,range,paraContent,chapId){
			setHighleted=this.getRendomId();
			var frame = document.getElementById('page_frame');
			var frameWindow = frame && frame.contentWindow; 
			var frameDocument = frameWindow && frameWindow.document;
			var selectionContents =range.extractContents();
			var span=frameDocument.createElement('span');
			span.setAttribute("high_id","newhigh_id"+setHighleted);
			span.setAttribute("id",setHighleted);
			span.appendChild(selectionContents)
			range.insertNode(span);
			var $fram=$('.Page iframe');
			if($fram.contents().find('#'+setHighleted).length<1){
			$fram=$('.Commentry iframe');
			}
			var code="hightlight_yellow";
			$fram.contents().find('#'+setHighleted).addClass(code);
			/* $(".notes_btn").trigger('click');
			$(".close_btn").trigger('click'); */
			var src= $fram.attr('src');
			var highlight=new controllerHighlight()
			highlight.saveHighlightData($fram,setHighleted);
			
	},this.addHighlightTexts = function(sel_sec_id,start_pos,end_pos,targetTag,targetId,content,range,paraContent,chapId){
			setHighleted=this.getRendomId();
			var frame = document.getElementById('commentry_frame');
			var frameWindow = frame && frame.contentWindow; 
			var frameDocument = frameWindow && frameWindow.document;
			var selectionContents =range.extractContents();
			var span=frameDocument.createElement('span');
			span.setAttribute("high_id","newhigh_id"+setHighleted);
			span.setAttribute("id",setHighleted);
			span.appendChild(selectionContents)
			range.insertNode(span);
			var $fram=$('.Page iframe');
			if($fram.contents().find('#'+setHighleted).length<1){
			$fram=$('.Commentry iframe');
			}
			var code="hightlight_yellow";
			$fram.contents().find('#'+setHighleted).addClass(code);
			/* $(".notes_btn").trigger('click');
			$(".close_btn").trigger('click'); */
			var src= $fram.attr('src');
			var highlight=new controllerHighlight()
			highlight.saveHighlightData($fram,setHighleted);
			
	},this.saveHighlightData=function($fram,id,t_ID){
		//alert(11); 		
                
		var pid,secId,paraData;
                var chk_pid=false;
		var chapterId=($fram.attr('name')=="page_frame")?thisTocObj.lastChapter:thisTocObj.lastCommentary;
		var $HiLi=$fram.contents().find('#'+setHighleted).parent();
		$HiLi.parents().each(function(){
				if($(this).is('div')&& $(this).hasClass('section')){
					secId=$(this).attr('id');
				}
			})
                        
                        if(secId==undefined){
                      var   t_Id= thisTocObj.objIframeMouse.firstElementChild.parentElement.id ; 
                      if(t_Id.length > 0){
                        var res = t_Id.replace("t", "s");
                        var myarr = res.split("-");
                        var myvar = myarr[0];
                        secId=null;
                        secId=myvar;
                     
                      var res1 = t_Id.replace("t", "table_inner_t"); 
                      var res2 = res1 .replace(".", "_");
                      chk_pid=true;
                   // pid=null;
                   // pid=res2;
              }
                          
        }
		if($HiLi.is('p')){
                    if(chk_pid==false){
			pid=$HiLi.attr('id');
                    }else{ pid= res2; }
			paraData=$HiLi.html();
			
		}else if($HiLi.parent().is('p')){
                    if(chk_pid==false){
			 pid=$HiLi.parent().attr('id');
                     }else{ pid= res2; }
			 paraData=$HiLi.parent().html();
		}
		DataSet={
			paraId:pid,
			sectionId:secId,
			paraData:paraData,
			chapterId:chapterId
		} 
		CONFIG.objModule[this.moduleName].model.saveHighlightData(DataSet);
	}
	
	
	this.highlightEvent = function(){ 
		//console.log("clicked");
		var frame = document.getElementById('page_frame');
		var frameWindow = frame && frame.contentWindow; 
		var frameDocument = frameWindow && frameWindow.document;
		$(frameDocument).find("[class^='hightlight_']").unbind('click');
		$(frameDocument).find("[class^='hightlight_']").click(function(){
			//this.localizationString();
		//if(confirm("do you want to remove highLight")){
			var $that=$(this),that=this;
			bootbox.confirm(localizedStrings.highlite_popup_pannel.conform.alertmsg.deleteNote, function(result) {
		    if(result){
				//debugger
		var pid,secId,paraData;
		var $parTag;
		var chapterId=thisTocObj.lastChapter;
			$that.parents().each(function(){
				if($(this).is('p')){
					pid=$(this).attr('id');
					$parTag=$(this);
				}if($(this).is('div') && $(this).hasClass('section')){
					secId=$(this).attr('id');
				}
			});
                        
                           if(secId==undefined){
          var   t_Id= thisTocObj.objIframeMouse.firstElementChild.parentElement.id ;       
          var myvar=null; 
          if(t_Id.length > 0){
               var res = t_Id.replace("t", "s");
               var myarr = res.split("-");
               var myvar = myarr[0];
               secId=null;
               secId=myvar;
               var res1 = t_Id.replace("t", "table_inner_t"); 
               var res2 = res1 .replace(".", "_");
                        pid=null;
                        pid=res2;
               
          }   
        }
                        
			removespan(that);
			paraData=$parTag.html();
			DataSet={
				paraId:pid,
				sectionId:secId,
				paraData:paraData,
				chapterId:chapterId
			}
			
			objThis.deleteHighlight(DataSet);
			}else{
					$('#notes_popup .note_list_container .notes').removeClass("delete");	
				}
			//}
		});
		});
		
		var frame2 = document.getElementById('commentry_frame');
		var frameWindow2 = frame2 && frame2.contentWindow; 
		var frameDocument2 = frameWindow2 && frameWindow2.document;
		$(frameDocument2).find("[class^='hightlight_']").unbind('click');
		$(frameDocument2).find("[class^='hightlight_']").click(function(){
			//debugger
			var $that=$(this),that=this;
			bootbox.confirm(localizedStrings.highlite_popup_pannel.conform.alertmsg.deleteNote, function(result) {
		 if(result){
			// debugger
			var pid,secId,paraData;
		var $parTag;
		var chapterId=thisTocObj.lastCommentary;
			$that.parents().each(function(){
				if($(this).is('p')){
					pid=$(this).attr('id');
					$parTag=$(this);
				}if($(this).is('div') && $(this).hasClass('section')){
					secId=$(this).attr('id');
				}
			});
			removespan(that);
			paraData=$parTag.html();
			DataSet={
				paraId:pid,
				sectionId:secId,
				paraData:paraData,
				chapterId:chapterId
			}
			objThis.deleteHighlight(DataSet);
			}
			
			});
		});
	}
	
	
	
	this.localizationString = function(){
		$( "#notes_popup .notes .panel-heading" ).append(localizedStrings.highlite_popup_pannel.header.title.text);
		$( "#notes_popup .panel-body .radio .current" ).text(localizedStrings.highlite_popup_pannel.current_chap.radio.text);
		$( "#notes_popup .panel-body .radio .all" ).text(localizedStrings.highlite_popup_pannel.all_chap.radio.text);
		$( "#notes_popup .search_area input" ).attr('placeholder',localizedStrings.highlite_popup_pannel.input_search.placeholder.text);
		$( ".notes_list thead tr th:nth-child(1)" ).text(localizedStrings.highlite_popup_pannel.note.title.text);
		$( ".notes_list thead tr th:nth-child(2)" ).text(localizedStrings.highlite_popup_pannel.page_chap.title.text);
		 $( ".notes_list thead tr th:nth-child(3)" ).text(localizedStrings.highlite_popup_pannel.action.title.text);
		$( ".notes_list thead tr th:nth-child(4)" ).text(localizedStrings.highlite_popup_pannel.delete.title.text);
		
		$( "#notes .notes_main .panel-heading" ).append(localizedStrings.notePopup.label.header.Note);
		$( "#notes .cancel_btn" ).text(localizedStrings.notePopup.label.button.cancel);
		$( "#notes .save_btn" ).text(localizedStrings.notePopup.label.button.save);
	}
	
	
	
	
	
	this.deleteHighlight = function(highLightId){
		CONFIG.objModule[objThis.moduleName].model.deleteHighlightText(highLightId);  
	}
	this.updateHigh = function(code){
		CONFIG.objModule[objThis.moduleName].model.updateHighLightColor(code);  
	}
	this.callbackAddHighlighted= function(dbResultset){}
	this.callbackAddHighlight= function(dbResultset){
		//alert(11);debugger
		setTimeout(function(){ 
		var tst=dbResultset.Highlight.split("::");
		dbResultset.Highlight=tst[0];
		var $fram=$('.Page iframe');
			if(tst[1]){
				var profix=tst[1].replace(/[0-9]/ig,'');
				if(profix=="chc")
				var $fram=$('.Commentry iframe');	
			}
			$fram.contents().find('[high_id="new_highlight"]').attr('high_id',dbResultset.Highlight);
		 }, 300);
		 lastid = dbResultset.Highlight;
	}
	this.highlightContent = function(range){
		result = false;
		try {
			var newNode = document.createElement("span");
			newNode.setAttribute("class", "highlight_text");
			range.surroundContents(newNode);
			result = true;
		}catch(err) {
			alert( " Selected one more element .... error : "+ err.message);
		}
		return result;
	}

	this.getHighlightText = function(chap_id){
		CONFIG.objModule[this.moduleName].model.getHighlightText(chap_id); 	
	}
	this.setHighlightSingleText = function(dbResultset){
		//alert(1); debugger
		this.highlightValues = dbResultset;
		$.each(this.highlightValues,function(key,value){
			//debugger
				if(value.chapterId){
				var profix=value.chapterId.replace(/[0-9]/g,'');
				}
				var $frame=(profix!='chc')?$('.Page iframe'):$('.Commentry iframe');
				var startNode=$frame.contents().find("#"+value.paraId);
				
				if(startNode.length > 0){
					startNode.html(value.paraData);
				}
		});
		objThis.highlightEvent();
		return true;
	}
	this.setHighlightText = function(dbResultset){
		//debugger
		this.highlightValues = dbResultset;
		$.each(this.highlightValues,function(key,value){
			var setLoaded=true;
			if(setLoaded){
			var highLightInterval=setInterval(function(){
				var $frame, pageName;
				if(value.t_txhchapid){
				var profix=value.t_txhchapid.replace(/[0-9]/g,'');
					if(profix=='ch'){
						$frame=$('.Page iframe'), pageName=this.chapWithPath.split("/").pop();
						if(pageName==value.t_txhchapid){
						var startNode=$frame.contents().find("#"+value.t_txhparaid);
						if(startNode.length > 0){
							//startNode.html(value.paraData);
							var div=document.createElement("div");
                                        div.innerHTML=value.paraData;
                                        var spans =div.getElementsByTagName("span");
                                        for(i=0; i< spans.length; i++){
                                            if(spans[i].hasAttribute("class") && spans[i].getAttribute("class")=="MathJax"){
                                                spans[i].remove();
                                            }
                                        }
                                        var scripts =div.getElementsByTagName("script");
                                        for(j=0; j< scripts.length; j++ ){
                                            if(scripts[j].hasAttribute("type") && scripts[j].getAttribute("type")=="math\/mml" ){
                                                var range= document.createRange();
                                                var frag =range.createContextualFragment(scripts[j].innerHTML);
                                                scripts[j].parentNode.replaceChild(frag, scripts[j]);
                                            }
                                        }
                                        startNode[0].innerHTML=div.innerHTML;
							setLoaded=false;
							clearInterval(highLightInterval);
							objThis.highlightEvent();
							}
						}
					}else{
						$frame=$('.Commentry iframe'),pageName=this.commentryChap;
						if(pageName==value.t_txhchapid){
						var startNode=$frame.contents().find("#"+value.t_txhparaid);
						if(startNode.length > 0){
							//startNode.html(value.paraData);
							var div=document.createElement("div");
                                        div.innerHTML=value.paraData;
                                        var spans =div.getElementsByTagName("span");
                                        for(i=0; i< spans.length; i++){
                                            if(spans[i].hasAttribute("class") && spans[i].getAttribute("class")=="MathJax"){
                                                spans[i].remove();
                                            }
                                        }
                                        var scripts =div.getElementsByTagName("script");
                                        for(j=0; j< scripts.length; j++ ){
                                            if(scripts[j].hasAttribute("type") && scripts[j].getAttribute("type")=="math\/mml" ){
                                                var range= document.createRange();
                                                var frag =range.createContextualFragment(scripts[j].innerHTML);
                                                scripts[j].parentNode.replaceChild(frag, scripts[j]);
                                            }
                                        }
                                        startNode[0].innerHTML=div.innerHTML;
							setLoaded=false;
							clearInterval(highLightInterval);
							objThis.highlightEvent();
							}
						}
					}
				}				
			},100);
			}
		i++;
		});
		
		return true;
	}
	cur_val=i;
}

$.fn.replaceText = function( search, replace, text_only ) {
return this.each(function(){
        var node = this.firstChild,
        val, new_val, remove = [];
        if ( node ) {
            do {
              if ( node.nodeType === 3 ) {
                val = node.nodeValue;
                new_val = val.replace( search, replace );
                if ( new_val !== val ) {
                  if ( !text_only && /</.test( new_val ) ) {
                    $(node).before( new_val );
                    remove.push( node );
                  } else {
                    node.nodeValue = new_val;
                  }
                }
              }
            } while ( node = node.nextSibling );
        }
        remove.length && $(remove).remove();
    });
};
function change_color(color,code){
	var $fram=$('.Page iframe');
	if($fram.contents().find('#'+setHighleted).length<1){
	$fram=$('.Commentry iframe');
	}
    $fram.contents().find('#'+setHighleted).addClass(code);
	/* $(".notes_btn").trigger('click');
	$(".close_btn").trigger('click'); */
	var src= $fram.attr('src');
    var highlight=new controllerHighlight()
	highlight.saveHighlightData($fram,setHighleted);
    //highlight.updateHigh(code);
	}
removespan = function(span) {
	var range= document.createRange();
	var frag =range.createContextualFragment(span.innerHTML);
    span.parentNode.replaceChild(frag, span);
}
