<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'i6600317_mo1';
$CFG->dbuser    = 'i6600317_mo1';
$CFG->dbpass    = 'I.fDGh4mS5jumu6p0qB84';
$CFG->usepaypalsandbox = 1;
$CFG->prefix    = 'mo_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 3306,
  'dbsocket' => '0',
  'dbcollation' => 'utf8_unicode_ci',
);

$CFG->wwwroot   = 'https://www.vleacademy.com';
$CFG->dataroot  = '/home/hfgmgvmwda5f/public_html/.htcljragujcbz2.data/';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
