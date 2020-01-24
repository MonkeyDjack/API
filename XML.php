<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <title>CompanyEmployeesApi</title>
       <link rel="stylesheet" href="style.css">
        

        
           
        <?php

        $ch = curl_init();
        $url = 'http://127.0.0.1:5000/XMLGrades';
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $information = curl_exec($ch);
       
        curl_close($ch);
        // Validate the result from the $json to the schema.json saved locally to check if the data is correct, otherwise return the appropiate error.

    require_once 'vendor/autoload.php';


          $informationRecived = simplexml_load_string($information);

        
 
    ?>


   
        
        
    </head>
    <body>
     
   
            <h1>Grades</h1>
            <?php
            
          
            include "xsd/validator.php";
                function libxml_display_errors() {
                    $errors = libxml_get_errors();
                    foreach ($errors as $error) {
                        print libxml_display_error($error);
                    }
                    libxml_clear_errors();
                }
                
                // Enable user error handling
                libxml_use_internal_errors(true);

                $xml = new DOMDocument();

                $xml->load('http://127.0.0.1:5000/XMLGrades');

                if (!$xml->schemaValidate('xsd/XMLStudentsGrades.xsd')) {
                    print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
                    libxml_display_errors();
                } else {
                    echo "<script>console.log('Validated!')</script>";
                    echo "<p>XML VALIDATED!</p>";
                }

    ?>

            <table style='width:100%'>
            <tr class='header'>
                <th>Student First name</th>
                <th>Last Name</th>
                <th>Age </th>
                <th> Semester </th>
                <th> Class name </th>
                <th> Grade </th>
            </tr>
            <tr>
                <?php
                        
                foreach ($informationRecived as $informationRecived)  
                {
                    echo "<tr class='line'><td>".$informationRecived->studentFirstName."</td>";
                    echo "<td>".$informationRecived->studentLastName."</td>";
                    echo "<td>".$informationRecived->Age."</td>";           
                    echo "<td>".$informationRecived->Semester."</td>"; 
                    echo "<td>".$informationRecived->ClassName."</td>"; 
                    echo "<td>".$informationRecived->Grade."</td></tr>"; 
                    
                }
                ?>
            </tr>
            </table>
            
            
            <?php 
            
                $chClasses = curl_init();
        
                $urlClasses = 'http://127.0.0.1:5000/XMLStudentsClass';

                curl_setopt($chClasses,CURLOPT_URL,$urlClasses);

                curl_setopt($chClasses,CURLOPT_HEADER, false);

                curl_setopt($chClasses,CURLOPT_RETURNTRANSFER,true);

                $infoClasses= curl_exec($chClasses);
                
                $infoRecivedClasses = simplexml_load_string($infoClasses);

                curl_close($chClasses);
                
                 // Enable user error handling
                libxml_use_internal_errors(true);
                
            
            //xml for charts
                $xmlClasses = new DOMDocument();
                $xmlClasses->load('http://127.0.0.1:5000/XMLStudentsClass');
                 
                  if (!$xmlClasses->schemaValidate('xsd/XMLStudentClasses.xsd')) 
                      {
                        print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
                        libxml_display_errors();
                      } 
                else 
                    
                 {
                        
                    $php_count = null;
                    $fed_count = null;
                    $java_count = null;
                    $info_man = null;
                     foreach($infoRecivedClasses as $infoRecivedData)
                {
            
                    if($infoRecivedData ->ClassName == "FED")
                    {
                        
                        $fed_count ++;
                    }
                    else if($infoRecivedData->ClassName == "PHP 2")
                    {
                        
                        $php_count ++;
                    }else if($infoRecivedData->ClassName == "Java 2")
                    {
                        
                        $java_count ++;
                    }else if($infoRecivedData->ClassName == "Information Management")
                    {
                        
                        $info_man ++;
                    }
                }
                            
                            // Draw the chart 
                            $dataPoints = array( 

                                array("label"=> "PHP 2", "y"=> $php_count),
                                array("label"=> "FED", "y"=> $fed_count),
                                array("label"=> "Java 2", "y"=> $java_count),
                                array("label"=> "Information Management", "y"=> $info_man)
                            );    
                 }
            
            
            
            ?>
             <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Top Classes"
	},
	axisY: {
		title: "people",
		includeZero: false
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


            </tr>
            </table>
            
    </body>
</html>
