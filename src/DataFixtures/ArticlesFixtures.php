<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Creation aléatoire de 3 catégories
        for ($i=0; $i <= 3; $i++) { 
            $category= new Category;
            $category->setTitle($faker->sentence(3));
            $manager->persist($category);

            //Création aléatoire de quelque articles pour chaque catégorie
            for ($j=1; $j <= mt_rand(4,6) ; $j++) { 
                $article=new Article;
                $content = '<p>'. join('</p><p>', $faker->paragraphs(5)) . '</p>';
                $article->setTitle($faker->sentence())
                ->setContent($content)
                ->setImage("http://picsum.photos/250/150")
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setCategory($category);
                $manager->persist($article);

                //Chaque article a quelque commentaires
                for ($k=0; $k < mt_rand(5,10) ; $k++) { 
                    $comment = new Comment;
                    $content = '<p>'. join('</p><p>', $faker->paragraphs(5)) . '</p>';
                    //$now = new DateTime();
                    //$interval = $now->diff($article->getCreatedAt());
                    //$days = $interval->days;
                    $days = (new DateTime())->diff($article->getCreatedAt())->days;
                    $comment->setAuthor($faker->name)
                    ->setContent($content)
                    ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
                    ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
