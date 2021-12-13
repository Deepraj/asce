<?php
class Cronfile extends MY_Controllerreader {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        $this->load->helper(array(
            'form',
            'url',
            'xml',
            'security',
            'directory'
        ));
        $this->load->library(array(
            'form_validation',
            'tank_auth',
            'xml',
            'session',
            'unzip',
            'HtmlDiff'
        ));
        $this->userid = $this->session->userdata('user_id');
        $this->load->model('history_model');
	$this->load->library(array('email'));
        ?>
        <script>
    /*
 * Javascript Diff Algorithm
 *  By John Resig (http://ejohn.org/)
 *  Modified by Chu Alan "sprite"
 *
 * Released under the MIT license.
 *
 * More Info:
 *  http://ejohn.org/projects/javascript-diff-algorithm/
 */


function escape(s) {
    var n = s;
    n = n.replace(/&/g, "&amp;");
    n = n.replace(/</g, "&lt;");
    n = n.replace(/>/g, "&gt;");
    n = n.replace(/"/g, "&quot;");

    return s;
}

function diffString( o, n ) {
	/*if(typeof document !== "undefined"){
		var div1=document.createElement("div"),
    div2=document.createElement("div");
		$(div1).find("script").remove();
    $(div2).find("script").remove();
		div1.innerHTML=o,div2.innerHTML=n;
		o=div1.innerHTML,n=div2.innerHTML;
	}*/
	var COMMENT_PSEUDO_COMMENT_OR_LT_BANG = new RegExp(
    '<!--[\\s\\S]*?(?:-->)?'
    + '<!---+>?'  // A comment with no body
    + '|<!(?![dD][oO][cC][tT][yY][pP][eE]|\\[CDATA\\[)[^>]*>?'
    + '|<[?][^>]*>?',  // A pseudo-comment
    'g');
	o=o.replace(COMMENT_PSEUDO_COMMENT_OR_LT_BANG,'');
	n=n.replace(COMMENT_PSEUDO_COMMENT_OR_LT_BANG,'');
  //o = o.replace(/\s+$/, '');
  o = o.replace(/(\<)/g, ' <'); 
  o = o.replace(/(\>)/g, '> ');
  o=o.trim();
  //n = n.replace(/\s+$/, ''); 
  n = n.replace(/(\<)/g, ' <'); 
  n = n.replace(/(\>)/g, '> ');
  n=n.trim();
  //debugger
  
  
  
  var out = diff(o == "" ? [] : o.split(/\s+/), n == "" ? [] : n.split(/\s+/) );
  var str = "";
//debugger

  var rex=new RegExp("<[^>]+>","i");
  if (out.n.length == 0) {
      for (var i = 0; i < out.o.length; i++) {
        str += '<del> '+escape(out.o[i])+"</del>"; //+ oSpace[i] +
      }
  } else {
    if (out.n[0].text == null) {
      for (n = 0; n < out.o.length && out.o[n].text == null; n++) {
        str += '<del> '+escape(out.o[n])+"</del>"; //+ oSpace[n] +
      }
    }

    for ( var i = 0; i < out.n.length; i++ ) {
		
      if (out.n[i].text == null) {
		if(!rex.test(out.n[i])){
			str += '<ins> '+escape(out.n[i])+"</ins>"; //+ nSpace[i] +
		}else{
			str +=escape(out.n[i]);
		}			
      } else {
        var pre = "";
		for (n = out.n[i].row + 1; n < out.o.length && out.o[n].text == null; n++ ) {
			//console.log(out.o[n]);
			//console.log(!rex.test(out.o[n]));
			if(!rex.test(out.o[n])){
				pre += '<del> '+escape(out.o[n])+"</del>"; //+ oSpace[n]
			}else{
				pre +=escape(out.o[n]);
			}
        }
        str += " " + out.n[i].text  + pre; //+ nSpace[i]
      }
    }
  }
  //str=str.replace(/<\/del>(\n|\s*|)<del>/g,''); 
//	str=str.replace(/<\/ins>(\n|\s*|)<ins>/g,' ');
	//str=str.replace(/<\/ins><ins>/g,' ');
  //str=str.replace(/<\/del><del>/g,'');
  
  //str=str.replace(/(\s\<)/g,'<'); str=str.replace(/(\>\s)/g,'>'); 
  
  
  
  return str;
}


function diff( o, n ) {
	
  var ns = new Object();
  var os = new Object();
  //debugger
  var joints=false ,JoinVal='';
  
  for ( var i = 0; i < n.length; i++ ) {
	  if(n[i].indexOf("<")>-1 && n[i].indexOf(">")==-1 && joints==false){
		  joints=true;
	  }
	  if(joints==true){
		JoinVal=JoinVal+" "+n[i];
		if(JoinVal.indexOf(">")>-1 && JoinVal.indexOf("<")>-1){
		  joints=false;
		  n[i]=JoinVal;
		  JoinVal="";
	  }else{
		n.splice(i,1);
		i--;  
	  }
	  }
  }
  
   var joints=false ,JoinVal='';
  for ( var i = 0; i < o.length; i++ ) {
	  if(o[i].indexOf("<")>-1 && o[i].indexOf(">")==-1 && joints==false){
		  joints=true;
	  }
	  if(joints==true){
		JoinVal=JoinVal+" "+o[i];
		if(JoinVal.indexOf(">")>-1 && JoinVal.indexOf("<")>-1 && joints==true){
			joints=false;
			o[i]=JoinVal;
			JoinVal="";
		}else{
		o.splice(i,1);
		i--;	
		}
		
	  }
	  if(JoinVal.indexOf(">")>-1 && JoinVal.indexOf("<")>-1 && joints==true){
		  joints=false;
		  o.splice(i+1,1,JoinVal);
		  o[i+1]=JoinVal;
		  JoinVal="";
	  }
	  
  }
  
  for ( var i = 0; i < n.length; i++ ) {
    if ( ns[ n[i] ] == null )
      ns[ n[i] ] = { rows: new Array(), o: null };
    ns[ n[i] ].rows.push( i );
  }
  
  for ( var i = 0; i < o.length; i++ ) {
    if ( os[ o[i] ] == null )
      os[ o[i] ] = { rows: new Array(), n: null };
    os[ o[i] ].rows.push( i );
  }
  
  for ( var i in ns ) {
    if ( ns[i].rows.length == 1 && typeof(os[i]) != "undefined" && os[i].rows.length == 1 ) {
      n[ ns[i].rows[0] ] = { text: n[ ns[i].rows[0] ], row: os[i].rows[0] };
      o[ os[i].rows[0] ] = { text: o[ os[i].rows[0] ], row: ns[i].rows[0] };
    }
  }
  
  for ( var i = 0; i < n.length - 1; i++ ) {
    if ( n[i].text != null && n[i+1].text == null && n[i].row + 1 < o.length && o[ n[i].row + 1 ].text == null && 
         n[i+1] == o[ n[i].row + 1 ] ) {
      n[i+1] = { text: n[i+1], row: n[i].row + 1 };
      o[n[i].row+1] = { text: o[n[i].row+1], row: i + 1 };
    }
  }
  
  for ( var i = n.length - 1; i > 0; i-- ) {
    if ( n[i].text != null && n[i-1].text == null && n[i].row > 0 && o[ n[i].row - 1 ].text == null && 
         n[i-1] == o[ n[i].row - 1 ] ) {
      n[i-1] = { text: n[i-1], row: n[i].row - 1 };
      o[n[i].row-1] = { text: o[n[i].row-1], row: i - 1 };
    }
  }
  
  return { o: o, n: n };
}


</script>
<?php
    }

