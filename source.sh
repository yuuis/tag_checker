# source /etc/profile
# source /home/ec2-user/.bash_profile
# source /home/ec2-user/.bashrc

pkill phantomjs
PATH=$PATH:/usr/local/bin
sudo /usr/local/pyenv/shims/python /var/www/html/tag_checker.py $1 $2
# /usr/local/pyenv/shims/python /var/www/html/hello.py
