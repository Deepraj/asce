
		//Commentary Part
		
		/*if(in_array("chc",$chars)){
	
			$xml= file_get_contents($playerPath."system/uploads/xml/".$xml_file);

			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
			$result = preg_replace($find, $replace, $xml);
			
			$fwrite = file_put_contents($playerPath."../asce_content/book/9780784412916/vol-1/xml/".$xml_file, $result);
			
			$diff = explode('.' , $xml_file);
				$html = $diff[0];
				$last_digit = substr($html, -2);
				if($last_digit < 10){
				$single_digit = substr($last_digit, -1);
				$final_html = $single_digit.".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
				}
				else{
				$final_html = $last_digit.".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
				}
			

		}
		
		
		if(in_array("11",$chars)){
		
			$xml= file_get_contents($playerPath."system/uploads/xml/".$xml_file);

			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
			$result = preg_replace($find, $replace, $xml);
			
			$fwrite = file_put_contents($playerPath."../asce_content/book/9780784412916/vol-1/xml/".$xml_file, $result);
			
			$diff = explode('.' , $xml_file);
				$html = $diff[0];
				$last_digit = substr($html, -2);
				
				$single_digit = substr($last_digit, -1);
				$final_html = $chars[3].$chars[2].".html";
				//$final_html = "ap".$single_digit.".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}
		
		if(in_array("xc",$chars)){
		
			$xml= file_get_contents($playerPath."system/uploads/xml/".$xml_file);

			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
			$result = preg_replace($find, $replace, $xml);
			
			$fwrite = file_put_contents($playerPath."../asce_content/book/9780784412916/vol-1/xml/".$xml_file, $result);
			
			$diff = explode('.' , $xml_file);
				$html = $diff[0];
				$last_digit = substr($html, -2);
				
				$mix = $chars[0];
				$final_html = $mix.".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
			
		}
		
		if(in_array("xd",$chars)){
		
			$xml= file_get_contents($playerPath."system/uploads/xml/".$xml_file);

			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
			$result = preg_replace($find, $replace, $xml);
			
			$fwrite = file_put_contents($playerPath."../asce_content/book/9780784412916/vol-1/xml/".$xml_file, $result);
			
			$diff = explode('.' , $xml_file);
				$html = $diff[0];
				$last_digit = substr($html, -2);
				$mix = $chars[0];
				$final_html = $mix.".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}
		
		if(in_array("xcd",$chars)){
		
			$xml= file_get_contents($playerPath."system/uploads/xml/".$xml_file);

			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
			$result = preg_replace($find, $replace, $xml);
			
			$fwrite = file_put_contents($playerPath."../asce_content/book/9780784412916/vol-1/xml/".$xml_file, $result);
			
			$diff = explode('.' , $xml_file);
				$html = $diff[0];
				$last_digit = substr($html, -2);
				$mix = $chars[0];
				$final_html = $mix.".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}
		
		
		if(in_array("cfm",$chars)){
		
			$xml= file_get_contents($playerPath."system/uploads/xml/".$xml_file);

			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
			$result = preg_replace($find, $replace, $xml);
			
			$fwrite = file_put_contents($playerPath."../asce_content/book/9780784412916/vol-1/xml/".$xml_file, $result);
			
			$diff = explode('.' , $xml_file);
				$html = $diff[0];
				
				$final_html = "f1".".html";
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $xml_file . '" -o:"../asce_content/book/9780784412916/vol-1/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
			
		}
        
        
        $explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);*/