<?php

// src/AppBundle/Form/Task.php
namespace AppBundle\Form;
use Symfony\Component\Validator\Constraints as Assert;

class ContactForm
{
    /**
     * @Assert\NotBlank(message="Vul een naam in")
     */
    protected $name;

    /**
     * @Assert\NotBlank(message="Vul een e-mailadres in")
     * @Assert\Email(
     *     message = "Het e-mailadres '{{ value }}' is geen geldig e-mailadres",
     *     checkMX = true
     * )
     */
    protected $email;

    /**
     * @Assert\NotBlank(message="Vul een telefoonnummer in")
     */
    protected $phoneNumber;

    /**
     * @Assert\NotBlank(message="Vul een plaatsnaam in")
     */
    protected $city;

    /**
     * @Assert\NotBlank(message="Vul een onderwerp in")
     */
    protected $subject;

    /**
     * @Assert\NotBlank(message="Vul een bericht in")
     */
    protected $message;

    /**
     * @Assert\NotBlank(message="Vink deze checkbox aan als u een bericht wilt verzenden")
     */
    protected $checkbox;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getCheckbox()
    {
        return $this->checkbox;
    }

    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;
    }
}