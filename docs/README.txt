README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:8000>
    ServerAdmin linice01@163.com
    # DocumentRoot "D:\Zend\Apache2\htdocs\centos_dev\public"
    DocumentRoot "F:/php_ws/centos_dev/public"
    ServerName www.centos.com.cn.dev
    ServerAlias centos.com.cn.dev
    ErrorLog "logs/centos-error.log"
    CustomLog "logs/centos-access.log" common
    
    SetEnv APPLICATION_ENV "development"
    
    # <Directory D:\Zend\Apache2\htdocs\centos_dev\public>
    <Directory F:/php_ws/centos_dev/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>  
</VirtualHost>



标题分为4级，第4级标题与正文字体大小相同。


code.google.com

