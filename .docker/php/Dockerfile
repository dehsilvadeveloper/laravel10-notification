FROM php:8.2-fpm

# Set your user name, ex: user=developer
ARG user=developer
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmemcached-dev \
    libssl-dev \
    libmcrypt-dev \
    zip \
    unzip \
    openssl \
    vim \
    bash \
    iputils-ping \
    net-tools \
    htop

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd sockets opcache

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Add redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www

# Copy custom.ini to the final directory
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

# Remove possible unnecessary directory (to avoid errors with symbolic link)
RUN rm -rf /var/www/html

# Create symbolic link
RUN ln -s public html

# Define user been used
USER $user

# Expose port
EXPOSE 9000