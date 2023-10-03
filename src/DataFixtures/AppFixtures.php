<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Sector;
use App\Entity\Account;
use App\Entity\Company;
use App\Entity\Posting;
use App\Entity\Identity;
use App\Entity\Language;
use Symfony\Component\Uid\Uuid;
use App\Entity\Identity\SpokenLanguage;
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
        // WooCommerce $wooCommerce
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
                'name' => 'CDI',
            ],
        ];

        $sp = [
            0 => [
                'name' => 'Horaire flexible',
            ],
            1 => [
                'name' => 'Travail en journée',
            ],
            2 => [
                'name' => 'Temps partiel',
            ],
            3 => [
                'name' => 'CDI',
            ],
        ];

        // $typePosts = [];
        // foreach($tp as $key => $value){
        //     $typePost = new TypePosting();
        //     $typePost
        //         ->setName($value['name'])
        //         ->setSlug($this->sluggerInterface->slug($value['name']))
        //         ;
        //     $manager-> persist($typePost);
        //     $typePosts[] = $typePost;
        // }

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

        for($i=0; $i<20; $i++){
            $user = new User();
            $plainPassword = '000000';
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, $plainPassword))
                // ->setLocale(($faker->countryCode))
            ;

            $identity = new Identity();
            $identity->setUser($user)
                // ->setFirstName($user->getFirstName())
                // ->setLastName($user->getLastName())
                ->setUsername($faker->uuid)
                ->setBio($faker->paragraph(3))
                ->setFileName($faker->randomElement($images))
                ->setAccount($accounts[1])
                // ->setCountry($user->getLocale())
                ->setCreatedAt($faker->dateTime)
                // ->setTarif($faker->numberBetween(90, 500))
                // ->setSector($faker->randomElement($sectors))
                ->addLanguage($faker->randomElement($languages))
                ->addLanguage($faker->randomElement($languages))
                ->addLanguage($faker->randomElement($languages))
                // ->addAicore($faker->randomElement($aiCores))
                // ->addAicore($faker->randomElement($aiCores))
                // ->addAicore($faker->randomElement($aiCores))
                ->setPhone("O340268554");

            $manager->persist($user);
            $manager->persist($identity);

            $identities[] = $identity;
        }
        $companies = [];

        for($i=0; $i<10; $i++){
            $user = new User();
            $plainPassword = '000000';
            $user->setLastName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, $plainPassword))
                // ->setLocale(($faker->countryCode));
                ;

            $identity = new Identity();
            $identity->setUser($user)
                // ->setFirstName($user->getFirstName())
                // ->setLastName($user->getLastName())
                ->setUsername($faker->uuid)
                ->setBio($faker->paragraph(3))
                ->setFileName($faker->randomElement($images))
                ->setAccount($accounts[0])
                // ->setCountry($user->getLocale())
                ->setCreatedAt($faker->dateTime)
                ->setPhone("0345466353");

            $company = new Company();
            $company
                ->setIdentity($identity)
                ->setName($faker->company)
                ->setSize($faker->randomElement(['XS', 'SM', 'MD', 'LG', 'XL']))
                ->setDescription($faker->paragraph(3))
                // ->setCountry($user->getLocale())
                ->setEmail($user->getEmail())
                ->setPhone($identity->getPhone())
            ;

            $manager->persist($company);
            $manager->persist($user);
            $manager->persist($identity);

            $companies[] = $company;
        }

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

        for($i=0; $i<20; $i++){
            $posting = new Posting();
            $posting
                ->setTitle($faker->randomElement($job))
                // ->addSector($faker->randomElement($sectors))
                ->setTarif($faker->numberBetween(200, 600))
                ->setDescription($faker->paragraph(3))
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
                // ->setTypePosting($faker->randomElement($typePosts))
            ;

            $manager->persist($posting);

            $postings[] = $posting;
        }

        $manager->flush();
    }
}
