<?php

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle;
use FOS\RestBundle\FOSRestBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Hautelook\AliceBundle\HautelookAliceBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Liip\FunctionalTestBundle\LiipFunctionalTestBundle;
use Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle;
use Nelmio\ApiDocBundle\NelmioApiDocBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use HGPestana\UserBundle\HGPestanaUserBundle;


class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [];
        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $frameworkBundles = [
                new FrameworkBundle(),
                new DebugBundle(),
                new TwigBundle(),
                new SecurityBundle(),
            ];

            $utilityBundles = [
                new DoctrineBundle(),
                new FOSRestBundle(),
                new SensioFrameworkExtraBundle(),
                new NelmioApiDocBundle(),
                new JMSSerializerBundle(),
            ];

            $testBundles = [
                new LiipFunctionalTestBundle(),
                new NelmioAliceBundle(),
                new FidryAliceDataFixturesBundle(),
                new HautelookAliceBundle(),
                new DoctrineFixturesBundle(),
            ];

            $hgpestanaBundles = [
                new HGPestanaUserBundle(),
            ];

            $bundles = array_merge(
                $bundles,
                $frameworkBundles,
                $utilityBundles,
                $testBundles,
                $hgpestanaBundles
            );
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        try {
            $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
        } catch (Exception $e) {
            //TODO: Resolve this
        }
    }
}