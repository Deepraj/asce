//Copyright@ MPS Ltd 2015
/**
 * module management
 * 
 * @author satheesh
 * @author Arulkumar Updated Date:17-08-15
 */
var historyarray = [];
var linkfortable = [];
var linkforfigure = [];
var dispformula = [];
var figpanel = [];
var printContent    =   '';
var PrintImage  =   '';

var figpanelC   =  [];
var dispformulaC = [];
var linkforfigureC = [];
var arrayofintext = [];
function controlerToc() {

    thisTocObj = this;
    var bookName = '';
    // thisHistoryObj=this;
    this.moduleName = "toc";
    this.viewSrc = objModule.getView(this.moduleName);
    this.arrChapters = new Array();
    this.arrContents = new Array();
    this.arrSection = new Array();
    this.arrNavigation = new Array();
    this.arrRawSection = new Array();
    this.arrNavigationList = new Array();
    this.arrNavigationListLink = new Array();
    this.commentryFilePrefix = {
        'CONTENT': {
            'commentry': "chc",
            'page': 'ch'
        },
        'APPENDIX': {
            'commentry': "apc",
            'page': 'ap'
        },
        'FRONT_MATTER': {
            'commentry': "cfm",
            'page': 'fm'
        }
    };

    this.fileExt = ".html";
    this.lastChapter = 0;
    this.lastCommentary = 0;
    this.lastPanelType = '';
    this.lastSec = 0;
    this.bufferChapter = 0;
    this.chapterPath = "";
    this.commentaryPath = "";
    this.historyPagePath = CONFIG.bookHistoryPath;
    this.init = function () {
        this.setChapterPath();
        this.setCommentaryPath();
        this.loadView();

        // CONFIG.objModule[this.moduleName].model
    }

    $(document).ready(function () {
        $('#commentry_frame').bind('mouseover', function () {
            var iframeID = $(this).attr('id');
            $(this).contents().unbind();
            $(this).contents().bind('click', function () {
                currentFrame = 'commentry'
            });
        });
    });
    $(document).ready(function () {
        $('#page_frame').bind('mouseover', function () {
            var iframeID = $(this).attr('id');
            $(this).contents().unbind();
            $(this).contents().bind('click', function () {
                currentFrame = 'pagevalue'
            });
        });
       
    });

    this.destroy = function () {
        this.chapterPath = ""
        this.commentaryPath = ""
    }

    this.loadView = function () {
        thisTocObj.start();
        // thisHistoryObj.start();
        /*
         * $('#toc').load(CONFIG.viewPath+this.viewSrc,function(){ });
         */
    }
    this.setChapterPath = function () {
        this.chapterPath = CONFIG.bookPath + "/"
                + CONFIG.objModule['commonInfo'].controler.getISBN() + "/"
                + CONFIG.prefix_volume
                + CONFIG.objModule['commonInfo'].controler.getVolumeNo() + "/"
                + CONFIG.pagePath + "/";
    }

    this.setCommentaryPath = function () {
        this.commentaryPath = CONFIG.bookPath + "/"
                + CONFIG.objModule['commonInfo'].controler.getISBN() + "/"
                + CONFIG.prefix_volume
                + CONFIG.objModule['commonInfo'].controler.getVolumeNo() + "/"
                + CONFIG.commentryPath + "/";
    }

    this.start = function () {
        this.manageCustomScroll();
        this.getChapters();
        this.generateNavigationList();
    }

    this.getChapters = function () {
        if (!arguments.length) {
            CONFIG.objModule[this.moduleName].model.getChapterList();
            //console.log(arguments);
        } else if (arguments[0]['ChapterDetails'].length) {
            /*
             * console.log('Get Chapters Start');
             * console.log(arguments[0]['ChapterDetails']);
             * console.log('End....');
             */
            thisTocObj.arrChapters = arguments[0]['ChapterDetails'];
            thisTocObj.historyContents = arguments[0]['historyContents'];
            thisTocObj.arrSection = arguments[0]['SectionDetails'];
            thisTocObj.arrRawSection = arguments[0]['RawSection'];
            thisTocObj.populateToc();
            CONFIG.objModule['commonInfo'].controler.getReady();
            thisTocObj.getFirstLevelSection();
            thisTocObj.loadChapter(thisTocObj.arrChapters[0].chapSrc);
            thisTocObj.bookName = arguments[0]['ChapterDetails'][0].m_boktitle;
            // alert(thisTocObj.bookName);
            $("#currentBookTitle").html(thisTocObj.bookName);
            // alert(thisTocObj.bookName);
        } else {
            bootbox.alert(localizedStrings.TOC.error.alertmsg.noChapter,
                    function () {
                        CONFIG.objModule.myaccount.model.doLogout();
                    });
        }
    }
    /*-----------------------For Getting List Of Contents-----------*/
    /*
     * this.getHistoryContents = function(){ if(!arguments.length){
     * CONFIG.objModule[this.moduleName].model.getHistoryContentList();
     * console.log('Start Get Chapters'); console.log(arguments[0]);
     * console.log('End Get Chapters'); } else if(
     * arguments['historyContents'].length ){ alert('Under Contents');
     * thisHistoryObj.arrContents = arguments[0]['historyContents'];
     * CONFIG.objModule['commonInfo'].controler.getReady(); }else{
     * bootbox.alert(localizedStrings.TOC.error.alertmsg.noChapter, function(){
     * CONFIG.objModule.myaccount.model.doLogout(); }); } }
     */
    this.getContentList = function () {
        return this.historyContents;
    }
    /*--------------------------------End---------------------------*/
    this.getChaptersList = function () {
        return this.arrChapters;
    }
    this.getFirstLevelSection = function () {
        return this.arrSection[0];
    }

    this.generateNavigationList = function () {
        CONFIG.objModule[this.moduleName].model.getNavigationList()
    }

    this.getCurrentChapter = function () {
        return this.lastChapter;
    }
    this.getCurrentCommentary = function () {
       // return this.getCurrentCommentary;
       return this.lastCommentary
    }
    this.populateToc = function () {
        this.clearForm();
        // build chapter
        chapterUl = $("<ul/>").addClass('main_toc');
        $.each(this.arrChapters, function (key, value) {
            if (value.chappaneltype == "PAGES") {
                $(chapterUl).append(
                        thisTocObj.getChpaterStructure(value, "chap", 0));
            }
        });
        $('div#toc').append(chapterUl);

        // build Section

        secLevel = -1;
        section = $.extend(true, {}, this.arrSection);
        $.each(section, function (keyLevel, valueLevel) {
            if (secLevel != keyLevel) {
                secLevel = keyLevel;
                $.each(valueLevel, function (keyMasId, valueMasId) {
                    $.each(valueMasId, function (key1, valueSec) {
                        if (secLevel == 0) {
                            if (!$(
                                    "#toc li[chapid='"
                                    + valueSec.chapId
                                    + "']")
                                    .children(
                                            "ul").length) {
                                secUl = $(
                                        "<ul/>",
                                        {
                                            'secLevel': secLevel
                                        });
                                $(
                                        "#toc li[chapid='"
                                        + valueSec.chapId
                                        + "'] a")
                                        .append(
                                                $(
                                                        "<div/>")
                                                .addClass(
                                                        'arrow down'));
                                $(
                                        "#toc li[chapid='"
                                        + valueSec.chapId
                                        + "']")
                                        .append(
                                                secUl);
                            }
                        } else {
                            if (!$(
                                    "#toc li[secid='"
                                    + valueSec.secMasterId
                                    + "']")
                                    .children(
                                            "ul").length) {
                                secUl = $(
                                        "<ul/>",
                                        {
                                            'secLevel': secLevel
                                        });
                                $(
                                        "#toc li[secid='"
                                        + valueSec.secMasterId
                                        + "'] a")
                                        .append(
                                                $(
                                                        "<div/>")
                                                .addClass(
                                                        'arrow down'));
                                $(
                                        "#toc li[secid='"
                                        + valueSec.secMasterId
                                        + "']")
                                        .append(
                                                secUl);
                            }
                        }

                        $(secUl)
                                .append(
                                        thisTocObj
                                        .getChpaterStructure(
                                                valueSec,
                                                "sec",
                                                secLevel));
                    })
                })
            }
        });

        setTimeout(function () {
            thisTocObj.dynamicEvenHandler();
        }, 500)
        this.dynamicEvenHandler();
        //adding data in last column hard coded as client suggested
        if($('#currentBookTitle').html()=='ASCE/SEI 7-16'){
            $(".main_toc").append('<li listtype="#" level="#" chapid="#" chapsrc="#" chaptype="#" chaplabel="#" paneltype="#"><a href="http://beta.asce.mpstechnologies.com/public/pdf/9780784414248.sup1.pdf" target="_blank"><div class="toc_topic"><span class="chapNo"></span><span class="chapTitle">Supplement 1 [PDF]</span></div></a></li>');   
        }
        if($('#currentBookTitle').html()=='ASCE/SEI 7-16'){
            $(".main_toc").append('<li listtype="#" level="#" chapid="#" chapsrc="#" chaptype="#" chaplabel="#" paneltype="#"><a href="http://beta.asce.mpstechnologies.com/public/pdf/9780784414248.err.pdf" target="_blank"><div class="toc_topic"><span class="chapNo"></span><span class="chapTitle">Errata [PDF]</span></div></a></li>');   
        }
        if($('#currentBookTitle').html()=='ASCE/SEI 7-16'){
            $(".main_toc").append('<li listtype="#" level="#" chapid="#" chapsrc="#" chaptype="#" chaplabel="#" paneltype="#"><a target="_blank"><div class="toc_topic"><span class="chapNo"></span><span class="chapTitle"></span></div></a></li>');   
        }
        if($('#currentBookTitle').html()=='ASCE/SEI 7-16'){
            $(".main_toc").append('<li listtype="#" level="#" chapid="#" chapsrc="#" chaptype="#" chaplabel="#" paneltype="#"><a target="_blank"><div class="toc_topic"><span class="chapNo"></span><span class="chapTitle"></span></div></a></li>');   
        }
    }

    this.getChpaterStructure = function (chapValue, type, levle) {// alert(chapValue.toSource())
        //checking for only chapter else part for section
        if (typeof chapValue.chapSrc !== "undefined") {
            if (type == "sec") {
                chapValue.chapId = chapValue.secId;
                chapValue.chapSrc = chapValue.secSrc;
                chapValue.chapLabel = chapValue.secLabel;
                chapValue.chapTitle = chapValue.secTitle;
                chapValue.chapPaneltype = chapValue.secPaneltype;
            }
            chapterLi = $("<li/>", {
                "listType": type,
                'level': levle
            });
            $(chapterLi).attr((type == "chap" ? "chapId" : "secId"),
                    chapValue.chapId);
            $(chapterLi).attr((type == "chap" ? "chapSrc" : "secSrc"),
                    chapValue.chapSrc);
            $(chapterLi).attr((type == "chap" ? "chapType" : "chapType"),
                    chapValue.contenttype);
            $(chapterLi).attr((type == "chap" ? "chapLabel" : "secLabel"),
                    chapValue.chapLabel);
            $(chapterLi).attr((type == "chap" ? "panelType" : "panelType"),
                    chapValue.chapPaneltype);
            chapterA = $("<a/>");
            chapterDivTopic = $("<div/>").addClass('toc_topic');
            $(chapterLi).append(chapterA);
            $(chapterA).append(chapterDivTopic);
            if (chapValue.chapLabel != '') {
                $(chapterDivTopic).append($("<span/>", {
                    class: "chapNo"
                }).append(chapValue.chapLabel + ":"));
            } else {
                $(chapterDivTopic).append($("<span/>", {
                    class: "chapNo"
                }).append(chapValue.chapLabel));
            }
            chapter_title = chapValue.chapTitle;
            if (chapter_title.charAt(chapter_title.length - 1) == ".") {
                chapter_title = chapter_title.slice(0, -1);
            } // Remove last char [{.},{dot}] in chapter title
            $(chapterDivTopic).append($("<span/>", {
                class: "chapTitle"
            }).append(chapter_title));
            return chapterLi;
        } else {
            //where escaping for section v value;
            var secsrcvalue = chapValue.secSrc;
            var lenghofstring = secsrcvalue.length;
            var res = secsrcvalue.charAt((lenghofstring - 1));
            if (res !== "v") {

                if (type == "sec") {
                    chapValue.chapId = chapValue.secId;
                    chapValue.chapSrc = chapValue.secSrc;
                    chapValue.chapLabel = chapValue.secLabel;
                    chapValue.chapTitle = chapValue.secTitle;
                    chapValue.chapPaneltype = chapValue.secPaneltype;
                }
                chapterLi = $("<li/>", {
                    "listType": type,
                    'level': levle
                });
                $(chapterLi).attr((type == "chap" ? "chapId" : "secId"),
                        chapValue.chapId);
                $(chapterLi).attr((type == "chap" ? "chapSrc" : "secSrc"),
                        chapValue.chapSrc);
                $(chapterLi).attr((type == "chap" ? "chapType" : "chapType"),
                        chapValue.contenttype);
                $(chapterLi).attr((type == "chap" ? "chapLabel" : "secLabel"),
                        chapValue.chapLabel);
                $(chapterLi).attr((type == "chap" ? "panelType" : "panelType"),
                        chapValue.chapPaneltype);
                chapterA = $("<a/>");
                chapterDivTopic = $("<div/>").addClass('toc_topic');
                $(chapterLi).append(chapterA);
                $(chapterA).append(chapterDivTopic);
                if (chapValue.chapLabel != '') {
                    $(chapterDivTopic).append($("<span/>", {
                        class: "chapNo"
                    }).append(chapValue.chapLabel + ":"));
                } else {
                    $(chapterDivTopic).append($("<span/>", {
                        class: "chapNo"
                    }).append(chapValue.chapLabel));
                }
                chapter_title = chapValue.chapTitle;
                if (chapter_title.charAt(chapter_title.length - 1) == ".") {
                    chapter_title = chapter_title.slice(0, -1);
                } // Remove last char [{.},{dot}] in chapter title
                $(chapterDivTopic).append($("<span/>", {
                    class: "chapTitle"
                }).append(chapter_title));
                return chapterLi;

            } else {
                return null;
            }
        }

    }

    this.clearForm = function () {
        $('#toc').empty();
    }

    this.commonClose = function () {
        objModule.destroyModule(this.moduleName);
        $('.custom_tooltip').addClass('hide');
    }
    this.distroyFrames = function () {
        $('.Commentry iframe').contents().find("body").html("still loading please wait...");
        $('.Page iframe').contents().find("body").html("still loading please wait...");
    }

    this.dynamicEvenHandler = function () {
        // this.localizationString();
        $("#toc li[listType='chap']").unbind('click');
        $("#toc li[listType='chap']").click(function () {
            arrayofintext = [];
            thisTocObj.commonClose();
            if (typeof ($(this).attr('chapSrc')) != "undefined") {
                if (thisTocObj.lastChapter != $(this).attr('chapSrc')) {
                    thisTocObj.distroyFrames();
                }
                thisTocObj.loadChapter($(this).attr('chapSrc'));
            }
            if ($(window).width() < 1020) { // bootstrap 3.x by Richard
                $('#container').addClass("hidetoc").removeClass("opentoc");
            }
			$('#history_popup .close_btn').trigger('click');
        })
        $("#toc li[listType='sec']").unbind('click');
        $("#toc li[listType='sec']").click(function (event) {
            //thisTocObj.distroyFrames();
            thisTocObj.commonClose();
            event.stopPropagation();
            if (typeof ($(this).attr('secsrc')) != "undefined") {
                var secTion1 = $(this).attr('secsrc');
                var secTion2 = $(this).parents("li[listType='chap']").attr('chapsrc');
                //debugger
                thisTocObj.goToSection(secTion1, secTion2);
                $('nav.navbar .section_no .present').val($(this).attr('secLabel'));
            }
            if ($(window).width() < 1020) { // bootstrap 3.x by Richard
                $('#container').addClass("hidetoc").removeClass("opentoc");
            }
        })
        $('.main_toc li a .arrow').unbind('click');
        $('.main_toc li a .arrow').click(function (event) {
            thisTocObj.commonClose();
            event.stopPropagation();
            $(this).toggleClass('down').toggleClass('up'); // for arrow
            $(this).parent('a').next('ul').toggleClass('open'); // for display
            // sub list
        });
		$('body').click(function(e) {
			if (!$(e.target).closest('.#history_popup').length){
				$("#history_popup").hide();
			}
		});
        $('.expandall').unbind('click');
        $('.expandall').click(function () {
            thisTocObj.commonClose();
            $('.main_toc li a .arrow').removeClass('down').addClass('up');
            $('.main_toc li a .arrow').parent('a').next('ul').addClass('open');
        });
        $('.collapseall').unbind('click');
        $('.collapseall').click(
                function () {
                    thisTocObj.commonClose();
                    $('.main_toc li a .arrow').removeClass('up').addClass(
                            'down');
                    $('.main_toc li a .arrow').parent('a').next('ul')
                            .removeClass('open');
                });

        $('.colorpicker li').unbind('click');
        $('.colorpicker li').click(function () {
            $('.colorpicker').addClass('hide');
        });




        // higlight events

        $('.custom_tooltip li').unbind('click');
        $('.custom_tooltip li').click(function () {
            //debugger
            var selectStaus = $(this).attr('class');
            $('.custom_tooltip').addClass('hide');
            var selected = thisTocObj.SelectionData.selected;
            var range = thisTocObj.SelectionData.range;
            var content = thisTocObj.SelectionData.content;
            var endNode = thisTocObj.SelectionData.endNode;
            var endOffset = thisTocObj.SelectionData.endOffset;
            var startNode = thisTocObj.SelectionData.startNode;
            var startOffset = thisTocObj.SelectionData.startOffset;
            var nodeName = thisTocObj.SelectionData.nodeName;
            var aa = thisTocObj.lastChapter;
            var bb = thisTocObj.lastCommentary;
            var paraContent = $(thisTocObj.objIframeMouse).find('#' + endNode).html();
            var secId = $(thisTocObj.objIframeMouse).find('[id^=s]').attr('id');
            if (!objModule.arrModule.highlight.active)
                return false;

            if (selectStaus == "highlight" && currentFrame == 'pagevalue') {
                CONFIG.objModule["highlight"].controler.addHighlightText(secId, startOffset, endOffset, nodeName, startNode, content, range, paraContent, aa);
                //$('.colorpicker').removeClass('hide');
            } else if (selectStaus == "highlight"
                    && currentFrame == 'commentry') {
                CONFIG.objModule["highlight"].controler
                        .addHighlightTexts($(thisTocObj.objIframeMouse)
                                .children('[id^=s]').attr('id'),
                                startOffset, endOffset, nodeName,
                                startNode, content, range, bb);

                //$('.colorpicker').removeClass('hide');
            }

            if (selectStaus == "note" && currentFrame == 'pagevalue') {
                // alert("vgfghfgf");
                if (paraContent)
                {
                    var noteId = CONFIG.objModule["notes_popup"].controler.coveretNote(range);
                }
               // var secId = $(thisTocObj.objIframeMouse).find("[newhigh_id='" + noteId + "']").closest('.section').attr('id');
                
                CONFIG.objModule["notes_popup"].controler.setNote(secId, startOffset, endOffset, nodeName,
                        startNode, content, thisTocObj.lastChapter, $(thisTocObj.objIframeMouse).find('[id=' + startNode + ']').html(), noteId);
                $('.colorpicker').addClass('hide');
            } else if (selectStaus == "note"
                    && currentFrame == 'commentry') {
                // alert("vgfghfgf");
                if (paraContent)
                {
                    var noteId = CONFIG.objModule["notes_popup"].controler.coveretNotes(range);
                }
                var secId = $(thisTocObj.objIframeMouse).find("[newhigh_id='" + noteId + "']").closest('.section').attr('id');
                CONFIG.objModule["notes_popup"].controler.setNote(secId, startOffset, endOffset, nodeName,
                        startNode, content, bb, $(thisTocObj.objIframeMouse).find('[id=' + startNode + ']').html(), noteId);
                $('.colorpicker').addClass('hide');
            }
//debugger   
            if (selectStaus == "bookmark" && currentFrame == 'pagevalue') {
                if (paraContent)
                {
                    var bookMarkId = CONFIG.objModule["bookmark"].controler.coveredboookmark(range);
                }
                CONFIG.objModule["bookmark"].controler.bookmarkSecId(
                        $(thisTocObj.objIframeMouse).children('[id^=s]').attr('id'),
                        startOffset, endOffset, nodeName, startNode, content, thisTocObj.lastChapter,
                        $(thisTocObj.objIframeMouse).find('[id=' + startNode + ']').html(), bookMarkId);
                $('.colorpicker').addClass('hide');
            } else if (selectStaus == "bookmark"
                    && currentFrame == 'commentry') {
                if (paraContent)
                {
                    var bookMarkId = CONFIG.objModule["bookmark"].controler.coveredboookmarks(range);
                }
                CONFIG.objModule["bookmark"].controler.bookmarkSecId($(
                        thisTocObj.objIframeMouse).children('[id^=s]')
                        .attr('id'), startOffset, endOffset, nodeName,
                        startNode, content, bb, $(thisTocObj.objIframeMouse).find('[id=' + startNode + ']').html(), bookMarkId);
                $('.colorpicker').addClass('hide');
            }
            if (selectStaus == "copy" && currentFrame == 'pagevalue') {
                $('.colorpicker').addClass('hide');
            } else if (selectStaus == "copy"
                    && currentFrame == 'commentry') {
                $('.colorpicker').addClass('hide');
            }
            selected.removeAllRanges();

        });

        /** *************** TOC Active class ***************** */

        $("nav.navbar .section_no .prop_value .left").unbind("click");
        $("nav.navbar .section_no .prop_value .left").click(function () {
            thisTocObj.commonClose();
            temp = "move_backward";
            thisTocObj.section_change(temp);
        });
        $("nav.navbar .section_no .prop_value .right").unbind("click");
        $("nav.navbar .section_no .prop_value .right").click(function () {
            thisTocObj.commonClose();
            temp = "move_forward";
            thisTocObj.section_change(temp);
        });
        $('nav.navbar .section_no .present').unbind("keypress");
        $('nav.navbar .section_no .present').keypress(function (e) {
            thisTocObj.commonClose();
            if (e.keyCode == 13) {
                last_sec_id = $('nav.navbar .section_no .present').val();
                temp = "move_current_position";
                thisTocObj.section_change(temp);
                // thisTocObj.goToSection($('nav.navbar .section_no
                // .present').val());
            }
        });
        $('aside header .pull-right').click(
                function () {
                    thisTocObj.commonClose();
                    if ($(this).hasClass('expandall')) {
                        // alert("expand all");
                        $('[data-accordion]').addClass('open');
                        $('aside').toggleClass('expand_contain').toggleClass(
                                'collapse_contain');
                        // $('#multiple *').removeClass( "open" ).removeClass(
                        // "close" ).removeAttr("style");
                        $('#multiple *').removeAttr("style");
                    } else {
                        // alert("collapse all");
                        $('[data-accordion]').removeClass('open');
                        $('[data-content]').css({
                            'max-height': 0,
                            'overflow': 'hidden'
                        });
                        $('aside').toggleClass('expand_contain').toggleClass(
                                'collapse_contain');
                    }
                });

        $('.nav li').on('click', function () { // toggle nav bar function
            if ($(window).width() < 1020) {
                // $('aside,section.main_section section' ).addClass( "hide" );
                $(".btn-navbar").click(); // bootstrap 2.x
                $(".navbar-toggle").click(); // bootstrap 3.x by Richard
                $('#container').addClass("hidetoc").removeClass("opentoc");
            }
        });

        $("nav.navbar .split_design span").unbind("click");
        $("nav.navbar .split_design span").click(function () {
            thisTocObj.commonClose();
            $('#container').toggleClass("horizontal").toggleClass("vertical");
            thisTocObj.set_height_and_width();
        });

        $("nav li.toc").unbind("click");
        $("nav li.toc").click(function () {
            thisTocObj.commonClose();
            $('#container').toggleClass("hidetoc").toggleClass("opentoc");
            // $( "aside .glyphicon" )[0].click();
        });

        $("aside .glyphicon").unbind("click");
        $("aside .glyphicon").click(function () {
            thisTocObj.commonClose();
            $('#container').toggleClass("hidetoc").toggleClass("opentoc");
        });

        $(".page_article header .glyphicon").unbind("click");
        $(".page_article header .glyphicon").click(
                function () {
                    thisTocObj.commonClose();
                    $('#container').toggleClass("full_size_page").toggleClass(
                            "non_full_view");
                    thisTocObj.set_height_and_width();
                });

        $(".Commentry_article header .glyphicon").unbind("click");
        $(".Commentry_article header .glyphicon").click(
                function () {
                    thisTocObj.commonClose();
                    $('#container').toggleClass("full_size_commentry")
                            .toggleClass("non_full_view");
                    thisTocObj.set_height_and_width();
                });

        $("nav.navbar .font_prop .font_img").unbind("click");
        $("nav.navbar .font_prop .font_img")
                .click(
                        function () {
                            thisTocObj.commonClose();
                            if (($('nav.navbar .zoom .present').text().replace(
                                    "%", "")) == 100) {
                                $('#container').toggleClass("font_120");
                                $('iframe').contents().find('body').attr({
                                    "style": ""
                                });
                                $('iframe').contents().find('body')
                                        .toggleClass("font_120_iframe");
                            } else {
                                zoom_type = "reset";
                                thisTocObj.pageZoom(zoom_type);
                            }
                        });

        $("nav.navbar .zoom .prop_value .plus").unbind("click");
        $("nav.navbar .zoom .prop_value .plus").click(function () {
            thisTocObj.commonClose();
            zoom_type = "plus";
            thisTocObj.pageZoom(zoom_type);
        });
        $("nav.navbar .zoom .prop_value .minus").unbind("click");
        $("nav.navbar .zoom .prop_value .minus").click(function () {
            thisTocObj.commonClose();
            zoom_type = "minus";
            thisTocObj.pageZoom(zoom_type);
        });

        // higlight events
    }

    this.localizationString = function () {

    }

    this.set_height_and_width = function () // set height width for all
    {
        CONFIG.objModule['commonInfo'].controler.set_height_and_width();
    }

    this.pageZoom = function (zoom_type) {
        $('#container').removeClass("font_120");
        zoom_perc = $('nav.navbar .zoom .present').text().replace("%", "");
        if (zoom_perc < 200 && zoom_perc >= 70 && zoom_type == "plus") {
            zoom_perc = parseInt(zoom_perc) + 10;
        }
        if (zoom_perc <= 200 && zoom_perc > 70 && zoom_type == "minus") {
            zoom_perc = parseInt(zoom_perc) - 10;
        }
        if (zoom_type == "reset") {
            zoom_perc = 100;
        }
        $("iframe").contents().find('body').css({
            'font-size': zoom_perc + "%"
        });
        $('nav.navbar .zoom .present').text(zoom_perc + "%");
    }

    this.iframeEventss = function () {

        $('#page_frame').contents().find(".xref-font").click(function(e){
            var chapterUrl = $(this).attr("href");
            if(chapterUrl.indexOf("#") == -1){
                e.preventDefault();
                var chapterNumber = chapterUrl.split(".").slice(-2, -1)[0];
                if(chapterNumber.indexOf("ch") > -1){
                    var number = chapterNumber.replace(/[^0-9]/gi, '')
                    chapterNumber = (number.length == 1) ? "ch0"+number :chapterNumber;
                    thisTocObj.loadChapter(chapterNumber);
                }
            }
            
        });

        $('#commentry_frame').contents().find(".xref-font").click(function(e){
            var chapterUrl = $(this).attr("href");
            if(chapterUrl.indexOf("#") == -1){
                e.preventDefault();
                var chapterNumber = chapterUrl.split(".").slice(-2, -1)[0];
                if(chapterNumber.indexOf("ch") > -1){
                    var number = chapterNumber.replace(/[^0-9]/gi, '')
                    chapterNumber = (number.length == 1) ? "ch0"+number :chapterNumber;
                    thisTocObj.loadChapter(chapterNumber);
                }
            }
            
        });

        $('.page_article').addClass("loaders");

        $('.page_article').after('<style>.loaders {opacity: 0.2}.loaders:before {opacity: 1;content: url("../asce_content/themes/default/images/loader.gif");position: absolute;top: 50%;left: 36%;z-index: 1;}</style>');

         
        $('#commentry_frame').contents().find(".deletion").hide();
        $('#commentry_frame').contents().find(".insertion").css('color', 'black');
        
        // $('#page_frame').contents().find(".deletion").hide();
        // $('#page_frame').contents().find(".insertion").css('color', 'black');
        setTimeout(function () {
            $('#page_frame').contents().find(".disp-formula").each(function () {
                var idvalue = $(this).attr('id');
                if (idvalue !== '')
                    dispformula[idvalue]=$(this).html();
            });
            $('#page_frame').contents().find(".table_view").each(function () {
               
                var idvalue = $(this).parent().attr('id');
                var linkValue = $(this).attr('href');;
                //linkforfigure[idvalue] = $(this).attr('href');
                linkforfigure[idvalue] = linkValue;
                //var contentValue = $(this).parent().contents()[3];
                var newID = idvalue.replace('.',"_");
                
                var newContent = '<p id="table_inner'+newID+'">'+$(this).parent().contents().eq(3).text()+"</p>";
                
                $( "<p id='table_inner_"+newID+"'>"+$(this).parent().contents().eq(3).text()+"</p>" ).insertBefore( $(this).parent().contents().eq(3) );
                $(this).parent().contents().eq(4).remove();
                var targetDivId = linkValue.slice( 1 );
                //$( "<p id='"+targetDivId+"'>"+$(this).parent().contents().eq(3).text()+"</p>" ).insertBefore( $(this).parent().contents().eq(3) );
                //debugger;
                //$('#page_frame').contents().find("#"+targetDivId).find('.first').html(newContent);
                //$('#page_frame').contents().find("#"+targetDivId).find('.first').html($(this).parent().contents().eq(3).text());
                //document.getElementById('anchor').addEventListener('click', function() {
                    //console.log('anchor');
                //});
            });
            $('#page_frame').contents().find(".img-space").each(function () {
                var idvalue = $(this).parent().attr('id');
                figpanel[idvalue] = $(this).attr('href');
                //debugger;
                //var allHTML = $(this).parent().html();
                //var newID = idvalue.replace('.',"_");
                //allHTML = allHTML.replace('</h5><br>', '</h5><p id="img_inner'+idvalue+'">');
                //allHTML = allHTML.replace('<br><a', '</p><a');
                //$(this).parent().html(allHTML);
            });


            //get all href for table link
            $('#page_frame').contents().find("a").each(function () {
                var hrefvalue = $(this).attr('href');

                if (typeof hrefvalue != 'undefined') {
                    var tablemark = hrefvalue.charAt(1);
                    var tablemarkwitout = hrefvalue.substring(1, hrefvalue.length);
                    if (tablemark == "t") {
                        //linkfortable.push(tablemarkwitout);
                        if (tablemarkwitout in linkforfigure) {
                            $(this).attr('href', linkforfigure[tablemarkwitout]+"_link");
                            $(this).attr('class', 'table_view_link');
                            $(this).bind( "click", function() {
                                //debugger;
                               var href=$(this).attr("href").replace("_link","");
                              //$('#page_frame').contents().find("a[href='"+href+"']").trigger("Click");
                              $('#page_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                                
                            });
                            
                        }
                    } else if (tablemark == "d") {
                        var linkhtml = $(this).attr('href');
                        var htmlclass = $(this).attr('class');
                        if (htmlclass == 'xref-font')
                        {
                            //$(this).addClass("show_equation");
                            var currentHRF = $(this).attr('href');
                            $(this).attr('href', '#equation');
                            $(this).bind( "click", function() {
                                    var hrefvalue = $(this).attr('href');
                                    var tablemarkwitout = hrefvalue.substring(1, hrefvalue.length);
                                    if (tablemarkwitout in dispformula) {
                                        var showingHTML = dispformula[tablemarkwitout];
                                        //debugger;
                                    }
                                    var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MathJax_Preview .MJXf-math {color: inherit!important} </style><style type="text/css">.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style type="text/css">.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                                    var stylesheetval = '<style>span.inline-formula {display: inline-block;margin-right: 121px;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 1.12em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>';
                                    printContent = mathJaxCss+stylesheetval+showingHTML;
                                    //debugger;
                                    $.fancybox({
                                    content: stylesheetval+mathJaxCss+showingHTML+'<hr><input type="button" style="background-color: #4CAF50; border: none; color: white;  padding: 5px 17px; text-align: center;  text-decoration: none;  display: inline-block; font-size: 16px;  margin: 4px 2px; cursor: pointer;" value="Print" onclick="printEQ()">',
                                    beforeShow: function () {
                                    //debugger
                                    $('.fancybox-outer').addClass('fancybox-skin');
                                    },
                                    });
                            });
                            $(this).attr('href', currentHRF);
                        }
                    } else if (tablemark == "f") {
                       // if (tablemarkwitout in figpanel) {
                       //     //debugger;
                       //      //$(this).attr('href', figpanel[tablemarkwitout]+"_link");
                       //      $(this).attr('href', '#ASCEIMG');
                       //      $(this).attr('class', 'table_view_link');
                       //      $(this).bind( "click", function() {
                       //          debugger;
                       //         var href=$(this).attr("href").replace("_link","");
                       //        //$('#page_frame').contents().find("a[href='"+href+"']").trigger("Click");
                       //        $('#page_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                       //        return false;
                                
                       //      });
                            
                       //  }
                    var fig_href_id = hrefvalue.replace("#","");
                    if( fig_href_id in figpanel) {
                            $(this).attr('href', figpanel[tablemarkwitout]+"_link");
                            $(this).attr('class', 'table_view_link');
                            $(this).bind( "click", function() {
                               var href=$(this).attr("href").replace("_link","");
                              $('#page_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                              return false;
                                
                            });
                        }

                    }
                    
                }
            });
            
            
            
            
            $('#page_frame').contents().find(".section").each(function () {
                arrayofintext = [];
                var idvalue = $(this).attr('id');
                var lenghofstring = idvalue.length;
                var res = idvalue.charAt((lenghofstring - 1))
                if (idvalue.indexOf("rev")> -1) {
                    $(this).hide();
                    //debugger;
                    var titleofnext =   $(this).attr('title');
                    var datefactor = $(this).attr('data-tooltip');
                    titleofnext = titleofnext+"";
                    orgsectionidrev = idvalue.slice(0, -3);
                    //var $secElementOrg = $('#page_frame').contents().find("a[id='" + orgsectionidrev + "']");
                    var $secElementOrg = $('#page_frame').contents().find("a[href='#" + idvalue + "']");
                    var checkDivEmpty = $('#page_frame').contents().find("a[href='#" + idvalue + "']").text();
                    console.log(idvalue);
                    allHTML = $secElementOrg.html();
                    //linkvalue1 = $(allHTML);
                    //linkvalue = linkvalue1;
                    //allHTML = '<div onclick="showpopupsup(\''+orgsectionidrev+'\')" class="supname tooltip1 historylinkview"><span class="tooltiptext">'+titleofnext+'; '+datefactor+'</span><a id="'+idvalue+'_history" class="history_view suplink" href="#'+idvalue+'">SUP1</a></div>'+allHTML;
                    var nameInCapital = titleofnext.toUpperCase();
                    var resnum = nameInCapital.substring(nameInCapital.length - 1);
                    var numberspan;
                    if(isNaN(resnum)){
                        numberspan='';
                    }else{
                        numberspan = resnum;
                    }
                    var first3Letter = nameInCapital.substring(0,3);
                    var finalTextForDisply = first3Letter+numberspan;
                    
                    
                    
                    //$(this).style.display = 'none';
                    //$(this).attr("id",$(this).attr("id").replace('.',"_"));
                    //var linkvalue = $("<a id='" + idvalue + "_history' class='history_view' href='#" + idvalue + "' style='color: white;font-size: 13px;cursor:pointer;'> >> Show Comparison to 7-10<div class='supname tooltip1 historylinkview'><span class='tooltiptext'>Supplement 1:2018-12-12</span><a id='s21.2.3rev_history' class='history_view suplink' href='#s21.2.3rev'>SUP1</a></div></a>");
                    //allHTML = '<div onclick="showpopupsup(\''+orgsectionidrev+'\')" class="supname tooltip1 historylinkview"><span class="tooltiptext">'+titleofnext+'; '+datefactor+'</span><a id="'+idvalue+'_history" class="history_view suplink" href="#'+idvalue+'">'+(finalTextForDisply);+'</a></div>'+allHTML; '+titleofnext+'; '+datefactor+'
                    
                  
                    
                    //checking the number in last
                    var duplicate = titleofnext;
                    length = duplicate.length;
                    var res = duplicate.substr(length-1, 1);
                    if(parseInt(res)){
                        var firstPart  = duplicate.substr(0,length-1);
                        var titleofnext = firstPart+" "+res;
                    }else{
                        titleofnext = duplicate;
                    }
                    var linkvalue = $("<a id='" + idvalue + "_history' class='history_view' href='#" + idvalue + "' style='color: white;font-size: 13px;cursor:pointer;'> <div id='supnamebottom" + idvalue +"' class='supnamebottom" + idvalue +" tooltip1 historylinkview'><span class='tooltiptext'>"+titleofnext+";<br/> "+datefactor+"</span>"+finalTextForDisply+"</div></a>");
                    var divsection = $("<div class='supname tooltip1 historylinkview'><div>");
                    //var divsectionun = $("<div class='supname tooltip1 historylinkview' style='display:none;'><div>");
                    //var finallinkdiv  = $(divsection).append(linkvalue)
                    
                    indexofvalue = arrayofintext.indexOf(idvalue);
                    
                    if(finalTextForDisply!=='UND1' && indexofvalue==-1){
                        var finallinkdiv = $(divsection).html(linkvalue)
                        allHTML = finallinkdiv;
                    }
                    //$secElementOrg.next().next().prepend(allHTML);
                    //debugger

                    // if($secElementOrg.find('.tooltip1').length < 1){
                    //     $secElementOrg.prepend(allHTML);
                    // }
                    
                    console.log(checkDivEmpty);
                    if($.inArray(idvalue,arrayofintext) == -1 && checkDivEmpty == ""){
                        //$secElementOrg.prev().remove();
                        $secElementOrg.prepend(allHTML);
                    }

                    arrayofintext.push(idvalue);
                    //var finallinkdiv1 = $(divsection).html(allHTML);
                    /*var finallinkdiv = $(divsection).html(linkvalue)
                    if (!$(this).prev().hasClass('historylinkview')) { 
                        $(this).before(finallinkdiv);
                    }
                    //historyarray.push(idvalue);
                    var finallinkdiv = $(divsection).html(linkvalue)
                    if (!$(this).prev().hasClass('historylinkview')) {
                        $(this).before(finallinkdiv);
                    }*/
                    //checking parent marked , if exist
                    var currentIdArray = idvalue.split(".");
                    var sizevalue = currentIdArray.length;
                    sizevalue = sizevalue - 1;
                    var counterid = 0;
                    var newidvalue = '';
                    var newidvalue_1 = [];
                    for (counterid = 0; counterid < sizevalue; counterid++) {
                        if (counterid == 0) {
                            newidvalue = currentIdArray[counterid];
                        } else {
                            newidvalue = newidvalue + "." + currentIdArray[counterid];
                        }
                        newidvalue_1[counterid] = newidvalue;
                    }
                    newidvalue = newidvalue + "rev";
                    var flagforexistence = 0;
                    var countivalue = 0;

                    for (flagforexistence = 0; flagforexistence < (newidvalue_1.length); flagforexistence++) {
                        //debugger;
                        if ((historyarray.indexOf((newidvalue_1[flagforexistence] + "rev")) > -1)) {
                            countivalue = 1;
                        }
                    }
                    if ((!(historyarray.indexOf(newidvalue) > -1)) && (countivalue == 0)) {
                        historyarray.push(idvalue);
                    }
                }else if(res === "v" && (!idvalue.indexOf("rev")> -1)) {

                    $(this).hide();
                    //$(this).attr("id",$(this).attr("id").replace('.',"_"));
                    var linkvalue = $("<a id='" + idvalue + "_history' class='history_view' href='#" + idvalue + "' style='color: white;font-size: 13px;cursor:pointer;'> >> Show Comparison to 7-10</a>");
                    var divsection = $("<div class='historylinkview' style='background-color: #808080;padding: 5px 10px;'><div>");
                    //var finallinkdiv  = $(divsection).append(linkvalue)
                    //debugger;
                    var finallinkdiv = $(divsection).html(linkvalue)
                    if (!$(this).prev().hasClass('historylinkview')) {
                        $(this).before(finallinkdiv);
                    }
                    //historyarray.push(idvalue);
                    var finallinkdiv = $(divsection).html(linkvalue)
                    if (!$(this).prev().hasClass('historylinkview')) {
                        $(this).before(finallinkdiv);
                    }
                    //checking parent marked , if exist
                    var currentIdArray = idvalue.split(".");
                    var sizevalue = currentIdArray.length;
                    sizevalue = sizevalue - 1;
                    var counterid = 0;
                    var newidvalue = '';
                    var newidvalue_1 = [];
                    for (counterid = 0; counterid < sizevalue; counterid++) {
                        if (counterid == 0) {
                            newidvalue = currentIdArray[counterid];
                        } else {
                            newidvalue = newidvalue + "." + currentIdArray[counterid];
                        }
                        newidvalue_1[counterid] = newidvalue;
                    }
                    newidvalue = newidvalue + "v";
                    var flagforexistence = 0;
                    var countivalue = 0;

                    for (flagforexistence = 0; flagforexistence < (newidvalue_1.length); flagforexistence++) {
                        //debugger;
                        if ((historyarray.indexOf((newidvalue_1[flagforexistence] + "v")) > -1)) {
                            countivalue = 1;
                        }
                    }
                    if ((!(historyarray.indexOf(newidvalue) > -1)) && (countivalue == 0)) {
                        historyarray.push(idvalue);
                    }
                }
                //debugger;
                console.log(linkvalue);
                $(linkvalue).click(function () {
                    
                    var chapterNumberString = $(this).attr("id");
                    var chapterNumber = "";
                    if(chapterNumberString !=""){
                        var chapterNumber = chapterNumberString.replace(/[^\d.-]/g,'');
                        chapterNumber = "<span class='chapter_numeric_number'>"+chapterNumber+"</span>";    
                    }
                    var orgsections = [];
                    var sectionid = $(this).attr('href');
                    if(sectionid.indexOf("rev")> -1){
                        //console.log(linkvalue);
                    orgsectionid = sectionid.slice(0, -3);
                    orgsectionid = orgsectionid.substr(1);
                    sectionid = sectionid.replace('#', "");
                    var $secElement = $('#page_frame').contents().find("div[class='section'][id='" + sectionid + "']");
                    var $secElementOrg = $('#page_frame').contents().find("div[class='section'][id='" + orgsectionid + "']");
                    //debugger;
                    //$secElement.find("img").attr("src","../asce_content/fancybox/dummy_table_thumb.gif");


                    //storing all orginal images
                    $secElementOrg.find("img").each(function () {
                        orgsections.push($(this).parent().attr('href'));
                    });

                    var counti = 0;
                    $secElement.find("img").each(function () {
                        if ((orgsections.hasOwnProperty(counti)) && ((orgsections[counti].indexOf('#')) > -1))
                        {
                            $(this).parent().attr('image_org', orgsections[counti]);
                            $(this).attr("src", "../asce_content/fancybox/dummy_table_thumb.gif");
                        } else if ($(this).parent().attr('class') == 'table_view') {
                            $(this).attr("src", "../asce_content/fancybox/dummy_table_thumb.gif");

                        } else {
                            $(this).parent().attr('image_org', orgsections[counti]);
                            //$(this).parent().attr('href', "#" + orgsections[counti]);
                            $(this).css('border', '1px solid #808080');
                            //setting image thum
                            var UrlValaue = $('#page_frame').attr('src');
                            var UrlValaueArray = UrlValaue.split("pages");
                            var TempImageValue = $(this).attr('src');
                            var altUrl = $(this).attr('alt');
                            var TempImage = TempImageValue.split("../");
                            if (TempImageValue.indexOf('asce_content') > -1) {
                                var FinalURL = TempImageValue;
                            } else {
                                var FinalURL = UrlValaueArray[0] + TempImage[1];
                            }

                            var TempImageValue = $(this).parent().attr('href');
                            var TempImage = TempImageValue.split("../");
                            if (TempImageValue.indexOf('asce_content') > -1) {
                                var FinalAnchorURL = TempImageValue;
                            } else {
                                var FinalAnchorURL = UrlValaueArray[0] + TempImage[1];
                            }

                            if(TempImageValue.indexOf("table30.6-2c.err") > -1){
                                var FinalAnchorURL = TempImageValue;
                                var FinalURL = altUrl;
                            }

                            $(this).parent().attr('href', FinalAnchorURL).attr("target","_blank");
                            $(this).attr("src", FinalURL);
                        }
                        counti++;
                    });
                    //debugger;
                    var contentvaluefancybox = $secElement.html();

                    //replace rev from title
                    contentvaluefancybox = chapterNumber + contentvaluefancybox.replace(/rev[^"]\s/,'');
                    var contentvaluefancybox = '<div id="FinalDiv" class="FinalDiv element">' + contentvaluefancybox + '</div>';
                    //var contentvaluefancybox = '<div id="FinalDiv" class="FinalDiv element">' + contentvaluefancybox + '</div>';
                    console.log("With JS Master");
                    //var stylesheetval = '<style>.FinalDiv{width:960px!important;}div.def-list{border-spacing: 0.25em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>';
                    var stylesheetval = '<style>.element {opacity: 0.2}.element:before {opacity: 1;content: url("../asce_content/themes/default/images/loader.gif");position: absolute;top: 50%;left: 36%;z-index: 1;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 0.25em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}.MathJax_Error{display:none!important;}</style>';
                var stylejs = '<script>$(".deletion").show();$(".insertion").css("color","green");\n\
$(document).ready(function() { setTimeout(function(){$("#FinalDiv").removeClass("element")},1000);var removeV = $( ".FinalDiv>a" ).html(); $( ".FinalDiv>a" ).html(removeV)\n\
$(".table_view").click(function()\n\
{ $("body").find("#history_popup").css("display","none");$("body").find(".history_panel").removeClass("active");var table_id=$(this).attr("image_org");\n\
var href=$(this).attr("href");\n\
$(".fancybox-close").trigger( "click" );\n\
$("#page_frame").contents().find("a[href=\'"+href+"\']")[0].click();\n\
$("#page_frame").contents().find(".insertion").css("color","green");\n\
$("#page_frame").contents().find(".deletion").css("display","inline");\n\
})\n\$(".img-space").click(function()\n\
{ var table_id=$(this).attr("image_org");\n\
$(".fancybox-close").trigger( "click" );\n\
$("#page_frame").contents().find("a[href=\'"+table_id+"\']")[0].click();\n\
})\n\
});</script>\n\
';
                  //  var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MathJax_Preview .MJXf-math {color: inherit!important} </style><style type="text/css">.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style type="text/css">.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                   // var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                      var mathJaxCss = '<link rel="stylesheet" type="text/css" href="mathjax/style.css"><style type="text/css">.mi,.mo,.mn,.msqrt,.mfrac{display:none!important},.math {display:hide},math[mode=inline]{display:inline;font-family:CMSY10,CMEX10,Symbol,Times;font-style:normal}math[mode=display]{display:block;text-align:center;font-family:CMSY10,CMEX10,Symbol,Times;font-style:normal}@media screen{math .[mathvariant=normal]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:400;font-style:normal}math .[mathvariant=bold]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:700;font-style:normal}math .[mathvariant=italic]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:400;font-style:italic}math .[mathvariant=bold-italic]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:700;font-style:italic}math .[mathvariant=double-struck]{font-family:msbm;font-weight:400;font-style:normal}math .[mathvariant=script]{font-family:eusb;font-weight:400;font-style:normal}math .[mathvariant=bold-script]{font-family:eusb;font-weight:700;font-style:normal}math .[mathvariant=fraktur]{font-family:eufm;font-weight:400;font-style:normal}math .[mathvariant=bold-fraktur]{font-family:eufm;font-weight:700;font-style:italic}math .[mathvariant=sans-serif]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:400;font-style:normal}math .[mathvariant=bold-sans-serif]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:700;font-style:normal}math .[mathvariant=sans-serif-italic]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:400;font-style:italic}math .[mathvariant=sans-serif-bold-italic]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:700;font-style:italic}math .[mathvariant=monospace]{font-family:monospace}math .[mathsize=small]{font-size:80%}math .[mathsize=big],mmultiscripts>:first-child[mathsize=big],mover>:first-child[mathsize=big],mroot>:first-child[mathsize=big],msub>:first-child[mathsize=big],msubsup>:first-child[mathsize=big],msup>:first-child[mathsize=big],munder>:first-child[mathsize=big],munderover>:first-child[mathsize=big]{font-size:125%}mmultiscripts>:first-child[mathsize=small],mover>:first-child[mathsize=small],mroot>:first-child[mathsize=small],msub>:first-child[mathsize=small],msubsup>:first-child[mathsize=small],msup>:first-child[mathsize=small],munder>:first-child[mathsize=small],munderover>:first-child[mathsize=small]{font-size:80%}mmultiscripts>:first-child,mover>:first-child,mroot>:first-child,msub>:first-child,msubsup>:first-child,msup>:first-child,munder>:first-child,munderover>:first-child{font-size:100%}math [scriptlevel="+1"][mathsize=big],math[display=inline] mfrac>[mathsize=big],mmultiscripts>[mathsize=big],mover>[mathsize=big],msub>[mathsize=big],msubsup>[mathsize=big],msup>[mathsize=big],munder>[mathsize=big],munderover>[mathsize=big]{font-size:89%}math [scriptlevel="+1"][mathsize=small],math[display=inline] mfrac>[mathsize=small],mmultiscripts>[mathsize=small],mover>[mathsize=small],msub>* [mathsize=small],msubsup>[mathsize=small],msup>[mathsize=small],munder>[mathsize=small],munderover>[mathsize=small]{font-size:57%}math [scriptlevel="+1"],math[display=inline] mfrac>*,mmultiscripts>*,mover>*,msub>*,msubsup>*,msup>*,munder>*,munderover>*{font-size:71%}mroot>[mathsize=big]{font-size:62%}mroot>[mathsize=small]{font-size:40%}mroot>*{font-size:50%}math [scriptlevel="+2"][mathsize=big]{font-size:63%}math [scriptlevel="+2"][mathsize=small]{font-size:36%}math [scriptlevel="+2"]{font-size:50%}math .[mathcolor=green]{color:green}math .[mathcolor=black]{color:#000}math .[mathcolor=red]{color:red}math .[mathcolor=blue]{color:#00f}math .[mathcolor=olive]{color:olive}math .[mathcolor=purple]{color:purple}math .[mathcolor=teal]{color:teal}math .[mathcolor=aqua]{color:#0ff}math .[mathcolor=gray]{color:gray}math .[mathbackground=blue]{background-color:#00f}math .[mathbackground=green]{background-color:green}math .[mathbackground=white]{background-color:#fff}math .[mathbackground=yellow]{background-color:#ff0}math .[mathbackground=aqua]{background-color:#0ff}} .mi,.mn,.mo{font-weight: bold;font-style: italic;} </style>';           
                                                     
                    
                
                   
                    var divE = document.createElement("div");
                    divE.innerHTML = contentvaluefancybox;

                    //debugger;
                    //
                    //replace all the mi class with new MathJax Class
                    /*$(divE).find(".mi").each(function () {
                        $(this).removeClass('mi');
                        $(this).addClass('MJXp-mi MJXp-italic');
                    });*/
                    
                    //now checking for list
                    $(divE).find(".list").each(function () {
						//debugger;
                        var previousclass = "";
                        if ($(this).prev().find(".insertion").length > 0)
                            previousclass = "";
                        else if ($(this).prev().find(".deletion").length > 0)
                            previousclass = "deletion";
                        else {
                            previousclass = "normaltable";
                        }
                       $(this).addClass(previousclass);
						
                    })

                    //now checking for list
                    $(divE).find(".img-space").each(function () {
                        //debugger;
                        var previousclassfigimage = '';
                        if (($(this).parent().attr('fig-type') == 'fig-deletion')) {
                            previousclassfigimage = "deletiontable";
                        } else if (($(this).parent().attr('fig-type') == 'fig-insertion')) {
                            previousclassfigimage = "insertiontable";
                        } else {
                            var previousclassfigimage = "normaltable";
                        }
                        $(this).parent().addClass(previousclassfigimage);
                    })
                    $(divE).find(".table_view").each(function () {
                        var previousclassfigimage = '';
                        if (($(this).parent().find('.table-wrap').attr('table-type') == 'table-deletion')) {
                            previousclassfigimage = "deletiontable";
                        } else if (($(this).parent().find('.table-wrap').attr('table-type') == 'table-insertion')) {
                            previousclassfigimage = "insertiontable";
                        } else {
                            var previousclassfigimage = "normaltable";
                        }
                        $(this).parent().addClass(previousclassfigimage);
                    })

                    //now showing inner value
                    $(divE).find(".section").each(function () {
                       // debugger;
                        var sectionidvalue = $(this).attr("id");
                        var lenghofstring = sectionidvalue.length;

                        var res = sectionidvalue.charAt((lenghofstring - 1))
                        if (res == 'rev') {
                            //if($(this).children().eq(0).indexOf("v")<-1)
                            $(this).children().eq(0).html($(this).children().eq(0).html().replace("rev", ''));
                            $(this).css('display', 'inline');

                        } else {
                            $(this).css('display', 'none');
                        }
                    })

                    var valuewithoutv = divE.firstChild.innerHTML;
                    //valuewithoutv = valuewithoutv.replace("rev", "");
                    divE.firstChild.innerHTML = valuewithoutv;

                    //debugger;
                    contentvaluefancybox = divE.innerHTML;
                    //contentvaluefancybox = stylesheetval + contentvaluefancybox + stylejs + mathJaxCss;
                    if($(this).find('.tooltiptext').html()!==''){                 
                        var titleoffancybox = '<div style="color: #0c5fa8;font-weight: bold;font-size: 17px;">'+($(this).find('.tooltiptext').html().replace("<br>", ""))+'</div>';
                    }
                    else{
                        titleoffancybox='';
                    }
                    contentvaluefancybox = mathJaxCss+ stylesheetval + titleoffancybox+ contentvaluefancybox + stylejs;
                    
                    $.fancybox({
                        
                        content: contentvaluefancybox,
                        beforeShow: function () {
                            //debugger
                            $("link").each(function () {
                                var href = $(this).attr("href");
                                if (href.indexOf("fancybox_2") > -1) {
                                    hrefvalue = href.replace("fancybox_2", "fancybox");
                                    $(this).attr('href', hrefvalue);
                                }
                            });
                            $('.fancybox-outer').addClass('fancybox-skin');
                        },
                    });
                    }else{
                        
                    orgsectionid = sectionid.slice(0, -1);
                    orgsectionid = orgsectionid.substr(1);
                    sectionid = sectionid.replace('#', "");
                    var $secElement = $('#page_frame').contents().find("div[class='section'][id='" + sectionid + "']");
                    var $secElementOrg = $('#page_frame').contents().find("div[class='section'][id='" + orgsectionid + "']");
                    //debugger;
                    //$secElement.find("img").attr("src","../asce_content/fancybox/dummy_table_thumb.gif");


                    //storing all orginal images
                    $secElementOrg.find("img").each(function () {
                        orgsections.push($(this).parent().attr('href'));
                    });

                    var counti = 0;
                    $secElement.find("img").each(function () {
                        if ((orgsections.hasOwnProperty(counti)) && ((orgsections[counti].indexOf('#')) > -1))
                        {
                            $(this).parent().attr('image_org', orgsections[counti]);
                            $(this).attr("src", "../asce_content/fancybox/dummy_table_thumb.gif");
                        } else if ($(this).parent().attr('class') == 'table_view') {
                            $(this).attr("src", "../asce_content/fancybox/dummy_table_thumb.gif");

                        } else {
                            //debugger;
                            $(this).parent().attr('image_org', orgsections[counti]);
                            $(this).parent().attr('href', "#" + orgsections[counti]);
                            $(this).css('border', '1px solid #808080');
                            //setting image thum
                            var UrlValaue = $('#page_frame').attr('src');
                            var UrlValaueArray = UrlValaue.split("pages");
                            var TempImageValue = $(this).attr('src');
                            var TempImage = TempImageValue.split("../");
                            if (TempImageValue.indexOf('asce_content') > -1) {
                                var FinalURL = TempImageValue;
                            } else {
                                var FinalURL = UrlValaueArray[0] + TempImage[1];
                            }
                            $(this).attr("src", FinalURL);
                        }
                        counti++;
                    });

                    var contentvaluefancybox = $secElement.html();
                    var contentvaluefancybox = '<script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML"></script><div id="FinalDiv" class="FinalDiv element">' + contentvaluefancybox + '</div>';

                    //var stylesheetval = '<style>.FinalDiv{width:960px!important;}div.def-list{border-spacing: 0.25em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>';
                    var stylesheetval = '<style>.element {opacity: 0.2}.element:before {opacity: 1;content: url("../asce_content/themes/default/images/loader.gif");position: absolute;top: 50%;left: 36%;z-index: 1;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 0.25em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}.MathJax_Error{display:none!important;}</style>';
                var stylejs = '<script>$(".deletion").show();$(".insertion").css("color","green");\n\
$(document).ready(function() {  setTimeout(function(){$("#FinalDiv").removeClass("element")},1000);var removeV = $( ".FinalDiv>a" ).html(); removeV= removeV.replace("v", "");$( ".FinalDiv>a" ).html(removeV)\n\
$(".table_view").click(function()\n\
{ var table_id=$(this).attr("image_org");\n\
$(".fancybox-close").trigger( "click" );\n\
$("#page_frame").contents().find("a[href=\'"+table_id+"\']")[0].click();\n\
})\n\$(".img-space").click(function()\n\
{ var table_id=$(this).attr("image_org");\n\
$(".fancybox-close").trigger( "click" );\n\
$("#page_frame").contents().find("a[href=\'"+table_id+"\']")[0].click();\n\
})\n\
});</script>\n\
';
                  //  var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MathJax_Preview .MJXf-math {color: inherit!important} </style><style type="text/css">.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style type="text/css">.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                   // var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                     // var mathJaxCss = '<style type="text/css">.mi,.mo,.mn,.msqrt,.mfrac{display:none!important},.math {display:hide},math[mode=inline]{display:inline;font-family:CMSY10,CMEX10,Symbol,Times;font-style:normal}math[mode=display]{display:block;text-align:center;font-family:CMSY10,CMEX10,Symbol,Times;font-style:normal}@media screen{math .[mathvariant=normal]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:400;font-style:normal}math .[mathvariant=bold]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:700;font-style:normal}math .[mathvariant=italic]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:400;font-style:italic}math .[mathvariant=bold-italic]{font-family:"Times New Roman",Courier,Garamond,serif;font-weight:700;font-style:italic}math .[mathvariant=double-struck]{font-family:msbm;font-weight:400;font-style:normal}math .[mathvariant=script]{font-family:eusb;font-weight:400;font-style:normal}math .[mathvariant=bold-script]{font-family:eusb;font-weight:700;font-style:normal}math .[mathvariant=fraktur]{font-family:eufm;font-weight:400;font-style:normal}math .[mathvariant=bold-fraktur]{font-family:eufm;font-weight:700;font-style:italic}math .[mathvariant=sans-serif]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:400;font-style:normal}math .[mathvariant=bold-sans-serif]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:700;font-style:normal}math .[mathvariant=sans-serif-italic]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:400;font-style:italic}math .[mathvariant=sans-serif-bold-italic]{font-family:Arial,"Lucida Sans Unicode",Verdana,sans-serif;font-weight:700;font-style:italic}math .[mathvariant=monospace]{font-family:monospace}math .[mathsize=small]{font-size:80%}math .[mathsize=big],mmultiscripts>:first-child[mathsize=big],mover>:first-child[mathsize=big],mroot>:first-child[mathsize=big],msub>:first-child[mathsize=big],msubsup>:first-child[mathsize=big],msup>:first-child[mathsize=big],munder>:first-child[mathsize=big],munderover>:first-child[mathsize=big]{font-size:125%}mmultiscripts>:first-child[mathsize=small],mover>:first-child[mathsize=small],mroot>:first-child[mathsize=small],msub>:first-child[mathsize=small],msubsup>:first-child[mathsize=small],msup>:first-child[mathsize=small],munder>:first-child[mathsize=small],munderover>:first-child[mathsize=small]{font-size:80%}mmultiscripts>:first-child,mover>:first-child,mroot>:first-child,msub>:first-child,msubsup>:first-child,msup>:first-child,munder>:first-child,munderover>:first-child{font-size:100%}math [scriptlevel="+1"][mathsize=big],math[display=inline] mfrac>[mathsize=big],mmultiscripts>[mathsize=big],mover>[mathsize=big],msub>[mathsize=big],msubsup>[mathsize=big],msup>[mathsize=big],munder>[mathsize=big],munderover>[mathsize=big]{font-size:89%}math [scriptlevel="+1"][mathsize=small],math[display=inline] mfrac>[mathsize=small],mmultiscripts>[mathsize=small],mover>[mathsize=small],msub>* [mathsize=small],msubsup>[mathsize=small],msup>[mathsize=small],munder>[mathsize=small],munderover>[mathsize=small]{font-size:57%}math [scriptlevel="+1"],math[display=inline] mfrac>*,mmultiscripts>*,mover>*,msub>*,msubsup>*,msup>*,munder>*,munderover>*{font-size:71%}mroot>[mathsize=big]{font-size:62%}mroot>[mathsize=small]{font-size:40%}mroot>*{font-size:50%}math [scriptlevel="+2"][mathsize=big]{font-size:63%}math [scriptlevel="+2"][mathsize=small]{font-size:36%}math [scriptlevel="+2"]{font-size:50%}math .[mathcolor=green]{color:green}math .[mathcolor=black]{color:#000}math .[mathcolor=red]{color:red}math .[mathcolor=blue]{color:#00f}math .[mathcolor=olive]{color:olive}math .[mathcolor=purple]{color:purple}math .[mathcolor=teal]{color:teal}math .[mathcolor=aqua]{color:#0ff}math .[mathcolor=gray]{color:gray}math .[mathbackground=blue]{background-color:#00f}math .[mathbackground=green]{background-color:green}math .[mathbackground=white]{background-color:#fff}math .[mathbackground=yellow]{background-color:#ff0}math .[mathbackground=aqua]{background-color:#0ff}} .mi,.mn,.mo{font-weight: bold;font-style: italic;} </style>';           
                      var mathJaxCss='';  
               
                                                     
                    
                
                   
                    var divE = document.createElement("div");
                    divE.innerHTML = contentvaluefancybox;

                    //debugger;
                    //
                    //replace all the mi class with new MathJax Class
                    $(divE).find(".mi").each(function () {
                        $(this).removeClass('mi');
                        $(this).addClass('MJXp-mi MJXp-italic');
                    });
                    
                    //now checking for list
                    $(divE).find(".list").each(function () {
						
                        var previousclass = "";
                        if ($(this).prev().find(".insertion").length > 0)
                            previousclass = "insertion";
                        else if ($(this).prev().find(".deletion").length > 0)
                            previousclass = "deletion";
                        else {
                            previousclass = "normaltable";
                        }
                        $(this).parent().addClass(previousclass);
                        //debugger;
                    })

                    //now checking for list
                    $(divE).find(".img-space").each(function () {
                        //debugger;
                        var previousclassfigimage = '';
                        if (($(this).parent().attr('fig-type') == 'fig-deletion')) {
                            previousclassfigimage = "deletiontable";
                        } else if (($(this).parent().attr('fig-type') == 'fig-insertion')) {
                            previousclassfigimage = "insertiontable";
                        } else {
                            var previousclassfigimage = "normaltable";
                        }
                        $(this).parent().addClass(previousclassfigimage);
                    })
                    $(divE).find(".table_view").each(function () {
                        var previousclassfigimage = '';
                        if (($(this).parent().find('.table-wrap').attr('table-type') == 'table-deletion')) {
                            previousclassfigimage = "deletiontable";
                        } else if (($(this).parent().find('.table-wrap').attr('table-type') == 'table-insertion')) {
                            previousclassfigimage = "insertiontable";
                        } else {
                            var previousclassfigimage = "normaltable";
                        }
                        $(this).parent().addClass(previousclassfigimage);
                    })

                    //now showing inner value
                    $(divE).find(".section").each(function () {
                       // debugger;
                        var sectionidvalue = $(this).attr("id");
                        var lenghofstring = sectionidvalue.length;

                        var res = sectionidvalue.charAt((lenghofstring - 1))
                        if (res == 'v') {
                            //if($(this).children().eq(0).indexOf("v")<-1)
                            $(this).children().eq(0).html($(this).children().eq(0).html().replace("v", ''));
                            $(this).css('display', 'inline');

                        } else {
                            $(this).css('display', 'none');
                        }
                    })

                    var valuewithoutv = divE.firstChild.innerHTML;
                    valuewithoutv = valuewithoutv.replace("v", "");
                    divE.firstChild.innerHTML = valuewithoutv;

                    //debugger;
                    contentvaluefancybox = divE.innerHTML;
                    //contentvaluefancybox = stylesheetval + contentvaluefancybox + stylejs + mathJaxCss;
                    contentvaluefancybox = mathJaxCss+ stylesheetval + contentvaluefancybox + stylejs;
                    $.fancybox({
                        content: contentvaluefancybox,
                        beforeShow: function () {
                            //debugger
                            $("link").each(function () {
                                var href = $(this).attr("href");
                                if (href.indexOf("fancybox_2") > -1) {
                                    hrefvalue = href.replace("fancybox_2", "fancybox");
                                    $(this).attr('href', hrefvalue);
                                }
                            });
                            $('.fancybox-outer').addClass('fancybox-skin');
                        },
                    });
                    }
                    
                })
            });
            $('#page_frame').contents().find(".section").each(function () {
                var idvalue = $(this).attr('id');
                var lenghofstring = idvalue.length;
                var res = idvalue.charAt((lenghofstring - 1))
                if (res !== 'v') {
                    //debugger;
                    var withVIdValue = idvalue + "v";
                    if (historyarray.indexOf(withVIdValue) > -1) {
                        $(this).css('border-left', ' thick solid grey');
                        $(this).css('padding-left', '10px');
                    }
                }
            });
            $('.page_article').removeClass("loaders");
        }, 3000);

        

        //console.log(historyarray);

        $('.Commentry iframe').contents().find('book-part > .section').unbind(
                'mouseup');
        $('.Commentry iframe')
                .contents()
                .find('book-part > .section')
                .mouseup(
                        function (event) {
                            $('.colorpicker').addClass('hide');

                            $($(this).siblings()).removeClass(
                                    'deselect_other_content');
                            var frame = document
                                    .getElementById('commentry_frame');
                            // alert("dsds");
                            var frameWindow = frame && frame.contentWindow;
                            var frameDocument = frameWindow
                                    && frameWindow.document;
                            var fullString = frameDocument
                                    .getElementsByTagName("body")[0].textContent;
                            // alert(fullString);
                            //debugger;
                            if (frame.contentDocument) {
                                var selected = frameWindow.getSelection();
                                var selobj = window.getSelection();

                                if (selected && selected.rangeCount > 0) {
                                var range = selected.getRangeAt(0);
                                var content = selected.toString();
                                if (!$.trim(content).length) {

                                    if (frameDocument.getSelection) {
                                        if (frameDocument.getSelection().empty) { // Chrome
                                            frameDocument.getSelection()
                                                    .empty();
                                        }/*  else if (frameDocument.getSelection().removeAllRanges) { // Firefox
                                         frameDocument.getSelection()
                                         .removeAllRanges();
                                         } */
                                    } else if (frameDocument.selection) { // IE?
                                        frameDocument.selection.empty();
                                    }
                                }
                                // console.log(getSelectedText('page_frame'));
                                // debugger;
                                if (thisTocObj
                                        .getSelectedText('commentry_frame') != ""
                                        && $.trim(content).length) {
                                    if ($(window).width() > 1020) {
                                        $('.non_full_view .custom_tooltip')
                                                .removeClass('hide')
                                                .css(
                                                        {
                                                            "position": "absolute",
                                                            "left": event.pageX
                                                                    - 115
                                                                    + ($(
                                                                            '#toc .main_toc')
                                                                            .width() + $(
                                                                            '.page_article')
                                                                            .width()),
                                                            "top": event.clientY
                                                                    + ($('#container .main_header')
                                                                            .outerHeight())
                                                        });
                                        $('.full_size_page .custom_tooltip')
                                                .removeClass('hide')
                                                .css(
                                                        {
                                                            "position": "absolute",
                                                            "left": event.pageX
                                                                    - 180
                                                                    + ($(
                                                                            '#toc .main_toc')
                                                                            .width() + $(
                                                                            '.page_article')
                                                                            .width()),
                                                            "top": event.clientY
                                                                    + ($('#container .main_header')
                                                                            .outerHeight())
                                                        });
                                        $('.non_full_view .colorpicker')
                                                .css(
                                                        {
                                                            "position": "absolute",
                                                            "left": event.pageX
                                                                    - 180
                                                                    + ($(
                                                                            '#toc .main_toc')
                                                                            .width() + $(
                                                                            '.page_article')
                                                                            .width()),
                                                            "top": event.clientY
                                                                    + ($('#container .main_header')
                                                                            .outerHeight())
                                                                    - 20
                                                        });
                                        $('.full_size_page .colorpicker')
                                                .css(
                                                        {
                                                            "position": "absolute",
                                                            "left": event.pageX
                                                                    - 180
                                                                    + ($(
                                                                            '#toc .main_toc')
                                                                            .width() + $(
                                                                            '.page_article')
                                                                            .width()),
                                                            "top": event.clientY
                                                                    + ($('#container .main_header')
                                                                            .outerHeight())
                                                                    - 20
                                                        });
                                        $('.custom_tooltip').addClass(
                                                'current_highlight');
                                    }
                                    thisTocObj.objIframeMouseEvent = event;
                                    thisTocObj.objIframeMouse = this;

                                } else {
                                    // console.log("text un select");
                                    $('.custom_tooltip').addClass('hide');
                                    $('.colorpicker').addClass('hide');
                                }
                                var endOffset = range.endOffset;
                                var startOffset = range.startOffset;
                                elemParentNodeStart = range.startContainer;
                                elemParentNodeEnd = range.endContainer;
                                run = true;
                                while (run) {
                                    elemParentNodeStart = elemParentNodeStart.parentNode;
                                    elemParentNodeEnd = elemParentNodeEnd.parentNode;
                                    if ($.trim(elemParentNodeStart.id).length) {
                                        var endNode = elemParentNodeEnd.id;
                                        var nodeName = elemParentNodeEnd.nodeName;
                                        var startNode = elemParentNodeStart.id;
                                        run = false;
                                    }
                                }
                            }
                        }
                                // debugger;
                                thisTocObj.SelectionData = {
                                    selected: selected,
                                    range: range,
                                    content: content,
                                    endNode: endNode,
                                    endOffset: endOffset,
                                    startNode: startNode,
                                    startOffset: startOffset,
                                    nodeName: nodeName
                            }

                        });
        

        if ($('#container').hasClass('font_120') == true) {
            $("iframe").contents().find('body').addClass("font_120_iframe");
            $("iframe").contents().find('body').css({
                'style': ''
            });
        } else {
            $("iframe").contents().find('body').css({
                'font-size': $('nav.navbar .zoom .present').text()
            });
        }
        
        // equation for commentry
        setTimeout(function () {
            $('#commentry_frame').contents().find(".disp-formula").each(function () {
                var idvalue = $(this).attr('id');
                if (idvalue !== '')
                    dispformulaC[idvalue]=$(this).html();
            });
            $('#commentry_frame').contents().find(".table_view").each(function () {
                var idvalue = $(this).parent().attr('id');
                linkforfigureC[idvalue] = $(this).attr('href');
            });
            $('#commentry_frame').contents().find(".img-space").each(function () {
                var idvalue = $(this).parent().attr('id');
                figpanelC[idvalue] = $(this).attr('href');
            });
            
            
            
            $('#commentry_frame').contents().find("a").each(function () {
                var hrefvalue = $(this).attr('href');

                if (typeof hrefvalue != 'undefined') {
                    var tablemark = hrefvalue.charAt(1);
                    var tablemarkwitout = hrefvalue.substring(1, hrefvalue.length);
                    if (tablemark == "t") {
                        //linkfortable.push(tablemarkwitout);
                        if (tablemarkwitout in linkforfigureC) {
//                            $(this).attr('href', linkforfigureC[tablemarkwitout]);
//                            $(this).attr('class', 'table_view');
//                            $(this).bind( "click", function() {
//                            });
                            
                            $(this).attr('href', linkforfigureC[tablemarkwitout]+"_link");
                            $(this).attr('class', 'table_view_link');
                            $(this).bind( "click", function() {
                              //debugger;
                              var href=$(this).attr("href").replace("_link","");
                              //$('#page_frame').contents().find("a[href='"+href+"']").trigger("Click");
                              $('#commentry_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                            });
                        }
                    } else if (tablemark == "d") {
                        var linkhtml = $(this).attr('href');
                        var htmlclass = $(this).attr('class');
                        if (htmlclass == 'xref-font')
                        {
                            //$(this).addClass("show_equation");
                            var currentHRF = $(this).attr('href');
                            $(this).attr('href', '#equation');
                            $(this).bind( "click", function() {
                                    //debugger;
                                    var hrefvalue = $(this).attr('href');
                                    var tablemarkwitout = hrefvalue.substring(1, hrefvalue.length);
                                    if (tablemarkwitout in dispformulaC) {
                                        var showingHTML = dispformulaC[tablemarkwitout];
                                        //debugger;
                                    }
                                    var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MathJax_Preview .MJXf-math {color: inherit!important} </style><style type="text/css">.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style type="text/css">.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                                    var stylesheetval = '<style>span.inline-formula {display: inline-block;margin-right: 121px;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 1.12em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>';
                                    printContent = mathJaxCss+stylesheetval+showingHTML;
                                    //debugger;
                                    $.fancybox({
                                    content: stylesheetval+mathJaxCss+showingHTML+'<hr><input type="button" style="background-color: #4CAF50; border: none; color: white;  padding: 5px 17px; text-align: center;  text-decoration: none;  display: inline-block; font-size: 16px;  margin: 4px 2px; cursor: pointer;" value="Print" onclick="printEQ()">',
                                    beforeShow: function () {
                                    //debugger
                                    $('.fancybox-outer').addClass('fancybox-skin');
                                    },
                                    });
                            });
                            $(this).attr('href', currentHRF);
                        }
                    } else if (tablemark == "f") {
                         $(this).attr('href', figpanelC[tablemarkwitout]+"_link");
                            $(this).attr('class', 'table_view_link');
                            $(this).bind( "click", function() {
                               var href=$(this).attr("href").replace("_link","");
                              $('#commentry_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                              return false;
                            });
                    }
                    if (tablemark == "c") { /* start the custom code for comentarty section 7-22 book issues */
                        var hrefv2 = hrefvalue.charAt(2);
                        var fig_href_id = hrefvalue.replace("#","");
                        if (hrefv2 == "t") {
                        if (tablemarkwitout in linkforfigureC) {
                            $(this).attr('href', linkforfigureC[tablemarkwitout]+"_link");
                            $(this).attr('class', 'table_view_link');
                            $(this).bind( "click", function() {
                            var href=$(this).attr("href").replace("_link","");
                            $('#commentry_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                            });
                          }  
                        }
                        if (hrefv2 == "d") {
                            var linkhtml = $(this).attr('href');
                        var htmlclass = $(this).attr('class');
                        if (htmlclass == 'xref-font')
                        {
                            //$(this).addClass("show_equation");
                            var currentHRF = $(this).attr('href');
                            $(this).attr('href', '#equation');
                            $(this).bind( "click", function() {
                                //debugger;
                                var hrefvalue = $(this).attr('href');
                                var tablemarkwitout = hrefvalue.substring(1, hrefvalue.length);
                                if (tablemarkwitout in dispformulaC) {
                                    var showingHTML = dispformulaC[tablemarkwitout];
                                    //debugger;
                                }
                                var mathJaxCss = '<style type="text/css">.MathJax_Hover_Frame {border-radius: .25em; -webkit-border-radius: .25em; -moz-border-radius: .25em; -khtml-border-radius: .25em; box-shadow: 0px 0px 15px #83A; -webkit-box-shadow: 0px 0px 15px #83A; -moz-box-shadow: 0px 0px 15px #83A; -khtml-box-shadow: 0px 0px 15px #83A; border: 1px solid #A6D ! important; display: inline-block; position: absolute} .MathJax_Menu_Button .MathJax_Hover_Arrow {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; font-family: \'Courier New\',Courier; font-size: 9px; color: #F0F0F0} .MathJax_Menu_Button .MathJax_Hover_Arrow span {display: block; background-color: #AAA; border: 1px solid; border-radius: 3px; line-height: 0; padding: 4px} .MathJax_Hover_Arrow:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_Hover_Arrow:hover span {background-color: #CCC!important} </style><style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}#MathJax_About.MathJax_MousePost {outline: none} .MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')} .MathJax_MenuItem {padding: 2px 2em; background: transparent} .MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em} .MathJax_MenuActive .MathJax_MenuArrow {color: white} .MathJax_MenuArrow.RTL {left: .5em; right: auto} .MathJax_MenuCheck {position: absolute; left: .7em} .MathJax_MenuCheck.RTL {right: .7em; left: auto} .MathJax_MenuRadioCheck {position: absolute; left: 1em} .MathJax_MenuRadioCheck.RTL {right: 1em; left: auto} .MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic} .MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px} .MathJax_MenuDisabled {color: GrayText} .MathJax_MenuActive {background-color: Highlight; color: HighlightText} .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8} .MathJax_ContextMenu:focus {outline: none} .MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none} #MathJax_AboutClose {top: .2em; right: .2em} .MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px} .MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: \'Courier New\',Courier; font-size: 24px; color: #F0F0F0} .MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px} .MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important} .MathJax_MenuClose:hover span {background-color: #CCC!important} .MathJax_MenuClose:hover:focus {outline: none} </style><style type="text/css">.MathJax_Preview .MJXf-math {color: inherit!important} </style><style type="text/css">.MJX_Assistive_MathML {position: absolute!important; top: 0; left: 0; clip: rect(1px, 1px, 1px, 1px); padding: 1px 0 0 0!important; border: 0!important; height: 1px!important; width: 1px!important; overflow: hidden!important; display: block!important; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none} .MJX_Assistive_MathML.MJX_Assistive_MathML_Block {width: 100%!important}   </style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\')}   #MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   #MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}   #MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}   </style><style type="text/css">.MathJax_Preview {color: #888}   #MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}   #MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}   .MathJax_Error {color: #CC0000; font-style: italic}   </style><style type="text/css">.MJXp-script {font-size: .8em}   .MJXp-right {-webkit-transform-origin: right; -moz-transform-origin: right; -ms-transform-origin: right; -o-transform-origin: right; transform-origin: right}   .MJXp-bold {font-weight: bold}   .MJXp-italic {font-style: italic}   .MJXp-scr {font-family: MathJax_Script,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-frak {font-family: MathJax_Fraktur,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-sf {font-family: MathJax_SansSerif,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-cal {font-family: MathJax_Caligraphic,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-mono {font-family: MathJax_Typewriter,\'Times New Roman\',Times,STIXGeneral,serif}   .MJXp-largeop {font-size: 150%}   .MJXp-largeop.MJXp-int {vertical-align: -.2em}   .MJXp-math {display: inline-block; line-height: 1.2; text-indent: 0; font-family: \'Times New Roman\',Times,STIXGeneral,serif; white-space: nowrap; border-collapse: collapse}   .MJXp-display {display: block; text-align: center; margin: 1em 0}   .MJXp-math span {display: inline-block}   .MJXp-box {display: block!important; text-align: center}   .MJXp-box:after {content: " "}   .MJXp-rule {display: block!important; margin-top: .1em}   .MJXp-char {display: block!important}   .MJXp-mo {margin: 0 .15em}   .MJXp-mfrac {margin: 0 .125em; vertical-align: .25em}   .MJXp-denom {display: inline-table!important; width: 100%}   .MJXp-denom > * {display: table-row!important}   .MJXp-surd {vertical-align: top}   .MJXp-surd > * {display: block!important}   .MJXp-script-box > *  {display: table!important; height: 50%}   .MJXp-script-box > * > * {display: table-cell!important; vertical-align: top}   .MJXp-script-box > *:last-child > * {vertical-align: bottom}   .MJXp-script-box > * > * > * {display: block!important}   .MJXp-mphantom {visibility: hidden}   .MJXp-munderover {display: inline-table!important}   .MJXp-over {display: inline-block!important; text-align: center}   .MJXp-over > * {display: block!important}   .MJXp-munderover > * {display: table-row!important}   .MJXp-mtable {vertical-align: .25em; margin: 0 .125em}   .MJXp-mtable > * {display: inline-table!important; vertical-align: middle}   .MJXp-mtr {display: table-row!important}   .MJXp-mtd {display: table-cell!important; text-align: center; padding: .5em 0 0 .5em}   .MJXp-mtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-mlabeledtr {display: table-row!important}   .MJXp-mlabeledtr > .MJXp-mtd:first-child {padding-left: 0}   .MJXp-mlabeledtr:first-child > .MJXp-mtd {padding-top: 0}   .MJXp-merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MJXp-scale0 {-webkit-transform: scaleX(.0); -moz-transform: scaleX(.0); -ms-transform: scaleX(.0); -o-transform: scaleX(.0); transform: scaleX(.0)}   .MJXp-scale1 {-webkit-transform: scaleX(.1); -moz-transform: scaleX(.1); -ms-transform: scaleX(.1); -o-transform: scaleX(.1); transform: scaleX(.1)}   .MJXp-scale2 {-webkit-transform: scaleX(.2); -moz-transform: scaleX(.2); -ms-transform: scaleX(.2); -o-transform: scaleX(.2); transform: scaleX(.2)}   .MJXp-scale3 {-webkit-transform: scaleX(.3); -moz-transform: scaleX(.3); -ms-transform: scaleX(.3); -o-transform: scaleX(.3); transform: scaleX(.3)}   .MJXp-scale4 {-webkit-transform: scaleX(.4); -moz-transform: scaleX(.4); -ms-transform: scaleX(.4); -o-transform: scaleX(.4); transform: scaleX(.4)}   .MJXp-scale5 {-webkit-transform: scaleX(.5); -moz-transform: scaleX(.5); -ms-transform: scaleX(.5); -o-transform: scaleX(.5); transform: scaleX(.5)}   .MJXp-scale6 {-webkit-transform: scaleX(.6); -moz-transform: scaleX(.6); -ms-transform: scaleX(.6); -o-transform: scaleX(.6); transform: scaleX(.6)}   .MJXp-scale7 {-webkit-transform: scaleX(.7); -moz-transform: scaleX(.7); -ms-transform: scaleX(.7); -o-transform: scaleX(.7); transform: scaleX(.7)}   .MJXp-scale8 {-webkit-transform: scaleX(.8); -moz-transform: scaleX(.8); -ms-transform: scaleX(.8); -o-transform: scaleX(.8); transform: scaleX(.8)}   .MJXp-scale9 {-webkit-transform: scaleX(.9); -moz-transform: scaleX(.9); -ms-transform: scaleX(.9); -o-transform: scaleX(.9); transform: scaleX(.9)}   .MathJax_PHTML .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style><style type="text/css">.MathJax_Display {text-align: center; margin: 1em 0em; position: relative; display: block!important; text-indent: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; width: 100%}   .MathJax .merror {background-color: #FFFF88; color: #CC0000; border: 1px solid #CC0000; padding: 1px 3px; font-style: normal; font-size: 90%}   .MathJax .MJX-monospace {font-family: monospace}   .MathJax .MJX-sans-serif {font-family: sans-serif}   #MathJax_Tooltip {background-color: InfoBackground; color: InfoText; border: 1px solid black; box-shadow: 2px 2px 5px #AAAAAA; -webkit-box-shadow: 2px 2px 5px #AAAAAA; -moz-box-shadow: 2px 2px 5px #AAAAAA; -khtml-box-shadow: 2px 2px 5px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color=\'gray\', Positive=\'true\'); padding: 3px 4px; z-index: 401; position: absolute; left: 0; top: 0; width: auto; height: auto; display: none}   .MathJax {display: inline; font-style: normal; font-weight: normal; line-height: normal; font-size: 100%; font-size-adjust: none; text-indent: 0; text-align: left; text-transform: none; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; direction: ltr; max-width: none; max-height: none; min-width: 0; min-height: 0; border: 0; padding: 0; margin: 0}   .MathJax:focus, body :focus .MathJax {display: inline-table}   .MathJax.MathJax_FullWidth {text-align: center; display: table-cell!important; width: 10000em!important}   .MathJax img, .MathJax nobr, .MathJax a {border: 0; padding: 0; margin: 0; max-width: none; max-height: none; min-width: 0; min-height: 0; vertical-align: 0; line-height: normal; text-decoration: none}   img.MathJax_strut {border: 0!important; padding: 0!important; margin: 0!important; vertical-align: 0!important}   .MathJax span {display: inline; position: static; border: 0; padding: 0; margin: 0; vertical-align: 0; line-height: normal; text-decoration: none}   .MathJax nobr {white-space: nowrap!important}   .MathJax img {display: inline!important; float: none!important}   .MathJax * {transition: none; -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none}   .MathJax_Processing {visibility: hidden; position: fixed; width: 0; height: 0; overflow: hidden}   .MathJax_Processed {display: none!important}   .MathJax_ExBox {display: block!important; overflow: hidden; width: 1px; height: 60ex; min-height: 0; max-height: none}   .MathJax .MathJax_EmBox {display: block!important; overflow: hidden; width: 1px; height: 60em; min-height: 0; max-height: none}   .MathJax_LineBox {display: table!important}   .MathJax_LineBox span {display: table-cell!important; width: 10000em!important; min-width: 0; max-width: none; padding: 0; border: 0; margin: 0}   .MathJax .MathJax_HitBox {cursor: text; background: white; opacity: 0; filter: alpha(opacity=0)}   .MathJax .MathJax_HitBox * {filter: none; opacity: 1; background: transparent}   #MathJax_Tooltip * {filter: none; opacity: 1; background: transparent}   @font-face {font-family: MathJax_Main; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-bold; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Bold.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Bold.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Main-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Main-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Main-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Math-italic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Math-Italic.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Math-Italic.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Caligraphic; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Caligraphic-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Caligraphic-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size1; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size1-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size1-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size2; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size2-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size2-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size3; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size3-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size3-Regular.otf?V=2.7.1\') format(\'opentype\')} @font-face {font-family: MathJax_Size4; src: url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/woff/MathJax_Size4-Regular.woff?V=2.7.1\') format(\'woff\'), url(\'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/fonts/HTML-CSS/TeX/otf/MathJax_Size4-Regular.otf?V=2.7.1\') format(\'opentype\')} .MathJax .noError {vertical-align: ; font-size: 90%; text-align: left; color: black; padding: 1px 3px; border: 1px solid}   </style>';
                                var stylesheetval = '<style>span.inline-formula {display: inline-block;margin-right: 121px;}.FinalDiv{width:960px!important;}div.def-list{border-spacing: 1.12em}div.table{display: table}div > *:first-child{margin-top: 0em}div.row{display: table-row}div > *:first-child{margin-top: 0em}div.def-list div.cell{vertical-align: top;border-bottom: thin solid black;padding-bottom: 0.5em}div.cell{display: table-cell;padding-left: 0.25em;padding-right: 0.25em}.label{color:midnightblue!important} .deletion {display: inline;color: red;text-decoration: line-through;}.insertion {color: green;text-decoration: underline;}.historylinkview{display:none;} .normaltable {background-color: white;font-size: 90%;border: thin solid black;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.insertiontable {background-color: white;font-size: 90%;border: thin solid green;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.deletiontable {background-color: white;font-size: 90%;border: thin solid red;padding-left: 0.5em;padding-right: 0.5em;padding-top: 0.5em;padding-bottom: 0.5em;margin-top: 0.5em;margin-bottom: 0.5em;width: 95%;overflow:auto;}.panel{border-color: black;}</style>';
                                printContent = mathJaxCss+stylesheetval+showingHTML;
                                //debugger;
                                $.fancybox({
                                content: stylesheetval+mathJaxCss+showingHTML+'<hr><input type="button" style="background-color: #4CAF50; border: none; color: white;  padding: 5px 17px; text-align: center;  text-decoration: none;  display: inline-block; font-size: 16px;  margin: 4px 2px; cursor: pointer;" value="Print" onclick="printEQ()">',
                                beforeShow: function () {
                                //debugger
                                $('.fancybox-outer').addClass('fancybox-skin');
                                },
                                });
                            });
                            $(this).attr('href', currentHRF);
                        }
                        } else if( fig_href_id in figpanelC) {
                            $(this).attr('href', figpanelC[tablemarkwitout]+"_link");
                            $(this).attr('class', 'table_view_link');
                            $(this).bind( "click", function() {
                               var href=$(this).attr("href").replace("_link","");
                              $('#commentry_frame').contents().find("a[href='"+href+"']").simulateClick('click');
                              return false;
                                
                            });
                        }
                    } /* end for commente chapter content link href */
                    
                }
            });
            
            
            
            
            
            
        },3000);
        
    }

    this.iframeEvents = function () {

        $('.Page iframe').contents().find('book-part > .section').unbind('mouseup');
        $('.Page iframe').contents().find('book-part > .section,.table-wrap').mouseup(function (event) {
            $('.colorpicker').addClass('hide');
            $($(this).siblings()).removeClass(
                    'deselect_other_content');
            //debugger
            var frame = document.getElementById('page_frame');
            var frameWindow = frame && frame.contentWindow;
            var frameDocument = frameWindow && frameWindow.document;
            var fullString = frameDocument.getElementsByTagName("body")[0].textContent;

            if (frame.contentDocument) {
                var selected = frameWindow.getSelection();
                var selobj = window.getSelection();
                if (selected && selected.rangeCount > 0) {
                    var range = selected.getRangeAt(0);
                    var content = selected.toString();
                
                if (!$.trim(content).length) {

                    if (frameDocument.getSelection) {
                        if (frameDocument.getSelection().empty) { // Chrome
                            frameDocument.getSelection()
                                    .empty();
                        } /* else if (frameDocument.getSelection().removeAllRanges) { // Firefox
                         frameDocument.getSelection()
                         .removeAllRanges();
                         } */
                    } else if (frameDocument.selection) { // IE?
                        frameDocument.selection.empty();
                    }
                }
                // console.log(getSelectedText('page_frame'));
                if (thisTocObj.getSelectedText('page_frame') != ""
                        && $.trim(content).length) {
                    if ($(window).width() > 1020) {
                        $('.non_full_view .custom_tooltip')
                                .removeClass('hide')
                                .css(
                                        {
                                            "position": "absolute",
                                            "left": event.pageX
                                                    - 80
                                                    + ($('#toc .main_toc')
                                                            .width()),
                                            "top": event.clientY
                                                    + ($('#container .main_header')
                                                            .outerHeight())
                                        });
                        $('.full_size_page .custom_tooltip')
                                .removeClass('hide')
                                .css(
                                        {
                                            "position": "absolute",
                                            "left": event.pageX
                                                    - 80
                                                    + ($('#toc .main_toc')
                                                            .width()),
                                            "top": event.clientY
                                                    + ($('#container .main_header')
                                                            .outerHeight())
                                        });
                        $('.non_full_view .colorpicker')
                                .css(
                                        {
                                            "position": "absolute",
                                            "left": event.pageX
                                                    - 80
                                                    + ($('#toc .main_toc')
                                                            .width()),
                                            "top": event.clientY
                                                    + ($('#container .main_header')
                                                            .outerHeight())
                                                    - 20
                                        });
                        $('.full_size_page .colorpicker')
                                .css(
                                        {
                                            "position": "absolute",
                                            "left": event.pageX
                                                    - 80
                                                    + ($('#toc .main_toc')
                                                            .width()),
                                            "top": event.clientY
                                                    + ($('#container .main_header')
                                                            .outerHeight())
                                                    - 20
                                        });
                        $('.custom_tooltip').addClass(
                                'current_highlight');
                    }
                    thisTocObj.objIframeMouseEvent = event;
                    thisTocObj.objIframeMouse = this;

                } else {
                    // console.log("text un select");
                    $('.custom_tooltip').addClass('hide');
                    $('.colorpicker').addClass('hide');
                }
                var endOffset = range.endOffset;
                var startOffset = range.startOffset;
                elemParentNodeStart = range.startContainer;
                elemParentNodeEnd = range.endContainer;
                run = true;
                while (run) {
                    elemParentNodeStart = elemParentNodeStart.parentNode;
                    elemParentNodeEnd = elemParentNodeEnd.parentNode;
                    if ($.trim(elemParentNodeStart.id).length) {
                        var endNode = elemParentNodeEnd.id;
                        var nodeName = elemParentNodeEnd.nodeName;
                        var startNode = elemParentNodeStart.id;
                        run = false;
                    }
                }
            }
            }
            thisTocObj.SelectionData = {
                selected: selected,
                range: range,
                content: content,
                endNode: endNode,
                endOffset: endOffset,
                startNode: startNode,
                startOffset: startOffset,
                nodeName: nodeName
            }
        });

        if ($('#container').hasClass('font_120') == true) {
            $("iframe").contents().find('body').addClass("font_120_iframe");
            $("iframe").contents().find('body').css({
                'style': ''
            });
        } else {
            $("iframe").contents().find('body').css({
                'font-size': $('nav.navbar .zoom .present').text()
            });
        }
        
        
        
          var $div = $('#page_frame').contents().find(".table_view").click(function () {
             return false; });
                    //clickListener = jQuery._data($div[0], 'events').click[0];

                    //unbind all
                    $div.off('click');

                    //bind yours
                    $div.click(function () { 
                        var idvalue = $(this).parent().attr('id');
                        var linkValue = $(this).attr('href');;
                        var newID = idvalue.replace('.',"_");

                        var targetDivId = linkValue.slice( 1 );
                        var newtext = $('#page_frame').contents().find("#table_inner_"+newID).html();
                        
                        if (typeof newtext != 'undefined'){
                            $('#page_frame').contents().find("#"+targetDivId).find('.first').html(newtext);
                            $('#page_frame').contents().find('u').each(function(){
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
                                        
                                        
                                        
                                        //for highlighted start //////////////////////////////////////////////
                $('#page_frame').contents().find("[class^='hightlight_']").click(function () {
                    //this.localizationString();
                    //if(confirm("do you want to remove highLight")){
                    var $that = $(this), that = this;
                    t_ID=null;
                    t_ID= $($that.parents()[2]).attr('id');
                    bootbox.confirm(localizedStrings.highlite_popup_pannel.conform.alertmsg.deleteNote, function (result) {  
                        if (result) {
                            //debugger
                            var pid, secId, paraData;
                            var $parTag;
                            var chapterId = thisTocObj.lastChapter;
                            $that.parents().each(function () {
                                if ($(this).is('p')) {
                                    pid = $(this).attr('id');
                                    $parTag = $(this);
                                }
                                if ($(this).is('div') && $(this).hasClass('section')) {
                                    secId = $(this).attr('id');
                                }
                            });
                            removespan(that);
                            paraData = $parTag.html();
                            
                      if(secId==undefined){
                  
                var res = t_ID.replace("t", "s");
               var myarr = res.split("-");
               var myvar = myarr[0];
               secId=null;
               secId=myvar;
                     
                      var res1 = t_ID.replace("t", "table_inner_t"); 
                      var res2 = res1 .replace(".", "_");
                    //  chk_pid=true;
                    pid=null;
                    pid=res2;
                    
                }
                            
                            DataSet = {
                                paraId: pid,
                                sectionId: secId,
                                paraData: paraData,
                                chapterId: chapterId
                            }

                            objThis.deleteHighlight(DataSet);
                        } else {
                            $('#notes_popup .note_list_container .notes').removeClass("delete");
                        }
                        //}
                    });
                });
                //for highlighted end //////////////////////////////////////////////
                     
                            
                            
                            
                            
                            
                            
                            
                                        
                        }
                    });

                    //$div.click(clickListener.handler);

                    //test out everyting
                    $div.triggerHandler('click');   

    }

    this.manageCustomScroll = function () {
        // $(".main_toc").mCustomScrollbar();
    }

    this.getSelectedText = function (frameId) {
        var frame = document.getElementById(frameId);
        var frameWindow = frame && frame.contentWindow;
        var frameDocument = frameWindow && frameWindow.document;
        if (frameDocument) {
            if (frameDocument.getSelection) {
                // Most browsers
                return String(frameDocument.getSelection());
            } else if (frameDocument.selection) {
                // Internet Explorer 8 and below
                return frameDocument.selection.createRange().text;
            } else if (frameWindow.getSelection) {
                // Safari 3
                return String(frameWindow.getSelection());
            }
        }
        return '';
    }

    this.loadSectionNavigation = function (chapSrc) {
        chapId = this.getChapIdWithChapSrc(chapSrc);
        $.each(this.getFirstLevelSection()[0], function (key, value) {
            if (chapId == value.chapId) {
                $('nav.navbar .section_no .present').val(value.secLabel);
                return false;
            }
        });
    }

    this.loadPageTitle = function () {
        $.each(this.getChaptersList(), function (key, value) {
            if (value.chapSrc == thisTocObj.lastChapter) {
                $('.content_container .page_article .title').html(
                        "Chapter" + " " + value.chapSrc.replace("ch", "") + " "
                        + value.chapTitle);
            }
        });
    }
    /*------------------------------------------For Loading History Title------------------------*/
    this.loadHistoryTitle = function (oldVal) {
        isbn = CONFIG.objModule['commonInfo'].controler.getISBN();
        volume = CONFIG.objModule['commonInfo'].controler.getVolumeNo();
        $.each(this.getChaptersList(), function (key, value) {
            if (value.chapSrc == oldVal) {
                $('.content_container .page_article .title').html(
                        "Chapter" + " " + value.chapSrc.replace("ch", "") + " "
                        + value.chapTitle);
            }
        });
    }
    /*-------------------------------------------------End---------------------------------------*/
    /*-------------------------------------------------Function For Checking File Exists Or Not------------------*/
    this.checkFileUrl = function (url) {
        if (url) {
            var last_part = url.substring(url.lastIndexOf('/'));
            if(last_part.indexOf("_") > -1){
                var ch_name = last_part.split("_");
                var new_part = ch_name[0]+".html";
                url = url.replace(last_part,new_part);
            }

            var req = new XMLHttpRequest();
            req.open('GET', url, false);
            req.send();
            return req.status == 200;
        } else {
            return false;
        }
    }
    /*------------------------------------------------------------------End--------------------------------------*/
    /*-------------------------------------------------Function For getting File Name Before _------------------*/
    this.getFirstUrl = function (url) {
        var n = url.indexOf('_');
        url = url.substring(0, n != -1 ? n : url.length);
        return url;
    }
    /*------------------------------------------------------------------End--------------------------------------*/
    this.loadChapter = function (chap) {// alert(chap)

        if(chap == 0){
            return false;
        }
        // if(chap.indexOf("_") > -1){
        //     var ch_name = chap.split("_");
        //     chap = ch_name[0];
        // }

        this.loadSectionNavigation(chap);
        chaptype = this.getChapContentTypeWithChapSrc(chap);
        paneltype = this.getChapPanelTypeWithChapSrc(chap);
        lastChapterTemp = 0;
        chapTemp = 1;
        if (this.lastChapter != '') {
            chapTemp = chap.replace(this.commentryFilePrefix[chaptype].commentry, '');
            lastChapterTemp = this.lastChapter.replace(this.commentryFilePrefix[chaptype].commentry, '');
            chapTemp = chapTemp.replace(this.commentryFilePrefix[chaptype].page, '')
            lastChapterTemp = lastChapterTemp.replace(this.commentryFilePrefix[chaptype].page, '');
        }

        if (lastChapterTemp == chapTemp) {
            $("#page_frame").contents().find('html,body').animate({
                'scrollTop': 0
            }, 'slow');
            $("#commentry_frame").contents().find('html,body').animate({
                'scrollTop': 0
            }, 'slow');
            return true;
        }

        this.lastChapter = chap;
        this.lastPanelType = paneltype;
        this.loadPageTitle();
        if (paneltype == "PAGES") {
            commentryChap = chap.replace(
                    this.commentryFilePrefix[chaptype].page,
                    this.commentryFilePrefix[chaptype].commentry)
        } else {
            commentryChap = chap;
            chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
                    this.commentryFilePrefix[chaptype].page);
        }

        this.lastPageChapter = chap;
        this.lastCommChapter = commentryChap;

        this.loadCommentary(commentryChap);
        checkFileStatus = this.checkFileUrl(this.chapterPath + chap
                + this.fileExt);

        chap = this.chapterPath + chap;
        newVal = CONFIG.bookPath + '/blank';
        chapWithPath = checkFileStatus == true ? chap : newVal;
        $(".Page iframe").attr("src", chapWithPath + this.fileExt);
        $('.Page iframe').unbind('load');
        $('.Page iframe').load(
                function () {
                    thisTocObj.goToSection(0, 0);
                    thisTocObj.iframeEvents();
                    $('.Page iframe').contents().find('book-part > .section')
                            .bind(
                                    'mousedown',
                                    function (event) {
                                        $($(this).siblings()).addClass(
                                                'deselect_other_content');
                                    });
                    /*--------------------------Code for Unit Toggling--------------------------*/
                    selected_Unit = $('select[name=unit_toogling]').val();
                    thisTocObj.loadToggling(selected_Unit);
                    /*----------------------------------End--------------------------------------*/
                });
        if (objModule.arrModule.highlight.active) {
            CONFIG.objModule["highlight"].controler
                    .getHighlightText(this.lastChapter);
            CONFIG.objModule["notes_popup"].controler.showAllNotes();
            CONFIG.objModule["bookmark"].controler.showAllBookmark();
        }

        //on chapter loading we are again checking
        $('#page_frame').contents().find(".section").each(function () {
            var idvalue = $(this).attr('id');
            var lenghofstring = idvalue.length;
            var res = idvalue.charAt((lenghofstring - 1))
            if (res !== 'v') {
                //debugger;
                var withVIdValue = idvalue + "v";
                if (historyarray.indexOf(withVIdValue) > -1) {
                    $(this).css('border-left', ' thick solid grey');
                    $(this).css('padding-left', '10px');

                }
            }
        });
    }
    /*-----------------------------------------------For Diffrent Edition Book--------------------------------*/
    /*------------------------------------------------------------------End--------------------------------------*/
    this.loadOriginalChapter = function (chap) {
        this.loadSectionNavigation(chap);
        chaptype = this.getChapContentTypeWithChapSrc(chap);
        paneltype = this.getChapPanelTypeWithChapSrc(chap);
        lastChapterTemp = 0;
        chapTemp = 1;
        if (this.lastChapter != '') {
            chapTemp = chap.replace(
                    this.commentryFilePrefix[chaptype].commentry, '');
            lastChapterTemp = this.lastChapter.replace(
                    this.commentryFilePrefix[chaptype].commentry, '');
            chapTemp = chapTemp.replace(
                    this.commentryFilePrefix[chaptype].page, '')
            lastChapterTemp = lastChapterTemp.replace(
                    this.commentryFilePrefix[chaptype].page, '');
        }
        this.lastChapter = chap;
        this.lastPanelType = paneltype;
        this.loadPageTitle();
        if (paneltype == "PAGES") {
            commentryChap = chap.replace(
                    this.commentryFilePrefix[chaptype].page,
                    this.commentryFilePrefix[chaptype].commentry)
        } else {
            commentryChap = chap;
            chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
                    this.commentryFilePrefix[chaptype].page);
        }
        this.lastPageChapter = chap;
        this.lastCommChapter = commentryChap;
        this.loadCommentary(commentryChap);
        checkFileStatus = this.checkFileUrl(this.chapterPath + chap
                + this.fileExt);
        chap = this.chapterPath + chap;
        newVal = CONFIG.bookPath + '/blank';
        chapWithPath = checkFileStatus == true ? chap : newVal;
        $(".Page iframe").attr("src", chapWithPath + this.fileExt);
        $('.Page iframe').unbind('load');
        $('.Page iframe').load(
                function () {
                    thisTocObj.goToSection(0, 0);
                    thisTocObj.iframeEvents();
                    $('.Page iframe').contents().find('book-part > .section')
                            .bind(
                                    'mousedown',
                                    function (event) {
                                        $($(this).siblings()).addClass(
                                                'deselect_other_content');
                                    });
                    /*--------------------------Code for Unit Toggling--------------------------*/
                    selected_Unit = $('select[name=unit_toogling]').val();
                    thisTocObj.loadToggling(selected_Unit);
                    /*----------------------------------End--------------------------------------*/
                });
        if (objModule.arrModule.highlight.active) {
            //alert(this.lastCommentary);
            CONFIG.objModule["highlight"].controler
                    .getHighlightText(this.lastChapter);
        }
    }
    /*--------------------------------------------------------End---------------------------------------------*/
    /*------------------------------Method For Loading History Dynamic Contents Same Edition-------------------*/
    this.loadHistoryChapter = function (chap, oldVal, section) {// alert(chap)
        //debugger;
        var current_chap_url = $("#page_frame").attr("src");

        if(chap.indexOf("_") > -1){
            var ch_name = chap.split("_");
            chap = ch_name[0];
        }

        if(current_chap_url.indexOf(chap) > -1){
            return false;
        }

        // alert('From Load History'+section);
        //debugger;
        this.loadSectionNavigation(chap);
        chaptype = this.getChapContentTypeWithChapSrc(chap);
        chaptype = chaptype != '' ? chaptype : 'CONTENT';
        paneltype = this.getChapPanelTypeWithChapSrc(oldVal);
        // alert(paneltype);
        lastChapterTemp = 0;
        chapTemp = 1;
        if (this.lastChapter != '') {
            chapTemp = chap.replace(
                    this.commentryFilePrefix[chaptype].commentry, '');
            lastChapterTemp = this.lastChapter.replace(
                    this.commentryFilePrefix[chaptype].commentry, '');
            chapTemp = chapTemp.replace(
                    this.commentryFilePrefix[chaptype].page, '')
            lastChapterTemp = lastChapterTemp.replace(
                    this.commentryFilePrefix[chaptype].page, '');
        }

        if (lastChapterTemp == chapTemp) {
            $("#page_frame").contents().find('html,body').animate({
                'scrollTop': 0
            }, 'slow');
            $("#commentry_frame").contents().find('html,body').animate({
                'scrollTop': 0
            }, 'slow');
            return true;
        }

        this.lastChapter = chap;
        this.lastPanelType = paneltype;
        this.loadHistoryTitle(oldVal);
        if (paneltype == "PAGES") {
            commentryChap = chap.replace(
                    this.commentryFilePrefix[chaptype].page,
                    this.commentryFilePrefix[chaptype].commentry)
        } else {
            commentryChap = chap;
            chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
                    this.commentryFilePrefix[chaptype].page);
        }
        this.lastPageChapter = chap;
        this.lastCommChapter = commentryChap;

        stat = this.loadHistoryCommentary(commentryChap);
        checkFileStatus = this.checkFileUrl(this.chapterPath + chap
                + this.fileExt);
        newVal = this.getFirstUrl(chap);
        chap = checkFileStatus == true ? chap : newVal;
        $(".Page iframe").attr("src", this.chapterPath + chap + this.fileExt);
        $('.Page iframe').unbind('load');
        $('.Page iframe').load(
                function () {
                    thisTocObj.goToSection(section, chap);
                    thisTocObj.iframeEvents();
                    $('.Page iframe').contents().find('book-part > .section')
                            .bind(
                                    'mousedown',
                                    function (event) {
                                        $($(this).siblings()).addClass(
                                                'deselect_other_content');
                                    });
                });
        if (objModule.arrModule.highlight.active) {
            CONFIG.objModule["highlight"].controler
                    .getHighlightText(this.lastChapter);
        }
    }
    /*-----------------------------------------------End------------------------------------------*/
    /*------------------------------Method For Loading History Dynamic Contents Different Edition-------------------*/
    this.loadHistoryChapterDiff = function (history_diff_version, chap, oldVal, section) { // alert(chap)
        // alert('From Load History'+section);
        //debugger;
        this.loadSectionNavigation(chap);
        chaptype = this.getChapContentTypeWithChapSrc(chap);
        chaptype = chaptype != '' ? chaptype : 'CONTENT';
        paneltype = this.getChapPanelTypeWithChapSrc(oldVal);
        // alert(paneltype);
        lastChapterTemp = 0;
        chapTemp = 1;
        if (this.lastChapter != '') {
            chapTemp = chap.replace(
                    this.commentryFilePrefix[chaptype].commentry, '');
            lastChapterTemp = this.lastChapter.replace(
                    this.commentryFilePrefix[chaptype].commentry, '');
            chapTemp = chapTemp.replace(
                    this.commentryFilePrefix[chaptype].page, '')
            lastChapterTemp = lastChapterTemp.replace(
                    this.commentryFilePrefix[chaptype].page, '');
        }
        /*    if (lastChapterTemp == chapTemp) {
         $("#page_frame").contents().find('html,body').animate({
         'scrollTop' : 0
         }, 'slow');
         $("#commentry_frame").contents().find('html,body').animate({
         'scrollTop' : 0
         }, 'slow');
         return true;
         }
         */
        this.lastChapter = chap;
        this.lastPanelType = paneltype;
        this.loadHistoryTitle(oldVal);
        if (paneltype == "PAGES") {
            commentryChap = chap.replace(
                    this.commentryFilePrefix[chaptype].page,
                    this.commentryFilePrefix[chaptype].commentry)
        } else {
            commentryChap = chap;
            chap = chap.replace(this.commentryFilePrefix[chaptype].commentry,
                    this.commentryFilePrefix[chaptype].page);
        }
        this.lastPageChapter = chap;
        this.lastCommChapter = commentryChap;
        // this.lastCommentary=this.lastCommChapter;
        stat = this.loadHistoryCommentaryDiff(commentryChap);
        checkFileStatus = this.checkFileUrl(this.historyPagePath + history_diff_version + '/' + chap
                + this.fileExt);
        //alert('From Check file Status'+checkFileStatus);
        newVal = this.getFirstUrl(chap);
        chap = checkFileStatus == true ? chap : newVal;
        $(".Page iframe").attr("src", this.historyPagePath + history_diff_version + '/' + chap + this.fileExt);
        $('.Page iframe').unbind('load');
        $('.Page iframe').load(
                function () {
                    thisTocObj.goToSection(section, chap);
                    thisTocObj.iframeEvents();
                    $('.Page iframe').contents().find('book-part > .section')
                            .bind(
                                    'mousedown',
                                    function (event) {
                                        $($(this).siblings()).addClass('deselect_other_content');
                                    });

                    //debugger
                    var newresponse = '';

                    //check for all chapter or single chapter
//                                                            $('#history_popup input').on('change', function() {
//                                                                //debugger;
//                                                                var selectedvalue = $("input[name='history_rdo_btn']:checked").val();
//                                                                if(selectedvalue = 'all_chapter'){
//                                                                    //history_diff_version
//                                                                    //ajax for get all list
//                                                                    $.ajax({
//                                                                            type : "POST",
//                                                                            url : CONFIG.webServicePath
//                                                                                            + "Book_library/GetDataForAllChapter",
//                                                                            data : {
//                                                                                    direcotryname : history_diff_version
//                                                                            },
//                                                                            async : false,
//                                                                            success : function(text) {
//                                                                                    response = text;
//                                                                                    // alert(response);
//                                                                            }
//                                                                    });
//                                                                }
//                                                            });


                    var alldelinstag = $("#page_frame").contents().find("[id^='chanes_']");
                    for (totalid = 0; totalid < alldelinstag.length; totalid++) {
                        var stringvalue = alldelinstag[totalid];
                        newresponse = newresponse + '<div class="row" onclick="gotoPage(this)"><div class=" date" >' + chap.toUpperCase() + '</div><div style="cursor: pointer; cursor: hand;">' + stringvalue.outerHTML + '</div></div>';
                    }
                    /*$.each( alldelinstag, function( indexDom, valueDom ){
                     //newresponse = newresponse+valueDom;
                     newresponse=newresponse+'<div class="row"><div class="pull-right date"></div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">'+chap+'</div><div class="h_result_updated_diff" style="cursor: pointer; cursor: hand;" version="1" chapter_no="2" section_no="2">' +valueDom.innerHTML+ '</div></div>';  
                     });*/
                    //debugger;
                    if (newresponse != '')
                        $('#container #history_popup .panel-data').html(newresponse);
                    else
                        $('#container #history_popup .panel-data').html("No results");


                });
        if (objModule.arrModule.highlight.active) {
            CONFIG.objModule["highlight"].controler
                    .getHighlightText(this.lastChapter);
        }
    }
    /*-----------------------------------------------End------------------------------------------*/
    this.goToSection = function (secNo, chapId) {
        if (secNo == 0) {
            secNo = this.lastSec;
        }
        if (chapId == 0) {
            chapId = this.lastChapter;
        }
        section_type = "";
        content_type = "";
        toc_type = "";
        if (typeof (arguments[2]) != "undefined") {
            section_type = arguments[2];
            content_type = arguments[3];
            toc_type = arguments[4];
        }

        if (secNo != 0)
            this.lastSec = secNo;

        if (this.lastSec == 0)
            return true;
        var pos = chapId.indexOf("chc");
        // alert(pos);
        if (pos >= 0) {
            if (this.lastCommentary != chapId && chapId != 0) {
                if (section_type != "Figure" && section_type != "Table"
                        && section_type != "References") {
                    chapId = this.getChapIdWithSecId(secNo);
                    chapSrc = this.getChapSrcWithChapId(chapId);
                } else {
                    chapSrc = chapId;
                }
                this.loadChapter(chapSrc)
                secNo_nav_top = secNo.replace("s", "");
                $('nav.navbar .section_no .present').val(secNo_nav_top);
                return true;
            }

        } else {
            if (this.lastChapter != chapId && chapId != 0) {
                if (section_type != "Figure" && section_type != "Table"
                        && section_type != "References") {
                    chapId = this.getChapIdWithSecId(secNo);
                    chapSrc = this.getChapSrcWithChapId(chapId);
                } else {
                    chapSrc = chapId;
                }
                //this.distroyFrames();
                this.loadChapter(chapSrc)

                secNo_nav_top = secNo.replace("s", "");
                $('nav.navbar .section_no .present').val(secNo_nav_top);
                return true;
            }
        }
        secNo = this.lastSec.replace(/\./gi, "\\.");

        if (section_type == "Section" && content_type == "PAGES") {
            comNo = secNo.replace("s", "sc");
        } else if (section_type == "Section" && content_type == "COMMENTARY") {
            comNo = secNo;
            secNo = secNo.replace("sc", "s");
        } else if (section_type == "Table" && content_type == "PAGES") {
            comNo = secNo.replace("t", "tc");
        } else if (section_type == "Table" && content_type == "COMMENTARY") {
            comNo = secNo;
            secNo = secNo.replace("tc", "t");
        } else if (section_type == "Figure" && content_type == "PAGES") {
            comNo = secNo.replace("f", "fc");
        } else if (section_type == "Figure" && content_type == "COMMENTARY") {
            comNo = secNo;
            secNo = secNo.replace("fc", "f");
        } else if (section_type == "References" && content_type == "PAGES") {
            comNo = secNo.replace("c", "cc");
        } else if (section_type == "References" && content_type == "COMMENTARY") {
            comNo = secNo;
            secNo = secNo.replace("cc", "c");
        } else {
            if (secNo != "" && secNo.indexOf('sc') > -1) {
                comNo = secNo;
            } else {
                comNo = secNo.replace("s", "sc");
            }
        }

        // alert(secNo+"-----------"+comNo)
        if ($("#page_frame").contents().find('html,body').find('.section').children('#' + secNo).length > 0) {
            var topGo = 0, $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo);
            if (this.hasOwnProperty("referID") && this.referID.hasOwnProperty("noteId") && this.referID.noteId != "") {
                $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo).find('u[newhigh_id="' + this.referID.noteId + '"]');
                topGo = 100;
                this.referID.noteId = '';
            } else if (this.hasOwnProperty("referID") && this.referID.hasOwnProperty("bookmarkId") && this.referID.bookmarkId != "") {
                $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo).find('mark[newhighbook_id="' + this.referID.bookmarkId + '"]');
                this.referID.bookmarkId = '';
                topGo = 100;
            }
            if ($elementGoto.length < 1) {
                topGo = 0, $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo);
            }
            $("#page_frame").contents().find('html,body').animate({'scrollTop': $elementGoto.position().top - topGo}, 'slow');
        }
        if ($("#commentry_frame").contents().find('html,body').find('.section').children('#' + comNo).length > 0) {
            var topGo = 0, $elementGoto = $("#commentry_frame").contents().find('html,body').find('.section').children('#' + comNo);
            if (this.hasOwnProperty("referID") && this.referID.hasOwnProperty("noteId") && this.referID.noteId != "") {
                $elementGoto = $("#commentry_frame").contents().find('html,body').find('.section').children('#' + comNo).find('u[newhigh_id="' + this.referID.noteId + '"]');
                topGo = 100;
                this.referID.noteId = '';
            } else if (this.hasOwnProperty("referID") && this.referID.hasOwnProperty("bookmarkId") && this.referID.bookmarkId != "") {
                $elementGoto = $("#commentry_frame").contents().find('html,body').find('.section').children('#' + comNo).find('mark[newhighbook_id="' + this.referID.bookmarkId + '"]');
                this.referID.bookmarkId = '';
                topGo = 100;
            }
            if ($elementGoto.length < 1) {
                topGo = 0;
                $elementGoto = $("#commentry_frame").contents().find('html,body').find('.section').children('#' + comNo);
            }
            $("#commentry_frame").contents().find('html,body').animate({'scrollTop': $elementGoto.position().top - topGo}, 'slow');
        }

        secNo = this.lastSec.replace(/\\/gi, "");

        CONFIG.objModule["search"].controler.highlightText(secNo);
    }

    //only for got to section not commentry
    this.goToOnlySection = function (secNo, chapId) {
        //debugger
        if (secNo == 0) {
            secNo = this.lastSec;
        }
        if (chapId == 0) {
            chapId = this.lastChapter;
        }
        section_type = "";
        content_type = "";
        toc_type = "";
        if (typeof (arguments[2]) != "undefined") {
            section_type = arguments[2];
            content_type = arguments[3];
            toc_type = arguments[4];
        }

        if (secNo != 0)
            this.lastSec = secNo;

        if (this.lastSec == 0)
            return true;

        if (this.lastChapter != chapId && chapId != 0) {
            if (section_type != "Figure" && section_type != "Table"
                    && section_type != "References") {
                chapId = this.getChapIdWithSecId(secNo);
                chapSrc = this.getChapSrcWithChapId(chapId);
            } else {
                chapSrc = chapId;
            }
            this.distroyFrames();
            this.loadChapter(chapSrc)

            secNo_nav_top = secNo.replace("s", "");
            $('nav.navbar .section_no .present').val(secNo_nav_top);
            return true;
        }

        secNo = this.lastSec.replace(/\./gi, "\\.");

        if (section_type == "Section" && content_type == "PAGES") {
            comNo = secNo.replace("s", "sc");
        } else if (section_type == "Table" && content_type == "PAGES") {
            comNo = secNo.replace("t", "tc");

        } else if (section_type == "Figure" && content_type == "PAGES") {
            comNo = secNo.replace("f", "fc");
        } else if (section_type == "References" && content_type == "PAGES") {
            comNo = secNo.replace("c", "cc");
        } else if (section_type == "References") {
            comNo = secNo;
            secNo = secNo.replace("cc", "c");
        } else {
            if (secNo != "" && secNo.indexOf('sc') > -1) {
                comNo = secNo;
            } else {
                comNo = secNo.replace("s", "sc");
            }
        }

        // alert(secNo+"-----------"+comNo)
        if ($("#page_frame").contents().find('html,body').find('.section').children('#' + secNo).length > 0) {
            var topGo = 0, $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo);
            if (this.hasOwnProperty("referID") && this.referID.hasOwnProperty("noteId") && this.referID.noteId != "") {
                $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo).find('u[newhigh_id="' + this.referID.noteId + '"]');
                topGo = 100;
                this.referID.noteId = '';
            } else if (this.hasOwnProperty("referID") && this.referID.hasOwnProperty("bookmarkId") && this.referID.bookmarkId != "") {  
                $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo).find('mark[newhighbook_id="' + this.referID.bookmarkId + '"]');
                this.referID.bookmarkId = '';
                topGo = 100;
            }
            if ($elementGoto.length < 1) {
                topGo = 0, $elementGoto = $("#page_frame").contents().find('html,body').find('.section').children('#' + secNo);
            }
            $("#page_frame").contents().find('html,body').animate({'scrollTop': $elementGoto.position().top - topGo}, 'slow');
        }
        secNo = this.lastSec.replace(/\\/gi, "");

        CONFIG.objModule["search"].controler.highlightText(secNo);
    }


    this.getChapIdWithSecId = function (secId) {
        chapId = 0;
        $.each(thisTocObj.arrRawSection, function (key, value) {
            if (value.secSrc == secId) {
                chapId = value.chapId;
            }
        });
        return chapId;
    }

    this.getChapIdWithChapSrc = function (chapSrc) {
        chapId = 0;
        $.each(thisTocObj.arrChapters, function (key, value) {
            if (value.chapSrc == chapSrc) {
                chapId = value.chapId;
            }
        });
        return chapId;
    }

    this.getChapSrcWithChapId = function (chapId) {
        chapSrc = 0;
        $.each(thisTocObj.arrChapters, function (key, value) {
            if (value.chapId == chapId) {
                chapSrc = value.chapSrc;
            }
        });
        return chapSrc;
    }

    this.getChapContentTypeWithChapId = function (chapId) {
        contentType = '';
        $.each(thisTocObj.arrChapters, function (key, value) {
            if (value.chapId == chapId) {
                contentType = value.contenttype;
            }
        });
        return contentType;
    }

    this.getChapPanelTypeWithChapId = function (secId) {
        panelType = '';
        $.each(thisTocObj.arrChapters, function (key, value) {
            if (value.chapId == chapId) {
                panelType = value.chapPaneltype;
            }
        });
        return panelType;
    }

    this.getChapContentTypeWithChapSrc = function (chapSrc) {
        contentType = '';
        $.each(thisTocObj.arrChapters, function (key, value) {
            if (value.chapSrc == chapSrc) {
                contentType = value.contenttype;
            }
        });
        return contentType;
    }

    this.getChapPanelTypeWithChapSrc = function (chapSrc) {
        panelType = '';
        $.each(thisTocObj.arrChapters, function (key, value) {
            if (value.chapSrc == chapSrc) {
                panelType = value.chapPaneltype;
            }
        });
        return panelType;
    }

    this.loadCommentary = function (comm) {
        this.lastCommentary = comm;
        if (typeof (arguments[1]) != "undefined")
            secNo1 = arguments[1];
        else
            secNo1 = false;
        checkCommentaryStatus = this.checkFileUrl(this.commentaryPath + comm
                + this.fileExt);
        //alert(checkCommentaryStatus);
        commVal = this.commentaryPath + comm;
        //alert(commVal+this.fileExt);
        newComVal = CONFIG.bookPath + '/blank';
        commWithPath = checkCommentaryStatus == true ? commVal : newComVal;
        if (this.commentryFilePrefix)
            $(".Commentry iframe").attr("src", commWithPath + this.fileExt);
        $(".Commentry iframe").load(function () {
            thisTocObj.iframeEvents();
            thisTocObj.iframeEventss();
            selected_Unit = $('select[name=unit_toogling]').val();
            thisTocObj.loadTogglingCommentary(selected_Unit);

        });
        return true;
    }
    /*--------------------------------------------For Loading Commentary For History-------------------*/
    this.loadHistoryCommentary = function (comm) {
        var current_comm_url = $("#commentry_frame").attr("src");

        if(comm.indexOf("_") > -1){
            var ch_name = comm.split("_");
            comm = ch_name[0];
        }

        if(current_comm_url.indexOf(comm) > -1){
            return false;
        }

        this.lastCommentary = comm;
        if (typeof (arguments[1]) != "undefined")
            secNo1 = arguments[1];
        else
            secNo1 = false;
        /*---------------------------------For Checking Whether File Exists or Not-----------------------*/
        checkFileStatus = this.checkFileUrl(this.commentaryPath + comm
                + this.fileExt);
        newVal = this.getFirstUrl(comm);
        comm = checkFileStatus == true ? comm : newVal;
        commFileURL = this.commentaryPath + comm;
        checkCom = this.checkFileUrl(this.commentaryPath + comm + this.fileExt);
        coomPath = CONFIG.bookPath + '/blank';
        comm = checkCom == true ? commFileURL : coomPath;
        /*----------------------------------------------End----------------------------------------------*/
        if (this.commentryFilePrefix)
            $(".Commentry iframe").attr("src", comm + this.fileExt);
        $(".Commentry iframe").load(function () {
            thisTocObj.iframeEvents();
        });
        return true;
    }
    /*-------------------------------------------------------End---------------------------------------*/
    /*--------------------------------------------For Loading Commentary For History Different Edition-------------------*/
    this.loadHistoryCommentaryDiff = function (comm) {
       var current_comm_url = $("#commentry_frame").attr("src");

        if(comm.indexOf("_") > -1){
            var ch_name = comm.split("_");
            comm = ch_name[0];
        }

        if(current_comm_url.indexOf(comm) > -1){
            return false;
        }

        this.lastCommentary = comm;
        if (typeof (arguments[1]) != "undefined")
            secNo1 = arguments[1];
        else
            secNo1 = false;
        /*---------------------------------For Checking Whether File Exists or Not-----------------------*/
        checkFileStatus = this.checkFileUrl(this.historyPagePath + history_diff_version + '/' + comm
                + this.fileExt);
        newVal = this.getFirstUrl(comm);
        comm = checkFileStatus == true ? comm : newVal;
        commFileURL = this.historyPagePath + history_diff_version + '/' + comm;
        checkCom = this.checkFileUrl(this.historyPagePath + history_diff_version + '/' + comm + this.fileExt);
        coomPath = CONFIG.bookPath + '/blank';
        comm = checkCom == true ? commFileURL : coomPath;
        /*----------------------------------------------End----------------------------------------------*/
        if (this.commentryFilePrefix)
            $(".Commentry iframe").attr("src", comm + this.fileExt);
        $(".Commentry iframe").load(function () {
            thisTocObj.iframeEvents();
        });
        return true;
    }
    /*-------------------------------------------------------End---------------------------------------*/
    this.setNavigationList = function (dbResultset) {
        thisTocObj.arrNavigation = dbResultset[0];
        thisTocObj.setArrSection(thisTocObj.arrNavigation);
    }

    this.setArrSection = function (arrNavigation) {
        $('nav.navbar .section_no .present').val(arrNavigation[0].m_seclabel);
        for (i = 0; i < arrNavigation.length; i++) {
            thisTocObj.arrNavigationList[i] = arrNavigation[i].m_seclabel;
            thisTocObj.arrNavigationListLink[i] = arrNavigation[i].m_seclinkpage;
        }
    }

    this.section_change = function (temp) {
        //debugger;
        chapId = 0;
        current_sec = $('nav.navbar .section_no .present').val();
        current_pos = this.arrNavigationList.indexOf(current_sec);
        if ((temp == "move_forward")
                && (current_pos < (this.arrNavigation.length - 1))) {
            current_pos++;
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos++;
            }

        } else if ((temp == "move_backward") && (current_pos > 0)) {
            current_pos--;

            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
            if (thisTocObj.arrNavigationListLink[current_pos].indexOf("v") > 1) {
                //current_pos+2;
                current_pos--;
            }
        } else if (temp == "move_current_position") {
            current_pos;
        } else if (current_pos == -1 || current_pos == "undefined"
                || current_pos == " ") {
        }
        $('nav.navbar .section_no .present').val(
                this.arrNavigationList[current_pos]);

        if (current_pos == -1) {
            bootbox.alert(localizedStrings.TOC.error.alertmsg.incorrectSecNo);
            $('nav.navbar .section_no .present').val(current_sec);
        } else {
            chapId = thisTocObj
                    .getChapIdWithSecId(thisTocObj.arrNavigationListLink[current_pos]);
            //thisTocObj.goToSection(thisTocObj.arrNavigationListLink[current_pos], thisTocObj.getChapSrcWithChapId(chapId));
            thisTocObj.goToOnlySection(thisTocObj.arrNavigationListLink[current_pos], thisTocObj.getChapSrcWithChapId(chapId));
        }
    }
    /*----------------------------Functions For Unit Toggling------------------------------------*/
    this.loadToggling = function (selected_Unit) {
        var f = $('#page_frame')
        if (selected_Unit == 'customary') {
            f.contents().find('.si').hide();
            f.contents().find('.toggle').hide();
            f.contents().find('.customary').show();
        }
        if (selected_Unit == 'si') {
            f.contents().find('.customary').hide();
            f.contents().find('.toggle').hide();
            f.contents().find('.si').show();
        }
        if (selected_Unit == 'both') {
            f.contents().find('.customary').show();
            f.contents().find('.toggle').show();
            f.contents().find('.si').show();
        }
    }
    this.loadTogglingCommentary = function (selected_Unit) {
        var f = $('#commentry_frame')
        if (selected_Unit == 'customary') {
            f.contents().find('.si').hide();
            f.contents().find('.toggle').hide();
            f.contents().find('.customary').show();
        }
        if (selected_Unit == 'si') {
            f.contents().find('.customary').hide();
            f.contents().find('.toggle').hide();
            f.contents().find('.si').show();
        }
        if (selected_Unit == 'both') {
            f.contents().find('.customary').show();
            f.contents().find('.toggle').show();
            f.contents().find('.si').show();
        }
    }
}

