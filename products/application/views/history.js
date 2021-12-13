// JavaScript Document
var divname = document.createElement("div");
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
        $('#history_popup').addClass("show");
    }

    this.hideForm = function () {
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
        if (!(this.historyContents.length)) {
            $('#history_popup .panel-data').append(
                    thisHistoryObj.generateMessage());
        } else {
            $.each(this.historyContents, function (key, value) {
                $('#history_popup .panel-data').append(
                        thisHistoryObj.generateHistoryList(value));
            });
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

        $('#history_popup .close_btn').unbind("click");
        $('#history_popup .close_btn').click(
                function () {
                    $('input:radio[name="history_rdo_btn_rdt"][value="current_edition"]').attr('checked', true);
                    $('#page_frame').contents().find(".deletion").hide();
                    $('#page_frame').contents().find(".insertion").css('color','black');
                    /*------------ For Corrections Leave or Not------------------*/
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
                    /*--------------------------End------------------------------*/
                    thisHistoryObj.cancel();
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
                     * the user deliberately closes it with the “X” button in
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
                    //var alldelinstagvalue = $("#page_frame").contents().find("[id^='chanes_']");							});
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
                                if ($(this).is(':checked')) {
                                    typeVal = $(this).val();
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
                                        $('#page_frame').contents().find(".insertion").css('color','green');

                                        
                                        
                                        
                                        
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
                                    
                                    chapControlValueAgain = $("input[name='history_rdo_btn_rdt']:checked").val();
                                    
                                    /*if(chapControlValueAgain != 'current_edition'){
                                    $('#page_frame').contents().find(".section").each(function() {
                                        //debugger
                                      var refId=$(this).attr("id");
                                        if(refId.indexOf("v")> -1){
                                            $(this).show();
                                            var newvalue = $(this).children().html();
                                            newvalue = newvalue.replace("v","");
                                            //$(this).children().html(newvalue)
                                            $(this).find('a:first').html( newvalue );

                                        }
                                        else{
                                            refId=refId+"v";
                                            for(i=0; i< historyarray.length; i++ ){
                                                if(refId==historyarray[i]){
                                                 $(this).hide();
                                                }
                                            }
                                        }
                                    });
                                    }*/
                                    /*else{
                                        //debugger;
                                       $('#page_frame').contents().find(".section").each(function() {
                                                var idvalue = $(this).attr('id');
                                                var lenghofstring = idvalue.length;
                                                var res = idvalue.charAt((lenghofstring-1))
                                                $(this).show();
                                                if(res=="v"){
                                                //debugger;
                                                historyarray.push(idvalue);
                                                $(this).hide();
                                                }
                                            });
                                    }*/
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
                                            if(versionControl=='current_edition'){
                                               
                                               
                                               
                                           
                                                /*------------ For Corrections Leave or Not------------------*/
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
                                                /*--------------------------End------------------------------*/
                                               
                                               
                                               
                                               
                                               
                                               
                                                $('#page_frame').contents().find(".deletion").show();
                                                $('#page_frame').contents().find(".insertion").css('color','green');
                                                
                                                var alldeletedvalues = $('#page_frame').contents().find(".deletion");
                                                var allinsertedvalues = $('#page_frame').contents().find(".insertion");

                                                var allhtmlforlink = "";
                                                var idvalue=2000;

                                                $.each(allinsertedvalues, function( index, value ) {
                                                    
                                                $('#history_popup .panel-data').html("");
                                                var currentdatevalue = value.getAttribute('data-tooltip');
                                                
                                                if(currentdatevalue!==null && versionControl !== "diff_edition"){
                                                    //debugger
                                                    value.setAttribute("id", "chanes_"+idvalue);
                                                    var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green">'+value.innerHTML+' </font></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv;
                                                    idvalue++;
                                                }
                                                if(currentdatevalue===null && versionControl === "diff_edition"){
                                                    //debugger;
                                                    value.setAttribute("id", "chanes_"+idvalue);
                                                    var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green">'+value.innerHTML+' </font></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv;
                                                    idvalue++;
                                                }
                                                });
                                                $.each(alldeletedvalues, function( index, value1 ) {
                                                var currentdatevalue = value1.getAttribute('data-tooltip');
                                                value1.setAttribute("id", "chanes_"+idvalue);
                                                if(currentdatevalue!==null && versionControl !== "diff_edition"){
                                                    //debugger
                                                    var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                                    idvalue++;
                                                }
                                                if(currentdatevalue===null && versionControl === "diff_edition"){
                                                    //debugger;
                                                    var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                                    idvalue++;
                                                }
                                                });
                                                $('#history_popup .panel-data').append(allhtmlforlink);
                                                
                                                
                                                $('#page_frame').contents().find(".deletion").show();
                                                $('#page_frame').contents().find(".insertion").css('color','green');
                                                
                                                
                                            }else{
                                             
                                            if (chapControl == 'all_chapter' || chapControl == 'current_chapter') {
                                                
                                                
                                                
                                                
                                                //$('#container').find('section').find('section article:first-child').find('header:first-child').find('span:first-child').html("PROVISIONS");
                                                //debugger
//                                                var allfilechangesdatainjson = jQuery.parseJSON(text);
//                                                divname.setAttribute("id", "chapertHistoryAll");
//                                                $.each(allfilechangesdatainjson, function (key, value) {
//                                                    var asce = document.createElement("acse-element");
//                                                    asce.setAttribute("style","display:none");
//                                                    $(document).append(asce);
//                                                    asce.setAttribute("data-set", key);
//                                                    asce.innerHTML = value;
//                                                    divname.append(asce);
//                                                });
//                                                
//                                                
//                                                setTimeout(function(){ 
//                                                var ditectChanges=[];
//                                                $(divname).contents().each(function(){
//                                                        var alldelinstag=$(this).contents().find("[id^='chanes_']");
//                                                        var data=[$(this).attr("data-set"),alldelinstag];
//                                                        ditectChanges.push(data);
//                                                });
//                                                    
//                                                //all string show
//                                                var allstringforhistory = '';
//                                                var arrayLength = ditectChanges.length;
//                                                var allhtmlforlink = "";
//                                                for (var i = 0; i < arrayLength; i++) {
//                                                    //console.log("chapt"+ditectChanges[i][0]);
//                                                    //debugger;
//                                                    var chapter=ditectChanges[i][0].split(".");
//                                                    
//                                                    ditectChanges[i][1].each(function(){
//                                                        
//                                                        var currentrowdiv = '<div class="row" onclick="gotoPageHistory(this)" ><div class="data">'+chapter[0].toUpperCase()+'</div><div style="cursor:pointer">'+$(this)[0].outerHTML+'</div></div>';
//                                                        allhtmlforlink = allhtmlforlink+currentrowdiv;
//                                                    });
//                                                    
//                                                }
//                                                
//                                                    $('#history_popup .panel-data').html(allhtmlforlink);
//                                                }, 1000);
//                                                
                                                $('#page_frame').contents().find(".deletion").show();
                                                $('#page_frame').contents().find(".insertion").css('color','green');

                                                var alldeletedvalues = $('#page_frame').contents().find(".deletion");
                                                var allinsertedvalues = $('#page_frame').contents().find(".insertion");

                                                var allhtmlforlink = "";
                                                var idvalue=2000;

                                                $.each(allinsertedvalues, function( index, value ) {
                                                var parentdiv = $(value).parent().parent();
                                                var sectionidvalue = $(parentdiv).attr('id');
                                                $('#history_popup .panel-data').html("");
                                                var currentdatevalue = value.getAttribute('data-tooltip');
                                                
                                                if(currentdatevalue!==null && versionControl !== "diff_edition"){
                                                    value.setAttribute("id", "chanes_"+idvalue);
                                                    var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green">'+value.innerHTML+' </font></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv;
                                                    idvalue++;
                                                }
                                                if(currentdatevalue===null && versionControl === "diff_edition"){
                                                    //debugger;
                                                    
                                                    value.setAttribute("id", "chanes_"+idvalue);
                                                    var currentrowdiv = '<div class="row" onclick="gotoPageNewHistory(this)"><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="'+sectionidvalue+'"><font style="color:green">'+value.innerHTML+' </font></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv;
                                                    idvalue++;
                                                }
                                                });
                                                $.each(alldeletedvalues, function( index, value1 ) {
                                                var parentdiv1 = $(value1).parent().parent();
                                                var sectionidvalue1 = $(parentdiv1).attr('id');
                                                var currentdatevalue = value1.getAttribute('data-tooltip');
                                                value1.setAttribute("id", "chanes_"+idvalue);
                                                if(currentdatevalue!==null && versionControl !== "diff_edition"){
                                                    var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no=""'+sectionidvalue1+'""><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                                    idvalue++;
                                                }
                                                if(currentdatevalue===null && versionControl === "diff_edition"){
                                                    //debugger;
                                                   
                                                    
                                                    var currentrowdiv1 = '<div class="row" onclick="gotoPageNewHistory(this)"><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="'+sectionidvalue1+'"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                                    idvalue++;
                                                }
                                                });
                                                $('#history_popup .panel-data').append(allhtmlforlink);
                                                
                                                
                                                $('#page_frame').contents().find(".deletion").show();
                                                $('#page_frame').contents().find(".insertion").css('color','green');
                                                
                                                
                                                //$('#history_popup .panel-data').html("My All History");
                                            }else{
                                             
                                                $('#history_popup .panel-data').empty();
                                                if (response.trim() == '') {
                                                        $('#history_popup .panel-data').html('<div class="row"><div class="pull-right date">No Record Found For This Book</div>');
                                                } else {
                                                        $('#history_popup .panel-data').html(response);
                                                }
                                            }
                                        }//else for current edition    
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
                                        }
                                    });
                        });
        /*-----------------------------End-----------------------------------------*/
        /*----------------------------- Showing readline on click history------------*/
        $('.history_panel')
                .click(
                        function () {
                            
                            loadedChapter = CONFIG.objModule["toc"].controler
                                    .getCurrentChapter();
                            $('#page_frame').contents().find(".deletion").show();
                            $('#page_frame').contents().find(".insertion").css('color','green');
                            
                            var alldeletedvalues = $('#page_frame').contents().find(".deletion");
                            var allinsertedvalues = $('#page_frame').contents().find(".insertion");
                            
                            var allhtmlforlink = "";
                            var idvalue=2000;
                            
                            $.each(allinsertedvalues, function( index, value ) {
                                $('#history_popup .panel-data').html("");
                                //debugger;
                                var currentdatevalue = value.getAttribute('data-tooltip');
                                if(currentdatevalue!==null){
                                    value.setAttribute("id", "chanes_"+idvalue);
                                    var currentrowdiv = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><font style="color:green">'+value.innerHTML+' </font></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv;
                                    idvalue++;
                                }
                            });
                            $.each(alldeletedvalues, function( index, value1 ) {
                                var currentdatevalue = value1.getAttribute('data-tooltip');
                                if(currentdatevalue!==null){
                                    value1.setAttribute("id", "chanes_"+idvalue);
                                    //debugger
                                    var currentrowdiv1 = '<div class="row" onclick="gotoPageNew(this)"><div class="pull-right date">'+currentdatevalue+'</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'+loadedChapter.toUpperCase()+' </div><div class="h_result" style="cursor: pointer; cursor: hand;" id="chanes_'+idvalue+'" chapter_no="ch03" section_no="s3.2.2"><strike style="color:red">'+value1.innerHTML+'</strike></div></div>';
                                                            allhtmlforlink = allhtmlforlink+currentrowdiv1;
                                    idvalue++;
                                }
                            });
                            $('#history_popup .panel-data').append(allhtmlforlink);
                            
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
                        });
        /*----------------------------------------For Scrolling data on load------------------------*/
        /*---------------------------------------------------End------------------------------------*/
        /*---------------------------------------End----------------------------------*/
    }

}
function jump(h){
    var top = document.getElementById(h).offsetTop;
    window.scrollTo(0, top);
}