    public function index() {
        //ini_set("display_errors", "1");
        //error_reporting(E_ALL);
        ini_set('memory_limit', '-1');
		//$this->session->sess_destroy();
		//die("fdf");
        /*ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/
        $this->load->model('crons');
        
        $resultdata = $this->crons->getCurrentQueqe();
        //echo "<pre>";print_r($resultdata);die;
        foreach($resultdata as $singlhistory){
        if(isset($singlhistory->id)){
        $current_id = $singlhistory->id;
        $onepath = $singlhistory->onepath;
        
        
        //echo "<pre>";print_r($_SERVER);die;
        $datapath = explode('asce_content',$onepath);
        //$onepath = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/asce-project/asce_content'.$datapath[1];
        $onepath = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/asce_content'.$datapath[1];
        //die($firstfilepath);
        $twopath = $singlhistory->twopath;
        $datapath2 = explode('asce_content',$twopath);
        //$twopath = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/asce-project/asce_content'.$datapath2[1];
        $twopath = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/asce_content'.$datapath2[1];
        $finalname = $singlhistory->finalname;
        
        $this->create_history_record($onepath,$twopath,$finalname);
        //we are going to prcess html difference
		$LastId = $this->crons->tableLastId();
		$tablelastid=$LastId->id;
		//echo $LastId; die;
		$sess_bookid = $this->session->userdata('bookid');
		$curbook_id=$this->crons->getCurentBookId($current_id);
		     
		$curbook_id=$curbook_id->bookid;
		//echo $sess_bookid."send mail".$curbook_id;
		if(empty($sess_bookid))
		{
		$this->session->set_userdata('bookid',$curbook_id);	
		}
		else
		{
		   if(($sess_bookid!=$curbook_id )|| ($tablelastid==$current_id))
		   {
		    //sendmail';
			$curbook_title = $this->crons->getCurentBookTitle($curbook_id);
			//echo "<pre>";print_r($curbook_title[0]->m_boktitle); die;
			 $this->SendEmail($curbook_title[0]->m_boktitle); 
			//echo $sess_bookid."final send mail".$curbook_id;
            $this->session->set_userdata('bookid',$curbook_id);			
		   }
		   
		}
        $this->crons->setCronFlage($current_id);
        }
    }
    }

	 public function SendEmail($curbook_title){
        $to_email="MGentry@asce.org"; 
		//$data['name']=$this->Institute_model->fetchDetail($to_email);
		//print_r($data['name']); die;
		$this->email->to($to_email);
	    $body="Hi admin <br> The book title '".$curbook_title."' History  has been generated and ready  for activate. <br>Thank you"; 
		$this->email->from('www.asce.org', 'American Society of civil engineers');
		$this->email->subject('Your Book History has been generated and ready  for activate.');
		$this->email->message($body);
	//	echo"<pre>"; print_r( $this->email);die; 	
		$send=$this->email->send();
		
  }
	
	
    function create_history_record($file_one, $file_two, $file_name) {
        //$version_file = explode('/', $file_name);
        //$version = $version_file [0];
        //$file = $version_file [1];
        //echo "<pre>";print_r($file_one);die;
        //echo "<pre>";print_r($file_two);
        //echo "<pre>";print_r($file_name);
        //echo "<pre>";print_r($file_name);die;

//        $domobject = file_get_contents($file_two);
//        $from_content = addslashes(file_get_contents($file_one));
//        //echo $from_content;die;
//
//        $from_content = str_replace(array("\r","\n"),"",$from_content);
//        //die($from_content);
//        $from_content = str_replace("</script>","<\/script>",$from_content);
//        //die($from_content);
//        //die($file_two);
//        $to_content = addslashes(file_get_contents($file_two));
//        //echo "<pre>4567323";print_r($to_content);die;
//        $to_content = str_replace(array("\r","\n"),"",$to_content);
//        //echo "<pre>4567";print_r($to_content);die;
//        $to_content = str_replace("</script>","<\/script>",$to_content);
        
        $allinformation = explode('/',$file_name);
        $version    =   $allinformation[count($allinformation)-2];
        $file       =   $allinformation[count($allinformation)-1];




        
        $book_path = $file_name . '.html';
        $allglobalpath = $allinformation;
        unset($allglobalpath[count($allglobalpath)-1]);
        $globalwritepath = implode("/", $allglobalpath);

        //echo "<pre>";print_r($globalwritepath);die;
        //echo "<pre>1234";print_r($book_path);die;
        //$this->create_history_file($globalwritepath,$book_path, $diff);


?>
            <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
            <script type="text/javascript">
                
                
                
                
            $(document).ready(function(){
            $.ajax({url: "<?php echo $file_one; ?>", crossDomain:true,cache: false, dataType : "html", crossorigin:"anonymous", contentType: "application/xhtml+xml+html; charset=utf-8", success: function(result){
            $.ajax({url: "<?php echo $file_two; ?>", crossDomain:true, dataType : "html",  crossorigin:"anonymous", cache: false, contentType: "application/xhtml+xml+html; charset=utf-8", success: function(result2){

            debugger
            var string=document.createElement("span");
            string.innerHTML=result;
            
            $(string).find('.inline-formula').html('');
            $(string).find('math').remove();
            
            var string2=document.createElement("span");
            string2.innerHTML=result2;
            $(string2).find('.inline-formula').html('');
            $(string2).find('math').remove();


            var stringResult=document.createElement("span");
            stringResult.innerHTML=result2;
            $(string).contents().find("book-part").children().eq(0).remove();
            string =$(string).contents().find("book-part").html();
            $(string2).contents().find("book-part").children().eq(0).remove();
            string2 =$(string2).contents().find("book-part").html();



            //var string= $(stringEle).contents().find("book-body").html();
            //book-b
            var diffStringValue = diffString(
            string.trim(),
            string2.trim()
            );



            var diffDiv=document.createElement("div");
                diffDiv.innerHTML=diffStringValue;
                var tags=diffDiv.getElementsByTagName("*");
                var j=100;
                for(i=0; i < tags.length; i++ ){
                    if( tags[i].tagName=="DEL" || tags[i].tagName=="INS"){
                       tags[i].setAttribute("id","chanes_"+tags[i].tagName.toLowerCase()+"_"+j);
                     j++;
                  }
                }
                result=diffDiv.innerHTML;

            //diffStringValue = diffStringValue.substring(5)
            /*var div=document.createElement("div")
            div.innerHTML=diffStringValue;*/


            $(stringResult).contents().find("book-body").html(result);
            var stringResult=$(stringResult).html();
            
            
            
            
            
            
            $.ajax({
                method: "POST",
                url: "cronfile/create_history_file_new",
                data: { filelocation:'<?php echo $globalwritepath;?>',filename:'<?php echo $book_path; ?>', contentvalue: stringResult }
                }).done(function() {
                console.log( "Data Saved: " );
              });
            
            //stringResult = stringResult.html();

            //console.log(stringResult);
            //debugger
            //$("#div1").html(stringResult);
                }});
               }});
            });

            </script>
        <?php

       // die("Chill");

