<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit(); }
 
$cv = [
    "nombre"    => "Joel Cid Ortega",
    "edad"      => 20,
    "ubicacion" => "Barcelona, España",
    "email"     => "joelcid@email.com",
    "github"    => "github.com/JoelCidOrtega",
    "sobre_mi"  => "Estudiante de Desarrollo de Aplicaciones Web apasionado por el backend, los sistemas y la automatización. Me gusta construir cosas que funcionen de verdad: desde APIs hasta pipelines CI/CD. Anteriormente formado en electromécanica, lo que me dio una base sólida en resolución de problemas y trabajo técnico.",
    "educacion" => [
        [
            "titulo"   => "Grado Superior — Desarrollo de Aplicaciones Web (DAW)",
            "centro"   => "Institut Monlau, Barcelona",
            "periodo"  => "2024 – 2026 (en curso)",
            "nota"     => "Especialización en backend, Docker, CI/CD y despliegue de microservicios"
        ],
        [
            "titulo"   => "Grado Medio — Electromecánica de Vehículos",
            "centro"   => "IES Barcelona",
            "periodo"  => "2022 – 2024",
            "nota"     => "Diagnóstico de sistemas eléctricos y mecánicos, mantenimiento preventivo"
        ]
    ],
    "habilidades" => [
        "Backend"     => ["PHP", "Python", "FastAPI", "Node.js"],
        "Frontend"    => ["HTML5", "CSS3", "JavaScript", "React"],
        "DevOps"      => ["Docker", "Jenkins", "GitHub Actions", "Ngrok"],
        "Bases datos" => ["MySQL", "PostgreSQL", "SQLite"],
        "Sistemas"    => ["Linux", "Git", "Apache", "Bash"]
    ],
    "proyectos" => [
        [
            "nombre"      => "Microservicio de Reconocimiento Facial",
            "descripcion" => "API REST con FastAPI y DeepFace desplegada en Docker con proxy inverso Caddy, HTTPS automático y monitorización con Uptime Kuma.",
            "tecnologias" => ["Python", "FastAPI", "DeepFace", "Docker", "Caddy"],
            "github"      => "github.com/JoelCidOrtega/facial_practica"
        ],
        [
            "nombre"      => "Pipeline CI/CD con Jenkins",
            "descripcion" => "Automatización de despliegues en Apache mediante Jenkins en Docker, Webhooks de GitHub y CDN con Cloudflare.",
            "tecnologias" => ["Jenkins", "Docker", "GitHub Actions", "Cloudflare"],
            "github"      => "github.com/JoelCidOrtega/facial_practica"
        ],
        [
            "nombre"      => "Plataforma de Reservas Online",
            "descripcion" => "Aplicación web fullstack para gestión de reservas con autenticación de usuarios, panel de administración y API REST.",
            "tecnologias" => ["PHP", "MySQL", "JavaScript", "Bootstrap"],
            "github"      => "github.com/JoelCidOrtega"
        ]
    ],
    "idiomas" => [
        ["idioma" => "Español",  "nivel" => "Nativo"],
        ["idioma" => "Catalán",  "nivel" => "Nativo"],
        ["idioma" => "Inglés",   "nivel" => "B1 — Intermedio"]
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joel Cid Ortega — CV</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
 
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            line-height: 1.6;
        }
 
        header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
            border-bottom: 1px solid #334155;
            padding: 3rem 2rem;
            text-align: center;
        }
 
        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 1.5rem;
            border: 3px solid #3b82f6;
        }
 
        h1 { font-size: 2.5rem; color: #f8fafc; margin-bottom: .3rem; }
 
        .tagline {
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 1.2rem;
        }
 
        .contact-bar {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
 
        .contact-bar a {
            color: #60a5fa;
            text-decoration: none;
            font-size: .9rem;
        }
 
        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
 
        section {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 1.5rem;
        }
 
        section.full { grid-column: 1 / -1; }
 
        h2 {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #3b82f6;
            margin-bottom: 1rem;
            padding-bottom: .5rem;
            border-bottom: 1px solid #334155;
        }
 
        .sobre-mi { color: #cbd5e1; font-size: .95rem; }
 
        .edu-item { margin-bottom: 1.2rem; }
        .edu-item:last-child { margin-bottom: 0; }
        .edu-titulo { font-weight: 600; color: #f1f5f9; font-size: .95rem; }
        .edu-centro { color: #60a5fa; font-size: .85rem; }
        .edu-periodo { color: #64748b; font-size: .8rem; }
        .edu-nota { color: #94a3b8; font-size: .82rem; margin-top: .25rem; }
 
        .skills-group { margin-bottom: .9rem; }
        .skills-group:last-child { margin-bottom: 0; }
        .skills-label { font-size: .8rem; color: #64748b; margin-bottom: .4rem; }
        .tags { display: flex; flex-wrap: wrap; gap: .4rem; }
        .tag {
            background: #0f172a;
            border: 1px solid #334155;
            color: #94a3b8;
            padding: .2rem .7rem;
            border-radius: 20px;
            font-size: .78rem;
        }
 
        .proyecto { margin-bottom: 1.2rem; padding-bottom: 1.2rem; border-bottom: 1px solid #1e293b; }
        .proyecto:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        .proyecto-nombre { font-weight: 600; color: #f1f5f9; margin-bottom: .3rem; }
        .proyecto-desc { color: #94a3b8; font-size: .85rem; margin-bottom: .5rem; }
        .proyecto-github { color: #60a5fa; font-size: .8rem; text-decoration: none; }
 
        .idioma-item {
            display: flex;
            justify-content: space-between;
            padding: .4rem 0;
            border-bottom: 1px solid #1e293b;
            font-size: .9rem;
        }
        .idioma-item:last-child { border-bottom: none; }
        .nivel { color: #64748b; }
 
        footer {
            text-align: center;
            padding: 1.5rem;
            color: #475569;
            font-size: .78rem;
        }
 
        @media (max-width: 600px) {
            main { grid-template-columns: 1fr; }
            section.full { grid-column: 1; }
        }
    </style>
</head>
<body>
 
<header>
    <div class="avatar">👨‍💻</div>
    <h1><?= htmlspecialchars($cv['nombre']) ?></h1>
    <p class="tagline">Desarrollador Web · DevOps Junior · <?= $cv['edad'] ?> años · <?= htmlspecialchars($cv['ubicacion']) ?></p>
    <div class="contact-bar">
        <a href="mailto:<?= $cv['email'] ?>"><?= $cv['email'] ?></a>
        <a href="https://<?= $cv['github'] ?>" target="_blank"><?= $cv['github'] ?></a>
    </div>
</header>
 
<main>
 
    <section class="full">
        <h2>Sobre mí</h2>
        <p class="sobre-mi"><?= htmlspecialchars($cv['sobre_mi']) ?></p>
    </section>
 
    <section>
        <h2>Educación</h2>
        <?php foreach ($cv['educacion'] as $edu): ?>
        <div class="edu-item">
            <div class="edu-titulo"><?= htmlspecialchars($edu['titulo']) ?></div>
            <div class="edu-centro"><?= htmlspecialchars($edu['centro']) ?></div>
            <div class="edu-periodo"><?= $edu['periodo'] ?></div>
            <div class="edu-nota"><?= htmlspecialchars($edu['nota']) ?></div>
        </div>
        <?php endforeach; ?>
    </section>
 
    <section>
        <h2>Habilidades</h2>
        <?php foreach ($cv['habilidades'] as $categoria => $skills): ?>
        <div class="skills-group">
            <div class="skills-label"><?= $categoria ?></div>
            <div class="tags">
                <?php foreach ($skills as $skill): ?>
                <span class="tag"><?= $skill ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
 
    <section class="full">
        <h2>Proyectos</h2>
        <?php foreach ($cv['proyectos'] as $proyecto): ?>
        <div class="proyecto">
            <div class="proyecto-nombre"><?= htmlspecialchars($proyecto['nombre']) ?></div>
            <p class="proyecto-desc"><?= htmlspecialchars($proyecto['descripcion']) ?></p>
            <div class="tags" style="margin-bottom:.5rem">
                <?php foreach ($proyecto['tecnologias'] as $tech): ?>
                <span class="tag"><?= $tech ?></span>
                <?php endforeach; ?>
            </div>
            <a class="proyecto-github" href="https://<?= $proyecto['github'] ?>" target="_blank">
                ↗ <?= $proyecto['github'] ?>
            </a>
        </div>
        <?php endforeach; ?>
    </section>
 
    <section>
        <h2>Idiomas</h2>
        <?php foreach ($cv['idiomas'] as $item): ?>
        <div class="idioma-item">
            <span><?= $item['idioma'] ?></span>
            <span class="nivel"><?= $item['nivel'] ?></span>
        </div>
        <?php endforeach; ?>
    </section>
 
</main>
 
<footer>
    Joel Cid Ortega · <?= date('Y') ?> · Desplegado con Jenkins CI/CD
</footer>
 
</body>
</html>
 