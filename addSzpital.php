<?php
/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    addSzpital.php
 * Encoding:    UTF-8
 * Created:     2016-08-17
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
?>
<html>
    <head>
        <script src="Controllers/AddSzpitalController.js" type="text/javascript"></script>
    </head>
    <html>
        <body >
            <div  class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form" id="AddSzpitalForm" name="AddSzpitalForm" >
                            <div class="form-group form-buffer-pa">
                                <h2>Dodaj szpital</h2>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">nazwa</label>
                                    <div class="col-sm-3">
                                        <textarea name="nazwa" id="nazwa" /></textarea>
                                    </div>    
                                </div>
                                <p class="col-sm-12"></p>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">skrót nazwy</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="skrot_nazwy" id="skrot_nazwy" />
                                    </div>    
                                </div>
                                <p class="col-sm-12"></p>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ulica</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="urodz_ulica" id="urodz_ulica" />
                                    </div>    

                                    <label class="col-sm-2 control-label">ulica nr</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="urodz_ulica_nr" id="urodz_ulica_nr" />
                                    </div>    
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">kod poczt</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="urodz_kod_poczt" id="urodz_kod_poczt" />
                                    </div>    

                                    <label class="col-sm-2 control-label">miasto</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="urodz_miasto" id="urodz_miasto" />
                                    </div>    
                                </div>
                                <p class="col-sm-12"></p>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">kraj</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="urodz_kraj" id="urodz_kraj" />
                                    </div>    
                                </div>
                                <p class="col-sm-12"></p>
                            </div>       
                            <button id="submit" class="btn btn-success btn-lg btn-block">
                                <span class="glyphicon glyphicon-floppy-saved"></span> Dodaj!
                            </button>

                        </form>
                        <pre>
                            <span id="message"></span>
                        </pre>
                    </div>
                </div>
            </div>
        </body>
    </html>

