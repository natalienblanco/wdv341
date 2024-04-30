<?php

class Recipe implements JsonSerializable
{
    private $recipeId;
    private $recipeName;
    private $recipeImage;
    private $servings;
    private $prepTime;
    private $cookTime;
    private $difficulty;
    private $ingredients;
    private $instructions;
    private $sourceLink;

    public function __construct($recipeId, $recipeName, $recipeImage, $servings, $prepTime, $cookTime, $difficulty, $ingredients, $instructions, $sourceLink)
    {
        $this->recipeId = $recipeId;
        $this->recipeName = $recipeName;
        $this->recipeImage = $recipeImage;
        $this->servings = $servings;
        $this->prepTime = $prepTime;
        $this->cookTime = $cookTime;
        $this->difficulty = $difficulty;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->sourceLink = $sourceLink;
    }

    // Setters

    function setRecipeId($inId)
    {
        $this->recipeId = $inId;
    }

    function setRecipeName($inName)
    {
        $this->recipeName = $inName;
    }

    function setRecipeImage($inImage)
    {
        $this->recipeImage = $inImage;
    }

    function setServings($inServings)
    {
        $this->servings = $inServings;
    }

    function setPrepTime($inPrepTime)
    {
        $this->prepTime = $inPrepTime;
    }

    function setCookTime($inCookTime)
    {
        $this->cookTime = $inCookTime;
    }

    function setDifficulty($inDifficulty)
    {
        $this->difficulty = $inDifficulty;
    }

    function setIngredients($inIngredients)
    {
        $this->ingredients = $inIngredients;
    }

    function setInstructions($inInstructions)
    {
        $this->instructions = $inInstructions;
    }

    function setSourceLink($inSourceLink)
    {
        $this->sourceLink = $inSourceLink;
    }


    // Getters

    public function getRecipeId()
    {
        return $this->recipeId;
    }

    public function getRecipeName()
    {
        return $this->recipeName;
    }

    public function getRecipeImage()
    {
        return $this->recipeImage;
    }

    public function getServings()
    {
        return $this->servings;
    }

    public function getPrepTime()
    {
        return $this->prepTime;
    }

    public function getCookTime()
    {
        return $this->cookTime;
    }

    public function getDifficulty()
    {
        return $this->difficulty;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function getInstructions()
    {
        return $this->instructions;
    }

    public function getSourceLink()
    {
        return $this->sourceLink;
    }

    // Implement the jsonSerialize method
    #[\ReturnTypeWillChange] // temporarily suppress notice

    public function jsonSerialize()
    {
        return [
            'recipeId' => $this->getRecipeId(),
            'recipeName' => $this->getRecipeName(),
            'recipeImage' => $this->getRecipeImage(),
            'servings' => $this->getServings(),
            'prepTime' => $this->getPrepTime(),
            'cookTime' => $this->getCookTime(),
            'difficulty' => $this->getDifficulty(),
            'ingredients' => $this->getIngredients(),
            'instructions' => $this->getInstructions(),
            'sourceLink' => $this->getSourceLink()
        ];
    }
}
