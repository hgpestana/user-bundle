<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'hgpestana.user.authenticator.token' shared service.

return $this->services['hgpestana.user.authenticator.token'] = new \HGPestana\UserBundle\Security\Core\Authentication\ApiTokenAuthenticator(${($_ = isset($this->services['hgpestana.user.repository.token']) ? $this->services['hgpestana.user.repository.token'] : $this->load('getHgpestana_User_Repository_TokenService.php')) && false ?: '_'});
