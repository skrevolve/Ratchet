# Ratchet (PHP7)
Apache server real-time chat using composer  
http://socketo.me/  
https://github.com/ratchetphp  
https://github.com/ratchetphp/Ratchet  
https://github.com/miconda/wsctl  

## You need an SSL certificate for this project
No need to configure Apache proxy(mod_proxy_wstunnel)  
http://httpd.apache.org/docs/2.4/mod/mod_proxy_wstunnel.html  
You can create any number of socket servers if you have an SSL certificate.  

```sh
chmod a+x wsctl_ssl.sh #Grant execute permission 실행 권한 부여
./wsctl_ssl.sh start #Server running 서버 실행
 ps -ef | grep server_ssl.php #Confirm execution 실행 확인
```
