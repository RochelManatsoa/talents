<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Sector;
use App\Entity\Account;
use App\Entity\Application;
use App\Entity\Company;
use App\Entity\Expert;
use App\Entity\Posting;
use App\Entity\Identity;
use App\Entity\Identity\Experience;
use App\Entity\Identity\Formation;
use App\Entity\Language;
use Symfony\Component\Uid\Uuid;
use App\Entity\Identity\SpokenLanguage;
use App\Entity\Identity\TechnicalSkill;
use App\Entity\Type\PostingType;
use App\Entity\Views\IdentityViews;
use App\Entity\Views\PostingViews;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $encoder,
        private ParameterBagInterface $parameterBag,
        private SluggerInterface $sluggerInterface,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $allFiles = scandir($this->parameterBag->get('kernel.project_dir') . '/public/uploads/experts/');
        $images = array_diff($allFiles, array('.', '..'));

        $s = [
            0 => [
                'name' => 'IT - Devéloppement',
                'slug' => 'it-developpement',
                'competences' => [
                    'Programmation',
                    'Maîtrise des systèmes de gestion de bases de données',
                    'Développement Front-end ',
                    'Conception et architecture logicielle',
                    'Intégration continue et déploiement continu (CI/CD)',
                    'Développement mobile (e.g., Android, iOS)',
                ],
            ],
            1 => [
                'name' => 'Marketing Digital',
                'slug' => 'marketing-digital',
                'competences' => [
                    'SEO (Optimisation pour les moteurs de recherche)',
                    'SEM (Marketing sur les moteurs de recherche)',
                    'Marketing sur les réseaux sociaux',
                    'Analyse de données et KPIs',
                    'Content marketing',
                    'E-mail marketing',
                ],
            ],
            2 => [
                'name' => 'Commercial',
                'slug' => 'commercial',
                'competences' => [
                    'Techniques de vente',
                    'Négociation commerciale',
                    'Gestion de la relation client (CRM)',
                    'Prospection commerciale',
                    'Connaissance des produits/services de l\'entreprise',
                    'Stratégie de vente et marketing',
                    'Analyse des besoins du client',
                ],
            ],
            3 => [
                'name' => 'Recrutement',
                'slug' => 'recrutement',
                'competences' => [
                    'Sourcing de candidats',
                    'Entretiens d\'embauche',
                    'Évaluation et sélection des candidats',
                    'Connaissance des outils de recrutement (e.g., LinkedIn, plateformes d\'offres d\'emploi)',
                    'Conception et rédaction d\'offres d\'emploi',
                    'Législation du travail et réglementation de l\'embauche',
                    'Gestion des relations avec les agences de recrutement',
                ],
            ],
            4 => [
                'name' => 'RH - Administration',
                'slug' => 'rh-administration',
                'competences' => [
                    'Gestion administrative du personnel',
                    'Gestion des paies',
                    'Connaissance de la législation du travail',
                    'Formation et développement des employés',
                    'Gestion des conflits et médiation',
                    'Évaluation des performances',
                    'Gestion des avantages et rémunérations',
                ],
            ],
            5 => [
                'name' => 'Finance',
                'slug' => 'finance',
                'competences' => [
                    'Analyse financière',
                    'Comptabilité',
                    'Gestion de trésorerie',
                    'Planification financière et budgétisation',
                    'Connaissance des réglementations financières',
                    'Évaluation d\'investissement',
                    'Gestion des risques financiers',
                ],
            ],
            6 => [
                'name' => 'Construction',
                'slug' => 'construction',
                'competences' => [
                    'Gestion de projet de construction',
                    'Connaissance des matériaux de construction',
                    'Lecture et interprétation des plans et schémas',
                    'Sécurité sur les chantiers',
                    'Connaissance des réglementations de construction',
                    'Estimation des coûts de construction',
                    'Gestion d\'équipe sur chantier',
                ],
            ],
            7 => [
                'name' => 'Immobilier',
                'slug' => 'immobilier',
                'competences' => [
                    'Estimation de la valeur des biens',
                    'Connaissance du marché immobilier local',
                    'Techniques de négociation immobilière',
                    'Réglementation et droit immobilier',
                    'Gestion de portefeuille de biens',
                    'Marketing et promotion immobilière',
                    'Gestion locative et relation avec les locataires',
                ],
            ],
            8 => [
                'name' => 'Transport et logistique',
                'slug' => 'transport-et-logistique',
                'competences' => [
                    'Planification et optimisation des itinéraires',
                    'Gestion de flotte et entretien des véhicules',
                    'Connaissance des réglementations de transport',
                    'Gestion des stocks et entreposage',
                    'Suivi et optimisation de la chaîne d\'approvisionnement',
                    'Logistique inverse (retours et échanges)',
                    'Sécurité et conformité dans le transport',
                ],
            ],
            9 => [
                'name' => 'Éducation',
                'slug' => 'education',
                'competences' => [
                    'Pédagogie',
                    'Conception de programmes d\'études',
                    'Technologies éducatives',
                    'Gestion de classe',
                    'Évaluation des étudiants',
                    'Formation continue et développement professionnel',
                ],
            ],
        ];

        $a = [
            0 => [
                'name' => 'Entreprise',
                'slug' => 'ressource'
            ],
            1 => [
                'name' => 'Expert',
                'slug' => 'expert'
            ]
        ];

        $l = [
            0 => [
                'name' => 'English',
                'slug' => 'english',
                'code' => 'gb',
            ],
            1 => [
                'name' => 'Русский',
                'slug' => 'russian',
                'code' => 'rs',
            ],
            2 => [
                'name' => 'Français',
                'slug' => 'francais',
                'code' => 'fr',
            ],
            3 => [
                'name' => 'Español',
                'slug' => 'espagnole',
                'code' => 'es',
            ],
            4 => [
                'name' => 'Deutsch',
                'slug' => 'deutsch',
                'code' => 'de',
            ],
            5 => [
                'name' => 'عرب',
                'slug' => 'arabe',
                'code' => 'ar',
            ]
        ];

        $n = [
            "J'ai besoin d'une formation approfondie pour utiliser efficacement l'outil et dépend souvent de l'assistance d'autres personnes.",
            "Je peux accomplir des tâches simples, mais peut nécessiter une assistance ou une référence aux documentations pour des fonctionnalités plus avancées.",
            "Je suis capable de travailler de manière autonome, d'utiliser efficacement les fonctionnalités principales et de résoudre la plupart des problèmes courants liés à l'outil.",
            "J'ai une connaissance approfondie de toutes les fonctionnalités, peut résoudre des problèmes complexes et est en mesure de fournir un support technique à d'autres utilisateurs.",
            "Je possède une expertise approfondie, peut utiliser l'outil de manière créative pour résoudre des problèmes complexes et est considérée comme une référence ou une ressource clé dans l'utilisation de l'outil."
        ];

        $tp = [
            0 => [
                'name' => 'Freelance',
            ],
            1 => [
                'name' => 'Temps plein',
            ],
            2 => [
                'name' => 'Temps partiel',
            ],
            3 => [
                'name' => 'Stage',
            ],
            4 => [
                'name' => 'CDI',
            ],
            5 => [
                'name' => 'CDD',
            ],
        ];

        $job = [
            'Développeur mobile',
            'Développeur web',
            'Administrateur réseau',
            'Consultant SEO',
            'Graphiste',
            'Monteur vidéo',
            'Rédacteur web',
            'Community manager',
            'Assistant virtuel',
            'Traducteur',
            'Correcteur',
            'Développeur full stack',
        ];


        $jobdesc = [
            "Hello !

            On recherche un freelance pour automatiser la création de comptes Fruitz (application de rencontre) avec l'émulateur BlueStacks.
            
            L'objectif est d'avoir (assez rapidement) une application exécutable en local sur Windows. Nous pensons donc nécessaire de créer l'app avec plusieurs langages de codage (Python, Node, et C++)
            
            L'UI/UX devra être user-friendly, sans pour autant être jolie, nous recherchons l'efficacité avant tout. Egalement, il sera nécessaire de pouvoir faire plusieurs espaces utilisateurs, car nous avons plusieurs profils Fruitz différent à créer.
            
            Le principe est de cloner une instance BlueStacks qui servira de modèle pour les suivantes. On t'apportera plus de précision lors d'un call :)
            
            A très vite !",
            "Pour une plateforme de restitution d'un projet européen, notre association a fait le choix de l'outil YesWiki. Nous avons construit la majorité du site (arborescences, principales pages, structure des données, etc.) et cherchons désormais :
                - un prestataire (prestations 1 et 2) pour réaliser le webdesign du site (et la création d'éléments visuels de types pictogrammes),
                - un prestataire (prestations 3) pour réaliser l'intégration sous YesWiki.
                Il peut s'agir d'une équipe constituée ou de deux prestataires indépendants.",
            "- Prestation 1 : webdesign de la plateforme avec livraison des fichiers déclinés sur la base de 4 écrans types (livrables : design des interfaces en format vectoriel et ensemble des informations nécessaires pour l’intégrateur, cf. prestation 3)
            - Prestation 2 : déclinaison d'éléments d'illustration complémentaires, cohérents avec l'esthétique générale du site.
            - Prestation 3 : Intégration du design sur le gestionnaire de contenus YesWiki
            
            Dates de réalisations :
            - Date de livraison prestation 1 : 10/11/23
            - Date de livraison prestation 2 : 17/11/23
            - Date de livraison prestation 3 : 01/12/23
            
            Un cahier des charges détaillé et ses annexes est joint pour détailler nos attentes.
            
            Merci de nous transmettre vos devis détaillés (avec références, portfolio et éléments techniques) par email ou via la plateforme.",
            "Nous recherchons un freelance expert dev Wordpress/elementor/woo-commerce pour reprendre un site Wordpress (Elementor, Woo-commerce, 50 plugins, 5000 références produits, comptes clients, factures, admin fabricant différent de l'admin webmaster):",
            "Aujourd'hui, il semble périlleux de:
            - le mettre à jour (ou mettre à jour chaque plug-in)
            - Ré-upload la base de données produits avec des modifications de ces produits (en bulk) ou par exemple, ajout d'une deuxième et troisième photos pour l'ensemble des produits
            - Conserver des performances top (rapidité & stabilité) dans le temps avec ajout de plus de références et création de nombreux comptes clients
            - Mettre à jour le serveur selon une manoeuvre demandée par OVH, sans risquer de casser les plug-ins qui ne s'adapteraient pas à cete nouvelle version du serveur...",
            "Nous souhaitons donc le reprendre, sans repayer un site complet (celui ci nous a couté déjà 10k euros et il est impossible de remettre la moitié de ce budget pour la suite)...
            Cela signifie remplacer une partie des plugins par une fonctionnalité reprenant ces derniers, et ainsi assurer la maintenance possible et la rapidité et sécurité du site web dans le temps.",
            "Nous cherchons quelqu'un de disponible, qui comprendra vraiment le site, ses fonctionnalités, le projet et la sensibilité de ce site afin de tester sur un serveur bis un site copié (amélioré progressivement) puis migrer sans aucune instabilité le travail sur le serveur live afin de pouvoir améliorer ce site sans compromettre les ventes qui ont lieu chaque jour dessus, ni perdre de la data.",
            "Nous avons, à dispo une fois votre intérêt et expertise démontrés, un cahier des charges détaillé de toutes les fonctionnalités principales du site. Je serai aussi ravie de faire connaissance au tel ou en visio pour un tel projet, afin de nous assurer du fit.

            Pour info, la refonte est tout récente et le site en lui-même (design, usage, fonctionnalités) doivent rester intactes..",
        ];

        $formationsArray = [
            "Développement Web Full-Stack",
            "Marketing Digital Avancé",
            "Gestion de Projet Agile",
            "Conception Graphique et PAO",
            "Administration de Bases de Données",
            "Intelligence Artificielle et Machine Learning",
            "Cybersécurité et Protection des Données",
            "Gestion Financière pour Entrepreneurs",
            "Techniques Avancées de Vente",
            "Langues Étrangères pour le Business",
            "Leadership et Management d'Équipe",
            "Stratégies de Content Marketing",
            "Ingénierie Logicielle",
            "Design Thinking et Innovation",
            "SEO et Optimisation pour Moteurs de Recherche",
            "E-commerce et Vente en Ligne",
            "Développement Mobile (Android et iOS)",
            "RH et Gestion des Talents",
            "Communication Corporate et Relations Publiques",
            "Droit des Affaires pour Non-Juristes",
        ];

        $experiencesArray = [
            // IT - Développement
            "Développeur Web Full-Stack",
            "Ingénieur Logiciel Backend Java",
            "Architecte Cloud AWS",
            "Data Scientist en Machine Learning",
        
            // Marketing Digital
            "Chef de Projet SEO",
            "Spécialiste en Publicité Facebook Ads",
            "Content Manager pour Blog Tech",
            "Expert en Email Marketing",
        
            // Commercial
            "Responsable Commercial B2B",
            "Attaché Commercial Région Sud",
            "Négociateur en Vente de Solutions IT",
            "Gestionnaire de Comptes Clés",
        
            // Recrutement
            "Consultant en Recrutement Tech",
            "Talent Acquisition Manager",
            "Chasseur de Têtes pour Profils Rares",
            "Coordinateur de Recrutement RH",
        
            // RH - Administration
            "Gestionnaire RH et Paie",
            "Coordinateur de Formation Continue",
            "Responsable des Avantages Sociaux",
            "Spécialiste en Relations du Travail"
        ];

        $experiences = [];
        foreach ($experiencesArray as $key => $value) {
            $experience = new Experience();
            $startDate = $faker->dateTime();
            $experience
                ->setTitle($value)
                ->setStartDate($startDate)
                ->setEndDate($startDate->modify('+6 months'));

            $manager->persist($experience);
            $experiences[] = $experience;
        }

        $formations = [];
        foreach ($formationsArray as $key => $value) {
            $formation = new Formation();
            $startDate = $faker->dateTime();
            $formation
                ->setTitle($value)
                ->setStartDate($startDate)
                ->setEndDate($startDate->modify('+3 months'));

            $manager->persist($formation);
            $formations[] = $formation;
        }

        $typePosts = [];
        foreach ($tp as $key => $value) {
            $typePost = new PostingType();
            $typePost
                ->setName($value['name'])
                ->setSlug($this->sluggerInterface->slug($value['name']));
            $manager->persist($typePost);
            $typePosts[] = $typePost;
        }

        $sectors = [];
        $technicalskills = [];
        foreach ($s as $key => $value) {
            $sector = new Sector();
            $sector
                ->setName($value['name'])
                ->setSlug($value['slug']);

                foreach ($value['competences'] as $competence) {
                    $skill = new TechnicalSkill();
                    $skill
                        ->setName($competence)
                        ->setSlug($this->sluggerInterface->slug($competence));

                    $manager->persist($skill);
                    $technicalskills[] = $skill;
                }

            $manager->persist($sector);
            $sectors[] = $sector;
        }

        $accounts = [];
        foreach ($a as $key => $value) {
            $account = new Account();
            $account
                ->setName($value['name'])
                ->setSlug($value['slug']);
            $manager->persist($account);
            $accounts[] = $account;
        }

        $langs = [];
        foreach ($l as $key => $value) {
            $language = new Language();
            $language
                ->setName($value['name'])
                ->setSlug($value['slug'])
                ->setCode($value['code']);
            $manager->persist($language);
            $langs[] = $language;
        }

        $languages = [];
        for($i=0; $i<50; $i++){
            $la = new SpokenLanguage();
            $ll = $faker->randomElement($langs);
            $la
            ->setLevel($faker->numberBetween(1, 5))
            ->setLanguage($ll)
            ->setTitle($ll->getName())
            ->setCode($ll->getCode())
            ;
            $manager-> persist($la);
            $languages[] = $la;
        }

        $views = [];

        for ($i = 0; $i < 20; $i++) {
            $ip = rand(1, 254) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
            $view = new IdentityViews();
            $view->setIpAdress($ip);
            $manager->persist($view);

            $views[] = $view;
        }

        $postingViews = [];

        for ($i = 0; $i < 20; $i++) {
            $ip = rand(1, 254) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
            $view = new PostingViews();
            $view->setIpAdress($ip);
            $manager->persist($view);

            $postingViews[] = $view;
        }

        $identities = [];
        $experts = [];

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $plainPassword = '123456789';
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, $plainPassword));

            $identity = new Identity();
            $identity->setUser($user)
                ->setUsername($faker->uuid)
                ->setBio($faker->paragraph(3))
                ->setFileName($faker->randomElement($images))
                ->setAccount($accounts[1])
                ->setCreatedAt(new DateTime())
                ->addLanguage($faker->randomElement($languages))
                ->addLanguage($faker->randomElement($languages))
                ->addTechnicalSkill($faker->randomElement($technicalskills))
                ->addTechnicalSkill($faker->randomElement($technicalskills))
                ->addExperience($faker->randomElement($experiences))
                ->addExperience($faker->randomElement($experiences))
                ->addFormation($faker->randomElement($formations))
                ->addFormation($faker->randomElement($formations))
                ->addFormation($faker->randomElement($formations))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->addView($faker->randomElement($views))
                ->setPhone("O340268554");

            $expert = new Expert();
            $expert
                ->setIdentity($identity)
                ->setTitle($faker->randomElement($job))
                ->setYears($faker->randomElement(['SM', 'MD', 'LG', 'XL']))
                ->setCountry($faker->countryCode())
                ->setMainSkills($faker->paragraph(4))
                ->addSector($faker->randomElement($sectors))
                ->setAspiration($faker->paragraph(4))
                ->setPreference($faker->paragraph(4))
                ->setWebsite('https://olona-talents.com');

            

            $manager->persist($expert);
            $manager->persist($user);
            $manager->persist($identity);

            $identities[] = $identity;
            $experts[] = $expert;
        }

        $companies = [];

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $plainPassword = '123456789';
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, $plainPassword));

            $identity = new Identity();
            $identity->setUser($user)
                ->setUsername($faker->uuid)
                ->setBio($faker->paragraph(3))
                ->setFileName($faker->randomElement($images))
                ->setAccount($accounts[0])
                ->setCreatedAt($faker->dateTime)
                ->setPhone("0345466353");

            $company = new Company();
            $company
                ->setIdentity($identity)
                ->setName($faker->company)
                ->setSize($faker->randomElement(['XS', 'SM', 'MD', 'LG', 'XL']))
                ->setDescription($faker->paragraph(3))
                ->setEmail($user->getEmail())
                ->setPhone($identity->getPhone());

            $manager->persist($company);
            $manager->persist($user);
            $manager->persist($identity);

            $companies[] = $company;
        }

        $user = new User();
        $plainPassword = '123456789';
        $user->setLastName('Client')
            ->setFirstName('Olona')
            ->setEmail('client@olona-talents.com')
            ->setPassword($this->encoder->hashPassword($user, $plainPassword));

        $identity = new Identity();
        $identity->setUser($user)
            ->setUsername($faker->uuid)
            ->setBio($faker->paragraph(3))
            ->setFileName($faker->randomElement($images))
            ->setAccount($accounts[0])
            ->setCreatedAt(new DateTime())
            ->setPhone("0340000000");

        $company = new Company();
        $company
            ->setIdentity($identity)
            ->setName('Olona Prod')
            ->setSize($faker->randomElement(['XS', 'SM', 'MD', 'LG', 'XL']))
            ->setDescription($faker->paragraph(3))
            ->setCountry($faker->countryCode())
            ->setEmail($user->getEmail())
            ->addSector($faker->randomElement($sectors))
            ->addSector($faker->randomElement($sectors))
            ->setPhone($identity->getPhone());

        $manager->persist($company);
        $manager->persist($user);
        $manager->persist($identity);

        $user = new User();
        $plainPassword = '123456789';
        $user->setLastName('Expert')
            ->setFirstName('Olona')
            ->setEmail('expert@olona-talents.com')
            ->setPassword($this->encoder->hashPassword($user, $plainPassword));

        $identity = new Identity();
        $identity->setUser($user)
            ->setUsername($faker->uuid)
            ->setBio($faker->paragraph(3))
            ->setFileName($faker->randomElement($images))
            ->setAccount($accounts[1])
            ->setCreatedAt(new DateTime())
            ->addLanguage($faker->randomElement($languages))
            ->addLanguage($faker->randomElement($languages))
            ->setPhone("0340000000");

        $expert = new Expert();
        $expert
            ->setIdentity($identity)
            ->setTitle('Chasseur de talent')
            ->setYears($faker->randomElement(['SM', 'MD', 'LG', 'XL']))
            ->setCountry($faker->countryCode())
            ->setMainSkills($faker->paragraph(4))
            ->setAspiration($faker->paragraph(4))
            ->setPreference($faker->paragraph(4))
            ->setWebsite('https://olona-talents.com')
            ->addSector($faker->randomElement($sectors))
            ->addSector($faker->randomElement($sectors));

        $manager->persist($expert);
        $manager->persist($user);
        $manager->persist($identity);

        $postings = [];

        for ($i = 0; $i < 100; $i++) {
            $posting = new Posting();
            $posting
                ->setTitle($faker->randomElement($job))
                ->setTarif($faker->numberBetween(200, 600))
                ->setDescription($faker->randomElement($jobdesc))
                ->setCreatedAt($faker->dateTime())
                ->setNumber($faker->numberBetween(1, 5))
                ->setIsValid($faker->boolean())
                ->setJobId(new Uuid(Uuid::v1()))
                ->setPlannedDate($faker->dateTime())
                ->setCompany($faker->randomElement($companies))
                ->setSector($faker->randomElement($sectors))
                ->addView($faker->randomElement($postingViews))
                ->addView($faker->randomElement($postingViews))
                ->addView($faker->randomElement($postingViews))
                ->addView($faker->randomElement($postingViews))
                ->addView($faker->randomElement($postingViews))
                ->addView($faker->randomElement($postingViews))
                ->addView($faker->randomElement($postingViews))
                ->addTechnicalSkill($faker->randomElement($technicalskills))
                ->addTechnicalSkill($faker->randomElement($technicalskills))
                ->addTechnicalSkill($faker->randomElement($technicalskills))
                ->addTechnicalSkill($faker->randomElement($technicalskills))
                ->setStatus(Posting::STATUS_PUBLISHED)
                ->addLanguage($faker->randomElement($langs))
                ->addLanguage($faker->randomElement($langs))
            ;

            $manager->persist($posting);

            $postings[] = $posting;
        }

        for ($i = 0; $i < 20; $i++) {
            $application = new Application();
            $application
                ->setPosting($faker->randomElement($postings))
                ->setIdentity($faker->randomElement($identities))
                ->setMotivation($faker->paragraph(3))
                ->setCreatedAt($faker->dateTime());
                $application->setStatus(Application::STATUS_PENDING);

            $manager->persist($application);
        }

        $manager->flush();
    }
}
