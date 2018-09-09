<!DOCTYPE html>
<html>
    <head>
        <title>PA Education system</title>
        <link rel="stylesheet" href="css/edu.css">
        <link rel="stylesheet" href="css/teacher.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- 引入 Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        
        <!--        nav-tabs-->
        <ul class="nav nav-tabs">
        <li role="presentation"><a href="index.html">Home</a></li>
        <li role="presentation" class="active"><a href="data.php">Data Statistics</a></li>
        <li role="presentation"><a href="graph.html">Queries</a></li>
        </ul>
        
    </head>
    
    <body>
        <h1 class="title">PA Education System</h1>
        
        <div class="list-group">
        <a href="data.html" class="list-group-item active">
            <h4 class="list-group-item-heading">
            School
            </h4>
        </a>
        <a href="teacher.php" class="list-group-item">
        <h4 class="list-group-item-heading">
            Teachers 
        </h4>
        </a>
        <a href="#" class="list-group-item">
        <h4 class="list-group-item-heading">
            Test Score
        </h4>
        </a>            
        </div>  
        
        <?php
        $firstyear=isset($_POST['fyear'])?$_POST['fyear']:'';     
        $_SESSION['fyear']=$firstyear;
        $fy=isset($_SESSION['fyear'])?$_SESSION['fyear']:'';
        
        $lastyear=isset($_POST['lyear'])?$_POST['lyear']:'';     
        $_SESSION['lyear']=$lastyear;
        $ly=isset($_SESSION['lyear'])?$_SESSION['lyear']:'';  
        
        $subject=isset($_POST['subject'])?$_POST['subject']:'';     
        $_SESSION['subject']=$subject;
        $sub=isset($_SESSION['subject'])?$_SESSION['subject']:''; 
        ?>
        
        
        
        <div class="search">
             <form action="score.php" method="post" id="my_form">
        <!-- county select -->
            <label class="lab">County:</label>
            <select class="select" onchange="submitForm();">
            <option value="*">all</option>
            </select>
        <!-- distrct select -->
            <label class="lab dis">Distric:</label>
            <select class="select" onchange="submitForm();">
            <option value="*">all</option>
            </select>
        <!-- subject select-->
            <label class="lab" id="sub">Subject:</label>
            <select  class="select" onchange="submitForm();" name="subject">
            <option value="Math" <?php if($sub=="Math"){ ?>selected="selected"<?php } ?>>Math</option>
            <option value="Reading" <?php if($sub=="Reading"){ ?>selected="selected"<?php } ?>>Reading</option>
            <option value="Science" <?php if($sub=="Science"){ ?>selected="selected"<?php } ?>>Science</option>
            <option value="Writing" <?php if($sub=="Writing"){ ?>selected="selected"<?php } ?>>Writing</option>
            <option value="Biology" <?php if($sub=="Biology"){ ?>selected="selected"<?php } ?>>Biology</option>
            </select>
        <!-- year select -->
            <label class="lab" id="fyear">From</label>
            <select  class="select" onchange="submitForm();" name="fyear">
            <option value="2010" <?php if($fy==2010){ ?>selected="selected"<?php } ?>>2010</option>
            <option value="2011" <?php if($fy==2011){ ?>selected="selected"<?php } ?>>2011</option>
            <option value="2012" <?php if($fy==2012){ ?>selected="selected"<?php } ?>>2012</option>
            <option value="2013" <?php if($fy==2013){ ?>selected="selected"<?php } ?>>2013</option>
            <option value="2014" <?php if($fy==2014){ ?>selected="selected"<?php } ?>>2014</option>
            <option value="2015" <?php if($fy==2015){ ?>selected="selected"<?php } ?>>2015</option>
            <option value="2016" <?php if($fy==2016){ ?>selected="selected"<?php } ?>>2016</option>
            </select>
                 
            <label class="lab" id="lyear">To</label>
            <select  class="select" onchange="submitForm();" name="lyear">
            <option value="2011" <?php if($ly==2011){ ?>selected="selected"<?php } ?>>2011</option>
            <option value="2012" <?php if($ly==2012){ ?>selected="selected"<?php } ?>>2012</option>
            <option value="2013" <?php if($ly==2013){ ?>selected="selected"<?php } ?>>2013</option>
            <option value="2014" <?php if($ly==2014){ ?>selected="selected"<?php } ?>>2014</option>
            <option value="2015" <?php if($ly==2015){ ?>selected="selected"<?php } ?>>2015</option>
            <option value="2016" <?php if($ly==2016){ ?>selected="selected"<?php } ?>>2016</option>
            <option value="2017" <?php if($ly==2017){ ?>selected="selected"<?php } ?>>2017</option>
            </select>
        <!--order by -->
            <br>
            <br>
        <label class="lab">Order by:</label>
        <div class="btn-group">
        <button  class="btn btn-default" value="Percent_Adv" name="query">Percent Advanced</button>
        <button  class="btn btn-default" value="Percent_Pro" name="query">Percent Proficient</button>
        <button  class="btn btn-default" value="Percent_Basic" name="query">Percent Basic</button>   
        </div>
        </form>
            
            
        </div>
        <div class="result">
            <div class="query">
            <?php
            error_reporting(E_ALL || ~E_NOTICE);
            define(DB_HOST, 'localhost');
            define(DB_USER, 'root');
            define(DB_PASS, '123456');
            define(DB_DATABASENAME, 'PA_edu');
            define(DB_TABLENAME, 'school_query');
            
            $dbcolarray = array('Year_ID', 'County_Name', 'School_Name', 'Percent_Adv', 'Percent_Pro', 'Percent_Basic');
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die("connect failed" . mysqli_error());
            mysqli_select_db($conn,DB_DATABASENAME); 
            
            $query = $_REQUEST['query'];
            $sub   = $_REQUEST['subject'];
            $fyear = $_REQUEST['fyear'];
            $lyear = $_REQUEST['lyear'];  
                
            echo "TOP 20 School based on $sub score $query <br />";    
        
            
            switch ($fyear){
                case 2010: $from = 201011; break;
                case 2011: $from = 201112; break;
                case 2012: $from = 201213; break;
                case 2013: $from = 201314; break;
                case 2014: $from = 201415; break;
                case 2015: $from = 201516; break;
                case 2016: $from = 201617; break;
            }
                
             switch ($lyear){
                case 2011: $to = 201011; break;
                case 2012: $to = 201112; break;
                case 2013: $to = 201213; break;
                case 2014: $to = 201314; break;
                case 2015: $to = 201415; break;
                case 2016: $to = 201516; break;
                case 2017: $to = 201617; break;
            }
            
            $count[0] = 0;    
            $sql = sprintf("select count(*) from %s where Year_ID>=%s and Year_ID<=%s  order by %s desc limit 20", DB_TABLENAME,$from,$to,$query);
            $result = mysqli_query($conn,$sql);
            if ($result)
            {
	       $count = mysqli_fetch_row($result);
            }
