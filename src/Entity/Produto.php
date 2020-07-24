<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProdutoRepository::class)
 */
class Produto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Undocumented variable
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Campo nome não pode ser vazio")
     */
    private $nome;

    /**
     * Undocumented variable
     *
     * @var float
     * 
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank(message="Campo preço não pode ser vazio")
     */
    private $preco;

    /**
     * Undocumented variable
     *
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Campo descrição não pode ser vazio")
     */
    private $descricao;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id) {  
        $this->id = $id; 
    } 

    public function getNome() { 
        return $this->nome; 
    } 

    public function setNome($nome) {  
       $this->nome = $nome; 
    } 

	public function getPreco() { 
 		return $this->preco; 
	} 

	public function setPreco($preco) {  
		$this->preco = $preco; 
    }

	public function getDescricao() { 
 		return $this->descricao; 
	} 

	public function setDescricao($descricao) {  
		$this->descricao = $descricao; 
	} 
}
