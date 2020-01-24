<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <title>CompanyEmployeesApi</title>
        <link rel="stylesheet" href="style.css">
        <?php
        $ch = curl_init();
        $url = 'http://127.0.0.1:5000/JSONGrades';
        
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $information = curl_exec($ch);
        curl_close($ch);
        $informationRecived = (array) json_decode($information);
        $data = json_decode($information);
       
        $chFed = curl_init();
        $urlClass = 'http://127.0.0.1:5000/JSONStudentsClass';
        
        curl_setopt($chFed,CURLOPT_URL,$urlClass);
        curl_setopt($chFed,CURLOPT_HEADER, false);
        curl_setopt($chFed,CURLOPT_RETURNTRANSFER,true);
        $informationClass = curl_exec($chFed);
        curl_close($chFed);
        $informationRecivedClass= (array) json_decode($informationClass);
        $dataClass = json_decode($informationClass);
        
        
        
        
        
        
require_once 'vendor/autoload.php';
//validate schema
$validator = new JsonSchema\Validator();
$validator->validate($data, (object)['$ref' => 'file://' . realpath('JsonGrades.json')]);

//validate schema for graphs
$validatorClass= new JsonSchema\Validator();
$validatorClass->validate($dataClass, (object)['$ref' => 'file://' . realpath('JsonStudentClass.json')]);


if ($validatorClass ->isValid())
                {
                    
                    $informationRecivedClass = (array) json_decode($informationClass,true);
        
                    $php_count = null;
                    $fed_count = null;
                    $java_count = null;
                    $info_man = null;
         
                for($i=0;$i<count($informationRecivedClass);$i++)
                {
            
                    if($informationRecivedClass[$i]['ClassName'] == "FED")
                    {
                        
                        $fed_count ++;
                    }
                    else if($informationRecivedClass[$i]['ClassName'] == "PHP 2")
                    {
                        
                        $php_count ++;
                    }else if($informationRecivedClass[$i]['ClassName'] == "Java 2")
                    {
                        
                        $java_count ++;
                    }else if($informationRecivedClass[$i]['ClassName'] == "Information Management")
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
                

                







if ($validator->isValid()) {
    echo "The supplied JSON validates against the schema.\n";
} else {
    echo "JSON does not validate. Violations:\n";
    foreach ($validator->getErrors() as $error) {
        echo sprintf("[%s] %s\n", $error['property'], $error['message']);
    }
}
        ?>
        
<script>
window.onload = function () {
 //chart jj
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Most popular class"
	},
	axisY: {
		title: "students",
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
        
           
        
        
        
    </head>
    <body>
     
   
            <h1>Students grades</h1>
            <table style='width:100%'>
            <tr class="header">
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
                    //insert data from json
                    echo "<tr class='line'>";
                    echo "<td>".$informationRecived->studentFirstName."</td>";
                    echo "<td>".$informationRecived->studentLastName."</td>";
                    echo "<td>".$informationRecived->Age."</td>";           
                    echo "<td>".$informationRecived->Semester."</td>"; 
                    echo "<td>".$informationRecived->ClassName."</td>"; 
                    echo "<td>".$informationRecived->Grade."</td>";  
                    echo "</tr>";
                }
                ?>
            </tr>
            </table>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            
    </body>
</html>
