# Entrega Práctica — DevOps 2026
# CI/CD con Jenkins · Cloudflare CDN · GitHub Actions

**Alumno:** Pablo Garrido Rubio  
**Curso:** 2º DAW — Monlau Formació Professional  
**Asignatura:** Desenvolupament Web en Entorn Servidor (RA6)  
**Fecha de entrega:** Mayo 2026  

---

## Introducción

En esta práctica hemos montado un pipeline CI/CD completo para un CV online. El objetivo era eliminar el despliegue manual: antes había que conectarse por SSH al servidor, copiar los ficheros a mano y reiniciar Apache. Ahora, con hacer `git push` desde el ordenador, todo ocurre automáticamente.

La arquitectura implementada es la siguiente:

```
git push ──► GitHub ──► Jenkins (Docker) ──► Apache (Raspberry Pi)
                  │
                  └──► GitHub Actions ──► (frontend React / Vercel)
                  
          ngrok (HTTPS + CDN) ──► Usuario final
```

---

## Actividad 1 — Jenkins en Docker

### ¿Qué es Jenkins y por qué en Docker?

Jenkins es el servidor que ejecuta el pipeline automáticamente cada vez que detecta un cambio en el repositorio de GitHub. Lo ejecutamos dentro de un contenedor Docker para evitar conflictos con otras aplicaciones instaladas en la Raspberry Pi: si algo falla, podemos eliminar el contenedor y volver a crearlo en segundos sin tocar el sistema operativo.

### ¿Qué hicimos?

Creamos el fichero `docker-compose.yml` en la Raspberry Pi y arrancamos Jenkins con el comando `docker-compose up -d`. Jenkins quedó accesible en el puerto 8080 de la Raspberry Pi.

### Captura 1 — Jenkins arrancado y accesible

> **Cómo hacerla:** Abre `http://172.17.31.60:8080` en el navegador y haz captura de la pantalla principal de Jenkins con tu usuario iniciado.

**[INSERTAR CAPTURA DE LA PANTALLA PRINCIPAL DE JENKINS]**

---

## Actividad 2 — Job + Jenkinsfile + Webhook/Poll SCM

### ¿Qué es el Jenkinsfile?

El Jenkinsfile es un fichero de texto que vive dentro del repositorio de GitHub y define exactamente qué tiene que hacer Jenkins cuando detecta un cambio. Tiene 3 etapas (stages):

1. **Descargar código** — Descarga el último commit de GitHub al servidor.
2. **Validar PHP** — Ejecuta `php -l` en todos los ficheros `.php` para comprobar que no hay errores de sintaxis. Si hay un error, el pipeline se para aquí y el código roto nunca llega al servidor.
3. **Desplegar en Apache** — Copia los ficheros a la carpeta de Apache (`/var/www/html/cv_site`) y recarga el servidor para que sirva la nueva versión.

### ¿Cómo se activa automáticamente?

Usamos **Poll SCM** con `* * * * *`: Jenkins consulta GitHub cada minuto para ver si hay commits nuevos. Si los hay, lanza el pipeline solo, sin que tengamos que pulsar ningún botón.

### Captura 2 — Pipeline con los 3 stages en verde

> **Cómo hacerla:** En Jenkins, entra al job `CV_Backend` → haz clic en el último build exitoso → captura la pantalla donde se ven los 3 stages en verde.

**[INSERTAR CAPTURA DE LOS 3 STAGES EN VERDE]**

### Captura 3 — Logs del pipeline (Console Output)

> **Cómo hacerla:** Dentro del mismo build, haz clic en **Console Output** (Salida de consola) y captura parte del log donde se vea "Despliegue completado en Apache" o similar.

**[INSERTAR CAPTURA DEL LOG DEL PIPELINE]**

---

## Actividad 3 — CDN con HTTPS (ngrok / Cloudflare)

### ¿Qué es una CDN y para qué sirve?

Una CDN (Content Delivery Network) es una red de servidores repartidos por el mundo que sirven el contenido desde el punto más cercano al usuario. Además de velocidad, aporta:

- **HTTPS automático** — El candado del navegador sin tener que instalar certificados manualmente.
- **Protección DDoS** — Los ataques se absorben antes de llegar al servidor.
- **Anonimato del servidor** — La IP real de la Raspberry Pi nunca queda expuesta.

En esta práctica usamos **ngrok** como alternativa a Cloudflare (la red de Monlau bloquea conexiones externas que necesita Cloudflare, pero ngrok funciona correctamente desde la red escolar). Ngrok cumple la misma función: pone un proxy HTTPS delante de nuestro Apache.

### Captura 4 — CV accesible por HTTPS con candado

> **Cómo hacerla:**
> 1. Asegúrate de que ngrok está corriendo en la Raspberry Pi (`ngrok http 8082`)
> 2. Abre la URL ngrok en el navegador: `https://XXXX.ngrok-free.app/cv_site`
> 3. Captura la pantalla mostrando el CV con el **candado HTTPS** visible en la barra del navegador

**[INSERTAR CAPTURA DEL CV CON CANDADO HTTPS]**

### Captura 5 — Terminal con ngrok activo

> **Cómo hacerla:** Captura la terminal de la Raspberry Pi donde se ve ngrok corriendo con el estado `online` y la URL pública asignada.

