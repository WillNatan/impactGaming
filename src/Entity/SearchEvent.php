<?php 

namespace App\Entity;

use App\Entity\EventCategory;
use App\Entity\AvailableGames;

class SearchEvent
{
    /**
     * @var EventCategory
     */
    private $category;

    /**
     * @var string
     */
    private $price;

    /**
     * @var Platform
     */
    private $support;

    /**
     * @var AvailableGames
     */
    private $game;

    /**
     * @var Department
     */
    private $department;

    
    /**
     * Get the value of price
     *
     * @return  string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param   string  $price  
     *
     * @return  self
     */
    public function setPrice(string $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return  EventCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param   EventCategory  $category  
     *
     * @return  self
     */
    public function setCategory(EventCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of game
     *
     * @return  AvailableGames
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set the value of game
     *
     * @param   AvailableGames  $game  
     *
     * @return  self
     */
    public function setGame(AvailableGames $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get the value of support
     *
     * @return  Platform
     */ 
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set the value of support
     *
     * @param  Platform  $support
     *
     * @return  self
     */ 
    public function setSupport(Platform $support)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get the value of department
     *
     * @return  Department
     */ 
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set the value of department
     *
     * @param  Department  $department
     *
     * @return  self
     */ 
    public function setDepartment(Department $department)
    {
        $this->department = $department;

        return $this;
    }
}