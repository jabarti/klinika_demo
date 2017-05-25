<?php
/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    EditCrud.php
 * Encoding:    UTF-8
 * Created:     2016-08-10
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
?>
<html>
    <head>
        <script src="Controllers/LoginController.js" type="text/javascript"></script>      
        <script src="Controllers/EditCrudController.js" type="text/javascript"></script>      
    </head>
    <body >
        <div  class="container">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" role="form" id="EditCrudForm" name="EditCrudForm" >
                        <div class="form-group form-buffer-pa">
                            <h2>Dane Użytkownika</h2>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ID</label>
                                <div class="col-sm-3">
                                    <input type="text" name="idUsers" id="idUsers" disabled/>
                                </div>    
                            </div>
                            <p class="col-sm-12"></p>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">User</label>
                                <div class="col-sm-3">
                                    <input type="text" name="anvandersnamn" id="anvandersnamn"/>
                                </div>    
                            </div>
                            <p class="col-sm-12"></p>

                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Stare hasło</label>
                                <div class="col-sm-3">
                                    <input type="password" name="losenord" id="losenord"  data-toggle="popover" data-trigger="hover" data-content="Hasło powinno składać się z min. 8 znaków, przynajmniej jedna litera duża i cyfra." />
                                    <!--                                    <div id="losenord_error" >
                                                                            <span class="alert-danger" >Hasło nieprawidłowe lub puste!!!</span>
                                                                        </div>
                                                                        <div id="losenord_success" >
                                                                            <span class="alert-success" >Prawidłowe hasło</span>
                                                                        </div>-->
                                </div>    
                            </div>
                            <p class="col-sm-12"></p>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nowe hasło</label>
                                <div class="col-sm-3">
                                    <input type="password" name="new_losenord" id="new_losenord"  data-toggle="popover" data-trigger="hover" data-content="Hasło powinno składać się z min. 8 znaków, przynajmniej jedna litera duża i cyfra." />
                                </div>       
                            </div>
                            <p class="col-sm-12"></p>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Powtórz nowe hasło</label>
                                <div class="col-sm-3">
                                    <input type="password" name="new_losenord2" id="new_losenord2"  data-toggle="popover" data-trigger="hover" data-content="Hasło powinno składać się z min. 8 znaków, przynajmniej jedna litera duża i cyfra." />
                                    <div id="new_losenord2_error" >
                                        <span class="alert-danger" >Hasła niezgodne!!!</span>
                                    </div>
                                    <div id="new_losenord2_success" >
                                        <span class="alert-success" >Prawidłowe hasło</span>
                                    </div>
                                </div>  

                            </div>
                            <p class="col-sm-12"></p>
                            <h2>Dane osobowe</h2>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Imię</label>
                                <div class="col-sm-3">
                                    <input type="text" name="imie" id="imie" required />
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nazwisko</label>
                                <div class="col-sm-3">
                                    <input type="text" name="nazwisko" id="nazwisko" required  />
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">email</label>
                                <div class="col-sm-3">
                                    <input type="email" name="email" id="email" required  />
                                </div>    
                            </div>

                            <p class="col-sm-12"></p>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Last log</label>
                                <div class="col-sm-3">
                                    <input type="text" name="last_logg" id="last_logg" disabled/>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" >Last log IP</label>
                                <div class="col-sm-3">
                                    <input type="text" name="IP" id="IP" disabled/>
                                </div>    
                            </div>
                        </div>       
                        <button id="submit" class="btn btn-success btn-lg btn-block">
                            <span class="glyphicon glyphicon-floppy-saved"></span> Edytuj!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

