//Copyright@ MPS Ltd 2015
/**
 * module management
 * @author Arulkumar
 */
function modelNotes (){
    this.moduleName = "notes_popup";
	this.objConnect = new JSDBC();
	this.init = function(){
	}
	this.getNotesList = function(chap_id){
		arrParm = {
			chapid:chap_id
		}
		this.objConnect.setService('Notes')
		this.objConnect.setMethod('retrivenotes')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.getNotes);
		this.objConnect.submit();		
	}
	this.addNote = function(sec_id,start_pos,end_pos,parent_tag,paremt_id,content,chap_id,note_content,note_gender,node_status,paraData,noteId,userdefine){
		$("#notes").addClass("hide").removeClass("show");
		
		arrParm = {
			notesecid:sec_id,
			notes_start:start_pos,
			notes_end:end_pos,
			tag_name:parent_tag,
			target_id:paremt_id,
			content:content,
			chapid:chap_id,
			note_content:note_content,
			note_gender:note_gender,
			node_status:node_status,
			paraData:paraData,
			noteId:noteId,
            userdefine:userdefine
		}
		 setTimeout(function(){
			$(".notes_btn").trigger('click');
		//		setTimeout(function(){
		//		$(".close_btn").trigger('click');
		//		},10);
			},100); 
		this.objConnect.setService('Notes');
		this.objConnect.setMethod('addnotes');
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.getNotes);
		this.objConnect.submit();
                
         this.getHighlightTextNote(chap_id);       
		
	}
        
        this.getHighlightTextNote = function(chap_id){	
	
		this.objConnect.setService('saveHighls');
		this.objConnect.setMethod('retrivehighlights');
		this.objConnect.setParam({'chapid':chap_id});
		this.objConnect.setCallback(CONFIG.objModule['highlight'].controler.setHighlightText);
		this.objConnect.submit();
            }
       
        
	this.getPublicNots=function(data){
		this.objConnect.setService('Notes');
		this.objConnect.setMethod('getPublicNots');
		this.objConnect.setParam(data);
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.callbackgetPublicNots);
		this.objConnect.submit();
		
	}
	this.updateNote = function(noteId,noteContent,note_gender){
		//debugger;
		arrParm = {
			note_id:noteId,
			note_content:noteContent,
			note_gender:note_gender,
			//paraData:paraData,
			//noteId:noteId
		}
		this.objConnect.setService('Notes')
		this.objConnect.setMethod('updatenotes')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.callbackUpdateNotes);
		this.objConnect.submit();		
	}	
	this.deleteNote = function(arrParm){
		//debugger;
		$('#notes_popup .notes_list .note_list_container .notes.delete').remove();
		this.objConnect.setService('Notes');
		this.objConnect.setMethod('deletenotes');
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule['highlight'].controler.setHighlightSingleText);
		this.objConnect.submit();
	}
	this.getUserInfo = function(){
	
		this.objConnect.setService('Book')
		this.objConnect.setMethod('subuserinfo')
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setUserInfo)
		this.objConnect.submit();		
	}

}
