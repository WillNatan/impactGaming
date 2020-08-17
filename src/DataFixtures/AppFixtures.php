<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Events;
use App\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * L'encoder de mots de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface  $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();

        $user = new User();

        $hash = $this->encoder->encodePassword($user, "password");

        $user->setEmail('email@email.fr')
             ->setPassword($hash)
             ->setFirstName('John')
             ->setLastName('Doe')
             ->setCompany('CompanyName')
             ->setRoles(['ROLE_BUSINESS']);

             $manager->persist($user);


        for($a = 0; $a < 15 ; $a++){
            $category = new EventCategory();
            $category->setCategoryName($faker->jobTitle);
            $manager->persist($category);
            for($c = 0; $c < mt_rand(1,100); $c ++)
            {
                $event = new Events();
                $name = $faker->company;
                $replaceSpace = str_replace(" ", "-",$name);
                $replaceComma = str_replace(',','',$replaceSpace);
                $event
                    ->setName($name)
                    ->setWebsiteLink($faker->url)
                    ->setPlace($faker->country)
                    ->setPrice(mt_rand(30,1500))
                    ->setLaunchDate($faker->dateTimeBetween($startDate = '+1 day', $endDate = '+2 years', $timezone = null))
                    ->setStopDate($faker->dateTimeBetween($startDate = '+2 years', $endDate = '+3 years', $timezone = null))
                    ->setShortDesc($faker->paragraph($nbSentences = 10, $variableNbSentences = true))
                    ->setLongDesc($faker->paragraph($nbSentences = 50, $variableNbSentences = true))
                    ->setSlug($replaceComma)
                    ->setUser($user)
                    ->setAddress($faker->address)
                    ->setTicketNumber(mt_rand(0,1000))
                    ->setCategory($category);
                $manager->persist($event);
                      
            }
           
            
        }
        
    

    
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
