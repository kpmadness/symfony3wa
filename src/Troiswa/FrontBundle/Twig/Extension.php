<?php


namespace Troiswa\FrontBundle\Twig;

class Extension extends \Twig_Extension
{

    public function getFilters()
    {
        return
            [
                'price' => new \Twig_Filter_Method($this, 'priceFilter'),
                'trunk'=> new \Twig_Filter_Method($this,'trunkFilter'),
            ];
        //Nom du filter => $this : objet extension avec les informations de la donnée à filter
        //								 priceFilter est la méthode à executer
    }

    public function priceFilter($number, $decimal = 2, $separatorDecimal = ',',
                                $separatorMille = " ")
    {
        $price = number_format($number, $decimal, $separatorDecimal, $separatorMille);
        return $price." €";
    }

    public function trunkFilter($texte,$nbr = 50)
    {

        return (strlen($texte) > $nbr ? substr(substr($texte,0,$nbr),0,strrpos(substr($texte,0,$nbr)," "))." ..." : $texte);

    }

    public function getFunctions()
    {
        return
            [
                'age' => new \Twig_Function_Method($this, 'ageFunction')
            ];
    }

    public function ageFunction($date)
    {
        $now = new \DateTime('now');
        $diff = $date->diff($now);
        return $diff->format('%y'). 'ans';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'troiswa_front_twig_extension';
    }
}