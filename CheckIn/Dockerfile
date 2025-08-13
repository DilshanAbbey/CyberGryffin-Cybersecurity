FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    apache2 php libapache2-mod-php \
    openssh-server sudo vim \
    && rm -rf /var/lib/apt/lists/*

# Apache config
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Flags
COPY flags/user_flag.txt /home/hotelmanager/flag.txt
COPY flags/root_flag.txt /root/flag.txt
RUN chmod 644 /home/hotelmanager/flag.txt && chmod 600 /root/flag.txt

#Delete apache's default web page
RUN rm -f /var/www/html/index.html
# Web files
COPY ./web/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# SSH setup
COPY ssh_setup.sh /ssh_setup.sh
RUN chmod +x /ssh_setup.sh && /ssh_setup.sh

# Startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80 22
CMD ["/start.sh"]
