--- 
customlog: 
  - 
    format: combined
    target: /usr/local/apache/domlogs/rebanx.com
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /usr/local/apache/domlogs/rebanx.com-bytes_log
documentroot: /home/wwwrebanx/public_html
group: wwwrebanx
hascgi: 1
homedir: /home/wwwrebanx
ifmodulealiasmodule: 
  scriptalias: 
    - 
      path: /home/wwwrebanx/public_html/cgi-bin/
      url: /cgi-bin/
ifmoduleincludemodule: 
  directoryhomewwwrebanxpublichtml: 
    ssilegacyexprparser: 
      - 
        value: " On"
ifmodulelogconfigmodule: 
  ifmodulelogiomodule: 
    customlog: 
      - 
        format: "\"%{%s}t %I .\\n%{%s}t %O .\""
        target: /usr/local/apache/domlogs/rebanx.com-bytes_log
ifmoduleuserdirmodule: 
  ifmodulempmitkc: 
    ifmoduleruidmodule: {}

ip: 198.178.123.35
owner: root
phpopenbasedirprotect: 1
port: 80
scriptalias: 
  - 
    path: /home/wwwrebanx/public_html/cgi-bin
    url: /cgi-bin/
serveradmin: webmaster@rebanx.com
serveralias: mail.rebanx.com www.rebanx.com
servername: rebanx.com
usecanonicalname: 'Off'
user: wwwrebanx
userdirprotect: ''