//            else
//            {
//	        die("query failed");
//            }
                
            echo "find $count[0] records<br />";
            echo "<br>";
                
            $sql = sprintf("select Year_ID,County_Name,School_Name,Percent_Adv,Percent_Pro,Percent_Basic from %s where Year_ID>=%s and Year_ID<=%s and Subject=\"%s\" order by %s desc limit 20", DB_TABLENAME,$from,$to,$sub,$query);
            $result = mysqli_query($conn,$sql);
            echo '<table class="t" border=1>'; 
            $thstr = "<th class=\"h\">" . implode("</th><th class=\"h\">", $dbcolarray) . "</th>";
            echo $thstr;
            
            while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
	           echo "<tr>";
	           $tdstr = "";
	           foreach ($dbcolarray as $td)
               $tdstr .= "<td>$row[$td]</td>";
               echo $tdstr;
	           echo "</tr>";
            }
            echo "</table>";
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
            </div>
        </div>

      
        <div class="list-group">
        <a href="district.html" class="list-group-item active">
        <h4 class="list-group-item-heading">
            District
        </h4>
        </a>
        <a href="dropout.php" class="list-group-item">
        <h4 class="list-group-item-heading">
            Dropout
        </h4>
        </a>
        <a href="tuition.php" class="list-group-item">
        <h4 class="list-group-item-heading">
            Tuition
        </h4>
        </a>
        <a href="revenue.php" class="list-group-item">
        <h4 class="list-group-item-heading">
            Revenues
        </h4>
        </a>
        <a href="expenditure.php" class="list-group-item">
        <h4 class="list-group-item-heading">
            Expenditure
        </h4>
        </a>
            
        </div>
        <div class="list-group">
        <a href="county.html" class="list-group-item active">
        <h4 class="list-group-item-heading">
            County
        </h4>
        </a>
        <a href="crime.php" class="list-group-item">
        <h4 class="list-group-item-heading">
            Crime
        </h4>
        </a>
        </div>
        
        
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/submit.js"></script>
    </body>
</html>