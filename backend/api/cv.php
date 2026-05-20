<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit(); }

// ============================================================
// MODIFICA ESTOS DATOS CON TU INFORMACIÓN REAL
// ============================================================
$cv = [
    'nombre'      => 'Tu Nombre Apellido',
    'titulo'      => 'Desarrollador Web Full Stack',
    'email'       => 'tu@email.com',
    'github'      => 'github.com/tuusuario',
    'descripcion' => 'Desarrollador web apasionado por la tecnología y el aprendizaje continuo.',
    'habilidades' => ['PHP', 'JavaScript', 'React', 'MySQL', 'Git', 'Docker', 'Linux'],
    'experiencia' => [
        [
            'empresa'     => 'Empresa de Prácticas S.L.',
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
