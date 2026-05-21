<?php
header("Content-Type: application/json; charset=UTF-8");
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
    'github'      => 'github.com/pablogarridok',
    'descripcion' => 'Desarrollador web de 21 años apasionado por crear aplicaciones modernas y eficientes. Cursando 2º de DAW en Monlau.',
    'habilidades' => ['PHP', 'JavaScript', 'React', 'MySQL', 'Git', 'Docker', 'Linux'],
    'experiencia' => [
        [
            'empresa'     => 'Restaurant La Terrassa',
            'cargo'       => 'Camarero',
            'periodo'     => 'Junio 2023 – Actualidad',
            'descripcion' => 'Atención al cliente en sala y terraza. Gestión de comandas y cobros.',
        ],
        [
            'empresa'     => 'Pràctiques FCT — Empresa de Desenvolupament',
            'cargo'       => 'Desarrollador Web (Prácticas FCT)',
            'periodo'     => 'Marzo 2026 – Junio 2026',
            'descripcion' => 'Desarrollo y mantenimiento de aplicaciones web con PHP y MySQL.',
        ],
    ],
    'educacion' => [
        [
            'institucion' => 'Monlau Formació Professional',
            'titulo'      => 'CFGS Desarrollo de Aplicaciones Web (DAW)',
            'periodo'     => '2024 – 2026',
        ],
    ],
];

echo json_encode($cv, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
