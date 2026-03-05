<?php
// Configuration
$host = 'db5019932242.hosting-data.io ';
$user = 'dbu1782294 ';
$pass = 'MediatekDB010203';
$name = 'dbs15390908';

// Dossier de destination (assurez-vous que le dossier 'backups' existe)
$backupDir = __DIR__ . '/backups/';
$fileName = $name . '_' . date('Y-m-d_H-i-s') . '.sql.gz';
$filePath = $backupDir . $fileName;

// Commande de sauvegarde (compressée en .gz)
$command = "mysqldump -h $host -u $user -p$pass $name | gzip > $filePath";

// Exécution
system($command, $output);

// Optionnel : Supprimer les sauvegardes de plus de 7 jours
$daysToKeep = 7;
foreach (glob($backupDir . "*.gz") as $file) {
    if (filemtime($file) < time() - ($daysToKeep * 86400)) {
        unlink($file);
    }
}
?>