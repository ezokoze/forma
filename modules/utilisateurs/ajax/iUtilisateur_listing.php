<?php

require_once('../../../lib/config.php');

// DB table to use
$table = 'view_utilisateurs_associations';

// Table's primary key
$primaryKey = 'utilisateurs_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array(
        'db'        => 'utilisateurs_id',
        'dt'        => -1,
        'formatter' => function( $d, $row ) {
            return '<input type="checkbox" name="check_delete[]" class="check_delete" value="'.$row['utilisateurs_id'].'">';
        }
    ),
    array(
        'db'        => 'associations_nom',
        'dt'        => 0,
        'formatter' => function( $d, $row ) {
            return '<span class="id" id="id" data-type="text" data-pk="'.$row['utilisateurs_id'].'" table_id="societes_id" data-original-title="">'.utf8_encode($d).'</span>';
        }
    ),
    array(
        'db'        => 'utilisateurs_type_nom',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            return '<span class="id" id="id" data-type="text" data-pk="'.$row['utilisateurs_id'].'" table_id="utilisateurs_id" data-original-title="">'.utf8_encode($d).'</span>';
        }
    ),
    array(
        'db'        => 'utilisateurs_nomComplet',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            return '<span class="id" id="id" data-type="text" data-pk="'.$row['utilisateurs_id'].'" table_id="societes_id" data-original-title="">'.utf8_encode($d).'</span>';
        }
    ),
    array(
        'db'        => 'utilisateurs_email',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            return '<a href="mailto:'. $d .'" class="id" id="id" data-type="text" data-pk="'.$row['utilisateurs_id'].'" table_id="societes_id" data-original-title="">'.utf8_encode($d).'</a>';
        }
    ),
    array(
        'db'        => 'utilisateurs_quotaFormation',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            return '<span class="id" id="id" data-type="text" data-pk="'.$row['utilisateurs_id'].'" table_id="societes_id" data-original-title="">'.utf8_encode($d).'</span>';
        }
    ),
    array(
        'db'        => 'utilisateurs_quotaFormation',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return '<button type=\'button\' onclick=\'ouverture_utilisateurs_modification('.$row['utilisateurs_id'].');\' class=\'btn btn-primary btn-circle\'><i class="fa fa-pencil"></i></button>
            <button type=\'button\' onclick=\'suppressionLigne('.$row['utilisateurs_id'].');\' class=\'btn btn-danger btn-circle\'><i class="fa fa-trash-o"></i></button>';
        }
    )
);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'forma_avril',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('../../ssp.class.php');

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>