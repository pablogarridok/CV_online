# Reflexión — DevOps 2026: CI/CD con Jenkins, Cloudflare y GitHub Actions

**Autor:** Tu Nombre Apellido  
**Fecha:** Mayo 2026  
**Asignatura:** Desenvolupament Web en Entorn Servidor (RA6)

---

## Pregunta 1

**¿Qué ventajas concretas has notado al usar un pipeline CI/CD con Jenkins respecto al despliegue manual por SSH? ¿Qué ocurre si hay un error de sintaxis en un fichero PHP?**

*Escribe aquí tu respuesta (mínimo 5 líneas):*

Con el pipeline CI/CD, el despliegue se lanza automáticamente con cada `git push`, sin necesidad de conectarse por SSH a la Raspberry Pi ni copiar archivos manualmente. Esto elimina errores humanos como olvidarse de reiniciar Apache o copiar mal una carpeta.

Si hay un error de sintaxis en un fichero PHP, el stage **Validar PHP** falla inmediatamente (el comando `php -l` devuelve error) y Jenkins detiene el pipeline sin llegar al stage de despliegue. El código roto nunca llega al servidor de producción, que sigue mostrando la versión anterior correcta.

En contraste, con el despliegue manual, si subiéramos un fichero PHP con error, Apache lo serviría tal cual y la web podría mostrar un error 500 a todos los usuarios hasta que nos diéramos cuenta.

---

## Pregunta 2

**¿Por qué se usa Jenkins para el backend (PHP en Raspberry Pi) y GitHub Actions para el frontend (React en Vercel), en lugar de usar una sola herramienta para todo?**

*Escribe aquí tu respuesta (mínimo 5 líneas):*

GitHub Actions ejecuta los pipelines en servidores de GitHub, en internet. Esto es perfecto para el frontend de React porque el resultado del build (ficheros estáticos) se sube a Vercel, que es un servicio en la nube. Todo ocurre en internet, sin necesidad de acceder a ninguna máquina propia.

El backend PHP, en cambio, vive en la Raspberry Pi, que está en una red local sin IP pública fija. GitHub Actions no puede conectarse a ella directamente para copiar archivos ni reiniciar Apache. Jenkins sí puede hacerlo porque está instalado dentro de la misma red (en un contenedor Docker en la propia Raspberry Pi).

En el mercado laboral real, esta combinación es muy habitual: GitHub Actions para el frontend (rápido, sin infraestructura que mantener) y Jenkins u otras herramientas auto-hospedadas para backends en servidores internos donde los datos no deben salir de la infraestructura de la empresa.

---

## Pregunta 3

**¿Qué papel juega Cloudflare CDN en la arquitectura? ¿Qué ventajas aporta respecto a servir el CV directamente desde la Raspberry Pi?**

*Escribe aquí tu respuesta (mínimo 5 líneas):*

Cloudflare actúa como proxy inverso entre los usuarios e internet y la Raspberry Pi. Cuando alguien visita el CV, la petición llega primero a Cloudflare (al servidor de su red más cercano geográficamente), que responde directamente con la versión cacheada del contenido si la tiene. Solo si necesita datos dinámicos (como la API PHP) reenvía la petición a la Raspberry Pi.

Las ventajas principales son:
- **Velocidad**: el contenido estático se sirve desde el nodo CDN más cercano al usuario, no desde Barcelona.
- **HTTPS automático**: Cloudflare gestiona y renueva el certificado SSL sin que tengamos que instalar Certbot ni Let's Encrypt.
- **Seguridad**: la IP real de la Raspberry Pi nunca queda expuesta; Cloudflare actúa de intermediario y filtra ataques DDoS.
- **Caché**: los archivos CSS, JS e imágenes se almacenan en el CDN y no consumen recursos de la Raspberry Pi en cada visita.

Sin Cloudflare, cada petición viajaría hasta la Raspberry Pi, que tiene recursos limitados y podría saturarse. Además, tendríamos que gestionar manualmente el HTTPS y nuestra IP real quedaría expuesta.
