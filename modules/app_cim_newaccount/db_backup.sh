#!/bin/csh

if ($#argv != 1) then

   echo " "
   echo "db_backup.sh"
   echo " "
   echo "Proper Usage: "
   echo "   db_backup.sh <FileNameToStoreBackupIn>"
   echo " "
   echo "   The result will be a file named FileNameToStorBackupIn.gz "
   echo "   that will have the DB contents."
   echo "  "
   echo "  "

 else

   mysqldump -uroot -p --add-drop-table site new account_person  > $1 
   bzip2 $1
   chmod 700 ${1}.bz2

endif
