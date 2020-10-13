<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Photo;
use App\Entity\PhotoGallery;
use App\Entity\Tag;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = Yaml::parseFile(__DIR__.'/fixtures.yml');

        $categories = array_map(function($object) {
            return $object['category'];
        }, $data);

        $categories = array_unique($categories);

        $tags = array_map(function($object) {
            return $object['tag'];
        }, $data);


        // Flatten array of arrays : https://stackoverflow.com/questions/1319903/how-to-flatten-a-multidimensional-array
        $tags = array_unique(call_user_func_array('array_merge', $tags));

        //        dump($categories);
//        dump($tags);
        $storedCategories = [];
        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $storedCategories[$categoryName] = $category;
        }

        $storedTags = [];
        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
            $storedTags[$tagName] = $tag;
        }

//        dump($storedTags);
//        dump($storedCategories);

        foreach ($data as $advertData) {
            $advert = new Advert();
            $advert->setCategory($storedCategories[$advertData['category']])
                ->setCreationDate( DateTime::createFromFormat('Y-m-d', $advertData['creationDate']))
                ->setDescription($advertData['description'])
                ->setPrice($advertData['price'])
                ->setTitle($advertData['title'])
                ->setYear(DateTime::createFromFormat('Y',$advertData['year']));

            foreach ($advertData['tag'] as $advertDataTag) {
                $advert->addTag($storedTags[$advertDataTag]);
            }

            $gal = new PhotoGallery();
            $manager->persist($gal);
            foreach ($advertData['photos'] as $photoLink){
                $photo = new Photo();
                $photo->setUrl($photoLink);
                $photo->setGallery($gal);
                $manager->persist($photo);
            }

            $advert->setGallery($gal);
            $manager->persist($advert);

        }

        $manager->flush();


    }
}