function gotoPageHistory(obj) {
    //debugger
    var pageName = $(obj).find(".data").text().toLowerCase() + ".html"
    $(divname).contents().each(function () {
        if (pageName.trim() == $(this).attr("data-set").trim()) {
            var pageContents = $(this).html();
            $("#page_frame").contents().find("body")[0].innerHTML = pageContents;
            gotoPage(obj);
        }
    });
    $("#page_frame").contents().find("body")
    $("#chapertHistoryAll").length;
}
function gotoPage(obj) {
    //debugger
    var attID = $(obj).find("[id^='chanes_']").attr("id");
    var $frameElm = $("#page_frame").contents().find("#" + attID);
    $("#page_frame").contents().find("body").animate({scrollTop: $frameElm.offset().top}, 300);
    //$("#page_frame").contents().find("body").scrollTop($frameElm.offset().top);
}
/*
function gotoPageNew(obj) {  debugger;
    var iframe = $('#page_frame').contents();
    var attID = $(obj).find("[id^='chanes_']").attr("id");
    var $frameElm = $("#page_frame").contents().find("#" + attID);
    iframe.scrollTop($frameElm.offset().top);
}
*/
function gotoCommPageNew(obj) {  debugger;
    var iframe = $('#commentry_frame').contents();
    var attID = $(obj).find("[id^='chanes_']").attr("id");
    var $frameElm = $("#commentry_frame").contents().find("#" + attID);
    iframe.scrollTop($frameElm.offset().top);
}

