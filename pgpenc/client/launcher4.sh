sshpass -p 5M.idkfa sftp pgapp@10.162.104.238:/File_Processing/PGIncomingQPS <<EOF
put /var/www/html/testspaysez/api/tlflog/tlftemp2/*   
exit
EOF