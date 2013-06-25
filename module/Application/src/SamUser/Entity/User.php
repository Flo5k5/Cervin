<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SamUser\Entity;

use DataTable\Model\ModelAbstract;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Doctrine\ORM\EntityRepository;

/**
 * An example of how to implement a role aware user entity.
 *
 * @Gedmo\Mapping\Annotation\Loggable
 * @ORM\Entity(repositoryClass="SamUser\Entity\UserRepository")
 * @ORM\Table(name="mbo_users")
 * 
 * @author Tom Oram <tom@scl.co.uk>
 */
class User extends ModelAbstract implements UserInterface, ProviderInterface
{
	protected $inputFilter;
	
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, length=255)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var int
     */
    protected $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="SamUser\Entity\Role")
     * @ORM\JoinTable(name="mbo_users_roles",
     * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToOne(targetEntity="SamUser\Entity\Role")
     **/
    protected $attenteRole;

    /**
     * @ORM\OneToMany(targetEntity="Collection\Entity\Element", mappedBy="utilisateur", cascade={"detach"})
     */
    protected $elements_chantier;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\Scene", mappedBy="utilisateur", cascade={"detach"})
     */
    protected $scenes_chantier;
    
    /**
     * @ORM\OneToMany(targetEntity="Parcours\Entity\SousParcours", mappedBy="utilisateur", cascade={"detach"})
     */
    protected $sous_parcours_chantier;
    
    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
    	return $this->$property;
    }
    
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
    	$this->$property = $value;
    }
    
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
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }


    /**
     * Get attenteRole.
     *
     * @return array
     */
    public function getAttenteRole()
    {
        return $this->attenteRole;
    }

    /**
     *
     * @param Role $role
     *
     * @return void
     */
    public function setAttenteRole($attenteRole)
    {
        $this->attenteRole = $attenteRole;
    }

    public function removeRoles(Array $elements)
    {
        foreach ($elements as $item) {
            $this->roles->removeElement($item);
        }
    }
    
    public function getInputFilter()
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    		$factory = new InputFactory();
    		 
    		$inputFilter->add($factory->createInput(array(
    			'name' => 'id',
    			'required' => true,
    			'filters' => array(array('name' => 'Int')),
    		)));
    		 
    		$inputFilter->add($factory->createInput(array(
    			'name' => 'username',
    			'required' => true,
    			'filters' => array(
    				array('name' => 'StripTags'),
    				array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    				array(
    					'name' => 'StringLength',
    					'options' => array(
    						'encoding' => 'UTF-8',
    						'min' => 1,
    						'max' => 200,
    					),
    				),
    			),
    		)));
    		 
    		$inputFilter->add($factory->createInput(array(
    			'name' => 'displayName',
    			'required' => true,
    			'filters' => array(
    				array('name' => 'StripTags'),
    				array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    				array(
    					'name' => 'StringLength',
    					'options' => array(
    						'encoding' => 'UTF-8',
    						'min' => 1,
    						'max' => 200,
    					),
    				),
    			),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    			'name' => 'email',
    			'required' => true,
    			'attributes' => array(
    				'type' => 'email'
    			),
    		)));
    		
    		$this->inputFilter = $inputFilter;
    
    	}
    	return $this->inputFilter;
    }
}

/**
 * Repository d'un utilisateur
 */
class UserRepository extends EntityRepository
{

    public function countAttenteRole()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('COUNT(u.attenteRole) AS NBattenteRole')

               ->from('SamUser\Entity\User','u')
               ;

        return $query->getQuery()->getSingleScalarResult();
    }
    
    /**
     * Génère un mot de passe aléatoire
     * 
     * Génère un mot de passe aléatoire composé de caractères alphanumériques
     * avec une longueur par défaut de 8 caractères.
     * Crédit : http://stackoverflow.com/questions/6101956/generating-a-random-password-in-php/6101976#6101976
     * 
     * @param int $length Longueur du mot de passe (défaut : 8)
     *  
     * @return string 
     */
    public function generateRandomPassword( $length = 8 ){
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		$str   = '';
		$max   = strlen($chars) - 1;
		
		for ($i=0; $i < $length; $i++)
			$str .= $chars[rand(0, $max)];
		
		return $str;
    }

}