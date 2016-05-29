<?php

session_start();
require_once('../../../lib/config.php');
$inscrit = $pdo->sqlValue("SELECT COUNT(stages_formations_id) FROM inscriptions WHERE utilisateurs_id = ?", array($_SESSION['utilisateurs_id']));

// DB table to use
$table = 'view_utilisateurs_inscrits';

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
        'db' => 'stages_formations_date',
        'dt' => 5,
        'formatter' => function ($d, $row) {
            return '<span class="id" id="id" data-type="text" data-pk="' . $row['stages_formations_id'] . '" table_id="societes_id" data-original-title="">' . date_format(date_create($d), "d/m/Y H:i:s") . '</span>';
        }
    ),
    array(
        'db' => 'stages_formations_date',
        'dt' => 6,
        'formatter' => function ($d, $row) {
            return '<button type=\'button\' onclick=\'desinscrireUtilisateurs(' . $row['stages_formations_id'] . ');\' class=\'btn btn-danger btn-xs\'>se désinscrire</button>';
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
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "utilisateurs_id = " . $_SESSION['utilisateurs_id'])
    );
}


?>