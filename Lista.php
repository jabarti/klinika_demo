<?php
/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    Lista.php
 * Encoding:    UTF-8
 * Created:     2016-08-06
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
?>
<html>
    <head>
        <script src="Controllers/ListaController.js" type="text/javascript"></script>
    </head>
    <body >
        <div  class="container"> 
            <form id="ListForm_Search"  name="ListForm_Search" class="form-horizontal" novalidate>
                <div class="form-group form-buffer-pa">
                    <p class="col-sm-12"></p>
                    <label class="col-sm-2 control-label">Szukaj nazwiska mamy</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="podaj nazwisko mamy" name="mama_lastname">
                    </div>
                    <div class="col-sm-3">

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Szukaj</button>
                    </div>
                    <p class="col-sm-12"></p>
                </div>
            </form>

            <table id="ListForm_Table" class="table table-striped">
                <thead id="ListForm_Table_head">
                    <tr>
                        <th>ID Wpisu</th>
                        <th>data utworzenia
                            <button type="button" onclick="$(this).MessageBox('data_utworzenia', 'down');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('data_utworzenia', 'up');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>                
                        </th>
                        <th>imie Mamy</th>
                        <th>nazwisko mamy
                            <button type="button" onclick="$(this).MessageBox('mama_lastname', 'down');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('mama_lastname', 'up');"  class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>imie dziecka
                            <button type="button" onclick="$(this).MessageBox('imie_dziecka', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('imie_dziecka', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>które dziecko</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody id="ListForm_Table_body"></tbody>
            </table>
            <?php if ($TEST_VER && !$TEST_VER) { ?>
                <pre>
                        <span id="message"></span>
                </pre>
            <?php }; ?>
        </div>
    </body>
</html>

