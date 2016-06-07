<?php

namespace SiteBundle\Twig;

class TwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('etatAdmission', array($this, 'EtatAdmissionFilter')),
            new \Twig_SimpleFilter('etatEntretien', array($this, 'EtatEntretienFilter')),
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
        if ($etat == '3')
            return 'Refu';
        return 'A valider';
    }

    public function EtatEntretienFilter($etat)
    {
        if ($etat == '0')
            return 'En attente de passage';
        if ($etat == '1')
            return 'Refu';
        if ($etat == '2')
            return 'Admis';
        return 'A valider';
    }

    public function getName()
    {
        return 'app_extension';
    }
}