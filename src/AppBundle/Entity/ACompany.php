<?php

/*
 * Nexxus Stock Keeping (online voorraad beheer software)
 * Copyright (C) 2018 Copiatek Scan & Computer Solution BV
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see licenses.
 *
 * Copiatek � info@copiatek.nl � Postbus 547 2501 CM Den Haag
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Location;

/**
 * Company
 *
 * @ORM\Table(name="acompany")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"c" = "Customer", "s" = "Supplier"})
 */
abstract class ACompany
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="kvk_nr", type="integer", nullable=true)
     */
    protected $kvkNr;

    /**
     * @var string
     *
     * @ORM\Column(name="representative", type="string", length=255, nullable=true)
     */
    protected $representative;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetExtra;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetExtra2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zip2;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location", inversedBy="companies")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ACompany
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set kvkNr
     *
     * @param integer $kvkNr
     *
     * @return ACompany
     */
    public function setKvkNr($kvkNr)
    {
        $this->kvkNr = $kvkNr;

        return $this;
    }

    /**
     * Get kvkNr
     *
     * @return int
     */
    public function getKvkNr()
    {
        return $this->kvkNr;
    }

    /**
     * Set representative
     *
     * @param string $representative
     *
     * @return ACompany
     */
    public function setRepresentative($representative)
    {
        $this->representative = $representative;

        return $this;
    }

    /**
     * Get representative
     *
     * @return string
     */
    public function getRepresentative()
    {
        return $this->representative;
    }

    /**
     * Set Email
     *
     * @param string $email
     *
     * @return ACompany
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $street
     *
     * @return Acompany
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreetExtra($streetExtra)
    {
        $this->streetExtra = $streetExtra;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetExtra()
    {
        return $this->streetExtra;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }
    /**
     * @param string $street2
     */
    public function setStreet2($street2)
    {
        $this->street1 = $street2;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * @param string $streetExtra2
     */
    public function setStreetExtra2($streetExtra2)
    {
        $this->streetExtra2 = $streetExtra2;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetExtra2()
    {
        return $this->streetExtra2;
    }

    /**
     * @param string $city2
     */
    public function setCity2($city2)
    {
        $this->city2 = $city2;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity2()
    {
        return $this->city2;
    }

    /**
     * @param string $country2
     */
    public function setCountry2($country2)
    {
        $this->country2 = $country2;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry2()
    {
        return $this->country2;
    }

    /**
     * @param string $state2
     */
    public function setState2($state2)
    {
        $this->state2 = $state2;

        return $this;
    }

    /**
     * @return string
     */
    public function getState2()
    {
        return $this->state2;
    }

    /**
     * @param string $zip2
     */
    public function setZip2($zip2)
    {
        $this->zip2 = $zip2;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip2()
    {
        return $this->zip2;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone2
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }


    /**
     * Set location
     *
     * @param Location $location
     *
     * @return ACompany
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string for use in views tooltips
     */
    public function getAddressString() {
        $address = $this->street . "<br />" .
            $this->zip . " " . $this->city;
            
        if ($this->location)    
        $address .= "<br />Your location: " . $this->location->getName();

        return $address;
    }
}

