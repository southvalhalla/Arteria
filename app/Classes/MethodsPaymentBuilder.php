<?php

namespace App\Classes;

use  App\Classes\MethodsPayment;

class MethodsPaymentBuilder
{
    private $type;
    private $number_account;
    private $bank;
    private $name;
    private $lastName;
    private $expirate_date;
    private $security_cod;
    private $card_type;

    public function withType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function withNumberAccount($number_account)
    {
        $this->number_account = $number_account;
        return $this;
    }

    public function withBank($bank)
    {
        $this->bank = $bank;
        return $this;
    }

    public function withName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function withLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function withExpirateDate($expirate_date)
    {
        $this->expirate_date = $expirate_date;
        return $this;
    }

    public function withSecurityCod($security_cod)
    {
        $this->security_cod = $security_cod;
        return $this;
    }

    public function withCardType($card_type)
    {
        $this->card_type = $card_type;
        return $this;
    }

    public function build()
    {
        $methodsPayment = new MethodsPayment();
        $methodsPayment->type = $this->type;
        $methodsPayment->number_account = $this->number_account;
        $methodsPayment->bank = $this->bank;
        $methodsPayment->name = $this->name;
        $methodsPayment->lastName = $this->lastName;
        $methodsPayment->expirate_date = $this->expirate_date;
        $methodsPayment->security_cod = $this->security_cod;
        $methodsPayment->card_type = $this->card_type;
        return $methodsPayment;
    }
}

