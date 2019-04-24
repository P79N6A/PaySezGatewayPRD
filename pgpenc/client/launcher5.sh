sshpass -p 5M.idkfa sftp pgapp@10.162.104.238:/File_Processing/PGIncomingMARS <<EOF
put /var/www/html/testspaysez/api/output2/*   
exit
EOF