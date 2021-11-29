<?php


$fileN=$argv[1];

$myfile = fopen($fileN, "r") or die("Unable to open file!");

$jsonfile = fopen("Product_Json_File.json", "w") or die("Unable to open file!");

$padjsonfile = fopen("Product_Objects_Json_format.txt", "w") or die("Unable to open file!");

$newfile = fopen("comma_separated_products_objects.csv", "w") or die("Unable to open file!");

$textfile = fopen("comma_separated_objects.txt", "w") or die("Unable to open file!");

$combofile = fopen("Unique_Combination.csv", "w") or die("Unable to open file!");
  

$tfile = file($fileN);


$headers = array();




$hs=fgets($myfile);
$headers = explode(',',$hs);
$new = implode(',',$headers);

fwrite($textfile,$new);




$titles=[];

$tok = strtok($hs, ",");
array_push($titles,str_replace('"','',$tok)); 
while ($tok !== false) {
  $tok = strtok(",");
  array_push($titles,str_replace('"','',$tok));
}

fputcsv($newfile,$titles);
$titles[7]=' Count';
fputcsv($combofile,$titles);

  $sa = array_slice($tfile,1);
      
  $cs = implode(' ',$sa);

  $f = explode (',',str_replace('"','',$cs));
     
                  
          $cnt =  array_count_values($sa);
          $ua = array_unique($sa);
           foreach($ua as $c)
            {  
               $count=$c.','.$cnt[$c];
               $mess = str_replace('"','',$count);
               $ca = explode(',',$mess);
               fputcsv($combofile,$ca);
            } 

    

  $array1=array();
  $make=[];
  $model=[];
  $condition=[];
  $grade=[];
  $capacity=[];
  $colour=[];
  $network=[];
  $all=array();
  $ob=[];
    

       //CSV PART
       for($i=0;$i<count($sa);$i++)
       {
           $trimmed=str_replace('"','',$sa[$i]);
        //    $trimmed=trim($sa[$i],'"');
           $dif = explode(',',$trimmed); 
           $imp = implode(',',$dif);
          //  echo $imp;
           fwrite($textfile,$imp);
           if($dif[0]=='')
           {
             throw new Exception("maker name needed");
           }
           else{
               $array1['make']=$dif[0];
           }
           if($dif[1]=='')
           {
            throw new Exception("model name needed");
           }
           else{
                $array1['model']=$dif[1];
            }
           $array1['condition']=$dif[2];
           $array1['grade']=$dif[3];
           $array1['capacity']=$dif[4];
           $array1['colour']=$dif[5];
           $array1['network']=$dif[6];
         
           
             $js = json_encode($array1);

             array_push($ob,$js);

            
            $object = json_decode(json_encode($array1), FALSE);
            $js =  json_encode($array1);
            //  print_r($object.'<br>');
            
            array_push($make,$object->make);
            array_push($model,$object->model);
            array_push($condition,$object->condition);
            array_push($grade,$object->grade);
            array_push($capacity,$object->capacity);
            array_push($colour,$object->colour);
            array_push($network,$object->network);
            fputcsv($newfile,$array1);
          }
        //    print_r($array1);
          
             //OBJECTS JSON FORMAT 
             for($i=0;$i<count($ob);$i++)
             {  
                 $data = $ob[$i].'      ';
                fwrite($padjsonfile,$data);
                fwrite($jsonfile,$data);
             }
               echo 'done';
            


?>