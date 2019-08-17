<?php


namespace App\Http\Models;


class Task
{
    private $title;
    private $description;
    private $dueDate;
    private $status;

    /**
     * Task constructor.
     * @param $title
     * @param $description
     * @param $dueDate
     * @param $status
     */
    public function __construct($title, $description, $dueDate, $status)
    {
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
