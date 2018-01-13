<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Products extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=50, nullable=true)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(column="pwd", type="string", length=50, nullable=true)
     */
    protected $pwd;

    /**
     *
     * @var string
     * @Column(column="email", type="string", length=50, nullable=true)
     */
    protected $email;

    /**
     *
     * @var string
     * @Column(column="img", type="string", length=50, nullable=true)
     */
    protected $img;

    /**
     *
     * @var string
     * @Column(column="time", type="string", length=50, nullable=true)
     */
    protected $time;

    /**
     *
     * @var integer
     * @Column(column="sex", type="integer", length=1, nullable=true)
     */
    protected $sex;

    /**
     *
     * @var string
     * @Column(column="address", type="string", length=50, nullable=true)
     */
    protected $address;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field pwd
     *
     * @param string $pwd
     * @return $this
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field img
     *
     * @param string $img
     * @return $this
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Method to set the value of field time
     *
     * @param string $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Method to set the value of field sex
     *
     * @param integer $sex
     * @return $this
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Method to set the value of field address
     *
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field pwd
     *
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Returns the value of field time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Returns the value of field sex
     *
     * @return integer
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Returns the value of field address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("products");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'products';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products[]|Products|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