/*

        $from_content = file_get_contents($file_one);
        $to_content = file_get_contents($file_two);
        $allinformation = explode('/',$file_name);
        $version    =   $allinformation[count($allinformation)-2];
        $file       =   $allinformation[count($allinformation)-1];
        
        if (!empty($from_content) && !empty($to_content)) {
            $from = $from_content;
            $to = $to_content;
            
            $diff = new HtmlDiff($from, $to);
            //echo "<pre>45666";print_r($diff  );die;
            $diff->build();
            //echo "<pre>45666";print_r($diff);die;
            $diff = $diff->getDifference();
            
            if (isset($diff)) {
                $dom = new DOMDocument ();
                $dom->loadHTML($diff);
                $xpath = new DOMXPath($dom);
                $history_data = $xpath->query('//div[contains(@class,"section")]');
                foreach ($history_data as $history_record) {
                    $history_value = $history_record;
                    $history_value = $dom->saveXML($history_value);
                    //die("Hdddd");
                    $data = $this->get_history_data($version, $file, $history_value);
                }
                $book_path = $file_name . '.html';
                $allglobalpath = $allinformation;
                unset($allglobalpath[count($allglobalpath)-1]);
                $globalwritepath = implode("/", $allglobalpath);

                //echo "<pre>";print_r($globalwritepath);die;
                //echo "<pre>1234";print_r($book_path);die;
                $this->create_history_file($globalwritepath,$book_path, $diff);
            }
            
            //$book_path = $this->config->item('history_path') . $file_name . '.html';
            
            
        }*/
      //die;  
        
        
        $dom = new DOMDocument ();
        $datastory = $book_path;
        //$datastory = 'D:/xampp_5_06_18/htdocs/asce-project/asce_content/history/14916930082017/ap04.html';
        $dom->loadHTMLFile($datastory);
        //$datavaluesforxml = file_get_contents($datastory);
        //$dom->loadHTML($datavaluesforxml);
        //echo "<pre>12345#";print_r($dom);die;
        $xpath = new DOMXPath($dom);
        //echo "<pre>12345";print_r($xpath);die;
        $history_data = $xpath->query('//div[contains(@class,"section")]');
        //echo "<pre>12345";print_r($history_data);die;
        
       // foreach ($history_data as $history_record) {
          //$history_value = $history_record;
          //$history_value = $dom->saveXML($history_value);
          //echo "<pre>1234567";print_r($history_value);die;
          //die("Hdddd");
          
          //$data = $this->get_history_data($version, $file, $history_value);
          $data = $this->get_history_data($version, $file, $datastory,$book_path);
       // }
    }
    
    function create_history_file_new() {
           
         // echo "<pre>123456";print_r($_REQUEST);die; 
          $contents = $_REQUEST['contentvalue'];
          $globalwritepath = $_REQUEST['filelocation'];
          $dir = $_REQUEST['filename'];

       $result = '<link href="../history.css" rel="stylesheet" type="text/css">';
        $result .= stripslashes($contents);
        //$result = $contents;
            //echo "<pre>222";print_r($dir);echo "<hr>";
            //echo "<pre>222";print_r($contents);die;
            if (!file_exists($globalwritepath)) {
                mkdir($globalwritepath, 0777, true);
            }
        file_put_contents ( $dir, $result );
        die("work done");
    }
    


    function create_history_file($globalwritepath,$dir, $contents) {
            
        $result = '<link href="../history.css" rel="stylesheet" type="text/css"><script type="text/javascript"
                        src="https://cdn.mathjax.org/mathjax/latest/MathJax.js">
                </script>';
        $result .= $contents;
            //echo "<pre>222";print_r($dir);echo "<hr>";
            //echo "<pre>222";print_r($contents);die;
            if (!file_exists($globalwritepath)) {
                mkdir($globalwritepath, 0777, true);
            }
        file_put_contents ( $dir, $result );
    }
    
    function get_history_data($version, $file, $dom_data,$book_path) {
                //echo "<pre>123";print_r($version.$file.$dom_data);die;
                $this->load->model('history_model');
		$version_id_arr=array();
		$chapter_no_arr=array();
		$curr_section_arr=array();
		$data_arr=array();
		$version_id = $version;
		$chapter_no = $file;
		$dom = new DOMDocument ();
		//$dom->loadHTML ( $dom_data );
                $dom->loadHTMLFile($dom_data);
		$ins = $dom->getElementsByTagName ( 'ins' );
                //echo "<pre>1234!!";print_r($ins);die;
		$sec_id = $dom->getElementsByTagName ( 'div' );
                
		$curr_section = '';
		/*foreach ( $sec_id as $sec ) {
                        echo "<pre>!!!!!";print_r($sec);echo "<hr>";
			$curr_section = $sec->getAttribute ( 'id' );
                        //echo "***".$curr_section;die;
			break;
		}
                //echo "<pre>1234!!@@";print_r($curr_section);die;
                
		foreach ( $ins as $attr ) {
			$value = $attr->nodeValue;
			if (! empty ( trim ( $value ) )) {
				$data = '<font style="color:green">' . $value . '</font>';
				array_push($version_id_arr, $version_id);
				array_push($chapter_no_arr,$chapter_no);
				array_push($curr_section_arr, $curr_section);
				array_push($data_arr, $data);
				//$insertData = $this->history_model->add_history ( $version_id, $chapter_no, $curr_section, $data );
			}
		}
		$del = $dom->getElementsByTagName ( 'del' );
		foreach ( $del as $del_attr ) {
			$value = $del_attr->nodeValue;
			if (! empty ( trim ( $value ) )) {
				$data = '<strike style="color:red">' . $value . '</strike>';
				array_push($version_id_arr, $version_id);
				array_push($chapter_no_arr,$chapter_no);
				array_push($curr_section_arr, $curr_section);
				array_push($data_arr, $data);
				//$insertData = $this->history_model->add_history ( $version_id, $chapter_no, $curr_section, $data );
			}
		}*/
		//$insertData = $this->history_model->add_history ( $version_id_arr, $chapter_no_arr, $curr_section_arr, $data_arr,$book_path );
		$insertData = $this->history_model->add_history ( $version, $chapter_no, $curr_section_arr, $data_arr,$book_path );
	}

}

?>

                
