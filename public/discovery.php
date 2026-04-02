<?php
echo "<h1>Diagnostic de Chemin Physique</h1>";
echo "<b>Chemin Complet (__FILE__) :</b> " . __FILE__ . "<br>";
echo "<b>Document Root :</b> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<b>Script Name :</b> " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "<hr>";
echo "<h3>Test de Dossiers</h3>";
$folders = ['/public_html', '/home/sanad425/public_html', './public'];
foreach ($folders as $f) {
    echo "Dossier $f : " . (is_dir($f) ? "<span style='color:green'>EXISTE</span>" : "<span style='color:red'>ABSENT</span>") . "<br>";
}
?>
