<?php

namespace AppBundle\Entity;

class Task
{
    protected $task;
    protected $dueDate;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var string
     */
    protected $path;

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
}