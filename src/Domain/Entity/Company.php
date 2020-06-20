<?php

namespace App\Entity;

use App\Core\Traits\TimeRecordsTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company")
 */
class Company
{
    
    use TimeRecordsTrait;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", nullable=false, length=4)
     * @Assert\NotBlank
     */
    protected $symbol;
    
    /**
     * @ORM\Column(type="date", nullable=false)
     * @Assert\NotBlank
     */
    protected $dateStart;
    
    /**
     * @ORM\Column(type="date", nullable=false)
     * @Assert\NotBlank
     */
    protected $dateEnd;
    
    /**
     * @ORM\Column(type="string", unique=true, length=75)
     * @Assert\NotBlank
     */
    protected $email;
    
    /**
     * @param array $array
     * @return Company|null
     */
    public function populate(array $array): ?self
    {
        
        if (!empty($array['id']) ) {
            $this->setId($array['id']);
        }
    
        if (!empty($array['symbol']) ) {
            $this->setSymbol($array['symbol']);
        }
    
        if (!empty($array['dateStart']) ) {
            $this->setDateStart($array['dateStart']);
        }
    
        if (!empty($array['dateEnd']) ) {
            $this->setDateStart($array['dateEnd']);
        }
    
        if (!empty($array['email']) ) {
            $this->setEmail($array['email']);
        }
        
        return $this;
    }
    
    /**
     * Account constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        return $this->populate($data);
    }
    
    /**
     * @return mixed
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * @param $id
     * @return Company
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
    
    /**
     * @param string $symbol
     * @return Company
     */
    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }
    
    /**
     * @param string $dateStart
     * @return Company
     */
    public function setDateStart(string $dateStart): self
    {
        $this->dateStart = $dateStart;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }
    
    /**
     * @param string $dateEnd
     * @return Company
     */
    public function setDateEnd(string $dateEnd): self
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     * @return Company
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
