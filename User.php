<?php

class User extends Player
{
    public $hand;
    public $score;

    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            $this->hand = $_SESSION['user']['hand'];
            $this->score = $_SESSION['user']['score'];
        }
    }

    public function setSession()
    {
        $_SESSION['user']['hand'] = $this->hand;
        $_SESSION['user']['score'] = $this->score;
    }

    public function setDrawMessage($card, $cardNum)
    {
        $_SESSION['message'][] = 'あなたのカードは' . $card['suit'] . 'の' . $cardNum . 'です。';
    }
}
