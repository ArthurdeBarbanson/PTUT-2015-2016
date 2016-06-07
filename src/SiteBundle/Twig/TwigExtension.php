<?php

namespace SiteBundle\Twig;

class TwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('etatAdmission', array($this, 'EtatAdmissionFilter')),
        );
    }

    public function EtatAdmissionFilter($etat)
    {
        if ($etat == '0')
            return 'A valider';
        if ($etat == '1')
            return 'Entretien en cours';
        if ($etat == '2')
            return 'Admis';
        return 'A valider';
    }

    public function getName()
    {
        return 'app_extension';
    }
}