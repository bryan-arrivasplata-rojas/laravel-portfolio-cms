<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\ContactLink;
use App\Models\Experience;
use App\Models\Section;
use App\Models\SkillCategory;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'bryanarrivasplata.rojas@gmail.com'],
            [
                'name' => 'Bryan Daniell Arrivasplata Rojas',
                'password' => Hash::make('bryan123456'),
                'email_verified_at' => now(),
            ]
        );

        $settings = [
            [
                'key' => 'site_name',
                'value_i18n' => ['es' => 'Bryan Arrivasplata · Ingeniero de Sistemas', 'en' => 'Bryan Arrivasplata · Systems Engineer'],
                'group' => 'general',
                'type' => 'text'
            ],
            [
                'key' => 'site_logo_prefix',
                'value_i18n' => ['value' => 'B.'],
                'group' => 'general',
                'type' => 'text'
            ],
            [
                'key' => 'site_logo_suffix',
                'value_i18n' => ['value' => 'A.'],
                'group' => 'general',
                'type' => 'text'
            ],
            [
                'key' => 'profile_avatar',
                'value_i18n' => ['value' => 'images/bryan.webp'],
                'group' => 'general',
                'type' => 'media_path'
            ],
            [
                'key' => 'site_favicon',
                'value_i18n' => ['value' => 'favicon.svg'],
                'group' => 'general',
                'type' => 'media_path'
            ],
            [
                'key' => 'footer_copyright',
                'value_i18n' => [
                    'es' => '© 2026 Bryan Daniell Arrivasplata Rojas · Perú',
                    'en' => '© 2026 Bryan Daniell Arrivasplata Rojas · Peru'
                ],
                'group' => 'general',
                'type' => 'textarea'
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $sections = [
            [
                'key' => 'hero',
                'title_prefix_i18n' => ['es' => 'Bryan ', 'en' => 'Bryan '],
                'title_highlight_i18n' => ['es' => 'Arrivasplata', 'en' => 'Arrivasplata'],
                'subtitle_i18n' => [
                    'es' => 'Diseño y optimizo sistemas de alta transaccionalidad <br />con arquitecturas resilientes.',
                    'en' => 'Designing and optimizing high-transactionality systems <br />with resilient architectures.'
                ],
                'content_i18n' => [
                    'badge' => ['es' => 'Backend Engineer · Core Banking', 'en' => 'Backend Engineer · Core Banking'],
                    'description' => [
                        'es' => 'Ingeniero de Sistemas con más de 5 años de experiencia en el sector financiero, especializado en el diseño y optimización de sistemas de alta transaccionalidad. Apasionado por la arquitectura de microservicios, el procesamiento de datos en tiempo real y la construcción de soluciones escalables y tolerantes a fallos, aportando valor a entidades financieras líderes.',
                        'en' => 'Systems Engineer with over 5 years of experience in the financial sector, specialized in designing and optimizing high-transactionality systems. Passionate about microservices architecture, real-time data processing, and building scalable, fault-tolerant solutions that deliver value to leading financial institutions.'
                    ],
                    'btn_experience' => ['es' => 'Ver experiencia', 'en' => 'View experience'],
                    'btn_contact' => ['es' => 'Contactar', 'en' => 'Contact']
                ],
                'is_visible' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'about',
                'title_prefix_i18n' => ['es' => 'Sobre ', 'en' => 'About '],
                'title_highlight_i18n' => ['es' => 'mí', 'en' => 'me'],
                'subtitle_i18n' => null,
                'content_i18n' => [
                    'p1' => [
                        'es' => '<strong>Ingeniero de Sistemas</strong> con más de 5 años de experiencia en el sector financiero, liderando el diseño de soluciones core para entidades bancarias de primer nivel. Especializado en <strong>arquitecturas de procesamiento transaccional (Online/Batch)</strong>, microservicios y sistemas orientados a eventos, siempre buscando el equilibrio entre rendimiento, mantenibilidad y seguridad.',
                        'en' => '<strong>Systems Engineer</strong> with over 5 years of experience in the financial sector, leading the design of core solutions for top-tier banks. Specialized in <strong>transactional processing architectures (Online/Batch)</strong>, microservices, and event-driven systems, always seeking the balance between performance, maintainability, and security.'
                    ],
                    'p2' => [
                        'es' => 'He participado en proyectos de <strong>pagos P2P</strong>, campañas promocionales, reportería regulatoria y migraciones históricas, gestionando volúmenes críticos de datos sin afectar la operativa del core bancario.',
                        'en' => 'I have participated in <strong>P2P payments</strong>, promotional campaigns, regulatory reporting, and historical migrations, handling critical data volumes without impacting the banking core.'
                    ],
                    'linkedin_label' => ['es' => 'LinkedIn', 'en' => 'LinkedIn'],
                    'linkedin_url' => 'https://www.linkedin.com/in/bryanarrivasplata'
                ],
                'is_visible' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'experience',
                'title_prefix_i18n' => ['es' => 'Trayectoria ', 'en' => 'Professional '],
                'title_highlight_i18n' => ['es' => 'profesional', 'en' => 'Experience'],
                'subtitle_i18n' => [
                    'es' => 'Experiencia en empresas líderes, siempre en el corazón de los sistemas financieros.',
                    'en' => 'Experience at leading companies, always at the heart of financial systems.'
                ],
                'content_i18n' => null,
                'is_visible' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'skills',
                'title_prefix_i18n' => ['es' => 'Habilidades ', 'en' => 'Technical '],
                'title_highlight_i18n' => ['es' => 'técnicas', 'en' => 'Skills'],
                'subtitle_i18n' => [
                    'es' => 'Stack moderno para arquitecturas robustas y escalables.',
                    'en' => 'Modern stack for robust and scalable architectures.'
                ],
                'content_i18n' => null,
                'is_visible' => true,
                'sort_order' => 4,
            ],
            [
                'key' => 'certifications',
                'title_prefix_i18n' => ['es' => 'Certificaciones ', 'en' => 'Featured '],
                'title_highlight_i18n' => ['es' => 'destacadas', 'en' => 'Certifications'],
                'subtitle_i18n' => [
                    'es' => 'Formación continua para mantenerse a la vanguardia.',
                    'en' => 'Continuous training to stay at the forefront.'
                ],
                'content_i18n' => null,
                'is_visible' => true,
                'sort_order' => 5,
            ],
            [
                'key' => 'contact',
                'title_prefix_i18n' => ['es' => 'Conectemos', 'en' => "Let's connect"],
                'title_highlight_i18n' => null,
                'subtitle_i18n' => [
                    'es' => '¿Interesado en colaborar o conocer más sobre mi trabajo?',
                    'en' => 'Interested in collaborating or learning more about my work?'
                ],
                'content_i18n' => null,
                'is_visible' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($sections as $sec) {
            Section::updateOrCreate(['key' => $sec['key']], $sec);
        }

        $stats = [
            ['number' => '5+', 'label_i18n' => ['es' => 'Años de experiencia', 'en' => 'Years of experience'], 'sort_order' => 1],
            ['number' => '8', 'label_i18n' => ['es' => 'Certificaciones clave', 'en' => 'Key certifications'], 'sort_order' => 2],
            ['number' => '5', 'label_i18n' => ['es' => 'Proyectos core', 'en' => 'Core projects'], 'sort_order' => 3],
        ];
        foreach ($stats as $stat) {
            Stat::updateOrCreate(['number' => $stat['number']], $stat);
        }

        $experiences = [
            [
                'position_i18n' => ['es' => 'Senior Backend Engineer', 'en' => 'Senior Backend Engineer'],
                'company_i18n' => ['es' => 'Bluetab, an IBM Company · BBVA', 'en' => 'Bluetab, an IBM Company · BBVA'],
                'period_i18n' => ['es' => 'Abr 2025 – Actualidad', 'en' => 'Apr 2025 – Present'],
                'responsibilities_i18n' => [
                    'es' => [
                        'Lideré el diseño del motor de campañas promocionales sobre PLIN con arquitectura APX (Online/Batch), LRBA y DataX, integrado con servidores IBM.',
                        'Diseñé reportería regulatoria de movimientos PLIN con motores de notificación y Document Generator.',
                        'Construí procesos batch en DataX para migración histórica de datos transaccionales a gran escala.',
                        'Optimicé consultas Oracle y servicios de consulta para explotación eficiente de movimientos desde sistemas Host.'
                    ],
                    'en' => [
                        'Led the design of the promotional campaign engine on PLIN with APX architecture (Online/Batch), LRBA, and DataX, integrated with IBM servers.',
                        'Designed regulatory reporting for PLIN movements with notification engines and Document Generator.',
                        'Built batch processes and DataX execution meshes for historical migration of transactional data at scale.',
                        'Optimized Oracle queries and designed query services for efficient consumption of financial movements from Host systems.'
                    ]
                ],
                'sort_order' => 1,
            ],
            [
                'position_i18n' => ['es' => 'Backend Engineer', 'en' => 'Backend Engineer'],
                'company_i18n' => ['es' => 'Stefanini IT Solutions · BBVA', 'en' => 'Stefanini IT Solutions · BBVA'],
                'period_i18n' => ['es' => 'Nov 2023 – Mar 2025', 'en' => 'Nov 2023 – Mar 2025'],
                'responsibilities_i18n' => [
                    'es' => [
                        'Implementé procesamiento de pagos a estudios jurídicos mediante batch, Control-M y DataX.',
                        'Integré componentes APX con APIs externas vía Proxy para fidelización (Loyalty), incluyendo servicios criptográficos.',
                        'Participé en la construcción de componentes transaccionales para contratación de productos financieros (Issuing).',
                        'Ajusté componentes APX de Open Market y gestioné despliegues productivos.'
                    ],
                    'en' => [
                        'Implemented payment processing for external law firms via batch, Control-M, and DataX.',
                        'Integrated APX components with external APIs via Proxy for Loyalty, including cryptographic services.',
                        'Participated in the construction of online transactional components for financial product contracting (Issuing).',
                        'Adjusted APX components of Open Market and managed production deployments.'
                    ]
                ],
                'sort_order' => 2,
            ],
            [
                'position_i18n' => ['es' => 'Systems Intern – Backend', 'en' => 'Systems Intern – Backend'],
                'company_i18n' => ['es' => 'ManpowerGroup', 'en' => 'ManpowerGroup'],
                'period_i18n' => ['es' => 'Sep 2022 – Dic 2022', 'en' => 'Sep 2022 – Dec 2022'],
                'responsibilities_i18n' => [
                    'es' => [
                        'Analicé requerimientos funcionales y coordiné con especialistas para integración de mejoras en sistemas financieros y de RR.HH.',
                        'Desarrollé y mantuve formularios y reportes operativos, optimizando consultas SQL.',
                        'Apoyé la implementación del Sistema de Gestión de Calidad (ISO 9001:2015) y diseñé trazabilidad digital con Google Apps Script.'
                    ],
                    'en' => [
                        'Analyzed functional requirements and coordinated with component specialists for system improvements.',
                        'Developed and maintained operational forms and reports, optimizing SQL queries.',
                        'Supported the implementation of the Quality Management System (ISO 9001:2015) and designed a digital traceability solution for external audit, including Google Apps Script automations.'
                    ]
                ],
                'sort_order' => 3,
            ],
            [
                'position_i18n' => ['es' => 'Quality Management Assistant', 'en' => 'Quality Management Assistant'],
                'company_i18n' => ['es' => 'Acreditación y Calidad FIIS – Universidad Nacional de Ingeniería', 'en' => 'Accreditation and Quality FIIS – National University of Engineering'],
                'period_i18n' => ['es' => 'Ene 2022 – Ago 2022', 'en' => 'Jan 2022 – Aug 2022'],
                'responsibilities_i18n' => [
                    'es' => [
                        'Apoyé la implementación del Sistema de Gestión de Calidad (ISO 9001:2015) y diseñé una solución de trazabilidad digital para auditoría externa, incluyendo automatizaciones con Google Apps Script.',
                        'Colaboré en la documentación de procesos y mejora continua, asegurando el cumplimiento de estándares internacionales.'
                    ],
                    'en' => [
                        'Supported the implementation of the Quality Management System (ISO 9001:2015) and designed a digital traceability solution for external audit, including Google Apps Script automations.',
                        'Collaborated in process documentation and continuous improvement, ensuring compliance with international standards.'
                    ]
                ],
                'sort_order' => 4,
            ]
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(['position_i18n->es' => $exp['position_i18n']['es']], $exp);
        }

        $categories = [
            [
                'name_i18n' => ['es' => 'Core & Backend', 'en' => 'Core & Backend'],
                'icon' => 'fas fa-server',
                'animation_class' => 'fade-left',
                'sort_order' => 1,
                'skills' => [
                    ['name' => 'Java / Spring Boot', 'icon' => 'fab fa-java'],
                    ['name' => 'APX (Online/Batch)', 'icon' => 'fas fa-cubes'],
                    ['name' => 'Microservicios (ASO)', 'icon' => 'fas fa-microchip'],
                    ['name' => 'LRBA', 'icon' => 'fas fa-database'],
                    ['name' => 'Python / Flask', 'icon' => 'fab fa-python'],
                    ['name' => 'Node.js', 'icon' => 'fab fa-node'],
                ]
            ],
            [
                'name_i18n' => ['es' => 'Cloud & DevOps', 'en' => 'Cloud & DevOps'],
                'icon' => 'fas fa-cloud',
                'animation_class' => 'fade-right',
                'sort_order' => 2,
                'skills' => [
                    ['name' => 'AWS (Practitioner)', 'icon' => 'fab fa-aws'],
                    ['name' => 'Azure (Fundamentals)', 'icon' => 'fab fa-microsoft'],
                    ['name' => 'GCP (Cloud Digital Leader)', 'icon' => 'fab fa-google'],
                    ['name' => 'Git / Bitbucket', 'icon' => 'fas fa-code-branch'],
                    ['name' => 'Control-M', 'icon' => 'fas fa-cog'],
                    ['name' => 'ECS-CLI', 'icon' => 'fas fa-rocket'],
                ]
            ],
            [
                'name_i18n' => ['es' => 'Bases de datos', 'en' => 'Databases'],
                'icon' => 'fas fa-database',
                'animation_class' => 'fade-left',
                'sort_order' => 3,
                'skills' => [
                    ['name' => 'Oracle SQL / PL/SQL', 'icon' => 'fas fa-database'],
                    ['name' => 'PostgreSQL', 'icon' => 'fas fa-database'],
                    ['name' => 'Power Designer', 'icon' => 'fas fa-pencil-alt'],
                ]
            ],
            [
                'name_i18n' => ['es' => 'Testing & Herramientas', 'en' => 'Testing & Tools'],
                'icon' => 'fas fa-vial',
                'animation_class' => 'fade-right',
                'sort_order' => 4,
                'skills' => [
                    ['name' => 'JUnit / Mockito', 'icon' => 'fas fa-check-circle'],
                    ['name' => 'Cucumber / Xray', 'icon' => 'fas fa-cucumber'],
                    ['name' => 'Postman / Bruno', 'icon' => 'fas fa-code'],
                ]
            ],
        ];

        foreach ($categories as $catData) {
            $skills = $catData['skills'];
            unset($catData['skills']);
            $cat = SkillCategory::updateOrCreate(['name_i18n->es' => $catData['name_i18n']['es']], $catData);
            
            $cat->skills()->delete();
            foreach ($skills as $index => $sk) {
                $cat->skills()->create([
                    'name' => $sk['name'],
                    'icon' => $sk['icon'],
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $certifications = [
            [
                'icon' => 'fas fa-tasks',
                'name_i18n' => ['es' => 'Scrum Master Professional (SMPC)', 'en' => 'Scrum Master Professional (SMPC)'],
                'organization_i18n' => ['es' => 'CertiProf', 'en' => 'CertiProf'],
                'date_i18n' => ['es' => 'Ago 2026 – Ago 2029', 'en' => 'Aug 2026 – Aug 2029'],
                'icon_color' => null,
                'sort_order' => 1,
            ],
            [
                'icon' => 'fab fa-aws',
                'name_i18n' => ['es' => 'AWS Cloud Practitioner', 'en' => 'AWS Cloud Practitioner'],
                'organization_i18n' => ['es' => 'Amazon Web Services', 'en' => 'Amazon Web Services'],
                'date_i18n' => ['es' => 'May 2026 – Mar 2029', 'en' => 'May 2026 – Mar 2029'],
                'icon_color' => null,
                'sort_order' => 2,
            ],
            [
                'icon' => 'fab fa-microsoft',
                'name_i18n' => ['es' => 'Azure Fundamentals (AZ-900)', 'en' => 'Azure Fundamentals (AZ-900)'],
                'organization_i18n' => ['es' => 'Microsoft', 'en' => 'Microsoft'],
                'date_i18n' => ['es' => 'Jul 2026', 'en' => 'Jul 2026'],
                'icon_color' => null,
                'sort_order' => 3,
            ],
            [
                'icon' => 'fas fa-university',
                'name_i18n' => ['es' => 'APX – BBVA', 'en' => 'APX – BBVA'],
                'organization_i18n' => ['es' => 'Net4Skills', 'en' => 'Net4Skills'],
                'date_i18n' => ['es' => '2025', 'en' => '2025'],
                'icon_color' => null,
                'sort_order' => 4,
            ],
            [
                'icon' => 'fab fa-google',
                'name_i18n' => ['es' => 'Cloud Digital Leader', 'en' => 'Cloud Digital Leader'],
                'organization_i18n' => ['es' => 'Google Cloud', 'en' => 'Google Cloud'],
                'date_i18n' => ['es' => 'Sep 2024', 'en' => 'Sep 2024'],
                'icon_color' => null,
                'sort_order' => 5,
            ],
            [
                'icon' => 'fas fa-chart-line',
                'name_i18n' => ['es' => 'Kanban Foundation KIKF™', 'en' => 'Kanban Foundation KIKF™'],
                'organization_i18n' => ['es' => 'Kanban Institute', 'en' => 'Kanban Institute'],
                'date_i18n' => ['es' => 'Oct 2024', 'en' => 'Oct 2024'],
                'icon_color' => null,
                'sort_order' => 6,
            ],
            [
                'icon' => 'fas fa-certificate',
                'name_i18n' => ['es' => 'Interpretación y Formación de Auditores Internos ISO 9001:2015', 'en' => 'Interpretation and Training of Internal Auditors ISO 9001:2015'],
                'organization_i18n' => ['es' => 'Bureau Veritas Perú', 'en' => 'Bureau Veritas Perú'],
                'date_i18n' => ['es' => 'Oct 2022', 'en' => 'Oct 2022'],
                'icon_color' => '#f0b429',
                'sort_order' => 7,
            ],
            [
                'icon' => 'fab fa-java',
                'name_i18n' => ['es' => 'Programador Java', 'en' => 'Java Programmer'],
                'organization_i18n' => ['es' => 'Sistemas UNI', 'en' => 'Sistemas UNI'],
                'date_i18n' => ['es' => 'Feb 2018', 'en' => 'Feb 2018'],
                'icon_color' => null,
                'sort_order' => 8,
            ],
        ];

        foreach ($certifications as $cert) {
            Certification::updateOrCreate(['name_i18n->es' => $cert['name_i18n']['es']], $cert);
        }

        $contacts = [
            [
                'type' => 'email',
                'icon' => 'fas fa-envelope',
                'label_i18n' => ['es' => 'bryanarrivasplata.rojas@gmail.com', 'en' => 'bryanarrivasplata.rojas@gmail.com'],
                'url' => 'mailto:bryanarrivasplata.rojas@gmail.com',
                'copy_value' => 'bryanarrivasplata.rojas@gmail.com',
                'target' => '_self',
                'sort_order' => 1,
            ],
            [
                'type' => 'linkedin',
                'icon' => 'fab fa-linkedin',
                'label_i18n' => ['es' => 'LinkedIn', 'en' => 'LinkedIn'],
                'url' => 'https://www.linkedin.com/in/bryanarrivasplata',
                'copy_value' => null,
                'target' => '_blank',
                'sort_order' => 2,
            ],
            [
                'type' => 'github',
                'icon' => 'fab fa-github',
                'label_i18n' => ['es' => 'GitHub', 'en' => 'GitHub'],
                'url' => 'https://github.com/bryan-arrivasplata-rojas',
                'copy_value' => null,
                'target' => '_blank',
                'sort_order' => 3,
            ],
            [
                'type' => 'website',
                'icon' => 'fas fa-globe',
                'label_i18n' => ['es' => 'bryanarrivasplata.com', 'en' => 'bryanarrivasplata.com'],
                'url' => 'https://bryanarrivasplata.com',
                'copy_value' => null,
                'target' => '_blank',
                'sort_order' => 4,
            ],
            [
                'type' => 'whatsapp',
                'icon' => 'fas fa-phone-alt',
                'label_i18n' => ['es' => '+51 997 767 771', 'en' => '+51 997 767 771'],
                'url' => 'https://wa.me/51997767771?text=Hola%20Bryan%2C%20me%20gustar%C3%ADa%20consultar%20informaci%C3%B3n%20sobre%20tus%20servicios.',
                'copy_value' => '+51 997 767 771',
                'target' => '_blank',
                'sort_order' => 5,
            ],
        ];

        foreach ($contacts as $c) {
            ContactLink::updateOrCreate(['type' => $c['type']], $c);
        }
    }
}