// JavaScript Document
var divname = document.createElement("div");
//debugger;
if($('input:radio[name="history_rdo_btn_rdt"][value="current_edition"]').attr("checked")){
   var leavcorrectionflage = true; 
}else{
    var leavcorrectionflage = false;
}

function controllerHistory() {

    thisHistoryObj = this;
    thisHistoryObj.historyLoadedPage = false;
    this.moduleName = "history";
    this.historyContents = new Array();
    this.init = function () {
        this.loadHistoryPanel();
    }

    this.destroy = function () {
        this.historyContents = new Array();
        this.hideForm();
    }

    this.loadHistoryPanel = function () {
        $('#history_popup').load(CONFIG.viewPath + "history.html", function () {
            thisHistoryObj.start();
        });
    }

    this.start = function () {
        this.historyContents = CONFIG.objModule["toc"].controler
                .getContentList();
        // alert(this.historyContents);
        this.setHistoryContents();
        this.setDynamicEvents();
    }

    this.showForm = function () {
        $('nav.navbar .menus li.history_panel').addClass("active");
        $( "#history_popup" ).toggle();
       // $('#history_popup').addClass("show");
    }

    this.hideForm = function () {   
      
       if(leavcorrectionflage == false){
        $('#commentry_frame').contents().find(".deletion").hide();
        $('#commentry_frame').contents().find(".insertion").css('color', 'black');
        
        $('#page_frame').contents().find(".deletion").hide();
        $('#page_frame').contents().find(".insertion").css('color', 'black');
    }
       
        $('nav.navbar .menus li.history_panel').removeClass("active");
        $('#history_popup').removeClass("show");
    }

    this.cancel = function () {
        thisHistoryObj.hideForm();
    }
    this.setHistoryContents = function () {
        /*
         * alert('Anuj'); console.log('Values----');
         * console.log(this.historyContents); console.log('End Values-----');
         */
        $('#history_popup .panel panel-default history_result').empty();
        if (!(this.historyContents != null && this.historyContents.length)) {
            $('#history_popup .panel-data').append(
                    thisHistoryObj.generateMessage());
        } else {
            $.each(this.historyContents, function (key, value) {
                $('#history_popup .panel-data').append(
                        thisHistoryObj.generateHistoryList(value));
            });
        }
        //checking for content
        var htmlContent = $('.panel-data').html();
        if(htmlContent==''){
           $('.panel-data').html("No Results"); 
        }
    }
    this.generateMessage = function (value) {
        str = '<div class="row"><div class="pull-right date">No Record Found For This Book</div>';
        // rootChapOption =
        // $('<option/>',{'chapId':value.chapId,'chapSrc':value.chapSrc});
        // rootChapOption.append(value.chapLabel+" : "+value.chapTitle);
        return str;
    }
    this.generateHistoryList = function (value) {
        Chap = value.chapter_no;
        ChapName = Chap.replace(/[^a-z]/gi, '');
        ChapNum = Chap.replace(/[^0-9]/gi, '');
        if (ChapName == 'ch') {
            chapNameValue = 'Chapter ' + ChapNum;
        }
        if (ChapName == 'chc') {
            chapNameValue = 'Commentary ' + ChapNum;
        }
        if (ChapName == 'ap') {
            chapNameValue = 'Appendix ' + ChapNum;
        }
        if (ChapName == 'apc') {
            chapNameValue = 'Appendix Commentary ' + ChapNum;
        }
        // alert(chapNameValue);
        str = '<div class="row"><div class="pull-right date">'
                + value.final_version
                + '</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'
                + chapNameValue
                + '</div><div class="h_result" style="cursor: pointer; cursor: hand;" version="'
                + value.version + '" chapter_no="' + value.chapter_no
                + '" section_no="' + value.section_no + '">' + value.data
                + '</div>';
        // rootChapOption =
        // $('<option/>',{'chapId':value.chapId,'chapSrc':value.chapSrc});
        // rootChapOption.append(value.chapLabel+" : "+value.chapTitle);
        return str;
    }
    this.setDynamicEvents = function () {
        $("nav.navbar .menus li.history_panel").unbind("click");
        $("nav.navbar .menus li.history_panel").click(function () {
            objModule.destroyModule(thisHistoryObj.moduleName);
            thisHistoryObj.showForm();
        });

        //$('#history_popup .close_btn').unbind("click");
        $('#history_popup .close_btn').click(
                function () {
                    $('input:radio[name="history_rdo_btn_rdt"][value="current_edition"]').attr('checked', true);
                    //debugger;
                    if(leavcorrectionflage==false){
                        
                        $('#commentry_frame').contents().find(".deletion").hide();
//                        $('#commentry_frame').contents().find(".insertion").css('color', 'black');
                         
                        $('#commentry_frame').contents().find(".insertion").css({'color':'black','text-decoration':'none'});
                        $('#commentry_frame').contents().find(".insertion img").css({'border':'0px','border-color':'black'});
                        $('#commentry_frame').contents().find(".deletion img").css({'border':'0px','border-color':'black'});
              
                        
                        $('#page_frame').contents().find(".deletion").hide();
                        $('#page_frame').contents().find(".insertion").css({'color':'black','text-decoration':'none'});
                        $('#page_frame').contents().find(".insertion img").css({'border':'0px','border-color':'black'});
                        $('#page_frame').contents().find(".deletion img").css({'border':'0px','border-color':'black'});
                    }
                    /*------------ For Corrections Leave or Not------------------*/
                   /* checked_status = $("#leave_corrections").is(':checked') ? 1
                            : 0;
                    currentChapter = CONFIG.objModule["toc"].controler
                            .getCurrentChapter();
                    load_chapter = currentChapter.substring(0, currentChapter
                            .indexOf('_'));
                    load_chapter = load_chapter != '' ? load_chapter
                            : currentChapter;
                    if (checked_status != '1' && thisHistoryObj.historyLoadedPage == true) {
                        thisTocObj.loadOriginalChapter(load_chapter);
                    } else if (checked_status != '1') {
                        thisTocObj.loadChapter(load_chapter);
                    }*/
                    /*--------------------------End------------------------------*/
                    thisHistoryObj.cancel();
                   $('#history_popup').hide();
                   $('#history_popup .dropdownid').val('current_edition');
                });

        $('#datepicker-history-from').Zebra_DatePicker();
        $('#datepicker-history-to').Zebra_DatePicker();
        /*----------------------------Date Picker--------------------------------*/
        $('#datepicker-history-from').Zebra_DatePicker({
            format: 'm-d-Y',
            selectWeek: true,
            inline: true,
            pair: $('#datepicker-history-to'),
            firstDay: 1,
            // direction: true, // add this line
            onSelect: function (view, elements) {
                $('#to_date').val('');
                $('#from_date').val($(this).val());
            }
        });

        $('#datepicker-history-to')
                .Zebra_DatePicker(
                        {
                            format: 'm-d-Y',
                            selectWeek: true,
                            onSelect: function (view, elements) {
                                $('#to_date').val($(this).val());
                                startDate = $('#from_date').val();
                                endDate = $('#to_date').val();
                                /*----------------------Method For Fetching Data According To Date---------*/
                                var response = '';
                                $.ajax({
                                    type: "POST",
                                    url: CONFIG.webServicePath
                                            + "Book_library/GetDataBetweenDate",
                                    data: {
                                        startDate: startDate,
                                        endDate: endDate
                                    },
                                    async: false,
                                    success: function (text) {
                                        response = text;
                                        // alert(response);
                                        $('#history_popup .panel-data')
                                                .empty();
                                        if (response.trim() == '') {
                                            $(
                                                    '#history_popup .panel-data')
                                                    .html(
                                                            '<div class="row"><div class="pull-right date">No Record Found For This Book</div>');
                                        } else {
                                            $(
                                                    '#history_popup .panel-data')
                                                    .html(response);
                                        }
                                        //checking for content
                                        var htmlContent = $('.panel-data').html();
                                        if(htmlContent==''){
                                        $('.panel-data').html("No Results"); 
                                        } 
                                    }
                                });
                                /*-------------------------------------End----------------------------------*/

                            }
                            // direction: true // change 0 to true
                        });

        /*--------------------------------End------------------------------------*/
        /*-----------------For Loading Dynamic Chapters-------------------*/
        $('#history_popup .history_result .h_result').click(
                function () {
                    currChapter = thisTocObj.getCurrentChapter();
                    chapter_no = $(this).attr('chapter_no') + '_'
                            + $(this).attr('version');
                    section = $(this).attr('section_no');
                    // alert('Anuj Dubey');
                    if ($(this).attr('version') != ""
                            && $(this).attr('chapter_no') !== ''
                            && currChapter != chapter_no) {
                        chapter_no = $(this).attr('chapter_no') + '_'
                                + $(this).attr('version');
                        str = $(this).attr('chapter_no');
                        section = $(this).attr('section_no');
                        res = str.replace(/[^a-z]/gi, '');
                        if (res == 'ch') {
                            // alert(str+'CHapter');
                            // alert(section+'SEction');
                            thisTocObj.loadHistoryChapter(chapter_no, $(this)
                                    .attr('chapter_no'), section);
                        }
                        if (res == 'chc') {
                            // alert('Commentary');
                            thisTocObj.loadHistoryChapter(chapter_no, $(this)
                                    .attr('chapter_no'), section);
                        }

                        // thisHistoryObj.goToPage($(this).attr('version'),$(this).attr('chapter_no'));
                    }
                    thisTocObj.goToSection(section, chapter_no);
                    /*
                     * Clicking on a specific correction should not close the
                     * drop-down menu. The drop-down menu should stay open until
                     * the user deliberately closes it with the “X�? button in
                     * the corner.
                     */
                    // thisHistoryObj.destroy();
                    /*
                     * else{ thisTocObj.loadChapter($(this).attr('chap_id')); }
                     * thisBookmarkObj.destroy();
                     */
                });
        /*-----------------------End--------------------------------------*/
        // alert($('.h_result_updated').lenght);
        /*----------------------------------History for same edition------------------------*/
        $("body").on(
                'click',
                '.h_result_updated',
                function () {
                    currChapter = thisTocObj.getCurrentChapter();
                    chapter_no = $(this).attr('chapter_no') + '_'
                            + $(this).attr('version');
                    section = $(this).attr('section_no');
                    if ($(this).attr('version') != ""
                            && $(this).attr('chapter_no') !== ''
                            && currChapter != chapter_no) {
                        chapter_no = $(this).attr('chapter_no') + '_'
                                + $(this).attr('version');
                        str = $(this).attr('chapter_no');
                        section = $(this).attr('section_no');
                        res = str.replace(/[^a-z]/gi, '');
                        if (res == 'ch') {
                            // alert('Chapter');
                            thisTocObj.loadHistoryChapter(chapter_no, $(this)
                                    .attr('chapter_no'), section);
                        }
                        if (res == 'chc') {
                            // alert('Commentary');
                            thisTocObj.loadHistoryChapter(chapter_no, $(this)
                                    .attr('chapter_no'), section);
                        }

                        // thisHistoryObj.goToPage($(this).attr('version'),$(this).attr('chapter_no'));
                    }
                    thisTocObj.goToSection(section, chapter_no);
                    // thisHistoryObj.destroy();
                    /*
                     * else{ thisTocObj.loadChapter($(this).attr('chap_id')); }
                     * thisBookmarkObj.destroy();
                     */
                });
        /*--------------------------------End---------------------------------------*/
        /*--------------------------------History for diffrent edition--------------*/
        $("body").on(
                'click',
                '.h_result_updated_diff',
                function () {
                    currChapter = thisTocObj.getCurrentChapter();
                    history_diff_version = $(this).attr('version');
                    chapter_no = $(this).attr('chapter_no');
                    section = $(this).attr('section_no');
                    if ($(this).attr('version') != ""
                            && $(this).attr('chapter_no') !== '') {
                        history_diff_version = $(this).attr('version');
                        chapter_no = $(this).attr('chapter_no');
                        str = $(this).attr('chapter_no');
                        section = $(this).attr('section_no');
                        res = str.replace(/[^a-z]/gi, '');
                        if (res == 'ch') {
                            // alert('Chapter');
                            thisTocObj.loadHistoryChapterDiff(history_diff_version, chapter_no, $(this)
                                    .attr('chapter_no'), section);
                        }
                        if (res == 'chc') {
                            // alert('Commentary');
                            thisTocObj.loadHistoryChapterDiff(history_diff_version, chapter_no, $(this)
                                    .attr('chapter_no'), section);
                        }
                        // thisHistoryObj.goToPage($(this).attr('version'),$(this).attr('chapter_no'));
                    }
                    thisHistoryObj.historyLoadedPage = true;
                    thisTocObj.goToSection(section, chapter_no);

                    // thisHistoryObj.destroy();
                    /*
                     * else{ thisTocObj.loadChapter($(this).attr('chap_id')); }
                     * thisBookmarkObj.destroy();
                     */
                    //var alldelinstagvalue = $("#page_frame").contents().find("[id^='chanes_']");                            });
                    //$.each( alldelinstag, function( indexDom, valueDom ){
                    //var newresponse=newresponse+'<div class="row"><div class="pull-right date"></div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">CH01</div><div class="h_result_updated_diff" style="cursor: pointer; cursor: hand;" version="1" chapter_no="2" section_no="2">' +valueDom+ '</div></div>';  
                    //});
                    //$('#history_popup .panel-data').html(newresponse);
                });
        /*-------------------------------------------End----------------------------*/
        /*------------------------Search On The Basis Of Selection-----------------*/
        $(function () {
            $('input[type="radio"]')
                    .click(
                            function () {
                                selectedDropDownValue = $('.dropdownid').val();
                                //if(selectedDropDownValue=='supplements'){
                                    //document.getElementById("history_rdo_btn_rdt_sup").click();
                                    //alert("Done By Click");
                                //}
                                if ($(this).is(':checked')) {
                                    typeVal = $(this).val();
                                    currentDivId = $(this).attr('id');
                                    //debugger;
                                    /*----------------- Chapter Control--------------------------*/
                                    /*chapControl= $('input[name=history_rdo_btn]');
                                     var checkedValue = chapControl.filter(':checked').val();*/
                                    chapControl = $("input[name='history_rdo_btn']:checked").val()
                                    /*-----------------------End---------------------------------*/
                                    /*-----------------------Version Control---------------------*/
                                    versionControl = $("input[name='history_rdo_btn_rdt']:checked").val();
                                    if (versionControl == "diff_edition")
                                    {
                                        if (chapControl != "all_chapter")
                                            $('#current_chapter').attr('checked', true);
                                        $('#datepicker-history-from').unbind('click');
                                        $('#datepicker-history-to').unbind('click');
                                        $('#page_frame').contents().find(".deletion").show();
                                        $('#page_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                                        $('#page_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                                        $('#page_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                                    
                                    
                                        $('#commentry_frame').contents().find(".deletion").show();
                                        $('#commentry_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                                        $('#commentry_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                                        $('#commentry_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                                  
                                    }
                                    /*----------------------------End-----------------------------*/
                                    var currComm;
                                    /*-------------------------------Getting Current Chapter-------------------------*/
                                    currentChapter = CONFIG.objModule["toc"].controler
                                            .getCurrentChapter();
                                    curChapName = currentChapter.replace(
                                            /[^a-zA-Z]/gi, '');
                                    curChapNo = currentChapter.replace(
                                            /[^0-9]/gi, '');
                                    if (curChapName == 'ch') {
                                        currentCommentary = 'chc' + curChapNo;
                                    }
                                    if (curChapName == 'ap') {
                                        currentCommentary = 'apc' + curChapNo;
                                    }
                                    /*-------------------------------------End---------------------------------------*/
                                    // alert('URL :'+CONFIG.webServicePath);
                                    // alert('Current Chapter
                                    // :'+currentCommentary);
                                    //console.log("Hidden Data");
                                    //debugger;
                                    chapControlValueAgain = $("input[name='history_rdo_btn_rdt']:checked").val();
                                    if(chapControlValueAgain != 'current_edition' && selectedDropDownValue=='supplements'){
                                    var currentrowdivhistory='';
                                    var historyarray = [];
                                    $('#page_frame').contents().find(".section").each(function() {
                                      var refId=$(this).attr("id");
                                      var datestamp=$(this).attr("data-tooltip");
                                      var titlevalue=$(this).attr("title");
                                        if(refId.indexOf("rev")> -1){
                                            //debugger;
                                            //checking parent marked , if exist
                                            var currentIdArray = refId.split(".");
                                            var sizevalue = currentIdArray.length;
                                            //sizevalue = sizevalue-1;
                                            var counterid=0;
                                            var newidvalue = '';
                                            var newidvalue_1=[];
                                            for(counterid=0;counterid<sizevalue;counterid++){
                                                if(counterid==0){
                                                    newidvalue = currentIdArray[counterid];
                                                }    
                                                else{
                                                    newidvalue = newidvalue+"."+currentIdArray[counterid];
                                                }
                                                newidvalue_1[counterid]= newidvalue;
                                            }
                                            newidvalue = newidvalue;
                                            //debugger;
                                            var flagforexistence = 0;
                                            var countivalue =0;
                                            for(flagforexistence=0;flagforexistence<(newidvalue_1.length);flagforexistence++){
                                            //debugger;
                                            /*if((historyarray.indexOf((newidvalue_1[flagforexistence]+"rev"))>-1)){
                                                countivalue = 1;
                                            }*/
                                            
                                            var serchvalue = newidvalue_1[flagforexistence]+"rev";
                                            if(findInArray(historyarray, serchvalue)>-1){
                                                countivalue = 1;
                                            }
                                            
                                            
                                            }
                                            //if((!(historyarray.indexOf(newidvalue)>-1)) && (countivalue==0)){
                                            if((!(historyarray.indexOf(newidvalue)>-1))){

                                                historyarray.push(refId);
                                                var chapterNumberString = $(this).find('a:first').attr("id");
                                                var chapterNumber = chapterNumberString.replace(/[^\d.-]/g,'');
                                                //chapterNumber = "<span class='chapter_numeric_number'>"+chapterNumber+"</span>";
                                                var newvalue = $(this).children().html();
                                                var headingtitle = $(this).find('b:first').html();
                                                newvalue = newvalue.replace("rev","");
                                                if(newvalue.search(chapterNumber) == -1){
                                                    newvalue = chapterNumber+ " " + newvalue+" "+headingtitle;
                                                }
                                                newvalue =  newvalue;//+" "+headingtitle;
                                                var bodytext = $(this).find('p:first').html();
                                                //////////date stamp////
                                                
                                                //if (typeof datestamp !== 'undefined')
                                                if(datestamp !== 'Standard 7-10' &&  titlevalue!=='Errata')
                                                {
                                                  //debugger;
                                                var currentrowdivhis= '<a href="#"><div class="row" onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-right date desc" style="cursor: pointer; cursor: hand; color:red;"> '+datestamp+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                            currentrowdivhistory = currentrowdivhistory+currentrowdivhis;
                                                            var sectionNumber = refId.replace(/[^\d.-]/g, '');
                                                    var currentrowdivhis= '<div onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-right date desc" style="cursor: pointer; cursor: hand; color:red;">'+datestamp+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                            
                                                            var url = $("#page_frame").attr("src");
                                                            var last_part = url.substring(url.lastIndexOf('/'));
                                                            if(last_part.indexOf(".") > -1){
                                                                var ch_name = last_part.split(".");
                                                                var chapter_no = ch_name[0].replace("/","");
                                                            }

                                                            $.ajax({
                                                                    type: "POST",
                                                                    url: CONFIG.webServicePath
                                                                            + "Book_library/SaveVersionIntoDb",
                                                                    data: {
                                                                        chapter_no: chapter_no,
                                                                        section_no: refId,
                                                                        data: currentrowdivhis,
                                                                        history_type: 'supplements'
                                                                    },
                                                                    cache:false,
                                                                    async: false,
                                                                    success: function (text) {
                                                                          console.log(text);
                                                                    }
                                                                }); 
                                                }
                                                
                                               
                                            }
                                            
                                        }
                                    });
                                     //debugger;
                                    }
                                    else if (chapControl !== 'all_chapter' && chapControlValueAgain != 'current_edition' &&  selectedDropDownValue !== 'supplements'){
                                    var currentrowdivhistory='';
                                    var historyarray = [];
                                    $('#page_frame').contents().find(".section").each(function() {
                                      var refId=$(this).attr("id");
                                        //if(refId.indexOf("v")> -1 && (!(refId.indexOf("rev")> -1))){
                                        if(refId.indexOf("rev")> -1){
                                            //checking parent marked , if exist
                                            var currentIdArray = refId.split(".");
                                            var sizevalue = currentIdArray.length;
                                            sizevalue = sizevalue-1;
                                            var counterid=0;
                                            var newidvalue = '';
                                            var newidvalue_1=[];
                                            for(counterid=0;counterid<sizevalue;counterid++){
                                            if(counterid==0){
                                            newidvalue = currentIdArray[counterid];
                                            }    
                                            else{
                                            newidvalue = newidvalue+"."+currentIdArray[counterid];
                                            }
                                            newidvalue_1[counterid]= newidvalue;
                                            }
                                            newidvalue = newidvalue+"v";
                                            //debugger;
                                            var flagforexistence = 0;
                                            var countivalue =0;
                                            for(flagforexistence=0;flagforexistence<(newidvalue_1.length);flagforexistence++){
                                            //debugger;
                                            if((historyarray.indexOf((newidvalue_1[flagforexistence]+"v"))>-1)){
                                            countivalue = 1;
                                            } 
                                            }
                                            if((!(historyarray.indexOf(newidvalue)>-1)) && (countivalue==0)){
                                                historyarray.push(refId);
                                                var chapterNumberString = $(this).find('a:first').attr("id");
                                                var chapterNumber = chapterNumberString.replace(/[^\d.-]/g,'');
                                                console.log(chapterNumber);
                                                //chapterNumber = "<span class='chapter_numeric_number'>"+chapterNumber+"</span>";
                                                var newvalue = $(this).children().html();
                                                var headingtitle = $(this).find('b:first').html();
                                                newvalue = newvalue.replace("rev","");
                                                if(newvalue.search(chapterNumber) == -1){
                                                    newvalue = chapterNumber+ " " + newvalue+" "+headingtitle;
                                                }
                                                newvalue =  newvalue;
                                                var bodytext = $(this).find('p:first').html();
                                                //debugger;
                                                /*var currentrowdivhis= '<a href="#"><div class="row" onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;"> '+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                            currentrowdivhistory = currentrowdivhistory+currentrowdivhis;*/
                                                            
                                                var datestamp=$(this).attr("data-tooltip");
                                                if(datestamp == 'Standard 7-10'){
                                                    var currentrowdivhis= '<a href="#"><div class="row" onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-right date desc" style="cursor: pointer; cursor: hand; color:red;">Standard 7-10</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                    currentrowdivhistory = currentrowdivhistory+currentrowdivhis;  
                                                    var sectionNumber = refId.replace(/[^\d.-]/g, '');
                                                    var currentrowdivhis= '<div onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-right date desc" style="cursor: pointer; cursor: hand; color:red;">Standard 7-10</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                            
                                                            var url = $("#page_frame").attr("src");
                                                            var last_part = url.substring(url.lastIndexOf('/'));
                                                            if(last_part.indexOf(".") > -1){
                                                                var ch_name = last_part.split(".");
                                                                var chapter_no = ch_name[0].replace("/","");
                                                            }

                                                            $.ajax({
                                                                    type: "POST",
                                                                    url: CONFIG.webServicePath
                                                                            + "Book_library/SaveVersionIntoDb",
                                                                    data: {
                                                                        chapter_no: chapter_no,
                                                                        section_no: refId,
                                                                        data: currentrowdivhis,
                                                                        history_type: chapControlValueAgain
                                                                    },
                                                                    cache:false,
                                                                    async: false,
                                                                    success: function (text) {
                                                                          console.log(text);
                                                                    }
                                                                }); 
                                                            
                                                        }
                                            }
                                            
                                        }
                                    });
                                     //debugger;
                                     
                                    //*********************** start for other option***********************************************/ 
                                    }else if (chapControl !== 'all_chapter' && chapControlValueAgain === 'current_edition' &&  selectedDropDownValue !== 'supplements'){
                                        var currentrowdivhistory='';
                                    var historyarray = [];
                                    $('#page_frame').contents().find(".section").each(function() {
                                      var refId=$(this).attr("id");
                                      var datestamp=$(this).attr("data-tooltip");
                                      var titlevalue=$(this).attr("title");
                                      //titlevalue = titlevalue.substring(0, 3);
                                      //titlevalue = titlevalue.toLowerCase();
                                        if(refId.indexOf("rev")> -1){
                                            //checking parent marked , if exist
                                            var currentIdArray = refId.split(".");
                                            var sizevalue = currentIdArray.length;
                                            //sizevalue = sizevalue-1;
                                            var counterid=0;
                                            var newidvalue = '';
                                            var newidvalue_1=[];
                                            for(counterid=0;counterid<sizevalue;counterid++){
                                                if(counterid==0){
                                                    newidvalue = currentIdArray[counterid];
                                                }    
                                                else{
                                                    newidvalue = newidvalue+"."+currentIdArray[counterid];
                                                }
                                                newidvalue_1[counterid]= newidvalue;
                                            }
                                            newidvalue = newidvalue;
                                            var flagforexistence = 0;
                                            var countivalue =0;
                                            for(flagforexistence=0;flagforexistence<(newidvalue_1.length);flagforexistence++){
                                            
                                            var serchvalue = newidvalue_1[flagforexistence]+"rev";
                                            if(findInArray(historyarray, serchvalue)>-1){
                                                countivalue = 1;
                                            }
                                            }
                                            if((!(historyarray.indexOf(newidvalue)>-1))){
                                                historyarray.push(refId);
                                                var chapterNumberString = $(this).find('a:first').attr("id");
                                                var chapterNumber = chapterNumberString.replace(/[^\d.-]/g,'');
                                                //chapterNumber = "<span class='chapter_numeric_number'>"+chapterNumber+"</span>";
                                                var newvalue = $(this).children().html();
                                                var headingtitle = $(this).find('b:first').html();
                                                newvalue = newvalue.replace("rev","");

                                                if(newvalue.search(chapterNumber) == -1){
                                                    newvalue = chapterNumber+ " " + newvalue+" "+headingtitle;
                                                }
                                                newvalue =  newvalue;//+" "+headingtitle;
                                                var bodytext = $(this).find('p:first').html();
                                                //if (typeof datestamp !== 'undefined')
                                                if(datestamp !== 'Standard 7-10' &&  titlevalue==='Errata')
                                                {
                                                  //debugger;
                                                var currentrowdivhis= '<a href="#"><div class="row" onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-right date desc" style="cursor: pointer; cursor: hand; color:red;"> '+datestamp+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;"> '+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                currentrowdivhistory = currentrowdivhistory+currentrowdivhis;

                                                var sectionNumber = refId.replace(/[^\d.-]/g, '');
                                                    var currentrowdivhis= '<div onclick="gotoPageNewHistory(this)" style="cursor: pointer; cursor: hand";><div class="pull-right date desc" style="cursor: pointer; cursor: hand; color:red;">'+datestamp+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+newvalue+'</div></a><div class="h_result" style="cursor: pointer; cursor: hand; color:black;" id="chanes_dynamicvalue" chapter_no="ch03" section_no="'+refId+'"><font>'+bodytext+' </font></div></div>';
                                                            
                                                            var url = $("#page_frame").attr("src");
                                                            var last_part = url.substring(url.lastIndexOf('/'));
                                                            if(last_part.indexOf(".") > -1){
                                                                var ch_name = last_part.split(".");
                                                                var chapter_no = ch_name[0].replace("/","");
                                                            }

                                                            $.ajax({
                                                                    type: "POST",
                                                                    url: CONFIG.webServicePath
                                                                            + "Book_library/SaveVersionIntoDb",
                                                                    data: {
                                                                        chapter_no: chapter_no,
                                                                        section_no: refId,
                                                                        data: currentrowdivhis,
                                                                        history_type: chapControlValueAgain
                                                                    },
                                                                    cache:false,
                                                                    async: false,
                                                                    success: function (text) {
                                                                          console.log(text);
                                                                    }
                                                                });

                                                }
                                            }
                                        }
                                    });
                                    }
                                    
                                    var response = '';
                                    //debugger;
                                    $.ajax({
                                        type: "POST",
                                        url: CONFIG.webServicePath
                                                + "Book_library/GetCustomisedData",
                                        data: {
                                            searchType: typeVal,
                                            chapControl: chapControl,
                                            versionControl: versionControl,
                                            currentChap: currentChapter,
                                            currComm: currentCommentary
                                        },
                                        cache:false,
                                        async: false,
                                        beforeSend: function () {
                                            //alert("Hello");
                                            $('#history_popup .panel-data').html("<img src='https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif'/>");


                                        },
                                        success: function (text) {
                                            //debugger;
                                            if (text == 'logouut') {
                                                location.href = CONFIG.webServicePath;
                                            }
                                            response = text;
                                             $('#history_popup .panel-data').empty()
                                             //debugger;
                                             //for radion button for current edition checkeing
                                            /*if(versionControl=='current_edition'){
                                               
                                                checked_status = $("#leave_corrections").is(':checked') ? 1
                                                : 0;
                                                currentChapter = CONFIG.objModule["toc"].controler
                                                .getCurrentChapter();
                                                load_chapter = currentChapter.substring(0, currentChapter
                                                .indexOf('_'));
                                                load_chapter = load_chapter != '' ? load_chapter
                                                : currentChapter;
                                                if (checked_status != '1' && thisHistoryObj.historyLoadedPage == true) {
                                                thisTocObj.loadOriginalChapter(load_chapter);
                                                } else if (checked_status != '1') {
                                                thisTocObj.loadChapter(load_chapter);
                                                }
                                               
                                                $('#commentry_frame').contents().find(".deletion").show();
                        //            $('#commentry_frame').contents().find(".insertion").css('color', 'green');
                                                $('#commentry_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                                                $('#commentry_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                                                $('#commentry_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});

                                                $('#page_frame').contents().find(".deletion").show();
                                                $('#page_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                                                $('#page_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                                                $('#page_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                                                
                                                var alldeletedvalues = $('#page_frame').contents().find(".deletion");
                                                var allinsertedvalues = $('#page_frame').contents().find(".insertion");
                                                
                                                var alldeletedvalues1 = $('#commentry_frame').contents().find(".deletion");
                                                var allinsertedvalues1 = $('#commentry_frame').contents().find(".insertion");

                                                var allhtmlforlink = "";
                                                var idvalue=2000;

                                                $.each(allinsertedvalues, function( index, value ) {
                                                    
                                                $('#history_popup .panel-data').html("");
                                                var currentdatevalue = value.getAttribute('data-tooltip');
                                                
                                                if(currentdatevalue!==null && versionControl !== "diff_edition"){
                                                    //debugger
                                                    
                                                    value.setAttribute("id", "chanes_"+idvalue);
                                                    if($(value.innerHTML).is("img")){
                                                        valueofTitle = $(value.innerHTML).attr("alt")
                                                        var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+valueofTitle+' </font></div></div>';
                                                    }else{
                                                        var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+value.innerHTML+' </font></div></div>';
                                                    }
                                                    
                                                    
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv;
                                                    idvalue++;
                                                }
                                                if(currentdatevalue===null && versionControl === "diff_edition"){
                                                    //debugger;
                                                    value.setAttribute("id", "chanes_"+idvalue);
                                                    if($(value.innerHTML).is("img")){
                                                        valueofTitle = $(value.innerHTML).attr("alt")
                                                        var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline;">'+valueofTitle+' </font></div></div>';
                                                    }
                                                    else{
                                                        var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline;">'+value.innerHTML+' </font></div></div>';
                                                    }
                                                    allhtmlforlink = allhtmlforlink+currentrowdiv;
                                                    idvalue++;
                                                }
                                                });
                                                $.each(alldeletedvalues, function( index, value1 ) {
                                                var currentdatevalue = value1.getAttribute('data-tooltip');
                                                value1.setAttribute("id", "chanes_"+idvalue);
                                                if(currentdatevalue!==null && versionControl !== "diff_edition"){
                                                    //debugger
                                                    if($(value1.innerHTML).is("img")){
                                                        valueofTitle = $(value1.innerHTML).attr("alt")
                                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+valueofTitle+'</strike></div></div>';
                                                    }else{
                                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                    }
                                                    allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                                    idvalue++;
                                                }
                                                if(currentdatevalue===null && versionControl === "diff_edition"){
                                                    //debugger;
                                                    if($(value1.innerHTML).is("img")){
                                                        valueofTitle = $(value1.innerHTML).attr("alt")
                                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+valueofTitle+'</strike></div></div>';
                                                    }else{
                                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                    }        
                                                    allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                                    idvalue++;
                                                }
                                                });
                                                $('#history_popup .panel-data').append(allhtmlforlink);
                                                
                                                
                                                $('#page_frame').contents().find(".deletion").show();
                                                $('#page_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                                                $('#page_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                                                $('#page_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                                                
                                                $('#commentry_frame').contents().find(".deletion").show();
                                                $('#commentry_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                                                $('#commentry_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                                                $('#commentry_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                                                
                                                //checking for content
                                                var htmlContent = $('.panel-data').html();
                                                if(htmlContent==''){
                                                $('.panel-data').html("No Results"); 
                                                }
                                                
                                            }else{*/
                                             
                                            if (chapControl == 'current_chapter') {
                                                //debugger
                                                $('#history_popup .panel-data').append(currentrowdivhistory);
                                                $('#page_frame').contents().find(".deletion").show();
                                                //$('#page_frame').contents().find(".insertion").css('color','green');
                                                //$('#history_popup .panel-data').html("My All History");
                                            }
                                            else if(chapControl === 'all_chapter' ){
                                               
                                               var versionVal = $('#dropdownid').val();
                                               $('#history_popup .panel-data').html('<div class="row"><div class="pull-right date">All Chapters</div>');
                                               
                                               
                                                $.ajax({
                                                    type: "POST",
                                                    url: CONFIG.webServicePath
                                                            + "Book_library/GetAllData",
                                                    data: {'type':versionVal},
                                                    async: false,
                                                    success: function (text) {
                                                        response = text;
                                                        $('#history_popup .panel-data')
                                                                .empty();
                                                        if (response.trim() == '') {
                                                            $('#history_popup .panel-data')
                                                                    .html(
                                                                            '<div class="row"><div class="pull-right date">No Record Found For This Book</div>');
                                                        } else {
                                                            $('#history_popup .panel-data')
                                                                    .html(response);
                                                        }
                                                        //checking for content
                                                        var htmlContent = $('.panel-data').html();
                                                        if (htmlContent == '') {
                                                            $('.panel-data').html("No Results");
                                                        }
                                                    }
                                                });

                                               
                                               
                                            }
                                            else{
                                                $('#history_popup .panel-data').empty();
                                                if (response.trim() == '') {
                                                        $('#history_popup .panel-data').html('<div class="row"><div class="pull-right date">No Record Found For This Book</div>');
                                                } else {
                                                        $('#history_popup .panel-data').html(response);
                                                }
                                            }
                                            //checking for content
                                            var htmlContent = $('.panel-data').html();
                                            if(htmlContent==''){
                                            $('.panel-data').html("No Results"); 
                                            }
                                            
                                        //}//else for current edition    
                                        }
                                    });


                                    //$('#history_popup .panel-data').html('<div class="row"><div class="pull-right date">No Record Found For This Book</div>');             
                                    $(".h_result_updated_diff").first().trigger("click");

                                }
                            });
        });
        $('#clear_form')
                .click(
                        function () {
                            $('#from_date').val('');
                            $('#to_date').val('');
                            $('#current_chapter').attr('checked', false);
                            var response = '';
                            $
                                    .ajax({
                                        type: "POST",
                                        url: CONFIG.webServicePath
                                                + "Book_library/GetAllData",
                                        data: {},
                                        async: false,
                                        success: function (text) {
                                            response = text;
                                            $('#history_popup .panel-data')
                                                    .empty();
                                            if (response.trim() == '') {
                                                $('#history_popup .panel-data')
                                                        .html(
                                                                '<div class="row"><div class="pull-right date">No Record Found For This Book</div>');
                                            } else {
                                                $('#history_popup .panel-data')
                                                        .html(response);
                                            }
                                            //checking for content
                                            var htmlContent = $('.panel-data').html();
                                            if(htmlContent==''){
                                            $('.panel-data').html("No Results"); 
                                            } 
                                        }
                                    });
                        });
        /*-----------------------------End-----------------------------------------*/
        /*----------------------------- Showing readline on click history------------*/
        
        /*----------------------------- start for checkbox value -------------------------- */
        $('#leave_corrections').change(
        function () {
            if(this.checked) {
                leavcorrectionflage = true;
                
        $('#commentry_frame').contents().find(".deletion").show();
        $('#commentry_frame').contents().find(".insertion").css('color', 'green');
        
        $('#page_frame').contents().find(".deletion").show();
        $('#page_frame').contents().find(".insertion").css('color', 'green');
            }else {
                leavcorrectionflage = false;
                
        $('#commentry_frame').contents().find(".deletion").hide();
        $('#commentry_frame').contents().find(".insertion").css('color', 'black');
        
        $('#page_frame').contents().find(".deletion").hide();
        $('#page_frame').contents().find(".insertion").css('color', 'black');
            }
        });
        /*----------------------------- end for checkbox value -------------------------- */
        
        
        
        
        
        
        $('.history_panel')
                .click(
                        function () {
                            //debugger;
                            loadedChapter = CONFIG.objModule["toc"].controler
                                    .getCurrentChapter();

                            loadedChapter_chc = CONFIG.objModule["toc"].controler       
                                    .getCurrentCommentary();
                            $('#commentry_frame').contents().find(".deletion").show();
                            //$('#commentry_frame').contents().find(".insertion").css('color', 'green');
                            $('#commentry_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                            $('#commentry_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                            $('#commentry_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                        
                            
                            $('#page_frame').contents().find(".deletion").show();
                            $('#page_frame').contents().find(".insertion").css({'color':'green','text-decoration':'underline'});
                            $('#page_frame').contents().find(".insertion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'green'});
                            $('#page_frame').contents().find(".deletion img").css({'border':'1px solid #808080','margin-left':'2%','border-color':'red'});
                            var alldeletedvalues = $('#page_frame').contents().find(".deletion");
                            var allinsertedvalues = $('#page_frame').contents().find(".insertion");
                            
                            var alldeletedvalues1 = $('#commentry_frame').contents().find(".deletion");
                            var allinsertedvalues1 = $('#commentry_frame').contents().find(".insertion");
                            
                            var allhtmlforlink = "";                     
                            var idvalue=2000;
                            //debugger;
                            //alert("History Started");
                            $.each(allinsertedvalues, function( index, value ) {
                                //debugger;
                                $('#history_popup .panel-data').html("");
                                //debugger;
                                var currentdatevalue = value.getAttribute('data-tooltip');
                                if(currentdatevalue!==null){
                                    value.setAttribute("id", "chanes_"+idvalue);
                                    try {
                                        
                                        if($(value.innerHTML).is("img")){
                                            valueofTitle = $(value.innerHTML).attr("alt");
                                            var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+valueofTitle+' </font></div></div>';
                                        }else{
                                            var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+value.innerHTML+' </font></div></div>';
                                        }
                                    }catch(err) {
                                        var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+value.innerHTML+' </font></div></div>';
                                    }
                                    allhtmlforlink = allhtmlforlink+currentrowdiv;
                                    idvalue++;
                                }
                            });
                          
                             $.each(allinsertedvalues1, function( index, value ) {
                                 //debugger;
                                $('#history_popup .panel-data').html("");
                                //debugger;
                                var currentdatevalue_chc = value.getAttribute('data-tooltip');
                                if(currentdatevalue_chc!==null){
                                    value.setAttribute("id", "chanes_"+idvalue);
                                   // debugger;
                                   try {
                                       
                                    if($(value.innerHTML).is("img")){
                                        //debugger;
                                        valueofTitle = $(value.innerHTML).attr("alt");
                                        var currentrowdiv = '<div class="row" onclick="gotoCommPageNew(this)"><div class="pull-right date">'+currentdatevalue_chc+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter_chc.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+valueofTitle+' </font></div></div>';
                                    }else{
                                        var currentrowdiv = '<div class="row" onclick="gotoCommPageNew(this)"><div class="pull-right date">'+currentdatevalue_chc+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter_chc.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+value.innerHTML+' </font></div></div>';
                                    } 
                                    }catch(err) {
                                        var currentrowdiv = '<div class="row" onclick="gotoCommPageNew(this)"><div class="pull-right date">'+currentdatevalue_chc+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter_chc.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green;text-decoration:underline">'+value.innerHTML+' </font></div></div>';
                                    }
                                    allhtmlforlink = allhtmlforlink+currentrowdiv;
                                    idvalue++;
                                }
                            });
                            
                             $.each(alldeletedvalues1, function( index, value ) {  
                                var currentdatevalue_chc = value.getAttribute('data-tooltip');
                                if(currentdatevalue_chc!==null){
                                    value.setAttribute("id", "chanes_"+idvalue);
                                       
                                        var currentrowdiv1 = '<div class="row" onclick="gotoCommPageNew(this)"><div class="pull-right date">'+currentdatevalue_chc+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter_chc.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="chc03" section_no="c3.2.2"><strike style="color:red">'+value.innerHTML+'</strike></div></div>';
                                       
                                    
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                    idvalue++;
                                }
                            });
                            
                   
                            
                            $.each(alldeletedvalues, function( index, value1 ) {
                                var currentdatevalue = value1.getAttribute('data-tooltip');
                                if(currentdatevalue!==null){
                                    value1.setAttribute("id", "chanes_"+idvalue);
//                                    //debugger
                                try {
                                    
                                    if($(value1.innerHTML).is("img")){
                                        valueofTitle = $(value1.innerHTML).attr("alt");
                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+valueofTitle+'</strike></div></div>';
                                    }else{
                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                    }
                                }catch(err) {
                                        var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                    }    
                                    
                                    allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                    idvalue++;
                                }
                            });
                            $('#history_popup .panel-data').append(allhtmlforlink);
                            
                            //checking for content
                            //debugger;
                            var htmlContent = $('.panel-data').html();
                            if(htmlContent==''){
                            $('.panel-data').html("No Results"); 
                            }
                            
                            var response = '';
                            /*$.ajax({    type: "POST",
                                url: CONFIG.webServicePath
                                        + "Book_library/GetLastHistoryChapter",
                                data: {
                                    loadedChapter: loadedChapter
                                },
                                async: false,
                                success: function (text) {
                                    chapter_no = text;
                                    if (chapter_no != '') {
                                        currLoadedChapter = CONFIG.objModule["toc"].controler
                                                .getCurrentChapter();
                                        section = '';
                                        thisTocObj.loadHistoryChapter(
                                                chapter_no,
                                                currLoadedChapter,
                                                section);
                                    }
                                }
                            });*/
                            
                                //debugger;
                                if($('#current_chapter').prop("checked") == true){
                                     $( "#current_chapter" ).click();
                                }
                        });
        /*----------------------------------------For Scrolling data on load------------------------*/
        /*---------------------------------------------------End------------------------------------*/
        /*---------------------------------------End----------------------------------*/
    }
    //specif for delete change
        $( ".history_panel" ).live( "click", function() {
            var containDivCss = $('#history_popup').attr('style');
            if((containDivCss.indexOf("display: none")>0)){
                  //  debugger;
                
                    
        $('#commentry_frame').contents().find(".deletion").show();
        $('#commentry_frame').contents().find(".insertion").css('color', 'green');
        
        $('#page_frame').contents().find(".deletion").show();
        $('#page_frame').contents().find(".insertion").css('color', 'green');
               
                    if(leavcorrectionflage==false){
                        $('#page_frame').contents().find(".deletion").hide();
                        $('#page_frame').contents().find(".insertion").css({'color':'black','text-decoration':'none'});
                        $('#page_frame').contents().find(".insertion img").css({'border':'0px','border-color':'black'});
                        $('#page_frame').contents().find(".deletion img").css({'border':'0px','border-color':'black'});
                        
                        $('#commentry_frame').contents().find(".deletion").hide();
                        $('#commentry_frame').contents().find(".insertion").css({'color':'black','text-decoration':'none'});
                        $('#commentry_frame').contents().find(".insertion img").css({'border':'0px','border-color':'black'});
                        $('#commentry_frame').contents().find(".deletion img").css({'border':'0px','border-color':'black'});
                        thisHistoryObj.cancel();
                        $('#history_popup').hide();
                    } 
            }
        });
        
        
        
}
function jump(h){
    var top = document.getElementById(h).offsetTop;
    window.scrollTo(0, top);
}
function findInArray(ar, val) {
    for (var i = 0,len = ar.length; i < len; i++) {
        if ( ar[i] === val ) { // strict equality test
            return i;
        }
    }
    return -1;
}

