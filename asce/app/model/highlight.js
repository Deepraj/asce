// JavaScript Document

function modelHighlight(){
	this.moduleName = "highlight";
	this.objConnect = new JSDBC();
	this.init = function(){
	}
	this.saveHighlightData=function(arrayData){
		//debugger
		this.objConnect.setService('saveHighls');
		this.objConnect.setMethod('savedata');
		this.objConnect.setParam(arrayData);
		this.objConnect.setCallback();
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setHighlightSingleText);
		this.objConnect.submit();
	} 
	
	this.addHighlightList = function(sel_sec_id,start_pos,end_pos,targetTag,targetId,content,chapId,t_range){
		//debugger
		arrParm = {
			notesecid:sel_sec_id,
			notes_start:start_pos,
			notes_end:end_pos,
			tag_name:targetTag,
			target_id:targetId,
			content:content,
			chapid:chapId,
			t_range:t_range
		}
		this.objConnect.setService('Highlights');
		this.objConnect.setMethod('addhighlight');
		this.objConnect.setParam(arrParm);
        this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.callbackAddHighlight);
		this.objConnect.submit();		
	}
	this.getHighlightText = function(chapid){	
	
		this.objConnect.setService('saveHighls');
		this.objConnect.setMethod('retrivehighlights');
		this.objConnect.setParam({'chapid':chapid});
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.setHighlightText);
		this.objConnect.submit();
	}
	this.deleteHighlightText = function(delData){
		
		this.objConnect.setService('saveHighls');
		this.objConnect.setMethod('deletehighlights');
		this.objConnect.setParam(delData);
		this.objConnect.setCallback(CONFIG.objModule[this.moduleName].controler.highlightEvent);
		this.objConnect.submit();
                this.getHighlightText();
	}
	this.updateHighLightColor = function(code){
		this.objConnect.setService('Highlights');
		this.objConnect.setMethod('UpdateHightLight');
		this.objConnect.setParam({'code':code});
		this.objConnect.setCallback();
		this.objConnect.submit();
	}
}