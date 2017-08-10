<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use FOS\RestBundle\FOSRestBundle;
use Nelmio\CorsBundle\NelmioCorsBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use AppBundle\AppBundle;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle,
            new SensioFrameworkExtraBundle,
            new AppBundle,
            new FOSRestBundle,
            new NelmioCorsBundle,
            new DoctrineBundle,
            new JMSSerializerBundle,
        ];

        if (in_array($this->getEnvironment(), ['test'])) {
            $bundles[] = new DoctrineFixturesBundle;
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
