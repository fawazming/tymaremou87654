<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYMa Tags</title>
    <link rel="stylesheet" href="<?=base_url('assets/css/paper.css')?>">
     <!-- Set page size here: A5, A4, A4 landscape, letter, legal or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>@page { size: A4 }</style>
    <style>
        body{
            font-family: 'Tahoma';
            line-height: 1.1rem;
        }
        .container{
            display: flex;
            flex-direction:row;
            flex-wrap: wrap;
            align-content: flex-start;
            justify-content: space-between;
            align-items: center;
        }
        .card{
            height: 88mm;
            width: 44mm;
            background-color: #fff;
            border: 2px #000 solid;
            padding: 1mm 3mm;
            margin: 0;
        }
        .center{
            text-align: center;
        }
        /*.logo{
            line-height: 0.99rem;
        }*/
        .m-0{
            margin: 0;
        }
        .mt-1{
            margin-top: 3px;
        }
    </style>
</head>
<body class="A4">

    <?php
        function ab($val){
            return strtoupper(substr($val,0,1));
        }
        function ab1($val){
            return strtoupper(substr($val,0,2));
        }
        function ib($val){
            if ($val > 0 && $val < 10) {
                return '00'.$val;
            }elseif ($val > 10 && $val < 100) {
                return '0'.$val;
            }else{
                return $val;
            }
        }
        function ageGroup($age)
        {
            // dd($age);
            //  ,  and  , 15 and above > Platinum
            if($age == '4-6'){
                return '4-6 Bronze';
            }elseif ($age == '7-9') {
                return '7-9 Silver';
            }elseif ($age == '10-12') {
                return '10-12 Gold';
            }elseif ($age == '13 and above') {
                return '13+ Platinum';
            }elseif ($age == 'Worker') {
                return 'Worker';
            }
        }
        $counter = 1;
            echo"<div class='container sheet'>";

        foreach ($del as $key => $de) {
            if ($counter == 12) {
                $counter = 0;
                echo"
    <div class= 'card'>
        <div style='display: flex; justify-content:space-between'>
        <img src='https://tymaegbayewa.com.ng/img/logo.png' alt='TYMa Logo' style='width: 50px; height: 50px;'>
        <img src='https://tymaegbayewa.com.ng/img/tyfllogo.png' alt='TYLf Logo' style='width: 50px; height: 50px;'>
        </div>
        <h1 style='font-size:18px'> National Muslim Children Camping Program <span style='font-size: 10px;'>(NMCCP '2024)</span></h1>
        <hr style='height: 2px; background-color: black;'>
        <label for='name'>Name</label>
        <p style='line-height:1rem;' id='name' class='m-0'><b>".$de[0]['fname']."</b> ".$de[0]['lname']."</p><br>
        <label for='age_range'>Age Group</label>
        <p align-text:center;' id='age_range' class='m-0'><b>".ageGroup($de[0]['age'])."</b></p><br>
        <label for=''>Group: </label> <b>".$de[0]['house']."</b> <br><br>
        <label style='line-height:0.3rem;' for='dtag'>Delagate Tag</label>
        <p id='dtag' class='m-0'><b>TY-".ab($de[0]['gender'])."-".ib($de[0]['id'])."</b></p>
    </div>

            </div>
                <div class='container sheet'>";
            }else{
                echo "
    <div class= 'card'>
        <div style='display: flex; justify-content:space-between'>
        <img src='https://tymaegbayewa.com.ng/img/logo.png' alt='TYMa Logo' style='width: 50px; height: 50px;'>
        <img src='https://tymaegbayewa.com.ng/img/tyfllogo.png' alt='TYLf Logo' style='width: 50px; height: 50px;'>
        </div>
        <h1 style='font-size:18px'> National Muslim Children Camping Program <span style='font-size: 10px;'>(NMCCP '2024)</span></h1>
        <hr style='height: 2px; background-color: black;'>
        <label for='name'>Name</label>
        <p style='line-height:1rem;' id='name' class='m-0'><b>".$de[0]['fname']."</b> ".$de[0]['lname']."</p><br>
        <label for='age_range'>Age Group</label>
        <p align-text:center;' id='age_range' class='m-0'><b>".ageGroup($de[0]['age'])."</b></p><br>
        <label for=''>Group: </label> <b>".$de[0]['house']."</b> <br><br>
        <label style='line-height:0.3rem;' for='dtag'>Delagate Tag</label>
        <p id='dtag' class='m-0'><b>TY-".ab($de[0]['gender'])."-".ib($de[0]['id'])."</b></p>
    </div>

                ";
            }
            $counter++;
        }
    echo"</div>";
    ?>


</body>
</html>