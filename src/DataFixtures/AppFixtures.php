<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * Le Manager "ObjectManager" est un objet qui sait comment manipuler en BDD
     * nos entités. (Insert, Update, Delete)
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        # Création des catégories (fluent setters)
        $politique = new Category();
        $politique->setName('Politique')->setAlias('politique');

        $economie = new Category();
        $economie->setName('Economie')->setAlias('economie');

        $social = new Category();
        $social->setName('Social')->setAlias('social');

        $sante = new Category();
        $sante->setName('Santé')->setAlias('sante');

        $culture = new Category();
        $culture->setName('Culture')->setAlias('culture');

        $loisirs = new Category();
        $loisirs->setName('Loisirs')->setAlias('loisirs');

        $sports = new Category();
        $sports->setName('Sports')->setAlias('sports');

        # Je souhaite sauvegarder en BDD ma catégorie politique, etc...
        $manager->persist($politique);
        $manager->persist($economie);
        $manager->persist($social);
        $manager->persist($sante);
        $manager->persist($culture);
        $manager->persist($loisirs);
        $manager->persist($sports);

        # J'execute ma requète
        $manager->flush();

        # Création d'un User
        $user = new User();
        $user->setFirstname('Hugo')
            ->setLastname('LIEGEARD')
            ->setEmail('hugo@actu.news')
            ->setPassword('test')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTime());

        # Sauvegarde dans la BDD
        $manager->persist($user);
        $manager->flush();

        # Création des Articles | Politique
        for ($i = 0; $i < 3; $i++) {

            $post = new Post();
            $post->setTitle('Lorem ipsum dolor ' . $i)
                ->setAlias('lorem-ipsum-dolor-' . $i)
                ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore nostrum odit quaerat quasi qui quidem sunt voluptatem! Consectetur consequatur consequuntur expedita id iure labore magnam maiores necessitatibus nihil nostrum.</p>')
                ->setImage('https://via.placeholder.com/500')
                ->setCreatedAt(new \DateTime())
                ->setCategory($politique)
                ->setUser($user);

            $manager->persist($post);
            $manager->flush();
        } # endfor

        # Création des Articles | Economie
        for ($i = 3; $i < 7; $i++) {

            $post = new Post();
            $post->setTitle('Lorem ipsum dolor ' . $i)
                ->setAlias('lorem-ipsum-dolor-' . $i)
                ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore nostrum odit quaerat quasi qui quidem sunt voluptatem! Consectetur consequatur consequuntur expedita id iure labore magnam maiores necessitatibus nihil nostrum.</p>')
                ->setImage('https://via.placeholder.com/500')
                ->setCreatedAt(new \DateTime())
                ->setCategory($economie)
                ->setUser($user);

            $manager->persist($post);
            $manager->flush();
        } # endfor

        # Création des Articles | Culture
        for ($i = 7 ; $i < 11; $i++) {

            $post = new Post();
            $post->setTitle('Lorem ipsum dolor ' . $i)
                ->setAlias('lorem-ipsum-dolor-' . $i)
                ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore nostrum odit quaerat quasi qui quidem sunt voluptatem! Consectetur consequatur consequuntur expedita id iure labore magnam maiores necessitatibus nihil nostrum.</p>')
                ->setImage('https://via.placeholder.com/500')
                ->setCreatedAt(new \DateTime())
                ->setCategory($culture)
                ->setUser($user);

            $manager->persist($post);
            $manager->flush();
        } # endfor

        # Création des Articles | Sports
        for ($i = 11 ; $i < 14; $i++) {

            $post = new Post();
            $post->setTitle('Lorem ipsum dolor ' . $i)
                ->setAlias('lorem-ipsum-dolor-' . $i)
                ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore nostrum odit quaerat quasi qui quidem sunt voluptatem! Consectetur consequatur consequuntur expedita id iure labore magnam maiores necessitatibus nihil nostrum.</p>')
                ->setImage('https://via.placeholder.com/500')
                ->setCreatedAt(new \DateTime())
                ->setCategory($sports)
                ->setUser($user);

            $manager->persist($post);
            $manager->flush();
        } # endfor
    }
}
