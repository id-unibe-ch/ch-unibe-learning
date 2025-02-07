# Check if Git is installed and install if not  
if ! command -v git &> /dev/null  
then  
    echo "Git could not be found. Attempting to install Git..."  
    apt-get update  
    apt-get install git -y  
else  
    echo "Git is already installed."  
fi 
# Rest off your web app congig
# echo "Installing requirements.txt"

# NGINX Kirby CMS configuration
echo "Copying NGINX configuration for Kirby CMS" 
cp /home/site/wwwroot/azsys/nginx/default /etc/nginx/sites-available/default && service nginx reload

# PHP Composer Installation
if ! command -v composer &> /dev/null  
then  
    echo "PHP Composer could not be found. Attempting to install PHP Composer..."
    cd /home
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    echo composer -v
else  
    echo "PHP Composer is already installed. Attempting to update PHP Composer..."
    composer self-update
    echo composer -v
fi

# Kirby CMS oAuth2 Installation
echo "Installing Kirby CMS oAuth2 plugin"
cd /home/site/wwwroot
composer require thathoff/kirby-oauth
composer require thenetworg/oauth2-azure