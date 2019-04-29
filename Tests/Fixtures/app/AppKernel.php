<?php
/**
 * Created by PhpStorm.
 * User: beyerz
 * Date: 29/10/2018
 * Time: 18:44
 */

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use FOS\RestBundle\FOSRestBundle;
use FOS\UserBundle\FOSUserBundle;
use Hautelook\AliceBundle\HautelookAliceBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Liip\FunctionalTestBundle\LiipFunctionalTestBundle;
use Nelmio\ApiDocBundle\NelmioApiDocBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use VDRoom\GeoBundle\VDRoomGeoBundle;
use VDRoom\OrganizationBundle\VDRoomOrganizationBundle;
use VDRoom\PropertyBundle\VDRoomPropertyBundle;
use VDRoom\SiteBundle\VDRoomSiteBundle;
use VDRoom\UserBundle\VDRoomUserBundle;

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

            $utilityBundles =  [
                new DoctrineBundle(),
                new FOSUserBundle(),
                new FOSRestBundle(),
                new SensioFrameworkExtraBundle(),
                new NelmioApiDocBundle(),
            ];

            $testBundles = [
                new LiipFunctionalTestBundle(),
                new HautelookAliceBundle()
            ];

            $bundles = array_merge(
                $bundles,
                $frameworkBundles,
                $utilityBundles,
                $testBundles,
            );
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}