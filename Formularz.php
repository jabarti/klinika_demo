<?php
/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    Formularz.php
 * Encoding:    UTF-8
 * Created:     2016-08-05
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
?>
<script src="Controllers/FormularzController.js" type="text/javascript"></script>
<script src="js_source/mapper/mapper.js" type="text/javascript"></script>
<script src="js_source/mapper/maputil.js" type="text/javascript"></script> 


<div class="container" >  

<!--h1><u>Opisujesz panią (rodzic): <span style="color:blue;" id="add_imie_mama"></span> <span style="color:blue;" id="add_nazwisko_mama"></span> i dziecko <span id="add_imie_dziecko" style="color:blue;"></span></u></h1-->

    <div class="row">
        <div class="col-md-12">
            <br>
            <!--<form id="NyFormularz" name="NyFormularz" class="form-horizontal" novalidate >-->
            <form id="NyFormularz" name="NyFormularz" class="form-horizontal"  >

                <!-- DANE FORMULARZA -->
                <?php include $FORM01_PATH . 'NyForm_01_dane.html'; ?>                   

                <!-- MAMA -->
                <?php include $FORM01_PATH . 'NyForm_02_mama.html'; ?> 

                <!-- DZIECKO -->
                <?php include $FORM01_PATH . 'NyForm_03_dziecko.html'; ?> 

                <!-- POWÓD ZGŁOSZENIA -->
                <?php include $FORM01_PATH . 'NyForm_04_powod.html'; ?> 

                <!-- KARMIENIE W SZPITALU -->
                <?php include $FORM01_PATH . 'NyForm_05_karmienieSzpital.html'; ?> 

                <!-- KARMIENIE OBECNIE -->
                <?php include $FORM01_PATH . 'NyForm_06_karmienieObecnie.html'; ?>

                <!-- OBSERWACJA MATKI -->
                <?php include $FORM01_PATH . 'NyForm_07_obserwacjaM.html'; ?>

                <!-- OBSERWACJA DZIECKA -->
                <?php include $FORM01_PATH . 'NyForm_08_obserwacjaDz.html'; ?>

                <!-- MECHANIZM SSANIA -->
                <?php include $FORM01_PATH . 'NyForm_09_ssanie.html'; ?>

                <!-- ROZPOZNANIE -->
                <?php include $FORM01_PATH . 'NyForm_10_rozpoznanie.html'; ?>

                <!-- ZALECENIA -->
                <?php include $FORM01_PATH . 'NyForm_11_zalecenia.html'; ?>

                <!-- SUBMIT -->
                <button type="submit" class="btn btn-success btn-lg btn-block">
                    <span class="glyphicon glyphicon-flash"></span> Zapisz formularz!
                </button>

            </form>
        </div>
    </div>

    <?php if ($TEST_VER) { ?>
        <pre>
                    <span id="message"></span>
        </pre>
    <?php }; ?>
</div>

