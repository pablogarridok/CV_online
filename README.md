# CV Online — DevOps 2026

CV online con pipeline CI/CD completo: backend PHP desplegado automáticamente mediante Jenkins en Docker, frontend React con GitHub Actions, CDN global con Cloudflare e imágenes optimizadas con ImageKit.

---

## Tech Stack

| Capa | Tecnología |
|------|-----------|
| Frontend | React 18, CSS |
| Backend | PHP 8, Apache |
| Base de datos | (JSON / MySQL opcional) |
| CI/CD backend | Jenkins (Docker) + GitHub Webhook |
| CI/CD frontend | GitHub Actions + Vercel |
| CDN | Cloudflare (HTTPS + caché + DDoS) |
| Imágenes | ImageKit (WebP, resize en tiempo real) |
| Servidor | Raspberry Pi (Apache) |
| Contenedores | Docker + docker compose |

---

## Arquitectura del pipeline

```
git push ──┬── GitHub Actions ──────────► Vercel (React)
           └── Webhook ─► Jenkins (Docker) ─► Apache (PHP)
                                 │
                    Cloudflare CDN (HTTPS + caché) ─► Usuario
```

---

## Requisitos previos

En la Raspberry Pi debe estar instalado:
- Apache2 + PHP
- Git
- Docker + docker compose

En local (Windows/Mac):
- Git
- Node.js 20+ (para desarrollo del frontend)

Cuentas necesarias:
- GitHub (gratuita)
- Cloudflare (gratuita) + dominio propio
- ImageKit (gratuita, 20 GB/mes)
- Vercel (gratuita, para el frontend)

---

## Instalación y despliegue

### 1. Clonar el repositorio (en la Raspberry Pi)

```bash
git clone https://github.com/TUUSUARIO/CV_online.git
cd CV_online
```

### 2. Levantar Jenkins en Docker

```bash
cd /home/pi/jenkins
docker compose up -d
```

Accede a Jenkins en `http://<IP_RASPBERRY>:8080` y completa la configuración inicial.

### 3. Configurar SSH entre Jenkins y la Raspberry Pi

```bash
# Generar clave SSH dentro del contenedor Jenkins
docker exec -u jenkins jenkins ssh-keygen -t ed25519 -N "" -f /var/jenkins_home/.ssh/id_ed25519

# Añadir la clave pública al usuario pi de la Raspberry Pi
docker exec jenkins cat /var/jenkins_home/.ssh/id_ed25519.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### 4. Configurar sudoers en la Raspberry Pi

```bash
sudo visudo
# Añadir al final del fichero:
pi ALL=(ALL) NOPASSWD: /bin/rm, /bin/mv, /bin/cp, /bin/chown, /bin/chmod, /usr/bin/systemctl
```

### 5. Crear el Job en Jenkins

- New Item → Pipeline → nombre: `CV_Backend`
- Pipeline → Definition: `Pipeline script from SCM`
- SCM: Git → URL del repositorio
- Branch: `*/main`
- Script Path: `Jenkinsfile`
- Guardar

### 6. Configurar el Webhook en GitHub

- Settings → Webhooks → Add webhook
- Payload URL: `https://TU_URL_NGROK/github-webhook/`
- Content type: `application/json`
- Event: `Just the push event`

---

## Variables de entorno

| Variable | Dónde configurar | Descripción |
|----------|-----------------|-------------|
| `REACT_APP_API_URL` | GitHub Secrets | URL base de la API PHP |
| `VERCEL_TOKEN` | GitHub Secrets | Token de Vercel |
| `VERCEL_ORG_ID` | GitHub Secrets | ID de organización de Vercel |
| `VERCEL_PROJECT_ID` | GitHub Secrets | ID del proyecto en Vercel |

---

## Pipeline CI/CD

### Backend (Jenkins)

Cada `git push` a `main` dispara el webhook hacia Jenkins, que ejecuta tres etapas:

1. **Descargar código** — `checkout scm` descarga el commit del repositorio.
2. **Validar PHP** — `php -l` comprueba la sintaxis de todos los ficheros `.php`. Si hay error, el pipeline se detiene y el código roto no llega al servidor.
3. **Desplegar en Apache** — Los ficheros se copian a `/var/www/html/cv_site` y se recarga Apache con `systemctl reload apache2`.

### Frontend (GitHub Actions)

El fichero `.github/workflows/deploy-frontend.yml` define el pipeline:

1. `npm install` — instala dependencias de React.
2. `npm test` — ejecuta los tests automáticos.
3. `npm run build` — genera el build de producción optimizado.
4. Deploy a Vercel (si los secrets están configurados).

---

## Autor

- **Nombre:** Tu Nombre Apellido  
- **GitHub:** [github.com/tuusuario](https://github.com/tuusuario)  
- **Email:** tu@email.com  
- **Centro:** Monlau Formació Professional — CFGS DAW 2026