function gotoPageNew(obj) {  debugger;
   var iframe = $('#page_frame').contents();
    var attID = $(obj).find("[id^='chanes_']").attr("id");
    var $frameElm = $("#page_frame").contents().find("#" + attID);
   var chkTable= $frameElm.closest("div").prop("class");
   if(chkTable=="table-wrap panel"){
      var ahrf= $frameElm.closest("div").parent().attr('id');
      var tbl='#'+ahrf;
       var linkhtml = $('#page_frame').contents().find("a[href="+tbl+"]");
       $('#history_popup').hide();
        $(linkhtml)[0].click();
      // console.log(ahrf);
   }else{
    iframe.scrollTop($frameElm.offset().top);
   }
   
}

function gotoPageNewHistory(obj) {
    //debugger
    var iframe = $('#page_frame').contents();
    //var iframe = $('#page_frame').contents();
    var currentsectionId = $(obj).find(".h_result").attr("section_no");
    var hreflinkid = currentsectionId + "_history";
    var linkhtml = $('#page_frame').contents().find("[id='" + hreflinkid + "']");
    //var linkhtml1 = $('#page_frame').contents().find("div[class='section'][id='"+currentsectionId+"']");
    $(linkhtml).trigger('click');
    var topdivid = $(linkhtml);
    if(iframe.length>0){
        iframe.scrollTop(topdivid.offset().top);
    }
}
function printEQ(){
    var mywindow = window.open('', 'PRINT', 'height=400,width=800');
    //$(p).remove();
    //mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body style="border:1px solid #000; ">');
    //mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(printContent);
    mywindow.document.write('</body></html>');
    parent.window.close();
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    //$(p).remove();
    mywindow.print();
    mywindow.close();
}

function printImage(){
    //debugger;
    var mywindow = window.open('', 'PRINT');
    //$(p).remove();
    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body style="border:1px solid #000; ">');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write('<img width="500" height="600" src='+PrintImage+' alt="Wrong path"/>');
    mywindow.document.write('</body></html>');
    parent.window.close();
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    //$(p).remove();
    mywindow.print();
    mywindow.close();
}
jQuery.fn.simulateClick = function() {
    return this.each(function() {
        if('createEvent' in document) {
            var doc = this.ownerDocument,
                evt = doc.createEvent('MouseEvents');
            evt.initMouseEvent('click', true, true, doc.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
            this.dispatchEvent(evt);
        } else {
            this.click(); // IE
        }
    });
}
function ReplaceAt(input, search, replace, start, end) {
        return input.slice(0, start)
+ input.slice(start, end).replace(search, replace)
+ input.slice(end);
}