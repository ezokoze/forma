<?php

session_start();
require_once('../../../lib/config.php');
$inscrit = $pdo->sqlValue("SELECT COUNT(stages_formations_id) FROM inscriptions WHERE utilisateurs_id = ?", array($_SESSION['utilisateurs_id']));

// DB table to use
$table = 'view_stages_formations';

// Table's primary key
$primaryKey = 'stages_formations_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array( /* Partie clé primaire */
        'db' => 'stages_formations_id',
        'dt' => -1,
        'formatter' => function ($d, $row) {
            return '<input type="checkbox" name="check_delete[]" class="check_delete" value="' . $row['stages_formations_id'] . '">';
        }
    ),
    array(
        'db' => 'formations_intitule',
        'dt' => 0,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . utf8_encode($d) . '</span>';
        }
    ),
    array(
        'db' => 'associations_nom',
        'dt' => 1,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="stages_formations_id" data-original-title="">' . utf8_encode($d) . '</span>';
        }
    ),
    array(
        'db' => 'salles_nom',
        'dt' => 2,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . utf8_encode($d) . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_prix',
        'dt' => 3,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . utf8_encode($d) . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_placeRestantes',
        'dt' => 4,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . utf8_encode($d) . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_dateDebut',
        'dt' => 5,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . date_format(date_create($d), "d/m/Y") . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_dateFin',
        'dt' => 6,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . date_format(date_create($d), "d/m/Y") . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_dateLimite',
        'dt' => 7,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . date_format(date_create($d), "d/m/Y") . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_dateLimite',
        'dt' => 8,
        'formatter' => function ($d, $row) {
            if($_SESSION['utilisateurs_admin'] == '1'){
                return '<button type=\'button\' onclick=\'ouverture_stages_modification('.$row['stages_formations_id'].');\' class=\'btn btn-primary btn-circle\'><i class="fa fa-pencil"></i></button>
            <button type=\'button\' onclick=\'suppressionLigne('.$row['stages_formations_id'].');\' class=\'btn btn-danger btn-circle\'><i class="fa fa-trash-o"></i></button>';
            } else {
                return '<button type=\'button\' onclick=\'inscriptionUtilisateurs(' . $row['stages_formations_id'] . ');\' class=\'btn btn-success btn-xs\'>inscription</button>';
            }

            
        }
    )
);

// SQL server connection information
$sql_details = array(
    'user' => 'fitchadmin',
    'pass' => 'menphis31',
    'db' => 'formadb',
    'host' => 'mysql.francois-garcia.ws'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('../../ssp.class.php');

if ($_SESSION['utilisateurs_admin'] == 1) {
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
    );
} else {
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "associations_id = '" . $_SESSION['associations_id'] . "' AND stages_formations_dateLimite >= NOW() AND stages_formations_id NOT IN (SELECT stages_formations_id FROM inscriptions WHERE utilisateurs_id = '" . $_SESSION['utilisateurs_id'] . "')")
    );
}


?>