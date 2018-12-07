<?php

namespace YZ\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="YZ\EcommerceBundle\Repository\CommandeRepository")
 */
class Commande
{

  public function __construct(){
    $this->dateCommande = new \DateTime;
  }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     */
    private $reference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCommande", type="datetime")
     */
    private $dateCommande;

    /**
   * @ORM\ManyToOne(targetEntity="YZ\UserBundle\Entity\User", inversedBy="commandes")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;

    /**
     * @var array
     *
     * @ORM\Column(name="products", type="array")
     */
    private $products;
    /**
     * @var array
     *
     * @ORM\Column(name="qteProduct", type="array")
     */
    private $qteProduct;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var bool
     *
     * @ORM\Column(name="validation", type="boolean")
     */
    private $validation;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference.
     *
     * @param string $reference
     *
     * @return Commande
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set dateCommande.
     *
     * @param \DateTime $dateCommande
     *
     * @return Commande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * Get dateCommande.
     *
     * @return \DateTime
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }


    /**
     * Set products.
     *
     * @param array $products
     *
     * @return Commande
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products.
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set validation.
     *
     * @param bool $validation
     *
     * @return Commande
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation.
     *
     * @return bool
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set user.
     *
     * @param \YZ\UserBundle\Entity\User $user
     *
     * @return Commande
     */
    public function setUser(\YZ\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \YZ\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set amount.
     *
     * @param int $amount
     *
     * @return Commande
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set qteProduct.
     *
     * @param array $qteProduct
     *
     * @return Commande
     */
    public function setQteProduct($qteProduct)
    {
        $this->qteProduct = $qteProduct;

        return $this;
    }

    /**
     * Get qteProduct.
     *
     * @return array
     */
    public function getQteProduct()
    {
        return $this->qteProduct;
    }
}
