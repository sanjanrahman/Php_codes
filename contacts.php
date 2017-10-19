<?php
//Php part of department contact inforamtion
//Read the data in memory.
$str_data = file_get_contents("contacts.json");
$data = json_decode($str_data, true);

if (array_key_exists('liasonsonly', $_GET)) {
    $liasons_only = $_GET['liasonsonly'];
} else {
    $liasons_only = 0;
}

if (array_key_exists('eonly', $_GET)) {
    $exceptions_only = $_GET['eonly'];
} else {
    $exceptions_only = 0;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/TemplateLibrary.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="WT.cg_n" content="Library" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Contacts - Eugene McDermott Library - The University of Texas at Dallas</title>
<link href="style/contacts.css" rel="stylesheet" type="text/css" />
        <script src="https://code.jquery.com/jquery-latest.min.js">
	
        </script>
        <script src="jquery.tablesorter.js">
	
        </script>
        <script src="jquery.uitablefilter.js">
	
        </script>
        <script>
            $(function() {
                var theTable = $('#contacts');
                $("#search").keyup(function() {
                    $.uiTableFilter(theTable, this.value);
                    theTable.trigger("applyWidgets");
                    $("input:radio").attr("checked", false);
                });
                $(".filtercheck").click(function() {
                    if (this.checked) {
                        $.uiTableFilter(theTable, this.value);
                        theTable.trigger("applyWidgets");
                        $('input[type="text"]').val("");
                    }
                });
                $(".filtercheckdep").click(function() {
                    if (this.checked) {
                        $.uiTableFilter(theTable, this.value, "Library Department");
                        theTable.trigger("applyWidgets");
                        $('input[type="text"]').val("");
                        var sorting = [[2,1],[0,0]]; 
                        theTable.trigger("sorton",[sorting]); 
                    }
                });
		
                $("#reset").click(function() {
                    $.uiTableFilter(theTable, "");
                    theTable.trigger("applyWidgets");
                    $("input:radio").attr("checked", false);
                    $('input[type="text"]').val("");
                });

                $("#contacts").tablesorter({
                    sortList: [[0,0]],
                    widgets : [ 'zebra' ],
                    headers : {  3: {sorter: false} },
                    textExtraction: myTextExtraction
                });
            });
            var myTextExtraction = function(node)  
            {  
                // extract data from markup and return it  
                return $(node).find("#sorter").html(); 
            } 
        </script>
<!-- InstanceEndEditable -->
<link href="/library/styles/screen.css" rel="stylesheet" type="text/css" />
<link href="/library/styles/screen-header.css" rel="stylesheet" type="text/css" />    
<link href="/library/styles/screen-mainnav.css" rel="stylesheet" type="text/css" />    
<link href="/library/styles/screen-content.css" rel="stylesheet" type="text/css" />
<link href="/library/styles/screen-sidebar.css" rel="stylesheet" type="text/css" />
<link href="/library/styles/library.css" rel="stylesheet" type="text/css" />  
<link href="/library/styles/print.css" rel="stylesheet" type="text/css" media="print" />
</head>
<body>
<div id="wrapit">
<div id="header">
  <div id="header-left">
    <div id="logo"><a href="http://www.utdallas.edu/"><img src="/library/images/UTDlogo.gif" alt="The University of Texas at Dallas" width="191" height="73" border="0" /></a></div>
  </div>
  <div id="header-right">
    <div id="toplinks">
        <ul>
          <li></li>
          <li></li>
        </ul>
    </div>
    <div id="sitetitle">
    <a href="http://www.utdallas.edu/library/"><img src="/library/images/LibLogo.png" width="300" height="30" border="0" /></a>
    <!-- InstanceBeginEditable name="site-title" -->	
	<!-- InstanceEndEditable -->
    </div>
  </div>
</div>
<?php include '../../includes/mainnav.html'; ?>
<?php include '../../includes/subnav.html'; ?>
<div id="breadcrumbs">
	<!-- InstanceBeginEditable name="breadcrumbs" -->
    <a href="http://www.utdallas.edu/library/">Library</a> &gt; <a href="http://www.utdallas.edu/library/about/">About</a> &gt; Contacts
	<!-- InstanceEndEditable -->    
</div>
<?php include '../../includes/todayHours.html';
        ?>
<div id="container">
	<div id="content">
		<div id="content-left">
        	
    		<!-- InstanceBeginEditable name="content-left" -->
            	 <div id="sidebar-navigation">
                 		
                         
                        <h3>Search &amp; Filter</h3>
                        <input id="search" type="text"/>
                        	<h4><a href="mcdermott.pdf">Library Organizational Chart</a></h4>
				<h4><a href="/library/faculty/selectors.html">Library Materials Selectors</a></h4>
                            <div id="school" class="category">
                                <h4>LIBRARY LIAISON</h4>
                                <?php
                                /* This part does : 
                                 * 1) Gets all the schools from all the people.
                                 * 2) Takes only unique ones from it.
                                 * 3) Sorts it and displays the school filter in the left nav.
                                 */
                                $schools = array();
                                foreach ($data["contacts"] as $person) {
                                    foreach ($person["schools"] as $key => $schooldata) {
                                        if (!empty($schooldata['school']))
                                            array_push($schools, $schooldata['school']);
                                    }
                                }
                                $schools = array_unique($schools);
                                sort($schools, SORT_STRING);
                                foreach ($schools as $school) {
                                    print <<< SCHOOLOPTION
						<div class="filterdata">
							<div class="checkbox"><input class="filtercheck" type="radio" name="filterradio"
								value="$school" /> </div> <div
								class="filterstring">$school</div>
						</div>
SCHOOLOPTION;
                                }
                                ?>
                            </div>
                            <?php
                            if ($liasons_only != 1) {
                                ?>

                                <div id="department" class="category">
                                    <h4>DEPARTMENT</h4>
                                    <?php
                                    /* This part does : 
                                     * 1) Gets all the departments from all the people.
                                     * 2) Takes only unique ones from it.
                                     * 3) Sorts it and displays the department filter in the left nav.
                                     */
                                    $departments = array();
                                    foreach ($data["contacts"] as $person) {
                                        array_push($departments, $person["department"]);
                                    }
                                    $departments = array_unique($departments);
                                    sort($departments, SORT_STRING);
                                    foreach ($departments as $department) {
                                        print <<< DEPARTMENTOPTION
						<div class="filterdata">
							<div class="checkbox"><input class="filtercheckdep" type="radio" name="filterradio"
								value="$department" /> </div> <div class="filterstring">$department</div>
						</div>
DEPARTMENTOPTION;
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div>
                                <input type="button" id="reset" value="Reset" />
                            </div>
                    </div>
			<!-- InstanceEndEditable -->
		</div>  
  		<div id="main"> 
  			<!-- InstanceBeginEditable name="content-heading" -->
            <div class="contactsHeading" align="left">Contacts</div>
            
			<!-- InstanceEndEditable -->
    		<!-- InstanceBeginEditable name="content-main" -->
            <table id="contacts" name="contacts">
                        <thead>
                            <tr align="left">
                                <th id="name">Name</th>
                                <th id="libdepartment">Library Department</th>
                                <th id="deprep" style="display: none">Department Representative</th>
                                <th id="subject">Subject/Link</th>
                                <th id="school" style="display: none">School</th>
                            </tr>
                        </thead>
                        <tbody align="left">
                            <?php
                            foreach ($data["contacts"] as $person) {
                                $included = false;
                                // Include liasons if liasons only is requested.
                                if ($liasons_only == 1 && !empty($person['schools']) && !empty($person['schools'][0]['school'])) {
                                    $included = true;
                                }
                                if ($exceptions_only == 1 && !empty($person['exception'])) {
                                    $included = true;
                                }
                                if ($liasons_only == 0 && $exceptions_only == 0) {
                                    $included = true;
                                }

                                if (!$included)
                                    continue;
                                $subhtml = "";
                                $schhtml = "";
                                $subjects = array();
                                $subjectlinks = array();
                                $depsupervisor = 0;
                                foreach ($person["schools"] as $key => $schooldata) {
                                    foreach ($schooldata["subjects"] as $key => $subjectdata) {
                                        array_push($subjects, $subjectdata[0]);
                                        array_push($subjectlinks, $subjectdata[1]);
                                    }
                                }

                                for ($i = 0; $i < count($subjects); $i++) {
                                    if ($i == count($subjects) - 1) {
                                        // This is the last subject so don't display a (,) after it.
                                        if (empty($subjectlinks[$i])) {
                                            // This subject has no link so dont have an hyperlink to it.
                                            $subhtml.="$subjects[$i]";
                                        } else {
                                            // This subject has link so have an hyperlink to it.
                                            $subhtml.="<a href=\"$subjectlinks[$i]\">$subjects[$i] </a>";
                                        }
                                    } else {
                                        // This is not the last subject so display a (,) after it.
                                        if (empty($subjectlinks[$i])) {
                                            // This subject has no link so dont have an hyperlink to it.
                                            $subhtml.="$subjects[$i], ";
                                        } else {
                                            // This subject has link so have an hyperlink to it.
                                            $subhtml.="<a href=\"$subjectlinks[$i]\">$subjects[$i], </a>";
                                        }
                                    }
                                }

                                foreach ($person["schools"] as $key => $schooldata) {
                                    if ($key == count($person["schools"]) - 1) {
                                        $schhtml.="$schooldata[school]";
                                    } else {
                                        $schhtml.="$schooldata[school], ";
                                    }
                                }
                                if (empty($person['profile'])) {
                                    // If person does not have a profile link dont display a hyperlink for him.
                                    $namehtml = "$person[fname]<span id=\"sorter\"> $person[lname]</span>";
                                } else {
                                    // Person has a profile link, display a hyperlink for him.
                                    $namehtml = "<a href=\"$person[profile]\">$person[fname]<span id=\"sorter\"> $person[lname]</span> (IM $person[fname])</a>";
                                }
                                if (!empty($person['depsupervisor'])) {
                                    $depsupervisor = $person['depsupervisor'];
                                }

                                echo <<<TABLEROW
                                <tr>
                                    <td style="background: url(images/$person[image]) left center no-repeat; background-position:5%">
                                        <div id ="datadiv" >
                                            <p class="name">$namehtml</p>
                                            <p class="title">$person[title]</p>
                                            <p class="phone">$person[phone]</p>
                                            <p class="email"><a href="mailto:$person[email]">$person[email]</a></p>
                                        </div>
                                    </td>
                                    <td><span id="sorter">$person[department]</span></td>
                                    <td style="display:none"><span id="sorter">$depsupervisor</span></td>
                                    <td>$subhtml</td>
                                    <td style="display:none"><span id="sorter">$schhtml</span></td>
                                </tr>
TABLEROW;
                            }
                            ?>
                        </tbody>
                    </table>
			<!-- InstanceEndEditable -->
        </div>
    	<div id="content-right">
   			<!-- InstanceBeginEditable name="content-right" -->
			<!-- InstanceEndEditable -->
    	</div>
        
	</div>
</div>
</div>
<div id="footer">
        	<ul>
            	<li><a href="/library/about/hours.html">Hours</a></li>
                <li><a href="/library/about/directions.html">Directions</a></li>
                <li><a href="/library/about/contacts/contacts.php">Contacts</a></li>
                <li><a href="/library/about/policies/">Policies</a></li>
                <li><a href="/library/about/employment.html">Library Employment</a></li>
                <li><a href="/library/about/statistics/">Library Statistics</a></li>
          </ul><br/>
          <ul>
          	<li>The Eugene McDermott Library<br/>
          		800 West Campbell Road, Richardson, TX 75080<br/>                
          		<strong>(972)-883-2955</strong><br/>   
                <a href="mailto:libwebhelp@utdallas.edu">libwebhelp@utdallas.edu</a></li></ul>
<div class="feedback">
          		<img src="/library/images/feddeplib.png" alt="Federal Depository Library" />
</div>
        </div>
<!--#include virtual="/websvcs/shared/sdc.js"-->
</body>
<!-- InstanceEnd --></html>
