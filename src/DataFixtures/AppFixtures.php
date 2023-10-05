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
use App\Entity\Language;
use Symfony\Component\Uid\Uuid;
use App\Entity\Identity\SpokenLanguage;
use App\Entity\Type\PostingType;
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
    ){
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $allFiles = scandir($this->parameterBag->get('kernel.project_dir').'/public/uploads/experts/');
        $images = array_diff($allFiles, array('.', '..'));

        $s = [
            0 => [
                'name' => 'IT - Devéloppement',
                'slug' => 'it-developpement'
            ],
            1 => [
                'name' => 'Marketing Digital',
                'slug' => 'marketing-digital'
            ],
            2 => [
                'name' => 'Commercial',
                'slug' => 'commercial'
            ],
            3 => [
                'name' => 'Recrutement',
                'slug' => 'recrutement'
            ],
            4 => [
                'name' => 'RH - Administration',
                'slug' => 'rh-administration'
            ],
            5 => [
                'name' => 'Finance',
                'slug' => 'finance'
            ],
            6 => [
                'name' => 'Construction',
                'slug' => 'construction'
            ],
            7 => [
                'name' => 'Immobilier',
                'slug' => 'immobilier'
            ],
            8 => [
                'name' => 'Transport et logistique',
                'slug' => 'transport-et-logistique'
            ],
            9 => [
                'name' => 'Éducation',
                'slug' => 'education'
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
            ],
            2 => [
                'name' => 'Manager',
                'slug' => 'manager'
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

        $lang = [
            "BASIC",
            "CONVERSATIONNAL",
            "FLUENT",
            "NATIVE",
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

        // $sp = [
        //     0 => [
        //         'name' => 'Horaire flexible',
        //     ],
        //     1 => [
        //         'name' => 'Travail en journée',
        //     ],
        //     2 => [
        //         'name' => 'Temps partiel',
        //     ],
        //     3 => [
        //         'name' => 'CDI',
        //     ],
        // ];

        $typePosts = [];
        foreach($tp as $key => $value){
            $typePost = new PostingType();
            $typePost
                ->setName($value['name'])
                ->setSlug($this->sluggerInterface->slug($value['name']))
                ;
            $manager-> persist($typePost);
            $typePosts[] = $typePost;
        }

        $sectors = [];
        foreach($s as $key => $value){
            $sector = new Sector();
            $sector
                ->setName($value['name'])
                ->setSlug($value['slug'])
                ;
            $manager-> persist($sector);
            $sectors[] = $sector;
        }

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
        
        $accounts = [];
        foreach($a as $key => $value){
            $account = new Account();
            $account
                ->setName($value['name'])
                ->setSlug($value['slug'])
            ;
            $manager-> persist($account);
            $accounts[] = $account;
        }

        $langs = [];
        foreach($l as $key => $value){
            $language = new Language();
            $language
            ->setName($value['name'])
            ->setSlug($value['slug'])
            ->setCode($value['code'])
            ;
            $manager-> persist($language);
            $langs[] = $language;
        }

        $languages = [];
        for($i=0; $i<50; $i++){
            $la = new SpokenLanguage();
            $ll = $faker->randomElement($langs);
            $la
            ->setLevel($faker->randomElement($lang))
            ->setLanguage($ll)
            ->setTitle($ll->getName())
            ->setCode($ll->getCode())
            ;
            $manager-> persist($la);
            $languages[] = $la;
        }

        $identities = [];
        $experts = [];

        for($i=0; $i<20; $i++){
            $user = new User();
            $plainPassword = '123456789';
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, $plainPassword))
            ;

            $identity = new Identity();
            $identity->setUser($user)
                ->setUsername($faker->uuid)
                ->setBio($faker->paragraph(3))
                ->setFileName($faker->randomElement($images))
                ->setAccount($accounts[1])
                ->setCreatedAt(new DateTime())
                // ->setTarif($faker->numberBetween(90, 500))
                // ->setSector($faker->randomElement($sectors))
                ->addLanguage($faker->randomElement($languages))
                ->addLanguage($faker->randomElement($languages))
                // ->addAicore($faker->randomElement($aiCores))
                // ->addAicore($faker->randomElement($aiCores))
                // ->addAicore($faker->randomElement($aiCores))
                ->setPhone("O340268554");

            $expert = new Expert();
            $expert
                ->setIdentity($identity)
                ->setTitle($faker->randomElement($job))
                ->setYears($faker->randomElement(['SM', 'MD', 'LG', 'XL']))
                ->setCountry($faker->countryCode())
                ->setMainSkills($faker->paragraph(4))
                ->setAspiration($faker->paragraph(4))
                ->setPreference($faker->paragraph(4))
                ->setWebsite('https://olona-talents.com')
            ;
    
            $manager->persist($expert);
            $manager->persist($user);
            $manager->persist($identity);

            $identities[] = $identity;
            $experts[] = $expert;
        }

        $companies = [];

        for($i=0; $i<10; $i++){
            $user = new User();
            $plainPassword = '123456789';
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, $plainPassword))
                ;

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
                ->setPhone($identity->getPhone())
            ;

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
            ->setPassword($this->encoder->hashPassword($user, $plainPassword))
            ;

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
            ->setEmail($user->getEmail())
            ->setPhone($identity->getPhone())
        ;

        $manager->persist($company);
        $manager->persist($user);
        $manager->persist($identity);

        $user = new User();
        $plainPassword = '123456789';
        $user->setLastName('Expert')
            ->setFirstName('Olona')
            ->setEmail('expert@olona-talents.com')
            ->setPassword($this->encoder->hashPassword($user, $plainPassword))
        ;

        $identity = new Identity();
        $identity->setUser($user)
            ->setUsername($faker->uuid)
            ->setBio($faker->paragraph(3))
            ->setFileName($faker->randomElement($images))
            ->setAccount($accounts[1])
            ->setCreatedAt(new DateTime())
            // ->setTarif($faker->numberBetween(90, 500))
            // ->setSector($faker->randomElement($sectors))
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
        ;

        $manager->persist($expert);
        $manager->persist($user);
        $manager->persist($identity);

        $postings = [];

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

        for($i=0; $i<20; $i++){
            $posting = new Posting();
            $posting
                ->setTitle($faker->randomElement($job))
                // ->addSector($faker->randomElement($sectors))
                ->setTarif($faker->numberBetween(200, 600))
                ->setDescription($faker->randomElement($jobdesc))
                ->setCreatedAt($faker->dateTime())
                ->setNumber($faker->numberBetween(1, 5))
                ->setIsValid($faker->boolean())
                ->setJobId(new Uuid(Uuid::v1()))
                ->setPlannedDate($faker->dateTime())
                ->setCompany($faker->randomElement($companies))
                // ->addSkill($faker->randomElement($aiCores))
                // ->addSkill($faker->randomElement($aiCores))
                ->setSector($faker->randomElement($sectors))
                // ->addSchedulePosting($faker->randomElement($schedulePosts))
                // ->addApplication($faker->randomElement($typePosts))
            ;

            $manager->persist($posting);

            $postings[] = $posting;
        }      

        for($i=0; $i<20; $i++){
            $application = new Application();
            $application
                ->setPosting($faker->randomElement($postings))
                ->setIdentity($faker->randomElement($identities))
                ->setMotivation($faker->paragraph(3))
                ->setCreatedAt($faker->dateTime())
            ;

            $manager->persist($application);
        }

        $manager->flush();
    }
}
