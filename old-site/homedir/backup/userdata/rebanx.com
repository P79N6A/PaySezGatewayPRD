--- 
customlog: 
  - 
    format: combined
    target: /usr/local/apache/domlogs/rebanx.com
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /usr/local/apache/domlogs/rebanx.com-bytes_log
documentroot: /home/rebanx84/public_html
group: rebanx84
hascgi: 1
homedir: /home/rebanx84
ip: 185.123.96.35
owner: root
phpopenbasedirprotect: 1
port: 81
scriptalias: 
  - 
    path: /home/rebanx84/public_html/cgi-bin
    url: /cgi-bin/
  - 
    path: /home/rebanx84/public_html/cgi-bin/
    url: /cgi-bin/
serveradmin: webmaster@rebanx.com
serveralias: www.rebanx.com
servername: rebanx.com
usecanonicalname: 'Off'
user: rebanx84
userdirprotect: ''
