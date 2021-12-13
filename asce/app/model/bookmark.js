// JavaScript Document

function modelBookmark(){
	this.moduleName = "bookmark";
	this.objConnect = new JSDBC();
	
	this.init = function(){
	
	}
	this.getBookmarkList = function(chap_id){
		arrParm = {
			chapid:chap_id
		}
		this.objConnect.setService('Bookmarks')
		this.objConnect.setMethod('retrivebookmark')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.getBookmark);
		this.objConnect.submit();		
	}
	this.addBookmark = function(chap_id,bookmark_content,sec_id,start_pos,end_pos,parent_tag,paremt_id,content,paraData,bookmarkSecId){
		//debugger;
		arrParm = {
			chapid:chap_id,
			bookmark_title:bookmark_content,
			bmksecid:sec_id,
			bookmark_start:start_pos,
			bookmark_end:end_pos,
			tag_name:parent_tag,
			target_id:paremt_id,
			content:content,
			paraData:paraData,
			bookmarkSecId:bookmarkSecId
		}
		this.objConnect.setService('Bookmarks')
		this.objConnect.setMethod('addbookmark')
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.callbackAddBookmark);    
		this.objConnect.submit();	
                
                this.getHighlightTextBookmark(chap_id);
              
	}
       
       this.getHighlightTextBookmark = function(chap_id){	
	
		this.objConnect.setService('saveHighls');
		this.objConnect.setMethod('retrivehighlights');
		this.objConnect.setParam({'chapid':chap_id});
		this.objConnect.setCallback(CONFIG.objModule['highlight'].controler.setHighlightText);
		this.objConnect.submit();
            }
	this.deleteBookmark = function(arrParm){
		$('#bookmarks .bookmark_list_container .bookmark.delete').remove();
		this.objConnect.setService('Bookmarks')
		this.objConnect.setMethod('deletebookmark')
		this.objConnect.setParam(arrParm);
       // this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.callbackDeleteBookmark);
		this.objConnect.setCallback(CONFIG.objModule['highlight'].controler.setHighlightSingleText);
		this.objConnect.submit();		
	}
}