**[INSERTAR CAPTURA DE LA TERMINAL CON NGROK]**

---

## Actividad 4 — Imágenes optimizadas con ImageKit

### ¿Por qué optimizar imágenes?

Las imágenes son el recurso más pesado de cualquier web. Una foto tomada con el móvil puede pesar 4-5 MB. ImageKit es un CDN especializado en imágenes que permite transformarlas en tiempo real solo añadiendo parámetros a la URL:

- `w-300,h-300` → redimensiona a 300×300 píxeles
- `f-webp` → convierte al formato WebP (30-40% más ligero que JPG)
- `q-80` → calidad al 80% (equilibrio entre tamaño y nitidez)

El fichero original no cambia. La transformación ocurre en el servidor de ImageKit al momento de servir la imagen.

### ¿Qué hicimos?

Subimos la foto de perfil a ImageKit y sustituimos la etiqueta `<img>` del CV por la URL de ImageKit con los parámetros de optimización. Con un `git push`, Jenkins desplegó el cambio automáticamente.

### Captura 6 — Imagen cargada desde ImageKit en formato WebP

> **Cómo hacerla:**
> 1. Abre el CV en el navegador
> 2. Pulsa **F12** para abrir las DevTools
> 3. Ve a la pestaña **Red** (Network)
> 4. Recarga la página con **F5**
> 5. Filtra por **Img** o busca la foto de perfil en la lista
> 6. Comprueba que la URL es de `ik.imagekit.io` y el tipo es `webp`
> 7. Captura las DevTools mostrando esa información

**[INSERTAR CAPTURA DE DEVTOOLS CON LA IMAGEN EN WEBP DESDE IMAGEKIT]**

---

## Actividad 5 — GitHub Actions (lectura guiada)

### ¿Qué es GitHub Actions y en qué se diferencia de Jenkins?

| | Jenkins | GitHub Actions |
|---|---|---|
| Dónde se ejecuta | Tu servidor (Raspberry Pi) | Servidores de GitHub |
| Servidor propio | Sí, necesario | No necesario |
| Ideal para | Backend, infraestructura interna | Frontend, proyectos open-source |
| Configuración | Jenkinsfile en el repo | Fichero YAML en `.github/workflows/` |

Usamos Jenkins para el backend porque está en la misma red que la Raspberry Pi y puede acceder a ella directamente. GitHub Actions no puede conectarse a un servidor en red local.

Para el frontend de React, GitHub Actions es la opción perfecta: instala dependencias, ejecuta tests, genera el build de producción y lo despliega en Vercel, todo en la nube sin necesitar ningún servidor propio.

### Fichero de workflow incluido en el repositorio

El fichero `.github/workflows/deploy-frontend.yml` ya está en el repositorio. Define el pipeline del frontend:

1. Descarga el código
2. Instala Node.js 20
3. Ejecuta `npm install`
4. Ejecuta los tests
5. Genera el build de producción
6. Despliega en Vercel (si los secrets están configurados)

### Captura 7 — Workflow de GitHub Actions en el repositorio

> **Cómo hacerla:** Ve a `https://github.com/pablogarridok/CV_online` → pestaña **Actions** → captura la pantalla mostrando el workflow ejecutado (aunque falle el paso de Vercel por falta de secrets, los pasos de build y test deben estar en verde).

**[INSERTAR CAPTURA DE GITHUB ACTIONS]**

---

## Reflexión

El fichero `reflexion.md` está en la raíz del repositorio con las 3 preguntas respondidas.

**Enlace directo:** https://github.com/pablogarridok/CV_online/blob/main/reflexion.md

---

## README del proyecto

El fichero `README.md` está en la raíz del repositorio con todas las secciones obligatorias: descripción, tech stack, requisitos, instalación, variables de entorno, pipeline CI/CD y autor.

**Enlace directo:** https://github.com/pablogarridok/CV_online/blob/main/README.md

---

## Enlace al repositorio GitHub

**URL del repositorio:** https://github.com/pablogarridok/CV_online

Contiene:
- `Jenkinsfile` — definición del pipeline CI/CD
- `docker-compose.yml` — configuración de Jenkins en Docker
- `backend/` — CV en PHP desplegado por Jenkins
- `frontend/` — CV en React (desplegado vía GitHub Actions)
- `.github/workflows/deploy-frontend.yml` — pipeline del frontend
- `reflexion.md` — reflexión de la práctica
- `README.md` — documentación del proyecto

---

## Conclusión

Con esta práctica hemos montado un pipeline CI/CD real de principio a fin. El flujo completo es:

1. Hacemos un cambio en el código y ejecutamos `git push`
2. Jenkins detecta el cambio en menos de 1 minuto (Poll SCM)
3. Jenkins valida la sintaxis PHP — si hay error, se detiene y el servidor no se toca
4. Si todo es correcto, Jenkins copia los ficheros a Apache y recarga el servidor
5. El CV queda accesible por HTTPS a través de ngrok/Cloudflare
6. Las imágenes se sirven optimizadas en WebP desde ImageKit

Este es exactamente el flujo que se usa en equipos de desarrollo reales: nadie despliega a mano, todo está automatizado y validado.
