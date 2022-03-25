<?php

namespace App\Interfaces;

interface SessionControl {
    public function SessionConfirm(String $GetOrPost, String $user);
}