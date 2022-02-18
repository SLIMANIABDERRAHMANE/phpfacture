<?php

    class Tranche {
        public $borneMin;
        public $borneMax;
        public $tarif;

        function __construct($bmin, $bmax, $tar){
            $this->borneMin = $bmin;
            $this->borneMax = $bmax;
            $this->tarif = $tar;
        }

    }
    $tva = 14;
    $tarifs = [
        new Tranche(0, 100, 0.794), 
        new Tranche(101, 150, 0.883),
        new Tranche(151, 210, 0.9451),
        new Tranche(211, 310, 1.0489),
        new Tranche(311, 510, 1.2915),
        new Tranche(511, null, 1.4975)
    ];
    $timber = 0.45;
    $oldIndex;
    $newIndex;
    $consommation;
    $montantsFacture = array(); 
    $montantsHT = array(); 

    if (isset($_POST["submit"])) {
        $oldIndex = $_POST["oldIndex"];
        $newIndex = $_POST["newIndex"];
        $calibre = $_POST["calibre"];
        $consommation = $newIndex - $oldIndex;
        $total_initial = 0;
        
        if($consommation <= 150) {
            if($consommation <= $tarifs[0]->borneMax) {
                $montantsFacture[0] = $consommation;
                $montantsHT[0] = $consommation * $tarifs[0]->tarif;
                $total_initial = $montantsHT[0];
            }
            
            else {
                $montantsFacture[0] = 100;
                $montantsFacture[1] = $consommation - $montantsFacture[0];
                $montantsHT[0] = $montantsFacture[0] * $tarifs[0]->tarif;
                $montantsHT[1] = $montantsFacture[1] * $tarifs[1]->tarif;
                $total_initial = $montantsHT[0] + $montantsHT[1];
            }
        }
      
        else {
            if($consommation <= $tarifs[2]->borneMax) {
                $montantsFacture[2] = $consommation;
                $montantsHT[2] = $consommation * $tarifs[2]->tarif;
                $total_initial = $montantsHT[2];
            }
            else if($consommation <= $tarifs[3]->borneMax) {
                $montantsFacture[3] = $consommation;
                $montantsHT[3] = $consommation * $tarifs[3]->tarif;
                $total_initial = $montantsHT[3];
            }
            else if($consommation <= $tarifs[4]->borneMax) {
                $montantsFacture[4] = $consommation;
                $montantsHT[4] = $consommation * $tarifs[4]->tarif;
                $total_initial = $montantsHT[4];
            }
            else{
                $montantsFacture[5] = $consommation;
                $montantsHT[5] = $consommation * $tarifs[5]->tarif;
                $total_initial = $montantsHT[5];
            }
        }
    }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>calcul</title>
</head>
<style>
   #calcul{
            background-color: #747cdf;
            text-align: center;
            color: white;
            width: 100px;
            font-size: 15px;
             border: none;
            border-radius: 5px;
            outline: none;
            cursor: pointer;
            font-weight: bold;
        }
       input{
        padding: 7px 3px 7px 20px;
        border: 1px solid #c9c9c9;
        outline-color: #747cdf;
        border-radius: 5px;
       }
       form{
           display: grid;
           grid-template-columns: auto auto auto auto;
           gap: 60px;
           padding: 30px 80px;
       }
       #cal{
    margin-top: 15px;
}
#print {
    width: 70px;
    background-color: #747cdf;
    color: white;
    height: 40px;
    border-radius: 8px;
    margin-top: 15px;
    float: right;
}
img{
    margin: 10px 10px 30px 180px;
    width:15% ;
    height: 80px;
    
}
h2{
    text-align: center;
    margin: 40px 40px;
    color: #747cdf;
    
}body{
    background-color: #EEF2F3;
}






</style>
<body>
    <img src="logosolidao.PNG" >
    <h2>Interface de simulation d'une facture d'électricité</h2>
<section id="inputs">
<form method="POST">

    <input type="number" name="oldIndex" placeholder="Old Index">
     <input type="number" name="newIndex" placeholder="New Index">
     <div>
     <input type="radio" id="cal" value="22.65" name="calibre" >5-15 &nbsp;
        <input type="radio" value="37.05" name="calibre">15-20 &nbsp;
        <input type="radio" value="46.20" name="calibre">>30 
    </div>
        <input type="submit" id="calcul" value="Calcul" name="submit">
        <button id="print" onclick="valida()">PRINT</button>
</form>
</section>
    

   <table class="table table-borderless">
            <thead>
                <tr>
                    <th></th>
                    <th>مفوتر <br><span>Facturé</span></th>
                    <th>س.و<br><span>P.U</span></th>
                    <th>مبلغ د.إ.ر <br><span></span>Montant HT</th>
                    <th>ض.ق.م <br><span></span>Taux TVA</th>
                    <th>مبلغ الرسوم <br><span> </span>Montant Taxes</th>
                    <th><span></span></th>
                </tr></thead> 
                <tr>
                    <th>CONSOMMATION ELECTRICITE</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>ستھلاك الكھرباء</th>
                </tr>
        <?php
        if (isset($_POST["submit"])) {    
            foreach($montantsFacture as $key => $value) {
              
        ?>
     
                <tr>
                    
                    <td>Tranche &nbsp;<?php echo $key+1?></td>
                    <td><?php echo $value ?></td>
                    <td><?php echo $tarifs[$key]->tarif ?></td>
                    <td><?php echo $montantsHT[$key] ?></td>
                    <td><?php echo $tva . "%";?></td>
                    <td><?php echo ($montantsHT[$key] * $tva /100)?></td>
                   

                </tr> <?php } ?>
                <tr>
                    <th>REDEVANCE ELECTRIQUE</th>
                    <td></td>
                    <td></td>
                    <td><?php echo $calibre ?></td>
                    <td><?php echo $tva . "%";?></td>
                    <td><?php echo $calibre * $tva /100 ?></td>
                    <th>  إثاوة ثابتةالكھرباء</th>
                    <tr>
                    <th>TAXES POUR LE COMPTE DE L’ETAT</th>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                    <th>   الرسوم المؤداة لفائدة الدولة</th>
                </tr>

                </tr>
               <?php foreach($montantsFacture as $key => $value) { ?>
             
             <?php } ?>
             
                   <tr>
                    <th>TOTAL TVA</th>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><?php echo ($total_initial * $tva /100) +  ($calibre * $tva /100) ?></td>
                    <th>مجموع ض.ق.م</th>
                </tr>
                <tr>
                    <th>TIMBRE</th>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><?php echo $timber ?></td>
                    <th>الطابع </th>
                </tr>
              
                <tr>
                    <th>SOUS-TOTAL</th>
                  <td></td>
                  <td></td>
                  <td><?php echo $total_initial ?></td>
                  <td></td>
                  <td><?php echo $timber +($total_initial * $tva /100) +  ($calibre * $tva /100) ?></td>
                    <th>المجموع الجزئي</th>
                </tr>
                <?php  ?>
                <tr>
                    <th>TOTAL ELECTICITE</th>
                  <td></td>
                  <td></td>
                  <th><?php echo $total_initial + $timber + ($total_initial * $tva /100) +  ($calibre * $tva /100) ?></th>
                  <td></td>
                  <td></td>
                    <th>مجموع الكھرباء</th>
                </tr><?php ?>
            </thead>
            </tbody>
        </table>

        <?php
            }
        
        ?>
    </table>
<script type="text/javascript">
function valida(){
    var print=document.getElementById('print');
   
    window.print();
    
}
</script>

</body>
</html>