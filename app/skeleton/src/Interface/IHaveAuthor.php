<?php

namespace App\Interface;

use App\Entity\User;

interface IHaveAuthor
{
    public function setAuthor(?User $author) : self;
    public function getAuthor() : ?User;

}
