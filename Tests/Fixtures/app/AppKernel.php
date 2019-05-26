<?php
/** @noinspection PhpUndefinedClassInspection */


use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use FOS\RestBundle\FOSRestBundle;
use FOS\UserBundle\FOSUserBundle;
use Hautelook\AliceBundle\HautelookAliceBundle;
use Liip\FunctionalTestBundle\LiipFunctionalTestBundle;
use Nelmio\ApiDocBundle\NelmioApiDocBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;


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
                new FOSUserBundle(),
                new FOSRestBundle(),
                new SensioFrameworkExtraBundle(),
                new NelmioApiDocBundle(),
            ];

            $testBundles = [
                new LiipFunctionalTestBundle(),
                new HautelookAliceBundle(),
            ];

            $bundles = array_merge(
                $bundles,
                $frameworkBundles,
                $utilityBundles,
                $testBundles
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