# sqli-lab

Simple sql injection lab.

# How-to

You need to install **nginx**, **mariadb** and **php-fpm** packages.

## nginx (or apache)

Set up your nginx serveur (**/etc/nginx/nginx.conf**) as it follow :

```
[...]
server {
	listen 80;
	server_name localhost sqli-lab.com;

	root /path/to/sqli-lab;
	index index.html index.php;

	location ~ \.php$ {
		fastcgi_index	index.php;
		fastcgi_pass	unix:/var/run/php-fpm/php-fpm.sock;
		include fastcgi.conf;
		root /path/to/sqli-lab;
	}

	location / {
		root   /path/to/sqli-lab;
		index index.php;
	}
}
```

## Virtual hosts

Add the line bellow in your **/etc/hosts** file :

```bash
$> cat /etc/hosts
[...]
127.0.0.1	sqli-lab.com
```

## Run

- Changes the credentials in **sqli-lab/config.php** to match yours.
- Start the services : `systemctl start nginx mysql php-fpm`
- Go to sqli-lab.com :D

---

Have fun!
