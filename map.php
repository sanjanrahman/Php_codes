<?php
$call_number = $_GET['call_number'];
$location_name = $_GET['location_name'];
$location_code = $_GET['location_code'];
$library_code = $_GET['library_code'];

$call_no = &get_callno($call_number);
$loc_code = &get_loc_code($location_code);
$temp_item_loc = &get_temp_item_loc($location_code);

$image_map=get_image_per_location($call_no,$loc_code,$temp_item_loc);

if(!validate($call_no)) {
	print "Invalid call number !.";
	exit;
}

#Calling all the fns.
					
build_page($loc_code, $call_no, $image_map);


function get_callno($string) {
	return $string;
}

function get_loc_code($string) {	
	return $string;
}

function get_temp_item_loc($string) {
	return $string;
}


function build_page($loc_code, $call_no, $image_map)

{

echo <<<END_HTML

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Detailed Map</title>
<SCRIPT language="JavaScript">

								function movepic(img_name,img_src) 
								{
								 document[img_name].src=img_src;
								}

</SCRIPT>

</head>
<body>
<table summary="" width="100%"  cellpadding="1" cellspacing="1">

END_HTML;

if($loc_code == "doctxwww"||$loc_code == "doctxejour"||$loc_code == "marcit"||$loc_code == "elewiley"||$loc_code == "elesage"||$loc_code == "ebondemand"||$loc_code == "ebldemand"||$loc_code == "elejuv"||$loc_code == "docejour"||$loc_code == "docwww"||$loc_code == "ebrary"||$loc_code == "elebl"||$loc_code == "elebook"||$loc_code == "elebsco"||$loc_code == "elecareer"||$loc_code == "elecco"||$loc_code == "eleceeb"||$loc_code == "elecipa"||$loc_code == "elecln"||$loc_code == "elecmome"||$loc_code == "elecon"||$loc_code == "elecref"||$loc_code == "elecwi"||$loc_code == "eledbs"||$loc_code == "eleeai"||$loc_code == "elegerr"||$loc_code == "elenet"||$loc_code == "elesafari"||$loc_code == "eleshaw"||$loc_code == "eleumi"||$loc_code == "elewww"||$loc_code == "factiva" ||$loc_code == "e-res" || $loc_code == "elecho" ||$loc_code == "emovie"||$loc_code == "cognet" ||$loc_code == "eleweb" ||$loc_code == "elenaxmusi" ||$loc_code == "elenaxword" ||$loc_code == "elesevier"||$loc_code == "overdrive"){
echo <<<END_HTML2
				<tr>
					<td align="left">Link :</td><td><a href=$elink>Click here for the Electronic resource.</a></td>
				</tr>
				<tr>
				<td align="left"></td><td><a HREF=$elink onmouseover="movepic('button','http://www.utdallas.edu/library/images/dynamic_maps/online_active.gif')" onmouseout="movepic('button','http://www.utdallas.edu/library/images/dynamic_maps/online_pasive.gif')"><IMG NAME="button" SRC="http://www.utdallas.edu/library/images/dynamic_maps/online_pasive.gif" ALT="Electronic Resource" BORDER=1 ALIGN=TOP HEIGHT="320" WIDTH="300"></a></td>
				</tr>
END_HTML2;
}else{
echo <<<END_HTML3
<tr>
<td align="left">Call No. :</td><td>$call_no</td>
</tr>
<tr>
<td align="left">Map :</td><td><IMG SRC="http://www.utdallas.edu/library/images/dynamic_maps/$image_map" ALT="McDermott Library Homepage" BORDER=1 ALIGN=TOP HEIGHT="500" WIDTH="600"></td>
</tr>
END_HTML3;
}
echo <<<END_HTML4
</table>

<table>
</body>
</html>

END_HTML4;

}
#subroutine to determine the location
function get_image_per_location($call_no, $loc_code, $temp_item_loc)
{
 			
			#open(OUTPUT,">$home"."log_map.txt") || die "Cannot open log_map\n";

			#print OUTPUT "Inside get_image_per_location \n";
			
			#**********************starting of getting the variables that determines the stack location************			
			preg_replace('/\s/','', $call_no);
			
			$call_no_2_letter=substr($call_no,0,2);#getting the first two letters for the Call#
			
			preg_replace('/\s/','', $loc_code);
			
			$call_loc=$loc_code;
			
			preg_replace('/\s/','', $temp_item_loc);
			$temp_loc=$temp_item_loc;
			#now get the numeric classification part
			#check if the second char is numeric or alphabet, 
			if(preg_match('/\d/',substr($call_no,1,1)))#second char is digit
			{
			 		$dot_pos=strpos($call_no,'.');#getting the first occurance of .
					$class_num_1=substr($call_no,1,$dot_pos-1);
			}
			else#second char is alpha
			{
			 	  $dot_pos=strpos($call_no,'.');#getting the first occurance of .
					$class_num_1=substr($call_no,2,$dot_pos-2);
			}
			#now got(hopefully) all the values to identify the proper stack location
			
			#first of all get the location code & assign the proper image
			
			#***************begening with figuring out if an item is in Exhibit, if so then route them to circ desk*************** 
			if($temp_loc == "exhibit" || $temp_loc == "exhibit2"||$temp_loc == "exhibit3" || $temp_loc == "exhibit4" || $temp_loc == "exhibitadm")#Juvenile coll
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="CirculationReserve_2ndFloor.gif";
						# set this ehibit location as Display location
						$loc_code=$temp_loc;
						
			}#***************starting of the main stack location finding*************** 
			elseif($call_loc == "juvenile" || $call_loc == "juv-audio")#Juvenile coll
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="Juvenile_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "leisure")#Leisure reading
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="Leisure_A-Z_2ndFloor.gif";
			}

			elseif($call_loc == "mfilmper")#Microfilm Periodicals 
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="MicroformArea_A-Z_2ndFloor.gif";
			}
		

			elseif($call_loc == "mficheper")#Microfiche Periodicals 
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="MicroformArea_A-Z_2ndFloor.gif";
			}
	
			elseif($call_loc == "mcdermott")#Special Collections 
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="SpecialCollections_A-Z_3rdF.gif";
			}

			elseif($call_loc == "mediaremot")#Circulation Desk
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="CirculationReserve_2ndFloor.gif";
			}

			elseif($call_loc == "sc-chess")#Chess Collections
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="SpecialCollections_A-Z_3rdF.gif";
			}
		
			elseif($call_loc == "eric")#Eric Docs
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="MicroformArea_A-Z_2ndFloor.gif";
			}

			elseif($call_loc == "dissutd")#Dissertations
			{
			 			#print OUTPUT $loc_code."-1".$call_no_2_letter;
						$image_name="Dissertations_2ndFloor.gif";
			}



			elseif($call_loc == "sc-archive" || $call_loc == "sc-aviat"||$call_loc == "sc-bels" || $call_loc == "sc-green"|| $call_loc == "sc-aviarch" || $call_loc == "sc-wprl"||$call_loc == "sc-rosen" || $call_loc == "sc-utdarch"||$call_loc == "sc-clstax"||$call_loc == "suite"||$call_loc == "sc-holcv" ||$call_loc == "sc-ludwig")#Special Coll
			{
			 			#print OUTPUT $loc_code."-2".$call_no_2_letter;
						$image_name="SpecialCollections_A-Z_3rdF.gif";
			}
			elseif($call_loc == "career")#Career Center
			{
			      #print OUTPUT $loc_code."-2".$call_no_2_letter;
						$image_name="CareerCenter.gif";
			}
			elseif($call_loc == "c-av" || $call_loc == "c-bachman"||$call_loc == "c-cdrom" ||$call_loc == "c-odtest"||$call_loc == "c-per" || $call_loc == "c-ref" ||$call_loc == "c-reserve"||$call_loc == "c-stax" || $call_loc == "c-test" || $call_loc == "c-videos")#Calier Center
			{
			      #print OUTPUT $loc_code."-3".$call_no_2_letter;
						$image_name="CallierLibrary.gif";
			}
			elseif($call_loc == "doctex" || $call_loc == "doctxncirc")#Texas docs
			{
			      #print OUTPUT $loc_code."-3".$call_no_2_letter;
						$image_name="TexasGovDocs_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "doc" ||$call_loc == "docdvd" ||$call_loc == "docncir" ||$call_loc == "docper")#Govt. docs
			{
			 			#print OUTPUT $loc_code."-4".$call_no_2_letter;
						$image_name="GovDocs_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "docredyref"||$call_loc == "ref-atlas"||$call_loc == "ref-ready")#ref-desk
			{
			 			#print OUTPUT $loc_code."-5".$call_no_2_letter;
						$image_name="RefDesk_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "ref")#ref-shelves
			{
			 			#print OUTPUT $loc_code."-5".$call_no_2_letter;
						$image_name="Reference_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "ref-index")#ref-index
			{
			 			#print OUTPUT $loc_code."-7".$call_no_2_letter;
						$image_name="RefIndex_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "circdesk"||$call_loc == "ele-nocirc" ||$call_loc == "reserve" ||$call_loc == "closedstax")#Circ-desk, Time/Newsweek magazines
			{
			 			#print OUTPUT $loc_code."-5".$call_no_2_letter;
						$image_name="CirculationReserve_2ndFloor.gif";
			}
			elseif($call_loc == "ill")#ILL
			{
			 			#print OUTPUT $loc_code."-6".$call_no_2_letter;
						$image_name="ILL_2ndFloor.gif";
			}
			elseif($call_loc == "maptex"||$call_loc == "map"||$call_loc == "map-flat"||$call_loc == "mapdocfile"||$call_loc == "mapindex"||$call_loc == "maproad"||$call_loc == "maptopo"||$call_loc == "mapwall")#map
			{
			 				#print OUTPUT $loc_code."-9".$call_no_2_letter;
							$image_name="Map_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "doctxfilm"||$call_loc == "sc-mfilm"||$call_loc == "docmfilm"||$call_loc == "microfilm"||$call_loc == "microindex")#microfilm
			{
			 			  #print OUTPUT $loc_code."-10".$call_no_2_letter;
							$image_name="MicroformArea_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "doctxfiche"||$call_loc == "docmfiche"||$call_loc == "microfiche")#microfiche
			{
			 				#print OUTPUT $loc_code."-11".$call_no_2_letter;
							$image_name="MicroformArea_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "doctxwww"||$call_loc == "doctxejour"||$call_loc == "elejuv"||$call_loc == "docejour"||$call_loc == "docwww"||$call_loc == "ebrary"||$call_loc == "elebl"||$call_loc == "elebook"||$call_loc == "elebsco"||$call_loc == "elecareer"||$call_loc == "elecco"||$call_loc == "eleceeb"||$call_loc == "elecipa"||$call_loc == "elecln"||$call_loc == "elecmome"||$call_loc == "elecon"||$call_loc == "elecref"||$call_loc == "elecwi"||$call_loc == "eledbs"||$call_loc == "eleeai"||$call_loc == "elegerr"||$call_loc == "elenet"||$call_loc == "elesafari"||$call_loc == "eleshaw"||$call_loc == "eleumi"||$call_loc == "elewww"||$call_loc == "factiva" ||$call_loc == "e-res" ||$call_loc == "e-res" ||$call_loc == "elecho" ||$call_loc == "emovie" ||$call_loc == "cognet" ||$call_loc == "eleweb")#e-item
			{
			        #print OUTPUT $loc_code."-12".$call_no_2_letter;
							$image_name="UnderConstruction_forAnimGi.gif";
			}
			elseif($call_loc == "ele-circ"||$call_loc == "ele-doc"||$call_loc == "ele-nocirc" ||$call_loc == "cdbook" ||$call_loc == "cd-circ")#cdrom
			{
			        #print OUTPUT $loc_code."-13".$call_no_2_letter;
							$image_name="CD-ROMCabinet_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "media"||$call_loc == "mediaad"||$call_loc == "mediaresv"||$call_loc == "mediavd"||$call_loc == "mediavt" ||$call_loc == "mainaudio" ||$call_loc == "medialect"||$call_loc == "audiobook"||$call_loc == "==uipment"||$call_loc == "videos"||$call_loc == "mediadview")#multi-media
			{
			        #print OUTPUT $loc_code."-14".$call_no_2_letter;
							$image_name="Multimedia_A-Z_2ndFloor.gif";
			}
			elseif($call_loc == "ackerman")#jonnson
			{
			        #print OUTPUT $loc_code."-14".$call_no_2_letter;
							$image_name="erikjonsson.gif";
			}
			elseif($call_loc == "doctexper"||$call_loc == "perincshlf"||$call_loc == "periodical")#periodicals
			{
			
			 		if((preg_match('/A[1-9A-Z]/', $call_no_2_letter)) || (preg_match('/[B-G][A-Z1-9]/', $call_no_2_letter)))#Periodcial A-GV, covers all A through all G
					{
			  	 				#print OUTPUT $loc_code."-17".$call_no_2_letter;
									$image_name="Periodicals_A-GV_2ndFloor.gif";
					}
					elseif(preg_match('/H[1-9A-Z]/', $call_no_2_letter))#Periodicals, covers all H
					{
			  	 				#print OUTPUT $loc_code."-18".$call_no_2_letter;
									$image_name="Periodicals_H1-HX_2ndFloor.gif";#P2
					}
					elseif(preg_match('/J[1-9A-Z]/', $call_no_2_letter) || preg_match('/[K-P][A-Z1-9]/', $call_no_2_letter))#Periodcial J-PS, covers all J through P
					{
			  	 				#print OUTPUT $loc_code."-17".$call_no_2_letter;
									$image_name="Periodicals_J-PS_2ndFloor.gif";
					}
					elseif(preg_match('/Q[1-9A-R]/', $call_no_2_letter))#Periodcial Q1-QR, covers all Q
					{
			  	 				#print OUTPUT $loc_code."-17".$call_no_2_letter;
									$image_name="Periodicals_Q1-QR_2ndFloor.gif";
					}
					elseif(preg_match('/R[1-9A-Z]/', $call_no_2_letter) ||preg_match('/[S-Z][A-Z1-9]/', $call_no_2_letter))#Periodcial R-Z, covers all R through all Z
					{
			  	 				#print OUTPUT $loc_code."-17".$call_no_2_letter;
									$image_name="Periodicals_R-Z_2ndFloor.gif";
					}
					else
					{
					 				$image_name="UnderConstruction_forAnimGi.gif";
					}
							
			}
			elseif($call_loc == "holc"||$call_loc == "sc-holc"||$call_loc == "stax"||$call_loc == "staxncirc"||$call_loc == "tenure")#main-stax
			{
			
			 		#**************Searching for P********************************************
			
					
					#print OUTPUT $loc_code."-16".$call_no_2_letter;
					
					#4th floor P stacks are divided into 3 zones, 1. P1~PN1994, 2. PN1995~PR99 and 3. PR105~PT8176
					if(preg_match('/P[1-9]/', $call_no_2_letter) || preg_match('/P[A-M]/', $call_no_2_letter) || (preg_match('/PN/', $call_no_2_letter)&& ($class_num_1<=1994)))
					{
			  	 				#print OUTPUT $loc_code."-17".$call_no_2_letter;
									$image_name="Main_P1-PN1994_4thFloor.gif";#P1
					}
					elseif((preg_match('/PN/', $call_no_2_letter)&& ($class_num_1 >=1995)) || preg_match('/P[O-Q]/', $call_no_2_letter) || (preg_match('/PR/', $call_no_2_letter)&& ($class_num_1<=98)))
					{
			  	 				#print OUTPUT $loc_code."-18".$call_no_2_letter;
									$image_name="Main_PN1995-PR98_4thFloor.gif";#P2
					}
					elseif((preg_match('/PR/', $call_no_2_letter)&& ($class_num_1>=99)) || preg_match('/P[S-Z]/', $call_no_2_letter))#|| (preg_match('/PT/)&& ($class_num_1<=8176))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_PR99-PZ_4thFloor.gif";#P3
					}#end of stack P
					#4th floor H stacks are divided into 3 zones, 1. H1~HC106.8.P, 2. HC106.8.Q~HD1375.H and 3. HD1375.H~HZ****needs fine tuning
					elseif(preg_match('/H[1-9]/', $call_no_2_letter) || preg_match('/H[A-B]/', $call_no_2_letter) || (preg_match('/HC/', $call_no_2_letter)&& ($class_num_1<=106)))
					{
			  	 				#print OUTPUT $loc_code."-17".$call_no_2_letter;
									$image_name="Main_H1_4thFloor.gif";#H1
					}
					elseif((preg_match('/HC/', $call_no_2_letter)&& ($class_num_1 >=106)) || (preg_match('/HD/', $call_no_2_letter)&& ($class_num_1<=1375)))
					{
			  	 				#print OUTPUT $loc_code."-18".$call_no_2_letter;
									$image_name="Main_H2_4thFloor.gif";#H2
					}
					elseif((preg_match('/HD/', $call_no_2_letter)&& ($class_num_1>=1375)) || preg_match('/H[E-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_H3_4thFloor.gif";#H3
					}
					#3rd floor A
					elseif(preg_match('/A[1-9A-Z]/', $call_no_2_letter))#3rd floor stack for A-AZ
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_A-AZ_3rdFloor.gif";
					}
					#3rd floor B
					elseif(preg_match('/B[1-9A-C]/', $call_no_2_letter))#3rd floor stack for B1-BC from first B through all BC
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_B1-BC_3rdFloor.gif";
					}
					elseif(preg_match('/B[D-J]/', $call_no_2_letter))#3rd floor stack for BD-BJ
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_BD-BJ_3rdFloor.gif";
					}
					elseif(preg_match('/B[L-R]/', $call_no_2_letter))#3rd floor stack for BL-BR
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_BL-BR_3rdFloor.gif";
					}
					elseif(preg_match('/B[S-Z]/', $call_no_2_letter)||preg_match('/C[1-9A-Z]/', $call_no_2_letter))#3rd floor stack for BS-CT
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_BS-CT_3rdFloor.gif";
					}
					elseif(preg_match('/D[1-9A-X]/', $call_no_2_letter))#3rd floor stack for D1-DX
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_D1-DX_3rdFloor.gif";
					}
					elseif(preg_match('/E[1-9A-Z]/', $call_no_2_letter))#3rd floor stack for E12-E905 (all E)
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_E12-E905_3rdFloor.gif";
					}
					elseif(preg_match('/F[1-9A-Z]/', $call_no_2_letter)||preg_match('/G[1-9A-V]/', $call_no_2_letter))#3rd floor stack for F3-GV
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_F3-GV_3rdFloor.gif";
					}
					#4th floor stack J-K
					elseif(preg_match('/J[1-9A-Z]/', $call_no_2_letter)|| preg_match('/K[1-9A-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_J-K_4thFloor.gif";
					}
					#4th floor stack L-N, all L, all M and all N
					elseif(preg_match('/L[1-9A-Z]/', $call_no_2_letter) || preg_match('/M[1-9A-Z]/', $call_no_2_letter) || preg_match('/N[1-9A-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_L-N_4thFloor.gif";
					}
					#4th floor stack Q covers all Q
					elseif(preg_match('/Q[1-9A-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_Q_4thFloor.gif";
					}
					#4th floor stack R-S, all R and all S
					elseif(preg_match('/R[1-9A-Z]/', $call_no_2_letter)|| preg_match('/S[1-9A-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_R-S_4thFloor.gif";
					}
					#4th floor stack T covers all T
					elseif(preg_match('/T[1-9A-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_T_4thFloor.gif";
					}
					#4th floor stack U-Z, all U and all Z
					elseif(preg_match('/U[1-9A-Z]/', $call_no_2_letter)|| preg_match('/Z[1-9A-Z]/', $call_no_2_letter))
					{
			  	 				#print OUTPUT $loc_code."-19".$call_no_2_letter;
									$image_name="Main_U-Z_4thFloor.gif";
					}
					#elseif($call_no_2_letter == "TK")
					#{
			  	 				#print OUTPUT $loc_code."-20".$call_no_2_letter;
									#$image_name="Main_PA-PN_4thFloor.gif";
					#}
					#elseif($call_no_2_letter == "F4")#&& $call_loc == "stax"
					#{
			 		 				#print OUTPUT $loc_code."-21".$call_no_2_letter;
									#$image_name="Main_F_3rdFloor.gif";
					#}
					else
					{
			  	 				#print OUTPUT $loc_code."-22".$call_no_2_letter;
									$image_name="UnderConstruction_forAnimGi.gif";
					}
			}
			else#detailed map is not available at this point 
			{
			 		 				#print OUTPUT $loc_code."-29".$call_no_2_letter;
									$image_name="UnderConstruction_forAnimGi.gif";
			}
					#close(OUTPUT);
					return $image_name;

}

// Protect against the XSS scripting. Ignore all the angular brackets to make sure no HTML gets through.
function validate($parameter) {
	$allowed_pattern = "/[^A-Za-z 0-9\.\/\-:]/";
	if (preg_match($allowed_pattern, $parameter)) {
		return false;
	} else {
		return true;
	}
}

?>