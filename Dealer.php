<?php

class Dealer extends Player
{
    public $hand;
    public $score;

    public $maxDrawScore;

    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            $this->hand = $_SESSION['dealer']['hand'];
            $this->score = $_SESSION['dealer']['score'];
        }

        $this->maxDrawScore = rand(16, 18);
    }

    public function setSession()
    {
        $_SESSION['dealer']['hand'] = $this->hand;
        $_SESSION['dealer']['score'] = $this->score;
    }

    public function setDrawMessage($card, $cardNum)
    {
        if (empty($_SESSION['dealer']['hand'][0])) {
            $_SESSION['message'][] = 'ディーラーのカードは' . $card['suit'] . 'の' . $cardNum . 'です。';

            return;
        } elseif (empty($_SESSION['dealer']['hand'][1])) {
            $_SESSION['message'][] = 'ディーラーの2枚目は分かりません。';
            return;
        }
        
        $_SESSION['message'][] = 'ディーラーがカードを引きました。';
    }

    public function choiceAction()
    {
        if ($this->score < $this->maxDrawScore) {
            while ($this->score < $this->maxDrawScore) {
                $this->draw();
            }
        }
    }
}
