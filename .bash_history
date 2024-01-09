id
sudo nginx 
sudo echo 1
exit
mkdir public 
cd public/
wget https://api.ytuber.ru/ytuber.tar.gz
tar -cvf ytuber.tar.gz 
tar xvzf ytuber.tar.gz 
ls
mv home/ytuber.ru/public/* .
ls
cd ..
rm -Rf public/
ls
wget https://api.ytuber.ru/ytuber.tar.gz
tar xvzf ytuber.tar.gz 
ls
mv home/ytuber.ru/ .
ls
mv ytuber.ru/* .
ls
rm home
rm -Rf home/
rm -Rf ytuber.ru/
rm -Rf ytuber.tar.gz 
ls
chouw -R ytuber.ru:ytuber.ru .
chown -R ytuber.ru:ytuber.ru .
nano /etc/nginx/conf.d/ytuber.ru.conf
ping 192.168.10.102
useradd -m webistan.ru
exit
