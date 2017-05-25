<?php

/****************************************************
 * Project:     Klinika_Local
 * Filename:    listMothers.php
 * Encoding:    UTF-8
 * Created:     2016-08-27
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
?>
<html>
    <head>
        <script src="Controllers/ListaMothersController.js" type="text/javascript"></script>
    </head>
    <body >
        <div  class="container"> 
            <form id="ListMothers_Search"  name="ListMothers_Search" class="form-horizontal" novalidate>
                <div class="form-group form-buffer-pa">
                    <p class="col-sm-12"></p>
                    <label class="col-sm-2 control-label">Szukaj matki</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="podaj nazwisko lub imię  matki" name="nazwa_matki">
                    </div>
                    <div class="col-sm-3">

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Szukaj</button>
                    </div>
                    <p class="col-sm-12"></p>
                </div>
            </form>

            <table id="ListMothers_Table" class="table table-striped">
                <thead id="ListMothers_Table_head">
                    <tr>
                        <th>ID Matki</th>
                        <th>Imię
                            <button type="button" onclick="$(this).MessageBox('mama_firstname', 'down');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('mama_firstname', 'up');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>                
                        </th>
                        <th>nazwisko
                            <button type="button" onclick="$(this).MessageBox('mama_lastname', 'down');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('mama_lastname', 'up');"  class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>data urodzenia
                            <button type="button" onclick="$(this).MessageBox('data_urodzenia_matka', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('data_urodzenia_matka', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>ulica
                            <button type="button" onclick="$(this).MessageBox('ulica', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('ulica', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>miasto
                            <button type="button" onclick="$(this).MessageBox('miasto', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('miasto', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>telefon</th>
                        <th>email</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody id="ListMothers_Table_body"></tbody>
            </table>
            <?php if ($TEST_VER && !$TEST_VER) { ?>
                <pre>
                            <span id="message"></span>
                </pre>
            <?php }; ?>
        </div>
    </body>
</html>

