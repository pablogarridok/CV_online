<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit(); }

// ============================================================
// MODIFICA ESTOS DATOS CON TU INFORMACIÓN REAL
// ============================================================
$cv = [
    'nombre'      => 'Pablo Garrido Rubio',
    'titulo'      => 'Desarrollador Web Full Stack',
    'email'       => 'pablogarrub@campus.monlau.com',
    'telefono'    => '+34 546 35 64 87',
    'github'      => 'github.com/pablogarridok',
    'linkedin'    => 'linkedin.com/in/pablo-garrido-rubio',
    'descripcion' => 'Desarrollador web de 21 años apasionado por crear aplicaciones modernas y eficientes. Actualmente cursando 2º de DAW en Monlau, donde he aprendido a construir soluciones completas combinando backend PHP con frontends en React. Me motiva especialmente el mundo DevOps y la automatización de despliegues.',
    // ACTIVIDAD 4: Sustituye esta URL por la de ImageKit
    'foto'        => '',
    'iniciales'   => 'PG',
    'habilidades' => ['PHP', 'JavaScript', 'React', 'MySQL', 'HTML/CSS', 'Git', 'Docker', 'Linux', 'Jenkins', 'Python'],
    'experiencia' => [
        [
            'empresa'     => 'Restaurant La Terrassa',
            'cargo'       => 'Camarero',
            'periodo'     => 'Junio 2023 – Actualidad',
            'descripcion' => 'Atención al cliente en sala y terraza. Gestión de comandas y cobros. Trabajo en equipo en entornos de alta demanda.',
        ],
        [
            'empresa'     => 'Pràctiques FCT — Empresa de Desenvolupament',
            'cargo'       => 'Desarrollador Web (Prácticas FCT)',
            'periodo'     => 'Marzo 2026 – Junio 2026',
            'descripcion' => 'Desarrollo y mantenimiento de aplicaciones web con PHP y MySQL. Implementación de interfaces con JavaScript y participación en el ciclo completo de despliegue.',
        ],
    ],
    'educacion' => [
        [
            'institucion' => 'Monlau Formació Professional',
            'titulo'      => 'CFGS Desarrollo de Aplicaciones Web (DAW)',
            'periodo'     => '2024 – 2026',
        ],
        [
            'institucion' => 'Institut Lluís de Requesens',
            'titulo'      => 'Bachillerato Científico-Tecnológico',
            'periodo'     => '2021 – 2023',
        ],
    ],
    'proyectos' => [
        [
            'nombre'      => 'CV Online con Pipeline CI/CD',
            'descripcion' => 'CV online desplegado automáticamente con Jenkins en Docker. Cada git push lanza el pipeline: validación PHP, copia a Apache y recarga del servidor. CDN con Cloudflare e imágenes optimizadas con ImageKit.',
            'tech'        => 'PHP · React · Jenkins · Docker · Cloudflare · ImageKit',
        ],
        [
            'nombre'      => 'TaskFlow — Gestión de Tareas',
            'descripcion' => 'Aplicación web para gestión de tareas en equipo con sistema de usuarios, prioridades y notificaciones en tiempo real.',
            'tech'        => 'PHP · MySQL · JavaScript · WebSockets',
        ],
        [
            'nombre'      => 'API REST de Inventario',
            'descripcion' => 'API REST para gestión de inventario con autenticación JWT y endpoints CRUD completos.',
            'tech'        => 'PHP · MySQL · JWT · Apache',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($cv['nombre']) ?> – CV Online</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, sans-serif;
            background: #edf2f7;
            color: #2d3748;
            min-height: 100vh;
        }

        .cv-container {
            display: flex;
            max-width: 960px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }

        /* ─── SIDEBAR ─────────────────────────────────────────── */
        .sidebar {
            width: 300px;
            min-width: 300px;
            background: #1a2332;
            color: #e8ecf0;
            padding: 40px 28px;
        }

        .profile-photo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #3498db;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #2c5282;
            font-size: 2.2rem;
            font-weight: 700;
            color: #fff;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-name {
            text-align: center;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .sidebar-title {
            text-align: center;
            font-size: 0.82rem;
            color: #3498db;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 28px;
        }

        .sidebar-section {
            margin-bottom: 28px;
        }

        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #3498db;
            border-bottom: 1px solid #2c405e;
            padding-bottom: 6px;
            margin-bottom: 14px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.82rem;
            color: #cbd5e0;
            word-break: break-all;
        }

        .contact-icon {
            font-size: 0.9rem;
            min-width: 16px;
            margin-top: 1px;
        }

        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .skill-tag {
            background: #2c405e;
            color: #90cdf4;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* ─── MAIN CONTENT ────────────────────────────────────── */
        .main-content {
            flex: 1;
            padding: 40px 36px;
            background: #f8fafc;
        }

        .main-section {
            margin-bottom: 32px;
        }

        .main-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #3498db;
            border-bottom: 2px solid #3498db;
            padding-bottom: 6px;
            margin-bottom: 18px;
        }

        .about-text {
            font-size: 0.9rem;
            line-height: 1.7;
            color: #4a5568;
        }

        .timeline-item {
            position: relative;
            padding-left: 18px;
            margin-bottom: 18px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3498db;
        }

        .timeline-company {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1a202c;
        }

        .timeline-role {
            font-size: 0.85rem;
            color: #4a5568;
            margin-bottom: 2px;
        }

        .timeline-period {
            font-size: 0.75rem;
            color: #3498db;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .timeline-desc {
            font-size: 0.82rem;
            color: #718096;
            line-height: 1.6;
        }

        .project-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .project-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .project-desc {
            font-size: 0.82rem;
            color: #718096;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .project-tech {
            font-size: 0.72rem;
            color: #3498db;
            font-weight: 600;
        }

        @media (max-width: 700px) {
            .cv-container { flex-direction: column; margin: 0; border-radius: 0; }
            .sidebar { width: 100%; }
        }
    </style>
</head>
<body>

<div class="cv-container">

    <!-- ─── SIDEBAR ──────────────────────────────── -->
    <aside class="sidebar">

        <div class="profile-photo-wrap">
            <div class="profile-photo">
                <?php if (!empty($cv['foto'])): ?>
                    <img src="<?= htmlspecialchars($cv['foto']) ?>" alt="Foto de perfil">
                <?php else: ?>
                    <?= htmlspecialchars($cv['iniciales']) ?>
                <?php endif; ?>
            </div>
        </div>

        <p class="sidebar-name"><?= htmlspecialchars($cv['nombre']) ?></p>
        <p class="sidebar-title"><?= htmlspecialchars($cv['titulo']) ?></p>

        <div class="sidebar-section">
            <p class="sidebar-section-title">Contacto</p>
            <div class="contact-item">
                <span class="contact-icon">✉</span>
                <span><?= htmlspecialchars($cv['email']) ?></span>
            </div>
            <div class="contact-item">
                <span class="contact-icon">📞</span>
                <span><?= htmlspecialchars($cv['telefono']) ?></span>
            </div>
            <div class="contact-item">
                <span class="contact-icon">🐙</span>
                <span><?= htmlspecialchars($cv['github']) ?></span>
            </div>
            <div class="contact-item">
                <span class="contact-icon">💼</span>
                <span><?= htmlspecialchars($cv['linkedin']) ?></span>
            </div>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-section-title">Habilidades</p>
            <div class="skills-grid">
                <?php foreach ($cv['habilidades'] as $skill): ?>
                    <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

    </aside>

    <!-- ─── MAIN CONTENT ─────────────────────────── -->
    <main class="main-content">

        <section class="main-section">
            <p class="main-section-title">Sobre mí</p>
            <p class="about-text"><?= htmlspecialchars($cv['descripcion']) ?></p>
        </section>

        <section class="main-section">
            <p class="main-section-title">Experiencia</p>
            <?php foreach ($cv['experiencia'] as $exp): ?>
            <div class="timeline-item">
                <p class="timeline-company"><?= htmlspecialchars($exp['empresa']) ?></p>
                <p class="timeline-role"><?= htmlspecialchars($exp['cargo']) ?></p>
                <p class="timeline-period"><?= htmlspecialchars($exp['periodo']) ?></p>
                <p class="timeline-desc"><?= htmlspecialchars($exp['descripcion']) ?></p>
            </div>
            <?php endforeach; ?>
        </section>

        <section class="main-section">
            <p class="main-section-title">Educación</p>
            <?php foreach ($cv['educacion'] as $edu): ?>
            <div class="timeline-item">
                <p class="timeline-company"><?= htmlspecialchars($edu['institucion']) ?></p>
                <p class="timeline-role"><?= htmlspecialchars($edu['titulo']) ?></p>
                <p class="timeline-period"><?= htmlspecialchars($edu['periodo']) ?></p>
            </div>
            <?php endforeach; ?>
        </section>

        <section class="main-section">
            <p class="main-section-title">Proyectos</p>
            <?php foreach ($cv['proyectos'] as $proyecto): ?>
            <div class="project-card">
                <p class="project-name"><?= htmlspecialchars($proyecto['nombre']) ?></p>
                <p class="project-desc"><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                <p class="project-tech"><?= htmlspecialchars($proyecto['tech']) ?></p>
            </div>
            <?php endforeach; ?>
        </section>

    </main>

</div>

</body>
</html>
