read -p "Enter namespace : " namespace
find . -type f \( -iname "*.php" -or -iname "*.yaml" -or -iname "*.json" \) -exec sed -i "s=Bolge\\\=${namespace}\\\=g" {} +

read -p "Enter name : " pluginname
sed -i "s=Plugin Name: .*=Plugin Name: ${pluginname}=g" ./bolge.php

read -p "Enter description : " plugindescription
sed -i "s=description: .*=description: ${plugindescription}=g" ./bolge.php

read -p "Enter text domain : " plugintextdomain
sed -i "s=Text Domain: .*=Text Domain: ${plugintextdomain}=g" ./bolge.php
sed -i "s=load_plugin_textdomain('[^']*'=load_plugin_textdomain('${plugintextdomain}'=g" ./bolge.php
