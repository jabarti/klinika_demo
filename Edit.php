<?php
/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    Edit.php
 * Encoding:    UTF-8
 * Created:     2016-08-06
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
?>
<script src="Controllers/EditController.js" type="text/javascript"></script>
<script src="js_source/mapper/mapper.js" type="text/javascript"></script> 
<script src="js_source/mapper/maputil.js" type="text/javascript"></script>       

<div  class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" role="form" id="EditForm" name="EditForm" >

                <!-- DANE FORMULARZA -->
                <?php include $EDIT01_PATH . 'EditForm_01_dane.html'; ?>  

                <!-- MAMA -->
                <?php include $EDIT01_PATH . 'EditForm_02_mama.html'; ?>  

                <!-- DZIECKO -->
                <?php include $EDIT01_PATH . 'EditForm_03_dziecko.html'; ?>  

                <!-- POWÓD ZGŁOSZENIA -->
                <?php include $EDIT01_PATH . 'EditForm_04_powod.html'; ?>  

                <!-- KARMIENIE W SZPITALU -->
                <?php include $EDIT01_PATH . 'EditForm_05_karmienieSzpital.html'; ?>  

                <!-- KARMIENIE OBECNIE -->
                <?php include $EDIT01_PATH . 'EditForm_06_karmienieObecnie.html'; ?>  

                <!-- OBSERWACJA MATKI -->
                <?php include $EDIT01_PATH . 'EditForm_07_obserwacjaM.html'; ?>

                <!-- OBSERWACJA DZIECKA -->
                <?php include $EDIT01_PATH . 'EditForm_08_obserwacjaDz.html'; ?>  

                <!-- SSANIE -->
                <?php include $EDIT01_PATH . 'EditForm_09_ssanie.html'; ?>  

                <!-- ROZPOZNANIE -->
                <?php include $EDIT01_PATH . 'EditForm_10_rozpoznanie.html'; ?>  

                <!-- ZALECENIA -->
                <?php include $EDIT01_PATH . 'EditForm_11_zalecenia.html'; ?>  

                <!-- TEST -->
                <?php
                if ($TEST_VER) {
                    include $EDIT01_PATH . 'TEST_output.html';
                }
                ?>  


            </form>
            <button id="submit" class="btn btn-success btn-lg btn-block">
                <span class="glyphicon glyphicon-floppy-saved"></span> Edytuj!
            </button>

            <button id="delete" class="btn btn-warning btn-lg btn-block">
                <span class="glyphicon glyphicon-remove"></span> Kasuj!
            </button>

        </div>
    </div>
</div>


