<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $manager;
    private $passwordEncoder;
    private $cRepo;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, CustomerRepository $cRepo)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->cRepo = $cRepo;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadUsersAndCustomers();
        $this->loadProducts();

        $manager->flush();
    }

    public function loadUsersAndCustomers()
    {
        $faker = Factory::create('fr_FR');
        $providers = ["sfr", "orange", "bouygues", "free"];

        foreach ($providers as $provider) {
            $customer = new Customer();
            $customer->setUsername($provider)
                ->setPassword($this->passwordEncoder->encodePassword($customer, $provider))
                ->setEmail($provider . "@" . $provider . ".com");

            $this->manager->persist($customer);
        }

        $customer = new Customer();
        $customer->setUsername("orange")
            ->setPassword($this->passwordEncoder->encodePassword($customer, "orange"))
            ->setEmail("orange@gmail.com");

        $this->manager->persist($customer);
        $this->manager->flush();

        $customers = $this->cRepo->findAll();
        foreach ($customers as $customer) {
            for ($i = 0; $i < 5; $i++) {
                $user = new User();
                $user->setname($faker->name)
                    ->setfirstName($faker->firstName)
                    ->setCustomer($customer)
                    ->setEmail($faker->email);
                $this->manager->persist($user);
            }
        }
    }

    public function loadProducts()
    {
        for ($i = 0; $i < 20; $i++) {

            $processor_names = ["A14 Bionic", "A13 Bionic", "Snapdragon 888", "Kirin 9000", "Exynos 2100", "Dimensity 1000+", "Snapdragon 870", "Kirin 9000E"];
            $colors = ["Argent", "Argent", "Blanc", "Bleu", "Bronze", "Gris", "Jaune", "Noir", "Or", "Orange", "Pourpre", "Rose", "Rouge", "Vert", "Violet", "Autres"];
            $ram_memories = ["12 Go", "8 Go", "6 Go", "4 Go", "3 Go", "2 Go"];
            $shortnames_samsung = ["Galaxy S20", "Galaxy S10", "Galaxy Note 10", "Galaxy S9", "Galaxy A12", "Galaxy A10"];
            $shortnames_apple = ["SE", "11", "Xr", "Xs", "8", "10", "9", "X"];
            $shortnames_sony = ["Z5", "XZ", "10 II", "XZ1", "XZ3", "10"];
            $shortnames_xiaomi = ["Mi 10", "Mi 10 Pro", "Mi 9", "Redmi Note 7", "Mi 10T Lite"];
            $shortnames_huawei = ["P30", "P Smart 2019", "P20 Lite", "Mate 20 Lite", "P40 Lite", "P20", "P20 Pro", "Mate 20 Pro"];

            $samsung_denomination = "Samsung ".array_rand(array_flip($shortnames_samsung));
            $apple_denomination = "Apple Iphone ".array_rand(array_flip($shortnames_apple));
            $sony_denomination = "Sony Xperia ".array_rand(array_flip($shortnames_sony));
            $xiaomi_denomination = "Xiaomi ".array_rand(array_flip($shortnames_xiaomi));
            $huawei_denomination = "Huawei ".array_rand(array_flip($shortnames_huawei));

            $arrayDenomination = array($samsung_denomination, $apple_denomination, $sony_denomination, $xiaomi_denomination, $huawei_denomination);
            $processor_name = array_rand(array_flip($processor_names));
            $color = array_rand(array_flip($colors));
            $ram = array_rand(array_flip($ram_memories));
            $denomination = array_rand(array_flip($arrayDenomination)) . " " . $color . " " . $ram;
            $manufacturerArr = explode(' ', trim($denomination));
            $manufacturer = $manufacturerArr[0];

            $product = new Product();
            $product->setDenomination($denomination)
                ->setManufacturer($manufacturer)
                ->setDenomination($denomination)
                ->setColor($color)
                ->setProcessorName($processor_name)
                ->setRamMemory($ram);

            $this->manager->persist($product);
        }

        $this->manager->flush();
    }
}
