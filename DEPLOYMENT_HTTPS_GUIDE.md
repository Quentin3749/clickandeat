# Déploiement, CI/CD et HTTPS pour Click & Eat

## 1. Pipeline CI/CD (GitHub Actions)

Un pipeline est configuré dans `.github/workflows/laravel.yml` :
- Installe les dépendances PHP et JS
- Lance les migrations et les tests
- Prépare les assets front
- Prévoyez d’ajouter votre étape de déploiement (ex : rsync, SSH, FTP, etc.)

## 2. Déploiement sécurisé en HTTPS

### a) Serveur Nginx (exemple)
```nginx
server {
    listen 443 ssl;
    server_name votredomaine.com;
    root /chemin/vers/clickandeat/public;

    ssl_certificate /etc/letsencrypt/live/votredomaine.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/votredomaine.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### b) Certificat gratuit avec Let’s Encrypt
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d votredomaine.com
```

### c) Forcer HTTPS dans Laravel (middleware)
Ajoutez dans `AppServiceProvider` :
```php
if (app()->environment('production')) {
    \URL::forceScheme('https');
}
```

## 3. Conseils supplémentaires
- Placez vos variables sensibles (DB, clés API, etc.) dans `.env`
- Pour la prod, désactivez le debug (`APP_DEBUG=false`)
- Utilisez un service type Laravel Forge, Ploi, ou un hébergeur compatible PHP 8+

---
Besoin d’un exemple pour Apache, Docker ou une autre plateforme ? Dites-le-moi !
