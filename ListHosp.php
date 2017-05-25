<?php
/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    ListHosp.php
 * Encoding:    UTF-8
 * Created:     2016-08-16
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
?>
<html>
    <head>
        <script src="Controllers/ListaSzpitaliController.js" type="text/javascript"></script>
    </head>
    <body >
        <div  class="container"> 
            <form id="ListSzpit_Search"  name="ListSzpit_Search" class="form-horizontal" novalidate>
                <div class="form-group form-buffer-pa">
                    <p class="col-sm-12"></p>
                    <label class="col-sm-2 control-label">Szukaj szpitala</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="podaj nazwe szpitala" name="nazwa">
                    </div>
                    <div class="col-sm-3">

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Szukaj</button>
                    </div>
                    <p class="col-sm-12"></p>
                </div>
            </form>

            <table id="ListSzpital_Table" class="table table-striped">
                <thead id="ListSzpital_Table_head">
                    <tr>
                        <th>ID Szpitala</th>
                        <th>nazwa
                            <button type="button" onclick="$(this).MessageBox('nazwa', 'down');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('nazwa', 'up');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>                
                        </th>
                        <th>ulica
                            <button type="button" onclick="$(this).MessageBox('urodz_ulica', 'down');" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('urodz_ulica', 'up');"  class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>ulica nr</th>
                        <th>kod poczt
                            <button type="button" onclick="$(this).MessageBox('urodz_kod_poczt', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('urodz_kod_poczt', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>miasto
                            <button type="button" onclick="$(this).MessageBox('urodz_miasto', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('urodz_miasto', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>kraj
                            <button type="button" onclick="$(this).MessageBox('urodz_kraj', 'down')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-down"></span> </button>
                            <button type="button" onclick="$(this).MessageBox('urodz_kraj', 'up')" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-up"></span> </button>
                        </th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody id="ListSzpital_Table_body"></tbody>
                <tr>
                    <td colspan="8">
                        <button id="addHospital" class="btn btn-success btn-lg btn-block">
                            <span class="glyphicon glyphicon-flash"></span> Dodaj szpital!
                        </button>

                    </td>
                </tr>

            </table>
            <?php if ($TEST_VER && !$TEST_VER) { ?>
                <pre>
                            <span id="message"></span>
                </pre>
            <?php }; ?>
        </div>
    </body>
</html>
