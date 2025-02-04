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